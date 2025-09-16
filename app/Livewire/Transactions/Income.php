<?php

namespace App\Livewire\Transactions;

use App\Models\Account;
use Livewire\Component;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use Illuminate\Support\Facades\DB;

class Income extends Component
{
    public $date;
    public $reference;
    public $description;
    public $amount;
    public $cash_account_id;
    public $income_account_id;

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate([
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:1',
            'cash_account_id' => 'required|exists:accounts,id',
            'income_account_id' => 'required|exists:accounts,id',
        ]);

        DB::transaction(function () {
            // generate reference number automatic 
            $lastEntry = JournalEntry::orderBy('id', 'desc')->first();

            if ($lastEntry && preg_match('/TRX-(\d+)/', $lastEntry->reference, $matches)) {
                $number = (int)$matches[1] + 1;
            } else {
                $number = 1;
            }

            $this->reference = 'TRX-' . str_pad($number, 4, '0', STR_PAD_LEFT);

            $entry = JournalEntry::create([
                'reference' => $this->reference,
                'description' => $this->description,
                'date' => $this->date,
            ]);

            // Debit kas
            JournalEntryLine::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $this->cash_account_id,
                'debit' => $this->amount,
                'credit' => 0,
                'note' => 'Penerimaan kas',
            ]);

            // Kredit pendapatan
            JournalEntryLine::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $this->income_account_id,
                'debit' => 0,
                'credit' => $this->amount,
                'note' => 'Pendapatan',
            ]);
        });

        session()->flash('success', 'Income transaction recorded successfully!');
        $this->reset(['reference', 'description', 'amount', 'cash_account_id', 'income_account_id']);
    }
    public function render()
    {
        return view('livewire.transactions.income', [
            'cashAccounts' => Account::where('type', 'asset')->get(),
            'incomeAccounts' => Account::where('type', 'revenue')->get(),
        ]);
    }
}

<?php

namespace App\Livewire\Transactions;

use App\Models\Account;
use Livewire\Component;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use Illuminate\Support\Facades\DB;

class Expense extends Component
{
    public $date, $description, $amount, $cash_account_id, $expense_account_id, $reference;
    public $cashAccounts = [];
    public $expenseAccounts = [];

    public function mount()
    {
        $this->date = now()->format('Y-m-d');

        // Filter akun kas dan akun pengeluaran
        $this->cashAccounts = Account::where('type', 'asset')->get();
        $this->expenseAccounts = Account::where('type', 'expense')->get();
    }

    public function save()
    {
        $this->validate([
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:1',
            'cash_account_id' => 'required|exists:accounts,id',
            'expense_account_id' => 'required|exists:accounts,id',
        ]);

        DB::transaction(function () {
            // Generate nomor referensi
            $last = JournalEntry::where('reference', 'like', 'TRX-%')->latest('id')->first();
            $number = $last && preg_match('/TRX-(\d+)/', $last->reference, $m)
                ? ((int) $m[1] + 1)
                : 1;
            $this->reference = 'TRX-' . str_pad($number, 4, '0', STR_PAD_LEFT);

            $entry = JournalEntry::create([
                'reference' => $this->reference,
                'description' => $this->description,
                'date' => $this->date,
            ]);

            // Debit expense
            JournalEntryLine::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $this->expense_account_id,
                'debit' => $this->amount,
                'credit' => 0,
                'note' => 'Pengeluaran',
            ]);

            // Credit kas
            JournalEntryLine::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $this->cash_account_id,
                'debit' => 0,
                'credit' => $this->amount,
                'note' => 'Pengurangan kas',
            ]);
        });

        session()->flash('success', 'Expense transaction recorded successfully!');

        $this->reset(['description', 'amount', 'cash_account_id', 'expense_account_id']);
        $this->date = now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.transactions.expense');
    }
}

<?php

namespace App\Livewire\Reports;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ProfitLoss extends Component
{
    public $startDate;
    public $endDate;

    public $revenues;
    public $expenses;
    public $totalRevenue = 0;
    public $totalExpense = 0;
    public $netProfit = 0;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function generate()
    {
        // Revenue
        $this->revenues = DB::table('journal_entry_lines')
            ->join('accounts', 'accounts.id', '=', 'journal_entry_lines.account_id')
            ->join('journal_entries', 'journal_entries.id', '=', 'journal_entry_lines.journal_entry_id')
            ->where('accounts.type', 'revenue')
            ->whereBetween('journal_entries.date', [$this->startDate, $this->endDate])
            ->select(
                'accounts.name',
                DB::raw('SUM(journal_entry_lines.credit - journal_entry_lines.debit) as amount')
            )
            ->groupBy('accounts.name')
            ->get();

        $this->totalRevenue = $this->revenues->sum('amount');

        // Expense
        $this->expenses = DB::table('journal_entry_lines')
            ->join('accounts', 'accounts.id', '=', 'journal_entry_lines.account_id')
            ->join('journal_entries', 'journal_entries.id', '=', 'journal_entry_lines.journal_entry_id')
            ->where('accounts.type', 'expense')
            ->whereBetween('journal_entries.date', [$this->startDate, $this->endDate])
            ->select(
                'accounts.name',
                DB::raw('SUM(journal_entry_lines.debit - journal_entry_lines.credit) as amount')
            )
            ->groupBy('accounts.name')
            ->get();

        $this->totalExpense = $this->expenses->sum('amount');

        // Net Profit
        $this->netProfit = $this->totalRevenue - $this->totalExpense;
    }

    public function render()
    {
        return view('livewire.reports.profit-loss');
    }
}

<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public function render()
    {
        $datas['count_accounts'] = DB::table('accounts')->count();

        $datas['totalIncome'] = DB::table('journal_entry_lines')
            ->join('accounts', 'journal_entry_lines.account_id', '=', 'accounts.id')
            ->where('accounts.type', 'revenue')
            ->sum('journal_entry_lines.credit');

        $datas['totalExpense'] = DB::table('journal_entry_lines')
            ->join('accounts', 'journal_entry_lines.account_id', '=', 'accounts.id')
            ->where('accounts.type', 'expense')
            ->sum('journal_entry_lines.debit');

        $monthlyIncome = DB::table('journal_entry_lines')
            ->join('journal_entries', 'journal_entry_lines.journal_entry_id', '=', 'journal_entries.id')
            ->join('accounts', 'journal_entry_lines.account_id', '=', 'accounts.id')
            ->where('accounts.type', 'revenue')
            ->selectRaw('
        DATE_FORMAT(journal_entries.date, "%Y-%m") as month,
        SUM(journal_entry_lines.credit) as total_income
    ')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $datas['labels_grafik'] = $monthlyIncome->pluck('month');
        $datas['data_grafik'] = $monthlyIncome->pluck('total_income');
        return view('livewire.dashboards.index', ['datas' => $datas]);
    }
}

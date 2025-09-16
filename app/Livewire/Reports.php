<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\JournalEntryLine;

class Reports extends Component
{
    public $startDate;
    public $endDate;

    public $report = [];

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function generate()
    {
        $this->report = JournalEntryLine::with('account')
            ->whereHas('journalEntry', function ($query) {
                $query->whereBetween('date', [$this->startDate, $this->endDate]);
            })
            ->get()
            ->groupBy('account.type')
            ->map(function ($group) {
                return [
                    'debit' => $group->sum('debit'),
                    'credit' => $group->sum('credit'),
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.reports');
    }
}

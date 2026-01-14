<div>
    <div class="card">
        <div class="card-header">
            <h4>Profit & Loss Report</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Start Date</label>
                    <input type="date" wire:model="startDate" class="form-control">
                </div>

                <div class="col-md-4">
                    <label>End Date</label>
                    <input type="date" wire:model="endDate" class="form-control">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button wire:click="generate" class="btn btn-primary">
                        Generate Report
                    </button>
                </div>
            </div>
        </div>
        @if($revenues || $expenses)
        <!-- Revenue -->
        <div class="card mb-3">
            <div class="card-header fw-bold">Revenue</div>
            <table class="table mb-0">
                @foreach ($revenues as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td class="text-end">{{ number_format($row->amount, 2) }}</td>
                </tr>
                @endforeach
                <tr class="fw-bold table-light">
                    <td>Total Revenue</td>
                    <td class="text-end">{{ number_format($totalRevenue, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Expense -->
        <div class="card mb-3">
            <div class="card-header fw-bold">Expense</div>
            <table class="table mb-0">
                @foreach ($expenses as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td class="text-end">{{ number_format($row->amount, 2) }}</td>
                </tr>
                @endforeach
                <tr class="fw-bold table-light">
                    <td>Total Expense</td>
                    <td class="text-end">{{ number_format($totalExpense, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Net Profit -->
        <div class="card">
            <div class="card-body d-flex justify-content-between fw-bold">
                <span>Net Profit / Loss</span>
                <span class="{{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($netProfit, 2) }}
                </span>
            </div>
        </div>
        @endif
    </div>
</div>
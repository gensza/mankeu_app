<div>
    <div class="card">
        <div class="card-header">
            <h4>Balance Sheet</h4>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="generate" class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Start Date</label>
                    <input type="date" class="form-control" wire:model="startDate">
                </div>
                <div class="col-md-4">
                    <label class="form-label">End Date</label>
                    <input type="date" class="form-control" wire:model="endDate">
                </div>
                <div class="col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary btn-sm">Generate</button>
                </div>
            </form>

            @if (!empty($report))
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Account Type</th>
                            <th>Total Debit</th>
                            <th>Total Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report as $type => $totals)
                            <tr>
                                <td>{{ ucfirst($type) }}</td>
                                <td>{{ number_format($totals['debit'], 2) }}</td>
                                <td>{{ number_format($totals['credit'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No report data available.</p>
            @endif
        </div>
    </div>
</div>

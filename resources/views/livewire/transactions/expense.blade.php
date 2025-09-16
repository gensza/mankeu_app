<div>
    <div class="card p-4 col-xl-6 col-lg-8 col-md-10 col-sm-12">
        <h5 class="mb-3">Record Income Transaction</h5>
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form wire:submit.prevent="save">
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" wire:model="date" id="date" class="form-control">
                @error('date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" wire:model="description" id="description" class="form-control">
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="expense_account_id" class="form-label">Expense Account</label>
                <select wire:model="expense_account_id" id="expense_account_id" class="form-select">
                    <option value="">-- Select Expense Account --</option>
                    @foreach ($expenseAccounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                    @endforeach
                </select>
                @error('expense_account_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cash_account_id" class="form-label">Cash/Bank Account</label>
                <select wire:model="cash_account_id" id="cash_account_id" class="form-select">
                    <option value="">-- Select Cash Account --</option>
                    @foreach ($cashAccounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                    @endforeach
                </select>
                @error('cash_account_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" wire:model="amount" id="amount" class="form-control" step="0.01">
                @error('amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-danger btn-sm">Submit Expense</button>
        </form>
    </div>
</div>

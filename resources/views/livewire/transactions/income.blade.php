<div>
    <div class="card p-4 col-xl-6 col-lg-8 col-md-10 col-sm-12">
        <h5 class="mb-3">Record Income Transaction</h5>

        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form wire:submit.prevent="save">
            <div class="mb-3">
                <label for="date">Date</label>
                <input wire:model="date" type="date" class="form-control" id="date">
                @error('date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description">Description</label>
                <textarea wire:model="description" class="form-control" id="description"></textarea>
            </div>

            <div class="mb-3">
                <label for="amount">Amount</label>
                <input wire:model="amount" type="number" class="form-control" id="amount">
                @error('amount')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cash_account_id">Cash/Bank Account</label>
                <select wire:model="cash_account_id" class="form-select" id="cash_account_id">
                    <option value="">-- Select --</option>
                    @foreach ($cashAccounts as $account)
                        <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </select>
                @error('cash_account_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="income_account_id">Income Account</label>
                <select wire:model="income_account_id" class="form-select" id="income_account_id">
                    <option value="">-- Select --</option>
                    @foreach ($incomeAccounts as $account)
                        <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </select>
                @error('income_account_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-sm">Save Transaction</button>
        </form>
    </div>

</div>

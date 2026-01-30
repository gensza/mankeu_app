<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Users</div>
            </div>
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                    <input type="text" class="form-control border rounded w-50" placeholder="Search title..."
                        wire:model.live.debounce.300ms="search">

                    <select wire:model.live.debounce.300ms="perPage" class="form-select border rounded w-25">
                        <option value="5">5 / page</option>
                        <option value="10">10 / page</option>
                        <option value="25">25 / page</option>
                    </select>
                </div>
                <table class="table table-bordered table-striped" id="basic-datatables">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th wire:click="sortBy('name')" style="cursor: pointer">
                                Name
                                @if ($sortField == 'name')
                                @if ($sortDirection == 'asc')
                                ↑
                                @else
                                ↓
                                @endif
                                @endif
                            </th>
                            <th>Email</th>
                            <th>created_at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $ac)
                        <tr>
                            <td>{{ $loop->iteration + $posts->firstItem() - 1 }}</td>
                            <td>{{ $ac->name }}</td>
                            <td>{{ $ac->email }}</td>
                            <td>{{ $ac->created_at }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No data found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
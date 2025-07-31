<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Accounts</div>
            </div>
            <div class="card-body">
                {{-- <div>
                    <button wire:click="openAddModal" class="btn btn-success btn-sm">Add</button>
                </div> --}}
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
                            <th wire:click="sortBy('code')" style="cursor: pointer">
                                Code
                                @if ($sortField == 'code')
                                    @if ($sortDirection == 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </th>
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
                            <th>Type</th>
                            <th>Parent</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $ac)
                            <tr>
                                <td>{{ $loop->iteration + $posts->firstItem() - 1 }}</td>
                                <td>{{ $ac->code }}</td>
                                <td>{{ $ac->name }}</td>
                                <td>{{ ucfirst($ac->type) }}</td>
                                <td>{{ $ac->parent?->name }}</td>
                                {{-- <td>
                                    <button wire:click="openEditModal({{ $ac->id }})"
                                        class="btn btn-sm btn-primary">
                                        Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger"
                                        wire:click="confirmDelete({{ $ac->id }})">
                                        Delete
                                    </button>
                                </td> --}}
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

    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Account</h5>
                    <button type="button" wire:click="hideAddModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Code</label>
                        <input type="text" class="form-control border rounded" placeholder=""
                            wire:model.defer="code">
                        @error('kode_gejala')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control border rounded" placeholder=""
                            wire:model.defer="name">
                        @error('nama_penyakit')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Type</label>
                        <select class="form-control" wire:model.defer="type">
                            <option value="">-- Select Type --</option>
                            @foreach ($types as $t)
                                <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Parent Account</label>
                        <select class="form-control" wire:model.defer="parent_id">
                            <option value="">-- None --</option>
                            @foreach ($accounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }} ({{ $acc->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="hideAddModal">Cancel</button>
                    <button type="button" wire:click="save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('show-add-modal', () => {
        new bootstrap.Modal(document.getElementById('addModal')).show();
    });

    window.addEventListener('hide-add-modal', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
        modal.hide();
    });
</script>

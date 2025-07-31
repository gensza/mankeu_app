<?php

namespace App\Livewire\AccountManager;

use App\Models\Account;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';

    public $accounts;
    public $accountId;
    public $code;
    public $name;
    public $type;
    public $parent_id;

    public $types = ['asset', 'liability', 'equity', 'revenue', 'expense'];

    #[On('post-added')]
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;

        $this->resetPage();
    }

    public function mount()
    {
        $this->loadAccounts();
    }

    public function loadAccounts()
    {
        $this->accounts = Account::with('parent')->get();
    }

    public function openAddModal()
    {
        $this->dispatch('show-add-modal');
    }

    public function save()
    {
        $this->validate([
            'code' => 'required|unique:accounts,code,' . $this->accountId,
            'name' => 'required',
            'type' => 'required|in:asset,liability,equity,revenue,expense',
        ]);

        Account::updateOrCreate(
            ['id' => $this->accountId],
            [
                'code' => $this->code,
                'name' => $this->name,
                'type' => $this->type,
                'parent_id' => $this->parent_id,
            ]
        );

        $this->resetForm();
        $this->loadAccounts();
    }

    public function edit($id)
    {
        $account = Account::findOrFail($id);
        $this->accountId = $account->id;
        $this->code = $account->code;
        $this->name = $account->name;
        $this->type = $account->type;
        $this->parent_id = $account->parent_id;
    }

    public function delete($id)
    {
        Account::findOrFail($id)->delete();
        $this->loadAccounts();
    }

    public function resetForm()
    {
        $this->reset(['accountId', 'code', 'name', 'type', 'parent_id']);
    }

    public function render()
    {
        $posts = Account::with('parent')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.account-manager.index', ['posts' => $posts]);
    }
}

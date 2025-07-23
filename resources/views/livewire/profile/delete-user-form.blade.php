<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/login', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h4>Delete Account</h4>
        <p class="text-muted">Once your account is deleted, all of its resources and data will be permanently deleted.
            Before deleting your
            account, please download any data or information that you wish to retain.'</p>
    </header>

    <!-- Modal Trigger -->
    <button type="button" class="btn btn-danger px-4 py-2" data-bs-toggle="modal"
        data-bs-target="#confirmUserDeletionModal">
        Delete Account
    </button>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="confirmUserDeletionModal" tabindex="-1"
        aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form wire:submit.prevent="deleteUser">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                            {{ __('Are you sure you want to delete your account?') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="{{ __('Close') }}"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label sr-only">{{ __('Password') }}</label>
                            <input wire:model="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" id="password"
                                placeholder="{{ __('Password') }}" />
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit" class="btn btn-danger">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

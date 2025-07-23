<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: RouteServiceProvider::HOME);

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h4>Profile Information</h4>
        <p class="text-muted">Update your account's profile information and email address.</p>
    </header>

    <form wire:submit="updateProfileInformation">
        <div class="mt-4">
            <label for="name">Name</label>
            <input wire:model="name" id="name" name="name" type="text" class="form-control mt-1" required
                autofocus autocomplete="name" />
            @error('name')
                <div class="invalid-feedback d-block mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mt-4">
            <label for="email">Email</label>
            <input wire:model="email" id="email" name="email" type="email"
                class="form-control mt-1 block w-full" required autocomplete="username" />
            @error('email')
                <div class="invalid-feedback d-block mt-2">
                    {{ $message }}
                </div>
            @enderror

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="small mt-2 text-dark">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                            class="btn btn-link p-0 align-baseline text-decoration-underline text-secondary">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success small fw-medium">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex mt-4 gap-3">
            <button type="submit" class="btn btn-black btn-sm px-4 py-2">{{ __('SAVE') }}</button>

            <x-action-message class="py-1 text-success" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>

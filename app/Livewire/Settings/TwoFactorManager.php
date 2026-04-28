<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Livewire\Component;

class TwoFactorManager extends Component
{
    public string $code = '';
    public ?array $recoveryCodes = null;
    public ?string $qrCodeSvg = null;
    public bool $enabled = false;
    public bool $confirmed = false;

    public function mount(): void
    {
        $this->refreshState();
    }

    public function enable(EnableTwoFactorAuthentication $enable): void
    {
        $enable($this->currentUser());

        $this->refreshState();
        session()->flash('success', 'Two-factor authentication enabled. Confirm it with a valid code.');
    }

    public function confirm(ConfirmTwoFactorAuthentication $confirm): void
    {
        $this->validate([
            'code' => ['required', 'string'],
        ]);

        try {
            $confirm($this->currentUser(), $this->code);
        } catch (ValidationException $exception) {
            $this->addError('code', 'The authentication code is invalid.');
            return;
        }

        $this->code = '';
        $this->refreshState();
        session()->flash('success', 'Two-factor authentication confirmed successfully.');
    }

    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generate): void
    {
        $generate($this->currentUser());

        $this->refreshState();
        session()->flash('success', 'Recovery codes regenerated successfully.');
    }

    public function disable(DisableTwoFactorAuthentication $disable): void
    {
        $disable($this->currentUser());

        $this->code = '';
        $this->recoveryCodes = null;
        $this->qrCodeSvg = null;

        $this->refreshState();
        session()->flash('success', 'Two-factor authentication disabled successfully.');
    }

    private function refreshState(): void
    {
        $user = $this->currentUser()->fresh();

        $this->enabled = ! is_null($user->two_factor_secret);
        $this->confirmed = ! is_null($user->two_factor_confirmed_at);

        if (! $this->enabled) {
            $this->qrCodeSvg = null;
            $this->recoveryCodes = null;
            return;
        }

        $this->qrCodeSvg = $user->twoFactorQrCodeSvg();
        $this->recoveryCodes = $user->recoveryCodes();
    }

    private function currentUser(): User
    {
        /** @var User $user */
        $user = Auth::user();

        return $user;
    }

    public function render()
    {
        return view('livewire.settings.two-factor-manager');
    }
}

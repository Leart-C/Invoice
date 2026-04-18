<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;


class ApiTokenManager extends Component
{
    public string $tokenName = '';
    public ?string $plainTextToken = null;

    public function createToken():void
    {
        $this->validate([
            'tokenName' => 'required|string|max:255',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $token = $user->createToken($this->tokenName);

        $this->plainTextToken = $token->plainTextToken;
        $this->tokenName = '';

        session()->flash('success','API token created successfully');
    }

    public function revokeToken(int $tokenId):void
    {
        /** @var User $user */
        $user = Auth::user();

        $user->tokens()
            ->where('id',$tokenId)
            ->delete();

            session()->flash('success','API token revoked successfully');
    }

    public function render()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('livewire.settings.api-token-manager',[
            'tokens' => $user->tokens()->latest()->get(),
        ]);
    }
}
<?php

namespace App\Http\Livewire\UserManagement;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DataPolicyConfirmationComponent extends Component
{

    public function acceptPolicy(){

        auth()->user()->update(['declaration'=>true]);

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Policy accepted!',
            'text' => 'Welcome to MERP - The ultimate resource planner !',
        ]);

    }

    public function declinePolicy(){

        auth()->user()->update(['declaration'=>false]);

        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.user-management.data-policy-confirmation-component');
    }
}

<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfileComponent extends Component
{
    use WithFileUploads;

    public $title;

    public $surname;

    public $first_name;

    public $other_name;

    public $name;

    public $email;

    public $contact;

    public $avatar;

    public $avatarPath = '';

    public $current_password;

    public $password;

    public $password_confirmation;

    public $edit_id;

    public $no_edit = false;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'title' => 'required',
            'surname' => 'required',
            'first_name' => 'required',
            'email' => 'required|email:filter',
            'contact' => 'required',
            'avatar' => ['image', 'mimes:jpg,png', 'max:500'],
        ]);
    }

    public function mount()
    {
        $currentUser = User::where('id', auth()->user()->id)->first();
        $this->edit_id = $currentUser->id;
        $this->title = $currentUser->title;
        $this->surname = $currentUser->surname;
        $this->first_name = $currentUser->first_name;
        $this->other_name = $currentUser->other_name;
        $this->name = $currentUser->name;
        $this->contact = $currentUser->contact;
        $this->email = $currentUser->email;
    }

    public function updateUser()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:6'],
            'surname' => 'required',
            'first_name' => 'required',
            'email' => 'required|email:filter',
            'contact' => 'required',
        ]);
        $user = User::findOrFail(auth()->user()->id);
        if ($this->avatar != null) {
            $this->validate([
                'avatar' => ['image', 'mimes:jpg,png', 'max:500'],
            ]);

            $avatarName = date('YmdHis').$this->surname.'.'.$this->avatar->extension();

            // Resize the photo to a width and height 150 pixels using intervention lib
            $resizedPhoto = Image::make($this->avatar)->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            });

            $resizedPhoto->save(storage_path('app/public/photos/'.$avatarName));
            $this->avatarPath = 'photos/'.$avatarName;

            if (file_exists(storage_path('app/public/').$user->avatar)) {
                @unlink(storage_path('app/public/').$user->avatar);
            }
        } else {
            $this->avatarPath = $user->avatar;
        }

        $user->title = $this->title;
        $user->surname = $this->surname;
        $user->first_name = $this->first_name;
        $user->other_name = $this->other_name;
        $user->name = $this->first_name;
        $user->contact = $this->contact;
        $user->email = $this->email;
        $user->avatar = $this->avatarPath;
        $user->update();

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Account Information updated successfully!']);
    }

    public function changePassword()
    {
        $currentUser = User::findOrFail(auth()->user()->id);
        if (Hash::check($this->current_password, auth()->user()->password)) {
            if (Hash::check($this->password, Hash::make($this->current_password))) {
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'warning',
                    'message' => 'Password Failure!',
                    'text' => 'Oops! You can not use your current password as your new password!',
                ]);
            } else {
                $this->validate([
                    'password' => ['required',
                        Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(),
                        'confirmed', ],
                ]);
                $currentUser->update([
                    'password' => Hash::make($this->password),
                    'password_updated_at' => now(),
                ]);

                Auth::guard('web')->logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect('/');
            }
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Password Mismatch!',
                'text' => 'Oops! Your Current Password does not match our records!',
            ]);
        }
    }

    public function render()
    {
        $user = User::where('id', auth()->user()->id)->first();

        return view('livewire.user-management.user-profile-component', compact('user'))->layout('layouts.app');
    }
}

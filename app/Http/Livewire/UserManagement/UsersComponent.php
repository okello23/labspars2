<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use App\Models\Institution;
use App\Exports\UsersExport;
use App\Notifications\SendPasswordNotification;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UsersComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    //Filters

    public $from_date;

    public $to_date;

    public $user_status;

    public $userIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = true;

    //User Fields

    public $emp_id;
    public $title;

    public $surname;

    public $first_name;

    public $other_name;

    public $name;

    public $email;

    public $contact;

    public $is_active;

    public $password;

    public $signature;

    public $signaturePath;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $county_id;
    public $category;
    public $institution_id;
    public $department_id;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected $validationAttributes = [
        'is_active' => 'status',
    ];


    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'title' => 'required',
            'surname' => 'required',
            'first_name' => 'required',
            'email' => 'required|email:filter',
            'contact' => 'required',
            'is_active' => 'required',
            'category' => 'required',
        ]);
    }

    public function updatedTitle()
    {
        $this->password = GeneratorService::password();
    }

    public function storeUser()
    {
        $this->validate([
            'title' => 'required|string|max:6',
            'surname' => 'required',
            'first_name' => 'required',
            'email' => 'required|email:filter',
            'contact' => 'required',
            'is_active' => 'required|integer|max:3',
            'password' => ['required',
            'category' => 'required',
                Password::min(8)
                            ->mixedCase()
                            ->numbers()
                            ->symbols()
                            ->uncompromised(), ],
        ]);

        $user = new User();
        // $user->emp_id = $this->emp_id;
        $user->title = $this->title;
        $user->surname = $this->surname;
        $user->first_name = $this->first_name;
        $user->other_name = $this->other_name;
        $user->name = $this->first_name;
        $user->contact = $this->contact;
        $user->institution_id = $this->institution_id;
        $user->category = $this->category;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);

        if ($this->signature != null) {
            $this->validate([
                'signature' => ['image', 'mimes:jpg,png', 'max:100'],
            ]);

            $signatureName = date('YmdHis').$this->surname.'.'.$this->signature->extension();
            $this->signaturePath = $this->signature->storeAs('signatures', $signatureName, 'public');
        } else {
            $this->signaturePath = null;
        }

        $user->signature = $this->signature;
        $user->save();

        $greeting = 'Hello'.' '.$this->first_name.' '.$this->surname;
        $body = 'Your password is'.' '.$this->password;
        $actiontext = 'Click here to Login';
        $details = [
            'greeting' => $greeting,
            'body' => $body,
            'actiontext' => $actiontext,
            'actionurl' => url('/'),
        ];

        try {
            Notification::send($user, new SendPasswordNotification($details));
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'User created and password sent successfully']);
        } catch (\Exception $error) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Email not Sent!',
                'text' => 'Oops! Something went wrong and the password could not be sent to user email address',
            ]);
        }

        $this->resetInputs();
    }

    public function editdata($id)
    {
        $user = User::findOrFail($id);
        $this->edit_id = $user->id;
        // $this->emp_id = $user->emp_id;
        $this->title = $user->title;
        $this->surname = $user->surname;
        $this->first_name = $user->first_name;
        $this->other_name = $user->other_name;
        $this->name = $user->name;
        $this->contact = $user->contact;
        $this->email = $user->email;
        $this->category = $user->category;
        $this->institution_id = $user->institution_id;
        $this->department_id = $user->department_id;
        $this->is_active = $user->is_active;

        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function updateUser()
    {
        $this->validate([
            'title' => 'required|string|max:6',
            'surname' => 'required',
            'first_name' => 'required',
            'email' => 'required|email:filter',
            'contact' => 'required',
            'is_active' => 'required|integer|max:3',
            'category' => 'required',
        ]);

        $user = User::findOrFail($this->edit_id);

        // $user->emp_id = $this->emp_id;
        $user->title = $this->title;
        $user->surname = $this->surname;
        $user->category = $this->category;
        $user->institution_id = $this->institution_id;
        $user->first_name = $this->first_name;
        $user->other_name = $this->other_name;
        $user->name = $this->first_name;
        $user->contact = $this->contact;
        $user->email = $this->email;
        $user->is_active = $this->is_active;

        if ($this->signature != null) {
            $this->validate([
                'signature' => ['image', 'mimes:jpg,png', 'max:100'],
            ]);

            $signatureName = date('YmdHis').$this->surname.'.'.$this->signature->extension();
            $this->signaturePath = $this->signature->storeAs('signatures', $signatureName, 'public');

            if (file_exists(storage_path('app/public/').$user->signature)) {
                @unlink(storage_path('app/public/').$user->signature);
            }
        } else {
            $this->signaturePath = $user->signature;
        }
        $user->signature = $this->signaturePath;

        $user->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'User updated successfully!']);
    }

    public function resetInputs()
    {
        $this->reset(['edit_id', 'password','emp_id','title', 'surname', 'first_name', 'other_name','signature','email', 'contact','is_active']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->userIds) > 0) {
            return (new UsersExport($this->userIds))->download('Users_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Not Found!',
                'text' => 'Oops! No Users selected for export!',
            ]);
        }
    }

    public function filterUsers()
    {
        $users = User::search($this->search)
                    ->when($this->user_status != '', function ($query) {
                        $query->where('is_active', $this->user_status);
                    }, function ($query) {
                        return $query;
                    })
                    ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                        $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
                    }, function ($query) {
                        return $query;
                    });

        $this->userIds = $users->pluck('id')->toArray();

        return $users;
    }

    public function render()
    {

        $data['users'] = $this->filterUsers()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        $data['institutions'] = Institution::all();

        return view('livewire.user-management.users-component', $data)->layout('layouts.app');
    }
}

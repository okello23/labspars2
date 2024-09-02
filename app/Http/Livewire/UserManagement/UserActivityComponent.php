<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class UserActivityComponent extends Component
{
    public $causer = 0;

    public $event = '';

    public $subject = '';

    public $from_date = '';

    public $to_date = '';

    public $checkroute = false;

    public function mount()
    {
        $this->checkroute = Route::is('myactivity');
        if ($this->checkroute) {
            $this->causer = auth()->user()->id;
        }
    }

    public function filterLogs()
    {
        $logs = Activity::select('*')->whereNotNull('causer_id')->with('causer')
                    ->when($this->causer != 0, function ($query) {
                        $query->where('causer_id', $this->causer);
                    }, function ($query) {
                        return $query;
                    })
                    ->when($this->event != '', function ($query) {
                        $query->where('event', $this->event);
                    }, function ($query) {
                        return $query;
                    })
                    ->when($this->subject != '', function ($query) {
                        $query->where('log_name', $this->subject);
                    }, function ($query) {
                        return $query;
                    })
                    ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                        $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
                    }, function ($query) {
                        return $query;
                    })
                    ->latest()->get()->take(1000);

        return $logs;
    }

    public function cleanLogs()
    {
        try {
            Artisan::call('activitylog:clean');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Logs deleted successfully!']);
        } catch(Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Something went wrong! Logs could not be cleared!']);
        }
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function deleteConfirmation()
    {
        $this->dispatchBrowserEvent('delete-modal');
    }

    public function cancel()
    {
        $this->dispatchBrowserEvent('close-modal');
    }

    public function render()
    {
        $logs = $this->filterLogs();
        $log_names = Activity::select('log_name')->distinct()->get();
        $events = Activity::select('event')->distinct()->get();

        if ($this->checkroute) {
            $users = collect([]);
        } else {
            $users = User::where(['is_active' => 1])->get();
        }

        return view('livewire.user-management.user-activity-component', compact('logs', 'events', 'users', 'log_names'))->layout('layouts.app');
    }
}

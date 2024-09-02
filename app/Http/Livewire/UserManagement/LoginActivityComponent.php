<?php

namespace App\Http\Livewire\UserManagement;

use App\Exports\LoginActivityExport;
use App\Models\LoginRecord;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class LoginActivityComponent extends Component
{
    use WithPagination;

    //Filters
    public $description;

    public $platform;

    public $browser;

    public $from_date;

    public $to_date;

    public $loginRecordIds;

    public $descriptions_list;

    public $platforms_list;

    public $browsers_list;

    public $perPage = 100;

    public $filter = false;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $logs = DB::table('login_records')
            ->select('description', 'platform', 'browser')
            ->take(3000)
            ->get();

        $this->descriptions_list = array_unique($logs->pluck('description')->toArray());
        $this->platforms_list = array_unique($logs->pluck('platform')->toArray());
        $this->browsers_list = array_unique($logs->pluck('browser')->toArray());
        // $this->descriptions_list = array_unique(array_column($logs, 'description'));
        // $this->platforms_list = array_unique(array_column($logs, 'platform'));
        // $this->browsers_list = array_unique(array_column($logs, 'browser'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->loginRecordIds) > 0) {
            return (new LoginActivityExport($this->loginRecordIds))->download('Login_Records_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Not Found!',
                'text' => 'Oops! No Login Records selected for export!',
            ]);
        }
    }

    public function filterLogs()
    {
        $loginRecords = LoginRecord::search($this->search)
                    ->when($this->description != 0, function ($query) {
                        $query->where('description', $this->description);
                    }, function ($query) {
                        return $query;
                    })
                    ->when($this->platform != 0, function ($query) {
                        $query->where('platform', $this->platform);
                    }, function ($query) {
                        return $query;
                    })
                    ->when($this->browser != 0, function ($query) {
                        $query->where('browser', $this->browser);
                    }, function ($query) {
                        return $query;
                    })
                    ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                        $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
                    }, function ($query) {
                        return $query;
                    });

        $this->loginRecordIds = $loginRecords->pluck('id')->toArray();

        return $loginRecords;
    }

    public function render()
    {
        $logs = $this->filterLogs()
        ->orderBy($this->orderBy, ! $this->orderAsc ? 'desc' : 'asc')
        ->paginate($this->perPage);

        return view('livewire.user-management.login-activity-component', compact('logs'))->layout('layouts.app');
    }
}

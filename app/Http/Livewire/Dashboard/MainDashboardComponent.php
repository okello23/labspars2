<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;

class MainDashboardComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'value';

    public $orderAsc = 0;

    public $to;

    public $from;

    public $endDate;

    public $startDate;

    public $facilities;

    public $facility_id;

    public $districts;

    public $district_id;

    public $filter_options;

    public function mount()
    {

    }

    public function updatedTo()
    {
        $this->endDate = '';
    }

    public function export()
    {

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mainQuery($value = '')
    {
        return Dhis233bReport::search($this->search)
            ->when($this->from, function ($query) {
                $query->where('date_captured', '>', $this->from);
            })
            ->when($this->to, function ($query) {
                $query->where('date_captured', '<', $this->to);
            });
    }

    public function render()
    {

        return view('livewire.dashboard.main-dashboard-component');
    }
}

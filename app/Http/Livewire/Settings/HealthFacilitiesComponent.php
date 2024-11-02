<?php

namespace App\Http\Livewire\Settings;

use App\Models\District;
use App\Models\Facility\Facility;
use App\Models\Settings\HealthSubDistrict;
use Livewire\Component;
use Livewire\WithPagination;

class HealthFacilitiesComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $SubCountyIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'facilities.id';

    public $orderAsc = 0;

    public $name;

    public $level;

    public $district_id;

    public $sub_district_id;

    public $regions = [];

    public $region_id;

    public $region_name;

    public $ownership;

    public $sub_districts = [];

    public $totalMembers;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public function updatedDistrictId($id)
    {
        // code...
        $this->sub_districts = HealthSubDistrict::where('district_id', $id)->get();
        $district = District::with('region')->where('id', $id)->first();
        $this->region_name = $district->region->name;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function addEntry()
    {
        $this->createNew = true;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'region_id' => 'required',
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|unique:facilities',
            'level' => 'required',
            'ownership' => 'required',
            'sub_district_id' => 'required',

        ]);

        $facility = new Facility();
        $facility->name = $this->name;
        $facility->level = $this->level;
        $facility->ownership = $this->ownership;
        $facility->sub_district_id = $this->sub_district_id;
        $facility->created_by = \Auth::user()->id;
        $facility->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Health Facility added successfully!']);
    }

    public function editData(Facility $facility)
    {
        $this->edit_id = $facility->id;
        $this->name = $facility->name;
        $this->level = $facility->level;
        $this->sub_district_id = $facility->sub_district_id;
        $this->ownership = $facility->ownership;
        $this->code = $facility->code;
        $this->createNew = false;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
        $this->reset(['name', 'district_id', 'level', 'ownership', 'sub_district_id']);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:facilities,name,'.$this->edit_id.'',
            'level' => 'required',
            'ownership' => 'required',
            'sub_district_id' => 'required',
        ]);

        $facility = Facility::find($this->edit_id);
        $facility->name = $this->name;
        $facility->level = $this->level;
        $facility->ownership = $this->ownership;
        $facility->sub_district_id = $this->sub_district_id;
        $facility->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Health facility details updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->SubCountyIds) > 0) {
            // return (new countiesExport($this->SubCountyIds))->download('counties_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No counties selected for export!',
            ]);
        }
    }

    public function filtercounties()
    {
        $counties = SubCounty::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->SubCountyIds = $counties->pluck('id')->toArray();

        return $counties;
    }

    public function render()
    {
        $data['facilities'] = Facility::search($this->search)
            ->when($this->region_id, function ($query) {
                $query->Leftjoin('health_sub_districts as hsd', 'facilities.sub_district_id', '=', 'hsd.id')
                    ->Leftjoin('districts as d', 'hsd.district_id', '=', 'd.id')
                    ->Leftjoin('regions as r', 'd.region_id', '=', 'r.id')
                    ->where('d.region_id', $this->region_id)->get(['r.name as region_name', 'facilities.name as facility']);
            })
            ->when($this->ownership, function ($query) {
                $query->where('ownership', $this->ownership);
            })
            ->with('healthSubDistrict', 'healthSubDistrict.district', 'healthSubDistrict.district.region')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        $data['districts'] = District::get();

        return view('livewire.settings.health-facilities-component', $data);
    }
}

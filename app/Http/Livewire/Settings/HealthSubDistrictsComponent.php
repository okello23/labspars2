<?php

namespace App\Http\Livewire\Settings;

use App\Models\District;
use App\Models\Settings\HealthSubDistrict;
use Livewire\Component;
use Livewire\WithPagination;

class HealthSubDistrictsComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $region_id;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'health_sub_districts.id';

    public $orderAsc = 0;

    public $name;

    public $district_id;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'district_id' => 'required|string',
        ]);
    }

    public function storevalue()
    {
        $this->validate([
            'name' => 'required|string|unique:counties',
            'district_id' => 'required|numeric',

        ]);

        $County = new HealthSubDistrict();
        $County->name = $this->name;
        $County->district_id = $this->district_id;
        $County->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'County created successfully!']);
    }

    public function editData(HealthSubDistrict $County)
    {
        $this->edit_id = $County->id;
        $this->name = $County->name;
        $this->district_id = $County->district_id;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['name', 'district_id', 'code']);
    }

    public function updatevalue()
    {
        $this->validate([
            'name' => 'required|unique:counties,name,'.$this->edit_id.'',
            'district_id' => 'required|numeric',
            'code' => 'nullable|string',
        ]);

        $County = HealthSubDistrict::find($this->edit_id);
        $County->name = $this->name;
        $County->district_id = $this->district_id;
        $County->code = $this->code;
        $County->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'County updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->CountyIds) > 0) {
            // return (new countiesExport($this->CountyIds))->download('counties_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No regions selected for export!',
            ]);
        }
    }

    public function filtercounties()
    {
        $counties = HealthSubDistrict::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->CountyIds = $counties->pluck('id')->toArray();

        return $counties;
    }

    public function render()
    {
        $data['sub_districts'] = HealthSubDistrict::search($this->search)
            ->with('district')
            ->when($this->region_id, function ($query) {
                $query->Leftjoin('districts as d', 'health_sub_districts.district_id', '=', 'd.id')
                    ->where('region_id', $this->region_id);
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        $data['districts'] = District::all();

        return view('livewire.settings.health-sub-district-component', $data);
    }
}

<?php

namespace App\Http\Livewire\Settings;

use App\Models\District;
use App\Models\Settings\Region;
use Livewire\Component;
use Livewire\WithPagination;

class DistrictsComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $DistrictIds = [];

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'name';

    public $orderAsc = 1;

    public $name;

    public $region_id;

    public $totalMembers;

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
            'name' => 'required|unique:districts',
            'region_id' => 'required',
        ]);
    }
    

    public function addEntry()
    {
        $this->createNew = true;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:districts',
            'region_id' => 'required',
        ], [
            'name.required' => 'The district name is required',
            'name.unique' => 'The district name entered already exists',
            'region_id' => 'Region is required',
        ]);

        $district = new District();
        $district->name = $this->name;
        $district->region_id = $this->region_id;
        $district->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'District created successfully!']);
    }

    public function editData(District $district)
    {
        $this->dispatchBrowserEvent('show-modal');

        $this->edit_id = $district->id;
        $this->name = $district->name;
        $this->region_id = $district->region_id;
        $this->createNew = false;
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
        $this->reset(['name', 'region_id']);
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required|unique:districts,name,' . $this->edit_id . ',id',
            'region_id' => 'required',
        ]);

        $district = District::find($this->edit_id);
        if (!$district) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'District not found!']);
            return;
        }
        if ($district->name == $this->name && $district->region_id == $this->region_id) {
            $this->dispatchBrowserEvent('alert', ['type' => 'info',  'message' => 'No changes made!']);
            return;
        }
        $this->validate([
            'name' => 'required|unique:districts,name,' . $this->edit_id . ',id',
            'region_id' => 'required',
        ], [
            'name.required' => 'The district name is required',
            'name.unique' => 'The district name entered already exists',
            'region_id.required' => 'Region is required',
        ]); 
        
        $district->name = $this->name;
        $district->region_id = $this->region_id;
        $district->updated_by = \Auth::user()->id;

        $district->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'District updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->DistrictIds) > 0) {
            // return (new districtsExport($this->DistrictIds))->download('districts_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No districts selected for export!',
            ]);
        }
    }

    public function filterdistricts()
    {
        $districts = District::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->DistrictIds = $districts->pluck('id')->toArray();

        return $districts;
    }

    public function render()
    {

        $data['districts'] = District::search($this->search)
            ->when($this->region_id, function ($query) {
                $query->where('region_id', $this->region_id);
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        $data['regions'] = Region::get();

        return view('livewire.settings.districts-component', $data);
    }
}

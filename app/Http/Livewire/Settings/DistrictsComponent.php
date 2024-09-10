<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\District;
use Livewire\WithPagination;

class DistrictsComponent extends Component
{
    use WithPagination;
    //Filters
    public $from_date;

    public $to_date;

    public $DistrictIds;

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
            'name' => 'required|string',
            'region_id' => 'required',
        ]);
    }

    public function storeDistrict()
    {
        $this->validate([
            'name' => 'required|string|unique:districts',
            'region_id' => 'required',

        ]);

        $District = new District();
        $District->name = $this->name;
        $District->region_id = $this->region_id;
        $District->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'District created successfully!']);
    }

    public function editData(District $District)
    {
        $this->edit_id = $District->id;
        $this->name = $District->name;
        $this->region_id = $District->region_id;
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
        $this->reset(['name', 'region_id']);
    }

    public function updateDistrict()
    {
        $this->validate([
            'name' => 'required|unique:districts,name,'.$this->edit_id.'',
            'region_id' => 'required',
        ]);

        $District = District::find($this->edit_id);
        $District->name = $this->name;
        $District->region_id = $this->region_id;
        $District->update();

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
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
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
          $query->where('region_id',$this->region_id);
        })
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.settings.districts-component',$data);
    }
}

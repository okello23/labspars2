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

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $dhis2_code =1;

    public $code;

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
            'dhis2_code' => 'required|string',
            'code' => 'nullable|string',
        ]);
    }

    public function storeDistrict()
    {
        $this->validate([
            'name' => 'required|string|unique:districts',
            'dhis2_code' => 'required|numeric',
            'code' => 'nullable|string',

        ]);

        $District = new District();
        $District->name = $this->name;
        $District->dhis2_code = $this->dhis2_code;
        $District->code = $this->code;
        $District->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'District created successfully!']);
    }

    public function editData(District $District)
    {
        $this->edit_id = $District->id;
        $this->name = $District->name;
        $this->dhis2_code = $District->dhis2_code;
        $this->code = $District->code;
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
        $this->reset(['name', 'dhis2_code', 'code']);
    }

    public function updateDistrict()
    {
        $this->validate([
            'name' => 'required|unique:districts,name,'.$this->edit_id.'',
            'dhis2_code' => 'required|numeric',
            'code' => 'nullable|string',
        ]);

        $District = District::find($this->edit_id);
        $District->name = $this->name;
        $District->dhis2_code = $this->dhis2_code;
        $District->code = $this->code;
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
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.settings.districts-component',$data);
    }
}

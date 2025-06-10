<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Models\Settings\LabPlatform;

class LabPlatformComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $platformIDs = [];

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'name';

    public $orderAsc = 0;
  

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public  $platform_id, $name, $type, $manufacturer, $model_number, $is_active;
  


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
            'type' => 'required',
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'is_active' => 'required',
        ]);
        LabPlatform::updateOrCreate(['id' => $this->platform_id], [
            'name' => $this->name,
            'type' => $this->type,
            'manufacturer' => $this->manufacturer,
            'model_number' => $this->model_number,
            'is_active' => $this->is_active,
        ]);

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Health LabPlatform added successfully!']);
    }

    public function editData(LabPlatform $LabPlatform)
    {
        $this->edit_id = $LabPlatform->id;
        $this->platform_id = $LabPlatform->id;
        $platform = $LabPlatform;
        $this->name = $platform->name;
        $this->type = $platform->type;
        $this->manufacturer = $platform->manufacturer;
        $this->model_number = $platform->model_number;
        $this->is_active = $platform->is_active;
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
        $this->reset(['name', 'type',  'manufacturer', 'model_number','is_active']);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:facilities,name,'.$this->edit_id.'',
            'level' => 'required',
            'ownership' => 'required',
            'sub_district_id' => 'required',
        ]);

        $LabPlatform = LabPlatform::find($this->edit_id);
        $LabPlatform->name = $this->name;
        $LabPlatform->level = $this->level;
        $LabPlatform->ownership = $this->ownership;
        $LabPlatform->sub_district_id = $this->sub_district_id;
        $LabPlatform->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Health LabPlatform details updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }
    public function delete($id)
    {
        try{
        LabPlatform::find($id)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Platform Deleted Successfully.']);
            //code...
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops!!',
                'text' => 'Record can not be deleted!',
            ]);
        }
    }

    public function export()
    {
        if (count($this->platformIDs) > 0) {
            // return (new countiesExport($this->SubCountyIds))->download('counties_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Equipment selected for export!',
            ]);
        }
    }
  
    public function render()
    {
        $data['platforms'] = LabPlatform::search($this->search)            
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.settings.lab-platform-component', $data);
    }
}

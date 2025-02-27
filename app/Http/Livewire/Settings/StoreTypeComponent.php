<?php

namespace App\Http\Livewire\Settings;

use App\Models\Facility\FvStorageType;
use Livewire\Component;
use Livewire\WithPagination;

class StoreTypeComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $exportIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $description = 1;

    public $is_active;

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
            'is_active' => 'required|integer',
            'description' => 'nullable|string',
        ]);
    }

    public function storevalue()
    {
        $this->validate([
            'name' => 'required|string|unique:fv_storage_types',
            'is_active' => 'required|integer',
            'description' => 'nullable|string',

        ]);

        $StorageType = new FvStorageType();
        $StorageType->name = $this->name;
        $StorageType->is_active = $this->is_active;
        $StorageType->description = $this->description;
        $StorageType->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'StorageType created successfully!']);
    }

    public function editData(FvStorageType $StorageType)
    {
        $this->edit_id = $StorageType->id;
        $this->name = $StorageType->name;
        $this->description = $StorageType->description;
        $this->is_active = $StorageType->is_active;
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
        $this->reset(['name', 'description', 'is_active']);
    }

    public function updatevalue()
    {
        $this->validate([
            'name' => 'required|string|unique:fv_storage_types',
            'is_active' => 'required|integer',
            'description' => 'nullable|string',

        ]);

        $StorageType = FvStorageType::find($this->edit_id);
        $StorageType->name = $this->name;
        $StorageType->is_active = $this->is_active;
        $StorageType->description = $this->description;
        $StorageType->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'StorageType updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->exportIds) > 0) {
            // return (new StorageTypesExport($this->exportIds))->download('StorageTypes_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No StorageTypes selected for export!',
            ]);
        }
    }

    public function render()
    {
        $data['StorageTypes'] = FvStorageType::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.settings.store-type-component', $data);
    }
}

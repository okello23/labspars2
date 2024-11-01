<?php

namespace App\Http\Livewire\Settings;

use App\Models\Settings\Reagent;
use App\Models\Settings\TestingCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ReagentsComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'name';

    public $orderAsc = 1;

    public $name;

    public $testing_category_id;

    public $is_active;

    public $delete_id;

    public $edit_id;

    public $description;
    public $exportIds;

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
            'name' => 'required|unique:testing_categories',
            'testing_category_id' => 'required',
            'description' => 'required',
            'is_active' => 'required',
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
            'name' => 'required|unique:testing_categories',
            'testing_category_id' => 'required',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        $reagent = new Reagent();
        $reagent->name = $this->name;
        $reagent->description = $this->description;
        $reagent->testing_category_id = $this->testing_category_id;
        $reagent->is_active = $this->is_active;
        $reagent->created_by = auth()->user()->id;
        $reagent->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['testing_category_id' => 'success',  'message' => 'reagent added successfully!']);
    }

    public function editData(Reagent $reagent)
    {
        $this->edit_id = $reagent->id;
        $this->name = $reagent->name;
        $this->testing_category_id = $reagent->testing_category_id;
        $this->description = $reagent->description;
        $this->is_active = $reagent->is_active;

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
        $this->reset(['name', 'is_active']);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:testing_categories,name,'.$this->edit_id.'',
            'is_active' => 'required',
        ]);

        $reagent = Reagent::find($this->edit_id);
        $reagent->name = $this->name;
        $reagent->is_active = $this->is_active;
        $reagent->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['testing_category_id' => 'success',  'message' => 'reagent updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->reagentIDs) > 0) {
            // return (new reagentsExport($this->reagentIDs))->download('lss_reagents'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'testing_category_id' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Test selected for export!',
            ]);
        }
    }

    public function mainQuery()
    {
        $reagents = Reagent::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->exportIds = $reagents->pluck('id')->toArray();

        return $reagents;
    }

    public function render()
    {

        $data['categories'] = TestingCategory::where('is_active', true)->get();
        $data['reagents'] = $this->mainQuery()
            ->when($this->is_active, function ($query) {
                $query->where('is_active', $this->is_active);
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.settings.reagents-component', $data);
    }
}

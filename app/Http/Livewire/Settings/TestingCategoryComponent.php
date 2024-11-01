<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\TestingCategory;

class TestingCategoryComponent extends Component
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

    public $type;

    public $is_active;

    public $delete_id;

    public $edit_id;

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
        ]);

        $TestingCategory = new TestingCategory();
        $TestingCategory->name = $this->name;
        $TestingCategory->is_active = $this->is_active;
        $TestingCategory->created_by = auth()->user()->id;
        $TestingCategory->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'TestingCategory added successfully!']);
    }

    public function editData(TestingCategory $TestingCategory)
    {
        $this->edit_id = $TestingCategory->id;
        $this->name = $TestingCategory->name;
        $this->is_active = $TestingCategory->is_active;

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

        $TestingCategory = TestingCategory::find($this->edit_id);
        $TestingCategory->name = $this->name;
        $TestingCategory->is_active = $this->is_active;
        $TestingCategory->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'TestingCategory updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->TestingCategoryIDs) > 0) {
            // return (new TestingCategorysExport($this->TestingCategoryIDs))->download('lss_TestingCategorys'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Test selected for export!',
            ]);
        }
    }

    public function mainQuery()
    {
        $TestingCategorys = TestingCategory::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->exportIds = $TestingCategorys->pluck('id')->toArray();

        return $TestingCategorys;
    }

    public function render()
    {

        $data['categories'] = $this->mainQuery()->with('category')
            ->when($this->is_active, function ($query) {
                $query->where('is_active', $this->is_active);
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.settings.testing-category-component', $data);
    }
}

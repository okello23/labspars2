<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\County;
use App\Models\Settings\SubCounty;

class SubCountiesComponent extends Component
{
    use WithPagination;
    //Filters
    public $from_date;

    public $to_date;

    public $SubCountyIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $county_id;

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
            'county_id' => 'required|string',
            'code' => 'nullable|string',
        ]);
    }

    public function storevalue()
    {
        $this->validate([
            'name' => 'required|string|unique:sub_counties',
            'county_id' => 'required|numeric',
            'code' => 'nullable|string',

        ]);

        $SubCounty = new SubCounty();
        $SubCounty->name = $this->name;
        $SubCounty->county_id = $this->county_id;
        $SubCounty->code = $this->code;
        $SubCounty->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'SubCounty created successfully!']);
    }

    public function editData(SubCounty $SubCounty)
    {
        $this->edit_id = $SubCounty->id;
        $this->name = $SubCounty->name;
        $this->county_id = $SubCounty->county_id;
        $this->code = $SubCounty->code;
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
        $this->reset(['name', 'county_id', 'code']);
    }

    public function updatevalue()
    {
        $this->validate([
            'name' => 'required|unique:sub_counties,name,' . $this->edit_id . '',
            'county_id' => 'required|numeric',
            'code' => 'nullable|string',
        ]);

        $SubCounty = SubCounty::find($this->edit_id);
        $SubCounty->name = $this->name;
        $SubCounty->county_id = $this->county_id;
        $SubCounty->code = $this->code;
        $SubCounty->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'SubCounty updated successfully!']);
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
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
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
        $data['sub_counties'] = SubCounty::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['districts'] = County::all();
        return view('livewire.settings.sub-counties-component', $data);
    }
}

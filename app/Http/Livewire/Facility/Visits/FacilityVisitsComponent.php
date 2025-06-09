<?php

namespace App\Http\Livewire\Facility\Visits;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\District;
use App\Models\Settings\Region;
use App\Models\Facility\Facility;
use App\Models\Facility\FacilityVisit;

class FacilityVisitsComponent extends Component
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

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $visit_number;

    public $in_charge_name;

    public $in_charge_contact;

    public $responsible_lss_name;

    public $region_id;
    
    public $health_sub_district_id;

    public $facility_id;

    public $facilities = [];

    public $districts_list = [];

    public $district_id;

    public $facility_level;    

    public $use_stock_cards;

    public $date_of_visit;

    public $date_of_next_visit;
    // Filter-specific variables
    public $filter_region_id;

    public $filter_district_id;
    
    public $filter_health_sub_district_id;
    
    public $filter_facility_level;


    public function updatedDateOfVisit()
    {
        $date_of_visit = Carbon::parse($this->date_of_visit);
        $this->date_of_next_visit = $date_of_visit->addDays(60)->format('Y-m-d');
    }

  public function updatedRegionId($value)
{
    // Clear lower-level selections
    $this->district_id = '';
    $this->health_sub_district_id = '';

    // Populate districts for the selected region
    $this->districts_list = District::where('region_id', $value)->get();
}

  public function updatedFilterRegionId($value)
{
    // Clear lower-level selections
    $this->district_id = '';
    $this->health_sub_district_id = '';

    // Populate districts for the selected region
    $this->districts_list = District::where('region_id', $value)->get();
}

    public function mount()
    {
        $this->from_date = Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m-d');
        $this->to_date = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->DistrictIds = [];
        $this->resetInputs();

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'info',
            'message' => 'Notice!',
            'message' => 'Data loaded is limited to the last three months. To view more, please clear the filters.'
        ]);
    }

    public function export()
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'info',
            'title' => 'Export Data',
            'message' => 'Functionality to export data is not yet implemented.'
        ]);
    }


    public function storevalue()
    {
        // Validate the input
        $this->validate([
            'visit_number' => 'required',
            'in_charge_name' => 'required',
            'in_charge_contact' => 'required',
            'responsible_lss_name' => 'required',
            'facility_id' => 'required',
            'use_stock_cards' => 'nullable',
            'date_of_visit' => 'required',
            'date_of_next_visit' => 'required',
        ]);

        // Create a new Facility record
        $visit = new FacilityVisit();
        $visit->visit_code = 'V-'.date('YM').'-'.time();
        $visit->visit_number = $this->visit_number;
        $visit->in_charge_name = $this->in_charge_name;
        $visit->in_charge_contact = $this->in_charge_contact;
        $visit->responsible_lss_name = $this->responsible_lss_name;
        $visit->facility_id = $this->facility_id;
        $visit->date_of_visit = $this->date_of_visit;
        $visit->date_of_next_visit = $this->date_of_next_visit;
        $visit->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->close();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Facility updated successfully!']);

        return redirect()->SignedRoute('facility-visit_details', $visit->visit_code);

    }

    public function updatedDistrictId($id)
    {
        $this->facilities = Facility::whereHas('healthSubDistrict.district', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        $this->facility_level = '';

    }

    public function updatedFacilityId($id)
    {
        $facility = Facility::where('id', $id)->first();
        $this->facility_level = $facility ? $facility->level : null;

    }
    public function editData(FacilityVisit $visit)
    {
        $this->edit_id = $visit->id;
        $this->visit_number = $visit->visit_number;
        $this->in_charge_name = $visit->in_charge_name;
        $this->in_charge_contact = $visit->in_charge_contact;
        $this->responsible_lss_name = $visit->responsible_lss_name;
        $this->facility_id = $visit->facility_id;
        $this->use_stock_cards = $visit->use_stock_cards;
        $this->date_of_visit = $visit->date_of_visit;
        $this->date_of_next_visit = $visit->date_of_next_visit;

        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function updatedFacilitId()
    {
        // $facility = Facility::find($this->facility_id);
        // $this->in_charge_name = $facility->in_charge_name;
        // $this->in_charge_contact = $facility->in_charge_contact;
    }

    public function updatevalue()
    {
        // Validate the input
        $this->validate([
            'visit_number' => 'required',
            'in_charge_name' => 'required',
            'in_charge_contact' => 'required',
            'responsible_lss_name' => 'required',
            'facility_id' => 'required',
            'use_stock_cards' => 'nullable',
            'date_of_visit' => 'required',
            'date_of_next_visit' => 'required',

        ]);

        $visit = FacilityVisit::where('id', $this->edit_id)->first();
        $visit->visit_number = $this->visit_number;
        $visit->in_charge_name = $this->in_charge_name;
        $visit->in_charge_contact = $this->in_charge_contact;
        $visit->responsible_lss_name = $this->responsible_lss_name;
        $visit->facility_id = $this->facility_id;
        // $visit->use_stock_cards = $this->use_stock_cards;
        $visit->date_of_visit = $this->date_of_visit;
        $visit->date_of_next_visit = $this->date_of_next_visit;
        $visit->update();

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->close();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Facility updated successfully!']);

        return redirect()->SignedRoute('facility-visit_details', $visit->visit_code);

    }

    public function resetInputs()
    {
        $this->reset([
            'visit_number',
            'in_charge_name',
            'in_charge_contact',
            'responsible_lss_name',
            'facility_id',
            'use_stock_cards',
            'date_of_visit',
            'date_of_next_visit',
        ]);
    }

  public function filterFacilities()
{
      $data = FacilityVisit::search($this->search)
        ->when($this->filter_region_id != '', function ($query) {
            $query->whereHas('facility.healthSubDistrict.district.region', function ($q) {
                $q->where('id', $this->filter_region_id);
            });
        })
        ->when($this->filter_health_sub_district_id != '', function ($query) {
            $query->whereHas('facility.healthSubDistrict', function ($q) {
                $q->where('id', $this->filter_health_sub_district_id);
            });
        })
        ->when($this->filter_district_id != '', function ($query) {
            $query->whereHas('facility.healthSubDistrict.district', function ($q) {
                $q->where('id', $this->filter_district_id);
                if ($this->filter_region_id != '') {
                    $q->whereHas('region', function ($regionQuery) {
                        $regionQuery->where('id', $this->filter_region_id);
                    });
                }
            });
        })
        ->when($this->filter_facility_level != '', function ($query) {
            $query->whereHas('facility', function ($q) {
                $q->where('level', $this->filter_facility_level);
            });
        })
        ->when($this->search != '', function ($query) {
            $query->where('visit_number', 'like', '%'.$this->search.'%');
        })
        ->when($this->orderBy != '', function ($query) {
            $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        })
        ->when($this->from_date != '' && $this->to_date != '', function ($query) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        });

    $this->DistrictIds = $data->pluck('id')->toArray();

    return $data;
}


    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function render()
    {
        $data['visits'] = $this->filterFacilities()
            ->with(['facility', 'facility.healthSubDistrict', 'facility.healthSubDistrict.district', 'facility.healthSubDistrict.district.region','createdBy'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        // $data['facilities'] = Facility::all();
        $data['districts'] = [];
        $data['regions'] = Region::all();
        $data['health_sub_districts'] = [];
        return view('livewire.facility.visits.facility-visits-component', $data);
    }
}

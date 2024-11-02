<?php

namespace App\Http\Livewire\Facility\Visits;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
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

    public $facility_id;

    public $use_stock_cards;

    public $date_of_visit;

    public $date_of_next_visit;

    public function updatedDateOfVisit()
    {
        $date_of_visit = Carbon::parse($this->date_of_visit);
        $this->date_of_next_visit = $date_of_visit->addDays(60)->format('Y-m-d');
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
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
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
            ->with(['facility', 'facility.healthSubDistrict', 'facility.healthSubDistrict.district', 'facility.healthSubDistrict.district.region'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['facilities'] = Facility::all();

        return view('livewire.facility.visits.facility-visits-component', $data);
    }
}

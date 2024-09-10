<?php

namespace App\Http\Livewire\Facility;

use App\Models\District;
use App\Models\Facility\Facility;
use App\Models\Settings\County;
use Livewire\Component;
use Livewire\WithPagination;

class FacilityComponent extends Component
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

    public $name;
    public $level;
    public $ip;
    public $parent_id;
    public $dhis2_facility_name;
    public $dhis2_facility_code;
    public $ownership;
    public $clinician_contact;
    public $email;
    public $is_hub;
    public $is_training_partner;
    public $details_sent;
    public $district_id;
    public $sub_district_id;
    public $is_active;

    public function storevalue()
    {
        // Validate the input
        $this->validate([
            'name'=>'nullable|string',
            'level'=>'nullable|integer',
            'ip'=>'nullable',
            'parent_id'=>'nullable|integer',
            'dhis2_facility_name'=>'nullable|string',
            'dhis2_facility_code'=>'nullable',
            'ownership'=>'required|string',
            'clinician_contact'=>'required',
            'email'=>'required|email',
            'is_active'=>'required|integer',
            'is_hub'=>'nullable|integer',
            'is_training_partner'=>'nullable|integer',
            'details_sent'=>'nullable|integer',
            'district_id'=>'required|integer',
            // 'sub_district_id'=>'required|integer',
            // ... other validation rules ...
        ]);

        // Create a new Facility record
        $facility = new Facility();
        $facility->name = $this->name;
        $facility->level = $this->level;
        $facility->ip = $this->ip;
        $facility->parent_id = $this->parent_id;
        $facility->dhis2_facility_name = $this->dhis2_facility_name;
        $facility->dhis2_facility_code = $this->dhis2_facility_code;
        $facility->ownership = $this->ownership;
        $facility->clinician_contact = $this->clinician_contact;
        $facility->email = $this->email;
        $facility->is_hub = $this->is_hub??0;
        $facility->is_active = $this->is_active;
        $facility->is_training_partner = $this->is_training_partner??0;
        $facility->details_sent = $this->details_sent??0;
        $facility->district_id = $this->district_id;
        $facility->sub_district_id = $this->sub_district_id;
        $facility->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->close();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Facility updated successfully!']);

    }
    public function editData(Facility $facility)
    {
        $this->edit_id = $facility->id;
        $this->name = $facility->name;
        $this->level = $facility->level;
        $this->ip = $facility->ip;
        $this->parent_id = $facility->parent_id;
        $this->dhis2_facility_name = $facility->dhis2_facility_name;
        $this->dhis2_facility_code = $facility->dhis2_facility_code;
        $this->ownership = $facility->ownership;
        $this->clinician_contact = $facility->clinician_contact;
        $this->email = $facility->email;
        $this->is_hub = $facility->is_hub;
        $this->is_active = $facility->is_active;
        $this->is_training_partner = $facility->is_training_partner;
        $this->details_sent = $facility->details_sent;
        $this->district_id = $facility->district_id;
        $this->sub_district_id = $facility->sub_district_id;
        $this->createNew = true;
        $this->toggleForm = true;
    }
    public function updatevalue()
    {
        // Validate the input
        $this->validate([
            'name'=>'nullable|string',
            'level'=>'nullable|integer',
            'ip'=>'nullable',
            'parent_id'=>'nullable|integer',
            'dhis2_facility_name'=>'nullable|string',
            'dhis2_facility_code'=>'nullable',
            'ownership'=>'required|string',
            'clinician_contact'=>'required',
            'email'=>'required|email',
            'is_hub'=>'integer',
            'is_active'=>'integer',
            'is_training_partner'=>'integer',
            'details_sent'=>'integer',
            'district_id'=>'required|integer',
            'sub_district_id'=>'required|integer',
            // ... other validation rules ...
        ]);

        $facility = Facility::where('id',$this->edit_id)->first();
        $facility->name = $this->name;
        $facility->level = $this->level;
        $facility->ip = $this->ip;
        $facility->parent_id = $this->parent_id;
        $facility->dhis2_facility_name = $this->dhis2_facility_name;
        $facility->dhis2_facility_code = $this->dhis2_facility_code;
        $facility->ownership = $this->ownership;
        $facility->clinician_contact = $this->clinician_contact;
        $facility->email = $this->email;
        $facility->is_hub = $this->is_hub;
        $facility->is_active = $this->is_active;
        $facility->is_training_partner = $this->is_training_partner;
        $facility->details_sent = $this->details_sent;
        $facility->district_id = $this->district_id;
        $facility->sub_district_id = $this->sub_district_id;
        $facility->update();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->close();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Facility updated successfully!']);


        // Clear input fields after saving
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->close();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Facility updated successfully!']);

    }
    public function resetInputs()
    {
        $this->reset([
            'name',
            'level',
            'ip',
            'parent_id',
            'dhis2_facility_name',
            'dhis2_facility_code',
            'ownership',
            'clinician_contact',
            'email',
            'is_hub',
            'is_active',
            'is_training_partner',
            'details_sent',
            'district_id',
            'sub_district_id',
        ]);
    }
    public function filterFaclities()
    {
        $data = Facility::search($this->search)
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
        $data['facilities'] = $this->filterFaclities()->with(['district', 'village', 'parish', 'village', 'county', 'subcounty'])->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['districts'] = District::all();
        $data['divisions'] = County::where('district_id', $this->district_id)->get();
        return view('livewire.facility.facility-component', $data);
    }
}

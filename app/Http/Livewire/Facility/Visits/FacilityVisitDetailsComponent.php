<?php

namespace App\Http\Livewire\Facility\Visits;

use App\Models\Facility\FacilityVisit;
use App\Models\Facility\FvPersonsSupervised;
use Livewire\Component;

class FacilityVisitDetailsComponent extends Component
{
    public $code;
    public $active_visit;
    public $step;
    public $toggleForm = false;
    public $sex, $contact, $email, $name, $profession;

    public function mount($code)
    {
        $this->code = $code;
        $this->active_visit = FacilityVisit::where('visit_code', $code)->with(['facility', 'facility.district', 'facility.subcounty'])->first();
        if (!$this->step) {
            $this->step = 1;
        }

    }
    public function storePersonal()
    {
        $this->validate([
            'name' => 'required|string',
            'contact' => 'required|numeric',
            'sex' => 'required|string',
            'email' => 'required|email',
            'profession'=> 'required|string',

        ]);

        $County = new FvPersonsSupervised();
        $County->visit_id = $this->active_visit->id;
        $County->name = $this->name;
        $County->contact = $this->contact;
        $County->email = $this->email;
        $County->sex = $this->sex;
        $County->profession = $this->profession;
        $County->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully!']);
    }
    public function resetInputs(){
        $this->reset([
            'name',
            'contact',
            'sex',
            'email',
            'profession'
        ]);
    }
    public function close()
    {
        $this->resetInputs();
    }
    public function stepOne()
    {
      
        $data['supervisors'] = collect([]);
        $data['supply_storages'] = collect([]);
        $data['stock_card_storages'] = collect([]);
    }
    public function render()
    {
        $data['supervised_persons'] = collect([]);
        $data['supervisors'] = collect([]);
        $data['supply_storages'] = collect([]);
        $data['stock_card_storages'] = collect([]);
        if ($this->step == 1) {
            $data['supervised_persons'] = FvPersonsSupervised::where('visit_id', $this->active_visit->id)->get();
        }
        return view('livewire.facility.visits.facility-visit-details-component', $data);
    }
}

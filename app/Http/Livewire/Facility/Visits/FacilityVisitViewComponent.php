<?php

namespace App\Http\Livewire\Facility\Visits;

use App\Models\Facility\Facility;
use App\Models\Facility\FacilityVisit;
use App\Models\Facility\FvPersonsSupervised;
use Livewire\Component;

class FacilityVisitViewComponent extends Component
{
    public $code;
    public $active_visit;
    public $step;


    public function mount($code)
    {
        $this->code = $code;
        $this->active_visit = FacilityVisit::where('visit_code', $code)->with(['facility', 'facility.district', 'facility.subcounty'])->first();
        if(!$this->step){
            $this->step = 1;
        }

    } 
   
    public function close()
    {
        // $this->resetInputs();
    }
    public function stepOne(){
        $data['supervised_persons'] = FvPersonsSupervised::where('visit_id',$this->active_visit)->get();
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
        if($this->step==1){
          $this->stepOne();
        }
        return view('livewire.facility.visits.facility-visit-view-component',$data);
    }
}

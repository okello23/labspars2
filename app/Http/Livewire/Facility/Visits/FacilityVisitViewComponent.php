<?php

namespace App\Http\Livewire\Facility\Visits;

use Livewire\Component;
use App\Models\Facility\Facility;
use App\Models\Facility\FvSupervisor;
use App\Models\Facility\FacilityVisit;
use App\Models\Facility\FvPersonsSupervised;
use App\Models\Facility\Visits\FvStorageManagement;

class FacilityVisitViewComponent extends Component
{
    public $code;
    public $active_visit;
    public $step;
    public $use_stock_cards;
    public $consumption_reconciliation;

    public function mount($code)
    {
        $this->code = $code;
        $this->active_visit = FacilityVisit::where('visit_code', $code)->with(['facility', 'facility.district'])->first();
        $this->consumption_reconciliation = $this->active_visit->consumption_reconciliation ?? null;
        $this->use_stock_cards = $this->active_visit->use_stock_cards ?? 0;
        if(!$this->step){
            $this->step = 1;
        }

    }

    public function close()
    {
        // $this->resetInputs();
    }
    public function render()
    {
        $data['supervised_persons'] = collect([]);
        $data['supervisors'] = collect([]);
        $data['supply_storages'] = collect([]);
        $data['stock_card_storages'] = collect([]);
        if($this->step==1){
            $data['supervised_persons'] = FvPersonsSupervised::where('visit_id', $this->active_visit->id)->get();
            $data['supervisors'] = FvSupervisor::where('visit_id', $this->active_visit->id)->get();
            $data['supply_storages'] = FvStorageManagement::where('visit_id', $this->active_visit->id)->with('storageType')->get();
        }
        return view('livewire.facility.visits.facility-visit-view-component',$data);
    }
}

<?php

namespace App\Http\Livewire\Facility\Visits;

use Livewire\Component;
use App\Models\Settings\Reagent;
use App\Models\Settings\StockItem;
use App\Models\Settings\LabPlatform;
use App\Models\Facility\FvSupervisor;
use App\Models\Settings\FilledReport;
use App\Models\Facility\FacilityVisit;
use App\Models\Facility\FvStorageType;
use App\Models\Settings\TestingCategory;
use App\Models\Settings\FvLisDataToolScore;
use App\Models\Facility\FvPersonsSupervised;
use App\Models\Facility\Visits\FvOrderReview;
use App\Models\Settings\LisDataCollectionTool;
use App\Models\Facility\Visits\FvLisHmisReport;
use App\Models\Facility\Visits\FvLisLabDataUse;
use App\Models\Facility\Visits\FvReportFilling;
use App\Models\Facility\Visits\FvStockManagement;
use App\Models\Facility\Visits\FvStorageManagement;
use App\Models\Facility\Visits\FvCompStockStatusAcc;
use App\Models\Facility\Visits\FvEquipmentUtilization;
use App\Models\Facility\Visits\FvEquipmentFunctionality;
use App\Models\Facility\Visits\FvCompServiceStatisticsAcc;

class FacilityVisitViewComponent extends Component
{
    public $code;

    public $active_visit;

    public $step;

    public $use_stock_cards;

    public $consumption_reconciliation;
    public $limsData;

    public function mount($code)
    {
        $this->code = $code;
        $this->active_visit = FacilityVisit::where('visit_code', $code)
        ->with(['facility', 'facility.healthSubDistrict', 'facility.healthSubDistrict.district', 'facility.healthSubDistrict.district.region'])->first();
        $this->consumption_reconciliation = $this->active_visit->consumption_reconciliation ?? null;
        $this->use_stock_cards = $this->active_visit->use_stock_cards ?? 0;
        $this->limsData = FvLisHmisReport::where('visit_id', $this->active_visit->id)->first();

    }
   

    public function close()
    {
        // $this->resetInputs();
    }

    public function render()
    {
       
            $data['supervised_persons'] = FvPersonsSupervised::where('visit_id', $this->active_visit->id)->get();
            $data['supervisors'] = FvSupervisor::where('visit_id', $this->active_visit->id)->get();
            $data['supply_storages'] = FvStorageManagement::where('visit_id', $this->active_visit->id)->with('storageType')->get();

    
            $data['test_types'] = TestingCategory::where(['is_active' => true])->get();
            // $data['reagents'] = Reagent::where(['is_active' => true, 'testing_category_id' => $this->test_type_id])->get();
            $data['storageMgts'] = FvStockManagement::where('visit_id', $this->active_visit->id)->with('reagent')->get();
  
            $items = FvStockManagement::where('visit_id', $this->active_visit->id)->orderBy('id', 'asc')->limit(5)->pluck('reagent_id')->toArray();
            $data['reviews'] = FvOrderReview::where('visit_id', $this->active_visit->id)->with('reagent')->get();
            $data['orderItems'] = Reagent::where(['is_active' => true])->whereIn('id', $items)->get();
   
            $data['platforms'] = LabPlatform::where('is_active', true)->get();
            $data['functionalities'] = FvEquipmentFunctionality::where('visit_id', $this->active_visit->id)->get();
            $data['utilizations'] = FvEquipmentUtilization::where('visit_id', $this->active_visit->id)->get();
      
            $data['dcTools'] = LisDataCollectionTool::where('is_active', true)->get();
            $data['reports'] = FilledReport::where('is_active', true)->get();
            $data['stockItems'] = StockItem::where('is_active', true)->get();
            $data['dcToolScores'] = FvLisDataToolScore::where('visit_id', $this->active_visit->id)->with('dcTool')->get();
            $data['lisLabDataUsages'] = FvLisLabDataUse::where('visit_id', $this->active_visit->id)->get();
            $data['filedReports'] = FvReportFilling::where('visit_id', $this->active_visit->id)->with('report')->get();
            $data['services'] = FvCompServiceStatisticsAcc::where('visit_id', $this->active_visit->id)->get();
            $data['stockStatuses'] = FvCompStockStatusAcc::where('visit_id', $this->active_visit->id)->with('stkItem')->get();
        
        $data['storageTypes'] = FvStorageType::where('is_active', true)->get();

        return view('livewire.facility.visits.facility-visit-view-component', $data);
    }
}

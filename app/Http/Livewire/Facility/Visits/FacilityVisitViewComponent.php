<?php
namespace App\Http\Livewire\Facility\Visits;

use App\Models\Facility\FacilityVisit;
use App\Models\Facility\FvPersonsSupervised;
use App\Models\Facility\FvSupervisor;
use App\Models\Facility\Visits\FvAdherence;
use App\Models\Facility\Visits\FvCleanlinessManagement;
use App\Models\Facility\Visits\FvCompServiceStatisticsAcc;
use App\Models\Facility\Visits\FvCompStockStatusAcc;
use App\Models\Facility\Visits\FvEquipmentFunctionality;
use App\Models\Facility\Visits\FvEquipmentManagement;
use App\Models\Facility\Visits\FvEquipmentUtilization;
use App\Models\Facility\Visits\FvHygieneManagement;
use App\Models\Facility\Visits\FvLisHmisReport;
use App\Models\Facility\Visits\FvLisLabDataUse;
use App\Models\Facility\Visits\FvOrderManagement;
use App\Models\Facility\Visits\FvOrderReview;
use App\Models\Facility\Visits\FvReportFilling;
use App\Models\Facility\Visits\FvStockManagement;
use App\Models\Facility\Visits\FvStockMgtScore;
use App\Models\Facility\Visits\FvStorageConditionManagement;
use App\Models\Facility\Visits\FvStorageManagement;
use App\Models\Facility\Visits\FvStoragePracticeManagement;
use App\Models\Facility\Visits\FvStorageSystemManagement;
use App\Models\Settings\FvLisDataToolScore;
use App\Models\Settings\LisDataCollectionTool;
use App\Http\Livewire\Dashboard\MainDashboardComponent;
use Livewire\Component;

class FacilityVisitViewComponent extends Component
{
    public $code;

    public $active_visit;

    public $step;

    public $use_stock_cards;

    public $consumption_reconciliation, $stock_mgt_comments;
    public $limsData, $stkScores, $cleanliness, $hygiene, $condition, $system, $StoragePractices, $adherence, $ordering, $equipmentMgt;
    public $scores = [];
    public $stock_management;
    public $storage_management;
    public $ordering_management;
    public $equipment_management;
    public $lis_mgt;
    public $component_scores;

    public $categories = [
        'Stock Management'               => 6,
        'Storage Areas & Lab Facilities' => 5,
        'Ordering'                       => 3,
        'Laboratory Equipment'           => 4,
        'Laboratory Information Systems' => 6,
    ];

    public function showFacilityVisit($visitCode)
{
    $visit = FacilityVisit::where('visit_code', $visitCode)->firstOrFail();

    // Fetch scores for this visit
    $scores = (new MainDashboardComponent())->stockMgtScores();
    $stockManagement = collect($scores)->firstWhere('visit_id', $visit->id)['components'] ?? [];

    return view('facility-visit_view', [
        'facilityvisit'    => $visit,
        'stock_management' => $stockManagement,
    ]);
}


    public function getScaledScoresProperty()
    {
        return collect($this->categories)->mapWithKeys(function ($max, $key) {
            $score = $this->scores[$key] ?? 0;
            return [$key => round(($score / $max) * 5, 2)];
        });
        $this->scores = [
            'Stock Management'               => 5,
            'Storage Areas & Lab Facilities' => 1,
            'Ordering'                       => 2,
            'Laboratory Equipment'           => 3,
            'Laboratory Information Systems' => 5,
        ];
    }
    public function mount($code)
    {
        $this->code         = $code;
        $this->active_visit = FacilityVisit::where('visit_code', $code)
            ->with(['facility', 'facility.healthSubDistrict', 'facility.healthSubDistrict.district', 'facility.healthSubDistrict.district.region'])->first();

        // Stock Management scores
        $stockMgtScores = (new MainDashboardComponent())->stockMgtScores();
        $this->stock_management = collect($stockMgtScores)->firstWhere('visit_id', $this->active_visit->id)['components'] ?? [];
        
        // Storage scores
        $StorageMgtScore = (new MainDashboardComponent())->fvTotalStorageScore();
        $this->storage_management = collect($StorageMgtScore)->firstWhere('visit_id', $this->active_visit->id)['component_scores'] ?? [];
        
        // Order Scores
        $orderMgtScore = (new MainDashboardComponent())->fvTotalOrderMgtScore();
        $this->ordering_management = collect($orderMgtScore)->firstWhere('visit_id', $this->active_visit->id)['component_scores'] ?? []; 

        // Equipment Mgt Scores
        $equipmentMgtScore = (new MainDashboardComponent())->getCombinedEquipmentScores();
        $this->equipment_management = collect($equipmentMgtScore)->firstWhere('visit_id', $this->active_visit->id)['component_scores'] ?? [];
        
        // LIS Mgt Scores
        $lisMgtScore = (new MainDashboardComponent())->fvLisTotalScorePerVisit();
        $this->lis_mgt = collect($lisMgtScore)->firstWhere('visit_id', $this->active_visit->id)['component_scores'] ?? [];


        $this->consumption_reconciliation = $this->active_visit->consumption_reconciliation ?? null;
        $this->use_stock_cards            = $this->active_visit->use_stock_cards ?? 0;
        $this->limsData                   = FvLisHmisReport::where('visit_id', $this->active_visit->id)->first();
        // firstStepSubmit
        $this->stkScores = FvStockMgtScore::where('visit_id', $this->active_visit->id)->first();

        // secondStepSubmit
        $this->cleanliness      = FvCleanlinessManagement::where('visit_id', $this->active_visit->id)->first();
        $this->hygiene          = FvHygieneManagement::where('visit_id', $this->active_visit->id)->first();
        $this->condition        = FvStorageConditionManagement::where('visit_id', $this->active_visit->id)->first();
        $this->system           = FvStorageSystemManagement::where('visit_id', $this->active_visit->id)->first();
        $this->StoragePractices = FvStoragePracticeManagement::where('visit_id', $this->active_visit->id)->first();
        // thirdStepSubmit
        $this->adherence = FvAdherence::where('visit_id', $this->active_visit->id)->first();
        $this->ordering  = FvOrderManagement::where('visit_id', $this->active_visit->id)->first();
        // fourthStepSubmit
        $this->equipmentMgt = FvEquipmentManagement::where('visit_id', $this->active_visit->id)->first();
        // fifthStepSubmit
    }

    public function close()
    {
        // $this->resetInputs();
    }

    public function render()
    {

        $data['supervised_persons'] = FvPersonsSupervised::where('visit_id', $this->active_visit->id)->get();
        $data['supervisors']        = FvSupervisor::where('visit_id', $this->active_visit->id)->get();
        $data['supply_storages']    = FvStorageManagement::where('visit_id', $this->active_visit->id)->with('storageType')->get();

        // $data['test_types'] = TestingCategory::where(['is_active' => true])->get();
        // $data['reagents'] = Reagent::where(['is_active' => true, 'testing_category_id' => $this->test_type_id])->get();
        $data['storageMgts'] = FvStockManagement::where('visit_id', $this->active_visit->id)->with('reagent')->get();

        // $items = FvStockManagement::where('visit_id', $this->active_visit->id)->orderBy('id', 'asc')->limit(5)->pluck('reagent_id')->toArray();
        $data['reviews'] = FvOrderReview::where('visit_id', $this->active_visit->id)->with('reagent')->get();
        // $data['orderItems'] = Reagent::where(['is_active' => true])->whereIn('id', $items)->get();

        // $data['platforms'] = LabPlatform::where('is_active', true)->get();
        $data['functionalities'] = FvEquipmentFunctionality::where('visit_id', $this->active_visit->id)->get();
        $data['utilizations']    = FvEquipmentUtilization::where('visit_id', $this->active_visit->id)->get();

        $data['dcTools'] = LisDataCollectionTool::where('is_active', true)->get();
        // $data['reports'] = FilledReport::where('is_active', true)->get();
        // $data['stockItems'] = StockItem::where('is_active', true)->get();
        $data['dcToolScores']     = FvLisDataToolScore::where('visit_id', $this->active_visit->id)->with('dcTool')->get();
        $data['lisLabDataUsages'] = FvLisLabDataUse::where('visit_id', $this->active_visit->id)->get();
        $data['filedReports']     = FvReportFilling::where('visit_id', $this->active_visit->id)->with('report')->get();
        $data['services']         = FvCompServiceStatisticsAcc::where('visit_id', $this->active_visit->id)->get();
        $data['stockStatuses']    = FvCompStockStatusAcc::where('visit_id', $this->active_visit->id)->with('stkItem')->get();
        $data['scaledScores']     = $this->scaledScores->toArray();
        // $data['storageTypes'] = FvStorageType::where('is_active', true)->get();

        return view('livewire.facility.visits.facility-visit-view-component', $data);
    }
}

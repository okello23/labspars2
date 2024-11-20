<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Facility\FvSupervisor;
use App\Models\Facility\FacilityVisit;
use App\Models\Facility\Visits\FvAdherence;
use App\Models\Settings\FvLisDataToolScore;
use App\Models\Facility\FvPersonsSupervised;
use App\Models\Facility\Visits\FvOrderReview;
use App\Models\Settings\LisDataCollectionTool;
use App\Models\Facility\Visits\FvLisHmisReport;
use App\Models\Facility\Visits\FvLisLabDataUse;
use App\Models\Facility\Visits\FvReportFilling;
use App\Models\Facility\Visits\FvStockMgtScore;
use App\Models\Facility\Visits\FvOrderManagement;
use App\Models\Facility\Visits\FvStockManagement;
use App\Models\Facility\Visits\FvHygieneManagement;
use App\Models\Facility\Visits\FvStorageManagement;
use App\Models\Facility\Visits\FvCompStockStatusAcc;
use App\Models\Facility\Visits\FvEquipmentManagement;
use App\Models\Facility\Visits\FvEquipmentUtilization;
use App\Models\Facility\Visits\FvCleanlinessManagement;
use App\Models\Facility\Visits\FvEquipmentFunctionality;
use App\Models\Facility\Visits\FvStorageSystemManagement;
use App\Models\Facility\Visits\FvCompServiceStatisticsAcc;
use App\Models\Facility\Visits\FvStoragePracticeManagement;
use App\Models\Facility\Visits\FvStorageConditionManagement;

class GeneralController extends Controller
{
  

    public static function generateVisit($code, PDF $pdf)
    {
        $data['active_visit'] =$active_visit= FacilityVisit::where('visit_code', $code)
        ->with(['facility', 'facility.healthSubDistrict', 'facility.healthSubDistrict.district', 'facility.healthSubDistrict.district.region'])->first();
        $data['consumption_reconciliation'] = $active_visit->consumption_reconciliation ?? null;
        $data['use_stock_cards'] = $active_visit->use_stock_cards ?? 0;
        $data['limsData'] = FvLisHmisReport::where('visit_id', $active_visit->id)->first();
        // firstStepSubmit
        $data['stkScores'] = FvStockMgtScore::where('visit_id', $active_visit->id)->first();
        $data['supervised_persons'] = FvPersonsSupervised::where('visit_id', $active_visit->id)->get();
            $data['supervisors'] = FvSupervisor::where('visit_id', $active_visit->id)->get();
            $data['supply_storages'] = FvStorageManagement::where('visit_id', $active_visit->id)->with('storageType')->get();
            $data['reviews'] = FvOrderReview::where('visit_id', $active_visit->id)->with('reagent')->get();

            $data['functionalities'] = FvEquipmentFunctionality::where('visit_id', $active_visit->id)->get();
            $data['utilizations'] = FvEquipmentUtilization::where('visit_id', $active_visit->id)->get();
      
            $data['dcTools'] = LisDataCollectionTool::where('is_active', true)->get();
            $data['dcToolScores'] = FvLisDataToolScore::where('visit_id', $active_visit->id)->with('dcTool')->get();
            $data['lisLabDataUsages'] = FvLisLabDataUse::where('visit_id', $active_visit->id)->get();
            $data['filedReports'] = FvReportFilling::where('visit_id', $active_visit->id)->with('report')->get();
            $data['services'] = FvCompServiceStatisticsAcc::where('visit_id', $active_visit->id)->get();
            $data['stockStatuses'] = FvCompStockStatusAcc::where('visit_id', $active_visit->id)->with('stkItem')->get();
        
        // secondStepSubmit
        $data['storageMgts'] = FvStockManagement::where('visit_id', $active_visit->id)->with('reagent')->get();
  
        $data['cleanliness'] = FvCleanlinessManagement::where('visit_id', $active_visit->id)->first();
        $data['hygiene'] = FvHygieneManagement::where('visit_id', $active_visit->id)->first();
        $data['condition'] = FvStorageConditionManagement::where('visit_id', $active_visit->id)->first();
        $data['system'] = FvStorageSystemManagement::where('visit_id', $active_visit->id)->first();
        $data['StoragePractices'] = FvStoragePracticeManagement::where('visit_id', $active_visit->id)->first();
        // thirdStepSubmit
        $data['adherence'] = FvAdherence::where('visit_id', $active_visit->id)->first();
        $data['ordering'] = FvOrderManagement::where('visit_id', $active_visit->id)->first();
        // fourthStepSubmit
        $data['equipmentMgt'] = FvEquipmentManagement::where('visit_id', $active_visit->id)->first();
        // return View('livewire.facility.visits.facility-visit-view-component', $data);
        $pdf = $pdf->loadView('livewire.facility.visits.facility-visit-view-component', $data);
        $pdf->setPaper('a4', 'portrait');   //horizontal
        $pdf->getDOMPdf()->set_option('isPhpEnabled', true);
        return  $pdf->stream($code.'.pdf');


        // return $pdf->download($testResult->sample->participant->identity.rand().'.pdf');
    }
  
}

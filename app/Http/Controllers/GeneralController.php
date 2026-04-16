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
use App\Http\Livewire\Dashboard\MainDashboardComponent;

class GeneralController extends Controller
{
    public function generateVisit(Request $request, $code, PDF $pdf)
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
        
        // Stock Management scores
        $stockMgtScores = (new MainDashboardComponent())->stockMgtScores();
        $data['stock_management'] = collect($stockMgtScores)->firstWhere('visit_id', $active_visit->id)['components'] ?? [];
        
        // Storage scores
        $StorageMgtScore = (new MainDashboardComponent())->fvTotalStorageScore();
        $data['storage_management'] = collect($StorageMgtScore)->firstWhere('visit_id', $active_visit->id)['component_scores'] ?? [];
        
        // Order Scores
        $orderMgtScore = (new MainDashboardComponent())->fvTotalOrderMgtScore();
        $data['ordering_management'] = collect($orderMgtScore)->firstWhere('visit_id', $active_visit->id)['component_scores'] ?? []; 

        // Equipment Mgt Scores
        $equipmentMgtScore = (new MainDashboardComponent())->getCombinedEquipmentScores();
        $data['equipment_management'] = collect($equipmentMgtScore)->firstWhere('visit_id', $active_visit->id)['component_scores'] ?? [];
        
        // LIS Mgt Scores
        $lisMgtScore = (new MainDashboardComponent())->fvLisTotalScorePerVisit();
        $data['lis_mgt'] = collect($lisMgtScore)->firstWhere('visit_id', $active_visit->id)['component_scores'] ?? [];

        $data['isPdfExport'] = true;
        $data['spiderGraphImage'] = $this->buildSpiderGraphImage($data);

        // return View('livewire.facility.visits.facility-visit-view-component', $data);
        $pdf = $pdf->loadView('livewire.facility.visits.facility-visit-view-component', $data);
        $pdf->setPaper('a4', 'portrait');   //horizontal
        $pdf->getDOMPdf()->set_option('isPhpEnabled', true);
        if ($request->boolean('download')) {
            return $pdf->download($code . '.pdf');
        }

        return $pdf->stream($code . '.pdf');


        // return $pdf->download($testResult->sample->participant->identity.rand().'.pdf');
    }

    private function buildSpiderGraphImage(array $data): ?string
    {
        if (!extension_loaded('gd')) {
            return null;
        }

        $stockScore = round((collect($data['stock_management'] ?? [])->avg() ?? 0) * 5, 2);
        $storageScore = round((collect($data['storage_management'] ?? [])->avg() ?? 0), 2);
        $orderingScore = round((collect($data['ordering_management'] ?? [])->avg() ?? 0), 2);
        $equipmentScore = round((collect($data['equipment_management'] ?? [])->avg() ?? 0) * 5, 2);

        $lisScores = $data['lis_mgt'] ?? [];
        $lisTotal = ($lisScores['availability_and_use_of_data_tool'] ?? 0)
            + ($lisScores['availability_of_hmis_reports'] ?? 0)
            + ($lisScores['timeliness_of_hmis_reports'] ?? 0)
            + ($lisScores['completeness_and_accuracy_of_hmis105_report'] ?? 0)
            + ($lisScores['lab_data_use'] ?? 0)
            + ($lisScores['report_filing'] ?? 0);
        $lisScore = round(($lisTotal / 6) * 5, 2);

        $values = [
            'Stock Management' => max(min($stockScore, 5), 0),
            'Storage' => max(min($storageScore, 5), 0),
            'Ordering' => max(min($orderingScore, 5), 0),
            'Equipment' => max(min($equipmentScore, 5), 0),
            'LIS' => max(min($lisScore, 5), 0),
        ];

        $width = 1400;
        $height = 1040;
        $image = imagecreatetruecolor($width, $height);

        imageantialias($image, true);

        $white = imagecolorallocate($image, 255, 255, 255);
        $grid = imagecolorallocate($image, 215, 222, 230);
        $axis = imagecolorallocate($image, 185, 194, 204);
        $text = imagecolorallocate($image, 76, 91, 108);
        $blue = imagecolorallocate($image, 40, 116, 166);
        $blueFill = imagecolorallocatealpha($image, 40, 116, 166, 90);
        $point = imagecolorallocate($image, 26, 82, 118);

        imagefill($image, 0, 0, $white);

        $centerX = 540;
        $centerY = 500;
        $radius = 360;
        $steps = 5;
        $axisCount = count($values);
        $angles = [];

        for ($index = 0; $index < $axisCount; $index++) {
            $angles[] = deg2rad(-90 + (($index * 360) / $axisCount));
        }

        for ($step = 1; $step <= $steps; $step++) {
            $ringRadius = (int) round(($radius / $steps) * $step);
            $ringPoints = [];

            foreach ($angles as $angle) {
                $ringPoints[] = (int) round($centerX + cos($angle) * $ringRadius);
                $ringPoints[] = (int) round($centerY + sin($angle) * $ringRadius);
            }

            imagepolygon($image, $ringPoints, $grid);
            imagestring($image, 3, $centerX + 10, (int) round($centerY - $ringRadius - 8), (string) $step, $text);
        }

        foreach ($angles as $index => $angle) {
            $endX = (int) round($centerX + cos($angle) * $radius);
            $endY = (int) round($centerY + sin($angle) * $radius);
            imageline($image, $centerX, $centerY, $endX, $endY, $axis);

            $label = array_keys($values)[$index];
            $labelX = (int) round($centerX + cos($angle) * ($radius + 45));
            $labelY = (int) round($centerY + sin($angle) * ($radius + 20));
            imagestring($image, 5, $labelX - (int) (strlen($label) * 4), $labelY - 7, $label, $text);
        }

        $shapePoints = [];
        foreach (array_values($values) as $index => $value) {
            $distance = $radius * ($value / 5);
            $pointX = (int) round($centerX + cos($angles[$index]) * $distance);
            $pointY = (int) round($centerY + sin($angles[$index]) * $distance);

            $shapePoints[] = $pointX;
            $shapePoints[] = $pointY;
        }

        imagefilledpolygon($image, $shapePoints, $blueFill);
        imagepolygon($image, $shapePoints, $blue);

        foreach (array_chunk($shapePoints, 2) as [$pointX, $pointY]) {
            imagefilledellipse($image, $pointX, $pointY, 12, 12, $point);
            imageellipse($image, $pointX, $pointY, 12, 12, $white);
        }

        ob_start();
        imagepng($image);
        $binaryImage = ob_get_clean();
        imagedestroy($image);

        return $binaryImage ? 'data:image/png;base64,' . base64_encode($binaryImage) : null;
    }
  
}

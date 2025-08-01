<?php
namespace App\Http\Livewire\Dashboard;

use App\Models\District;
use App\Models\Facility\Facility;
use App\Models\Facility\FacilityVisit;
use App\Models\Settings\Region;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MainDashboardComponent extends Component
{
    use WithPagination;

    public $perPage          = 10;
    public $search           = '';
    public $orderBy          = 'id';
    public $orderAsc         = 0;
    public $selectedRegion   = null;
    public $selectedDistrict = null;
    public $dateRange        = 'all';
    public $customStartDate  = null;
    public $customEndDate    = null;

    // Statistics holders
    public $totalVisits       = 0;
    public $pendingVisits     = 0;
    public $completedVisits   = 0;
    public $visitsByStatus    = [];
    public $visitTrends       = [];
    public $regionWiseStats   = [];
    public $equipmentStats    = [];
    public $stockStats        = [];
    public $adherenceScores   = [];
    public $storageConditions = [];
    public $facilityStats     = [];

    //spider graph
 public $categories = [
    'Stock Management',
    'Storage Areas & Lab Facilities Mgt',
    // 'Lab Equipment',
    // 'Ordering',
    // 'Lab Information Systems'
];

public $scoreSets = [
    [
        'label' => 'Visit-1 Score:',
        'data' => [3.2, 2.7, 4, 4.5, 5],
        'color' => 'rgb(255, 169, 99,1)'
    ],
    [
        'label' => 'Visit-2 Score:',
        'data' => [4.0, 3.5, 4.2, 4.8, 4.7],
        'color' => 'rgba(54, 162, 235, 1)'
    ],
    [
        'label' => 'Visit-3 Score:',
        'data' => [4.5, 4.0, 4.6, 5.0, 4.9],
        'color' => 'rgba(75, 192, 192, 1)'
    ]
];


    protected $queryString = [
        'search'           => ['except' => ''],
        'dateRange'        => ['except' => 'all'],
        'selectedRegion'   => ['except' => null],
        'selectedDistrict' => ['except' => null],
    ];

    private function randomColor($index)
{
    $colors = [
        'rgb(255, 169, 99, 1)',      // Visit-1: orange
        'rgba(54, 162, 235, 1)',     // Visit-2: blue
        'rgba(75, 192, 192, 1)',     // Visit-3: teal
        'rgba(153, 102, 255, 1)',    // purple
        'rgba(255, 206, 86, 1)',     // yellow
        'rgba(201, 203, 207, 1)',    // grey
        'rgba(255, 99, 132, 1)',     // red
        'rgba(0, 128, 128, 1)',      // dark teal
        'rgba(0, 191, 255, 1)',      // deep sky blue
        'rgba(255, 105, 180, 1)',    // hot pink
    ];

    return $colors[$index % count($colors)];
}

public function stockMgtScores(): array
{
    $user = auth()->user();
    $visitQuery = $this->query();

    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }

    $visitIds = $visitQuery->pluck('id');

    if ($visitIds->isEmpty()) {
        return [];
    }

    $scores = DB::table('fv_stock_mgt_scores')
        ->select(
            'visit_id',
            'availability_score',
            'stock_card_score',
            'correct_filling_score',
            'physical_agrees_score',
            'amc_well_calculated_score',
            'emr_usage_score'
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {  // Removed $visitId parameter
        $fields = [
            $score->availability_score,
            $score->stock_card_score,
            $score->correct_filling_score,
            $score->physical_agrees_score,
            $score->amc_well_calculated_score,
            $score->emr_usage_score,
        ];

        $validScores = collect($fields)->filter(function ($value) {
            return is_numeric($value);
        });

        $finalScore = $validScores->isNotEmpty()
            ? round(($validScores->avg()) * 5, 2)
            : 0;

        return [
            'visit_id' => $score->visit_id,  // Use actual visit_id from DB
            'label' => 'Visit-' . $score->visit_id . ' Score:',  // Use actual visit_id
            'data' => [$finalScore],
            'color' => $this->randomColor($score->visit_id),
        ];
    })->toArray();
}

public function fvStorageAreaCleanlinessScore() : array {
    $user = auth()->user();
    $visitQuery = $this->query();

    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }

    $visitIds = $visitQuery->pluck('id');

    if ($visitIds->isEmpty()) {
        return [];
    }

    $scores = DB::table('fv_cleanliness_management')
        ->select(
            'visit_id',
            'lab_store_clean',
            'main_store_clean',
            'laboratory_clean',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
            $score->lab_store_clean,
            $score->main_store_clean,
            $score->laboratory_clean,
        ];

          // Filter out nulls or "NA"
       $validScores = collect($fields)->filter(fn($s) => $s != 2);;

       $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;
        
        return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();

}

public function fvHygieneManagementScore() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_hygiene_management')
        ->select(
            'visit_id',
            'running_water',
            'hand_washing_separate',
            'hand_washing_facility',
            'drainage_system',
            'soap_available',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();
    return $scores->map(function ($score) {
        $fields = [
            $score->running_water,
            $score->hand_washing_separate,
            $score->hand_washing_facility,
            $score->drainage_system,
            $score->soap_available,
        ];
        
        // Filter out nulls or "NA"
         $validScores = collect($fields)->filter(function ($score) {
        return $score != 2; // Exclude NA (2)
        });

        $validScores = collect($fields)->filter(fn($s) => $s != 2);

        $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

        return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();
}

public function fvStorageSystemMgtMainLabScore() : array {
    $user = auth()->user();
    $visitQuery = $this->query();

    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }

    $visitIds = $visitQuery->pluck('id');

    if ($visitIds->isEmpty()) {
        return [];
    }

    $scores = DB::table('fv_storage_system_management')
        ->select(
            'visit_id',
            'main_store_shelves',
            'main_store_reagents',
            'main_store_stock_cards',
            'main_store_systematic',
            'main_store_labeled',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
            $score->main_store_shelves,
            $score->main_store_reagents,
            $score->main_store_stock_cards,
            $score->main_store_systematic,
            $score->main_store_labeled,
        ];

   $validScores = collect($fields)->filter(fn($s) => $s != 2);

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();
    
}

public function fvStorageSystemMgtLabStoreScore() : array {
    $user = auth()->user();
    $visitQuery = $this->query();

    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }

    $visitIds = $visitQuery->pluck('id');

    if ($visitIds->isEmpty()) {
        return [];
    }

    $scores = DB::table('fv_storage_system_management')
        ->select(
            'visit_id',
            'lab_store_shelves',
            'lab_store_reagents',
            'lab_store_stock_cards',
            'lab_store_systematic',
            'lab_store_labeled',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
            $score->lab_store_shelves,
            $score->lab_store_reagents,
            $score->lab_store_stock_cards,
            $score->lab_store_systematic,
            $score->lab_store_labeled,
        ];

    $validScores = collect($fields)->filter(fn($s) => $s != 2);

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();
    
}

public function fvOverallStorageSystemScore(): array
{
    $mainScores = $this->fvStorageSystemMgtMainLabScore();  // Should include 'visit_id'
    $labScores = $this->fvStorageSystemMgtLabStoreScore();  // Should include 'visit_id'

    // Index both score sets by visit_id for easier access
    $mainByVisit = collect($mainScores)->keyBy('visit_id');
    $labByVisit  = collect($labScores)->keyBy('visit_id');

    // Merge all unique visit_ids
    $visitIds = $mainByVisit->keys()->merge($labByVisit->keys())->unique()->sort();

    $combinedScores = [];

    foreach ($visitIds as $i => $visitId) {
        $mainScore = $mainByVisit[$visitId]['data'][0] ?? null;
        $labScore  = $labByVisit[$visitId]['data'][0] ?? null;

        $validScores = collect([$mainScore, $labScore])->filter(fn($s) => is_numeric($s));

        $averageScore = $validScores->isNotEmpty()
            ? round($validScores->avg(), 2)
            : 0;

        $combinedScores[] = [
            'visit_id'   => $visitId,
            'label'      => "Visit-$visitId Overall Score",
            'data'       => [$averageScore],
            'color'      => $this->randomColor($i),
            'main_score' => $mainScore,
            'lab_score'  => $labScore,
        ];
    }

    return $combinedScores;
}


public function fvMainLabStorageConditionScore() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_storage_condition_management')
        ->select(
            'visit_id',
            'main_store_pests',
            'main_store_sunlight',
            'main_store_temperature',
            'main_store_lockable',
            'main_temperature_regulated',
            'main_roof_condition',
            'main_sufficient_storage_space',
            'main_fire_safety_equipment_available',
            'main_cold_storage_functional',
            'main_fridge_well_ventilated',
            'main_fridge_used_for_reagents_only',
            'main_containers_securely_capped',
            'main_fridge_temperature_monitored',
            'main_boxes_not_on_floor',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
           $score->main_store_pests,
           $score->main_store_sunlight,
           $score->main_store_temperature,
           $score->main_store_lockable,
           $score->main_temperature_regulated,
           $score->main_roof_condition,
           $score->main_sufficient_storage_space,
           $score->main_fire_safety_equipment_available,
           $score->main_cold_storage_functional,
           $score->main_fridge_well_ventilated,
           $score->main_fridge_used_for_reagents_only,
           $score->main_containers_securely_capped,
           $score->main_fridge_temperature_monitored,
           $score->main_boxes_not_on_floor,
        ];
        // Filter out nulls or "NA"
         $validScores = collect($fields)->filter(fn($s) => $s != 2);

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();
}   

function fvLabStorageConditionScore() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_storage_condition_management')
        ->select(
            'visit_id',
            'lab_store_pests',
            'lab_store_sunlight',
            'lab_store_temperature',
            'lab_store_lockable',
            'lab_temperature_regulated',
            'lab_roof_condition',
            'lab_sufficient_storage_space',
            'lab_fire_safety_equipment_available',
            'lab_cold_storage_functional',
            'lab_fridge_well_ventilated',
            'lab_fridge_used_for_reagents_only',
            'lab_containers_securely_capped',
            'lab_fridge_temperature_monitored',
            'lab_boxes_not_on_floor',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
           $score->lab_store_pests,
           $score->lab_store_sunlight,
           $score->lab_store_temperature,
           $score->lab_store_lockable,
           $score->lab_temperature_regulated,
           $score->lab_roof_condition,
           $score->lab_sufficient_storage_space,
           $score->lab_fire_safety_equipment_available,
           $score->lab_cold_storage_functional,
           $score->lab_fridge_well_ventilated,
           $score->lab_fridge_used_for_reagents_only,
           $score->lab_containers_securely_capped,
           $score->lab_fridge_temperature_monitored,
           $score->lab_boxes_not_on_floor,
        ];
        
        $validScores = collect($fields)->filter(fn($s) => $s != 2);

        $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();
    
}

public function fvOverallStorageConditionScore(): array
{
    $mainScores = $this->fvMainLabStorageConditionScore(); // Should return ['visit_id' => ..., 'data' => [...]]
    $labScores  = $this->fvLabStorageConditionScore();     // Same

    // Index both score sets by visit_id
    $mainByVisit = collect($mainScores)->keyBy('visit_id');
    $labByVisit  = collect($labScores)->keyBy('visit_id');

    // Combine all unique visit_ids
    $visitIds = $mainByVisit->keys()->merge($labByVisit->keys())->unique()->sort();

    $combinedScores = [];

    foreach ($visitIds as $i => $visitId) {
        $mainScore = $mainByVisit[$visitId]['data'][0] ?? null;
        $labScore  = $labByVisit[$visitId]['data'][0] ?? null;

        $validScores = collect([$mainScore, $labScore])->filter(fn($s) => is_numeric($s));

        $averageScore = $validScores->isNotEmpty()
            ? round($validScores->avg(), 2)
            : 0;

        $combinedScores[] = [
            'visit_id'   => $visitId,
            'label'      => "Visit-$visitId Overall Score",
            'data'       => [$averageScore],
            'color'      => $this->randomColor($i),
            'main_score' => $mainScore,
            'lab_score'  => $labScore,
        ];
    }

    return $combinedScores;
}


public function fvMainStoragePracticeManagementScore() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_storage_practice_management')
        ->select(
            'visit_id',
            'main_store_expired_record',
            'main_store_expired_separate',
            'main_store_fefo',
            'main_store_opening_date',
            'main_opened_bottles_have_lids',
            'main_chemicals_properly_labelled',
            'main_flammables_stored_safely',
            'main_corrosives_separated',
            'main_safety_data_sheets_available',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
           $score->main_store_expired_record,
           $score->main_store_expired_separate,
           $score->main_store_fefo,
           $score->main_store_opening_date,
           $score->main_opened_bottles_have_lids,
           $score->main_chemicals_properly_labelled,
           $score->main_flammables_stored_safely,
           $score->main_corrosives_separated,
           $score->main_safety_data_sheets_available,
        ];
       
          $validScores = collect($fields)->filter(fn($s) => $s != 2);

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();
}   


public function fvLabStoragePracticeManagementScore() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_storage_practice_management')
        ->select(
            'visit_id',
            'lab_store_expired_record',
            'lab_store_expired_separate',
            'lab_store_fefo',
            'lab_store_opening_date',
            'lab_opened_bottles_have_lids',
            'lab_chemicals_properly_labelled',
            'lab_flammables_stored_safely',
            'lab_corrosives_separated',
            'lab_safety_data_sheets_available',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
           $score->lab_store_expired_record,
           $score->lab_store_expired_separate,
           $score->lab_store_fefo,
           $score->lab_store_opening_date,
           $score->lab_opened_bottles_have_lids,
           $score->lab_chemicals_properly_labelled,
           $score->lab_flammables_stored_safely,
           $score->lab_corrosives_separated,
           $score->lab_safety_data_sheets_available,
        ];
        // Filter out nulls or "NA"
         $validScores = collect($fields)->filter(fn($s) => $s != 2);

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();
}   

public function fvOverallStoragePracticeManagementScore(): array
{
    $mainScores = $this->fvMainStoragePracticeManagementScore(); // Must include 'visit_id'
    $labScores  = $this->fvLabStoragePracticeManagementScore();  // Must include 'visit_id'

    // Index both sets by visit_id for merging
    $mainByVisit = collect($mainScores)->keyBy('visit_id');
    $labByVisit  = collect($labScores)->keyBy('visit_id');

    // Merge and get all unique visit_ids
    $visitIds = $mainByVisit->keys()->merge($labByVisit->keys())->unique()->sort();

    $combinedScores = [];

    foreach ($visitIds as $i => $visitId) {
        $mainScore = $mainByVisit[$visitId]['data'][0] ?? null;
        $labScore  = $labByVisit[$visitId]['data'][0] ?? null;

        $validScores = collect([$mainScore, $labScore])->filter(fn($s) => is_numeric($s));

        $averageScore = $validScores->isNotEmpty()
            ? round($validScores->avg(), 2)
            : 0;

        $combinedScores[] = [
            'visit_id'   => $visitId,
            'label'      => "Visit-$visitId Overall Score",
            'data'       => [$averageScore],
            'color'      => $this->randomColor($i),
            'main_score' => $mainScore,
            'lab_score'  => $labScore,
        ];
    }

    return $combinedScores;
}

public function fvTotalStorageScore(): array
{
    // Define all component score functions
    $componentFunctions = [
        'fvOverallStorageConditionScore',
        'fvOverallStoragePracticeManagementScore',
        'fvOverallStorageSystemScore',
        'fvStorageAreaCleanlinessScore',
        'fvHygieneManagementScore'
    ];

    // Initialize collection by visit_id
    $allScoresByVisitId = [];

    foreach ($componentFunctions as $function) {
        $scores = $this->$function();

        foreach ($scores as $score) {
            $visitId = $score['visit_id'] ?? null;
            if ($visitId === null) continue;

            if (!isset($allScoresByVisitId[$visitId])) {
                $allScoresByVisitId[$visitId] = [
                    'scores' => [],
                    'color' => $score['color'] ?? $this->randomColor($visitId),
                ];
            }

            $allScoresByVisitId[$visitId]['scores'][] = $score['data'][0] ?? 0;
        }
    }

    $numberOfFunctions = count($componentFunctions);
    $result = [];

    foreach ($allScoresByVisitId as $visitId => $data) {
        $visitScores = $data['scores'];
        $paddedScores = array_pad($visitScores, $numberOfFunctions, 0);

        $totalScore = array_sum($paddedScores) / $numberOfFunctions * 5;
        $roundedScore = round($totalScore, 2);

        $result[] = [
            'visit_id' => $visitId,
            'label' => "Visit-$visitId Total Score (0-5)",
            'score' => [$roundedScore],
            'color' => $data['color'],
            'component_scores' => [
                'storage_condition'      => ($paddedScores[0] ?? 0) * 5,
                'practice_management'    => ($paddedScores[1] ?? 0) * 5,
                'storage_system'         => ($paddedScores[2] ?? 0) * 5,
                'cleanliness'            => ($paddedScores[3] ?? 0) * 5,
                'hygiene'                => ($paddedScores[4] ?? 0) * 5,
            ],
        ];
    }

    return $result;
}

public function fvOrderManagement() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_order_management')
        ->select(
            'visit_id',
            'cycles_filed_stored',
            'electronic_submission',
            'qty_to_order_score',
            'test_menu_available',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
           $score->cycles_filed_stored,
           $score->electronic_submission,
           $score->qty_to_order_score,
           $score->test_menu_available,
        ];
        // Filter out nulls or "NA"
       $validScores = collect($fields)->filter(fn($s) => $s != 2);

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();
}   


public function fvAdherenceToOrderPracticesManagement() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_adherences')
        ->select(
            'visit_id',
            'ordering_timely',
            'delivery_on_time',
            'annual_procurement_plan',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
           $score->ordering_timely,
           $score->delivery_on_time,
           $score->annual_procurement_plan,
        ];
        // Filter out nulls or "NA"
        $validScores = collect($fields)->filter(fn($s) => $s != 2);

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();
}   
public function fvTotalOrderMgtScore(): array
{
    // Define component score functions
    $componentFunctions = [
        'fvOrderManagement',
        'fvAdherenceToOrderPracticesManagement',
    ];

    $scoresByVisit = [];

    foreach ($componentFunctions as $function) {
        $scores = $this->$function();

        foreach ($scores as $score) {
            $visitId = $score['visit_id'] ?? null;

            // Fallback using label if visit_id missing
            if ($visitId === null && isset($score['label'])) {
                preg_match('/Visit-(\d+)/', $score['label'], $matches);
                $visitId = $matches[1] ?? null;
            }

            if ($visitId === null) {
                continue;
            }

            if (!isset($scoresByVisit[$visitId])) {
                $scoresByVisit[$visitId] = [];
            }

            $scoresByVisit[$visitId][] = $score['data'][0] ?? 0;
        }
    }

    $numberOfFunctions = count($componentFunctions);
    $result = [];

    foreach ($scoresByVisit as $visitId => $visitScores) {
        // Ensure exactly N scores per visit
        $paddedScores = array_pad($visitScores, $numberOfFunctions, 0);
        $totalScore = array_sum($paddedScores) / $numberOfFunctions * 5;
        $roundedScore = round($totalScore, 2);

        $result[] = [
            'visit_id' => $visitId,
            'label' => "Visit-$visitId Total Score (0-5)",
            'score' => [$roundedScore],
            'component_scores' => [
                'order_mgt' => ($paddedScores[0] ?? 0) * 5,
                'adherence_to_order_practice' => ($paddedScores[1] ?? 0) * 5,
            ],
        ];
    }

    return $result;
}
public function fvEquipmentManagementScore(): array {
    $user = auth()->user();
    $visitQuery = $this->query();

    // Default to user's Institution if no region/district filter
    if ($user && $user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }

    $visitIds = $visitQuery->pluck('id');

    if ($visitIds->isEmpty()) {
        return [];
    }

    $scores = DB::table('fv_equipment_management')
        ->select(
            'visit_id',
            'inventory_log_available',
            'inventory_log_updated',
            'service_info_available',
            'equipment_serviced',
            'iqc_performed',
            'operator_manuals_available'
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
            $score->inventory_log_available,
            $score->inventory_log_updated,
            $score->service_info_available,
            $score->equipment_serviced,
            $score->iqc_performed,
            $score->operator_manuals_available,
        ];

        // Filter out values where score is "NA" (i.e., 2)
        $validScores = collect($fields)->filter(fn($s) => $s != 2);

        $finalScore = $validScores->isNotEmpty()
            ? round($validScores->avg(), 2)
            : 0;

        return [
            'visit_id' => $score->visit_id,
            'label'    => 'Visit-' . $score->visit_id . ' Score:',
            'data'     => [$finalScore],
        ];
    })->toArray();
}

public function fvEquipmentUtilizationScores(): array {
    $user = auth()->user();
    $visitQuery = $this->query();

    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }

    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }

    // Step 1: Group by visit_id and equipment_type
    $equipmentTypeScores = DB::table('fv_equipment_utilizations')
        ->select(
            'visit_id',
            'equipment_type',
            DB::raw('SUM(greater_score) as sum_greater'),
            DB::raw('SUM(final_score) as sum_final')
        )
        ->whereIn('visit_id', $visitIds)
        ->groupBy('visit_id', 'equipment_type')
        ->get()
        ->groupBy('visit_id'); // Group entire result by visit_id for processing

  // Step 2: Compute final score per visit
    $results = $equipmentTypeScores->map(function ($equipTypes, $visitId) {
        $categoryScores = $equipTypes->map(function ($row) {
            return ($row->sum_greater + $row->sum_final) / 2;
        });

        // Get actual count of categories instead of hardcoding 4
        $categoryCount = $categoryScores->count();
        $finalScore = $categoryCount > 0 
            ? round($categoryScores->sum() / $categoryCount, 2)
            : 0;

        return [
            'visit_id' => $visitId,
            'label' => 'Visit-' . $visitId . ' Equipment Score:',
            'data' => [$finalScore],
        ];
    })->values();

    return $results->toArray();
}


public function getCombinedEquipmentScores(): array {
    $managementScores = $this->fvEquipmentManagementScore();
    $utilizationScores = $this->fvEquipmentUtilizationScores();

    $combined = [];

    // Helper to extract visit number
    $extractVisitId = function ($label) {
        preg_match('/Visit-(\d+)/', $label, $matches);
        return $matches[1] ?? null;
    };

    // Load management scores into array
    foreach ($managementScores as $entry) {
        $visitId = $extractVisitId($entry['label']);
        if ($visitId !== null) {
            $combined[$visitId]['management'] = $entry['data'][0];
        }
    }

    // Load utilization scores into array
    foreach ($utilizationScores as $entry) {
        $visitId = $extractVisitId($entry['label']);
        if ($visitId !== null) {
            $combined[$visitId]['utilization'] = $entry['data'][0];
        }
    }

    // Compute average per visit
    $final = [];
    foreach ($combined as $visitId => $scores) {
        $management = $scores['management'] ?? null;
        $utilization = $scores['utilization'] ?? 0;

        $availableScores = collect([$management, $utilization])->filter(fn($v) => $v !== null);
        $averageScore = $availableScores->isNotEmpty()
            ? round($availableScores->avg()*5, 2)
            : 0;

        $final[] = [
            'visit_id' => $visitId,
            'label' => "Visit-$visitId Combined Score:",
            'data' => [$averageScore],
        ];
    }

    return $final;
}


public function fvLisDataToolScores() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_lis_data_tool_scores')
        ->select(
            'visit_id',
            'dct_availability_score',
            'dct_usage_score'
        )
         ->whereIn('visit_id', $visitIds)
        ->groupBy('visit_id', 'tool_id')
        ->get()
        ->groupBy('visit_id'); // Group entire result by visit_id for processing
    return $scores->map(function ($groupedScores, $visitId) {
    // Flatten all scores from the group into a single array of the two columns
    $fields = collect($groupedScores)->flatMap(function ($row) {
        return [
            $row->dct_availability_score,
            $row->dct_usage_score,
        ];
    });

    // Filter out values equal to 2 (i.e., "NA")
    $validScores = $fields->filter(function ($value) {
        return $value != 2;
    });

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
         'visit_id' => $visitId,
        'label' => 'Visit-' . $visitId . ' lis_stock_status_scores:',
        'data' => [$finalScore],
    ];
})->values()->toArray(); // Reset keys if needed
}

public function fvLisHmisScores() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_lis_hmis_reports')
        ->select(
            'visit_id',
            'hmis_105_outpatient_report',
            'hmis_105_previous_months',
            't_reports_submitted_to_district',
            't_reports_submitted_on_time',
            'hmis_section_6_complete',
            'hmis_section_10_complete',
        )
        ->whereIn('visit_id', $visitIds)
        ->orderBy('visit_id')
        ->get();

    return $scores->map(function ($score) {
        $fields = [
          $score->hmis_105_outpatient_report,
          $score->hmis_105_previous_months,
          $score->t_reports_submitted_to_district,
          $score->t_reports_submitted_on_time,
          $score->hmis_section_6_complete,
          $score->hmis_section_10_complete,
        ];
        // Filter out nulls or "NA"
         $validScores = collect($fields)->filter(fn($s) => $s != 2);

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
        'visit_id' => $score->visit_id,
        'label'    => 'Visit-' . $score->visit_id . ' Score:',
        'data'     => [$finalScore],
        'color'    => $this->randomColor($score->visit_id),
    ];
})->toArray();
}

public function fvLisCompStockStatusScores() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_comp_stock_status_accs')
        ->select(
            'visit_id',
            'c_reports_available',
            'c_report_sc_agree'
        )
         ->whereIn('visit_id', $visitIds)
        ->groupBy('visit_id', 'stock_item_id')
        ->get()
        ->groupBy('visit_id'); // Group entire result by visit_id for processing
    return $scores->map(function ($groupedScores, $visitId) {
    // Flatten all scores from the group into a single array of the two columns
    $fields = collect($groupedScores)->flatMap(function ($row) {
        return [
            $row->c_reports_available,
            $row->c_report_sc_agree,
        ];
    });

    // Filter out values equal to 2 (i.e., "NA")
    $validScores = $fields->filter(function ($value) {
        return $value != 2;
    });

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
         'visit_id' => $visitId,
        'label' => 'Visit-' . $visitId . ' lis_stock_status_scores:',
        'data' => [$finalScore],
    ];
})->values()->toArray(); // Reset keys if needed
}

    public function fvLisCompServiceStatsScores() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_comp_service_statistics_accs')
        ->select(
            'visit_id',
           'service_name',
           'service_statistics_available',
           'hims_lab_tests_balance',
        )
         ->whereIn('visit_id', $visitIds)
        ->groupBy('visit_id', 'service_name')
        ->get()
        ->groupBy('visit_id'); // Group entire result by visit_id for processing

    return $scores->map(function ($groupedScores, $visitId) {
    // Flatten all scores from the group into a single array of the two columns
    $fields = collect($groupedScores)->flatMap(function ($row) {
        return [
            $row->service_statistics_available,
            $row->hims_lab_tests_balance,
        ];
    });

    // Filter out values equal to 2 (i.e., "NA")
    $validScores = $fields->filter(function ($value) {
        return $value != 2;
    });

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
         'visit_id' => $visitId,
        'label' => 'Visit-' . $visitId . ' lis_comp_service_scores:',
        'data' => [$finalScore],
    ];
})->values()->toArray(); // Reset keys if needed
}

    public function fvLisLabDataUseScores() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_lis_lab_data_uses')
        ->select(
            'visit_id',
            'item_name',
            'updated_last_quarter',
            'is_available',
        )
         ->whereIn('visit_id', $visitIds)
        ->groupBy('visit_id', 'item_name')
        ->get()
        ->groupBy('visit_id'); // Group entire result by visit_id for processing

    return $scores->map(function ($groupedScores, $visitId) {
    // Flatten all scores from the group into a single array of the two columns
    $fields = collect($groupedScores)->flatMap(function ($row) {
        return [
            $row->updated_last_quarter,
            $row->is_available,
        ];
    });

    // Filter out values equal to 2 (i.e., "NA")
    $validScores = $fields->filter(function ($value) {
        return $value != 2;
    });

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
         'visit_id' => $visitId,
        'label' => 'Visit-' . $visitId . ' lab_item_uses:',
        'data' => [$finalScore],
    ];
})->values()->toArray(); // Reset keys if needed
}


    public function fvLisReportFillingScores() : array {
    $user = auth()->user();
    $visitQuery = $this->query();
    // Default to user's Institution if no region/district filter
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $visitQuery->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }
    $visitIds = $visitQuery->pluck('id');
    if ($visitIds->isEmpty()) {
        return [];
    }
    $scores = DB::table('fv_report_fillings')
        ->select(
            'visit_id',
            'report_id',
            'filling_score',
        )
         ->whereIn('visit_id', $visitIds)
        ->groupBy('visit_id', 'report_id')
        ->get()
        ->groupBy('visit_id'); // Group entire result by visit_id for processing

    return $scores->map(function ($groupedScores, $visitId) {
    // Flatten all scores from the group into a single array of the two columns
    $fields = collect($groupedScores)->flatMap(function ($row) {
        return [
            $row->filling_score
        ];
    });

    // Filter out values equal to 2 (i.e., "NA")
    $validScores = $fields->filter(function ($value) {
        return $value != 2;
    });

    $finalScore = $validScores->isNotEmpty()
        ? round($validScores->avg(), 2)
        : 0;

    return [
         'visit_id' => $visitId,
        'label' => 'Visit-' . $visitId . ' lis_report_filling:',
        'data' => [$finalScore],
    ];
})->values()->toArray(); // Reset keys if needed
}

public function fvLisTotalScorePerVisit(): array
{
    // Get all component scores
    $scoreSets = [
        $this->fvLisDataToolScores(),
        $this->fvLisHmisScores(),
        $this->fvLisCompStockStatusScores(),
        $this->fvLisCompServiceStatsScores(),
        $this->fvLisLabDataUseScores(),
        $this->fvLisReportFillingScores(),
        // Add more functions here if needed, no need to update the count
    ];

    // Flatten all score entries into one collection
    $allScores = collect($scoreSets)->flatten(1);

    // Group scores by visit_id
    $grouped = $allScores->groupBy('visit_id');

    // Apply dynamic formula per visit
    $finalScores = $grouped->map(function ($items, $visitId) {
        $visitScores = collect($items)->pluck('data')->flatten()->filter(fn($s) => $s !== null);

        $numberOfFunctions = $visitScores->count();

        $finalScore = $numberOfFunctions > 0
            ? round(($visitScores->sum() / $numberOfFunctions) * 5, 2)
            : 0;

        return [
            'visit_id' => $visitId,
            'label'    => "Visit-$visitId total_score (scaled):",
            'data'     => [$finalScore],
        ];
    })->values()->toArray();

    return $finalScores;
}

private function getFacilityNamesByVisit(): array
{
    // Retrieve visit data with facility names and created_at for ordering
    $visits = DB::table('facility_visits as visits')
        ->join('facilities', 'visits.facility_id', '=', 'facilities.id')
        ->select('visits.id as visit_id', 'facilities.name as facility_name','facilities.level', 'visits.created_at')
        ->orderBy('facilities.name')
        ->orderBy('visits.created_at') // or use id if that's the visit sequence
        ->get();

    $facilityVisitCounts = [];
    $labels = [];

    foreach ($visits as $visit) {
        $facilityName = $visit->facility_name;
        $visitId = $visit->visit_id;

        // Track visit count
        if (!isset($facilityVisitCounts[$facilityName])) {
            $facilityVisitCounts[$facilityName] = 1;
        } else {
            $facilityVisitCounts[$facilityName]++;
        }

        $count = $facilityVisitCounts[$facilityName];
        $labels[$visitId] = "$facilityName (V-$count)";
    }

    return $labels; // [visit_id => "Facility Name (V-x)"]
}


public function getSpiderGraphData(): array
{
     $facilityMap = $this->getFacilityNamesByVisit();

    // Get all thematic scores
    $stockScores      = $this->stockMgtScores();
    $storageScores    = $this->fvTotalStorageScore();
    $orderScores      = $this->fvTotalOrderMgtScore();
    $equipmentScores  = $this->getCombinedEquipmentScores();
    $lisScores        = $this->fvLisTotalScorePerVisit();

    // Normalize all scores into [visit_id => score]
   $normalize = function (array $scores, string $key = 'data'): array {
    $normalized = [];

    foreach ($scores as $entry) {
        if (!isset($entry['visit_id']) || !is_numeric($entry['visit_id']) || $entry['visit_id'] <= 0) {
            continue; // ✅ Skip invalid or zero visit_id
        }

        $visitId = (int) $entry['visit_id'];

        $normalized[$visitId] = isset($entry[$key][0]) && is_numeric($entry[$key][0])
            ? (float)$entry[$key][0]
            : 0;
    }

    return $normalized;
};


    $stock     = $normalize($stockScores);
    $storage   = $normalize($storageScores, 'score');
    $ordering  = $normalize($orderScores, 'score');
    $equipment = $normalize($equipmentScores);
    $lis       = $normalize($lisScores);

    // Collect all unique visit IDs
    $visitIds = collect(array_merge(
        array_keys($stock),
        array_keys($storage),
        array_keys($ordering),
        array_keys($equipment),
        array_keys($lis)
    ))->unique()->sort()->values();

    // Build spider chart data structure
    $spiderData = $visitIds->map(function ($visitId) use ($stock, $storage, $ordering, $equipment, $lis, $facilityMap) {
        return [
            'visit_id' => $visitId,
            'label' => $facilityMap[$visitId] ?? "Unknown Facility ($visitId)",
            'data'     => [
                'Stock Management'       => $stock[$visitId] ?? 0,
                'Storage'                => $storage[$visitId] ?? 0,
                'Ordering'               => $ordering[$visitId] ?? 0,
                'Equipment Management'   => $equipment[$visitId] ?? 0,
                'Lab Information System' => $lis[$visitId] ?? 0,
            ],
        ];
    })->toArray();

    return $spiderData;
}


    public function mount()
    {
        $this->loadDashboardData();
    }
    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }
    public function query()
    {
        $user = \Auth()->user();
        $data = FacilityVisit::query()
            ->with(['facility.healthSubDistrict.district.region']);

            // ->when($this->selectedRegion, function ($query) {
            //     $query->whereHas('facility.healthSubDistrict.district', function ($q) {
            //         $q->where('region_id', $this->selectedRegion);
            //     });
            // })

            // ->when($this->selectedDistrict, function ($query) {
            //     $query->whereHas('facility.healthSubDistrict', function ($q) {
            //         $q->where('district_id', $this->selectedDistrict);
            //     });
            // });
             // Filter for user's Institution if no region/district is selected
    if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
        $data->whereHas('facility', function ($q) use ($user) {
            $q->where('facility_id', $user->facility_id);
        });
    }

    // Existing filters
    if ($this->selectedRegion) {
        $data->whereHas('facility.healthSubDistrict.district', function ($q) {
            $q->where('region_id', $this->selectedRegion);
        });
    }

    if ($this->selectedDistrict) {
        $data->whereHas('facility.healthSubDistrict', function ($q) {
            $q->where('district_id', $this->selectedDistrict);
        });
    }

        // Apply date filters
        switch ($this->dateRange) {
            case 'today':
                $data->whereDate('date_of_visit', Carbon::today());
                break;
            case 'week':
                $data->whereBetween('date_of_visit', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $data->whereBetween('date_of_visit', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'custom':
                if ($this->customStartDate && $this->customEndDate) {
                    $data->whereBetween('date_of_visit', [$this->customStartDate, $this->customEndDate]);
                }
                break;
        }
        return $data;
        // Region and District filters

    }
    public function loadDashboardData()
    {

        // Basic Statistics
        $this->totalVisits     = $this->query()->count();
        $this->pendingVisits   = $this->query()->where('status', 'Pending')->count();
        $this->completedVisits = $this->query()->where('status', 'Approved')->count();

        // Visit Status Distribution
        $this->visitsByStatus = $this->query()->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Region-wise Statistics
        $this->regionWiseStats = $this->query()->select('regions.name as regionName','facilities.*','districts.name as districtName', 'health_sub_districts.name as subDistrictName', DB::raw('count(*) as visits'))
            ->join('facilities', 'facility_visits.facility_id', '=', 'facilities.id')
            ->join('health_sub_districts', 'facilities.sub_district_id', '=', 'health_sub_districts.id')
            ->join('districts', 'health_sub_districts.district_id', '=', 'districts.id')
            ->join('regions', 'districts.region_id', '=', 'regions.id')
            ->groupBy('regions.name')
            ->get();

        // Equipment Functionality Statistics
        $this->equipmentStats = DB::table('fv_equipment_functionalities')
            ->select('equipment_type', DB::raw('count(*) as count'))
            ->whereIn('visit_id', $this->query()->pluck('id'))
            ->groupBy('equipment_type')
            ->get();

        // Stock Management Scores (Fixed)
        $this->stockStats = DB::table('fv_stock_mgt_scores')
            ->select(DB::raw('AVG(availability_score) as average_score'))
            ->whereIn('visit_id', $this->query()->pluck('id'))
            ->first()
            ->average_score ?? 0;

        // Visit Trends (Last 12 months)
        $this->visitTrends = $this->query()
            ->selectRaw('count(*) as count')
            ->selectRaw("DATE_FORMAT(date_of_visit, '%M-%Y') month")
            ->selectRaw("DATE_FORMAT(date_of_visit, '%Y-%m') new_date")
            ->where('date_of_visit', '>=', Carbon::now()->subMonths(12))
            ->groupBy(DB::raw("DATE_FORMAT(date_of_visit, '%M-%Y')"))
            ->orderBy(DB::raw("DATE_FORMAT(date_of_visit, '%M-%Y')"))
            ->get();

        // Facility Statistics
        $this->facilityStats = [
            'total'   => Facility::count(),
            'visited' => $this->query()->distinct('facility_id')->count('facility_id'),
            'active'  => Facility::where('is_active', true)->count(),
        ];
    }
    public function loadDashboardData3()
    {
        $query = FacilityVisit::query()
            ->with(['facility.healthSubDistrict.district.region']);

        // Apply date filters
        switch ($this->dateRange) {
            case 'today':
                $this->query()->whereDate('date_of_visit', Carbon::today());
                break;
            case 'week':
                $this->query()->whereBetween('date_of_visit', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $this->query()->whereBetween('date_of_visit', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'custom':
                if ($this->customStartDate && $this->customEndDate) {
                    $this->query()->whereBetween('date_of_visit', [$this->customStartDate, $this->customEndDate]);
                }
                break;
        }

        // Region and District filters
        if ($this->selectedRegion) {
            $this->query()->whereHas('facility.healthSubDistrict.district', function ($q) {
                $q->where('region_id', $this->selectedRegion);
            });
        }

        if ($this->selectedDistrict) {
            $this->query()->whereHas('facility.healthSubDistrict', function ($q) {
                $q->where('district_id', $this->selectedDistrict);
            });
        }

        // Basic Statistics
        $this->totalVisits     = $this->query()->count();
        $this->pendingVisits   = $this->query()->where('status', 'Pending')->count();
        $this->completedVisits = $this->query()->where('status', 'Approved')->count();

        // Visit Status Distribution
        $this->visitsByStatus = $this->query()->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Region-wise Statistics
        $this->regionWiseStats = $this->query()->select('regions.name', DB::raw('count(*) as visits'))
            ->join('facilities', 'facility_visits.facility_id', '=', 'facilities.id')
            ->join('health_sub_districts', 'facilities.sub_district_id', '=', 'health_sub_districts.id')
            ->join('districts', 'health_sub_districts.district_id', '=', 'districts.id')
            ->join('regions', 'districts.region_id', '=', 'regions.id')
            ->groupBy('regions.name')
            ->get();

        // Equipment Functionality Statistics
        $this->equipmentStats = DB::table('fv_equipment_functionalities')
            ->select('equipment_type', DB::raw('count(*) as count'))
            ->whereIn('visit_id', $this->query()->pluck('id'))
            ->groupBy('equipment_type')
            ->get();

        // Stock Management Scores
        $this->stockStats = DB::table('fv_stock_mgt_scores')
            ->select(DB::raw('AVG(availability_score) as average_score'))
            ->whereIn('visit_id', $this->query()->pluck('id'))
            ->first();

        // Visit Trends (Last 12 months)

        $this->visitTrends = $query
            ->selectRaw('count(*) as count')
            ->selectRaw("DATE_FORMAT(date_of_visit, '%M-%Y') month")
            ->selectRaw("DATE_FORMAT(date_of_visit, '%Y-%m') new_date")
            ->where('date_of_visit', '>=', Carbon::now()->subMonths(12))
            ->groupBy(DB::raw("DATE_FORMAT(date_of_visit, '%M-%Y')"))
            ->orderBy(DB::raw("DATE_FORMAT(date_of_visit, '%M-%Y')"))
            ->get();

        // Facility Statistics
        $this->facilityStats = [
            'total'   => Facility::count(),
            'visited' => $this->query()->distinct('facility_id')->count('facility_id'),
            'active'  => Facility::where('is_active', true)->count(),
        ];
    }

    public function updatedDateRange()
    {
        $this->loadDashboardData();
    }

    public function updatedSelectedRegion()
    {
        $this->selectedDistrict = null;
        $this->loadDashboardData();
    }

    public function updatedSelectedDistrict()
    {
        $this->loadDashboardData();
    }

    public function render()
    {
        // dd($this->getSpiderGraphData());
        $regions   = Region::all();
        $districts = $this->selectedRegion ? District::where('region_id', $this->selectedRegion)->get() : collect();

        return view('livewire.dashboard.main-dashboard-component', [
            'regions'   => $regions,
            'districts' => $districts,
        ]);
    }
}

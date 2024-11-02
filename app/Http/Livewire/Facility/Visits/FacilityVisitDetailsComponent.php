<?php

namespace App\Http\Livewire\Facility\Visits;

use App\Models\Facility\FacilityVisit;
use App\Models\Facility\FvPersonsSupervised;
use App\Models\Facility\FvStorageType;
use App\Models\Facility\FvSupervisor;
use App\Models\Facility\Visits\FvAdherence;
use App\Models\Facility\Visits\FvCleanlinessManagement;
use App\Models\Facility\Visits\FvEquipmentFunctionality;
use App\Models\Facility\Visits\FvEquipmentManagement;
use App\Models\Facility\Visits\FvEquipmentUtilization;
use App\Models\Facility\Visits\FvHygieneManagement;
use App\Models\Facility\Visits\FvOrderManagement;
use App\Models\Facility\Visits\FvOrderReview;
use App\Models\Facility\Visits\FvStockManagement;
use App\Models\Facility\Visits\FvStockMgtScore;
use App\Models\Facility\Visits\FvStorageConditionManagement;
use App\Models\Facility\Visits\FvStorageManagement;
use App\Models\Facility\Visits\FvStoragePracticeManagement;
use App\Models\Facility\Visits\FvStorageSystemManagement;
use App\Models\Settings\LabPlatform;
use App\Models\Settings\Reagent;
use App\Models\Settings\TestingCategory;
use Livewire\Component;

class FacilityVisitDetailsComponent extends Component
{
    public $code;

    public $active_visit;

    public $step;

    public $storage_type;

    public $toggleForm = false;

    public $sex;

    public $contact;

    public $email;

    public $name;

    public $profession;

    public $title;

    public $use_stock_cards;

    public $consumption_reconciliation;

    public $storage_type_id;

    public $comment;

    public function mount($code)
    {
        $this->code = $code;
        $this->active_visit = FacilityVisit::where('visit_code', $code)
            ->with(['facility', 'facility.healthSubDistrict', 'facility.healthSubDistrict.district', 'facility.healthSubDistrict.district.region'])->first();
        $this->consumption_reconciliation = $this->active_visit->consumption_reconciliation ?? null;
        $this->use_stock_cards = $this->active_visit->use_stock_cards ?? 0;
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
            'profession' => 'required|string',

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
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public function storeSupervisor()
    {
        $this->validate([
            'name' => 'required|string',
            'contact' => 'required|numeric',
            'email' => 'required|email',
            'title' => 'required|string',

        ]);

        $County = new FvSupervisor();
        $County->visit_id = $this->active_visit->id;
        $County->name = $this->name;
        $County->contact = $this->contact;
        $County->email = $this->email;
        $County->title = $this->title;
        $County->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public function storeStorageType()
    {
        $this->validate([
            'name' => 'nullable|string',
            'comment' => 'required|string',
            'storage_type' => 'required|string',
            'storage_type_id' => 'required|integer',

        ]);

        $County = new FvStorageManagement();
        $County->visit_id = $this->active_visit->id;
        $County->other = $this->name;
        $County->comment = $this->comment;
        $County->entry_type = $this->storage_type;
        $County->storage_type_id = $this->storage_type_id;
        $County->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public function updatedConsumptionReconciliation($value)
    {
        // Check if $value is not empty and if the relationship is valid
        if ($value && $this->active_visit && $this->active_visit->consumption_reconciliation) {
            $this->active_visit->update([
                'consumption_reconciliation' => $value,
            ]);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Comment successfully updated!']);
        }
    }

    public function updatedUseStockCards($value)
    {
        // Check if $value is not empty and if the relationship is valid
        if ($this->active_visit && $this->active_visit->use_stock_cards) {
            $this->active_visit->update([
                'use_stock_cards' => $value,
            ]);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Stock card successfully updated!']);
        }
    }

    public $lab_store_clean;

    public $main_store_clean;

    public $laboratory_clean;

    public $cleanliness_comments;

    public function saveCleanliness()
    {
        $this->validate([
            'cleanliness_comments' => 'required|string',
            'main_store_clean' => 'required|integer',
            'laboratory_clean' => 'required|integer',
            'lab_store_clean' => 'required|integer',

        ]);

        FvCleanlinessManagement::updateOrCreate(
            ['visit_id' => $this->active_visit->id],
            [
                'visit_id' => $this->active_visit->id,
                'lab_store_clean' => $this->lab_store_clean,
                'main_store_clean' => $this->main_store_clean,
                'laboratory_clean' => $this->laboratory_clean,
                'cleanliness_comments' => $this->cleanliness_comments,
            ]
        );
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public $running_water;

    public $hand_washing_separate;

    public $hand_washing_facility;

    public $drainage_system;

    public $soap_available;

    public $hygiene_comments;

    public function saveHygiene()
    {
        $this->validate([
            'hygiene_comments' => 'required|string',
            'hand_washing_separate' => 'required|integer',
            'hand_washing_facility' => 'required|integer',
            'drainage_system' => 'required|integer',
            'soap_available' => 'required|integer',
            'running_water' => 'required|integer',

        ]);

        FvHygieneManagement::updateOrCreate(
            ['visit_id' => $this->active_visit->id],
            [
                'running_water' => $this->running_water,
                'hand_washing_separate' => $this->hand_washing_separate,
                'hand_washing_facility' => $this->hand_washing_facility,
                'drainage_system' => $this->drainage_system,
                'soap_available' => $this->soap_available,
                'hygiene_comments' => $this->hygiene_comments,
            ]
        );
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public $main_store_shelves;

    public $lab_store_shelves;

    public $main_store_reagents;

    public $lab_store_reagents;

    public $main_store_stock_cards;

    public $lab_store_stock_cards;

    public $main_store_systematic;

    public $lab_store_systematic;

    public $main_store_labeled;

    public $lab_store_labeled;

    public $storage_comments;

    public function saveSystemStorage()
    {
        $this->validate([
            'main_store_shelves' => 'required|integer',
            'lab_store_shelves' => 'required|integer',
            'main_store_reagents' => 'required|integer',
            'lab_store_reagents' => 'required|integer',
            'main_store_stock_cards' => 'required|integer',
            'lab_store_stock_cards' => 'required|integer',
            'main_store_systematic' => 'required|integer',
            'lab_store_systematic' => 'required|integer',
            'main_store_labeled' => 'required|integer',
            'lab_store_labeled' => 'required|integer',
            'storage_comments' => 'required|string',

        ]);

        FvStorageSystemManagement::updateOrCreate(
            ['visit_id' => $this->active_visit->id],
            [
                'main_store_shelves' => $this->main_store_shelves,
                'lab_store_shelves' => $this->lab_store_shelves,
                'main_store_reagents' => $this->main_store_reagents,
                'lab_store_reagents' => $this->lab_store_reagents,
                'main_store_stock_cards' => $this->main_store_stock_cards,
                'lab_store_stock_cards' => $this->lab_store_stock_cards,
                'main_store_systematic' => $this->main_store_systematic,
                'lab_store_systematic' => $this->lab_store_systematic,
                'main_store_labeled' => $this->main_store_labeled,
                'lab_store_labeled' => $this->lab_store_labeled,
                'storage_comments' => $this->storage_comments,
            ]
        );
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public $main_store_pests;

    public $lab_store_pests;

    public $main_store_sunlight;

    public $lab_store_sunlight;

    public $main_store_temperature;

    public $lab_store_temperature;

    public $main_store_lockable;

    public $lab_store_lockable;

    public $condition_comments;

    public function saveStorageCondition()
    {
        $this->validate([
            'main_store_pests' => 'required|integer',
            'lab_store_pests' => 'required|integer',
            'main_store_sunlight' => 'required|integer',
            'lab_store_sunlight' => 'required|integer',
            'main_store_temperature' => 'required|integer',
            'lab_store_temperature' => 'required|integer',
            'main_store_lockable' => 'required|integer',
            'lab_store_lockable' => 'required|integer',
            'condition_comments' => 'required|string',

        ]);

        FvStorageConditionManagement::updateOrCreate(
            ['visit_id' => $this->active_visit->id],
            [
                'main_store_pests' => $this->main_store_pests,
                'lab_store_pests' => $this->lab_store_pests,
                'main_store_sunlight' => $this->main_store_sunlight,
                'lab_store_sunlight' => $this->lab_store_sunlight,
                'main_store_temperature' => $this->main_store_temperature,
                'lab_store_temperature' => $this->lab_store_temperature,
                'main_store_lockable' => $this->main_store_lockable,
                'lab_store_lockable' => $this->lab_store_lockable,
                'condition_comments' => $this->condition_comments,
            ]
        );
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public $main_store_expired_record;

    public $lab_store_expired_record;

    public $main_store_expired_separate;

    public $lab_store_expired_separate;

    public $main_store_fefo;

    public $lab_store_fefo;

    public $main_store_opening_date;

    public $lab_store_opening_date;

    public $practices_comments;

    public function saveStoragePractices()
    {
        $this->validate([
            'main_store_expired_record' => 'required|integer',
            'lab_store_expired_record' => 'required|integer',
            'main_store_expired_separate' => 'required|integer',
            'lab_store_expired_separate' => 'required|integer',
            'main_store_fefo' => 'required|integer',
            'lab_store_fefo' => 'required|integer',
            'main_store_opening_date' => 'required|integer',
            'lab_store_opening_date' => 'required|integer',
            'practices_comments' => 'required|string',

        ]);

        FvStoragePracticeManagement::updateOrCreate(
            ['visit_id' => $this->active_visit->id],
            [
                'main_store_expired_record' => $this->main_store_expired_record,
                'lab_store_expired_record' => $this->lab_store_expired_record,
                'main_store_expired_separate' => $this->main_store_expired_separate,
                'lab_store_expired_separate' => $this->lab_store_expired_separate,
                'main_store_fefo' => $this->main_store_fefo,
                'lab_store_fefo' => $this->lab_store_fefo,
                'main_store_opening_date' => $this->main_store_opening_date,
                'lab_store_opening_date' => $this->lab_store_opening_date,
                'practices_comments' => $this->practices_comments,

            ]
        );
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public function firstStepSubmit()
    {
        $this->validate([
            'consumption_reconciliation' => 'required|string',
        ]);
        $this->active_visit->consumption_reconciliation = $this->consumption_reconciliation;
        $this->active_visit->update();
        $this->step = 2;

        $stkScores = FvStockMgtScore::where('visit_id', $this->active_visit->id)->first();
        // dd($stkScores);
        $this->availability_score = $stkScores->availability_score ?? null;
        $this->availability_percentage = $stkScores->availability_percentage ?? null;
        $this->stock_card_score = $stkScores->stock_card_score ?? null;
        $this->stock_card_percentage = $stkScores->stock_card_percentage ?? null;
        $this->correct_filling_score = $stkScores->correct_filling_score ?? null;
        $this->correct_filling_percentage = $stkScores->correct_filling_percentage ?? null;
        $this->physical_agrees_score = $stkScores->physical_agrees_score ?? null;
        $this->physical_agrees_percentage = $stkScores->physical_agrees_percentage ?? null;
        $this->amc_well_calculated_score = $stkScores->amc_well_calculated_score ?? null;
        $this->amc_well_calculated_percentage = $stkScores->amc_well_calculated_percentage ?? null;
        $this->emr_usage_score = $stkScores->emr_usage_score ?? null;
        $this->emr_usage_percentage = $stkScores->emr_usage_percentage ?? null;
        $this->stock_mgt_comments = $stkScores->stock_mgt_comments ?? null;

    }

    public function secondStepSubmit()
    {

        $this->saveStkMgtScore();
        $this->step = 3;
        $cleanliness = FvCleanlinessManagement::where('visit_id', $this->active_visit->id)->first();
        $this->lab_store_clean = $cleanliness->lab_store_clean ?? null;
        $this->main_store_clean = $cleanliness->main_store_clean ?? null;
        $this->laboratory_clean = $cleanliness->laboratory_clean ?? null;
        $this->cleanliness_comments = $cleanliness->cleanliness_comments ?? null;

        $hygiene = FvHygieneManagement::where('visit_id', $this->active_visit->id)->first();
        $this->running_water = $hygiene->running_water ?? null;
        $this->hand_washing_separate = $hygiene->hand_washing_separate ?? null;
        $this->hand_washing_facility = $hygiene->hand_washing_facility ?? null;
        $this->drainage_system = $hygiene->drainage_system ?? null;
        $this->soap_available = $hygiene->soap_available ?? null;
        $this->hygiene_comments = $hygiene->hygiene_comments ?? null;

        $condition = FvStorageConditionManagement::where('visit_id', $this->active_visit->id)->first();
        $this->main_store_pests = $condition->main_store_pests ?? null;
        $this->lab_store_pests = $condition->lab_store_pests ?? null;
        $this->main_store_sunlight = $condition->main_store_sunlight ?? null;
        $this->lab_store_sunlight = $condition->lab_store_sunlight ?? null;
        $this->main_store_temperature = $condition->main_store_temperature ?? null;
        $this->lab_store_temperature = $condition->lab_store_temperature ?? null;
        $this->main_store_lockable = $condition->main_store_lockable ?? null;
        $this->lab_store_lockable = $condition->lab_store_lockable ?? null;
        $this->condition_comments = $condition->condition_comments ?? null;

        $system = FvStorageSystemManagement::where('visit_id', $this->active_visit->id)->first();
        $this->main_store_shelves = $system->main_store_shelves ?? null;
        $this->lab_store_shelves = $system->lab_store_shelves ?? null;
        $this->main_store_reagents = $system->main_store_reagents ?? null;
        $this->lab_store_reagents = $system->lab_store_reagents ?? null;
        $this->main_store_stock_cards = $system->main_store_stock_cards ?? null;
        $this->lab_store_stock_cards = $system->lab_store_stock_cards ?? null;
        $this->main_store_systematic = $system->main_store_systematic ?? null;
        $this->lab_store_systematic = $system->lab_store_systematic ?? null;
        $this->main_store_labeled = $system->main_store_labeled ?? null;
        $this->lab_store_labeled = $system->lab_store_labeled ?? null;
        $this->storage_comments = $system->storage_comments ?? null;

        $StoragePractices = FvStoragePracticeManagement::where('visit_id', $this->active_visit->id)->first();
        $this->main_store_expired_record = $StoragePractices->main_store_expired_record ?? null;
        $this->lab_store_expired_record = $StoragePractices->lab_store_expired_record ?? null;
        $this->main_store_expired_separate = $StoragePractices->main_store_expired_separate ?? null;
        $this->lab_store_expired_separate = $StoragePractices->lab_store_expired_separate ?? null;
        $this->main_store_fefo = $StoragePractices->main_store_fefo ?? null;
        $this->lab_store_fefo = $StoragePractices->lab_store_fefo ?? null;
        $this->main_store_opening_date = $StoragePractices->main_store_opening_date ?? null;
        $this->lab_store_opening_date = $StoragePractices->lab_store_opening_date ?? null;
        $this->practices_comments = $StoragePractices->practices_comments ?? null;

    }

    public $cycles_filed_stored;

    public $cycles_filed_comments;

    public $electronic_submission;

    public $electronic_submission_comments;

    public $soh;

    public $quantity_issued;

    public $days_out_of_stock;

    public $adjusted_amc;

    public $max_quantity;

    public $quantity_to_order;

    public $test_menu_available;

    // public $annual_procurement_plan;

    // public $procurement_plan_comments;

    // public $adherence_percentage;

    // public $adherence_score;

    public $qty_to_order_score;

    public $response_score;

    public $response_percentage;

    public $plan_score;

    public $plan_percentage;

    public $item;

    public $quantity_ordered;

    public $quantity_received;

    public $fulfillment_rate;

    public function updatedQuantityOrdered()
    {
        $this->updatedQuantityReceived();
    }

    public function updatedQuantityReceived()
    {
        if (is_numeric($this->quantity_ordered) && is_numeric($this->quantity_received)) {
            $x = $this->quantity_received / $this->quantity_ordered;
            $this->fulfillment_rate = round($x * 100, 2);
        }
    }

    public function saveOrderReview()
    {
        $this->validate([
            'item' => 'required|string',
            'quantity_ordered' => 'required|numeric',
            'quantity_received' => 'required|numeric',
            'fulfillment_rate' => 'required|numeric',

        ]);

        FvOrderReview::create(
            [
                'visit_id' => $this->active_visit->id,
                'item' => $this->item,
                'quantity_ordered' => $this->quantity_ordered,
                'quantity_received' => $this->quantity_received,
                'fulfillment_rate' => $this->fulfillment_rate,
            ]
        );
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public $ordering_schedule_deadline;

    public $actual_ordering_date;

    public $ordering_timely;

    public $delivery_schedule_deadline;

    public $delivery_date;

    public $delivery_on_time;

    public $adherence_comments;

    public $adherence_score;

    public $procurement_plan_comments;

    public $adherence_percentage;

    public $annual_procurement_plan;

    public function saveOrdering()
    {
        $this->validate([
            'cycles_filed_comments' => 'required',
            'cycles_filed_stored' => 'required',
            'electronic_submission' => 'required',
            'electronic_submission_comments' => 'required',
            'soh' => 'required',
            'quantity_issued' => 'required',
            'days_out_of_stock' => 'required',
            'adjusted_amc' => 'required',
            'max_quantity' => 'required',
            'quantity_to_order' => 'required',
            'test_menu_available' => 'required',
            'qty_to_order_score' => 'required',

            'ordering_schedule_deadline' => 'required',
            'actual_ordering_date' => 'required',
            'ordering_timely' => 'required',
            'delivery_schedule_deadline' => 'required',
            'delivery_date' => 'required',
            'delivery_on_time' => 'required',
            // 'adherence_comments' => 'required',
            // 'adherence_score'=>'required',
            // 'adherence_percentage' => 'required',
            'annual_procurement_plan' => 'required',
            'procurement_plan_comments' => 'required',

        ]);

        $order = FvOrderManagement::updateOrCreate(
            ['visit_id' => $this->active_visit->id],
            [
                'cycles_filed_stored' => $this->cycles_filed_stored,
                'cycles_filed_comments' => $this->cycles_filed_comments,
                'electronic_submission' => $this->electronic_submission,
                'electronic_submission_comments' => $this->electronic_submission_comments,
                'soh' => $this->soh,
                'quantity_issued' => $this->quantity_issued,
                'days_out_of_stock' => $this->days_out_of_stock,
                'adjusted_amc' => $this->adjusted_amc,
                'max_quantity' => $this->max_quantity,
                'quantity_to_order' => $this->quantity_to_order,
                'test_menu_available' => $this->test_menu_available,
                'qty_to_order_score' => $this->qty_to_order_score,
            ]);

        // dd($this->delivery_on_time);
        $add = FvAdherence::updateOrCreate(
            ['visit_id' => $this->active_visit->id],
            [
                'ordering_schedule_deadline' => $this->ordering_schedule_deadline,
                'actual_ordering_date' => $this->actual_ordering_date,
                'ordering_timely' => $this->ordering_timely,
                'delivery_schedule_deadline' => $this->delivery_schedule_deadline,
                'delivery_date' => $this->delivery_date,
                'delivery_on_time' => $this->delivery_on_time,
                'adherence_comments' => $this->adherence_comments,
                'adherence_score' => $this->adherence_score,
                'adherence_percentage' => $this->adherence_percentage,
                'annual_procurement_plan' => $this->annual_procurement_plan,
                'procurement_plan_comments' => $this->procurement_plan_comments]);
        // dd( $add );
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Adherence successfully added!']);
        if ($order && $add) {

            $this->step = 5;
        }

    }

    public function thirdStepSubmit()
    {

        $this->saveSystemStorage();
        $this->saveStorageCondition();
        $this->saveStoragePractices();
        $this->saveHygiene();
        $this->saveCleanliness();
        $this->step = 4;
        $ordering = FvOrderManagement::where('visit_id', $this->active_visit->id)->first();

        $this->cycles_filed_stored = $ordering->cycles_filed_stored ?? null;
        $this->cycles_filed_comments = $ordering->cycles_filed_comments ?? null;
        $this->electronic_submission = $ordering->electronic_submission ?? null;
        $this->electronic_submission_comments = $ordering->electronic_submission_comments ?? null;
        $this->soh = $ordering->soh ?? null;
        $this->quantity_issued = $ordering->quantity_issued ?? null;
        $this->days_out_of_stock = $ordering->days_out_of_stock ?? null;
        $this->adjusted_amc = $ordering->adjusted_amc ?? null;
        $this->max_quantity = $ordering->max_quantity ?? null;
        $this->quantity_to_order = $ordering->quantity_to_order ?? null;
        $this->test_menu_available = $ordering->test_menu_available ?? null;
        $this->qty_to_order_score = $ordering->qty_to_order_score ?? null;

        $adherence = FvAdherence::where('visit_id', $this->active_visit->id)->first();
        // dd($adherence);
        $this->ordering_schedule_deadline = $adherence->ordering_schedule_deadline ?? null;
        $this->actual_ordering_date = $adherence->actual_ordering_date ?? null;
        $this->ordering_timely = $adherence->ordering_timely ?? null;
        $this->delivery_schedule_deadline = $adherence->delivery_schedule_deadline ?? null;
        $this->delivery_date = $adherence->delivery_date ?? null;
        $this->delivery_on_time = $adherence->delivery_on_time ?? null;
        $this->adherence_comments = $adherence->adherence_comments ?? null;
        $this->adherence_score = $adherence->adherence_score ?? null;
        $this->adherence_percentage = $adherence->adherence_percentage ?? null;
        $this->annual_procurement_plan = $adherence->annual_procurement_plan ?? null;
        $this->procurement_plan_comments = $adherence->procurement_plan_comments ?? null;
    }

    public function fourthStepSubmit()
    {

        $this->saveOrdering();
        $equipmentMgt = FvEquipmentManagement::where('visit_id', $this->active_visit->id)->first();
        $this->inventory_log_available = $equipmentMgt->inventory_log_available ?? null;
        $this->inventory_log_updated = $equipmentMgt->inventory_log_updated ?? null;
        $this->service_info_available = $equipmentMgt->service_info_available ?? null;
        $this->equipment_serviced = $equipmentMgt->equipment_serviced ?? null;
        $this->iqc_performed = $equipmentMgt->iqc_performed ?? null;
        $this->operator_manuals_available = $equipmentMgt->operator_manuals_available ?? null;
        $this->equipment_inv_score = $equipmentMgt->equipment_inv_score ?? null;
        $this->equipment_inv_percentage = $equipmentMgt->equipment_inv_percentage ?? null;
        $this->equipment_score = $equipmentMgt->equipment_score ?? null;
        $this->equipment_percentage = $equipmentMgt->equipment_percentage ?? null;
        $this->equipment_mgt_comments = $equipmentMgt->equipment_mgt_comments ?? null;
        $this->equipment_maintenance_comment = $equipmentMgt->equipment_maintenance_comment ?? null;

    }

    public $equipment_id;
    public $equipment_name;
    public $equipment_type;
    public $functional;
    public $downtime;
    public $nonfunctional_hw;
    public $nonfunctional_reagents;
    public $other_factors;
    public $response_time;

    public function updatedEquipmentId()
    {
        $data = LabPlatform::where('id', $this->equipment_id)->first();
        $this->equipment_name = $data->name ?? null;
        $this->equipment_type = $data->type ?? null;

    }
    public function storFunctionality()
    {
        $this->validate([
            'equipment_id' => 'required',
            'equipment_name' => 'required',
            'equipment_type' => 'required',
            'functional' => 'required',
            'downtime' => 'required',
            'nonfunctional_hw' => 'required',
            'nonfunctional_reagents' => 'required',
            'other_factors' => 'required',
            'response_time' => 'required',
        ]);
        $add = FvEquipmentFunctionality::updateOrCreate(
            ['visit_id' => $this->active_visit->id,
                'equipment_id' => $this->equipment_id,
            ],
            [
                'equipment_id' => $this->equipment_id,
                'equipment_name' => $this->equipment_name,
                'equipment_type' => $this->equipment_type,
                'functional' => $this->functional,
                'downtime' => $this->downtime,
                'nonfunctional_hw' => $this->nonfunctional_hw,
                'nonfunctional_reagents' => $this->nonfunctional_reagents,
                'other_factors' => $this->other_factors,
                'response_time' => $this->response_time,
            ]);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);

    }
    public $through_put;
    public $running_days;
    public $actual_output;
    public $utilization;
    public $greater_score;
    public $capacity;
    public $final_score;
    public $expected_output;

    public function updatedExpectedOutput()
    {
        $this->calUtilization();
    }
    public function updatedActualOutput()
    {
        $this->calUtilization();
    }
    public function calUtilization()
    {
        if (is_numeric($this->actual_output) && is_numeric($this->expected_output) && $this->actual_output > 0 && $this->expected_output) {
            $utilization = ($this->actual_output / $this->expected_output) * 100;
            $this->utilization = round($utilization, 2);
            if ($this->utilization > 70) {
                $this->greater_score = 1;
            } else {
                $this->greater_score = 0;
            }
        } else {
            $this->utilization = 0;
            $this->greater_score = null;
        }
    }
    public function updatedCapacity()
    {

        $this->checkScore();
    }
    public function updatedThroughPut()
    {
        $this->checkScore();
    }
    public function checkScore()
    {
        if ($this->capacity == $this->through_put) {
            $this->final_score = 1;
        } else {
            $this->final_score = 0;
        }
    }
    public function storUtilization()
    {
        $this->validate([
            'equipment_id' => 'required',
            'equipment_name' => 'required',
            'equipment_type' => 'required',
            'through_put' => 'required|numeric',
            'running_days' => 'required|numeric',
            'actual_output' => 'required|numeric',
            'utilization' => 'required|numeric',
            'greater_score' => 'required|numeric',
            'capacity' => 'required|numeric',
            'final_score' => 'required|numeric',
            'expected_output' => 'required|numeric',
        ]);
        $add = FvEquipmentUtilization::updateOrCreate(
            ['visit_id' => $this->active_visit->id,
                'equipment_id' => $this->equipment_id,
            ],
            [
                'equipment_id' => $this->equipment_id,
                'equipment_name' => $this->equipment_name,
                'equipment_type' => $this->equipment_type,
                'expected_output' => $this->expected_output,
                'through_put' => $this->through_put,
                'running_days' => $this->running_days,
                'actual_output' => $this->actual_output,
                'utilization' => $this->utilization,
                'greater_score' => $this->greater_score,
                'capacity' => $this->capacity,
                'final_score' => $this->final_score,
            ]);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);

    }
    public $submitted_on_time, $hmis_105_previous_months, $hmis_105_outpatient_report;
    public $visit_id;
    public $reagent_id;
    public $test_performed = false;
    public $item_available = false;
    public $stock_card_available = false;
    public $physical_count_done = false;
    public $stock_card_correct = false;
    public $balance_on_card;
    public $physical_count;
    public $balance_matches_physical = false;
    public $last_issues;
    public $out_of_stock_days;
    public $amc_on_card;
    public $amc_calculated = false;
    public $amc_calculated_matches = false;
    public $elmis_installed = false;
    public $elmis_quantity = 0;
    public $elmis_balance_matches = false;
    public $test_type_id;

    public function StorageSubmit()
    {
        $this->validate([
            'reagent_id' => 'required|exists:reagents,id',
            'test_performed' => 'required',
            'item_available' => 'required',
            'stock_card_available' => 'required',
            'physical_count_done' => 'required',
            'stock_card_correct' => 'required',
            'balance_on_card' => 'nullable|integer',
            'physical_count' => 'nullable|integer',
            'balance_matches_physical' => 'required',
            'last_issues' => 'nullable|integer',
            'out_of_stock_days' => 'nullable|integer',
            'amc_on_card' => 'nullable|integer',
            'amc_calculated' => 'required',
            'amc_calculated_matches' => 'required',
            'elmis_installed' => 'required',
            'elmis_quantity' => 'integer',
            'elmis_balance_matches' => 'required',
        ]);

        // Save the data to the database
        FvStockManagement::updateOrCreate(
            ['visit_id' => $this->active_visit->id,
                'reagent_id' => $this->reagent_id,
            ],
            [
                'reagent_id' => $this->reagent_id,
                'test_performed' => $this->test_performed,
                'item_available' => $this->item_available,
                'stock_card_available' => $this->stock_card_available,
                'physical_count_done' => $this->physical_count_done,
                'stock_card_correct' => $this->stock_card_correct,
                'balance_on_card' => $this->balance_on_card,
                'physical_count' => $this->physical_count,
                'balance_matches_physical' => $this->balance_matches_physical,
                'last_issues' => $this->last_issues,
                'out_of_stock_days' => $this->out_of_stock_days,
                'amc_on_card' => $this->amc_on_card,
                'amc_calculated' => $this->amc_calculated,
                'amc_calculated_matches' => $this->amc_calculated_matches,
                'elmis_installed' => $this->elmis_installed,
                'elmis_quantity' => $this->elmis_quantity,
                'elmis_balance_matches' => $this->elmis_balance_matches,
            ]);

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }
    // Define properties for each field
    public $availability_score;
    public $availability_percentage;
    public $stock_card_score;
    public $stock_card_percentage;
    public $correct_filling_score;
    public $correct_filling_percentage;
    public $physical_agrees_score;
    public $physical_agrees_percentage;
    public $amc_well_calculated_score;
    public $amc_well_calculated_percentage;
    public $emr_usage_score;
    public $emr_usage_percentage;
    public $stock_mgt_comments;

    // Method to store data in the database
    public function saveStkMgtScore()
    {
        $this->validate([
            'availability_score' => 'required|integer',
            'availability_percentage' => 'required|integer',
            'stock_card_score' => 'required|integer',
            'stock_card_percentage' => 'required|integer',
            'correct_filling_score' => 'required|integer',
            'correct_filling_percentage' => 'required|integer',
            'physical_agrees_score' => 'required|integer',
            'physical_agrees_percentage' => 'required|integer',
            'amc_well_calculated_score' => 'required|integer',
            'amc_well_calculated_percentage' => 'required|integer',
            'emr_usage_score' => 'required|integer',
            'emr_usage_percentage' => 'required|integer',
            'stock_mgt_comments' => 'required|string',
        ]); // Validate input data

        FvStockMgtScore::updateOrCreate(
            ['visit_id' => $this->active_visit->id],
            [
                'availability_score' => $this->availability_score,
                'availability_percentage' => $this->availability_percentage,
                'stock_card_score' => $this->stock_card_score,
                'stock_card_percentage' => $this->stock_card_percentage,
                'correct_filling_score' => $this->correct_filling_score,
                'correct_filling_percentage' => $this->correct_filling_percentage,
                'physical_agrees_score' => $this->physical_agrees_score,
                'physical_agrees_percentage' => $this->physical_agrees_percentage,
                'amc_well_calculated_score' => $this->amc_well_calculated_score,
                'amc_well_calculated_percentage' => $this->amc_well_calculated_percentage,
                'emr_usage_score' => $this->emr_usage_score,
                'emr_usage_percentage' => $this->emr_usage_percentage,
                'stock_mgt_comments' => $this->stock_mgt_comments,
            ]);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public $inventory_log_available;
    public $inventory_log_updated;
    public $service_info_available;
    public $equipment_serviced;
    public $iqc_performed;
    public $operator_manuals_available;
    public $equipment_inv_score;
    public $equipment_inv_percentage;
    public $equipment_score;
    public $equipment_percentage;
    public $equipment_mgt_comments;
    public $equipment_maintenance_comment;
    public function fifthStepSubmit()
    {
        $this->validate([

            'inventory_log_available' => 'required|integer',
            'inventory_log_updated' => 'required|integer',
            'service_info_available' => 'required|integer',
            'equipment_serviced' => 'required|integer',
            'iqc_performed' => 'required|integer',
            'operator_manuals_available' => 'required|integer',
            'equipment_inv_score' => 'nullable|integer',
            'equipment_inv_percentage' => 'nullable|integer',
            'equipment_score' => 'nullable|integer',
            'equipment_percentage' => 'nullable|integer',
            'equipment_mgt_comments' => 'required|string',
            'equipment_maintenance_comment' => 'required|string',
        ]);

        FvEquipmentManagement::updateOrCreate(
            ['visit_id' => $this->active_visit->id],
            [
                'inventory_log_available' => $this->inventory_log_available,
                'inventory_log_updated' => $this->inventory_log_updated,
                'service_info_available' => $this->service_info_available,
                'equipment_serviced' => $this->equipment_serviced,
                'iqc_performed' => $this->iqc_performed,
                'operator_manuals_available' => $this->operator_manuals_available,
                'equipment_inv_score' => $this->equipment_inv_score,
                'equipment_inv_percentage' => $this->equipment_inv_percentage,
                'equipment_score' => $this->equipment_score,
                'equipment_percentage' => $this->equipment_percentage,
                'equipment_mgt_comments' => $this->equipment_mgt_comments,
                'equipment_maintenance_comment' => $this->equipment_maintenance_comment,
            ]);
        $this->step = 6;
    }

    public function back($num)
    {
        if ($num == 1) {
            $this->step = 1;
        } elseif ($num == 2) {
            $this->firstStepSubmit();
        } elseif ($num == 3) {
            $this->secondStepSubmit();
        } elseif ($num == 4) {
            $this->step = 4;
        } elseif ($num == 5) {
            $this->step = 5;
        }
    }

    public function resetInputs()
    {
        $this->reset([
            'name',
            'contact',
            'sex',
            'email',
            'profession',
            'title',
            'storage_type_id',
            'comment',
            'item',
            'quantity_ordered',
            'quantity_received',
            'fulfillment_rate',
            'equipment_id',
            'equipment_name',
            'equipment_type',
            'functional',
            'downtime',
            'nonfunctional_hw',
            'nonfunctional_reagents',
            'other_factors',
            'response_time',
            'through_put',
            'running_days',
            'actual_output',
            'utilization',
            'greater_score',
            'capacity',
            'final_score',
            'expected_output',
            'reagent_id',
            'test_performed',
            'item_available',
            'stock_card_available',
            'physical_count_done',
            'stock_card_correct',
            'balance_on_card',
            'physical_count',
            'balance_matches_physical',
            'last_issues',
            'out_of_stock_days',
            'amc_on_card',
            'amc_calculated',
            'amc_calculated_matches',
            'elmis_installed',
            'elmis_quantity',
            'elmis_balance_matches',
        ]);
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function render()
    {
        $data['supervised_persons'] = collect([]);
        $data['supervisors'] = collect([]);
        $data['reviews'] = collect([]);
        $data['functionalities'] = collect([]);
        $data['utilizations'] = collect([]);
        $data['test_types'] = collect([]);
        $data['reagents'] = collect([]);
        $data['platforms'] = collect([]);
        $data['supply_storages'] = collect([]);
        $data['stock_card_storages'] = collect([]);
        $data['storageMgts'] = collect([]);
        if ($this->step == 1) {
            $data['supervised_persons'] = FvPersonsSupervised::where('visit_id', $this->active_visit->id)->get();
            $data['supervisors'] = FvSupervisor::where('visit_id', $this->active_visit->id)->get();
            $data['supply_storages'] = FvStorageManagement::where('visit_id', $this->active_visit->id)->with('storageType')->get();
        }
        if ($this->step == 2) {
            $data['test_types'] = TestingCategory::where(['is_active' => true])->get();
            $data['reagents'] = Reagent::where(['is_active' => true, 'testing_category_id' => $this->test_type_id])->get();
            $data['storageMgts'] = FvStockManagement::where('visit_id', $this->active_visit->id)->with('reagent')->get();
        }
        if ($this->step == 4) {
            $data['reviews'] = FvOrderReview::where('visit_id', $this->active_visit->id)->get();
        }
        if ($this->step == 5) {
            $data['platforms'] = LabPlatform::where('is_active', true)->get();
            $data['functionalities'] = FvEquipmentFunctionality::where('visit_id', $this->active_visit->id)->get();
            $data['utilizations'] = FvEquipmentUtilization::where('visit_id', $this->active_visit->id)->get();
        }
        $data['storageTypes'] = FvStorageType::where('is_active', true)->get();

        return view('livewire.facility.visits.facility-visit-details-component', $data);
    }
}

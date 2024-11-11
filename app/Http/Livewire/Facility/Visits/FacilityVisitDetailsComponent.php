<?php

namespace App\Http\Livewire\Facility\Visits;

use App\Models\Facility\FacilityVisit;
use App\Models\Facility\FvPersonsSupervised;
use App\Models\Facility\FvStorageType;
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
use App\Models\Settings\FilledReport;
use App\Models\Settings\FvLisDataToolScore;
use App\Models\Settings\LabPlatform;
use App\Models\Settings\LisDataCollectionTool;
use App\Models\Settings\Reagent;
use App\Models\Settings\StockItem;
use App\Models\Settings\TestingCategory;
use Illuminate\Database\Eloquent\Model;
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
            public $supervised_count =0;
            public $supervisors_count =0;
            public $supply_storages_count =0;
    public function firstStepSubmit()
    {
        // dd($this->supervised_count);

        if($this->supervised_count<1){
             $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! You can not proceed!',
                'text' => 'At least enter more than one record in the Persons Supervised table!',
            ]);
            return;
        }
        if($this->supervisors_count==0){
             $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! You can not proceed!',
                'text' => 'At least enter more than one record in the supervisors table!',
            ]);
            return;
        }
        if($this->supply_storages_count<1){
             $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! You can not proceed!',
                'text' => 'At least enter more than one record in each supply storage table!',
            ]);
            return;
        }
        $this->validate([
            'consumption_reconciliation' => 'required|string',
        ]);
        $this->active_visit->consumption_reconciliation = $this->consumption_reconciliation;
        $this->active_visit->stage = 'Stock Mgt';
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
        $this->validate([
            'stock_mgt_comments' => 'required|string',
        ]);
        $this->calculateScored();
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
        $this->active_visit->stage->update(['stage'=>'Storage Mgt']);

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
    public $order_item_id;

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
            'order_item_id' => 'required|integer',
            'quantity_ordered' => 'required|numeric',
            'quantity_received' => 'required|numeric',
            'fulfillment_rate' => 'required|numeric',

        ]);

        FvOrderReview::updateOrCreate(
            ['visit_id' => $this->active_visit->id,
                'order_item_id' => $this->order_item_id],
            [
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

    public function deleteOrderItem($id)
    {
        FvOrderReview::where('id', $id)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully deleted!']);
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
        $this->active_visit->stage->update(['stage'=>'Ordering Mgt']);
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
        $this->active_visit->stage->update(['stage'=>'Lab Equipment']);

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
    public $submitted_on_time;
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
        $this->calculateScored();
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

    public function calculateScored()
    {
        $isavailableCount = 0;
        $isavailable = 0;
        $availability_score = 0;
        $availability_percentage = 0;

        $scAvailable = 0;
        $scAvailableCount = 0;
        $stock_card_score = 0;
        $stock_card_percentage = 0;

        $correct_filling = 0;
        $correct_filling_count = 0;
        $correct_filling_score = 0;
        $correct_filling_percentage = 0;

        $Physical_agrees = 0;
        $Physical_agrees_count = 0;
        $physical_agrees_score = 0;
        $physical_agrees_percentage = 0;

        $amc_well_calculated = 0;
        $amc_well_calculated_count = 0;
        $amc_well_calculated_score = 0;
        $amc_well_calculated_percentage = 0;

        $emr_usage = 0;
        $emr_usage_count = 0;
        $emr_usage_score = 0;
        $emr_usage_percentage = 0;
        $records = FvStockManagement::where('visit_id', $this->active_visit->id)->with('reagent')->get();
        foreach ($records as $storageItem) {
            if ($storageItem->item_available == 1) {
                $isavailable += 1;
                $isavailableCount += 1;
            } elseif ($storageItem->item_available == 0) {
                $isavailable += 0;
                $isavailableCount += 1;
            } else {
                $isavailable += 0;
                $isavailableCount += 0;
            }
            if ($isavailableCount > 0 && $isavailable > 0) {
                $availability_score = $isavailable / $isavailableCount;
            } else {
                $availability_score = 0;
            }
            $availability_percentage = round($availability_score * 100);
            //--------STOCK CARD SCORES-------------
            if ($storageItem->stock_card_available == 1) {
                $scAvailable += 1;
                $scAvailableCount += 1;
            } elseif ($storageItem->stock_card_available == 0) {
                $scAvailable += 0;
                $scAvailableCount += 1;
            } else {
                $scAvailable += 0;
                $scAvailableCount += 0;
            }
            if ($scAvailableCount > 0 && $scAvailable > 0) {
                $stock_card_score = $scAvailable / $scAvailableCount;
            } else {
                $stock_card_score = 0;
            }
            $stock_card_percentage = round($stock_card_score * 100);

            //--------STOCK CARD OKAY-------------
            if ($storageItem->stock_card_correct == 1) {
                $correct_filling += 1;
                $correct_filling_count += 1;
            } elseif ($storageItem->stock_card_correct == 0) {
                $correct_filling += 0;
                $correct_filling_count += 1;
            } else {
                $correct_filling += 0;
                $correct_filling_count += 0;
            }
            if ($correct_filling_count > 0 && $correct_filling > 0) {
                $correct_filling_score = $correct_filling / $correct_filling_count;
            } else {
                $correct_filling_score = 0;
            }
            $correct_filling_percentage = round($correct_filling_score * 100);

            //--------PHYSICAL AGREES-------------
            if ($storageItem->balance_matches_physical == 1) {
                $Physical_agrees += 1;
                $Physical_agrees_count += 1;
            } elseif ($storageItem->balance_matches_physical == 0) {
                $Physical_agrees += 0;
                $Physical_agrees_count += 1;
            } else {
                $Physical_agrees += 0;
                $Physical_agrees_count += 0;
            }
            if ($Physical_agrees > 0 && $Physical_agrees_count > 0) {
                $physical_agrees_score = $Physical_agrees / $Physical_agrees_count;
            } else {
                $physical_agrees_score = 0;
            }
            $physical_agrees_percentage = round($physical_agrees_score * 100);

            //--------AMC WELL CAL-------------
            if ($storageItem->amc_calculated_matches == 1) {
                $amc_well_calculated += 1;
                $amc_well_calculated_count += 1;
            } elseif ($storageItem->amc_calculated_matches == 0) {
                $amc_well_calculated += 0;
                $amc_well_calculated_count += 1;
            } else {
                $amc_well_calculated += 0;
                $amc_well_calculated_count += 0;
            }
            if ($amc_well_calculated > 0 && $amc_well_calculated_count > 0) {
                $amc_well_calculated_score = $amc_well_calculated / $amc_well_calculated_count;
            } else {
                $amc_well_calculated_score = 0;
            }
            $amc_well_calculated_percentage = round($amc_well_calculated_score * 100);

            //--------AMC WELL CAL-------------
            if ($storageItem->elmis_balance_matches == 1) {
                $emr_usage += 1;
                $emr_usage_count += 1;
            } elseif ($storageItem->elmis_balance_matches == 0) {
                $emr_usage += 0;
                $emr_usage_count += 1;
            } else {
                $emr_usage += 0;
                $emr_usage_count += 0;
            }
            if ($emr_usage > 0 && $emr_usage_count > 0) {
                $emr_usage_score = $emr_usage / $amc_well_calculated_count;
            } else {
                $emr_usage_score = 0;
            }
            $emr_usage_percentage = round($emr_usage_score * 100);
        }

        $this->availability_score = $availability_score;
        $this->availability_percentage = $availability_percentage;
        $this->stock_card_score = $stock_card_score;
        $this->stock_card_percentage = $stock_card_percentage;
        $this->correct_filling_score = $correct_filling_score;
        $this->correct_filling_percentage = $correct_filling_percentage;
        $this->physical_agrees_score = $physical_agrees_score;
        $this->physical_agrees_percentage = $physical_agrees_percentage;
        $this->amc_well_calculated_score = $amc_well_calculated_score;
        $this->amc_well_calculated_percentage = $amc_well_calculated_percentage;
        $this->emr_usage_score = $emr_usage_score;
        $this->emr_usage_percentage = $emr_usage_percentage;
        $this->saveStkMgtScore();

    }

    // Method to store data in the database
    public function saveStkMgtScore()
    {
        $this->validate([
            'availability_score' => 'required|numeric',
            'availability_percentage' => 'required|numeric',
            'stock_card_score' => 'required|numeric',
            'stock_card_percentage' => 'required|numeric',
            'correct_filling_score' => 'required|numeric',
            'correct_filling_percentage' => 'required|numeric',
            'physical_agrees_score' => 'required|numeric',
            'physical_agrees_percentage' => 'required|numeric',
            'amc_well_calculated_score' => 'required|numeric',
            'amc_well_calculated_percentage' => 'required|numeric',
            'emr_usage_score' => 'required|numeric',
            'emr_usage_percentage' => 'required|numeric',
            'stock_mgt_comments' => 'nullable|string',
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
        $this->loadLimsData();
        $this->active_visit->stage->update(['stage'=>'LIMS']);
    }

    public $tool_id;
    public $dct_availability_score;
    public $dct_usage_score;

    public function saveLisDctScores()
    {
        $this->validate([
            'tool_id' => 'required|integer',
            'dct_availability_score' => 'required|numeric',
            'dct_usage_score' => 'required|numeric',
        ]); // Validate input data

        FvLisDataToolScore::updateOrCreate(
            ['visit_id' => $this->active_visit->id,
                'tool_id' => $this->tool_id,
            ],
            [
                'dct_availability_score' => $this->dct_availability_score,
                'dct_usage_score' => $this->dct_usage_score,
            ]);
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
    }

    public $hmis_105_outpatient_report;
    public $hmis_105_previous_months;
    public $lis_availability_score;
    public $lis_availability_percentage;
    public $lis_availability_comments;
    public $t_reports_submitted_to_district;
    public $t_reports_submitted_on_time;
    public $timeliness_score;
    public $timeliness_percentage;
    public $timeliness_comments;
    public $hmis_section_6_complete;
    public $hmis_section_10_complete;
    public $completeness_score;
    public $completeness_percentage;
    public $lis_tools_comments;
    public $total_availability_sum;
    public $total_availability_percentage;
    public $total_inuse_sum;
    public $total_inuse_percentage;
    public $availability_inuse_sum;
    public $availability_inuse_percentage;
    public $hmis_105_report_comments;
    public $hmis_105_report_score;
    public $hmis_105_report_percentage;
    public $lab_data_usage_comments;
    public $lab_data_usaget_score;
    public $lab_data_usage_percentage;
    public $reports_filling_comments;
    public $reports_filling_score;
    public $reports_filling_percentage;
    public $lab_data_usage_score;

    public function loadLimsData()
    {
        $lims = FvLisHmisReport::where('visit_id', $this->active_visit->id)->first();
        $this->hmis_105_outpatient_report = $lims->hmis_105_outpatient_report ?? null;
        $this->hmis_105_previous_months = $lims->hmis_105_previous_months ?? null;
        $this->lis_availability_score = $lims->lis_availability_score ?? null;
        $this->lis_availability_percentage = $lims->lis_availability_percentage ?? null;
        $this->lis_availability_comments = $lims->lis_availability_comments ?? null;
        $this->t_reports_submitted_to_district = $lims->t_reports_submitted_to_district ?? null;
        $this->t_reports_submitted_on_time = $lims->t_reports_submitted_on_time ?? null;
        $this->timeliness_score = $lims->timeliness_score ?? null;
        $this->timeliness_percentage = $lims->timeliness_percentage ?? null;
        $this->timeliness_comments = $lims->timeliness_comments ?? null;
        $this->hmis_section_6_complete = $lims->hmis_section_6_complete ?? null;
        $this->hmis_section_10_complete = $lims->hmis_section_10_complete ?? null;
        $this->completeness_score = $lims->completeness_score ?? null;
        $this->completeness_percentage = $lims->completeness_percentage ?? null;
        $this->lis_tools_comments = $lims->lis_tools_comments ?? null;
        $this->total_availability_sum = $lims->total_availability_sum ?? null;
        $this->total_availability_percentage = $lims->total_availability_percentage ?? null;
        $this->total_inuse_sum = $lims->total_inuse_sum ?? null;
        $this->total_inuse_percentage = $lims->total_inuse_percentage ?? null;
        $this->availability_inuse_sum = $lims->availability_inuse_sum ?? null;
        $this->availability_inuse_percentage = $lims->availability_inuse_percentage ?? null;
        $this->hmis_105_report_comments = $lims->hmis_105_report_comments ?? null;
        $this->hmis_105_report_score = $lims->hmis_105_report_score ?? null;
        $this->hmis_105_report_percentage = $lims->hmis_105_report_percentage ?? null;
        $this->lab_data_usage_comments = $lims->lab_data_usage_comments ?? null;
        $this->lab_data_usage_score = $lims->lab_data_usage_score ?? null;
        $this->lab_data_usage_percentage = $lims->lab_data_usage_percentage ?? null;
        $this->reports_filling_comments = $lims->reports_filling_comments ?? null;
        $this->reports_filling_score = $lims->reports_filling_score ?? null;
        $this->reports_filling_percentage = $lims->reports_filling_percentage ?? null;
    }
    public function saveLisHmisReport()
    {
        $this->validate([
            'hmis_105_outpatient_report' => 'required|numeric',
            'hmis_105_previous_months' => 'required|numeric',
            'lis_availability_score' => 'nullable|numeric',
            'lis_availability_percentage' => 'nullable|numeric',
            'lis_availability_comments' => 'required|string',
            't_reports_submitted_to_district' => 'required|numeric',
            't_reports_submitted_on_time' => 'required|numeric',
            'timeliness_score' => 'nullable|numeric',
            'timeliness_percentage' => 'nullable|numeric',
            'timeliness_comments' => 'required|string',
            'hmis_section_6_complete' => 'required|numeric',
            'hmis_section_10_complete' => 'required|numeric',
            'completeness_score' => 'nullable|numeric',
            'completeness_percentage' => 'nullable|numeric',
            'lis_tools_comments' => 'required|string',
            'total_availability_sum' => 'nullable|numeric',
            'total_availability_percentage' => 'nullable|numeric',
            'total_inuse_sum' => 'nullable|numeric',
            'total_inuse_percentage' => 'nullable|numeric',
            'availability_inuse_sum' => 'nullable|numeric',
            'availability_inuse_percentage' => 'nullable|numeric',
            'hmis_105_report_comments' => 'required|string',
            'hmis_105_report_score' => 'nullable|numeric',
            'hmis_105_report_percentage' => 'nullable|numeric',
            'lab_data_usage_comments' => 'required|string',
            'lab_data_usage_score' => 'nullable|numeric',
            'lab_data_usage_percentage' => 'nullable|numeric',
            'reports_filling_comments' => 'required|string',
            'reports_filling_score' => 'nullable|numeric',
            'reports_filling_percentage' => 'nullable|numeric',
        ]); // Validate input data

        FvLisHmisReport::updateOrCreate(
            ['visit_id' => $this->active_visit->id],
            [
                'hmis_105_outpatient_report' => $this->hmis_105_outpatient_report,
                'hmis_105_previous_months' => $this->hmis_105_previous_months,
                'lis_availability_score' => $this->lis_availability_score,
                'lis_availability_percentage' => $this->lis_availability_percentage,
                'lis_availability_comments' => $this->lis_availability_comments,
                't_reports_submitted_to_district' => $this->t_reports_submitted_to_district,
                't_reports_submitted_on_time' => $this->t_reports_submitted_on_time,
                'timeliness_score' => $this->timeliness_score,
                'timeliness_percentage' => $this->timeliness_percentage,
                'timeliness_comments' => $this->timeliness_comments,
                'hmis_section_6_complete' => $this->hmis_section_6_complete,
                'hmis_section_10_complete' => $this->hmis_section_10_complete,
                'completeness_score' => $this->completeness_score,
                'completeness_percentage' => $this->completeness_percentage,
                'lis_tools_comments' => $this->lis_tools_comments,
                'total_availability_sum' => $this->total_availability_sum,
                'total_availability_percentage' => $this->total_availability_percentage,
                'total_inuse_sum' => $this->total_inuse_sum,
                'total_inuse_percentage' => $this->total_inuse_percentage,
                'availability_inuse_sum' => $this->availability_inuse_sum,
                'availability_inuse_percentage' => $this->availability_inuse_percentage,
                'hmis_105_report_comments' => $this->hmis_105_report_comments,
                'hmis_105_report_score' => $this->hmis_105_report_score,
                'hmis_105_report_percentage' => $this->hmis_105_report_percentage,
                'lab_data_usage_comments' => $this->lab_data_usage_comments,
                'lab_data_usage_score' => $this->lab_data_usage_score,
                'lab_data_usage_percentage' => $this->lab_data_usage_percentage,
                'reports_filling_comments' => $this->reports_filling_comments,
                'reports_filling_score' => $this->reports_filling_score,
                'reports_filling_percentage' => $this->reports_filling_percentage,
            ]);
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record successfully added!']);
        return redirect()->signedRoute('facility-visit_view', $this->active_visit->visit_code);
    }

    public $stock_item_id;
    public $c_reports_available;
    public $chmis_qty_consumed;
    public $chmis_days_out_of_stock;
    public $chmis_Stock_on_hand;
    public $csc_qty_consumed;
    public $csc_days_out_of_stock;
    public $csc_Stock_on_hand;
    public $c_report_sc_agree;

    public function saveStockAccuracy()
    {
        $this->validate([
            'stock_item_id' => 'required|numeric',
            'c_reports_available' => 'required|numeric',
            'chmis_qty_consumed' => 'required|numeric',
            'chmis_days_out_of_stock' => 'required|numeric',
            'chmis_Stock_on_hand' => 'required|numeric',
            'csc_qty_consumed' => 'required|numeric',
            'csc_days_out_of_stock' => 'required|numeric',
            'csc_Stock_on_hand' => 'required|numeric',
            'c_report_sc_agree' => 'required|numeric',
        ]); // Validate input data

        FvCompStockStatusAcc::updateOrCreate(
            ['visit_id' => $this->active_visit->id,
                'stock_item_id' => $this->stock_item_id],
            [
                'c_reports_available' => $this->c_reports_available,
                'chmis_qty_consumed' => $this->chmis_qty_consumed,
                'chmis_days_out_of_stock' => $this->chmis_days_out_of_stock,
                'chmis_Stock_on_hand' => $this->chmis_Stock_on_hand,
                'csc_qty_consumed' => $this->csc_qty_consumed,
                'csc_days_out_of_stock' => $this->csc_days_out_of_stock,
                'csc_Stock_on_hand' => $this->csc_Stock_on_hand,
                'c_report_sc_agree' => $this->c_report_sc_agree,
            ]);
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Stock statistics  successfully added!']);
    }

    public $service_name;
    public $service_statistics_available;
    public $hims_tests_reported;
    public $lab_reg_tests_reported;
    public $hims_lab_tests_balance;
    public function saveServiceAccuracy()
    {
        $this->validate([
            'service_name' => 'required|string',
            'service_statistics_available' => 'required|numeric',
            'hims_tests_reported' => 'required|numeric',
            'lab_reg_tests_reported' => 'required|numeric',
            'hims_lab_tests_balance' => 'required|numeric',
        ]); // Validate input data

        FvCompServiceStatisticsAcc::updateOrCreate(
            ['visit_id' => $this->active_visit->id,
                'service_name' => $this->service_name],
            [
                'service_statistics_available' => $this->service_statistics_available,
                'hims_tests_reported' => $this->hims_tests_reported,
                'lab_reg_tests_reported' => $this->lab_reg_tests_reported,
                'hims_lab_tests_balance' => $this->hims_lab_tests_balance,
            ]);
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'statistics  successfully added!']);
    }

    public $item_name;
    public $updated_last_quarter;
    public $is_available;
    public $lab_data_usage_comment;

    public function saveLisDataUsage()
    {
        $this->validate([
            'item_name' => 'required|string',
            'updated_last_quarter' => 'required|numeric',
            'is_available' => 'required|numeric',
            'lab_data_usage_comment' => 'required|string',
        ]); // Validate input data

        FvLisLabDataUse::updateOrCreate(
            ['visit_id' => $this->active_visit->id,
                'item_name' => $this->item_name],
            [

                'updated_last_quarter' => $this->updated_last_quarter,
                'comments' => $this->lab_data_usage_comment,
                'is_available' => $this->is_available,
            ]);
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Laboratory monthly statistics  successfully added!']);
    }
    public $report_id;
    public $filling_score;

    public function saveFiling()
    {
        $this->validate([
            'filling_score' => 'required|string',
            'report_id' => 'required|numeric',
        ]); // Validate input data

        FvReportFilling::updateOrCreate(
            ['visit_id' => $this->active_visit->id,
                'report_id' => $this->report_id],
            [

                'filling_score' => $this->filling_score,
            ]);
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record  successfully added!']);
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
            'stock_item_id',
            'c_reports_available',
            'chmis_qty_consumed',
            'chmis_days_out_of_stock',
            'chmis_Stock_on_hand',
            'csc_qty_consumed',
            'csc_days_out_of_stock',
            'csc_Stock_on_hand',
            'c_report_sc_agree',
            'service_name',
            'service_statistics_available',
            'hims_tests_reported',
            'lab_reg_tests_reported',
            'hims_lab_tests_balance',
            'report_id',
            'filling_score',
            'item_name',
            'is_available',
            'updated_last_quarter',
            'tool_id',
            'dct_availability_score',
            'dct_usage_score',
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
            'recordId',
            'model',
        ]);
    }

    public function close()
    {
        $this->resetInputs();
    }

    public $recordId;
    public $model;

    // Set the record ID and model to delete
    public function confirmDelete($id, $model)
    {
        $this->recordId = $id;
        $this->model = app($model); // Dynamically instantiate the model
    }

    // Generic delete method
    public function deleteRecord()
    {
        if ($this->recordId && $this->model) {
            try {
                $this->model->find($this->recordId)->delete();

                // Show success alert
                $this->dispatchBrowserEvent('alert', [
                    'type' => 'success',
                    'message' => 'Record deleted successfully!',
                ]);

                // Reset the fields after deletion
                $this->reset(['recordId', 'model']);

            } catch (\Throwable $th) {
                // Show failure alert
                $this->dispatchBrowserEvent('alert', [
                    'type' => 'warning',
                    'message' => 'Record cannot be deleted!',
                ]);
            }
        }
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
        $data['dcTools'] = collect([]);
        $data['dcToolScores'] = collect([]);
        $data['orderItems'] = collect([]);
        $data['filedReports'] = collect([]);
        $data['reports'] = collect([]);
        $data['filedReports'] = collect([]);
        $data['stockItems'] = collect([]);
        $data['services'] = collect([]);
        $data['stockStatuses'] = collect([]);
        if ($this->step == 1) {
            $data['supervised_persons'] = FvPersonsSupervised::where('visit_id', $this->active_visit->id)->get();
            $data['supervisors'] = FvSupervisor::where('visit_id', $this->active_visit->id)->get();
            $data['supply_storages'] = FvStorageManagement::where('visit_id', $this->active_visit->id)->with('storageType')->get();

            $this->supervised_count = $data['supervised_persons']->count();
            $this->supervisors_count = $data['supervisors']->count();
            $this->supply_storages_count = $data['supply_storages']->count();
        }
        if ($this->step == 2) {
            $data['test_types'] = TestingCategory::where(['is_active' => true])->get();
            $data['reagents'] = Reagent::where(['is_active' => true, 'testing_category_id' => $this->test_type_id])->get();
            $data['storageMgts'] = FvStockManagement::where('visit_id', $this->active_visit->id)->with('reagent')->get();
        }
        if ($this->step == 4) {
            $items = FvStockManagement::where('visit_id', $this->active_visit->id)->orderBy('id', 'asc')->limit(5)->pluck('reagent_id')->toArray();
            $data['reviews'] = FvOrderReview::where('visit_id', $this->active_visit->id)->with('reagent')->get();
            $data['orderItems'] = Reagent::where(['is_active' => true])->whereIn('id', $items)->get();
        }
        if ($this->step == 5) {
            $data['platforms'] = LabPlatform::where('is_active', true)->get();
            $data['functionalities'] = FvEquipmentFunctionality::where('visit_id', $this->active_visit->id)->get();
            $data['utilizations'] = FvEquipmentUtilization::where('visit_id', $this->active_visit->id)->get();
        }
        if ($this->step == 6) {
            $data['dcTools'] = LisDataCollectionTool::where('is_active', true)->get();
            $data['reports'] = FilledReport::where('is_active', true)->get();
            $data['stockItems'] = StockItem::where('is_active', true)->get();
            $data['dcToolScores'] = FvLisDataToolScore::where('visit_id', $this->active_visit->id)->with('dcTool')->get();
            $data['lisLabDataUsages'] = FvLisLabDataUse::where('visit_id', $this->active_visit->id)->get();
            $data['filedReports'] = FvReportFilling::where('visit_id', $this->active_visit->id)->with('report')->get();
            $data['services'] = FvCompServiceStatisticsAcc::where('visit_id', $this->active_visit->id)->get();
            $data['stockStatuses'] = FvCompStockStatusAcc::where('visit_id', $this->active_visit->id)->with('stkItem')->get();
        }
        $data['storageTypes'] = FvStorageType::where('is_active', true)->get();

        return view('livewire.facility.visits.facility-visit-details-component', $data);
    }
}

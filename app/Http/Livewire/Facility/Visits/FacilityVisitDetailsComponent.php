<?php

namespace App\Http\Livewire\Facility\Visits;

use App\Models\Facility\FacilityVisit;
use App\Models\Facility\FvPersonsSupervised;
use App\Models\Facility\FvStorageType;
use App\Models\Facility\FvSupervisor;
use App\Models\Facility\Visits\FvStorageManagement;
use Livewire\Component;

class FacilityVisitDetailsComponent extends Component
{
  public $code;
  public $active_visit;
  public $step;
  public $storage_type;
  public $toggleForm = false;
  public $sex, $contact, $email, $name, $profession, $title;
  public $use_stock_cards;
  public $consumption_reconciliation;

  public $storage_type_id, $comment;

  public function mount($code)
  {
    $this->code = $code;
    $this->active_visit = FacilityVisit::where('visit_code', $code)
    ->with(['facility', 'facility.healthSubDistrict', 'facility.healthSubDistrict.district','facility.healthSubDistrict.district.region'])->first();
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
    $data['supply_storages'] = collect([]);
    $data['stock_card_storages'] = collect([]);
    if ($this->step == 1) {
      $data['supervised_persons'] = FvPersonsSupervised::where('visit_id', $this->active_visit->id)->get();
      $data['supervisors'] = FvSupervisor::where('visit_id', $this->active_visit->id)->get();
      $data['supply_storages'] = FvStorageManagement::where('visit_id', $this->active_visit->id)->with('storageType')->get();
    }
    $data['storageTypes'] = FvStorageType::where('is_active', true)->get();
    return view('livewire.facility.visits.facility-visit-details-component', $data);
  }
}

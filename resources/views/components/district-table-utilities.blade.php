@props(['display' => ''])
<div class="d-flex align-items-center">
  {{ $slot }}

  <div class="col-6 col-md-3 px-1 mb-3">
    <label for="from" class="form-label required">From</label>
    <div class="group_input undefined">
      <input class="form-control" type="date" wire:model="from" max="{{date('Y-m-d')}}">
    </div>
  </div>

  <div class="col-6 col-md-3 px-1 mb-3">
    <label for="from" class="form-label required">To</label>
    <div class="group_input undefined">
      <input class="form-control" type="date" wire:model="to" max="{{date('Y-m-d')}}">
    </div>
  </div>

  <a href="javascript:;" id="IdExport" wire:click='export' class="btn btn-outline-success me-2 m-3 fa fa-sign-out" title="Export"></a>
</div>
<hr>

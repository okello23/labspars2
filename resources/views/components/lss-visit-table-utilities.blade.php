@props(['display' => ''])
<div class="d-flex align-items-center">


  <div class="md-3">
    <div class="mb-1  col-md-12">
      <label for="orderBy" class="form-label">Per Page</label>
      <select wire:model="perPage" class="form-control">
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="200">200</option>
        <option value="500">500</option>
        <option value="1000">1000</option>
      </select>
    </div>
  </div>
  <div class="md-3">
    <div class="mb-1  col-md-12">
      <label for="orderAsc" class="form-label">Order</label>
      <select wire:model="orderAsc" class="form-control ms-1">
        <option value="1">Asc</option>
        <option value="0">Desc</option>
      </select>
    </div>
  </div>
  {{ $slot }}

  <div class="float-right text-end position-relative mb-1  col-md-2" >
    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
    <label for="orderAsc" class="form-label">Search</label>
    <input wire:model.debounce.300ms="search" class="form-control ps-5 ms-1" type="text" placeholder="search">
  </div>


  <div class="mt-4 col-md-2">
    <a type="button" class="btn btn-sm btn-outline-success me-2" wire:click="export()"><i
      class="fa fa-file-excel-o"></i> {{__('Export')}}</a>

      <a type="button" class="btn btn-sm btn-outline-info me-2" wire:click="$set('createNew',1)" data-toggle="modal" data-target="#addUpdateRecord">
        <i class="fa fa-plus"></i> {{__('New')}}</a>

        <a type="button" class="btn btn-sm btn-outline-success me-2" href="{{ asset('storage/documents/labSparsTool_2024.pdf') }}" target="blank" >
        <i class="fa fa-file-pdf-o" title="Download LabSpars Tool"></i> {{__('')}}</a>

        <!-- <a type="button" class="btn btn-sm btn-outline-primary me-2"
      wire:click="refresh()"><i class="fa fa-refresh"></i> Refresh Page </a> -->
      </div>
    </div>
    <hr>

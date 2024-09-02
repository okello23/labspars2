@props(['display' => ''])
<div class="d-flex align-items-center">

  <div class="float-right text-end position-relative mb-1  col-md-12" >
    <div class="position-absolute top-50 translate-middle-y search-icon px-3"></div>
    <label for="orderAsc" class="form-label">Search</label>
    <input wire:model="extraction_search" class="form-control ps-5 ms-1" type="text" placeholder="search">
  </div>
  {{ $slot }}

    </div>
    <hr>

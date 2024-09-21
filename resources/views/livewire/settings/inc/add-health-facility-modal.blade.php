<div wire:ignore.self class="modal fade" id="addEntry" data-bs-backdrop="static" data-bs-keyboard="false"
tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">
        @if($createNew)
        New Health Facility
        @else
        Update Health Facility Details
        @endif
      </h5>
      <button type="button" class="btn-close"  wire:click="close" aria-hidden="true"></button>
    </div> <!-- end modal header -->
    <div class="modal-body">
      <form
      @if ($createNew) wire:submit.prevent="store"
      @else
      wire:submit.prevent="update"
      @endif
      >

      <div class="row">

        <div class="col-12 col-md-6 px-1 mb-3">
          <label for="name" class="form-label required"> Health Facility Name</label>
          <input type="text" class="form-control" wire:model.defer="name"required>
          @error('name')
          <div class="text-danger text-small">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12 col-md-6 px-1 mb-3">
          <label for="level" class="form-label required">Level</label>
          <select class="form-control" wire:model.defer="level" required>
            <option value="">select....</option>
            <option value = "HC2"> HC2</option>
            <option value = "HC3"> HC3</option>
            <option value = "HC4"> HC4</option>
            <option value = "Clinic"> Clinic</option>
            <option value = "Regional Referral Hospital"> Regional Referral Hospital</option>
            <option value = "Hospital"> Hospital</option>
            <option value = "General Hospital"> General Hospital</option>
            <option value = "National Referral Hospital"> National Referral Hospital</option>
          </select>
          @error('level')
          <div class="text-danger text-small">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12 col-md-6 px-1 mb-3">
          <label for="ownership" class="form-label required">Ownership</label>
          <select class="form-control" wire:model.defer="ownership" required>
            <option value="">select....</option>
            <option value="Govt">Govt</option>
            <option value="PNFP">PNFP</option>
            <option value="PFP">PFP</option>
            <option value="PFNP">PFNP</option>
            <option value="Other">Other</option>
          </select>
          @error('ownership')
          <div class="text-danger text-small">{{ $message }}</div>
          @enderror
        </div>


        <div class="col-12 col-md-6 px-1 mb-3">
          <label for="district_id" class="form-label required">District</label>
          <select class="form-control select2" wire:model.lazy="district_id" id="district_id" required>
            <option value="">select....</option>
            @foreach ($districts as $key => $value)
            <option value="{{ $value->id }}">{{$value->name}}</option>

            @endforeach
          </select>
          @error('district_id')
          <div class="text-danger text-small">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12 col-md-6 px-1 mb-3">
          <label for="sub_district_id" class="form-label required">Health Sub-District</label>
          <select class="form-control" wire:model.defer="sub_district_id" required>
            <option value="">select....</option>
            @foreach ($sub_districts as $key => $value)
            <option value="{{ $value->id }}">{{$value->name}}</option>

            @endforeach
          </select>
          @error('sub_district_id')
          <div class="text-danger text-small">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12 col-md-6 px-1 mb-3">
          <label for="region_name" class="form-label required">Region</label>
          <input type="text" class="form-control" wire:model.defer="region_name" readonly>
          @error('region_name')
          <div class="text-danger text-small">{{ $message }}</div>
          @enderror
        </div>

      </div>

      <div class="modal-footer">
        @if ($createNew)
        <x-button class="btn-success">Save</x-button>
        @else
        <x-button class="btn-success">Update</x-button>
        @endif
        <x-button type="button" class="btn btn-danger" wire:click="close">Close</x-button>

      </div>
    </form>
  </div>
</div> <!-- end modal content-->
</div> <!-- end modal dialog-->
</div> <!-- end modal-->

<script>


</script>

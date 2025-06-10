<div wire:ignore.self class="modal fade" id="addEntry" data-bs-backdrop="static" data-bs-keyboard="false"
tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">
        @if($createNew)
        New District
        @else
        Update District
        @endif
      </h5>
      <button type="button" class="btn-close"  wire:click="close" aria-hidden="true"></button>
    </div> <!-- end modal header -->
    <div class="modal-body">
      <form
      @if ($createNew) wire:submit.prevent="store"
      @else
      wire:submit.prevent="updateData"
      @endif
      >

      <div class="row">

        <div class="col-12 col-md-6 px-1 mb-3">
          <label for="name" class="form-label required"> District Name</label>
          <input type="text" class="form-control" wire:model.defer="name"required>
          @error('name')
          <div class="text-danger text-small">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12 col-md-6 px-1 mb-3">
          <label for="region_id" class="form-label required">Region</label>
          <select class="form-control" wire:model.defer="region_id" required>
            <option value="">select....</option>
            @foreach ($regions as $key => $value)
            <option value="{{ $value->id }}">{{$value->name}}</option>

            @endforeach
          </select>
          @error('region_id')
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

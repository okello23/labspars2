<div wire:ignore.self class="modal fade" id="addEntry" data-bs-backdrop="static" data-bs-keyboard="false"
tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">
        @if($createNew)
        New Product
        @else
        Update Product
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
          <label for="name" class="form-label required"> Product Name</label>
          <input type="text" class="form-control" wire:model.defer="name"required>
          @error('name')
          <div class="text-danger text-small">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12 col-md-6 px-1 mb-3">
          <label for="type" class="form-label required">Type</label>
          <select class="form-control" wire:model.defer="type" required>
            <option value="">select....</option>
            <option value="Reagent">Reagent</option>
            <option value="Equipment">Equipment</option>
          </select>
          @error('type')
          <div class="text-danger text-small">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12 col-md-6 px-1 mb-3">
          <label for="is_active" class="form-label required">Is Active</label>
          <select class="form-control" wire:model.defer="is_active" required>
            <option value="">select....</option>
            <option value="1">In-Use</option>
            <option value="0">Discontinued</option>
          </select>
          @error('is_active')
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

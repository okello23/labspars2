<div wire:ignore.self class="modal fade" id="confirmDelete" data-bs-backdrop="static"
data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">

      <h5 class="modal-title" id="staticBackdropLabel">{{ __('Confirm Delete Action') }}</h5>
      <button type="button" class="btn-close" wire:click="close()" data-bs-dismiss="modal"
      aria-hidden="true"></button>
    </div>
    <div class="modal-body">
      <h1 class="bx bx-error-alt"></h1>
      <h6>{{ __('Are you sure want to delete this entry? ') }}<br>{{ __('logistics.This action is irreversible') }}</h6>

    </div>
    <!-- end row-->
    <div class="modal-footer">
      <button type="button" wire:click.prevent="deleteEntry()"
      class="btn btn-success close-modal bx bx-trash"
      data-dismiss="modal">{{ __('Yes') }}</button>
      <x-button type="button" class="btn btn-danger" wire:click="close()"
      data-bs-dismiss="modal">{{ __('Close') }}</x-button>
    </div>
  </div>
</div> <!-- end modal content-->
</div> <!-- end modal dialog-->

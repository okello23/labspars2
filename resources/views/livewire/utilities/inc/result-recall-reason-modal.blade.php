<!-- Modal -->
<div class="modal fade" id="RecallReason" role="dialog" data-backdrop="false">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5>
          @if (!$toggleForm)
          New Result Recall Reason
          @else
          Update Result Recall Reason
          @endif
          </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="box-body">
          <div class="container-fluid " style="float:left; width: 100%; overflow-x: auto;  overflow-y: auto;">
            <h5 style="text-align:left; color:red" id="modal_header_name"></h5>
            <form
            @if (!$toggleForm) wire:submit.prevent="storeData"
            @else
            wire:submit.prevent="updateData"
            @endif>

            <div class="row">

              <div class="col-12">
                <label for="name" class="form-label">Recall Reason</label>
                <textarea class="form-control" wire:model.defer="name" rows="3" cols="100"></textarea>
                @error('name')
                <div class="text-danger text-small">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          </div>
          <div class="modal-footer">
            @if (!$toggleForm)
            <x-button class="btn-success" >{{ __('Save') }}</x-button>
            @else
            <x-button class="btn-success">{{ __('Update') }}</x-button>
            @endif
            <x-button type="button" class="btn btn-danger" wire:click="close">Close</x-button>
          </form>
          </div>
        </div>

    </div>
  </div>
</div>

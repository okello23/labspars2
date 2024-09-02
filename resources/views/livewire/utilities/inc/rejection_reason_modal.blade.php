<!-- Modal -->
<div class="modal fade" id="newReason" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5>Sample Rejection Reason</h5>
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

              <div class="mb-3 col-md-6">
                <label for="pathogen_id"
                class="form-label required"> Pathogen</label>
                <select class="form-control" wire:model.defer="pathogen_id">
                  <option value="" selected> Select...</option>
                  @foreach ($pathogens as $key => $value)
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
                </select>
                @error('pathogen_id')
                <div class="text-danger text-small">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-12 col-md-6 px-1 mb-3">
                <label for="rejection_reason" class="form-label">Rejection Reason</label>
                <textarea class="form-control" wire:model.defer="rejection_reason"></textarea>
                @error('rejection_reason')
                <div class="text-danger text-small">{{ $message }}</div>
                @enderror
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
</div>

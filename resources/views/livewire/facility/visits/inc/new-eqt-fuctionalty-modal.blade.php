 <div wire:ignore.self  class="modal fade" id="addequipmentFunctionality" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Add Functionality</h5>
                </div>
              
                <form  @if ($toggleForm) wire:submit.prevent="updatevalue" @else wire:submit.prevent="storFunctionality" @endif >
                    <div class="modal-body">
                        <div class="row">
                             <div class="mb-3 col-md-5">
                                <label for="station_id" class="form-label required">Equipment</label>
                                <select class="form-control selectr" id="equipment_id"
                                    wire:model='equipment_id'>
                                    <option  value="">Select</option>
                                    @forelse ($platforms as $platmform)
                                    <option  value="{{ $platmform->id }}">{{ $platmform->name }}({{ $platmform->type }})</option>
                                        
                                    @empty
                                        
                                    @endforelse
                                </select>
                                @error('equipment_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="type" class="form-label required">Type</label>
                                <input type="text"  class="form-control" name="downtime" required
                                    wire:model.defer="equipment_type">
                                @error('equipment_type')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="station_id" class="form-label required">Is the equipment functional?</label>
                                <select class="form-control selectr" id="functional"
                                    wire:model.lazy='functional'>
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                                </select>
                                @error('functional')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($functional == 0)
                            <div class="mb-3 col-md-4">
                                <label for="name" class="form-label required">Duration of downtime (months)</label>
                                <input type="number" max='12' id="downtime" class="form-control" required
                                    wire:model.defer="downtime">
                                @error('downtime')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="nonfunctional_hw" class="form-label required">Non-functional due to HW/SW?</label>
                                <select id="nonfunctional_hw" class="form-control"  required
                                    wire:model.defer="nonfunctional_hw">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                                @error('nonfunctional_hw')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Non-functional due to reagents?</label>
                                <select class="form-control" wire:model="nonfunctional_reagents">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                                @error('nonfunctional_reagents') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Non-functional due to other factors?</label>
                                <select  class="form-control" wire:model="other_factors">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                                @error('other_factors') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Reaponse Time (Months)</label>
                                <input type="number" class="form-control" wire:model="response_time">
                                @error('response_time') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>                          
                           @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" wire:click="close()" >{{ __('close') }}</button>
                        @if($toggleForm)
                        <x-button type="submit"  class="btn-success btn-sm">{{ __('Update') }}</x-button>
                         @else
                         <x-button type="submit"  class="btn-success btn-sm">{{ __('Save') }}</x-button>
                         @endif
                    </div><!--end modal-footer-->
                </form>

            </div>
        </div>
    </div>
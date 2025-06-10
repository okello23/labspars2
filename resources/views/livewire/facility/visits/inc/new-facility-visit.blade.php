 <div wire:ignore.self  class="modal fade" id="addUpdateRecord" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Add Facility</h5>
                </div>
                <form  @if ($toggleForm) wire:submit.prevent="updatevalue" @else wire:submit.prevent="storevalue" @endif >
                    <div class="modal-body">
                        <div class="row">
                        <div class="mb-3 col-md-3">
                                <label for="district_id" class="form-label required">Region</label>
                                  <select class="form-control" wire:model="region_id" required>
                                  <option value="">All</option>
                                  @foreach($regions as $region)
                                      <option value="{{ $region->id }}">{{ $region->name }}</option>
                                  @endforeach
                              </select>
                            </div>
                            
                            <div class="mb-3 col-md-3">
                                <label for="district_id" class="form-label required">District</label>
                                <select class="form-control selectr" id="district_id"
                                    wire:model.lazy='district_id'  @if(empty($districts_list)) disabled @endif>
                                    <option selected value="">Select</option>
                                    @foreach ($districts_list as $value)
                                        <option value='{{ $value->id }}'>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('facility_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="station_id" class="form-label required">Facility</label>
                                <select class="form-control selectr" id="facility_id"
                                    wire:model.lazy='facility_id' required>
                                    <option selected value="">Select</option>
                                    @foreach ($facilities as $value)
                                        <option value='{{ $value->id }}'>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('facility_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="facility_level" class="form-label required">Level</label>
                                <input type='text' class="form-control" wire:model.defer='facility_level' readonly>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="name" class="form-label required">Visit Number</label>
                                <input type="number" min="1" id="visit_number" class="form-control" name="visit_number" required
                                    wire:model.defer="visit_number">
                                @error('visit_number')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-5">
                                <label for="in_charge_name" class="form-label required">In Charge Name</label>
                                <input type="text" id="in_charge_name" class="form-control" name="in_charge_name" required
                                    wire:model.defer="in_charge_name">
                                @error('in_charge_name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>In Charge Contact</label>
                                <input type="text" class="form-control" wire:model="in_charge_contact">
                                @error('in_charge_contact') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="in_charge_name" class="form-label required">Responsible LSS</label>
                                <input type="text" id="in_charge_name" class="form-control" name="responsible_lss_name" required
                                    wire:model.defer="responsible_lss_name">
                                @error('responsible_lss_name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label >Date Of Visit</label>
                                <input type="date" class="form-control required" max="{{ date('Y-m-d') }}" wire:model="date_of_visit" required>
                                @error('date_of_visit') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Date Of Next Visit</label>
                                <input type="date" class="form-control" min="{{ date('Y-m-d') }}" wire:model="date_of_next_visit">
                                @error('date_of_next_visit') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                          
                           
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
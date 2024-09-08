 <div wire:ignore.self  class="modal fade" id="addUpdateRecord" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Add Facility</h5>
                </div>
                <form  @if ($toggleForm) wire:submit.prevent="updatevalue" @else wire:submit.prevent="storevalue" @endif >
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label required">Name</label>
                                <input type="text" id="name" class="form-control" name="name" required
                                    wire:model.defer="name">
                                @error('name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="level" class="form-label required">Level</label>
                                <input type="text" id="level" class="form-control" name="level" required
                                    wire:model.defer="level">
                                @error('level')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Owner</label>
                                <input type="text" class="form-control" wire:model="ownership">
                                @error('ownership') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Contact</label>
                                <input type="text" class="form-control" wire:model="clinician_contact">
                                @error('clinician_contact') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Email</label>
                                <input type="email" class="form-control" wire:model="email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="station_id" class="form-label required">District</label>
                                <select class="form-control selectr" id="district_id"
                                    wire:model.lazy='district_id'>
                                    <option selected value="">Select</option>
                                    @foreach ($districts as $value)
                                        <option value='{{ $value->id }}'>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('district_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="station_id" class="form-label required">Sub District</label>
                                <select class="form-control selectr" id="sub_district_id"
                                    wire:model.lazy='sub_district_id'>
                                    <option selected value="">Select</option>
                                    @foreach ($divisions as $value)
                                        <option value='{{ $value->id }}'>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('sub_district_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                          
                            <div class="col-12 col-md-3 px-1 mb-3">
                                <label for="latitude">DHIS2 division ID</label>
                                <div class="group_input undefined">
                                    <input class="form-control" type="text" id="dhis2_division_id"
                                        wire:model.defer="dhis2_division_id" >
                                </div>
                                @error('dhis2_division_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-3 px-1 mb-3">
                                <label for="latitude">DHIS2 District ID</label>
                                <div class="group_input undefined">
                                    <input class="form-control" type="text" id="dhis2_district_id"
                                        wire:model.defer="dhis2_district_id" >
                                </div>
                                @error('dhis2_district_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="is_active" class="form-label required">{{ __('public.status') }}</label>
                                <select class="form-control selectr"  id="is_active" wire:model.defer="is_active">
                                    <option selected value="">Select</option>
                                    <option value='1'>Active</option>
                                    <option value='0'>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
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
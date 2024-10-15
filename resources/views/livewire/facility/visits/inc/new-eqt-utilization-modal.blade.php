 <div wire:ignore.self  class="modal fade" id="addequipmentUtilization" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addequipmentUtilization">Add Utilization</h5>
                </div>
                <form  @if ($toggleForm) wire:submit.prevent="storUtilization" @else wire:submit.prevent="storUtilization" @endif >
                    <div class="modal-body">
                        <div class="row">
                             <div class="mb-3 col-md-4">
                                <label for="station_id" class="form-label required">A). Equipment</label>
                                <select class="form-control selectr" id="equipment_id"
                                    wire:model='equipment_id'>
                                    <option  value="">Select</option>
                                    @forelse ($platforms->where('type',$equipment_type) as $platmform)
                                    <option  value="{{ $platmform->id }}">{{ $platmform->name }}({{ $platmform->type }})</option>
                                        
                                    @empty
                                        
                                    @endforelse
                                </select>
                                @error('equipment_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="type" class="form-label required">B). Throughput (per day)</label>
                                <input type="text"  class="form-control" name="through_put" required
                                    wire:model.defer="through_put">
                                @error('through_put')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>                            
                            <div class="mb-3 col-md-5">
                                <label for="name" class="form-label required">C). Average no. of days running (monthly)</label>
                                <input type="number" max='31' id="running_days" class="form-control" required
                                    wire:model.defer="running_days">
                                @error('running_days')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="name" class="form-label required">D). Average actual output</label>
                                <input type="number"  id="actual_output" class="form-control" required
                                    wire:model="actual_output">
                                @error('actual_output')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="name" class="form-label required">E). Average expected output</label>
                                <input type="number"  id="actual_output" class="form-control" required
                                    wire:model="expected_output">
                                @error('expected_output')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="name" class="form-label required">F). % Utilization ((D/E)*100)</label>
                                <input type="number" id="utilization" class="form-control" required
                                    wire:model="utilization">
                                @error('utilization')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="greater_score" class="form-label required">G). If "F">70%, score 1</label>
                                <select id="nonfunctional_hw" class="form-control"  required
                                    wire:model.defer="greater_score">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                                @error('greater_score')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="name" class="form-label required">H). Capacity of equipment</label>
                                <input type="number" max='12' id="capacity" class="form-control" required
                                    wire:model.defer="capacity">
                                @error('capacity')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>I). If B=H, score 1</label>
                                <select  class="form-control" wire:model="final_score">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                                @error('final_score') <span class="text-danger">{{ $message }}</span> @enderror
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
 <div wire:ignore.self  class="modal fade" id="addeDataCollectionToolScore" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addeDataCollectionToolScore">Add Scores</h5>
                </div>
                <form   wire:submit.prevent="saveLisDctScores" >
                    <div class="modal-body">
                        <div class="row">
                             <div class="mb-3 col-md-12">
                                <label for="station_id" class="form-label required"> Data collection tool</label>
                                <select class="form-control selectr" id="tool_id"
                                    wire:model='tool_id'>
                                    <option  value="">Select</option>
                                    @forelse ($dcTools as $tool)
                                    <option  value="{{ $tool->id }}">{{ $tool->name }}</option>
                                        
                                    @empty
                                        
                                    @endforelse
                                </select>
                                @error('tool_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>                         
                           
                            <div class="mb-3 col-md-6">
                                <label for="dct_availability_score" class="form-label required">Available Scores (1/0)</label>
                                <select id="nonfunctional_hw" class="form-control"  required 
                                    wire:model.lazy="dct_availability_score">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                                  <option value="2">N/A</option>
                                </select>
                                @error('dct_availability_score')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>  
                            <div class="mb-3 col-md-6">
                                <label for="dct_usage_score" class="form-label required">In Use Scores (1/0)</label>
                                <select id="nonfunctional_hw" class="form-control"  required 
                                    wire:model.lazy="dct_usage_score">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                                  <option value="2">N/A</option>
                              </select>
                                @error('dct_usage_score')
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
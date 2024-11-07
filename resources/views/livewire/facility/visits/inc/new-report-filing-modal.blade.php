 <div wire:ignore.self  class="modal fade" id="addeReortFillingModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addeReortFillingModal">Add New</h5>
                </div>
                <form   wire:submit.prevent="saveFiling" >
                    <div class="modal-body">
                        <div class="row">
                             <div class="mb-3 col-md-8">
                                <label for="station_id" class="form-label required">Item</label>
                                <select class="form-control selectr" id="report_id"
                                    wire:model='report_id'>
                                    <option  value="">Select</option>
                                    @foreach ($reports as $report)
                                        <option value="{{ $report->id }}">{{ $report->name }}</option>
                                    @endforeach
                                </select>
                                @error('report_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>                         
                            
                            <div class="mb-3 col-md-4">
                                <label for="filling_score" class="form-label required">Score</label>
                                <select id="filling_score" class="form-control"  required 
                                    wire:model.lazy="filling_score">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                                  <option value="2">N/A</option>
                              </select>
                                @error('filling_score')
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
 <div wire:ignore.self  class="modal fade" id="addeDataUsageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addeDataUsageModal">Add New</h5>
                </div>
                <form   wire:submit.prevent="saveLisDataUsage" >
                    <div class="modal-body">
                        <div class="row">
                             <div class="mb-3 col-md-4">
                                <label for="station_id" class="form-label required"> Data collection tool</label>
                                <select class="form-control selectr" id="item_name"
                                    wire:model='item_name'>
                                    <option  value="">Select</option>
                                    <option value="Map">Map</option>
                                    <option value="Graph">Graph</option>
                                    <option value="Chart">Chart</option>
                                    <option value="Table">Table</option>
                                </select>
                                @error('item_name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>                         
                            
                            <div class="mb-3 col-md-4">
                                <label for="is_available" class="form-label required">Available?</label>
                                <select id="nonfunctional_hw" class="form-control"  required 
                                    wire:model.lazy="is_available">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                                @error('is_available')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>  
                            <div class="mb-3 col-md-4">
                                <label for="updated_last_quarter" class="form-label required">Updated in last quarter?</label>
                                <select id="nonfunctional_hw" class="form-control"  required 
                                    wire:model.lazy="updated_last_quarter">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                                @error('updated_last_quarter')
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
 <div wire:ignore.self  class="modal fade" id="satockAccuracyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="satockAccuracyModal">Add Scores</h5>
                </div>
                <form   wire:submit.prevent="saveStockAccuracy" >
                    <div class="modal-body">
                        <div class="row">
                             <div class="mb-3 col-md-12">
                                <label for="station_id" class="form-label required"> Data collection tool</label>
                                <select class="form-control selectr" id="stock_item_id"
                                    wire:model='stock_item_id'>
                                    <option  value="">Select</option>
                                    @forelse ($stockItems as $stockItem)
                                    <option  value="{{ $stockItem->id }}">{{ $stockItem->name }}</option>
                                        
                                    @empty
                                        
                                    @endforelse
                                </select>
                                @error('stock_item_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div> 
                            <div class="mb-3 col-md-4">
                                <label for="c_reports_available" class="form-label required">Previous HMIS 105 & SC Reports?</label>
                                <select id="c_reports_available" class="form-control"  required 
                                    wire:model.lazy="c_reports_available">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                                  <option value="2">N/A</option>
                              </select>
                                @error('c_reports_available')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>      
                            <div class="mb-3 col-md-4">
                                <label for="chmis_qty_consumed" class="form-label required">No of tests as recorded in lab register in that month
                                    </label>
                                <input type="number" id="hims_tests_reported" wire:model='chmis_qty_consumed' class="form-control" required>
                                @error('chmis_qty_consumed')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="chmis_days_out_of_stock" class="form-label required">No of tests as recorded in lab register in that month
                                    </label>
                                <input type="number" id="hims_tests_reported" wire:model='chmis_days_out_of_stock' class="form-control" required>
                                @error('chmis_days_out_of_stock')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="chmis_Stock_on_hand" class="form-label required">No of tests as recorded in lab register in that month
                                    </label>
                                <input type="number" id="hims_tests_reported" wire:model='chmis_Stock_on_hand' class="form-control" required>
                                @error('chmis_Stock_on_hand')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3 col-md-4">
                                <label for="csc_qty_consumed" class="form-label required">No of tests as recorded in lab register in that month
                                    </label>
                                <input type="number" id="hims_tests_reported" wire:model='csc_qty_consumed' class="form-control" required>
                                @error('csc_qty_consumed')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="csc_days_out_of_stock" class="form-label required">No of tests as recorded in lab register in that month
                                    </label>
                                <input type="number" id="hims_tests_reported" wire:model='csc_days_out_of_stock' class="form-control" required>
                                @error('csc_days_out_of_stock')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="csc_Stock_on_hand" class="form-label required">No of tests as recorded in lab register in that month
                                    </label>
                                <input type="number" id="csc_Stock_on_hand" wire:model='csc_Stock_on_hand' class="form-control" required>
                                @error('csc_Stock_on_hand')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="dct_usage_score" class="form-label required">Report SC data agree?</label>
                                <select id="c_report_sc_agree" class="form-control"  required 
                                    wire:model.lazy="c_report_sc_agree">
                                    <option  value="">Select</option>
                                    <option value="1">Yes</option>
                                  <option value="0">No</option>
                                  <option value="2">N/A</option>
                              </select>
                                @error('c_report_sc_agree')
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
 <div wire:ignore.self class="modal fade" id="addeStkMgtAvailabilityModal" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="addeStkMgtAvailabilityModal">Add record</h5>
             </div>
             <form wire:submit.prevent='StorageSubmit()'>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-4 mb-3">
                            <label for="">Test Category</label>
                                 <select id="storage_type_id" class="form-control" name="test_type_id" required
                                     wire:model="test_type_id">
                                     <option value="">Select</option>
                                     @foreach ($test_types as $test_type)
                                         <option value="{{ $test_type->id }}">{{ $test_type->name }}</option>
                                     @endforeach
                                 </select>
                                 @error('test_type_id')
                                     <div class="text-danger text-small">{{ $message }}</div>
                                 @enderror
                         </div>
                         <div class="col-md-4 mb-3" title="Reagent & Unit size">
                                <label for="">Reagent & Unit size</label>
                                 <select id="reagent_id" class="form-control" name="reagent_id" required
                                     wire:model="reagent_id">
                                     <option value="">Select</option>
                                     @foreach ($reagents as $reagent)
                                         <option value="{{ $reagent->id }}">{{ $reagent->name }}</option>
                                     @endforeach
                                 </select>
                                 @error('reagent_id')
                                     <div class="text-danger text-small">{{ $message }}</div>
                                 @enderror
                         </div>
                         <div class="col-md-4 mb-3"
                             title="Does the facility carry out these tests (Assessor ask for all ten tracer items and score yes=1 and No=0">
                             <label for="">Does the facility carry out these tests</label>
                             <select class="form-control" wire:model.lazy="test_performed">
                                 <option value="">select</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                                 <option value="2">N/A</option>
                             </select>
                             @error('test_performed')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3" title="Is the Item available? (Score 1/0) - If expired, mark (E)">
                            <label for="">Is the Item available? (Score 1/0)</label>
                             <select class="form-control" wire:model.lazy="item_available">
                                 <option value="">select</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                             </select>
                             @error('item_available')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>

                         <div class="col-md-4 mb-3" title="Is the Stock card available? (1/0)">
                            <label for="">Is the Stock card available?</label>
                             <select class="form-control" wire:model.lazy="stock_card_available">
                                 <option value="">select</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                             </select>
                             @error('stock_card_available')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3"
                             title="Is a physical count (PC) done every month and marked in the stock card (check last 3 complete months) (1/0)">
                             <label for="">Is a physical count done monthly and marked in the SC</label>
                             <select class="form-control" wire:model.lazy="physical_count_done">
                                 <option value="">select</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                             </select>
                             @error('physical_count_done')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3"
                             title="Is the card filled correctly with name, unit size, Min& Max, special storage (1/0)">
                             <label for="">Is the card filled correctly</label>
                             <select class="form-control" wire:model.lazy="stock_card_correct">
                                 <option value="">select</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                             </select>
                             @error('stock_card_correct')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3" title="Balance according to stock card (record no. from the card)">
                            <label for="">Balance according to stock card</label>
                             <input type="number" min="0" step="any" class="form-control"
                                 wire:model.lazy="balance_on_card">
                             @error('balance_on_card')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>

                         <div class="col-md-4 mb-3"
                             title="Count the no. of reagents in stock and record i.e. physical count (PC)">
                             <label for="">No. of reagents in stock and record</label>
                             <input type="number" min="0" step="any" class="form-control"
                                 wire:model.lazy="physical_count">
                             @error('physical_count')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3"
                             title="Does the balance according to the stock card agree with the PC 100%? (1/0)">
                             <label for="">Balance according to the SCagree with the PC 100%?</label>
                             <select class="form-control" wire:model.lazy="balance_matches_physical">
                                 <option value="">select</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                             </select>
                             @error('balance_matches_physical')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3" title="Record the amount issued in the last 3 complete months.">
                            <Label>Amount issued in the last 3 complete month</Label>
                             <input type="number" min="0" step="any" class="form-control"
                                 wire:model.lazy="last_issues">
                             @error('last_issues')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3"
                             title="Record the number of days out of stock in the last 3 complete months.">
                             <Label>No. of days out of stock in the last 3 complete months</Label>
                             <input type="number" min="0" class="form-control"
                                 wire:model.lazy="out_of_stock_days">
                             @error('out_of_stock_days')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>

                         <div class="col-md-4 mb-3"
                             title="Record the average monthly consumption (AMC) as per the stock card. Write NR if not recorded.">
                             <label for="">Average monthly consumption (AMC) as per the</label>
                             <input type="number" min="0" class="form-control"
                                 wire:model.lazy="amc_on_card">
                             @error('amc_on_card')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3"
                             title="Calculate & record the AMC based on the last 3 complete months ">
                             <label for="">Calculate & record the AMC based on the last 3 complete months</label>
                             <input type="number" min="0" class="form-control"
                                 wire:model.lazy="amc_calculated">
                             @error('amc_calculated')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3"
                             title="Does the AMC from the stock card agree with the calculated AMC ±10%? (1/0) Write NR if no record in C11 above">
                             <label for="">AMC from the stock card agree with the calculated AMC</label>
                             <select class="form-control" wire:model.lazy="amc_calculated_matches">
                                 <option value="">select</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                             </select>
                             @error('amc_calculated_matches')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3"
                             title="Does the facility have an ELMIS/EMR installed at the store? (1/0)">
                             <label for="">Does the facility have an ELMIS/EMR installed at the store?</label>
                             <select class="form-control" wire:model.lazy="elmis_installed">
                                 <option value="">select</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                             </select>
                             @error('elmis_installed')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>

                         @if($elmis_installed == 1)
                         <div class="col-md-4 mb-3"
                             title="Record the quantity as per the ELMIS/EMR. Write NR if not recorded.">
                             <label for="">Quantity as per the ELMIS/EMR</label>
                             <input type="number" min="0" class="form-control"
                                 wire:model.lazy="elmis_quantity">
                             @error('elmis_quantity')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="col-md-4 mb-3"
                             title="Does the balance according to the ELMIS/EMR agree with the PC 100%? (1/0)">
                             <label for="">Does the balance according to the ELMIS/EMR agree with the PC 100%</label>
                             <select class="form-control" wire:model.lazy="elmis_balance_matches">
                                 <option value="">select</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                             </select>
                             @error('elmis_balance_matches')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         @endif
                        </div>
                    </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"
                         wire:click="close()">{{ __('close') }}</button>
                         <x-button type="submit" class="btn-success btn-sm fa fa-save">{{ __('Save') }}</x-button>
                 </div><!--end modal-footer-->
             </form>

         </div>
     </div>
 </div>

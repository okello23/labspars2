 <div wire:ignore.self class="modal fade" id="addeAccuracyModal" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="addeAccuracyModal">Add New</h5>
             </div>
             <form wire:submit.prevent="saveServiceAccuracy">
                 <div class="modal-body">
                     <div class="row">
                         <div class="mb-3 col-md-4">
                             <label for="service_name" class="form-label required"> Service Name</label>
                             <select class="form-control selectr" id="service_name" wire:model='service_name'>
                                 <option value="">Select</option>
                                 <option value ="Blood slide (Malaria)">Blood slide (Malaria)</option>
                                 <option value ="HIV (Determine)">HIV (Determine)</option>
                                 <option value ="TB (GeneXpert )">TB (GeneXpert )</option>
                             </select>
                             @error('service_name')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>

                         <div class="mb-3 col-md-3">
                             <label for="service_statistics_available" class="form-label required">Available?</label>
                             <select id="service_statistics_available" class="form-control" required wire:model.lazy="service_statistics_available">
                                 <option value="">Select</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                              <option value="2">N/A</option>
                            </select>
                             @error('service_statistics_available')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="mb-3 col-md-5">
                             <label for="hims_tests_reported" class="form-label required">No of tests as reported on HMIS 105
                                 </label>
                             <input type="number" id="hims_tests_reported" wire:model='hims_tests_reported' class="form-control" required>
                             @error('hims_tests_reported')
                                 <div class="text-danger text-small">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="mb-3 col-md-6">
                            <label for="lab_reg_tests_reported" class="form-label required">No of tests as recorded in lab register in that month
                                </label>
                            <input type="number" id="hims_tests_reported" wire:model='lab_reg_tests_reported' class="form-control" required>
                            @error('lab_reg_tests_reported')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="hims_lab_tests_balance" class="form-label required">Do the two agree? (1/0/NA)</label>
                            <select id="hims_lab_tests_balance" class="form-control"  required 
                                wire:model.lazy="hims_lab_tests_balance">
                                <option  value="">Select</option>
                                <option value="1">Yes</option>
                              <option value="0">No</option>
                              <option value="2">N/A</option>
                          </select>
                            @error('hims_lab_tests_balance')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>      

                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"
                         wire:click="close()">{{ __('close') }}</button>
                     @if ($toggleForm)
                         <x-button type="submit" class="btn-success btn-sm">{{ __('Update') }}</x-button>
                     @else
                         <x-button type="submit" class="btn-success btn-sm">{{ __('Save') }}</x-button>
                     @endif
                 </div><!--end modal-footer-->
             </form>

         </div>
     </div>
 </div>

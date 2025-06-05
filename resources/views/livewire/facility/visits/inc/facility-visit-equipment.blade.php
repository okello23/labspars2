   <div class="p-2">
       <h3>Laboratory Equipment Form</h3>

       <!-- Section 16: Developing and Maintaining Facility Equipment Inventory -->
       <h4 class="section-title">16. Developing and Maintaining Facility Equipment Inventory</h4>
       <div class="table-responsive-sm">
           <table class="table-sm">
               <thead>
                   <tr>
                       <th>No.</th>
                       <th>Responses</th>
                       <th>Score</th>
                       <th>Comments</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td>1</td>
                       <td>Is the Laboratory Equipment Inventory Log (HMIS Lab 20) available? </td>
                       <td>
                           <select class="form-control" wire:model="inventory_log_available" required>
                               <option value="">select</option>
                               <option value="1">Yes</option>
                               <option value="0">No</option>
                           </select>
                           @error('inventory_log_available')
                               <div class="text-danger text-small">{{ $message }}</div>
                           @enderror
                       </td>
                   </tr>
                   <tr>
                       <td>2</td>
                       <td>Has the Laboratory Inventory Log been updated in the last 1 calendar year (Check the Log was
                           updated in the last 1 year (yes= 1, No=0)</td>
                       <td>
                           <select class="form-control" wire:model="inventory_log_updated">
                               <option value="">select</option>
                               <option value="1">Yes</option>
                               <option value="0">No</option>
                           </select>
                       </td>
                       <td colspan="2">
                           <textarea class="form-control" type="text" wire:model="equipment_maintenance_comment"></textarea>
                       </td>
                   </tr>
               </tbody>
           </table>
       </div>
       <p class="text-info">
           <strong>Score:</strong> Sum of 1 & 2 divided by 2 <u> {{ $equipment_maintenance_score ?? 'N/A' }} </u>
           <strong>Percentage:</strong>
           {{ $equipment_maintenance_percentage !== null ? $equipment_maintenance_percentage . '%' : 'N/A' }} </u>
       </p>

       <!-- Section 17: Equipment Management Plan -->
       <h4 class="section-title">17. Equipment Management Plan to Ensure Functionality</h4>
       <div class="table-responsive-sm">
           <table class="table-sm">
               <thead>
                   <tr>
                       <th>No.</th>
                       <th>Responses</th>
                       <th>Score</th>
                       <th>Comments</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td>1</td>
                       <td>Is relevant major equipment service information readily available in the laboratory?</td>
                       <td>
                           <select class="form-control" wire:model.lazy="service_info_available">
                               <option value="">select</option>
                               <option value="1">Yes</option>
                               <option value="0">No</option>
                           </select>
                       </td>
                       <td><input type="text" name="comments_1"></td>
                   </tr>
                   <tr>
                       <td>2</td>
                       <td>Is major equipment routinely serviced according to schedule and documented in the service
                           logs?
                       </td>
                       <td>
                           <select class="form-control" wire:model.lazy="equipment_serviced">
                               <option value="">select</option>
                               <option value="1">Yes</option>
                               <option value="0">No</option>
                           </select>
                       </td>
                   </tr>
                   <tr>
                       <td>3</td>
                       <td>Is internal quality control (IQC) performed for major equipment?</td>
                       <td>
                           <select class="form-control" wire:model.lazy="iqc_performed">
                               <option value="">select</option>
                               <option value="1">Yes</option>
                               <option value="0">No</option>
                           </select>
                       </td>
                   </tr>
                   <tr>
                       <td>4</td>
                       <td>Are the manufacturers' operator manuals for major equipment readily available?</td>
                       <td>
                           <select class="form-control" wire:model.lazy="operator_manuals_available">
                               <option value="">select</option>
                               <option value="1">Yes</option>
                               <option value="0">No</option>
                           </select>
                       </td>
                       <td rowspan="3">
                           <textarea class="form-control" wire:model.lazy="equipment_mgt_comments"></textarea>
                       </td>
                   </tr>
               </tbody>
           </table>
       </div>
       <h4>Score: Sum (1 to 4)</h4>
       <p class="text-info">
           <strong>Score:</strong> Sum of 1 & 4 <u> {{ $equipment_mgt_plan_score ?? 'N/A' }} </u>
           <strong>Percentage:</strong>
           {{ $equipment_mgt_plan_percentage !== null ? $equipment_mgt_plan_percentage . '%' : 'N/A' }} </u>
       </p>

       <!-- Section 18: Equipment Functionality -->
       <h4 class="section-title">18. Equipment Functionality</h4>

       <button class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
           data-target="#addequipmentFunctionality">
           Add New
       </button>
       <label>Has the laboratory provided uninterrupted testing services with no disruptions due to equipment
           downtime?</label>
       {{-- <select wire:model="uninterrupted_services">
           <option value="yes">Yes</option>
           <option value="no">No</option>
           <option value="na">N/A</option>
       </select> --}}

       <h4>Equipment Downtime</h4>
       <div class="table-responsive-sm">
           <table class="table-sm">
               <thead>
                   <tr>
                       <th>Equipment</th>
                       <th>Is the equipment functional?</th>
                       <th>Duration of downtime (months)</th>
                       <th>Non-functional due to hardware/software</th>
                       <th>Non-functional due to reagents</th>
                       <th>Non-functional due to other factors</th>
                       <th>Response time (months)</th>
                   </tr>
               </thead>
               <tbody>
                   @forelse ($functionalities as $functionality)
                       <tr>
                           <td>{{ $functionality->equipment_name }}({{ $functionality->equipment_type }})</td>
                           <td>{{ $functionality->functional }}</td>
                           <td>{{ $functionality->downtime }}</td>
                           <td>{{ $functionality->nonfunctional_hw }}</td>
                           <td>{{ $functionality->nonfunctional_reagents }}</td>
                           <td>{{ $functionality->other_factors }}</td>
                           <td>{{ $functionality->response_time }}
                               <a href="javascript:void(0)"
                                   wire:click="confirmDelete({{ $functionality->id }}, '{{ addslashes(get_class($functionality)) }}')"
                                   class="text-danger float-right fa fa-trash"></a>
                           </td>
                       </tr>
                   @empty
                       <tr>
                           <td colspan="7">No record entered</td>
                       </tr>
                   @endforelse
                   <!-- Repeat for other equipment types -->
               </tbody>
           </table>
       </div>
       <!-- Section 19: Equipment Utilization -->
       <h4 class="section-title">19. Equipment Utilization for Chemistry, Hematology, and CD4 Platforms
           <a class="action-ico mx-1 btn btn-sm btn-success" data-toggle="modal" data-target="#addequipmentUtilization"
               wire:click="$set('equipment_type','CD4')">
               Add CD4 Equipment</a>
       </h4>
       <div class ="cd4">
           <div class="table-responsive-sm">
               <table class="table-sm">
                   <thead>
                       <tr>
                           <th colspan="9" class="text-center">1.CD4 Equipment </th>
                       </tr>
                       <tr>
                           <th>Equipment Name</th>
                           <th>Throughput (per day)</th>
                           <th>Average no. of days running per month</th>
                           <th>Average actual output</th>
                           <th>Average expected output</th>
                           <th>% Utilization ((D/E)*100)</th>
                           <th>If "F">70%, score 1</th>
                           <th>Capacity of equipment</th>
                           <th>If B=H, score 1</th>
                       </tr>
                   </thead>
                   <tbody>
                       @forelse ($utilizations->where('equipment_type','CD4') as $eutilization)
                           <tr>
                               <td>{{ $eutilization->equipment_name }}({{ $eutilization->equipment_type }})</td>
                               <td>{{ $eutilization->through_put }}</td>
                               <td>{{ $eutilization->running_days }}</td>
                               <td>{{ $eutilization->actual_output }}</td>
                               <td>{{ $eutilization->expected_output }}</td>
                               <td>{{ $eutilization->utilization }}</td>
                               <td>{{ $eutilization->greater_score }}</td>
                               <td>{{ $eutilization->capacity }}</td>
                               <td>{{ $eutilization->final_score }}
                                   <a href="javascript:void(0)"
                                       wire:click="confirmDelete({{ $eutilization->id }}, '{{ addslashes(get_class($eutilization)) }}')"
                                       class="text-danger float-right fa fa-trash"></a>

                               </td>
                           </tr>
                       @empty
                           <td colspan="9">No CD4 record entered</td>
                       @endforelse
                       <!-- Repeat for Chemistry and Hematology Equipment -->
                   </tbody>
               </table>
           </div>
       </div>
       <div class ="Chemistry">
           <a class="action-ico mx-1 btn btn-sm btn-success mb-2" data-toggle="modal"
               data-target="#addequipmentUtilization" wire:click="$set('equipment_type','Chemistry')">
               Add Chemistry Equipment</a>
           <div class="table-responsive-sm">
               <table class="table-sm">
                   <thead>
                       <tr>
                           <th colspan="9" class="text-center">4.Chemistry Equipment </th>
                       </tr>
                       <tr>
                           <th>Equipment Name</th>
                           <th>Throughput (per day)</th>
                           <th>Average no. of days running per month</th>
                           <th>Average actual output</th>
                           <th>Average expected output</th>
                           <th>% Utilization ((D/E)*100)</th>
                           <th>If "F">70%, score 1</th>
                           <th>Capacity of equipment</th>
                           <th>If B=H, score 1</th>
                       </tr>
                   </thead>
                   <tbody>
                       @forelse ($utilizations->where('equipment_type','Chemistry') as $cutilization)
                           <tr>
                               <td>{{ $cutilization->equipment_name }}({{ $cutilization->equipment_type }})</td>
                               <td>{{ $cutilization->through_put }}</td>
                               <td>{{ $cutilization->running_days }}</td>
                               <td>{{ $cutilization->actual_output }}</td>
                               <td>{{ $cutilization->expected_output }}</td>
                               <td>{{ $cutilization->utilization }}</td>
                               <td>{{ $cutilization->greater_score }}</td>
                               <td>{{ $cutilization->capacity }}</td>
                               <td>{{ $cutilization->final_score }}
                                   <a href="javascript:void(0)"
                                       wire:click="confirmDelete({{ $cutilization->id }}, '{{ addslashes(get_class($cutilization)) }}')"
                                       class="text-danger float-right fa fa-trash"></a>

                               </td>
                           </tr>
                       @empty
                           <td colspan="9">No Chemistry record entered</td>
                       @endforelse
                       <!-- Repeat for Chemistry and Hematology Equipment -->
                   </tbody>
               </table>
           </div>
       </div>
       <div class ="Heamatology">
           <a class="action-ico mx-1 mb-1 btn btn-sm btn-success" data-toggle="modal"
               data-target="#addequipmentUtilization" wire:click="$set('equipment_type','Hematology')">
               Add Heamatology Equipment</a>
           <div class="table-responsive-sm">
               <table class="table-sm">
                   <thead>
                       <tr>
                           <th colspan="9" class="text-center">3.Heamatology Equipment </th>
                       </tr>
                       <tr>
                           <th>Equipment Name</th>
                           <th>Throughput (per day)</th>
                           <th>Average no. of days running per month</th>
                           <th>Average actual output</th>
                           <th>Average expected output</th>
                           <th>% Utilization ((D/E)*100)</th>
                           <th>If "F">70%, score 1</th>
                           <th>Capacity of equipment</th>
                           <th>If B=H, score 1</th>
                       </tr>
                   </thead>
                   <tbody>
                       @forelse ($utilizations->where('equipment_type','Hematology') as $hutilization)
                           <tr>
                               <td>{{ $hutilization->equipment_name }}({{ $hutilization->equipment_type }})</td>
                               <td>{{ $hutilization->through_put }}</td>
                               <td>{{ $hutilization->running_days }}</td>
                               <td>{{ $hutilization->actual_output }}</td>
                               <td>{{ $hutilization->expected_output }}</td>
                               <td>{{ $hutilization->utilization }}</td>
                               <td>{{ $hutilization->greater_score }}</td>
                               <td>{{ $hutilization->capacity }}</td>
                               <td>{{ $hutilization->final_score }}
                                   <a href="javascript:void(0)"
                                       wire:click="confirmDelete({{ $hutilization->id }}, '{{ addslashes(get_class($hutilization)) }}')"
                                       class="text-danger float-right fa fa-trash"></a>

                               </td>
                           </tr>
                       @empty
                           <td colspan="9">No Heamatology record entered</td>
                       @endforelse
                       <!-- Repeat for Chemistry and Hematology Equipment -->
                   </tbody>
               </table>
           </div>
       </div>
       <div class ="Heamatology">
           <a class="action-ico mx-1 mb-1 btn btn-sm btn-success" data-toggle="modal"
               data-target="#addequipmentUtilization" wire:click="$set('equipment_type','POC')">
               Add POC Equipment</a>
           <div class="table-responsive-sm">
               <table class="table-sm">
                   <thead>
                       <tr>
                           <th colspan="9" class="text-center">4.Point of Care Equipment </th>
                       </tr>
                       <tr>
                           <th>Equipment Name</th>
                           <th>Throughput (per day)</th>
                           <th>Average no. of days running per month</th>
                           <th>Average actual output</th>
                           <th>Average expected output</th>
                           <th>% Utilization ((D/E)*100)</th>
                           <th>If "F">70%, score 1</th>
                           <th>Capacity of equipment</th>
                           <th>If B=H, score 1</th>
                       </tr>
                   </thead>
                   <tbody>
                       @forelse ($utilizations->where('equipment_type','POC') as $pointofcare)
                           <tr>
                               <td>{{ $pointofcare->equipment_name }}({{ $pointofcare->equipment_type }})</td>
                               <td>{{ $pointofcare->through_put }}</td>
                               <td>{{ $pointofcare->running_days }}</td>
                               <td>{{ $pointofcare->actual_output }}</td>
                               <td>{{ $pointofcare->expected_output }}</td>
                               <td>{{ $pointofcare->utilization }}</td>
                               <td>{{ $pointofcare->greater_score }}</td>
                               <td>{{ $pointofcare->capacity }}</td>
                               <td>{{ $pointofcare->final_score }}
                                   <a href="javascript:void(0)"
                                       wire:click="confirmDelete({{ $pointofcare->id }}, '{{ addslashes(get_class($pointofcare)) }}')"
                                       class="text-danger float-right fa fa-trash"></a>

                               </td>
                           </tr>
                       @empty
                           <td colspan="9">No Point of Care Equipment record entered</td>
                       @endforelse
                       <!-- Repeat for Chemistry and Hematology Equipment -->
                   </tbody>
               </table>
           </div>
       </div>
       @php
           $fields = [
               'visit_id',
               'inventory_log_available',
               'inventory_log_updated',
               'service_info_available',
               'equipment_serviced',
               'iqc_performed',
               'operator_manuals_available',
               'equipment_inv_score',
               'equipment_inv_percentage',
               'equipment_score',
               'equipment_percentage',
               'equipment_mgt_comments',
               'equipment_maintenance_comment',
           ];
       @endphp

       @foreach ($fields as $field)
           @error($field)
               <div class="text-danger text-small">{{ $message }}</div>
           @enderror
       @endforeach
       @include('livewire.facility.visits.inc.new-eqt-fuctionalty-modal')
       @include('livewire.facility.visits.inc.new-eqt-utilization-modal')
   </div>

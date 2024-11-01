   <div class="p-2">
       <h4>Laboratory Equipment Form</h4>

       <!-- Section 16: Developing and Maintaining Facility Equipment Inventory -->
       <div class="section-title">16. Developing and Maintaining Facility Equipment Inventory</div>
       <table>
           <thead>
               <tr>
                   <th>Area</th>
                   <th>Score</th>
                   <th>Comments</th>
               </tr>
           </thead>
           <tbody>
               <tr>
                   <td>Is the Laboratory Equipment Inventory Log (HMIS Lab 20) available? </td>
                   <td>
                       <select class="form-control" wire:model.lazy="inventory_log_available" required>
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
                   <td>b) Did the facility submit the last order to the warehouse electronically?</td>
                   <td>
                       <select class="form-control" wire:model.lazy="inventory_log_updated">
                           <option value="">select</option>
                           <option value="1">Yes</option>
                           <option value="0">No</option>
                       </select>
                   </td>
                   <td colspan="2">
                       <textarea class="form-control" type="text" wire:model.lazy="inventory_log_updated"></textarea>
                   </td>
               </tr>
           </tbody>
       </table>

       <h4>Score: <span>(Sum of 1 & 2) / 2</span></h4>

       <!-- Section 17: Equipment Management Plan -->
       <div class="section-title">17. Equipment Management Plan to Ensure Functionality</div>
       <table>
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
                   <td>Is major equipment routinely serviced according to schedule and documented in the service logs?
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

       <h4>Score: Sum (1 to 4)</h4>

       <!-- Section 18: Equipment Functionality -->
       <div class="section-title">18. Equipment Functionality</div>

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
       <table>
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
                       <td>{{ $functionality->response_time }}</td>
                   </tr>
               @empty
                   <tr>
                       <td colspan="7">No record entered</td>
                   </tr>
               @endforelse
               <!-- Repeat for other equipment types -->
           </tbody>
       </table>

       <!-- Section 19: Equipment Utilization -->
       <div class="section-title">19. Equipment Utilization for Chemistry, Hematology, and CD4 Platforms

       </div>
       <div class ="cd4">
           <a class="action-ico mx-1 btn btn-sm btn-success" data-toggle="modal" data-target="#addequipmentUtilization"
               wire:click="$set('equipment_type','CD4')">
               Add CD4 Equipment</a>
           <table>
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
                           <td>{{ $eutilization->final_score }}</td>
                       </tr>
                   @empty
                       <td colspan="9">No CD4 record entered</td>
                   @endforelse
                   <!-- Repeat for Chemistry and Hematology Equipment -->
               </tbody>
           </table>
       </div>
       <div class ="Chemistry">
           <a class="action-ico mx-1 btn btn-sm btn-success" data-toggle="modal" data-target="#addequipmentUtilization"
               wire:click="$set('equipment_type','Chemistry')">
               Add Chemistry Equipment</a>
           <table>
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
                   @forelse ($utilizations->where('equipment_type','Chemistry') as $eutilization)
                       <tr>
                           <td>{{ $eutilization->equipment_name }}({{ $eutilization->equipment_type }})</td>
                           <td>{{ $eutilization->through_put }}</td>
                           <td>{{ $eutilization->running_days }}</td>
                           <td>{{ $eutilization->actual_output }}</td>
                           <td>{{ $eutilization->expected_output }}</td>
                           <td>{{ $eutilization->utilization }}</td>
                           <td>{{ $eutilization->greater_score }}</td>
                           <td>{{ $eutilization->capacity }}</td>
                           <td>{{ $eutilization->final_score }}</td>
                       </tr>
                   @empty
                       <td colspan="9">No Chemistry record entered</td>
                   @endforelse
                   <!-- Repeat for Chemistry and Hematology Equipment -->
               </tbody>
           </table>
       </div>
       <div class ="Heamatology">
           <a class="action-ico mx-1 btn btn-sm btn-success" data-toggle="modal" data-target="#addequipmentUtilization"
               wire:click="$set('equipment_type','Heamatology')">
               Add Heamatology Equipment</a>
           <table>
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
                   @forelse ($utilizations->where('equipment_type','Heamatology') as $eutilization)
                       <tr>
                           <td>{{ $eutilization->equipment_name }}({{ $eutilization->equipment_type }})</td>
                           <td>{{ $eutilization->through_put }}</td>
                           <td>{{ $eutilization->running_days }}</td>
                           <td>{{ $eutilization->actual_output }}</td>
                           <td>{{ $eutilization->expected_output }}</td>
                           <td>{{ $eutilization->utilization }}</td>
                           <td>{{ $eutilization->greater_score }}</td>
                           <td>{{ $eutilization->capacity }}</td>
                           <td>{{ $eutilization->final_score }}</td>
                       </tr>
                   @empty
                       <td colspan="9">No Heamatology record entered</td>
                   @endforelse
                   <!-- Repeat for Chemistry and Hematology Equipment -->
               </tbody>
           </table>
       </div>
       @include('livewire.facility.visits.inc.new-eqt-fuctionalty-modal')
       @include('livewire.facility.visits.inc.new-eqt-utilization-modal')
   </div>

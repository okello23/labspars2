   <div class="p-2">
       <h3>Laboratory Equipment Form</h3>

       <!-- Section 16: Developing and Maintaining Facility Equipment Inventory -->
       <h4 class="section-title">16. Developing and Maintaining Facility Equipment Inventory</h4>
       <div class="table-responsive-sm">
           <table class="table-sm">
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
                        {{ checkYesNoNA($equipmentMgt?->inventory_log_available) }}
                       </td>
                   </tr>
                   <tr>
                       <td>b) Did the facility submit the last order to the warehouse electronically?</td>
                       <td>
                        {{ checkYesNoNA($equipmentMgt?->inventory_log_updated) }}
                       </td>
                       <td colspan="2">
                        <p>{{ $equipmentMgt?->equipment_maintenance_comment }}</p>
                       </td>
                   </tr>
               </tbody>
           </table>
       </div>
       <h4>Score: <span>(Sum of 1 & 2) / 2</span></h4>

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
                        {{ checkYesNoNA($equipmentMgt?->service_info_available) }}
                       </td>
                       {{-- <td><input type="text" name="comments_1"></td> --}}
                   </tr>
                   <tr>
                       <td>2</td>
                       <td>Is major equipment routinely serviced according to schedule and documented in the service
                           logs?
                       </td>
                       <td>
                        {{ checkYesNoNA($equipmentMgt?->equipment_serviced) }}

                       </td>
                   </tr>
                   <tr>
                       <td>3</td>
                       <td>Is internal quality control (IQC) performed for major equipment?</td>
                       <td>
                        {{ checkYesNoNA($equipmentMgt?->iqc_performed) }}
                       </td>
                   </tr>
                   <tr>
                       <td>4</td>
                       <td>Are the manufacturers' operator manuals for major equipment readily available?</td>
                       <td>
                        {{ checkYesNoNA($equipmentMgt?->operator_manuals_available) }}

                       </td>
                       <td rowspan="4">
                        <p>{{ $equipmentMgt?->equipment_mgt_comments }}</p>
                        </td>
                   </tr>
               </tbody>
           </table>
       </div>
       <h4>Score: Sum (1 to 4)</h4>

       <!-- Section 18: Equipment Functionality -->
       <h4 class="section-title">18. Equipment Functionality</h4>

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
   </div>

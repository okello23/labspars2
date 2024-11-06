<h1>Laboratory Information System</h1>

<!-- Section 20: Availability & Use of Laboratory Data Collection Tools -->
<h2>20. Availability & Use of Laboratory Data Collection Tools wire:
    <a class="action-ico mx-1 btn btn-sm btn-success" data-toggle="modal" data-target="#addeDataCollectionToolScore">
               Add scores</a>
</h2>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Available? (1/0)</th>
            <th>In Use? (1/0)</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($dcToolScores as $key=>$dcToolScore)
        <tr>
            <td>A</td>
            <td>{{ $dcToolScore->dcTool->name }}</td>
            <td>
                {{ $dcToolScore->dct_availability_score }}
            </td>
            <td>
              {{ $dcToolScore->dct_usage_score }}
            </td>
            <td></td>
        </tr>
        @empty
            <tr>
                <td colspan="5">No scores yet</td>
            </tr>
        @endforelse
       <tr>
        <td colspan="2">
            <b>Sum</b>
        </td>
        <td></td>
        <td></td>
        <td>
            <textarea class="form-control" wire:model="lis_tools_comments"></textarea>
        </td>
       </tr>
       
    </tbody>
</table>

<p>
    <strong>Score - Available:</strong> Sum of A to P divided by 16 minus NA: ______
    <strong>Percentage - Available:</strong> _______%<
    <strong>Score - In Use:</strong> Sum of A to P divided by 16 minus NA: ______
    <strong>Percentage - In Use:</strong> _______%<br>
    <strong>Sum of Available + In Use:</strong> _______
    <strong>Percentage:</strong> _______%
</p>

<!-- Section 21: Availability of HMIS 105 Reports -->
<h2>21. Availability of HMIS 105 Reports</h2>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Score (1/0)</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Does the laboratory keep copies of the Laboratory HMIS 105 Health Unit Outpatient Monthly Report Section
                10 pages 26 & 27?</td>
            <td>
                <select class="form-control"  id="hmis_105_outpatient_report" wire:model='hmis_105_outpatient_report'>
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>Does the facility have HMIS 105 Monthly reports for the previous 2 months?</td>
            <td>
                <select class="form-control"  id="hmis_105_previous_months" wire:model='hmis_105_previous_months'>
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
            <td rowspan="2"><textarea class="form-control" wire:model="lis_availability_comments"></textarea></td>
        </tr>
    </tbody>
</table>

<p>
    <strong>Score:</strong> Sum of 2 divided by 2: ______
    <strong>Percentage:</strong> _______%
</p>

<!-- Section 22: Timeliness of HMIS 105 Reports -->
<h2>22. Timeliness of HMIS 105 Reports</h2>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Score (1/0)</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Date HMIS 105 Section 10 pages 26 & 27 report was submitted to the district?</td>
            <td>
                <select class="form-control"  id="t_reports_submitted_to_district" wire:model='t_reports_submitted_to_district'>
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
            {{-- <td><input type="text" wire:model="comments_submitted_on_time"></td> --}}
        </tr>
        <tr>
            <td>3</td>
            <td>Was the HMIS 105 Section 10 pages 26 & 27 report submitted to the district on time?</td>
            <td>
                <select class="form-control"  id="t_reports_submitted_on_time" wire:model='t_reports_submitted_on_time'>
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
            <td><textarea class="form-control" wire:model="timeliness_comments"></textarea></td>
        </tr>
    </tbody>
</table>

<p>
    <strong>Score:</strong> ______
    <strong>Percentage:</strong> _______%
</p>

<!-- Section 23: Completeness and Accuracy of HMIS 105 Report -->
<h2>23. Completeness and Accuracy of HMIS 105 Report</h2>
<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Score (1/0)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>HMIS 105 report section 6 is completely filled (No blanks left)</td>
            <td><select class="form-control"  wire:model="hmis_section_6_complete">
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>HMIS 105 report section 10 is completely filled (No blanks left)</td>
            <td>
            <select class="form-control"  wire:model="hmis_section_10_complete">
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            </td>
        </tr>
    </tbody>
</table>

<p>
    <strong>Sum of (i & ii) divided by 2:</strong> _______
    <strong>Accuracy = Sum/(7 - NA):</strong> _______
</p>

<!-- Section 24: Use of Laboratory Data -->
<h2>24. Use of Laboratory Data
    <a class="action-ico mx-1 btn btn-sm btn-success" data-toggle="modal" data-target="#addeDataUsageModal">
        Add scores</a>
</h2>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Available? (1/0)</th>
            <th>Updated in Last Quarter? (1/0)</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($collection as $item)            
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>Table/Graph/Chart/Map</td>
            <td>
                <select class="form-control"  wire:model="section_10_complete">
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
            <td>
                <select class="form-control"  wire:model="section_10_complete">
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
            <td><input type="text" wire:model="comments_table_graph_chart_map"></td>
        </tr>
        @empty
            <tr>
                <td></td>
            </tr>
        @endforelse
    </tbody>
</table>

<p>
    <strong>Score:</strong> Sum of 2 divided by 2: _______
    <strong>Percentage:</strong> _______%
</p>

<!-- Section 25: Filing of Reports -->
<h2>25. Filing of Reports</h2>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Score (1/0/NA)</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>HMIS 105 (Section 10) monthly reports (Last 2 months)</td>
            <td><select class="form-control" wire:model="hmis_105_section_10">
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select></td>
            {{-- <td><input type="text" wire:model="comments_hmis_105_section_10"></td> --}}
        </tr>
        <tr>
            <td>2</td>
            <td>HMIS Lab 024 Bimonthly Report & Order Calculation Form for HIV Test Kits (Last 2 order cycles)</td>
            <td><select class="form-control" wire:model="hmis_lab_024">
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            </td>
            <td><input type="text" wire:model="comments_hmis_lab_024"></td>
        </tr>
        <tr>
            <td>3</td>
            <td>HMIS 025 Laboratory Order Form (Last 2 order cycles)</td>
            <td><select class="form-control" wire:model="hmis_lab_024">
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            </td>
            <td><input type="text" wire:model="comments_hmis_lab_024"></td>
        </tr>
        <tr>
            <td>4</td>
            <td>HMIS PHAR 020 Requisition & Issue vouchers (Last 2 weeks)</td>
            <td><select class="form-control" wire:model="hmis_lab_024">
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            </td>
            <td><input type="text" wire:model="comments_hmis_lab_024"></td>
        </tr>
        <!-- Add more rows for other items as needed -->
    </tbody>
</table>

<p>
    <strong>Score:</strong> Sum of 4 divided by 4: _______
    <strong>Percentage:</strong> _______%
</p>
@include('livewire.facility.visits.inc.new-data-collection-score-modal')
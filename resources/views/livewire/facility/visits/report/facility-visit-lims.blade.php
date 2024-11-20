<h1>Laboratory Information System</h1>

<!-- Section 20: Availability & Use of Laboratory Data Collection Tools -->
<h2>20. Availability & Use of Laboratory Data Collection Tools wire:
</h2>
<table class="table-sm">
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
                <td>{{ $key + 1 }}</td>
                <td>{{ $dcToolScore->dcTool->name }}</td>
                <td>
                    {{ $dcToolScore->dct_availability_score }}
                </td>
                <td>
                    {{ $dcToolScore->dct_usage_score }}
                </td>
                <td>
                        <a href="javascript:void(0)" wire:click="confirmDelete({{ $dcToolScore->id }}, '{{ addslashes(get_class($dcToolScore)) }}')" class="text-danger float-right fa fa-trash"></a>
                </td>
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
    <strong>Percentage - Available:</strong> _______%< <strong>Score - In Use:</strong> Sum of A to P divided by 16
        minus NA: ______
        <strong>Percentage - In Use:</strong> _______%<br>
        <strong>Sum of Available + In Use:</strong> _______
        <strong>Percentage:</strong> _______%
</p>

<!-- Section 21: Availability of HMIS 105 Reports -->
<h2>21. Availability of HMIS 105 Reports</h2>
<table class="table-sm">
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
                <select class="form-control" id="hmis_105_outpatient_report" wire:model='hmis_105_outpatient_report'>
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
                <select class="form-control" id="hmis_105_previous_months" wire:model='hmis_105_previous_months'>
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
            <td rowspan="2">
                <textarea class="form-control" wire:model="lis_availability_comments"></textarea>
            </td>
        </tr>
    </tbody>
</table>
<div class="mb-3">
    <label for="">Availability of HMIS 105 Report Comment</label>
    <textarea class="form-control" wire:model="hmis_105_report_comments"></textarea>
</div>
<p>
    <strong>Score:</strong> Sum of 2 divided by 2: ______
    <strong>Percentage:</strong> _______%
</p>

<!-- Section 22: Timeliness of HMIS 105 Reports -->
<h2>22. Timeliness of HMIS 105 Reports</h2>
<table class="table-sm">
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
                <select class="form-control" id="t_reports_submitted_to_district"
                    wire:model='t_reports_submitted_to_district'>
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
                <select class="form-control" id="t_reports_submitted_on_time" wire:model='t_reports_submitted_on_time'>
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
            <td>
                <textarea class="form-control" wire:model="timeliness_comments"></textarea>
            </td>
        </tr>
    </tbody>
</table>

<p>
    <strong>Score:</strong> ______
    <strong>Percentage:</strong> _______%
</p>

<!-- Section 23: Completeness and Accuracy of HMIS 105 Report -->
<h2>23. Completeness and Accuracy of HMIS 105 Report</h2>
<table class="table-sm">
    <thead>
        <tr>
            <th>Item</th>
            <th>Score (1/0)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>HMIS 105 report section 6 is completely filled (No blanks left)</td>
            <td><select class="form-control" wire:model="hmis_section_6_complete">
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>HMIS 105 report section 10 is completely filled (No blanks left)</td>
            <td>
                <select class="form-control" wire:model="hmis_section_10_complete">
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

</p>
<!-- Section 24: Use of Laboratory Data -->
<h4>b) Check the accuracy of the last HMIS 105 report (Yes=1/ No=0):

    </h3>
    <table class="table-sm">
        <thead>
            <tr>
                <th   colspan="2">Stock Status</th>
                <th colspan="3">Reported in HMIS 105</th>
                <th colspan="3">Actual (recounted) in stock card/book</th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th>Is the previous HMIS 105 report and the stock card/book for the following commodities available?
                    (1/0/NA)</th>
                <th>Quantity consumed</th>
                <th>No. Of days out of stock</th>
                <th>Stock on hand</th>
                <th>Quantity consumed</th>
                <th>No. Of days out of stock</th>
                <th>Stock on hand</th>
                <th>Do the report and stock card/book data agree? (1/0/NA)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stockStatuses as $key=>$stockStatus)
            <tr>
                <td>{{ $key+1 }} {{ $stockStatus->stkItem->name }}</td>
                <td>{{ $stockStatus->c_reports_available }}</td>
                <td>{{ $stockStatus->chmis_qty_consumed }}</td>
                <td>{{ $stockStatus->chmis_days_out_of_stock }}</td>
                <td>{{ $stockStatus->chmis_Stock_on_hand }}</td>
                <td>{{ $stockStatus->csc_qty_consumed }}</td>
                <td>{{ $stockStatus->csc_days_out_of_stock }}</td>
                <td>{{ $stockStatus->csc_Stock_on_hand }}</td>
                <td>{{ $stockStatus->c_report_sc_agree }}
                 </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">No records yet</td>
            </tr>
            @endforelse
           
        </tbody>
    </table>
    <!-- Section 24: Use of Laboratory Data -->
    <h3>c) Check the accuracy of the last HMIS 105 report (Yes=1/ No=0):
    </h3>
    <table class="table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Service statistics</th>
                <th>Information on Service statistics
                    Available? (1/0)</th>
                <th>No of tests as reported on HMIS 105</th>
                <th>No of tests as recorded in lab register in that month</th>
                <th>Do the two agree? (1/0/NA)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($services as $key => $service)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $service->service_name }}</td>
                    <td>{{ $service->service_statistics_available }}</td>
                    <td>{{ $service->hims_tests_reported }}</td>
                    <td>{{ $service->lab_reg_tests_reported }}</td>
                    <td>{{ $service->hims_lab_tests_balance }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No entries</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Section 24: Use of Laboratory Data -->
    <h2>24. Use of Laboratory Data
    </h2>
    <table class="table-sm">
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
            @forelse ($lisLabDataUsages as $lisLabDataUsage)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $lisLabDataUsage->item_name }}</td>
                    <td>{{ $lisLabDataUsage->is_available }}</td>
                    <td>{{ $lisLabDataUsage->updated_last_quarter }}</td>
                    <td>{{ $lisLabDataUsage->comments }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No entries</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mb-3">
        <label for="">Use of Laboratory Data Comment</label>
        <p>{{ $limsData?->lab_data_usage_comments }}</p>

    </div>
    <p>
        <strong>Score:</strong> Sum of 2 divided by 2: _______
        <strong>Percentage:</strong> _______%
    </p>

    <!-- Section 25: Filing of Reports -->
    <h2>25. Filing of Reports
    </h2>
    <table class="table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Score (1/0/NA)</th>
                {{-- <th>Comments</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($filedReports as $key => $filedReport)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $filedReport->report->name }}</td>
                    <td>{{ $filedReport->filling_score }}
                    </td>
                    {{-- <td><input type="text" wire:model="comments_hmis_105_section_10"></td> --}}
                </tr>
            @endforeach

            <!-- Add more rows for other items as needed -->
        </tbody>
    </table>
    <div class="mb-3">
        <label for="">Filing of Reports omment</label>
        <p>{{ $limsData?->reports_filling_comments }}</p>
    </div>
    <p>
        <strong>Score:</strong> Sum of 4 divided by 4: _______
        <strong>Percentage:</strong> _______%
    </p>
<div>
    @php
        $isPdfExport = $isPdfExport ?? false;
        $lisTotal = ($lis_mgt['availability_and_use_of_data_tool'] ?? 0)
            + ($lis_mgt['availability_of_hmis_reports'] ?? 0)
            + ($lis_mgt['timeliness_of_hmis_reports'] ?? 0)
            + ($lis_mgt['completeness_and_accuracy_of_hmis105_report'] ?? 0)
            + ($lis_mgt['lab_data_use'] ?? 0)
            + ($lis_mgt['report_filing'] ?? 0);
        $stockSpiderScore = round((collect($stock_management)->avg() ?? 0) * 5, 2);
        $storageSpiderScore = round((collect($storage_management)->avg() ?? 0), 2);
        $orderingSpiderScore = round((collect($ordering_management)->avg() ?? 0), 2);
        $equipmentSpiderScore = round((collect($equipment_management)->avg() * 5 ?? 0), 2);
        $lisSpiderScore = round(($lisTotal / 6) * 5, 2);
        $spiderValues = [
            'Stock Management' => $stockSpiderScore,
            'Storage' => $storageSpiderScore,
            'Ordering' => $orderingSpiderScore,
            'Equipment' => $equipmentSpiderScore,
            'LIS' => $lisSpiderScore,
        ];
        $spiderChartSize = 460;
        $spiderChartCenter = $spiderChartSize / 2;
        $spiderChartRadius = 150;
        $spiderSteps = 5;
        $spiderAxisCount = count($spiderValues);
        $spiderPoints = [];

        foreach (array_values($spiderValues) as $index => $value) {
            $angle = deg2rad(-90 + (($index * 360) / max($spiderAxisCount, 1)));
            $distance = $spiderChartRadius * (max(min($value, 5), 0) / 5);
            $spiderPoints[] = round($spiderChartCenter + cos($angle) * $distance, 2) . ',' . round($spiderChartCenter + sin($angle) * $distance, 2);
        }
    @endphp
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @if ($isPdfExport)
        @page {
            margin: 18px 16px;
        }
        @endif
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            color: #2c3e50;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        header {
            background: linear-gradient(to right, #1a5276, #2874a6);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        header h1 { font-size: 28px; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 5px; }
        .content-wrapper { display: flex; flex-wrap: wrap; padding: 20px; }
        .indicators-section, .spider-section { flex: 1; min-width: 300px; padding: 20px; }
        .section-title {
            background: linear-gradient(to right, #2874a6, #3498db);
            color: white;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 500;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        th {
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
            color: #2c3e50;
            font-weight: 600;
            text-align: left;
            padding: 15px;
            border: 1px solid #dee2e6;
        }
        td { padding: 7px 10px; border: 1px solid #dee2e6; }
        .category-header {
            background: linear-gradient(to right, #d6eaf8, #aed6f1);
            font-weight: 600;
            font-size: 16px;
        }
        .indicator-item { background-color: #f8f9fa; }
        .indicator-item:nth-child(even) { background-color: #edf2f7; }
        .total-row {
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
            font-weight: 600;
        }
        .spider-row {
            background: linear-gradient(to right, #d1f2eb, #a3e4d7);
            font-weight: 500;
        }
        .spider-graph {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-top: 30px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }
        .spider-graph-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1a5276;
        }
        .spider-chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            overflow: hidden;
        }
        .basic-info-table {
            table-layout: fixed;
        }
        .basic-info-table th {
            width: 18%;
        }
        .basic-info-table td {
            width: 32%;
        }
        .spider-graph-card {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .spider-svg {
            max-width: 100%;
            height: auto;
        }
        .score-summary-table thead td,
        .score-summary-table thead th {
            font-weight: 600;
        }
        .action-links {
            margin-top: 12px;
        }
        .action-links a {
            display: inline-block;
            margin: 0 6px;
            text-decoration: none;
        }
        .key-assessment {
            background: linear-gradient(to right, #1a5276, #2874a6);
            color: white;
            padding: 15px 30px;
            text-align: center;
            font-size: 18px;
            font-weight: 500;
            margin-top: 20px;
        }
        footer {
            padding: 20px;
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
            border-top: 1px solid #ecf0f1;
        }
        @if ($isPdfExport)
        body {
            background: #ffffff;
            padding: 0;
            font-size: 11px;
            line-height: 1.4;
        }
        .container {
            max-width: 100%;
            box-shadow: none;
            border-radius: 0;
            overflow: visible;
        }
        header,
        .section-title,
        .category-header,
        .total-row,
        .spider-row,
        .key-assessment {
            background: #ffffff !important;
            color: #2c3e50 !important;
        }
        .content-wrapper {
            display: block;
            padding: 8px;
        }
        table {
            table-layout: fixed;
            box-shadow: none;
            margin-bottom: 18px;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        thead {
            display: table-header-group;
        }
        tbody {
            display: table-row-group;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        th,
        td {
            padding: 5px 6px;
            font-size: 10px;
            line-height: 1.3;
            word-wrap: break-word;
            overflow-wrap: anywhere;
            vertical-align: top;
        }
        h1, h2, h3, h4, h5 {
            margin-bottom: 6px;
            page-break-after: avoid;
            break-after: avoid;
        }
        .header h4 {
            font-size: 16px;
        }
        .card,
        .card-body,
        .card-body > div,
        .score-summary-table,
        .spider-graph-card {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        p,
        label,
        small {
            font-size: 10px;
        }
        .spider-chart-container {
            padding-top: 10px;
        }
        .spider-svg,
        .spider-image {
            max-width: 620px;
        }
        .action-links {
            margin-top: 8px;
        }
        .action-links a {
            font-size: 11px;
        }
        .basic-info-table th,
        .basic-info-table td {
            font-size: 10px;
        }
        @endif
        @media (max-width: 768px) {
            .content-wrapper { flex-direction: column; }
            .indicators-section, .spider-section { width: 100%; }
            .spider-chart { width: 250px; height: 250px; }
        }
    </style>
    <div class="container">
        @include('livewire.facility.visits.inc.visit-header')
        <div class="content-wrapper">
            @include('livewire.facility.visits.inc.report-detailed')

            <div class="header"><h4>Score summary</h4></div>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Lab SPARS Indicators</th>
                        <th colspan="2">Score</th>
                    </tr>
                    <tr>
                        <th>Score</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Helper for percent
                        function percent($score, $mult = 100, $suffix = '%') {
                            return isset($score) ? ($score * $mult) . $suffix : '';
                        }
                        // Helper for safe division
                        function safe_div($num, $div) {
                            return $div ? $num / $div : 0;
                        }
                    @endphp

                    {{-- Stock Management --}}
                    <tr class="category-header"><td colspan="3">Stock management</td></tr>
                    @foreach([
                        ['1. Availability of reagents for selected tests on day of visit', 'availability_score'],
                        ['2. Stock card availability', 'stock_card_score'],
                        ['3. Correct filling of stock card', 'correct_filling_score'],
                        ['4. Does physical count agree with stock card balance?', 'physical_agrees_score'],
                        ['5. Is AMC in the stock card correctly calculated', 'amc_well_calculated_score'],
                        ['6. Is the ELMIS/EMR correctly used and updated?', 'emr_usage_score'],
                    ] as [$label, $key])
                    <tr class="indicator-item">
                        <td>{{ $label }}</td>
                        <td>{{ $stock_management[$key] ?? '' }}</td>
                        <td>{{ percent($stock_management[$key] ?? null) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td><strong>TOTAL (Add 1-6)</strong></td>
                        <td>{{ collect($stock_management)->sum() }}</td>
                        <td>{{ round((collect($stock_management)->avg() ?? 0) * 100, 2) . '%' }}</td>
                    </tr>
                    <tr class="spider-row">
                        <td colspan="3">
                            <strong>Spider Graph Score (TOTAL1/6‐NA) x 5 = {{ $stockSpiderScore }}</strong>
                        </td>
                    </tr>

                    {{-- Storage Areas & Lab Facilities Management --}}
                    <tr class="category-header"><td colspan="3">Storage Areas & Lab Facilities Management</td></tr>
                    @foreach([
                        ['8. Cleanliness of the laboratory including storage facilities', 'cleanliness'],
                        ['9. Hygiene of the Laboratory', 'hygiene'],
                        ['10. System for storage of laboratory reagents and supplies', 'storage_system'],
                        ['11. Storage conditions for laboratory supplies/reagents', 'storage_condition'],
                        ['12. Storage practices of laboratory reagents', 'practice_management'],
                    ] as [$label, $key])
                    <tr class="indicator-item">
                        <td>{{ $label }}</td>
                        <td>{{ isset($storage_management[$key]) ? safe_div($storage_management[$key], 5) : '' }}</td>
                        <td>{{ isset($storage_management[$key]) ? ($storage_management[$key] * 20) . '%' : '' }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td><strong>TOTAL (Add 8-12)</strong></td>
                        <td>{{ safe_div(collect($storage_management)->sum(), 5) }}</td>
                        <td>{{ round((collect($storage_management)->avg() ?? 0) * 20, 2) . '%' }}</td>
                    </tr>
                    <tr class="spider-row">
                        <td colspan="3">
                            <strong>Spider Graph Score (TOTAL2/5‐NA) x 5 = {{ $storageSpiderScore }}</strong>
                        </td>
                    </tr>

                    {{-- Ordering --}}
                    <tr class="category-header"><td colspan="3">Ordering</td></tr>
                    @foreach([
                        ['13. Reorder level calculations', 'order_mgt'],
                        ['14. Adherence to ordering procedures', 'adherence_to_order_practice'],
                        ['15. Availability of current Annual Laboratory Procurement Plan', 'availability_of_procurement_plan'],
                    ] as [$label, $key])
                    <tr class="indicator-item">
                        <td>{{ $label }}</td>
                        <td>{{ isset($ordering_management[$key]) ? safe_div($ordering_management[$key], 5) : '' }}</td>
                        <td>{{ isset($ordering_management[$key]) ? ($ordering_management[$key] * 20) . '%' : '' }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td><strong>TOTAL (Add 15-17)</strong></td>
                        <td>{{ safe_div(collect($ordering_management)->sum(), 5) }}</td>
                        <td>{{ round((collect($ordering_management)->avg() ?? 0) * 20, 2) . '%' }}</td>
                    </tr>
                    <tr class="spider-row">
                        <td colspan="3"><strong>Spider Graph Score (TOTAL3/3‐NA) x 5 = {{ $orderingSpiderScore }} </strong></td>
                    </tr>

                    {{-- Laboratory Equipment --}}
                    <tr class="category-header"><td colspan="3">Laboratory Equipment</td></tr>
                    <tr class="indicator-item"><td>16. Developing and maintaining facility equipment inventory</td><td>-</td><td>-</td></tr>
                    <tr class="indicator-item"><td>17. Equipment management plan to ensure equipment functionality</td><td>-</td><td>-</td></tr>
                    @foreach([
                        ['18. Equipment Management', 'management_score'],
                        ['19. Equipment utilization', 'utilization_score'],
                    ] as [$label, $key])
                    <tr class="indicator-item">
                        <td>{{ $label }}</td>
                        <td>{{ $equipment_management[$key] ?? '' }}</td>
                        <td>{{ isset($equipment_management[$key]) ? $equipment_management[$key]*5 * 20 . '%' : '' }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td><strong>TOTAL (Add 18-21)</strong></td>
                        <td>{{ collect($equipment_management)->sum() }}</td>
                        <td>{{ round((collect($equipment_management)->avg() ?? 0)*5 * 20, 2) . '%' }}</td>
                    </tr>
                    <tr class="spider-row">
                        <td colspan="3"><strong>Spider Graph Score (TOTAL4/4‐NA) x 5 = {{ $equipmentSpiderScore }}  </strong></td>
                    </tr>

                    {{-- Laboratory Information systems --}}
                    <tr class="category-header"><td colspan="3">Laboratory Information systems</td></tr>
                    @foreach([
                        ['20. Availability of laboratory data collection tools', 'availability_and_use_of_data_tool'],
                        ['21. Availability of HMIS 105 reports', 'availability_of_hmis_reports'],
                        ['22. Timeliness of HMIS 105 reports', 'timeliness_of_hmis_reports'],
                        ['23. Completeness and accuracy of HMIS 105 report', 'completeness_and_accuracy_of_hmis105_report'],
                        ['24. Use of Laboratory data', 'lab_data_use'],
                        ['25. Filing of reports', 'report_filing'],
                    ] as [$label, $key])
                    <tr class="indicator-item">
                        <td>{{ $label }}</td>
                        <td>{{ $lis_mgt[$key] ?? '' }}</td>
                        <td>{{ isset($lis_mgt[$key]) ? $lis_mgt[$key]*5 * 20 . '%' : '' }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td><strong>TOTAL (Add 20-25)</strong></td>
                        <td>{{ $lisTotal }}</td>
                        <td>{{ round($lisTotal / 6 * 100, 2) . '%' }}</td>
                    </tr>
                    <tr class="spider-row">
                        <td colspan="3">
                            <strong>
                                Spider Graph Score (TOTAL/6) x 5 = {{ $lisSpiderScore }}
                            </strong>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="score-summary-table" border="1" cellspacing="0" cellpadding="6" style="border-collapse: collapse; width: 100%; text-align: center;">
    <thead>
         <tr class="category-header"><th colspan="4">Thematic Areas Score Summary</th></tr>
        <tr>
            <th>Assessment area</th>
            <th>Maximum score (minus-NA)</th>
            <th>Total scored (Y÷Maximum score)</th>
            <th>SPIDO graph value scaled</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left;">Stock Management</td>
            <td>6</td>
            <td>{{ round(collect($stock_management)->sum()/6,2) }}</td>
            <td>{{ $stockSpiderScore }}</td>
        </tr>
        <tr>
            <td style="text-align: left;">Storage Areas &amp; Lab Facilities Management</td>
            <td>5</td>
            <td>{{ round(safe_div(collect($storage_management)->sum(), 5)/5,2) }}</td>
            <td>{{ $storageSpiderScore }} </td>
        </tr>
        <tr>
            <td style="text-align: left;">Ordering</td>
            <td>3</td>
            <td>{{ safe_div(round(collect($ordering_management)->sum()/3), 5) }}</td>
            <td>{{ $orderingSpiderScore }} </td>
            
        </tr>
        <tr>
            <td style="text-align: left;">Laboratory Equipment</td>
            <td>4</td>
            <td> {{ round(collect($equipment_management)->sum()/2,2) }} </td>
            <td> {{ $equipmentSpiderScore }}  </td>
        </tr>
        <tr>
            <td style="text-align: left;">Laboratory Information systems</td>
            <td>6</td>
            <td>{{ round($lisTotal / 6, 3) }}</td>
            <td>{{ $lisSpiderScore }} </td>
        </tr>
        <tr class="spider-row">
            <td colspan="3" style="text-align: left; font-weight: bold;">Total Spider Graph Score (Max score is 25)</td>
            @php
                $spider_total = 
                    $lisSpiderScore +
                    $equipmentSpiderScore +
                    $orderingSpiderScore +
                    $storageSpiderScore +
                    $stockSpiderScore;
            @endphp
            <td>{{ $spider_total }}</td>
        </tr>
    </tbody>
</table>


            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="card spider-graph-card">
                        <div class="header"><h4>Spider Graph</h4></div>
                        <div class="body">
                            <div class="spider-chart-container">
                                @if ($isPdfExport && !empty($spiderGraphImage))
                                    <img class="spider-image" src="{{ $spiderGraphImage }}" alt="Facility visit spider graph" />
                                @else
                                <svg class="spider-svg" viewBox="0 0 {{ $spiderChartSize }} {{ $spiderChartSize }}" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Facility visit spider graph">
                                    @for ($step = 1; $step <= $spiderSteps; $step++)
                                        @php
                                            $ringPoints = [];
                                            $ringRadius = ($spiderChartRadius / $spiderSteps) * $step;
                                        @endphp
                                        @foreach (array_values($spiderValues) as $index => $value)
                                            @php
                                                $ringAngle = deg2rad(-90 + (($index * 360) / max($spiderAxisCount, 1)));
                                                $ringPoints[] = round($spiderChartCenter + cos($ringAngle) * $ringRadius, 2) . ',' . round($spiderChartCenter + sin($ringAngle) * $ringRadius, 2);
                                            @endphp
                                        @endforeach
                                        <polygon points="{{ implode(' ', $ringPoints) }}" fill="none" stroke="#d8dee9" stroke-width="1"/>
                                    @endfor

                                    @foreach (array_keys($spiderValues) as $index => $label)
                                        @php
                                            $axisAngle = deg2rad(-90 + (($index * 360) / max($spiderAxisCount, 1)));
                                            $axisX = round($spiderChartCenter + cos($axisAngle) * $spiderChartRadius, 2);
                                            $axisY = round($spiderChartCenter + sin($axisAngle) * $spiderChartRadius, 2);
                                            $labelX = round($spiderChartCenter + cos($axisAngle) * ($spiderChartRadius + 38), 2);
                                            $labelY = round($spiderChartCenter + sin($axisAngle) * ($spiderChartRadius + 22), 2);
                                        @endphp
                                        <line x1="{{ $spiderChartCenter }}" y1="{{ $spiderChartCenter }}" x2="{{ $axisX }}" y2="{{ $axisY }}" stroke="#c2cad6" stroke-width="1"/>
                                        <text x="{{ $labelX }}" y="{{ $labelY }}" font-size="13" font-weight="600" fill="#24435b" text-anchor="middle">{{ $label }}</text>
                                    @endforeach

                                    <polygon points="{{ implode(' ', $spiderPoints) }}" fill="#2874a6" fill-opacity="0.20" stroke="#2874a6" stroke-width="3"/>

                                    @foreach (array_values($spiderValues) as $index => $value)
                                        @php
                                            $pointAngle = deg2rad(-90 + (($index * 360) / max($spiderAxisCount, 1)));
                                            $pointRadius = $spiderChartRadius * (max(min($value, 5), 0) / 5);
                                            $pointX = round($spiderChartCenter + cos($pointAngle) * $pointRadius, 2);
                                            $pointY = round($spiderChartCenter + sin($pointAngle) * $pointRadius, 2);
                                        @endphp
                                        <circle cx="{{ $pointX }}" cy="{{ $pointY }}" r="5" fill="#1a5276" stroke="#ffffff" stroke-width="2"/>
                                    @endforeach

                                    @for ($tick = 1; $tick <= $spiderSteps; $tick++)
                                        <text x="{{ $spiderChartCenter + 8 }}" y="{{ $spiderChartCenter - (($spiderChartRadius / $spiderSteps) * $tick) + 5 }}" font-size="11" fill="#5c6b7a">{{ $tick }}</text>
                                    @endfor
                                </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer style="text-align: center;">
            <hr>
            <p>LabSPARS Dashboard v2.0 | © Central Public Health Laboratories. All rights reserved.</p>
            <small>
                Printed By: {{ Auth::user()->name ?? 'Unknown User' }} Printed on {{ now()->format('Y-m-d H:i:s') }}
            </small>
            @if (! $isPdfExport)
            <div class="action-links">
                <a target="_blank" href="{{ route('facility-visit_print', $active_visit->visit_code) }}"
                    class="btn btn-sm btn-info fa fa-print"> Print Form</a>
                <a target="_blank" href="{{ route('facility-visit_print', ['code' => $active_visit->visit_code, 'download' => 1]) }}"
                    class="btn btn-sm btn-success fa fa-download"> Download PDF</a>
            </div>
            @endif
        </footer>
    </div>
</div>

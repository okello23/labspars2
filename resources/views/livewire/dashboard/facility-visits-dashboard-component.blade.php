<div>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        header h1 {
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .content-wrapper {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }

        .indicators-section {
            flex: 1;
            min-width: 300px;
            padding: 20px;
        }

        .spider-section {
            flex: 1;
            min-width: 300px;
            padding: 20px;
        }

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

        td {
            padding: 7px 10px;
            border: 1px solid #dee2e6;
        }

        .category-header {
            background: linear-gradient(to right, #d6eaf8, #aed6f1);
            font-weight: 600;
            font-size: 16px;
        }

        .indicator-item {
            background-color: #f8f9fa;
        }

        .indicator-item:nth-child(even) {
            background-color: #edf2f7;
        }

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

        @media (max-width: 768px) {
            .content-wrapper {
                flex-direction: column;
            }

            .indicators-section,
            .spider-section {
                width: 100%;
            }

            .spider-chart {
                width: 250px;
                height: 250px;
            }
        }
    </style>
    <div class="container">
        

        <div class="content-wrapper">
            {{-- <div class="indicators-section"> --}}
            <div class="section-title">Lab SPARS Indicators</div>

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
                  <tr class="category-header">
                    <td colspan="3">Stock management</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>1. Availability of reagents for selected tests on day of visit</td>
                        <td>{{ $stock_management['availability_score'] ?? '' }}</td>
                        <td>{{ isset($stock_management['availability_score']) ? $stock_management['availability_score'] * 100 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>2. Stock card availability</td>
                        <td>{{ $stock_management['stock_card_score'] ?? '' }}</td>
                        <td>{{ isset($stock_management['stock_card_score']) ? $stock_management['stock_card_score'] * 100 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>3. Correct filling of stock card</td>
                        <td>{{ $stock_management['correct_filling_score'] ?? '' }}</td>
                        <td>{{ isset($stock_management['correct_filling_score']) ? $stock_management['correct_filling_score'] * 100 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>4. Does physical count agree with stock card balance?</td>
                        <td>{{ $stock_management['physical_agrees_score'] ?? '' }}</td>
                        <td>{{ isset($stock_management['physical_agrees_score']) ? $stock_management['physical_agrees_score'] * 100 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>5. Is AMC in the stock card correctly calculated</td>
                        <td>{{ $stock_management['amc_well_calculated_score'] ?? '' }}</td>
                        <td>{{ isset($stock_management['amc_well_calculated_score']) ? $stock_management['amc_well_calculated_score'] * 100 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>6. Is the ELMIS/EMR correctly used and updated?</td>
                        <td>{{ $stock_management['emr_usage_score'] ?? '' }}</td>
                        <td>{{ isset($stock_management['emr_usage_score']) ? $stock_management['emr_usage_score'] * 100 . '%' : '' }}</td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>TOTAL (Add 1-6)</strong></td>
                        <td>{{ collect($stock_management)->sum() }}</td>
                        <td>{{ round((collect($stock_management)->avg() ?? 0) * 100, 2) . '%' }}</td>
                    </tr>
                    <tr class="spider-row">
                        <td colspan="3">
                            <strong>Spider Graph Score (TOTAL1/6‐NA) x 5 = {{ round((collect($stock_management)->avg() ?? 0) * 5, 2) }}</strong>
                        </td>
                    </tr>

                    </tr>
                    <tr class="category-header">
                        <td colspan="3">Storage Areas & Lab Facilities Management</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>8. Cleanliness of the laboratory including storage facilities</td>
                        <td>{{ $storage_management['cleanliness']/5 ?? '' }}</td>
                        <td>{{ isset($storage_management['cleanliness']) ? $storage_management['cleanliness'] * 20 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>9. Hygiene of the Laboratory</td>
                        <td>{{ $storage_management['hygiene']/5 ?? '' }}</td>
                        <td>{{ isset($storage_management['hygiene']) ? $storage_management['hygiene'] * 20 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>10. System for storage of laboratory reagents and supplies</td>
                        <td>{{ $storage_management['storage_system']/5 ?? '' }}</td>
                        <td>{{ isset($storage_management['storage_system']) ? $storage_management['storage_system'] * 20 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>11. Storage conditions for laboratory supplies/reagents</td>
                        <td>{{ $storage_management['storage_condition']/5 ?? '' }}</td>
                        <td>{{ isset($storage_management['storage_condition']) ? $storage_management['storage_condition'] * 20 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>12. Storage practices of laboratory reagents</td>
                        <td>{{ $storage_management['practice_management']/5 ?? '' }}</td>
                        <td>{{ isset($storage_management['practice_management']) ? $storage_management['practice_management'] * 20 . '%' : '' }}</td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>TOTAL (Add 8-12)</strong></td>
                        <td>{{ collect($storage_management)->sum()/5 }}</td>
                        <td>{{ round((collect($storage_management)->avg() ?? 0) * 20, 2) . '%' }}</td>
                    </tr>
                    <tr class="spider-row">
                        <td colspan="3">
                            <strong>Spider Graph Score (TOTAL2/5‐NA) x 5 = {{ round((collect($storage_management)->avg() ?? 0), 2) }}</strong>
                        </td>
                    </tr>


                    <tr class="category-header">
                        <td colspan="3">Ordering</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>13. Reorder level calculations</td>
                        <td>{{ $ordering_management['order_mgt']/5 ?? '' }}</td>
                        <td>{{ isset($ordering_management['order_mgt']) ? $ordering_management['order_mgt'] * 20 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>14. Adherence to ordering procedures</td>
                        <td>{{ $ordering_management['adherence_to_order_practice']/5 ?? '' }}</td>
                        <td>{{ isset($ordering_management['adherence_to_order_practice']) ? $ordering_management['adherence_to_order_practice'] * 20 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>15. Availability of current Annual Laboratory Procurement Plan</td>
                       <td>{{ $ordering_management['availability_of_procurement_plan']/5 ?? '' }}</td>
                       <td>{{ isset($ordering_management['availability_of_procurement_plan']) ? $ordering_management['availability_of_procurement_plan'] * 20 . '%' : '' }}</td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>TOTAL (Add 15-17)</strong></td>
                        <td>{{ collect($ordering_management)->sum()/5 }}</td>
                        <td>{{ round((collect($ordering_management)->avg() ?? 0) * 20, 2) . '%' }}</td>
                    </tr>
                    
                    <tr class="spider-row">
                        <td colspan="3"><strong>Spider Graph Score (TOTAL3/3‐NA) x 5 = {{ round((collect($ordering_management)->avg() ?? 0), 2) }} </strong></td>
                    </tr>

                    <tr class="category-header">
                        <td colspan="3">Laboratory Equipment</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>16. Developing and maintaining facility equipment inventory</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>17. Equipment management plan to ensure equipment functionality</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>18. Equipment Management</td>
                        <td>{{ $equipment_management['management_score'] ?? '' }}</td>
                        <td>{{ isset($equipment_management['management_score']) ? $equipment_management['management_score']*5 * 20 . '%' : '' }}</td>
                    </tr>
                    <tr class="indicator-item">
                        <td>19. Equipment utilization</td>
                        <td>{{ $equipment_management['utilization_score'] ?? '' }}</td>
                        <td>{{ isset($equipment_management['utilization_score']) ? $equipment_management['utilization_score']*5  * 20 . '%' : '' }}</td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>TOTAL (Add 18-21)</strong></td>
                        <td>{{ collect($equipment_management)->sum() }}</td>
                        <td>{{ round((collect($equipment_management)->avg() ?? 0)*5 * 20, 2) . '%' }}</td>
                    </tr>
                    <tr class="spider-row">
                        <td colspan="3"><strong>Spider Graph Score (TOTAL4/4‐NA) x 5 = {{ round((collect($equipment_management)->avg()*5 ?? 0), 2) }}  </strong></td>
                    </tr>

                   <tr class="category-header">
<tr class="category-header">
    <td colspan="3">Laboratory Information systems </td>
</tr>
<tr class="indicator-item">
    <td>20. Availability of laboratory data collection tools</td>
    <td>{{ $lis_mgt['availability_and_use_of_data_tool'] ?? '' }}</td>
    <td>{{ isset($lis_mgt['availability_and_use_of_data_tool']) ? $lis_mgt['availability_and_use_of_data_tool']*5 * 20 . '%' : '' }}</td>
</tr>
<tr class="indicator-item">
    <td>21. Availability of HMIS 105 reports</td>
    <td>{{ $lis_mgt['availability_of_hmis_reports'] ?? '' }}</td>
    <td>{{ isset($lis_mgt['availability_of_hmis_reports']) ? $lis_mgt['availability_of_hmis_reports']*5 * 20 . '%' : '' }}</td>
</tr>
<tr class="indicator-item">
    <td>22. Timeliness of HMIS 105 reports</td>
    <td>{{ $lis_mgt['timeliness_of_hmis_reports'] ?? '' }}</td>
    <td>{{ isset($lis_mgt['timeliness_of_hmis_reports']) ? $lis_mgt['timeliness_of_hmis_reports']*5 * 20 . '%' : '' }}</td>
</tr>
<tr class="indicator-item">
    <td>23. Completeness and accuracy of HMIS 105 report</td>
    <td>{{ $lis_mgt['completeness_and_accuracy_of_hmis105_report'] ?? '' }}</td>
    <td>{{ isset($lis_mgt['completeness_and_accuracy_of_hmis105_report']) ? $lis_mgt['completeness_and_accuracy_of_hmis105_report']*5 * 20 . '%' : '' }}</td>
</tr>
<tr class="indicator-item">
    <td>24. Use of Laboratory data</td>
    <td>{{ $lis_mgt['lab_data_use'] ?? '' }}</td>
    <td>{{ isset($lis_mgt['lab_data_use']) ? $lis_mgt['lab_data_use']*5 * 20 . '%' : '' }}</td>
</tr>
<tr class="indicator-item">
    <td>25. Filing of reports</td>
    <td>{{ $lis_mgt['report_filing'] ?? '' }}</td>
    <td>{{ isset($lis_mgt['report_filing']) ? $lis_mgt['report_filing']*5 * 20 . '%' : '' }}</td>
</tr>

<tr class="total-row">
    <td><strong>TOTAL (Add 20-25)</strong></td>
    <td>
        {{ 
            ($lis_mgt['availability_and_use_of_data_tool'] ?? 0) +
            ($lis_mgt['availability_of_hmis_reports'] ?? 0) +
            ($lis_mgt['timeliness_of_hmis_reports'] ?? 0) +
            ($lis_mgt['completeness_and_accuracy_of_hmis105_report'] ?? 0) +
            ($lis_mgt['lab_data_use'] ?? 0) +
            ($lis_mgt['report_filing'] ?? 0)
        }}
    </td>
    <td>
        {{
            round((
                ($lis_mgt['availability_and_use_of_data_tool'] ?? 0) +
                ($lis_mgt['availability_of_hmis_reports'] ?? 0) +
                ($lis_mgt['timeliness_of_hmis_reports'] ?? 0) +
                ($lis_mgt['completeness_and_accuracy_of_hmis105_report'] ?? 0) +
                ($lis_mgt['lab_data_use'] ?? 0) +
                ($lis_mgt['report_filing'] ?? 0)
            ) * 20,2) . '%'
        }}
        
    </td>
</tr>
<tr class="spider-row">
    <td colspan="3">
        <strong>
            Spider Graph Score (TOTAL/6) x 5 = {{ 
             round(((
                ($lis_mgt['availability_and_use_of_data_tool'] ?? 0) +
                ($lis_mgt['availability_of_hmis_reports'] ?? 0) +
                ($lis_mgt['timeliness_of_hmis_reports'] ?? 0) +
                ($lis_mgt['completeness_and_accuracy_of_hmis105_report'] ?? 0) +
                ($lis_mgt['lab_data_use'] ?? 0) +
                ($lis_mgt['report_filing'] ?? 0)
            ) / 6) * 5, 2)

            }}

        </strong>
    </td>
</tr>


                </tbody>
            </table>
          

            <div class="spider-graph">
                <div class="spider-graph-title">Total Spider Graph Score (Max score is 25)</div>
                <div class="bg-white rounded shadow p-4">
                    <h3 class="text-lg font-semibold mb-2">Radar Graph Summary</h3>
                    <canvas id="spiderChart" width="400" height="400"></canvas>
                </div>

            </div>
        </div>
    </div>

    <div class="key-assessment">
        Lab SPARS Key Assessment Areas
    </div>

    <footer>
        <p>Laboratory Quality Management System | SPARS Dashboard v2.0</p>
        <p>© Central Public Health Laboratories. All rights reserved.</p>
    </footer>
    <!-- Radar Chart -->

</div>

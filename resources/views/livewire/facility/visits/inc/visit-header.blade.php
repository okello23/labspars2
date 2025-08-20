    <style>

        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px; /* Reduce font size */
        }

        table,
        th,
        td {
            border: 1px solid rgb(54, 83, 248);
        }

        th,
        td {
            padding: 4px 8px; /* Reduce padding to make the table more compact */
            text-align: left;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>

    <h3>Lab SPARS Data Collection & Support Supervision Visit Tool</h3>

    <!-- Basic Information -->
    @if (isset($active_visit) && $active_visit)
        <div>
            <h4>Basic Information</h4>
            <table>
                <tr>
                    <th>Health Region</th>
                    <td>{{ $active_visit->facility->healthSubDistrict?->district->region?->name ?? 'N/A' }}</td>
                    <th>District</th>
                    <td>{{ $active_visit->facility?->healthSubDistrict->district->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Health Sub District</th>
                    <td>{{ $active_visit->facility->healthSubDistrict->name ?? 'N/A' }}</td>
                    <th>Health Facility</th>
                    <td>{{ $active_visit->facility->name }}</td>
                </tr>
                <tr>
                    <th>Ownership</th>
                    <td>{{ $active_visit->facility->ownership ?? 'N/A' }}</td>
                    <th>Level</th>
                    <td>{{ $active_visit->facility->level ?? 'N/A' }}</td>
                    <!-- <td>{{ $active_visit->visit_number ?? 'N/A' }}</td> -->
                </tr>
                <tr>
                    <th>Name of Laboratory In-charge</th>
                    <td>{{ $active_visit->in_charge_name ?? 'N/A' }}</td>
                    <th>In-Charge Phone No</th>
                    <td>{{ $active_visit->in_charge_contact }}</td>
                </tr>
                <tr>
                    <th>Date of Visit</th>
                    <td>{{ $active_visit->date_of_visit }}</td>
                    <th>Date of Next Visit</th>
                    <td>{{ $active_visit->date_of_next_visit }}</td>
                </tr>
                <tr>
                    <th>Name of Responsible LSS</th>
                    <td colspan="3">{{ $active_visit->responsible_lss_name }}</td>
                </tr>
            </table>
        </div>
    @endif

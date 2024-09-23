
    <h1>Laboratory Information System</h1>

    <!-- Section 20: Availability & Use of Laboratory Data Collection Tools -->
    <h2>20. Availability & Use of Laboratory Data Collection Tools</h2>
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
            <tr>
                <td>A</td>
                <td>HMIS Lab 001 General Laboratory Request Form</td>
                <td><input type="checkbox" name="available_lab_001"></td>
                <td><input type="checkbox" name="in_use_lab_001"></td>
                <td><input type="text" name="comments_lab_001"></td>
            </tr>
            <tr>
                <td>B</td>
                <td>HMIS Lab 002 Laboratory Specimen Reception Register</td>
                <td><input type="checkbox" name="available_lab_002"></td>
                <td><input type="checkbox" name="in_use_lab_002"></td>
                <td><input type="text" name="comments_lab_002"></td>
            </tr>
            <!-- Repeat similar rows for other items (C to P) -->
        </tbody>
    </table>

    <p>
        <strong>Score - Available:</strong> Sum of A to P divided by 16 minus NA: ______<br>
        <strong>Percentage - Available:</strong> _______%<br>
        <strong>Score - In Use:</strong> Sum of A to P divided by 16 minus NA: ______<br>
        <strong>Percentage - In Use:</strong> _______%<br>
        <strong>Sum of Available + In Use:</strong> _______<br>
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
                <td>Does the laboratory keep copies of the Laboratory HMIS 105 Health Unit Outpatient Monthly Report Section 10 pages 26 & 27?</td>
                <td><input type="checkbox" name="hmis_105_outpatient_report"></td>
                <td><input type="text" name="comments_hmis_105_outpatient_report"></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Does the facility have HMIS 105 Monthly reports for the previous 2 months?</td>
                <td><input type="checkbox" name="hmis_105_previous_months"></td>
                <td><input type="text" name="comments_hmis_105_previous_months"></td>
            </tr>
        </tbody>
    </table>

    <p>
        <strong>Score:</strong> Sum of 2 divided by 2: ______<br>
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
                <td>Was the HMIS 105 Section 10 pages 26 & 27 report submitted to the district on time?</td>
                <td><input type="checkbox" name="submitted_on_time"></td>
                <td><input type="text" name="comments_submitted_on_time"></td>
            </tr>
        </tbody>
    </table>

    <p>
        <strong>Score:</strong> ______<br>
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
                <td><input type="checkbox" name="section_6_complete"></td>
            </tr>
            <tr>
                <td>HMIS 105 report section 10 is completely filled (No blanks left)</td>
                <td><input type="checkbox" name="section_10_complete"></td>
            </tr>
        </tbody>
    </table>

    <p>
        <strong>Sum of (i & ii) divided by 2:</strong> _______<br>
        <strong>Accuracy = Sum/(7 - NA):</strong> _______
    </p>

    <!-- Section 24: Use of Laboratory Data -->
    <h2>24. Use of Laboratory Data</h2>
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
            <tr>
                <td>1</td>
                <td>Table/Graph/Chart/Map</td>
                <td><input type="checkbox" name="table_graph_chart_map"></td>
                <td><input type="checkbox" name="updated_last_quarter"></td>
                <td><input type="text" name="comments_table_graph_chart_map"></td>
            </tr>
        </tbody>
    </table>

    <p>
        <strong>Score:</strong> Sum of 2 divided by 2: _______<br>
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
                <td><input type="checkbox" name="hmis_105_section_10"></td>
                <td><input type="text" name="comments_hmis_105_section_10"></td>
            </tr>
            <tr>
                <td>2</td>
                <td>HMIS Lab 024 Bimonthly Report & Order Calculation Form for HIV Test Kits (Last 2 order cycles)</td>
                <td><input type="checkbox" name="hmis_lab_024"></td>
                <td><input type="text" name="comments_hmis_lab_024"></td>
            </tr>
            <!-- Add more rows for other items as needed -->
        </tbody>
    </table>

    <p>
        <strong>Score:</strong> Sum of 4 divided by 4: _______<br>
        <strong>Percentage:</strong> _______%
    </p>


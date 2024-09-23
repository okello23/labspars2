    <h4>Laboratory Equipment Form</h4>

    <!-- Section 16: Developing and Maintaining Facility Equipment Inventory -->
    <div class="section-title">16. Developing and Maintaining Facility Equipment Inventory</div>

    <label>Is the Laboratory Equipment Inventory Log (HMIS Lab 20) available?</label>
    <select name="inventory_log_available">
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>

    <label>Has the Laboratory Inventory Log been updated in the last 1 calendar year?</label>
    <select name="inventory_log_updated">
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>

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
                <td><input type="number" name="score_1"></td>
                <td><input type="text" name="comments_1"></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Is major equipment routinely serviced according to schedule and documented in the service logs?</td>
                <td><input type="number" name="score_2"></td>
                <td><input type="text" name="comments_2"></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Is internal quality control (IQC) performed for major equipment?</td>
                <td><input type="number" name="score_3"></td>
                <td><input type="text" name="comments_3"></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Are the manufacturers' operator manuals for major equipment readily available?</td>
                <td><input type="number" name="score_4"></td>
                <td><input type="text" name="comments_4"></td>
            </tr>
        </tbody>
    </table>

    <h4>Score: Sum (1 to 4)</h4>

    <!-- Section 18: Equipment Functionality -->
    <div class="section-title">18. Equipment Functionality</div>

    <label>Has the laboratory provided uninterrupted testing services with no disruptions due to equipment downtime?</label>
    <select name="uninterrupted_services">
        <option value="yes">Yes</option>
        <option value="no">No</option>
        <option value="na">N/A</option>
    </select>

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
            <tr>
                <td>CD4 (Specify)</td>
                <td><select name="cd4_functional">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </td>
                <td><input type="number" name="cd4_downtime"></td>
                <td><input type="checkbox" name="cd4_nonfunctional_hw"></td>
                <td><input type="checkbox" name="cd4_nonfunctional_reagents"></td>
                <td><input type="checkbox" name="cd4_nonfunctional_other"></td>
                <td><input type="number" name="cd4_response_time"></td>
            </tr>
            <!-- Repeat for other equipment types -->
        </tbody>
    </table>

    <!-- Section 19: Equipment Utilization -->
    <div class="section-title">19. Equipment Utilization for Chemistry, Hematology, and CD4 Platforms</div>

    <table>
        <thead>
            <tr>
                <th>Equipment Name</th>
                <th>Throughput (per day)</th>
                <th>Average no. of days running per month</th>
                <th>Average actual output</th>
                <th>Average expected output</th>
                <th>% Utilization ((D/E)*100)</th>
                <th>If "F" > 70%, score 1, else 0</th>
                <th>Capacity of equipment</th>
                <th>If B=H, score 1, else 0</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>CD4 Equipment (BD FACSPresto)</td>
                <td>60</td>
                <td><input type="number" name="cd4_days_running"></td>
                <td><input type="number" name="cd4_actual_output"></td>
                <td><input type="number" name="cd4_expected_output"></td>
                <td><input type="number" name="cd4_utilization"></td>
                <td><input type="number" name="cd4_score"></td>
                <td><input type="number" name="cd4_capacity"></td>
                <td><input type="number" name="cd4_final_score"></td>
            </tr>
            <!-- Repeat for Chemistry and Hematology Equipment -->
        </tbody>
    </table>

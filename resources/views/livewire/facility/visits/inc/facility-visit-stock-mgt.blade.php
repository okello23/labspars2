


    <h1>Stock Management Form</h1>

    <!-- Stock Management Instructions -->
    <p>
        <strong>I. STOCK MANAGEMENT</strong><br>
        Availability of reagents and correct filling of stock cards, stock books, etc. Complete the table below as per the instructions.
    </p>

    <!-- Stock Management Table -->
    <table>
        <thead>
            <tr>
                <th rowspan="2">Testing Category (Reagent & Unit Size)</th>
                <th colspan="2">Tests</th>
                <th colspan="4">Stock Card Information</th>
                <th colspan="3">Stock Balances</th>
                <th colspan="3">Stock Book Information</th>
                <th rowspan="2">ELMIS/EMR Installed</th>
            </tr>
            <tr>
                <th>Test Performed?</th>
                <th>Item Available?</th>
                <th>Stock Card Available?</th>
                <th>Physical Count Monthly?</th>
                <th>Stock Card Correct?</th>
                <th>Balance on Stock Card</th>
                <th>Physical Count</th>
                <th>Balance Matches PC?</th>
                <th>Last 3-Month Issues</th>
                <th>Out of Stock Days</th>
                <th>AMC on Stock Card</th>
                <th>AMC Calculated?</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>HIV Determine Strips, 100 Tests</td>
                <td><input type="checkbox" name="test_performed_1"></td>
                <td><input type="checkbox" name="item_available_1"></td>
                <td><input type="checkbox" name="stock_card_available_1"></td>
                <td><input type="checkbox" name="physical_count_1"></td>
                <td><input type="checkbox" name="stock_card_correct_1"></td>
                <td><input type="number" name="balance_on_card_1"></td>
                <td><input type="number" name="physical_count_1"></td>
                <td><input type="checkbox" name="balance_matches_pc_1"></td>
                <td><input type="number" name="last_issues_1"></td>
                <td><input type="number" name="out_of_stock_days_1"></td>
                <td><input type="number" name="amc_on_card_1"></td>
                <td><input type="checkbox" name="amc_calculated_1"></td>
                <td><input type="checkbox" name="elmis_installed_1"></td>
            </tr>
            <tr>
                <td>Malaria RDT, 25 Tests</td>
                <td><input type="checkbox" name="test_performed_2"></td>
                <td><input type="checkbox" name="item_available_2"></td>
                <td><input type="checkbox" name="stock_card_available_2"></td>
                <td><input type="checkbox" name="physical_count_2"></td>
                <td><input type="checkbox" name="stock_card_correct_2"></td>
                <td><input type="number" name="balance_on_card_2"></td>
                <td><input type="number" name="physical_count_2"></td>
                <td><input type="checkbox" name="balance_matches_pc_2"></td>
                <td><input type="number" name="last_issues_2"></td>
                <td><input type="number" name="out_of_stock_days_2"></td>
                <td><input type="number" name="amc_on_card_2"></td>
                <td><input type="checkbox" name="amc_calculated_2"></td>
                <td><input type="checkbox" name="elmis_installed_2"></td>
            </tr>
            <!-- Repeat similar rows for other reagents (R3 to R23) -->
        </tbody>
    </table>

    <!-- Score Summary Section -->
    <h2>Score Summary</h2>
    <table>
        <thead>
            <tr>
                <th>Indicator</th>
                <th>Score</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Availability of reagents</td>
                <td><input type="number" name="availability_score"></td>
                <td><input type="number" name="availability_percentage"></td>
            </tr>
            <tr>
                <td>Stock card availability</td>
                <td><input type="number" name="stock_card_score"></td>
                <td><input type="number" name="stock_card_percentage"></td>
            </tr>
            <tr>
                <td>Correct filling of stock card</td>
                <td><input type="number" name="correct_filling_score"></td>
                <td><input type="number" name="correct_filling_percentage"></td>
            </tr>
            <!-- Add more rows for other indicators as needed -->
        </tbody>
    </table>

    <!-- Comments Section -->
    <h2>Comments</h2>
    <textarea name="comments" placeholder="Add comments here..."></textarea>

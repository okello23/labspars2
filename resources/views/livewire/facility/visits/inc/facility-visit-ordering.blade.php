<h3>Ordering Form</h3>

<!-- Section 13: Reorder Level Calculation -->
<div class="section-title">13. Reorder Level Calculation</div>

<label>Stock on Hand (SOH):</label>
<input type="number" name="soh">

<label>Quantity Issued Out (2 months):</label>
<input type="number" name="qty_issued">

<label>Days Out of Stock:</label>
<input type="number" name="days_out_of_stock">

<label>Adjusted AMC:</label>
<input type="number" name="adjusted_amc">

<label>Maximum Quantity (Adjusted AMC x 4):</label>
<input type="number" name="max_quantity">

<label>Quantity to Order (Maximum stock - Stock on hand):</label>
<input type="number" name="quantity_to_order">

<label>Are copies of the last 2 complete order cycles filed and stored?</label>
<select name="order_cycle_files">
    <option value="yes">Yes</option>
    <option value="no">No</option>
</select>

<label>Did the facility submit the last order electronically?</label>
<select name="order_submitted_electronically">
    <option value="yes">Yes</option>
    <option value="no">No</option>
</select>

<!-- Section 13c: Order Review -->
<h4>Review of Recent Order Form</h4>
<label>Is there a standard test menu at the laboratory facility?</label>
<select name="test_menu">
    <option value="yes">Yes</option>
    <option value="no">No</option>
</select>

<!-- Order Fulfillment Table -->
<h4>Order Fulfillment Review</h4>
<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>A. Quantity Ordered</th>
            <th>B. Quantity Received</th>
            <th>Order Fulfillment Rate (B/A * 100)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td><input type="number" name="qty_ordered_1"></td>
            <td><input type="number" name="qty_received_1"></td>
            <td><input type="text" name="fulfillment_rate_1" disabled></td>
        </tr>
        <tr>
            <td>2</td>
            <td><input type="number" name="qty_ordered_2"></td>
            <td><input type="number" name="qty_received_2"></td>
            <td><input type="text" name="fulfillment_rate_2" disabled></td>
        </tr>
        <tr>
            <td>3</td>
            <td><input type="number" name="qty_ordered_3"></td>
            <td><input type="number" name="qty_received_3"></td>
            <td><input type="text" name="fulfillment_rate_3" disabled></td>
        </tr>
        <!-- Add more rows as needed -->
    </tbody>
</table>

<!-- Section 14: Adherence to Ordering Procedures -->
<div class="section-title">14. Adherence to Ordering Procedures</div>
<label>Ordering Schedule Deadline:</label>
<input type="date" name="ordering_schedule_deadline">

<label>Actual Date of Ordering:</label>
<input type="date" name="actual_ordering_date">

<label>Was ordering timely?</label>
<select name="ordering_timely">
    <option value="yes">Yes</option>
    <option value="no">No</option>
</select>

<label>Delivery Schedule Deadline:</label>
<input type="date" name="delivery_schedule_deadline">

<label>Date of Delivery from Warehouse:</label>
<input type="date" name="delivery_date">

<label>Was delivery on schedule?</label>
<select name="delivery_on_time">
    <option value="yes">Yes</option>
    <option value="no">No</option>
</select>

<!-- Section 15: Procurement Plan -->
<div class="section-title">15. Availability of Current Annual Laboratory Procurement Plan</div>
<label>Is the Annual Procurement Plan available?</label>
<select name="procurement_plan_available">
    <option value="yes">Yes</option>
    <option value="no">No</option>
</select>

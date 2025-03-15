<div class="p-2">
    <h4>Ordering Form</h4>
    
    <!-- Section 13: Reorder Level Calculation -->
    <div class="section-title">13. Reorder Level Calculation</div>
    <h5>8. Cleanliness of the Laboratory and Storage Facilities</h5>
    <table>
        <thead>
            <tr>
                <th>Area</th>
                <th>Score</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>a) Are copies (soft or hard) of last 2 complete order cycles filed and stored? </td>
                <td>
                    {{ checkYesNoNA($ordering?->cycles_filed_stored) }}
                </td>
                <td>
                    <p>{{ $ordering?->cycles_filed_comments }}</p>
                </td>

            </tr>
            <tr>
                <td>b) Did the facility submit the last order to the warehouse electronically?</td>
                <td>
                    {{ checkYesNoNA($ordering?->electronic_submission) }}
                </td>
                <td rowspan="4">
                    <p>{{ $ordering?->electronic_submission_comments }}</p>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th>Stock on Hand (SOH)</th>
                <th>Quantity Issued Out (2 months)</th>
                <th>Days Out of Stock</th>
                <th>Adjusted AMC</th>
                <th>Maximum Quantity (Adjusted AMC x 4)</th>
                <th>Quantity to Order (Maximum stock - Stock on hand)</th>
                <th>Score 1 if quantity to order is correct otherwise 0 or NR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $ordering?->soh }}
                </td>
                <td> {{ $ordering?->quantity_issued }}</td>
                <td> {{ $ordering?->days_out_of_stock }}</td>
                <td> {{ $ordering?->adjusted_amc }}</td>
                <td> {{ $ordering?->max_quantity }}</td>
                <td> {{ $ordering?->quantity_to_order }}</td>
                <td> {{ checkYesNoNA($ordering?->qty_to_order_score) }}</td>
            </tr>
        </tbody>
    </table>
    <h4>Review of Recent Order Form</h4>
    <label class="form-label required">Is there a standard test menu at the laboratory facility?</label>
    {{ $ordering?->test_menu_available }}
    <!-- Order Fulfillment Table -->
    <h4>Order Fulfillment Review</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>A. Quantity Ordered</th>
                <th>B. Quantity Received</th>
                <th>Order Fulfillment Rate (B/A * 100)</th>
            </tr>
        </thead>
        <tbody>

            @forelse ($reviews as $key => $review)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $review->reagent->name ?? 'N/A' }}</td>
                    <td>{{ $review->quantity_ordered ?? 'N/A' }}</td>
                    <td>{{ $review->quantity_received ?? 'N/A' }}</td>
                    <td>{{ $review->fulfillment_rate }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="5">No orders and delivery reviews for the notes from the most
                        recent order cycle</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Section 14: Adherence to Ordering Procedures -->
    <div class="section-title">14. Adherence to Ordering Procedures</div>
    <table>
        <thead>
            <tr>
                <th>Ordering Schedule Deadline</th>
                <th>Actual Date of Ordering</th>
                <th>Was ordering timely</th>
                <th>Delivery Schedule Deadline</th>
                <th>Date of Delivery from Warehouse</th>
                <th>Was delivery on schedule</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $adherence?->ordering_schedule_deadline }}
                </td>
                <td> {{ $adherence?->actual_ordering_date }}</td>
                <td> {{ $adherence?->ordering_timely }}</td>
                <td> {{ $adherence?->delivery_schedule_deadline }}</td>
                <td> {{ $adherence?->delivery_date }}</td>
                <td> {{ checkYesNoNA($adherence?->delivery_on_time) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-12">
            <!-- Section 15: Procurement Plan -->
            <div class="section-title">15. Availability of Current Annual Laboratory Procurement Plan</div>
            <table>
                <thead>
                    <tr>
                        <th>Area</th>
                        <th>Score</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Is the Annual Procurement Plan available? </td>
                        <td>
                            {{ checkYesNoNA($adherence?->annual_procurement_plan)}}
                        </td>
                        <td>
                            <p>{{ $adherence?->procurement_plan_comments }}</p>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>

    </div>

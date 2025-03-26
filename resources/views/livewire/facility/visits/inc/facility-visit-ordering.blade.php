<div class="p-4">
    <h3>Ordering Form</h3>

    <!-- Section 13: Reorder Level Calculation -->
    <div class="section-title">13. Reorder Level Calculation</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Indicator</th>
                <th>Score</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>a)</td>
                <td>Are copies (soft or hard) of last 2 complete order cycles filed and stored? </td>
                <td>
                    <select class="form-control" wire:model.lazy="cycles_filed_stored" required>
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                    @error('cycles_filed_stored')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>

                <td>
                    <textarea class="form-control" type="text" wire:model.lazy='cycles_filed_comments'></textarea>
                    @error('cycles_filed_comments')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>

            </tr>
            <tr>

                <td>b)</td>
                <td> Did the facility submit the last order to the warehouse electronically?</td>
                <td><select class="form-control" wire:model.lazy="electronic_submission">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td>
                    <textarea class="form-control" type="text" wire:model.lazy='electronic_submission_comments'
                        wire:model.lazy="electronic_submission_comments"></textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Responses</th>
                <th>Score</th>
            </tr>
            <tr>
                <td>c)</td>
                <td style="word-break: break-word; white-space: normal;">
                    <i><small>Review an order form from the most recent order cycle to check whether the person knows
                            how to
                            calculate the quantity to order. Let the person show you how to calculate the quantity to
                            order for
                            the selected reagents/test kit</small></i><br>

                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label required">Stock on Hand (SOH):</label>
                            <input class="form-control" type="number" wire:model.lazy="soh">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label required">Qty Issued Out (2 months):</label>
                            <input class="form-control" type="number" wire:model.lazy="quantity_issued">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label required">Days Out of Stock:</label>
                            <input class="form-control" type="number" step='any'
                                wire:model.lazy="days_out_of_stock">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label required">Adjusted AMC:</label>
                            <input class="form-control" type="number" step='any' wire:model.lazy="adjusted_amc">
                        </div>
                        <div class="col-md-2">

                            <label class="form-label required">Maximum Qty:</label>
                            <input class="form-control" type="number" step='any' wire:model.lazy="max_quantity"
                                title="Formular: Adjusted AMC x 4">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label required">Qty to Order:</label>
                            <input class="form-control" type="number" step='any'
                                wire:model.lazy="quantity_to_order"
                                title="Formular: Quantity to order = Maximum stock – Stock on hand">
                        </div>
                    </div>
                </td>

                <td>
                    <div class="col-md-12">

                        <label class="form-label required">Score 1 if qty to order is correct otherwise 0 or NR</label>
                        <select class="form-control" wire:model.lazy="qty_to_order_score">
                            <option value="">Select</option>
                            <option value="1">1</option>
                            <option value="0">0</option>
                            <option value="2">N/A</option>
                        </select>
                    </div>
                </td>
            </tr>

            <tr>
                <td>d)</td>
                <td>
                    <label class="form-label required">Is there a standard test menu at the laboratory facility?</label>
                    <select class="form-control" wire:model.lazy="test_menu_available">
                        <option value=""></option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>e)</td>
                <td style="word-break: break-word; white-space: normal;">
                    <i><small>Review the orders and delivery notes from the most recent order cycle and complete the
                            table below
                            based on the first 5 items assessed under Stock Management</small></i><br>
                    <form wire:submit.prevent="saveOrderReview()">
                        <div class="row">
                            <div class="col-md-5">
                                <label for="order_item_id">Item Name:</label>
                                <select class="form-control" id="order_item_id" wire:model="order_item_id" required>
                                    <option value="">select</option>
                                    @foreach ($orderItems as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('order_item_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="quantity">Qty Ordered</label>
                                <input type="number" step='any' required class="form-control"
                                    wire:model="quantity_ordered">
                                @error('quantity_ordered')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="unit_cost">Qty Received:</label>
                                <input type="number" step="any" required class="form-control"
                                    wire:model="quantity_received">
                                @error('quantity_received')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="amount">Fulfillment Rate:</label>
                                <input type="number" step='any' readonly required class="form-control"
                                    wire:model="fulfillment_rate">
                                @error('fulfillment_rate')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-1 pt-4 text-end">
                                <button class="btn btn-success fas fa fa-plus" type="submit"></button>
                            </div>
                        </div>
                    </form>
                    <!-- Order Fulfillment Table -->
                    <h4></h4>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>A. Quantity Ordered</th>
                                <th>B. Quantity Received</th>
                                <th>Order Fulfillment Rate (B/A * 100)</th>
                                <th>Action</th>
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
                                    <td>
                                        <a href="javascript:void(0)"
                                            wire:click="confirmDelete({{ $review->id }}, '{{ addslashes(get_class($review)) }}')"
                                            class="text-danger float-right fa fa-trash"></a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5">No orders and delivery reviews for the
                                        notes from the most
                                        recent order cycle</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </td>
            </tr>
        </thead>
    </table>
    {{-- <div class="col-md-2">
            <button class="btn btn-success" wire:click ='saveHygiene'> Save</button>
        </div> --}}
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>as</th>
            <th></th>
        </tr>
    </thead>
</table>
<!-- Section 14: Adherence to Ordering Procedures -->
<div class="section-title">14. Adherence to Ordering Procedures</div>

<div class="row">
    <div class="col-md-2">
        <label class="form-label required">Ordering Schedule Deadline:</label>
        <input class="form-control" type="date" wire:model="ordering_schedule_deadline">
    </div>
    <div class="col-md-2">
        <label class="form-label required">Actual Date of Ordering:</label>
        <input class="form-control" type="date" wire:model="actual_ordering_date">
    </div>
    <div class="col-md-2">
        <label class="form-label required">Was ordering timely?</label>
        <select class="form-control" wire:model="ordering_timely">
            <option value="">select</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>
    <div class="col-md-2">
        <label class="form-label required">Delivery Schedule Deadline:</label>
        <input class="form-control" type="date" wire:model.lazy="delivery_schedule_deadline">
    </div>
    <div class="col-md-2">
        <label class="form-label required">Date of Delivery from Warehouse:</label>
        <input class="form-control" type="date" wire:model.lazy="delivery_date">
    </div>
    <div class="col-md-2">
        <label class="form-label required">Was delivery on schedule?</label>
        <select class="form-control" wire:model="delivery_on_time">
            <option value="">select</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>
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
                        <select class="form-control" wire:model.lazy="annual_procurement_plan" required>
                            <option value="">select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                            <option value="2">N/A</option>
                        </select>
                        @error('annual_procurement_plan')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <textarea class="form-control" type="text" wire:model.lazy='procurement_plan_comments'></textarea>
                        @error('procurement_plan_comments')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </td>

                </tr>
            </tbody>
        </table>
        <div class="col-12">
            @php
                $orderFields = [
                    'cycles_filed_comments',
                    'cycles_filed_stored',
                    'electronic_submission',
                    'electronic_submission_comments',
                    'soh',
                    'quantity_issued',
                    'days_out_of_stock',
                    'adjusted_amc',
                    'max_quantity',
                    'quantity_to_order',
                    'test_menu_available',
                    'qty_to_order_score',
                    'ordering_schedule_deadline',
                    'actual_ordering_date',
                    'ordering_timely',
                    'delivery_schedule_deadline',
                    'delivery_date',
                    'delivery_on_time',
                    'adherence_comments',
                    'adherence_score',
                    'adherence_percentage',
                    'annual_procurement_plan',
                    'procurement_plan_comments',
                    'condition_comments',
                ];
            @endphp

            @foreach ($orderFields as $conditionsField)
                @error($conditionsField)
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            @endforeach

        </div>
    </div>

</div>

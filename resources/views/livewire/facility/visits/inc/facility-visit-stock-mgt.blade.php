<h1>Stock Management Form</h1>

<!-- Stock Management Instructions -->
<p>
    <strong>I. STOCK MANAGEMENT</strong><br>
    Availability of reagents and correct filling of stock cards, stock books, etc. Complete the table below as per the
    instructions.
</p>
@php
    $fields = [
        'reagent_id',
        'test_performed',
        'item_available',
        'stock_card_available',
        'physical_count_done',
        'stock_card_correct',
        'balance_on_card',
        'physical_count',
        'balance_matches_physical',
        'last_issues',
        'out_of_stock_days',
        'amc_on_card',
        'amc_calculated',
        'amc_calculated_matches',
        'elmis_installed',
        'elmis_quantity',
        'elmis_balance_matches',
    ];
@endphp

@foreach ($fields as $field)
    @error($field)
        <div class="text-danger text-small">{{ $message }}</div>
    @enderror
@endforeach

<!-- Stock Management Table -->
<table>
    <thead>
        <tr>
            <th>Testing Category</th>
            <th>Reagent</th>
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
            <th>AMC balance Matches?</th>
            <th>ELIMS Installed?</th>
            <th>ELMIS/EMR Qty</th>
            <th>ELMIS Malance Matches</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <form wire:submit.prevent='StorageSubmit()'>
            <tr>
                <td title="	Testing Category">
                    <div>
                        <select id="storage_type_id" class="form-control" name="test_type_id" required
                            wire:model="test_type_id">
                            <option value="">Select</option>
                            @foreach ($test_types as $test_type)
                                <option value="{{ $test_type->id }}">{{ $test_type->name }}</option>
                            @endforeach
                        </select>
                        @error('test_type_id')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                </td>
                <td title="Reagent & Unit size">
                    <div>
                        <select id="reagent_id" class="form-control" name="reagent_id" required wire:model="reagent_id">
                            <option value="">Select</option>
                            @foreach ($reagents as $reagent)
                                <option value="{{ $reagent->id }}">{{ $reagent->name }}</option>
                            @endforeach
                        </select>
                        @error('reagent_id')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                </td>
                <td
                    title="Does the facility carry out these tests (Assessor ask for all ten tracer items and score yes=1 and No=0">
                    <select class="form-control" wire:model.lazy="test_performed">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('test_performed')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td title="Is the Item available? (Score 1/0) - If expired, mark (E)">
                    <select class="form-control" wire:model.lazy="item_available">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('item_available')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>

                <td title="Is the Stock card available? (1/0)">
                    <select class="form-control" wire:model.lazy="stock_card_available">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('stock_card_available')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td
                    title="Is a physical count (PC) done every month and marked in the stock card (check last 3 complete months) (1/0)">
                    <select class="form-control" wire:model.lazy="physical_count_done">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('physical_count_done')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td title="Is the card filled correctly with name, unit size, Min& Max, special storage (1/0)">
                    <select class="form-control" wire:model.lazy="stock_card_correct">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('stock_card_correct')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td title="Balance according to stock card (record no. from the card)">
                    <input type="number" min="0" step="any" class="form-control"
                        wire:model.lazy="balance_on_card">
                    @error('balance_on_card')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>

                <td title="Count the no. of reagents in stock and record i.e. physical count (PC)">
                    <input type="number" min="0" step="any" class="form-control"
                        wire:model.lazy="physical_count">
                    @error('physical_count')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td title="Does the balance according to the stock card agree with the PC 100%? (1/0)">
                    <select class="form-control" wire:model.lazy="balance_matches_physical">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('balance_matches_physical')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td title="Record the amount issued in the last 3 complete months.">
                    <input type="number" min="0" step="any" class="form-control"
                        wire:model.lazy="last_issues">
                    @error('last_issues')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td title="Record the number of days out of stock in the last 3 complete months.">
                    <input type="number" min="0" class="form-control" wire:model.lazy="out_of_stock_days">
                    @error('out_of_stock_days')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>

                <td
                    title="Record the average monthly consumption (AMC) as per the stock card. Write NR if not recorded.">
                    <input type="number" min="0" class="form-control" wire:model.lazy="amc_on_card">
                    @error('amc_on_card')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td title="Calculate & record the AMC based on the last 3 complete months ">
                    <input type="number" min="0" class="form-control" wire:model.lazy="amc_calculated">
                    @error('amc_calculated')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td
                    title="Does the AMC from the stock card agree with the calculated AMC ±10%? (1/0) Write NR if no record in C11 above">
                    <select class="form-control" wire:model.lazy="amc_calculated_matches">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('amc_calculated_matches')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td title="Does the facility have an ELMIS/EMR installed at the store? (1/0)">
                    <select class="form-control" wire:model.lazy="elmis_installed">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('elmis_installed')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td title="Record the quantity as per the ELMIS/EMR. Write NR if not recorded.">
                    <input type="number" min="0" class="form-control" wire:model.lazy="elmis_quantity">
                    @error('elmis_quantity')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td title="Does the balance according to the ELMIS/EMR agree with the PC 100%? (1/0)">
                    <select class="form-control" wire:model.lazy="elmis_balance_matches">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('elmis_balance_matches')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </td>
                <td>
                    <x-button wire:click='StorageSubmit' type="submit"
                        class="btn btn-success nextBtn btn-lg float-right fa fa-save"></x-button>
                </td>
            </tr>
        </form>
        @foreach ($storageMgts as $storageItem)
            <tr>
                <td title="	Testing Category">
                    {{ $storageItem->reagent?->category?->name??'N/A'  }}
                </td>
                <td title="Reagent & Unit size">
                    {{ $storageItem->reagent->name??'N/A' }}
                </td>
                <td>
                    {{ $storageItem->test_performed }}
                </td>
                <td title="Is the Item available? (Score 1/0) - If expired, mark (E)">
                    {{ $storageItem->item_available }}
                </td>

                <td>
                    {{ $storageItem->stock_card_available }}

                </td>
                <td>
                    {{ $storageItem->physical_count_done }}
                </td>
                <td>
                    {{ $storageItem->stock_card_correct }}

                </td>
                <td>
                    {{ $storageItem->balance_on_card }}

                </td>
                <td>
                    {{ $storageItem->physical_count }}

                </td>
                <td>
                    {{ $storageItem->balance_matches_physical }}
                </td>
                <td>
                    {{ $storageItem->last_issues }}

                </td>
                <td >
                    {{ $storageItem->out_of_stock_days }}
                  
                </td>

                <td>
                    {{ $storageItem->amc_on_card }}

                  
                </td>
                <td >
                {{ $storageItem->amc_calculated }}
              
                </td>
                <td>
                {{ $storageItem->amc_calculated_matches }}

                   
                </td>
                <td >
                
                {{ $storageItem->elmis_installed }}
               
                </td>
                <td >
                {{ $storageItem->elmis_quantity }}
                </td>
                
                <td >
                
                {{ $storageItem->elmis_balance_matches }}
                </td>
                <td>
                    <x-button
                        class="btn btn-danger nextBtn btn-lg float-right fa fa-trash"></x-button>
                </td>
            </tr>
        @endforeach
        <!-- Repeat similar rows for other reagents (R3 to R23) -->
    </tbody>
</table>
<b>Note!</b>
<ol>
    <li>A minimum of 10 commodities must be assessed prioritizing the commodities in rows R1 – R15</li>
    <li>In case priority commodities listed are not available, please select from the options below per category</li>
    <li>All ‘NAs’ must be explained in the comments section below. </li>
</ol>

<!-- Comments Section -->
<h6>Comments</h6>
<textarea wire:model.lazy="stock_mgt_comments" class="form-control" placehlider="Add comments here..."></textarea>

    @php
    $scoreconditionsFields =[
        'visit_id',
        'availability_score',
        'availability_percentage',
        'stock_card_score',
        'stock_card_percentage',
        'correct_filling_score',
        'correct_filling_percentage',
        'physical_agrees_score',
        'physical_agrees_percentage',
        'amc_well_calculated_score',
        'amc_well_calculated_percentage',
        'emr_usage_score',
        'emr_usage_percentage',
        'stock_mgt_comments',
    ];
@endphp

@foreach ($scoreconditionsFields as $conditionsField)
    @error($conditionsField)
        <div class="text-danger text-small">{{ $message }}</div>
    @enderror
@endforeach
<!-- Score Summary Section -->
<h3>Score Summary</h3>
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
            <td>1. Availability of reagents</td>
            <td><select wire:model="availability_score">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select></td>
            <td><input type="number" wire:model.lazy="availability_percentage"></td>
        </tr>
        <tr>
            <td>2. Stock card availability</td>
            <td><select wire:model.lazy="stock_card_score">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><input type="number" wire:model.lazy="stock_card_percentage">
            </td>
        </tr>
        <tr>
            <td>3. Correct filling of stock card</td>
            <td><select wire:model.lazy="correct_filling_score">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><input type="number" wire:model.lazy="correct_filling_percentage"></td>
        </tr>

        <tr>
            <td>4. Does physical count agree with stock card balance? </td>
            <td><select wire:model.lazy="physical_agrees_score">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select></td>
            <td><input type="number" wire:model.lazy="physical_agrees_percentage"></td>
        </tr>
        <tr>
            <td>5. Is AMC in the stock card correctly calculated </td>
            <td><select wire:model.lazy="amc_well_calculated_score">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><input type="number" wire:model.lazy="amc_well_calculated_percentage">
            </td>
        </tr>
        <tr>
            <td>6. Is the ELMIS/EMR correctly used and updated?</td>
            <td><select wire:model.lazy="emr_usage_score">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><input type="number" wire:model.lazy="emr_usage_percentage"></td>
        </tr>
        <!-- Add more rows for other indicators as needed -->
    </tbody>
</table>

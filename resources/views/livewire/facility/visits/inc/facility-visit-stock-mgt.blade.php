<h1>Stock Management Form</h1>

<!-- Stock Management Instructions -->
<p>
    <strong>I. STOCK MANAGEMENT</strong><br>
    Availability of reagents and correct filling of stock cards, stock books, etc. Complete the table below as per the
    instructions.
    <a class="action-ico mx-1 btn btn-sm btn-success" data-toggle="modal" data-target="#addeStkMgtAvailabilityModal">
        Add new</a>
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
        @php
            $isavailable=0;
            $isavailableCount=0;
            $scAvailable =0;
            $scAvailableCount =0;
        @endphp
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
                    <a class="text-danger float-right fa fa-trash"></a>
                </td>
            </tr>
        @endforeach
        <!-- Repeat similar rows for other reagents (R3 to R23) -->
        {{-- <tr>
            <td colspan="2">Sum</td>
            <td></td>
            <td>{{ $isavailable }}</td>
            <td>{{ $scAvailable }}</td>
        </tr> --}}
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
{{-- <button class="btn btn-success" wire:click='calculateScored'>Cal</button> --}}
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
            <td>
                
                {{ $availability_score }}
            </td>
            <td>{{ $availability_percentage }}%
                {{-- <input type="number" wire:model.lazy="availability_percentage"> --}}
            </td>
        </tr>
        <tr>
            <td>2. Stock card availability</td>
            <td>
                 {{ $stock_card_score }}
            </td>
            <td>
                
                {{$stock_card_percentage}}%
            </td>
        </tr>
        <tr>
            <td>3. Correct filling of stock card</td>
            <td>
                {{ $correct_filling_score }}
            </td>
            <td>{{ $correct_filling_percentage }}%</td>
        </tr>

        <tr>
            <td>4. Does physical count agree with stock card balance? </td>
            <td>
                {{ $physical_agrees_score }}
            </td>
            <td>{{ $physical_agrees_percentage }}%</td>
        </tr>
        <tr>
            <td>5. Is AMC in the stock card correctly calculated </td>
            <td>
                {{ $amc_well_calculated_score }}
            </td>
            <td>
                {{ $amc_well_calculated_percentage }}%
            </td>
        </tr>
        <tr>
            <td>6. Is the ELMIS/EMR correctly used and updated?</td>
            <td>
                {{ $emr_usage_score }}
            </td>
            <td>{{ $emr_usage_percentage }}%</td>
        </tr>
        <!-- Add more rows for other indicators as needed -->
    </tbody>
</table>
@include('livewire.facility.visits.inc.new-stk-mgt-reagents-modal')

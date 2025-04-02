<h3>Storage & Lab Facilities Management Form</h3>

<!-- Cleanliness Section -->
<h3>8. Cleanliness of the Laboratory and Storage Facilities</h3>
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
            <td>The Lab store is clean and tidy</td>
            <td>
                <select class="form-control" wire:model.defer.defer='lab_store_clean' name="lab_store_clean">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>

        </tr>
        <tr>
            <td>The Main store is clean and tidy</td>
            <td><select class="form-control" wire:model.defer='main_store_clean' name="main_store_clean">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td>
                @error('main_store_clean')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                @error('laboratory_clean')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                @error('cleanliness_comments')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>The Laboratory is clean and tidy</td>
            <td><select class="form-control" wire:model.defer='laboratory_clean' name="laboratory_clean">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td rowspan="4">
                <textarea class="form-control" type="text" wire:model.defer.lazy='cleanliness_comments' name="practices_comments"></textarea>
            </td>
        </tr>
    </tbody>
</table>
{{-- <button class="btn btn-success" wire:click ='saveCleanliness'> Save</button> --}}
<p>
    <strong>Score:</strong> Sum of scores for (a+b+c) divided by 3 minus NA = ______
    <strong>Percentage:</strong> __________
</p>

<!-- Hygiene Section -->
<h3>9. Hygiene of the Laboratory</h3>
<small>Ask to be shown the water points, hand washing and staining stations: score yes =1, No=0 and NA for not
    applicable</small>
<table>
    <thead>
        <tr>
            <th>Indicator</th>
            <th>Score</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Is there running water in the lab?</td>
            <td>

                <select class="form-control" wire:model.defer='running_water'>
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Is the hand washing area separate from the staining area?</td>
            <td> <select class="form-control" wire:model.defer='hand_washing_separate'>
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Is the hand washing facility accessible, hygienic, and functioning?</td>
            <td> <select class="form-control" wire:model.defer='hand_washing_facility'>
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Is the drainage system of suitable standards?</td>
            <td> <select class="form-control" wire:model.defer='drainage_system'>
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td>
                @error('soap_available')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                @error('running_water')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                @error('hand_washing_separate')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                @error('hand_washing_facility')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                @error('drainage_system')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                @error('hygiene_comments')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>Is there soap for hand washing?</td>
            <td> <select class="form-control" wire:model.defer='soap_available'>
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>

            <td rowspan="3">
                <textarea class="form-control" type="text" wire:model.defer="hygiene_comments"></textarea>
            </td>
        </tr>
    </tbody>
</table>
{{-- <button class="btn btn-success" wire:click ='saveHygiene'> Save</button> --}}

<p>
    <strong>Score:</strong> Sum of scores (a to d) divided by 5 minus NA = ______
    <strong>Percentage:</strong> __________
</p>

<!-- Storage System Section -->
<h3>10. System for Storage of Laboratory Reagents and Supplies</h3>
<small>Ask to be shown around the main and e laboratory store that sores laboratory supplies and observe the following
    conditions, score yes =1 and No=0 </small>
<table>
    <thead>
        <tr>
            <th>Indicator</th>
            <th>Main Store (1/0)</th>
            <th>Lab Store (1/0)</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Are there shelves, pallets, and cabinets for storage?</td>
            <td><select class="form-control" wire:model.defer="main_store_shelves">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_store_shelves">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>

        </tr>
        <tr>
            <td>Are reagents stored on shelves or in cabinets?</td>
            <td><select class="form-control" wire:model.defer="main_store_reagents">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_store_reagents">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>

        </tr>
        <tr>
            <td>Are stock cards kept next to the reagents on the shelves?</td>
            <td><select class="form-control" wire:model.defer="main_store_stock_cards">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_store_stock_cards">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>

        </tr>
        <tr>
            <td>Are lab reagents stored systematically (alphabetic, usage form)?</td>
            <td><select class="form-control" wire:model.defer="main_store_systematic">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_store_systematic">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td>
                @php
                    $fields = [
                        'main_store_shelves',
                        'lab_store_shelves',
                        'main_store_reagents',
                        'lab_store_reagents',
                        'main_store_stock_cards',
                        'lab_store_stock_cards',
                        'main_store_systematic',
                        'lab_store_systematic',
                        'main_store_labeled',
                        'lab_store_labeled',
                        'storage_comments',
                    ];
                @endphp

                @foreach ($fields as $field)
                    @error($field)
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Are the shelves and cabinets labeled?</td>
            <td><select class="form-control" wire:model.defer="main_store_labeled">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_store_labeled">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td rowspan="4">
                <textarea class="form-control" type="text" wire:model.defer="storage_comments"></textarea>
            </td>
        </tr>
    </tbody>
</table>
{{-- <button class="btn btn-success" wire:click ='saveSystemStorage'> Save</button> --}}

<p>
    <strong>Score:</strong> Sum of scores (a to e) divided by 5 minus NA = ______
    <strong>Percentage:</strong> __________
</p>

<!-- Storage Conditions Section -->
<h3>11. Storage Conditions for Laboratory Supplies/Reagents</h3>
<small>Ask to be shown around the main store and the store for lab supplies and observe the following conditions, score
    Yes =1, No=0 </small>
<table>
    <thead>
        <tr>
            <th>Indicator</th>
            <th>Main Store (1/0)</th>
            <th>Lab Store (1/0)</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>a) No signs of pests/harmful insects/rodents</td>
            <td><select class="form-control" wire:model.defer="main_store_pests">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_store_pests">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td>
                @php
                    $conditionsFields = [
                        'main_store_pests',
                        'lab_store_pests',
                        'main_store_sunlight',
                        'lab_store_sunlight',
                        'main_store_temperature',
                        'lab_store_temperature',
                        'main_store_lockable',
                        'lab_store_lockable',
                        'condition_comments',
                        'main_temperature_regulated',
                        'lab_temperature_regulated',
                        'main_roof_condition',
                        'lab_roof_condition',
                        'main_sufficient_storage_space',
                        'lab_sufficient_storage_space',
                        'main_fire_safety_equipment_available',
                        'lab_fire_safety_equipment_available',
                        'main_cold_storage_functional',
                        'lab_cold_storage_functional',
                        'main_fridge_well_ventilated',
                        'lab_fridge_well_ventilated',
                        'main_fridge_used_for_reagents_only',
                        'lab_fridge_used_for_reagents_only',
                        'main_containers_securely_capped',
                        'lab_containers_securely_capped',
                        'main_fridge_temperature_monitored',
                        'lab_fridge_temperature_monitored',
                        'main_boxes_not_on_floor',
                        'lab_boxes_not_on_floor',
                    ];
                @endphp

                @foreach ($conditionsFields as $conditionsField)
                    @error($conditionsField)
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                @endforeach
            </td>
        </tr>
        <tr>
            <td>b) Are supplies protected from direct sunlight?</td>
            <td><select class="form-control" wire:model.defer="main_store_sunlight">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_store_sunlight">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>c) Is the temperature of the storage room monitored?</td>
            <td><select class="form-control" wire:model.defer="main_store_temperature">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_store_temperature">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>d) Can the temperature of the storeroom be regulated ?</td>
            <td><select class="form-control" wire:model.defer="main_temperature_regulated">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_temperature_regulated">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>e) Roof is maintained in good condition to avoid water penetration?</td>
            <td><select class="form-control" wire:model.defer="main_roof_condition">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_roof_condition">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>f) Is storage space sufficient and adequate?</td>
            <td><select class="form-control" wire:model.defer="main_sufficient_storage_space">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_sufficient_storage_space">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>g. Is the storeroom lockable and access restricted to authorized personnel?</td>
            <td><select class="form-control" wire:model.defer="main_store_lockable">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_store_lockable">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>



        <tr>
            <td>h) Fire safety equipment is available and accessible (any items for promotion of fire safety should be
                considered)</td>
            <td><select class="form-control" wire:model.defer="main_fire_safety_equipment_available">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_fire_safety_equipment_available">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>i) Is there a functioning system for cold storage (Refrigerator/Freezer)?</td>
            <td><select class="form-control" wire:model.defer="main_cold_storage_functional">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_cold_storage_functional">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>j) Is the refrigerator/freezer kept in a well-ventilated space? </td>
            <td><select class="form-control" wire:model.defer="main_fridge_well_ventilated">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_fridge_well_ventilated">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>k) If yes, are only reagents stored in the refrigerator – no food or beverage?</td>
            <td><select class="form-control" wire:model.defer="main_fridge_used_for_reagents_only">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_fridge_used_for_reagents_only">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>l) Are the containers in the refrigerator securely capped or properly covered?</td>
            <td><select class="form-control" wire:model.defer="main_containers_securely_capped">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_containers_securely_capped">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>m) Is the temperature of the refrigerator monitored daily?</td>
            <td><select class="form-control" wire:model.defer="main_fridge_temperature_monitored">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_fridge_temperature_monitored">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>n) Boxes are not directly on the floor in the store</td>
            <td><select class="form-control" wire:model.defer="main_boxes_not_on_floor">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td><select class="form-control" wire:model.defer="lab_boxes_not_on_floor">
                    <option value="">select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">N/A</option>
                </select>
            </td>
            <td rowspan="3">
                <textarea class="form-control" type="text" wire:model.defer="condition_comments"></textarea>
            </td>
        </tr>
        <!-- Add more rows as per other indicators -->
    </tbody>
</table>
{{-- <button class="btn btn-success" wire:click ='saveStorageCondition'> Save</button> --}}


<p>
    <strong>Score:</strong> Sum of scores (a to l) divided by 14 minus NA = ______
    <strong>Percentage:</strong> __________
</p>

<!-- Storage Practices Section -->
<h3>12. Storage Practices of Laboratory Reagents</h3>
<div class="table-responsive-sm">
    <table>
        <thead>
            <tr>
                <th>Indicator</th>
                <th>Main Store (1/0)</th>
                <th>Lab Store (1/0)</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>a) Is there a record for expired reagents?</td>
                <td><select class="form-control" wire:model.defer="main_store_expired_record">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td><select class="form-control" wire:model.defer="lab_store_expired_record">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td>
                    @php
                        $conditionsFields = [
                            'main_store_expired_record',
                            'lab_store_expired_record',
                            'main_store_expired_separate',
                            'lab_store_expired_separate',
                            'main_store_fefo',
                            'lab_store_fefo',
                            'main_store_opening_date',
                            'lab_store_opening_date',
                            'practices_comments',
                            'main_opened_bottles_have_lids',
                            'lab_opened_bottles_have_lids',
                            'main_chemicals_properly_labelled',
                            'lab_chemicals_properly_labelled',
                            'main_flammables_stored_safely',
                            'lab_flammables_stored_safely',
                            'main_corrosives_separated',
                            'lab_corrosives_separated',
                            'main_safety_data_sheets_available',
                            'lab_safety_data_sheets_available',
                        ];
                    @endphp

                    @foreach ($conditionsFields as $conditionsField)
                        @error($conditionsField)
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>b) Is there a place to store expired reagents separately?</td>
                <td><select class="form-control" wire:model.defer="main_store_expired_separate">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td><select class="form-control" wire:model.defer="lab_store_expired_separate">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>c) Is FEFO adhered to?</td>
                <td><select class="form-control" wire:model.defer="main_store_fefo">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td><select class="form-control" wire:model.defer="lab_store_fefo">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>d) Are reagent bottles/kits labeled with the date of opening?</td>
                <td><select class="form-control" wire:model.defer="main_store_opening_date">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td><select class="form-control" wire:model.defer="lab_store_opening_date">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>e) Do all bottles that have been opened have a lid on? </td>
                <td><select class="form-control" wire:model.defer="main_opened_bottles_have_lids">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td><select class="form-control" wire:model.defer="lab_opened_bottles_have_lids">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>f) Are chemicals labelled with the chemical’s name and with hazard markings? </td>
                <td><select class="form-control" wire:model.defer="main_chemicals_properly_labelled">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td><select class="form-control" wire:model.defer="lab_chemicals_properly_labelled">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>g) Are flammable chemicals stored out of sunlight and below their flashpoint, preferably in a steel
                    cabinet in a well-ventilated area </td>
                <td><select class="form-control" wire:model.defer="main_flammables_stored_safely">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td><select class="form-control" wire:model.defer="lab_flammables_stored_safely">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>h) Are flammable and corrosive agents stored on lower shelves or separated from one another
                    (preferably in a separate cabinet) </td>
                <td><select class="form-control" wire:model.defer="main_corrosives_separated">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td><select class="form-control" wire:model.defer="lab_corrosives_separated">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
            </tr>


            <tr>
                <td>i) Are Specific Material Safety Data Sheets available for all reagents in storage?</td>
                <td><select class="form-control" wire:model.defer="main_safety_data_sheets_available">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td><select class="form-control" wire:model.defer="lab_safety_data_sheets_available">
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        <option value="2">N/A</option>
                    </select>
                </td>
                <td>
                    <textarea class="form-control" type="text" wire:model.defer="practices_comments"></textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>
{{-- <button class="btn btn-success" wire:click ='saveStoragePractices'> Save</button> --}}

<p>
    <strong>Score:</strong> Sum of scores (a to i) divided by 9 minus NA = ______
    <strong>Percentage:</strong> __________
</p>

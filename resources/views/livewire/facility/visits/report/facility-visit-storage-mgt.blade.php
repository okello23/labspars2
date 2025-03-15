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
               {{ checkYesNoNA($cleanliness?->lab_store_clean) }}
            </td>

        </tr>
        <tr>
            <td>The Main store is clean and tidy</td>
            <td>
                {{ checkYesNoNA($cleanliness?->main_store_clean) }}
            </td>
        </tr>
        <tr>
            <td>The Laboratory is clean and tidy</td>
            <td>
                {{ checkYesNoNA($cleanliness?->laboratory_clean) }}
            </td>
            <td rowspan="3">
                
                {{ $cleanliness?->cleanliness_comments }}
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
                {{ checkYesNoNA($hygiene?->running_water) }}
            </td>
        </tr>
        <tr>
            <td>Is the hand washing area separate from the staining area?</td>
            <td> 
                {{ checkYesNoNA($hygiene?->hand_washing_separate) }}
            </td>
        </tr>
        <tr>
            <td>Is the hand washing facility accessible, hygienic, and functioning?</td>
            <td> 
                {{ checkYesNoNA($hygiene?->hand_washing_facility) }}
            </td>
        </tr>
        <tr>
            <td>Is the drainage system of suitable standards?</td>
            <td> 
                {{ checkYesNoNA($hygiene?->drainage_system) }}
            </td>           
        </tr>
        <tr>
            <td>Is there soap for hand washing?</td>
            <td> 
                {{ checkYesNoNA($hygiene?->soap_available) }}
            </td>

            <td rowspan="4">
                {{ $hygiene?->hygiene_comments }}
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
            <td>
                {{ checkYesNoNA($system?->main_store_shelves) }}
            </td>
            <td>
                {{ checkYesNoNA($system?->lab_store_shelves) }}
            </td>

        </tr>
        <tr>
            <td>Are reagents stored on shelves or in cabinets?</td>
            <td>
                {{ checkYesNoNA($system?->main_store_reagents) }}
            </td>
            <td>
                {{ checkYesNoNA($system?->lab_store_reagents) }}
            </td>

        </tr>
        <tr>
            <td>Are stock cards kept next to the reagents on the shelves?</td>
            <td>
                {{ checkYesNoNA($system?->main_store_stock_cards) }}
            </td>
            <td>
                {{ checkYesNoNA($system?->lab_store_stock_cards) }}
            </td>

        </tr>
        <tr>
            <td>Are lab reagents stored systematically (alphabetic, usage form)?</td>
            <td>
                {{ checkYesNoNA($system?->main_store_systematic) }}
            </td>
            <td>
                {{ checkYesNoNA($system?->lab_store_systematic) }}
            </td>
           
        </tr>
        <tr>
            <td>Are the shelves and cabinets labeled?</td>
            <td>
                {{ checkYesNoNA($system?->main_store_labeled) }}
            </td>
            <td>
                {{ checkYesNoNA($system?->lab_store_labeled) }}
            </td>
            <td rowspan="5">
                {{ $system?->storage_comments }}
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
            <td>No signs of pests/harmful insects/rodents</td>
            <td>
                {{ checkYesNoNA($condition?->main_store_pests) }}
            </td>
            <td>
                {{ checkYesNoNA($condition?->lab_store_pests) }}
            </td>
        </tr>
        <tr>
            <td>Are supplies protected from direct sunlight?</td>
            <td>
                {{ checkYesNoNA($condition?->main_store_sunlight) }}
            </td>
            <td>
                {{ checkYesNoNA($condition?->lab_store_sunlight) }}
            </td>
        </tr>
        <tr>
            <td>Is the temperature of the storage room monitored?</td>
            <td>
                {{ checkYesNoNA($condition?->main_store_temperature) }}
            </td>
            <td>
                {{ checkYesNoNA($condition?->lab_store_temperature) }}
            </td>
        </tr>
        <tr>
            <td>Is the storeroom lockable and access restricted to authorized personnel?</td>
            <td>
                {{ checkYesNoNA($condition?->main_store_lockable) }}
            </td>
            <td>
                {{ checkYesNoNA($condition?->lab_store_lockable) }}
            </td>
            <td rowspan="3">
                {{ $condition?->condition_comments }}
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
            <td>Is there a record for expired reagents?</td>
            <td>
                {{ checkYesNoNA($StoragePractices?->main_store_expired_record) }}
            </td>
            <td>
                {{ checkYesNoNA($StoragePractices?->lab_store_expired_record) }}
            </td>
        </tr>
        <tr>
            <td>Is there a place to store expired reagents separately?</td>
            <td>
                {{ checkYesNoNA($StoragePractices?->main_store_expired_separate) }}
            </td>
            <td>
                {{ checkYesNoNA($StoragePractices?->lab_store_expired_separate) }}
            </td>
        </tr>
        <tr>
            <td>Is FEFO adhered to?</td>
            <td>
                {{ checkYesNoNA($StoragePractices?->main_store_fefo) }}
            </td>
            <td>
                {{ checkYesNoNA($StoragePractices?->lab_store_fefo) }}
            </td>
        </tr>
        <tr>
            <td>Are reagent bottles/kits labeled with the date of opening?</td>
            <td>
                {{ checkYesNoNA($StoragePractices?->main_store_opening_date) }}
            </td>
            <td>
                {{ checkYesNoNA($StoragePractices?->lab_store_opening_date) }}
            </td>
            <td>
                {{ $StoragePractices?->practices_comments }}
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

<div>
    <div class="card">
        <div class="card-header">
            @include('livewire.facility.visits.inc.visit-header')
        </div>
        <!-- Persons Supervised -->
        <div class="card-body">
            <div>
                <h4>Persons Supervised</h4>
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Sex (F/M)</th>
                            <th>Profession</th>
                            <th>Contact/Phone No.</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
        
                        @forelse ($supervised_persons as $key => $supervised_person)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $supervised_person->name }}</td>
                                <td>{{ $supervised_person->sex ?? 'N/A' }}</td>
                                <td>{{ $supervised_person->profession ?? 'N/A' }}</td>
                                <td>{{ $supervised_person->contact }}</td>
                                <td>{{ $supervised_person->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="5">No Persons Supervised Records</td>
                            </tr>
                        @endforelse
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        
            <!-- Supervisors -->
            <div>
                <h4>Supervisors</h4>
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Name</th>
                            <th>Phone No.</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($supervisors as $key => $supervisor)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $supervisor->title ?? 'N/A' }}</td>
                                <td>{{ $supervisor->name }}</td>
                                <td>{{ $supervisor->contact }}</td>
                                <td>{{ $supervisor->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="5">No Supervisor Records</td>
                            </tr>
                        @endforelse
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>          
            </div>
            <hr>
            <!-- Storage Details -->
            <div>
                <h4>Laboratory Supply Storage</h4>
                <h5>D1: Where are Laboratory supplies MAINLY stored in the facility?</h5>
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Store</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($supply_storages->where('entry_type', 'Main Store') as $key=>$mainStorage)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $mainStorage->storageType?->name }}</td>
                                <td title="{{ $mainStorage->comment }}">{{ Str::words($mainStorage->comment, 30, '...') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No Laboratory supplies MAINLY stored in the facility</td>
        
                            </tr>
                        @endforelse
        
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
        
                <h5>D2: Where ELSE are Laboratory supplies stored in the facility?</h5>
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Store</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($supply_storages->where('entry_type', 'Other Store') as $key=>$otherStorage)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $otherStorage->storageType?->name }}</td>
                                <td title="{{ $otherStorage->comment }}">{{ Str::words($otherStorage->comment, 30, '...') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Laboratory supplies ELSE stored in the facility</td>
        
                            </tr>
                        @endforelse
        
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
            <!-- Stock Cards -->
            <hr>
            <div>
                <h4>Stock Cards</h4>
                <h5>D3: Does the facility use stock cards to track the use of laboratory supplies?</h5>
                <label>Yes <input type="radio" class="form-control" wire:model='use_stock_cards' name="uses_stock_cards"
                        value="1"></label>
                <label>No <input type="radio" class="form-control" wire:model='use_stock_cards' name="uses_stock_cards"
                        value="0"></label>
        
                <h5>D4: Where are stock cards kept in the facility?</h5>
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Store</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($supply_storages->where('entry_type', 'Card Store') as $key=>$cardStorage)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $cardStorage->storageType?->name }}</td>
                                <td title="{{ $cardStorage->comment }}">{{ Str::words($cardStorage->comment, 30, '...') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No stock cards kept in the facility </td>
        
                            </tr>
                        @endforelse
        
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>        
                <h5>D5: If stock cards are kept in multiple places, how is the consumption reconciled with the main
                    store/stock card?</h5>
                <textarea name="reconciliation_comments" wire:model.lazy='consumption_reconciliation' class="form-control"></textarea>
            </div>
        </div>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: center;
            }
            th {
                background-color: #f2f2f2;
            }
            textarea {
                width: 100%;
                height: 100px;
                margin-top: 10px;
            }
            input[type="checkbox"] {
                transform: scale(1.2);
            }
        </style>
    </head>
    <body>
    
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
    </div>

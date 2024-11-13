<div>
    <div class="card">
        <div class="card-header">
            @include('livewire.facility.visits.inc.visit-header')
        </div>
        <!-- Persons Supervised -->
        <div class="card-body">
            <div>
                <h4>Persons Supervised</h4>
                <table style="width: 100%">
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
                <table style="width: 100%">
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
                <table style="width: 100%">
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
                <table style="width: 100%">
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
                <table style="width: 100%">
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
                
                    <p>{{ $consumption_reconciliation }}</p>
            </div>
            <hr>
            @include('livewire.facility.visits.report.facility-visit-stock-mgt')
            @include('livewire.facility.visits.report.facility-visit-storage-mgt')
            @include('livewire.facility.visits.report.facility-visit-ordering')
        </div>
       

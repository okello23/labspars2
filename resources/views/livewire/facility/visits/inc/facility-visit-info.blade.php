<div class="card-body">
    <div>
        <h4>Persons Supervised <span class="ms-auto text-right"><button 
            class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
            data-target="#personalModal">
            Add New
        </button></span></h4>
        <table class="table" style="width: 100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Sex (F/M)</th>
                    <th>Profession</th>
                    <th>Contact/Phone No.</th>
                    <th>Email</th>
                    <th>Action</th>
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
                    <td>
                        <button wire:click="editData({{ $supervised_person->id }})"
                            class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
                            data-target="#personalModal">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>
                </tr>
                @empty
                   <tr>
                    <td class="text-center" colspan="6">No Persons Supervised Records</td>
                   </tr>
                @endforelse
                <!-- Add more rows as needed -->
            </tbody>
        </table>
        <div wire:ignore.self  class="modal fade" id="personalModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="defaultModalLabel">
                          @if (!$toggleForm)
                          Add
                          @else
                          Update
                          @endif a supervised Person
                          </h5>
                    </div>
                    <form  @if ($toggleForm) wire:submit.prevent="updatePersonal" @else wire:submit.prevent="storePersonal" @endif >
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-8">
                                    <label for="name" class="form-label required">Name</label>
                                    <input type="text" id="name" class="form-control" name="name" required
                                        wire:model.defer="name">
                                    @error('name')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="sex" class="form-label required">Sex</label>
                                    <select id="sex" class="form-control" name="sex" required
                                        wire:model.defer="sex">
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    @error('sex')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="contact" class="form-label required">Contact</label>
                                    <input type="nunmber" id="email" class="form-control" name="contact" required
                                        wire:model.defer="contact">
                                    @error('contact')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                             
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label required">Email</label>
                                    <input type="email" id="email" class="form-control" name="email" required
                                        wire:model.defer="email">
                                    @error('email')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="Profession" class="form-label required">Profession</label>
                                    <input type="text" id="Profession" class="form-control" name="profession" required
                                        wire:model.defer="profession">
                                    @error('profession')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" wire:click="close()" >{{ __('close') }}</button>
                            @if($toggleForm)
                            <x-button type="submit"  class="btn-success btn-sm">{{ __('Update') }}</x-button>
                             @else
                             <x-button type="submit"  class="btn-success btn-sm">{{ __('Save') }}</x-button>
                             @endif
                        </div><!--end modal-footer-->
                    </form>
    
                </div>
            </div>
        </div>
    </div>

    <!-- Supervisors -->
    <div>
        <h4>Supervisors
            <button 
            class="action-ico btn btn-sm btn-info mx-1" data-toggle="modal"
            data-target="#supervisorModal">
            Add New
        </button>
        </h4>
         <table class="table" style="width: 100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Name</th>
                    <th>Phone No.</th>
                    <th>Email</th>
                    <th>Action</th>
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
                    <td>
                        <button wire:click="editSupervisor({{ $supervisor->id }})"
                            class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
                            data-target="#supervisorModal">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>
                </tr>
                @empty
                   <tr>
                    <td class="text-center" colspan="6">No Supervisor Records</td>
                   </tr>
                @endforelse
                <!-- Add more rows as needed -->
            </tbody>
        </table>
        <div wire:ignore.self  class="modal fade" id="supervisorModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="defaultModalLabel">
                          @if (!$toggleForm)
                          Add
                          @else
                          Update
                          @endif a supervisor
                          </h5>
                    </div>
                    <form  @if ($toggleForm) wire:submit.prevent="updateSupervisor" @else wire:submit.prevent="storeSupervisor" @endif >
                        <div class="modal-body">
                            <div class="row">   
                                <div class="mb-3 col-md-4">
                                <label for="title" class="form-label required">Title</label>
                                <select id="title" class="form-control" name="title" required
                                    wire:model.defer="title">
                                    <option value="">Select</option>
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Miss.">Miss.</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Eng.">Eng.</option>
                                    <option value="Prof.">Prof.</option>
                                </select>
                                @error('title')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                                <div class="mb-3 col-md-8">
                                    <label for="name" class="form-label required">Name</label>
                                    <input type="text" id="name" class="form-control" name="name" required
                                        wire:model.defer="name">
                                    @error('name')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>                            

                                <div class="mb-3 col-md-6">
                                    <label for="contact" class="form-label required">Contact</label>
                                    <input type="nunmber" id="email" class="form-control" name="contact" required
                                        wire:model.defer="contact">
                                    @error('contact')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                             
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label required">Email</label>
                                    <input type="email" id="email" class="form-control" name="email" required
                                        wire:model.defer="email">
                                    @error('email')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" wire:click="close()" >{{ __('close') }}</button>
                            @if($toggleForm)
                            <x-button type="submit"  class="btn-success btn-sm">{{ __('Update') }}</x-button>
                             @else
                             <x-button type="submit"  class="btn-success btn-sm">{{ __('Save') }}</x-button>
                             @endif
                        </div><!--end modal-footer-->
                    </form>
    
                </div>
            </div>
        </div>
    </div>

    <!-- Storage Details -->
    <div>
        <h4>Laboratory Supply Storage      
            <button 
            class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
            data-target="#storageModal" wire:click="$set('storage_type','Main Store')">
            Add New
        </button></h4>
        <h5>D1: Where are Laboratory supplies MAINLY stored in the facility?</h5>
         <table class="table" style="width: 100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Store</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($supply_storages->where('entry_type', 'Main Store') as $key=>$mainStorage)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $mainStorage->storageType?->name }}</td>
                    <td title="{{ $mainStorage->comment }}">{{ Str::words($mainStorage->comment, 30, '...') }}</td>
                    <td><button wire:click="editStorage({{ $mainStorage->id }})"
                        class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
                        data-target="#storageModal">
                        <i class="fa fa-edit"></i>
                    </button></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No Laboratory supplies MAINLY stored in the facility</td>
                    
                </tr>
                @endforelse
               
                <!-- Add more rows as needed --> 
            </tbody>
        </table>

        <h5>D2: Where ELSE are Laboratory supplies stored in the facility?
            <button 
            class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
            data-target="#storageModal" wire:click="$set('storage_type','Other Store')">
            Add New
        </button>
        </h5>
        <table class="table" style="width: 100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Store</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($supply_storages->where('entry_type', 'Other Store') as $key=>$otherStorage)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $otherStorage->storageType?->name }}</td>
                    <td title="{{ $otherStorage->comment }}">{{ Str::words($otherStorage->comment, 30, '...') }}</td>
                    <td><button wire:click="editStorage({{ $otherStorage->id }})"
                        class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
                        data-target="#storageModal">
                        <i class="fa fa-edit"></i>
                    </button></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4"  class="text-center">No Laboratory supplies ELSE stored in the facility</td>
                    
                </tr>
                @endforelse
               
                <!-- Add more rows as needed --> 
            </tbody>
        </table>
    </div>

    <!-- Stock Cards -->
    <div>
        <h4>Stock Cards</h4>
        <h5>D3: Does the facility use stock cards to track the use of laboratory supplies?</h5>
        <label>Yes <input type="radio"  class="form-control" wire:model='use_stock_cards' name="uses_stock_cards" value="1"></label>
        <label>No <input type="radio"  class="form-control" wire:model='use_stock_cards' name="uses_stock_cards" value="0"></label>

        <h5>D4: Where are stock cards kept in the facility?
            <button 
            class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
            data-target="#storageModal" wire:click="$set('storage_type','Card Store')">
            Add New
        </button>
        </h5>
        <table class="table" style="width: 100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Store</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($supply_storages->where('entry_type', 'Card Store') as $key=>$cardStorage)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $cardStorage->storageType?->name }}</td>
                    <td title="{{ $cardStorage->comment }}">{{ Str::words($cardStorage->comment, 30, '...') }}</td>
                    <td><button wire:click="editStorage({{ $cardStorage->id }})"
                        class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
                        data-target="#storageModal">
                        <i class="fa fa-edit"></i>
                    </button></td>
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
        <textarea name="reconciliation_comments"  wire:model.lazy='consumption_reconciliation' class="form-control"></textarea>
    </div>

    @include('livewire.facility.visits.inc.facilit-storage-types')
    @push('scripts')
        <script>
            window.addEventListener('close-modal', event => {
                $('#personalModal').modal('hide');
                $('#supervisorModal').modal('hide');
                $('#storageModal').modal('hide');
                $('#show-delete-confirmation-modal').modal('hide');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush
</div>

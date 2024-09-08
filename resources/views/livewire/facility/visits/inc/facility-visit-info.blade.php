<div class="card-body">
    <div>
        <h4>Persons Supervised <span class="ms-auto floa-end"><button 
            class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal"
            data-target="#personalModal">
            Add New
        </button></span></h4>
        <table>
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
        <h4>Supervisors</h4>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Contact/Phone No.</th>
                    <th>Title</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><input type="text" name="supervisor_name_1"></td>
                    <td><input type="text" name="supervisor_phone_1"></td>
                    <td><input type="text" name="supervisor_title_1"></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><input type="text" name="supervisor_name_2"></td>
                    <td><input type="text" name="supervisor_phone_2"></td>
                    <td><input type="text" name="supervisor_title_2"></td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <!-- Storage Details -->
    <div>
        <h4>Laboratory Supply Storage</h4>
        <h3>D1: Where are Laboratory supplies MAINLY stored in the facility?</h3>
        <table>
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Tick (✔)</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Main store</td>
                    <td><input type="checkbox" name="main_store"></td>
                    <td><input type="text" name="main_store_comment"></td>
                </tr>
                <tr>
                    <td>Laboratory store</td>
                    <td><input type="checkbox" name="lab_store"></td>
                    <td><input type="text" name="lab_store_comment"></td>
                </tr>
                <tr>
                    <td>Pharmacy store</td>
                    <td><input type="checkbox" name="pharmacy_store"></td>
                    <td><input type="text" name="pharmacy_store_comment"></td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>

        <h3>D2: Where ELSE are Laboratory supplies stored in the facility?</h3>
        <table>
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Tick (✔)</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Main store</td>
                    <td><input type="checkbox" name="else_main_store"></td>
                    <td><input type="text" name="else_main_store_comment"></td>
                </tr>
                <tr>
                    <td>Laboratory store</td>
                    <td><input type="checkbox" name="else_lab_store"></td>
                    <td><input type="text" name="else_lab_store_comment"></td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <!-- Stock Cards -->
    <div>
        <h4>Stock Cards</h4>
        <h3>D3: Does the facility use stock cards to track the use of laboratory supplies?</h3>
        <label>Yes <input type="radio" name="uses_stock_cards" value="yes"></label>
        <label>No <input type="radio" name="uses_stock_cards" value="no"></label>

        <h3>D4: Where are stock cards kept in the facility?</h3>
        <table>
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Tick (✔)</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Main store</td>
                    <td><input type="checkbox" name="stock_main_store"></td>
                    <td><input type="text" name="stock_main_store_comment"></td>
                </tr>
                <tr>
                    <td>Laboratory store</td>
                    <td><input type="checkbox" name="stock_lab_store"></td>
                    <td><input type="text" name="stock_lab_store_comment"></td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>

        <h3>D5: If stock cards are kept in multiple places, how is the consumption reconciled with the main
            store/stock card?</h3>
        <textarea name="reconciliation_comments" rows="3" cols="80"></textarea>
    </div>
    
    @push('scripts')
        <script>
            window.addEventListener('close-modal', event => {
                $('#personalModal').modal('hide');
                $('#supervisoirModal').modal('hide');
                $('#show-delete-confirmation-modal').modal('hide');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush
</div>

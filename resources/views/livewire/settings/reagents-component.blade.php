<div>

    @section('title', 'Reagents')
    @include('livewire.layouts.partials.inc.create-resource')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                        Storage Types (<span class="text-danger fw-bold">{{ $reagents->total() }}</span>)
                                        @include('livewire.layouts.partials.inc.filter-toggle')
                                    @else
                                        Edit value
                                    @endif

                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter Users</h6>

                            <div class="mb-3 col-md-3">
                                <label for="user_status" class="form-label">Status</label>
                                <select wire:model="user_status" class="form-control select2" id="user_status">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Suspended</option>
                                </select>
                            </div>

                        </div>
                        <div class="row mb-0">


                            <div class="mb-3 col-md-2">
                                <label for="from_date" class="form-label">From Date</label>
                                <input id="from_date" type="date" class="form-control"
                                    wire:model.lazy="from_date">
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="to_date" class="form-label">To Date</label>
                                <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="perPage" class="form-label">Per Page</label>
                                <select wire:model="perPage" class="form-control" id="perPage">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="orderBy" class="form-label">OrderBy</label>
                                <select wire:model="orderBy" class="form-control">
                                    <option value="name">Name</option>
                                    <option value="id">Latest</option>
                                    <option value="is_active">Status</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-1">
                                <label for="orderAsc" class="form-label">Order</label>
                                <select wire:model="orderAsc" class="form-control" id="orderAsc">
                                    <option value="1">Asc</option>
                                    <option value="0">Desc</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="search" class="form-label">Search</label>
                                <input id="search" type="text" class="form-control"
                                    wire:model.debounce.300ms="search" placeholder="search">
                            </div>
                            <hr>
                        </div>

                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped table-bordered mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reagents as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->category->name??'N/A' }}</td>
                                            <td>{{ $value->description }}</td>

                                            <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                            <td>
                                                <button wire:click="editData({{ $value->id }})" class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal" data-target="#addUpdateRecord">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-right">
                                    {{ $reagents->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <div wire:ignore.self  class="modal fade" id="addUpdateRecord" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">
                      @if (!$toggleForm)
                      Add Reagents
                      @else
                      Update 
                      @endif
                      </h5>
                </div>
                <form  @if ($toggleForm) wire:submit.prevent="updatevalue" @else wire:submit.prevent="storevalue" @endif >
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
                                <label for="is_active" class="form-label required">{{ __('public.status') }}</label>
                                <select class="form-control selectr"  id="is_active" wire:model.defer="is_active">
                                    <option selected value="">Select</option>
                                    <option value='1'>Active</option>
                                    <option value='0'>Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="is_active" class="form-label required">{{ __('Category') }}</label>
                                <select class="form-control selectr"  id="is_active" wire:model.defer="testing_category_id">
                                    <option selected value="">Select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('testing_category_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-8">
                                <label for="description" class="form-label required">Description</label>
                                <textarea  id="description" class="form-control" name="description" required
                                    wire:model.defer="description"></textarea>
                                @error('description')
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
    @push('scripts')
            <script>
                window.addEventListener('close-modal', event => {
                    $('#addUpdateRecord').modal('hide');
                    $('#delete_modal').modal('hide');
                    $('#show-delete-confirmation-modal').modal('hide');
                });
                window.addEventListener('delete-modal', event => {
                    $('#delete_modal').modal('show');
                });
            </script>
    @endpush
</div>

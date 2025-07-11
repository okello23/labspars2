<div>

    @section('title', 'LSS Visits')
    <!-- @include('livewire.layouts.partials.inc.create-resource') -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                        Facilit Visits (<span class="text-danger fw-bold">{{ $visits->total() }}</span>)
                                        @include('livewire.layouts.partials.inc.filter-toggle')
                                    @else
                                        Edit value
                                    @endif
                                    <a href="{{ asset('storage/documents/labSparsTool_2024.pdf') }}"
                                        class="btn btn-info fa fa-file-pdf-o" download>
                                        Download LabSpars Tool
                                    </a>

                                </h5>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter</h6>

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
                                <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
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
                            <table id="datableButton"
                                class="table table-striped table-sm table-bordered mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Facility Name</th>
                                        <th>Visit Number</th>
                                        <th>In Charge Name</th>
                                        <th>In Charge Contact</th>
                                        <th>Date Of Visit</th>
                                        <th>Date Of Next Visit</th>
                                        <th>District</th>
                                        <th>Health Sub District</th>
                                        <th>Region</th>
                                        <th>Create By</th>
                                        <th>Stage</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visits as $key => $facilityvisit)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $facilityvisit->facility->name }}
                                                {{ $facilityvisit->facility?->level }}</td>
                                            <td>{{ $facilityvisit->visit_number ?? 'N/A' }}</td>
                                            <td>{{ $facilityvisit->in_charge_name ?? 'N/A' }}</td>
                                            <td>{{ $facilityvisit->in_charge_contact }}</td>
                                            <td>{{ $facilityvisit->date_of_visit }}</td>
                                            <td>{{ $facilityvisit->date_of_next_visit }}</td>
                                            <td>{{ $facilityvisit->facility?->healthSubDistrict->district->name ?? 'N/A' }}
                                            </td>
                                            <td>{{ $facilityvisit->facility->healthSubDistrict->name ?? 'N/A' }}</td>
                                            <td>{{ $facilityvisit->facility->healthSubDistrict?->district->region?->name }}
                                            </td>
                                            <td>{{ $facilityvisit->createdBy->name }}</td>
                                            <td>{{ $facilityvisit->stage }}</td>
                                            <td><span class="badge badge-primary">{{ $facilityvisit->status }}</span>
                                            </td>
                                            <td>

                                                <a href="{{ URL::signedRoute('facility-visit_view', $facilityvisit->visit_code) }}"
                                                    class="action-ico btn btn-sm btn-info mx-1">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ URL::signedRoute('facility-visit_dashboard', $facilityvisit->visit_code) }}"
                                                    class="action-ico btn btn-sm btn-info mx-1">
                                                    <i class="fa fa-home"></i>
                                                </a>
                                                <a href="{{ URL::signedRoute('facility-visit_details', $facilityvisit->visit_code) }}"
                                                    class="action-ico btn btn-sm btn-success mx-1">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-right">
                                    {{ $visits->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('livewire.facility.visits.inc.new-facility-visit')
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

<div>
    @section('title', 'Facility Performance')

    <div class="row">
        <div class="info-box" style="float:left; width: 100%; overflow-x: auto; overflow-y: auto;">
            <div class="info-box-content">
                <h4>
                    LSS Facility Performance Summary Report
                    (<span class="text-danger fw-bold">{{ $facility_performance->total() }}</span>)
                </h4>

                <div class="progress">
                    <div class="progress-bar bg-info" style="width:100%; height:25%;"></div>
                </div>

                <span class="progress-description">

                    <div class="table-responsive">

                        {{-- FILTERS --}}

                        <x-table-utilities>
                            <div class="md-3">
                                <div class="mb-1 col-md-12">
                                    <label for="filter_region_id" class="form-label">Region</label>
                                    <select class="form-control" wire:model="filter_region_id">
                                        <option value="">All</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="md-3">
                                <div class="mb-1 col-md-12">
                                    <label for="filter_district_id" class="form-label">District</label>
                                    <select class="form-control" wire:model="filter_district_id"
                                            @if(empty($districts_list)) disabled @endif>
                                        <option value="">Select District</option>
                                        @foreach($districts_list as $district)
                                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="md-3">
                                <div class="mb-1 col-md-12">
                                    <label for="from_date" class="form-label">From Date</label>
                                    <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
                                </div>
                            </div>

                            <div class="md-3">
                                <div class="mb-1 col-md-12">
                                    <label for="to_date" class="form-label">To Date</label>
                                    <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                                </div>
                            </div>
                        </x-table-utilities>

                        {{-- TABLE --}}
                        <table class="table table-striped table-sm table-bordered mb-0 w-100 sortable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Facility Name</th>
                                    <th>District</th>
                                    <th>Region</th>
                                    <th>Stock Mgt</th>
                                    <th>Storage</th>
                                    <th>Ordering</th>
                                    <th>Equipment</th>
                                    <th>LIS</th>
                                    <th>Spider Graph <br>Value (Scaled)</th>
                                    <th>Total Spider Score <br><i>(max = 25)</i></th>
                                    <th>Overall Score <br> %age</th>
                                    <th>Date Of Visit</th>
                                    <th>Date Entered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody wire:key="league-table-body">
                                @foreach ($facility_performance as $lss)
                                    <tr>
                                       <td>{{ ($facility_performance->currentPage() - 1) * $facility_performance->perPage() + $loop->iteration }}</td>
                                        <td>{{ $lss->facility->name ?? 'NA' }} ({{ $lss->facility?->level }})</td>
                                        <td>{{ $lss->district ?? 'N/A' }}</td>
                                        <td>{{ $lss->region ?? 'N/A' }}</td>
                                        <td>{{ number_format($lss->stock_management, 2) }}</td>
                                        <td>{{ number_format($lss->storage_management, 2) }}</td>
                                        <td>{{ number_format($lss->ordering_management, 2) }}</td>
                                        <td>{{ number_format($lss->equipment_management, 2) }}</td>
                                        <td>{{ number_format($lss->lis_mgt, 2) }}</td>
                                        
                                        {{-- total_score = avg of all thematic areas --}}
                                        <td>{{ number_format($lss->total_score, 2) }}</td>
                                        
                                        {{-- total spider score (max = 25) --}}
                                        <td>{{ number_format($lss->total_score * 5, 2) }}</td>
                                        
                                        {{-- percentage --}}
                                        <td>{{ number_format(($lss->total_score * 5) / 25 * 100, 0) }}%</td>
                                        <td>{{ $lss->date_of_visit }}</td>
                                        <td>{{ $lss->created_at }}</td>
                                        <td>
                                            <a href="{{ URL::signedRoute('facility-visit_view', $lss->visit_code) }}"
                                               class="action-ico btn btn-sm btn-info mx-1">
                                                <i class="fa fa-eye" title="View LSS entry"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="btn-group float-right">
                                {{ $facility_performance->links('vendor.livewire.bootstrap') }}
                            </div>
                        </div>
                    </div>

                </span>

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

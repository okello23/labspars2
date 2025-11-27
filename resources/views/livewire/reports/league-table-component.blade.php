<div>
    @section('title', 'League Table')
    <div class="row">
        <div class="info-box" style="float:left; width: 100%; overflow-x: auto; overflow-y: auto;">
            <div class="info-box-content">
                <h4>
                    LSS District League Table
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
                                <th>District</th>
                                <th>Region</th>
                                <th>Baseline Score</th>
                                <th>Current Score</th>
                                <th>Change</th>
                                <th>% Change</th>
                                <th>Average Score</th>
                                <th>Facilities visited</th>
                                <th>Total Visits</th>
                                <th>Rank</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($district_performance as $district)
                            <tr>
                                <td>{{ $district->district }}</td>
                                <td>{{ $district->region }}</td>
                                <td>{{ $district->baseline_score }}</td>
                                <td>{{ $district->current_score }}</td>
                                <td>
                                    @if($district->change > 0)
                                        <span class="text-success fw-bold">
                                            {{ $district->change }} ▲
                                        </span>
                                    @elseif($district->change < 0)
                                        <span class="text-danger fw-bold">
                                            {{ $district->change }} ▼
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            {{ $district->change }} ➝
                                        </span>
                                    @endif
                                </td>                                    
                                <td>
                                   @if($district->percent_change > 0)
                                       <span class="text-success fw-bold">
                                           {{ $district->percent_change }}% ▲
                                       </span>
                                   @elseif($district->percent_change < 0)
                                       <span class="text-danger fw-bold">
                                           {{ $district->percent_change }}% ▼
                                       </span>
                                   @else
                                       <span class="text-muted">
                                           {{ $district->percent_change }}% ➝
                                       </span>
                                   @endif
                               </td>

                                <td>{{ number_format($district->average_score, 1) }}</td>
                                <td>{{ $district->facilities }}</td>
                                <td>{{ $district->visits_count }}</td>
                                <td>{{ $district->rank }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

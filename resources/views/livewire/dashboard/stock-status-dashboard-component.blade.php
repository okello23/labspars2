@section('title', 'Stock Status')

<div>
    <div class="container-fluid">

        <div class="row" wire:ignore>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Stock Status Summaries</legend>

                <!-- ===================== -->
                <!-- Filters -->
                <!-- ===================== -->
                <x-table-utilities>

                    <!-- Region -->
                    <div class="md-3">
                        <div class="mb-1 col-md-12">
                            <label class="form-label">Region</label>
                            <select class="form-control" wire:model="filter_region_id">
                                <option value="">All</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- District -->
                    <div class="md-3">
                        <div class="mb-1 col-md-12">
                            <label class="form-label">District</label>
                            <select class="form-control"
                                    wire:model="filter_district_id"
                                    @if(empty($districts_list)) disabled @endif>
                                <option value="">Select District</option>
                                @foreach($districts_list as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Period -->
                    <div class="md-3">
                        <div class="mb-1 col-md-12">
                            <label class="form-label">Period</label>
                            <select wire:model="dateRange" class="form-control">
                                <option value="all">All Time</option>
                                <option value="q1">Qtr 1</option>
                                <option value="q2">Qtr 2</option>
                                <option value="q3">Qtr 3</option>
                                <option value="q4">Qtr 4</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>
                    </div>

                    @if ($dateRange === 'custom')
                        <div class="md-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" wire:model="customStartDate" class="form-control">
                        </div>

                        <div class="md-3">
                            <label class="form-label">End Date</label>
                            <input type="date" wire:model="customEndDate" class="form-control">
                        </div>
                    @endif

                </x-table-utilities>

                <!-- ===================== -->
                <!-- Scrollable Table -->
                <!-- ===================== -->
                <div class="col-12">
                    <div class="table-responsive" style="overflow-x:auto;">
                        <table class="table table-striped table-sm table-bordered mb-0 sortable  border rounded">
                            <thead class="table-light">
                                <tr>
                                    <th>District</th>
                                    <th>Region</th>
                                    <th>Facility</th>
                                    <th>Test Category</th>
                                    <th>Commodity</th>
                                    <!-- <th>Performs Test?</th> -->
                                    <th>SoH</th>
                                    <!-- <th>Past 3 Month's Use</th> -->
                                    <th>PC</th>
                                    <th>AMC</th>
                                    <th>Days Stocked out</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($grouped_stock as $facilityId => $rows)
                                    @php
                                        $first = $rows->first();
                                        $rowCount = $rows->count();
                                    @endphp

                                    @foreach ($rows as $index => $stock)
                                        <tr>
                                            @if ($index === 0)
                                                <td rowspan="{{ $rowCount }}">
                                                    {{ $first->visit->facility->healthSubDistrict->district->name }}
                                                </td>

                                                <td rowspan="{{ $rowCount }}">
                                                    {{ $first->visit->facility->healthSubDistrict->name }}
                                                </td>

                                                <td rowspan="{{ $rowCount }}">
                                                    {{ $first->visit->facility->name }}
                                                    ({{ $first->visit->facility->level }})
                                                </td>
                                            @endif

                                            <td>{{ $stock->reagent->category->name }}</td>
                                            <td>{{ $stock->reagent->name }}</td>
                                            <!-- <td>{{ $stock->test_performed ? 'Yes' : 'No' }}</td> -->
                                            <td>{{ number_format($stock->balance_on_card,1) }}</td>
                                            <!-- <td>{{ number_format($stock->last_issues,1) }}</td> -->
                                            <td>{{ number_format($stock->physical_count,1) }}</td>
                                            <td>{{ number_format($stock->amc_calculated,1) }}</td>
                                            <td>{{ number_format($stock->out_of_stock_days,1) }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </fieldset>
        </div>

    </div>
</div>

@push('scripts')
@endpush

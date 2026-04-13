@section('title', 'Stock Status')

<div>
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col-12">
                <fieldset class="scheduler-border w-100" style="width: 100%;">
                    <legend class="scheduler-border">Stock Status Summaries</legend>

                    @if($quarterNotice)
                        <div class="alert alert-info border-1 alert-dismissible fade show" role="alert">
                            {{ $quarterNotice }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

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
                                <input
                                    type="text"
                                    class="form-control"
                                    list="stock-status-district-options"
                                    wire:model.debounce.300ms="districtSearch"
                                    placeholder="Search District"
                                    @if(empty($districts_list)) disabled @endif
                                >
                                <datalist id="stock-status-district-options">
                                    @foreach($districts_list as $district)
                                        <option value="{{ $district->name }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <!-- Period Mode -->
                        <div class="md-3">
                            <div class="mb-1 col-md-12">
                                <label class="form-label">Period</label>
                                <select wire:model="dateRange" class="form-control">
                                    <option value="quarter">Quarter</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                        </div>

                        @if ($dateRange === 'quarter')
                            <div class="md-3">
                                <div class="mb-1 col-md-12">
                                    <label class="form-label">Year</label>
                                    <select wire:model="filterYear" class="form-control">
                                        @foreach($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="md-3">
                                <div class="mb-1 col-md-12">
                                    <label class="form-label">Quarter</label>
                                    <select wire:model="filterQuarter" class="form-control">
                                        <option value="q1">Qtr 1</option>
                                        <option value="q2">Qtr 2</option>
                                        <option value="q3">Qtr 3</option>
                                        <option value="q4">Qtr 4</option>
                                    </select>
                                </div>
                            </div>
                        @endif

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
                            <table class="table table-striped table-sm table-bordered mb-0 sortable border rounded w-100">
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

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="btn-group float-right">
                                {{ $grouped_stock->links('vendor.livewire.bootstrap') }}
                            </div>
                        </div>
                    </div>

                </fieldset>
            </div>
        </div>

    </div>
</div>

@push('scripts')
@endpush

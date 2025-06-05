{{-- The whole world belongs to you. --}}
<div>
    <div class="row clearfix">
        <div class="col-12">
            <div class="section_title">
                <div class="mr-3">
                    <h3>Overview</h3>
                    <small>Statistics, Visit Analytics Data Visualization, Big Data Analytics, etc.</small>
                </div>

                <div class="input-group mb-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Region</label>
                        <select wire:model="selectedRegion" class="form-control">
                            <option value="">All Regions</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">District</label>
                        <select wire:model="selectedDistrict" class="form-control">
                            <option value="">All Districts</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date Range</label>
                        <select wire:model="dateRange" class="form-control">
                            <option value="all">All Time</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>

                    @if ($dateRange === 'custom')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" wire:model="customStartDate" class="form-control">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" wire:model="customEndDate" class="form-control">
                        </div>
                    @endif
                </div>
                <div class="btn-group mb-3">

                    <button type="button" wire:click="refresh()" class="btn btn-default"><i class="fa fa-refresh"></i>
                        <span class="hidden-md">Load</span></button>
                    <button type="button" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> <span
                            class="hidden-md">Export</span></button>
                </div>
            </div>
        </div>
    </div>



    <!-- Summary Statistics Cards -->
    <div class="row">
        <!-- Total Visits -->
        <div class="col col-md-3">
            <div class="card">
                <div class="stat-value text-info"><h2>{{ number_format($totalVisits) }}</h2></div>
                <div class="stat-label">Total Visits</div>
                <div class="absolute top-2 right-2">
                    <i class="fa fa-play text-info text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Visits -->
        <div class="col col-md-3">
            <div class="card">
                <div class="stat-value text-warning"><h2>{{ number_format($pendingVisits) }}</h2></div>
                <div class="stat-label">Pending Visits</div>
                <div class="absolute top-2 right-2">
                    <i class="fa fa-pause text-warning text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Completed Visits -->
        <div class="col col-md-3">
            <div class="card">
                <div class="stat-value text-success"><h2>{{ number_format($completedVisits) }}<h2></div>
                <div class="stat-label">Completed Visits</div>
                <div class="absolute top-2 right-2">
                    <i class="fa fa-check text-success text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Facility Coverage -->
        <div class="col col-md-3">
            <div class="card">
                <div class="stat-value text-purple-600">
                    {{ $facilityStats['total'] ? number_format(($facilityStats['visited'] / $facilityStats['total']) * 100, 1) : 0 }}%
                </div>
                <div class="stat-label">Facility Coverage</div>
                <div class="absolute top-2 right-2">
                    <i class="fa fa-building text-purple text-3xl"></i>
                </div>
            </div>
        </div>
        <!-- Stock Availability -->
        {{-- <div class="col col-md-3">
            <div class="card">
                <div class="stat-value text-teal-600">{{ number_format($stockStats, 1) }}%</div>
                <div class="stat-label">Stock Availability</div>
                <div class="absolute top-2 right-2">
                    <i class="fas fa-boxes text-teal-200 text-3xl"></i>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Charts Section -->
    <div class="row" wire:ignore>
        <!-- Visit Trends Chart -->
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="header">
                    <h4>Spider Graph</h4>
                </div>
                <div class="body">
                    <div class="card-body">
                        <!-- <div class="chart-container" id="visitTrendsChart"></div> -->
                         <div>
    <canvas id="spiderChart" width="400" height="400"></canvas>
</div>


                    </div>
                </div>
            </div>
        </div>

        <!-- League Table -->
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="header">
                    <h4>League Table</h4>
                </div>
                <div class="body">
                    <div class="card-body">
                        <div class="chart-container" id="leagueTable" style="overflow-x: auto;">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Region</th>
                                        <th>District</th>
                                        <th>Total Visits</th>
                                        <th>Pending Visits</th>
                                        <th>Completed Visits</th>
                                        <th>Ranking</th>
                                        <th>Stock Mgt</th>
                                        <th>Stoarage</th>
                                        <th>Equipment</th>
                                        <th>Ordering</th>
                                        <th>LIS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($regionWiseStats as $key => $region)
                                        <tr>
                                             <td>{{ $key + 1 }}</td>
                                            <td>{{ $region->name }}</td>
                                            <td>Kiboga</td>
                                            <td>{{ number_format($region->visits) }}</td>
                                            <td>{{ number_format($region->visits) }}</td>
                                            <td>{{ number_format($region->visits) }}</td>
                                            <td>{{ number_format($region->visits) }}</td>
                                            <td>{{ number_format($region->visits) }}</td>
                                            <td>{{ number_format($region->pending) }}</td>
                                            <td>{{ number_format($region->pending) }}</td>
                                            <td>{{ number_format($region->pending) }}</td>
                                            <td>{{ number_format($region->completed) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Regional Distribution Chart -->
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="header">
                    <h4>Regional Distribution</h4>
                </div>
                <div class="body">
                    <div class="card-body">
                        <div class="chart-container" id="regionalDistributionChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Status Chart -->
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="header">
                    <h4>Equipment Status Distribution</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container" id="equipmentStatusChart"></div>
                </div>
            </div>
        </div>

        <!-- Visit Status Distribution -->
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="header">
                    <h4>Visit Status Distribution</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container" id="visitStatusChart"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Visit Trends Chart
            var visitTrendsOptions = {
                series: [{
                    name: 'Visits',
                    data: @json($visitTrends->pluck('count'))
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: @json($visitTrends->pluck('month'))
                },
                colors: ['#6366F1']
            };
            new ApexCharts(document.querySelector("#visitTrendsChart"), visitTrendsOptions).render();

            // Regional Distribution Chart
            var regionalDistributionOptions = {
                series: @json($regionWiseStats->pluck('visits')),
                chart: {
                    type: 'pie',
                    height: 300
                },
                labels: @json($regionWiseStats->pluck('name')),
                colors: ['#6366F1', '#F59E0B', '#10B981', '#EF4444']
            };
            new ApexCharts(document.querySelector("#regionalDistributionChart"), regionalDistributionOptions).render();

            // Equipment Status Chart
            var equipmentStatusOptions = {
                series: @json($equipmentStats->pluck('count')),
                chart: {
                    type: 'donut',
                    height: 300
                },
                labels: @json($equipmentStats->pluck('status')),
                colors: ['#10B981', '#F59E0B', '#EF4444']
            };
            new ApexCharts(document.querySelector("#equipmentStatusChart"), equipmentStatusOptions).render();

            // Visit Status Distribution Chart
            var visitStatusOptions = {
                series: [{
                    name: 'Visits',
                    data: @json($visitsByStatus->pluck('count'))
                }],
                chart: {
                    type: 'bar',
                    height: 300
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: @json($visitsByStatus->pluck('status'))
                },
                colors: ['#6366F1']
            };
            new ApexCharts(document.querySelector("#visitStatusChart"), visitStatusOptions).render();

               document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('spiderChart').getContext('2d');

        const datasets = @json($scoreSets).map(set => ({
            label: set.label,
            data: set.data,
            backgroundColor: set.color.replace('1)', '0.2)'),  // semi-transparent fill
            borderColor: set.color,
            pointBackgroundColor: set.color,
            borderWidth: 2
        }));

        const chart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: @json($categories),
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        suggestedMin: 0,
                        suggestedMax: 5,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    });
        </script>
    @endpush
</div>

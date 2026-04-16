{{-- The whole world belongs to you. --}}
@section('title', 'Home')
<div>
    <style>
        .district-map-shell {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
            border-radius: 8px;
            background: #f8f9fb;
        }

        .district-map-shell .leaflet-container {
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
        }

        #districtMap {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
    </style>

    <div class="row clearfix">
        <div class="col-12">
            <div class="section_title">
                <div class="mr-3">
                    <h3>Overview</h3>
                    <small>LSS Visit Analytics & Visualization. Use these filters to filter and alter visualizations</small>
                </div>

                @if($quarterNotice)
                    <div class="alert alert-info border-1 alert-dismissible fade show" role="alert">
                        {{ $quarterNotice }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                        <label class="block text-sm font-medium text-gray-700">Period</label>
                        <select wire:model="dateRange" class="form-control">
                            <option value="all">All Data</option>
                            <option value="quarter">Quarter</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>

                    @if ($dateRange === 'quarter')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Year</label>
                            <select wire:model="filterYear" class="form-control">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quarter</label>
                            <select wire:model="filterQuarter" class="form-control">
                                <option value="q1">Qtr 1</option>
                                <option value="q2">Qtr 2</option>
                                <option value="q3">Qtr 3</option>
                                <option value="q4">Qtr 4</option>
                            </select>
                        </div>
                    @endif

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

    <div class="row mb-3">
        <div class="col-12">
            <div class="btn-group" role="group">
                <a href="{{ request()->fullUrlWithQuery(['dashboardTab' => 'overview', 'incomplete_entries_page' => null]) }}"
                    class="btn {{ $dashboardTab === 'overview' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Overview
                </a>
                <a href="{{ request()->fullUrlWithQuery(['dashboardTab' => 'entry_stats', 'page' => null]) }}"
                    class="btn {{ $dashboardTab === 'entry_stats' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Entry Follow-up
                </a>
            </div>
        </div>
    </div>

    @if ($dashboardTab === 'overview')
    <!-- Summary Statistics Cards -->
    <div class="row">
        <!-- Total Visits -->
        <div class="col col-md-3">
            <div class="card">
                <div class="stat-value text-info"><h2>{{ number_format($totalVisits) }}</h2></div>
                <div class="stat-label">Total LSS Entries</div>
                <div class="absolute top-2 right-2">
                    <i class="fa fa-play text-info text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Visits -->
        <div class="col col-md-3">
            <div class="card">
                <div class="stat-value text-warning"><h2>{{ number_format($pendingVisits) }}</h2></div>
                <div class="stat-label">Incomplete LSS Entries</div>
                <div class="absolute top-2 right-2">
                    <i class="fa fa-pause text-warning text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Completed Visits -->
        <div class="col col-md-3">
            <div class="card">
                <div class="stat-value text-success"><h2>{{ number_format($completedVisits) }}</h2></div>
                <div class="stat-label">Completed LSS Entries</div>
                <div class="absolute top-2 right-2">
                    <i class="fa fa-check text-success text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Facility Coverage -->
        <div class="col col-md-3">
            <div class="card">
                <div class="stat-value text-warning"><h2>
                    {{ $facilityStats['total'] ? number_format(($facilityStats['visited'] / $facilityStats['total']) * 100, 1) : 0 }}%</h2>
                </div>
                <div class="stat-label">LSS Facility Coverage ( {{ number_format(($facilityStats['visited'])) }} of {{  $facilityStats['total'] }} Health Facilities)
                </div>
                <div class="absolute top-2 right-2">
                    <i class="fa fa-spinner text-warning text-3xl"></i>
                </div>
            </div>
        </div>
        <!-- Stock Availability -->

    </div>

    <!-- Charts Section -->
    <div class="row" wire:ignore>
        <!-- Visit Trends Chart -->
        <div class="col-lg-6 col-md-6">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Spider Graph </legend>

                <select id="facilityFilter" multiple class="form-control" style="margin-bottom: 1rem; width: 100%;"></select>
                <button id="deselectAllBtn" class="btn btn-sm btn-danger mt-2">Deselect All</button>
                <canvas id="spiderChart" width="850" height="850"></canvas>
            </fieldset>
        </div>
                

  
        
        <!-- Regional Distribution Chart -->
        <div class="col-lg-6 col-md-6">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">LSS District Distribution & Scores</legend>
                <div class="district-map-shell">
                    <div id="districtMap"></div>
                </div>
            </fieldset>
         <div class="card">
                <div class="header">
                    <h4>LSS Regional Distribution</h4>
                </div>
                <div class="body">
                    <div class="card-body">
                        <div class="chart-container" id="regionalDistributionChart"></div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="header">
                    <h4>District Baseline vs Current League Trend (Last 6 Months)</h4>
                </div>
                <div class="body">
                    <div class="card-body">
                        <div class="chart-container" id="trendChart"></div>
                    </div>
                </div>
            </div> 

         <!-- <div class="col-lg-12 col-md-12">
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
                                        <th>Health Sub-District</th>
                                        <th>Health Facility</th>
                                        <th>Total Visits</th>
                                        <th>Pending</th>
                                        <th>Completed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($regionWiseStats as $key => $region)
                                        <tr>
                                             <td>{{ $key + 1 }}</td>
                                            <td>{{ $region->regionName }}</td>
                                            <td>{{ $region->districtName }}</td>
                                            <td>{{ $region->subDistrictName }}</td>
                                            <td>{{ $region->name }} {{ $region->level}}</td>
                                            <td>{{ number_format($region->visits) }}</td>
                                            <td>{{ number_format($region->pending) }}</td>
                                            <td>{{ number_format($region->completed) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>  
    </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="stat-value text-info"><h2>{{ number_format($incompleteEntrySummary['users'] ?? 0) }}</h2></div>
                <div class="stat-label">Users With Incomplete Entries</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="stat-value text-warning"><h2>{{ number_format($incompleteEntrySummary['incomplete_entries'] ?? 0) }}</h2></div>
                <div class="stat-label">Incomplete Entries</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="stat-value text-success"><h2>{{ number_format($incompleteEntrySummary['completed_entries'] ?? 0) }}</h2></div>
                <div class="stat-label">Completed Entries By Affected Users</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="stat-value text-primary"><h2>{{ number_format($incompleteEntrySummary['total_entries'] ?? 0) }}</h2></div>
                <div class="stat-label">Total Entries By Affected Users</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="header">
                    <h4>Follow-up Snapshot</h4>
                </div>
                <div class="body">
                    <div class="card-body">
                        <p class="text-muted small">
                            Weekly reminders are sent every Monday at 08:00 to users who still have pending LSS entries.
                        </p>
                        <div id="incompleteEntryChart" style="min-height: 360px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="header">
                    <h4>Users With Incomplete Entries</h4>
                </div>
                <div class="body">
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-sm table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th>Complete</th>
                                    <th>Incomplete</th>
                                    <th>Facility Visited</th>
                                    <th>Visit Number</th>
                                    <th>Date Of Visit</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($incompleteEntryRows as $row)
                                    <tr>
                                        <td>{{ $row->user_name }}</td>
                                        <td>{{ $row->total_entries }}</td>
                                        <td>{{ $row->completed_entries }}</td>
                                        <td>{{ $row->incomplete_entries }}</td>
                                        <td>{{ $row->facility_name }}</td>
                                        <td>{{ $row->visit_number }}</td>
                                        <td>{{ $row->date_of_visit }}</td>
                                        <td>{{ $row->status }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No incomplete entries found for the current filters.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @if ($incompleteEntryRows->hasPages())
                            {{ $incompleteEntryRows->withQueryString()->links('pagination::bootstrap-4') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

    @push('scripts')
        <script>
            @if ($dashboardTab === 'entry_stats')
            const incompleteEntryChartElement = document.querySelector("#incompleteEntryChart");
            if (incompleteEntryChartElement) {
                const incompleteEntryChartOptions = {
                    series: [{
                        name: 'Complete',
                        data: @json($incompleteEntryChart['complete'] ?? [])
                    }, {
                        name: 'Incomplete',
                        data: @json($incompleteEntryChart['incomplete'] ?? [])
                    }],
                    chart: {
                        type: 'bar',
                        stacked: true,
                        height: 360,
                        toolbar: { show: false }
                    },
                    plotOptions: {
                        bar: { horizontal: true, borderRadius: 4 }
                    },
                    xaxis: {
                        categories: @json($incompleteEntryChart['labels'] ?? [])
                    },
                    colors: ['#22c55e', '#f59e0b'],
                    legend: { position: 'top' },
                    noData: { text: 'No incomplete entry data available.' }
                };

                new ApexCharts(incompleteEntryChartElement, incompleteEntryChartOptions).render();
            }
            @endif

            @if ($dashboardTab === 'overview')
            function renderRegionalDistributionChart(regionWiseStats) {
                const regionalDistributionChartElement = document.querySelector("#regionalDistributionChart");
                if (!regionalDistributionChartElement) {
                    return;
                }

                const themeColors = [
                    '#E15858',
                    '#63a9c7',
                    '#ff7321',
                    '#59C4BC',
                ];

                if (window.regionalDistributionChartInstance) {
                    window.regionalDistributionChartInstance.destroy();
                }

                const stats = Array.isArray(regionWiseStats) ? regionWiseStats : [];
                const regionalDistributionOptions = {
                    series: stats.map((item) => item.visits),
                    chart: {
                        type: 'pie',
                        height: 400
                    },
                    labels: stats.map((item) => item.regionName),
                    colors: stats.map((_, index) => themeColors[index % themeColors.length]),
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '17px',
                            fontWeight: 700,
                            colors: ['#2f3542']
                        },
                        dropShadow: {
                            enabled: false
                        }
                    },
                    legend: {
                        fontSize: '15px',
                        labels: {
                            colors: '#4b5563'
                        }
                    },
                    stroke: {
                        colors: ['#f8fafc'],
                        width: 2
                    },
                    tooltip: {
                        style: {
                            fontSize: '14px'
                        }
                    },
                    noData: { text: 'No regional data available.' }
                };

                window.regionalDistributionChartInstance = new ApexCharts(regionalDistributionChartElement, regionalDistributionOptions);
                window.regionalDistributionChartInstance.render();
            }

            async function plotSpiderChart() {
                const dropdown = document.getElementById('facilityFilter');
                const deselectBtn = document.getElementById('deselectAllBtn');
                const spiderChartCanvas = document.getElementById('spiderChart');

                if (!dropdown || !deselectBtn || !spiderChartCanvas) {
                    return;
                }

                const response = await fetch('/spider-graph-data');
                const spiderData = await response.json();

                const labels = [
                    "Stock Management",
                    "Storage",
                    "Ordering",
                    "Equipment Management",
                    "Lab Information System"
                ];

                const getRGBA = (index, alpha = 0.5) => {
                    const colors = [
                        [255, 99, 132],
                        [54, 162, 235],
                        [255, 206, 86],
                        [75, 192, 192],
                        [153, 102, 255],
                        [255, 159, 64],
                        [100, 200, 100],
                        [240, 80, 128],
                        [0, 200, 255],
                        [180, 80, 200]
                    ];
                    const [r, g, b] = colors[index % colors.length];
                    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
                };

                spiderData.forEach((visit, i) => {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = visit.label;
                    dropdown.appendChild(option);
                });

                const choices = new Choices(dropdown, {
                    removeItemButton: true,
                    searchEnabled: true,
                    placeholder: true,
                    placeholderValue: 'Select facilities to plot the ...',
                    shouldSort: false
                });

                const spiderChart = new Chart(spiderChartCanvas.getContext('2d'), {
                    type: 'radar',
                    data: {
                        labels: labels,
                        datasets: []
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Thematic Area Scores per Facility LSS Visit'
                            },
                            legend: {
                                position: 'top'
                            }
                        },
                        elements: {
                            line: {
                                borderWidth: 2
                            }
                        },
                        scales: {
                            r: {
                                min: 0,
                                max: 5,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });

                const updateChart = () => {
                    const selected = Array.from(dropdown.selectedOptions).map((opt) => parseInt(opt.value, 10));
                    const filteredDatasets = selected.map((index) => ({
                        label: spiderData[index].label,
                        data: Object.values(spiderData[index].data),
                        fill: true,
                        backgroundColor: getRGBA(index, 0.2),
                        borderColor: getRGBA(index, 1),
                        pointBackgroundColor: getRGBA(index, 1),
                        pointBorderColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: getRGBA(index, 1),
                    }));

                    spiderChart.data.datasets = filteredDatasets;
                    spiderChart.update();
                };

                updateChart();
                dropdown.addEventListener('change', updateChart);
                deselectBtn.addEventListener('click', () => {
                    choices.removeActiveItems();
                    updateChart();
                });
            }

            plotSpiderChart();

            function renderTrendChart(trendData) {
                const trendChartElement = document.querySelector("#trendChart");
                if (!trendChartElement) {
                    return;
                }

                if (window.trendChartInstance) {
                    window.trendChartInstance.destroy();
                }

                const labels = trendData.map((item) => item.district);
                const baselineScores = trendData.map((item) => item.baseline_score);
                const currentScores = trendData.map((item) => item.current_score);

                const options = {
                    chart: {
                        height: 360,
                        type: 'line',
                        toolbar: { show: true },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 700,
                        }
                    },
                    stroke: {
                        width: 3,
                        curve: 'smooth'
                    },
                    series: [
                        {
                            name: 'Baseline Score',
                            data: baselineScores
                        },
                        {
                            name: 'Current Score',
                            data: currentScores
                        }
                    ],
                    xaxis: {
                        categories: labels,
                        title: { text: 'District' },
                        labels: { rotate: -45 }
                    },
                    yaxis: {
                        title: { text: 'Score' },
                        decimalsInFloat: 1
                    },
                    colors: ['#FF9F40', '#4BC0C0'],
                    markers: {
                        size: 5,
                        hover: { size: 7 }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: function (value) {
                                return value.toFixed(1);
                            }
                        },
                    },
                    legend: {
                        position: 'top'
                    },
                    noData: {
                        text: 'No trend data available.'
                    }
                };

                window.trendChartInstance = new ApexCharts(trendChartElement, options);
                window.trendChartInstance.render();
            }

            function renderDistrictMap(performance) {
                const districtMapElement = document.getElementById('districtMap');
                if (!districtMapElement) {
                    return;
                }

                if (!window.dashboardDistrictMap) {
                    window.dashboardDistrictMap = L.map('districtMap', {
                        scrollWheelZoom: false,
                    }).setView([1.3733, 32.2903], 7);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 18,
                    }).addTo(window.dashboardDistrictMap);
                }

                fetch('/maps/uganda_districts.geojson')
                    .then((response) => response.json())
                    .then((data) => {
                        if (window.dashboardDistrictLayer) {
                            window.dashboardDistrictMap.removeLayer(window.dashboardDistrictLayer);
                        }

                        function getColor(score) {
                            return score > 80 ? '#006837'
                                : score > 50 ? '#eba40cff'
                                : score > 0 ? '#ef2c00ff'
                                : '#f2f2f2';
                        }

                        window.dashboardDistrictLayer = L.geoJSON(data, {
                            style: function (feature) {
                                const district = feature.properties.shapeName;
                                const score = performance[district] ?? 0;

                                return {
                                    fillColor: getColor(score),
                                    fillOpacity: 0.8,
                                    weight: 1,
                                    color: '#555'
                                };
                            },
                            onEachFeature: function (feature, layer) {
                                const district = feature.properties.shapeName;
                                const score = performance[district] ?? 0;

                                layer.bindPopup(
                                    "<strong>" + district + "</strong><br>" +
                                    "Current LSS Score: " + score + "%"
                                );
                            }
                        }).addTo(window.dashboardDistrictMap);
                    });
            }

            document.addEventListener('livewire:load', function () {
                renderRegionalDistributionChart(@json($regionWiseStats->map(fn ($row) => ['regionName' => $row->regionName, 'visits' => (int) $row->visits])->values()->all()));
                renderTrendChart(@json($trend_data));
                renderDistrictMap(@json($district_performance));

                window.addEventListener('dashboard-data-updated', function (event) {
                    const detail = event.detail || {};

                    renderRegionalDistributionChart(detail.regionWiseStats || []);
                    renderTrendChart(detail.trendData || []);
                    renderDistrictMap(detail.districtPerformance || {});
                });
            });
            @endif
</script>
@endpush
</div>

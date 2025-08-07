{{-- The whole world belongs to you. --}}
@section('title', 'Home')
<div>
    <div class="row clearfix">
        <div class="col-12">
            <div class="section_title">
                <div class="mr-3">
                    <h3>Overview</h3>
                    <small>LSS Visit Analytics & Visualization. Use these filters to filter and alter visualizations</small>
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
                <div class="stat-label">LSS Facility Coverage</div>
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
            <div class="card">
                <div class="header"> <h4>Spider Graph</h4> </div>
                <div class="body">
                    <div class="card-body"> <div>
                        <select id="facilityFilter" multiple class="form-control" style="margin-bottom: 1rem; width: 100%;"></select>
                        <button id="deselectAllBtn" class="btn btn-sm btn-danger mt-2">Deselect All</button>

                        <canvas id="spiderChart" width="600" height="600"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
        
        <!-- Regional Distribution Chart -->
        <div class="col-lg-6 col-md-6">

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
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

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
                    height: 450,
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
                    height: 400
                },
                labels: @json($regionWiseStats->pluck('regionName')),
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
                colors: [
                        "#6A89CC", // Light Blue
                        "#38ADA9", // Teal
                        "#E55039", // Red Orange
                        "#F8C291", // Peach
                        "#60A3BC"  // Muted Blue
                        ]
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

async function plotSpiderChart() {
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

  // Populate dropdown
  const dropdown = document.getElementById('facilityFilter');
  const deselectBtn = document.getElementById('deselectAllBtn');

  spiderData.forEach((visit, i) => {
    const option = document.createElement('option');
    option.value = i;
    option.textContent = visit.label;
    dropdown.appendChild(option);
  });

  // Initialize Choices.js
  const choices = new Choices(dropdown, {
    removeItemButton: true,
    searchEnabled: true,
    placeholder: true,
    placeholderValue: 'Select facilities to plot the Spider graph...',
    shouldSort: false
  });

  const ctx = document.getElementById('spiderChart').getContext('2d');

  let spiderChart = new Chart(ctx, {
    type: 'radar',
    data: {
      labels: labels,
      datasets: [] // Start empty
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

  // Update chart with selected datasets
  const updateChart = () => {
    const selected = Array.from(dropdown.selectedOptions).map(opt => parseInt(opt.value));
    const filteredDatasets = selected.map((i) => ({
      label: spiderData[i].label,
      data: Object.values(spiderData[i].data),
      fill: true,
      backgroundColor: getRGBA(i, 0.2),
      borderColor: getRGBA(i, 1),
      pointBackgroundColor: getRGBA(i, 1),
      pointBorderColor: "#fff",
      pointHoverBackgroundColor: "#fff",
      pointHoverBorderColor: getRGBA(i, 1),
    }));

    spiderChart.data.datasets = filteredDatasets;
    spiderChart.update();
  };

  // Initial empty chart
  updateChart();

  // Change on selection
  dropdown.addEventListener('change', updateChart);

  // Deselect All
  deselectBtn.addEventListener('click', () => {
    choices.removeActiveItems();
    updateChart();
  });
}

plotSpiderChart();

        </script>
    @endpush
</div>

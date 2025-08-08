<div>
    <div class="card">
        <div class="card-header">
            @include('livewire.facility.visits.inc.visit-header')
        </div>
        <!-- Persons Supervised -->
        <div class="body">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Home-new"><i
                            class="fa fa-home"></i> Full Report</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Profile-new"><i class="fa fa-home"></i>
                        Lab SPARS Dashboard </a>
                </li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#spiderGraph">
                        <i class="fa fa-bar-chart"></i>Spider Graph</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show vivify active" id="Home-new">
                    <h6>Home</h6>
                </div>
                <div class="tab-pane vivify" id="Profile-new">
                    <h6>Dashboard</h6>
                    @include('livewire.dashboard.facility-visits-dashboard-component')
                </div>
                <div class="tab-pane vivify" id="spiderGraph">
                    <h3 class="text-lg font-semibold mb-2">Spider Graph Summary</h3>
                    <div id="apexRadarChart"></div>
                </div>

            </div>
        </div>


        @push('scripts')
            <script>
                document.addEventListener('livewire:load', () => {
                    const options = {
                        chart: {
                            type: 'radar',
                            height: 650
                        },
                        title: {
                            text: 'Scaled SPARS Scores'
                        },
                        xaxis: {
                            categories: @json(array_keys($scaledScores))
                        },
                        series: [{
                            name: 'Scaled Score (x5)',
                            data: @json(array_values($scaledScores))
                        }],
                        yaxis: {
                            min: 0,
                            max: 5
                        }
                    };

                    const chart = new ApexCharts(document.querySelector("#apexRadarChart"), options);
                    chart.render();

                    Livewire.on('updateChart', (scaledScores) => {
                        chart.updateSeries([{
                            name: 'Scaled Score (x5)',
                            data: Object.values(scaledScores)
                        }]);
                    });
                });
            </script>
        @endpush
    </div>

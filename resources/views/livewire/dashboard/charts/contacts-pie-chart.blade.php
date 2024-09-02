<div>
    <div wire:ignore id="sampleStatus"></div>  
    

    @push('scripts')

    <script>
        var options = {
            series: @json($series),
            colors: ['#119A48', '#951F39', '#BBA66D','#681527','#958457','#33C481'],
            chart: {
                width: '100%',
                type: 'pie',
            },
            labels: @json($categories),

            plotOptions: {
                pie: {
                    dataLabels: {
                        offset: -5
                    },

                    fill: {
                        type: 'gradient',
                    },
                }
            },
            dataLabels: {
                formatter(val, opts) {
                    const name = opts.w.globals.labels[opts.seriesIndex]
                    return [name, val.toFixed(1) + '%']
                }
            },
            legend: {
                show: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#sampleStatus"), options);
        chart.render();
    </script>
        <script>
            var chart = new ApexCharts(document.querySelector("#caseChart"), {
                chart: {
                    type: 'bar',
                    height: 325,
                },
                fill: {
                    opacity: [0.85, 0.25, 1],
                    gradient: {
                        inverseColors: false,
                        shade: 'light',
                        type: "vertical",
                        opacityFrom: 0.85,
                        opacityTo: 0.55,
                        stops: [0, 100, 100, 100]
                    }
                },
                series: @json($series),
                colors: ['#119A48', '#BBA66D', '#951F39'],
                xaxis: {
                    categories: @json($categories),
                },
            });

            chart.render();

            Livewire.on('updateChart', function(data) {
                chart.updateSeries(data.series);
                chart.updateOptions({
                    xaxis: {
                        categories: data.categories
                    }
                });
            });
        </script>
    @endpush
</div>

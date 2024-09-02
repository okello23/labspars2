<div>
    <div wire:ignore id="perHubchart"></div>  
    

    @push('scripts')
        <script>
            var chart = new ApexCharts(document.querySelector("#perHubchart"), {
                chart: {
                    type: 'bar',
                    height: 415,
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

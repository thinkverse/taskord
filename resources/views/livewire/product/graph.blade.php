<div class="card" wire:init="loadGraph">
    @if (!$readyToLoad)
    <div class="card-body">
        <div class="spinner-border spinner-border-sm taskord-spinner text-secondary me-2" role="status"></div>
        Loading activity graph...
    </div>
    @else
    <div id="activityGraph"></div>
    @endif
    @if ($readyToLoad)
    <script>
    var options = {
        chart: {
            type: 'line',
            height: 100,
            animations: { enabled: false },
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        series: [{name: 'Tasks', data: <?php echo $tasks ?> }],
        xaxis: { categories: <?php echo $week_dates ?>, labels: { show: false } },
        yaxis: { labels: { show: false } }
    }

    var activityGraph = new ApexCharts(document.querySelector("#activityGraph"), options);
    activityGraph.render();
    </script>
    @endif
</div>

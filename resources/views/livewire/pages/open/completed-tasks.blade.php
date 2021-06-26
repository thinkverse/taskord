<div class="mt-4" wire:init="loadCompletedTasks">
    <h5>{{ $completed_tasks_count }} Completed Tasks</h5>
    <div class="card mt-3">
        <div class="card-body">
            @if (!$readyToLoad)
                <x:loaders.stat-skeleton />
            @endif
            <div id="completedTasks"></div>
        </div>
    </div>

    @if ($readyToLoad)
        <script>
            var options = {
                chart: {
                    type: 'bar',
                    height: 300,
                    animations: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: 'Tasks',
                    data: <?php echo $completed_tasks; ?>
                }],
                xaxis: {
                    categories: <?php echo $weekDates; ?>,
                    labels: {
                        show: false
                    }
                }
            }

            var completedTasks = new ApexCharts(document.querySelector("#completedTasks"), options);
            completedTasks.render();
        </script>
    @endif
</div>

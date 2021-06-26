<div class="mt-4" wire:init="loadComments">
    <h5>{{ $comments_count }} Comments</h5>
    <div class="card mt-3">
        <div class="card-body">
            @if (!$readyToLoad)
                <x:loaders.stat-skeleton />
            @endif
            <div id="comments"></div>
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
                    name: 'Comments',
                    data: <?php echo $comments; ?>
                }],
                xaxis: {
                    categories: <?php echo $weekDates; ?>,
                    labels: {
                        show: false
                    }
                }
            }

            var comments = new ApexCharts(document.querySelector("#comments"), options);
            comments.render();
        </script>
    @endif
</div>

<div class="mt-4" wire:init="loadAnswers">
    <h5>{{ $answers_count }} Answers</h5>
    <div class="card mt-3">
        <div class="card-body">
            @if (!$readyToLoad)
                <x:loaders.stat-skeleton />
            @endif
            <div id="answers"></div>
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
                    name: 'Answers',
                    data: <?php echo $answers; ?>
                }],
                xaxis: {
                    categories: <?php echo $week_dates; ?>,
                    labels: {
                        show: false
                    }
                }
            }

            var answers = new ApexCharts(document.querySelector("#answers"), options);
            answers.render();
        </script>
    @endif
</div>

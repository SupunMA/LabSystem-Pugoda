<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $totalPatients }}</h3>
                <h4>Total Patients</h4>
            </div>
            <div class="icon">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <a href="{{ route('admin.allPatient') }}" class="small-box-footer">
                View Patients <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$availableTests}}</h3>
                <h4>Available Tests</h4>
            </div>
            <div class="icon">
                <i class="fa fa-flask" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">
                Manage Tests <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$reportsGenerated}}</h3>
                <h4>Reports Generated</h4>
            </div>
            <div class="icon">
                <i class="fa fa-file-text" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">
                View Reports <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{$requestedTests}}</h3>
                <h4>Requested Tests</h4>
            </div>
            <div class="icon">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">
                Review Tests <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

<!-- Gender distribution pie chart -->
<!-- Gender Distribution Card -->
<div class="row">
    <!-- Gender Distribution Card -->
    <div class="col-lg-6 col-xs-12">
        <div class="small-box bg-white">
            <div class="inner">
                <h4>Patient Gender Distribution</h4>
                <div class="chart-container" style="position: relative; height: 500px; width: 100%; max-width: 500px; margin: 0 auto;">
                    <canvas id="genderChart" width="300" height="300"></canvas>
                </div>
            </div>
            <div class="icon">
                <i class="fa fa-pie-chart" aria-hidden="true"></i>
            </div>
            <div class="small-box-footer" style="background: rgba(66, 66, 66, 0.993); color: white; font-weight: 500;">
                Patient Demographics <i class="fa fa-info-circle"></i>
            </div>
        </div>
    </div>

    <!-- Most Requested Tests Card -->
    <div class="col-lg-6 col-xs-12">
        <div class="small-box bg-white">
            <div class="inner">
                <h4>Most Requested Tests</h4>
                <div class="chart-container" style="position: relative; height: 500px; width: 100%; max-width: 500px; margin: 0 auto;">
                    <canvas id="testsChart" width="300" height="300"></canvas>
                </div>
            </div>
            <div class="icon">
                <i class="fa fa-flask" aria-hidden="true"></i>
            </div>
            <div class="small-box-footer" style="background: rgba(66, 66, 66, 0.993); color: white; font-weight: 500;">
                Test Popularity <i class="fa fa-info-circle"></i>
            </div>
        </div>
    </div>
</div>

@push('specificCSS')


@endpush

@push('specificJs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gender distribution pie chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');

    const genderData = {
        labels: @json($genderData->pluck('gender')),
        datasets: [{
            data: @json($genderData->pluck('count')),
            backgroundColor: [
                'rgba(13, 110, 253, 1)',   // Blue for Male
                'rgba(255, 193, 7, 1)',    // Pink for Female
                'rgba(108, 117, 125, 1)'     // Green for Other
            ],
            borderColor: [
                'rgba(13, 110, 253, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(108, 117, 125, 1)'
            ],
            borderWidth: 3
        }]
    };

    new Chart(genderCtx, {
        type: 'pie',
        data: genderData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>

{{-- top test chart --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make sure we have test data to display
    if (document.getElementById('testsChart')) {
        // Get the canvas element
        const testsCtx = document.getElementById('testsChart').getContext('2d');

        // Generate random colors for the chart segments
        function generateColors(count) {
            const colors = [];
            const backgroundColors = [];

            for (let i = 0; i < count; i++) {
                // Generate pastel colors
                const hue = i * (360 / count);
                const color = `hsla(${hue}, 70%, 60%, 0.8)`;
                const borderColor = `hsla(${hue}, 70%, 50%, 1)`;

                backgroundColors.push(color);
                colors.push(borderColor);
            }

            return { backgroundColor: backgroundColors, borderColor: colors };
        }

        // Prepare the data
        const testLabels = @json($mostRequestedTests->pluck('name'));
        const testCounts = @json($mostRequestedTests->pluck('count'));
        const colorSet = generateColors(testLabels.length);

        // Create the chart data
        const testData = {
            labels: testLabels,
            datasets: [{
                data: testCounts,
                backgroundColor: colorSet.backgroundColor,
                borderColor: colorSet.borderColor,
                borderWidth: 1
            }]
        };

        // Create the donut chart
        new Chart(testsCtx, {
            type: 'doughnut',
            data: testData,
            options: {
                responsive: true,
                cutout: '60%', // Controls the size of the hole
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 10
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} tests (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush

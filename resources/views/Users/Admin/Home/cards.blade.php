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
            <a href="{{ route('admin.allAvailableTest') }}" class="small-box-footer">
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
            <a href="{{ route('admin.addReport') }}" class="small-box-footer">
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
            <a href="{{ route('admin.addTest') }}" class="small-box-footer">
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
                <i class="fa fa-users" aria-hidden="true"></i>
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

<!-- Income Chart Card -->
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <a href="#" data-toggle="collapse" data-target="#incomeCardBody" style="color: inherit; text-decoration: none; cursor: pointer;">
                    <h3 class="card-title mb-0">Monthly Income</h3>
                </a>
                {{-- <div class="card-tools">
                    <button type="button" class="btn btn-tool" id="lock-button">
                        <i class="fas fa-lock"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#incomeCardBody">
                        <i class="fas fa-minus"></i>
                    </button>
                </div> --}}
            </div>
            <div class="card-body" id="incomeCardBody">
                <div id="income-card-placeholder" class="text-center">
                    <p>Enter PIN to view income details.</p>
                    <button class="btn btn-primary" id="unlock-button">Unlock</button>
                </div>
                <div id="income-chart-container" style="display: none;">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date range:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="income-date-range">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button id="apply-filter" class="btn btn-primary mt-4">Apply</button>
                        </div>
                    </div>
                    <div class="chart-container" style="height: 450px; position: relative;">
                        <canvas id="incomeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PIN Modal -->
<div class="modal fade" id="pinModal" tabindex="-1" role="dialog" aria-labelledby="pinModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pinModalLabel">Enter PIN to View Income</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="pin-input">PIN</label>
                    <input type="password" class="form-control" id="pin-input" placeholder="Enter PIN">
                    <div class="invalid-feedback">
                        Invalid PIN.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-pin">Submit</button>
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
    // Gender distribution donut chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');

    const genderData = {
        labels: @json($genderData->pluck('gender')),
        datasets: [{
            data: @json($genderData->pluck('count')),
            backgroundColor: [
                'rgba(13, 110, 253, 0.8)',   // Blue for Male
                'rgba(255, 193, 7, 0.8)',    // Yellow for Female
                'rgba(108, 117, 125, 0.8)'   // Gray for Other
            ],
            borderColor: [
                'rgba(13, 110, 253, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(108, 117, 125, 1)'
            ],
            borderWidth: 3,
            hoverBackgroundColor: [
                'rgba(13, 110, 253, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(108, 117, 125, 1)'
            ]
        }]
    };

    new Chart(genderCtx, {
        type: 'doughnut',  // Changed from 'pie'
        data: genderData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',  // Creates the donut hole
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
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

{{-- income chart --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize date range picker
    $('#income-date-range').daterangepicker({
        opens: 'right',
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear'
        },
        ranges: {
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')]
        }
    });

    $('#income-date-range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        loadIncomeChart(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
    });

    $('#income-date-range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        // Load default (last 6 months)
        const startDate = moment().subtract(6, 'months').startOf('month').format('YYYY-MM-DD');
        const endDate = moment().endOf('month').format('YYYY-MM-DD');
        loadIncomeChart(startDate, endDate);
    });

    // Apply filter button
    $('#apply-filter').click(function() {
        if ($('#income-date-range').val()) {
            const dates = $('#income-date-range').val().split(' - ');
            loadIncomeChart(dates[0], dates[1]);
        } else {
            // Load default (last 6 months)
            const startDate = moment().subtract(6, 'months').startOf('month').format('YYYY-MM-DD');
            const endDate = moment().endOf('month').format('YYYY-MM-DD');
            loadIncomeChart(startDate, endDate);
        }
    });

    // Initialize the chart with last 6 months data
    const initialStartDate = moment().subtract(6, 'months').startOf('month').format('YYYY-MM-DD');
    const initialEndDate = moment().endOf('month').format('YYYY-MM-DD');
    $('#income-date-range').val(initialStartDate + ' - ' + initialEndDate);
    loadIncomeChart(initialStartDate, initialEndDate);

    function loadIncomeChart(startDate, endDate) {
        $.ajax({
            url: '{{ route("admin.getIncomeData") }}',
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                updateIncomeChart(response);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    function updateIncomeChart(data) {
        const ctx = document.getElementById('incomeChart').getContext('2d');

        // Destroy previous chart if it exists
        if (window.incomeChart instanceof Chart) {
            window.incomeChart.destroy();
        }

        const labels = data.map(item => `${item.month_name} ${item.year}`);
        const incomeData = data.map(item => item.total);

        window.incomeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Income',
                    data: incomeData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (Rs / රුපියල්)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'රු' + context.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // Initial chart with default data
    const initialData = @json($incomeData);
    updateIncomeChart(initialData);
});
</script>
<script>
$(document).ready(function() {
    $('.card-header').on('click', function() {
        const icon = $(this).find('.btn-tool i');
        const isCollapsed = $(this).next('.card-body').hasClass('show');

        if (isCollapsed) {
            icon.removeClass('fa-minus').addClass('fa-plus');
        } else {
            icon.removeClass('fa-plus').addClass('fa-minus');
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $('#lock-button, #unlock-button').on('click', function() {
        $('#pinModal').modal('show');
    });

    $('#submit-pin').on('click', function() {
        var pin = $('#pin-input').val();
        $.ajax({
            url: '{{ route("admin.verifyPin") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                pin: pin
            },
            success: function(response) {
                if (response.success) {
                    $('#pinModal').modal('hide');
                    $('#income-card-placeholder').hide();
                    $('#income-chart-container').show();
                    $('#lock-button').find('i').removeClass('fa-lock').addClass('fa-unlock');
                    $('#lock-button, #unlock-button').off('click');
                } else {
                    $('#pin-input').addClass('is-invalid');
                }
            },
            error: function() {
                alert('An error occurred.');
            }
        });
    });
});
</script>
@endpush

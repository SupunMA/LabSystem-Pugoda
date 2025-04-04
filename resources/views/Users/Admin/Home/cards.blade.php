
 <!-- Small boxes (Stat box) -->
 <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
            <h3>{{$ClientsCount}}</h3>
            <h4>Patients</h4>
        </div>
        <div class="icon">
          <i class="fa fa-users" aria-hidden="true"></i>
        </div>
        <a href="{{route('admin.allPatient')}}" class="small-box-footer">
          View Patients <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>Rs {{$total}}<sup style="font-size: 20px">.00</sup></h3>

          <h4>Total Income</h4>
        </div>
        <div class="icon">
          <i class="fa fa-money" aria-hidden="true"></i>
        </div>
        <a href="#" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{$TestCount}}</h3>

          <h4>Requested Tests</h4>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{route('admin.allTest')}}" class="small-box-footer">
          View Requested Tests <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{$DoctorCount}}</h3>

          <h4>Doctors</h4>
        </div>
        <div class="icon">
          <i class="fa fa-user-md" aria-hidden="true"></i>
        </div>
        <a href="{{route('admin.allDoctor')}}" class="small-box-footer">
          View Doctors <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->





{{-- Charts --}}


    <div class="row">
      <div class="col-md-6">


        <!-- DONUT CHART -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Gender of Patients</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> --}}
            </div>
          </div>
          <div class="box-body">
            <canvas id="pieChart" ></canvas>

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
      <!-- /.col (LEFT) -->
      <div class="col-md-6">


        <!-- BAR CHART -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">The Requested and Tested Tests</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> --}}
            </div>
          </div>
          <div class="box-body">
            <div class="chart">
              <canvas id="barChart" ></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
      <!-- /.col (RIGHT) -->
    </div>
    <!-- /.row -->


    <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of Reports</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Patient Name</th>
                        <th>Test Name</th>
                        <th>Result</th>



                    </tr>
                </thead>
                <tbody>

                    @foreach ($allReportData->unique('rid') as $data)
                            <tr>
                                <td>{{$data->rid}} </td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->AvailableTestName}}</td>
                                <td>
                                    @php
                                        $resultArray = explode(',', $data->result);
                                    @endphp
                                    @foreach ($allReportData->unique('sub_id') as $data2)
                                        {{$data2->SubCategoryName}} :-
                                        @foreach($resultArray as $result)
                                            {{$result}} ({{$data2->Units}}) -
                                            @if ($result < $data2->SubCategoryRangeMin || $result > $data2->SubCategoryRangeMax)
                                            <b>Abnormal</b>
                                            @else
                                            <b>Normal</b>
                                            @endif
                                            <br>
                                            @php
                                                array_shift($resultArray);
                                            @endphp
                                            @break
                                        @endforeach
                                    @endforeach

                                </td>





                            </tr>


                        @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>Report ID</th>
                        <th>Patient Name</th>
                        <th>Test Name</th>
                        <th>Result</th>

                     
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
      <!-- /.box -->

  @push('specificJs')
          <script>
            $(function () {
              /* ChartJS
               * -------
               * Here we will create a few charts using ChartJS
               */

              var barChartList = @json($testList);
              var notDoneTestsArray = @json($notDoneTestsArray);
              var DoneTestsArray = @json($DoneTestsArray);


              var areaChartData = {
                  labels: barChartList,
                  datasets: [
                      {
                          label: 'The Requested Test',
                          fillColor: 'rgba(210, 214, 222, 1)',
                          strokeColor: 'rgba(210, 214, 222, 1)',
                          pointColor: 'rgba(210, 214, 222, 1)',
                          pointStrokeColor: '#c1c7d1',
                          pointHighlightFill: '#fff',
                          pointHighlightStroke: 'rgba(220, 220, 220, 1)',
                          data: notDoneTestsArray
                      },
                      {
                          label: 'The Tested Test',
                          fillColor: 'rgba(60, 141, 188, 0.9)',
                          strokeColor: 'rgba(60, 141, 188, 0.8)',
                          pointColor: '#3b8bba',
                          pointStrokeColor: 'rgba(60, 141, 188, 1)',
                          pointHighlightFill: '#fff',
                          pointHighlightStroke: 'rgba(60, 141, 188, 1)',
                          data: DoneTestsArray
                      }
                  ]
              };



              //-------------
              //- PIE CHART -
              //-------------
              // Get context with jQuery - using jQuery's .get() method.
              var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
              var pieChart       = new Chart(pieChartCanvas)
              var PieData        = [
                {
                  value    : {{$maleP}},
                  color    : '#f56954',
                  highlight: '#c2422f',
                  label    : 'Male'
                },
                {
                  value    : {{$femaleP}},
                  color    : '#00a65a',
                  highlight: '#188754',
                  label    : 'Famale'
                },
                {
                  value    : {{$otherP}},
                  color    : '#08aabf',
                  highlight: '#0f7c8a',
                  label    : 'Other'
                }

              ]
              var pieOptions     = {
                //Boolean - Whether we should show a stroke on each segment
                segmentShowStroke    : false,
                //String - The colour of each segment stroke
                segmentStrokeColor   : '#fff',
                //Number - The width of each segment stroke
                segmentStrokeWidth   : 2,
                //Number - The percentage of the chart that we cut out of the middle
                percentageInnerCutout: 50, // This is 0 for Pie charts
                //Number - Amount of animation steps
                animationSteps       : 140,
                //String - Animation easing effect
                animationEasing      : 'easeInBounce',
                //Boolean - Whether we animate the rotation of the Doughnut
                animateRotate        : true,
                //Boolean - Whether we animate scaling the Doughnut from the centre
                animateScale         : false,
                //Boolean - whether to make the chart responsive to window resizing
                responsive           : true,
                // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio  : true,
                //String - A legend template
                legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
              }
              //Create pie or douhnut chart
              // You can switch between pie and douhnut using the method below.
              pieChart.Doughnut(PieData, pieOptions)

              //-------------
              //- BAR CHART -
              //-------------
              var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
              var barChart                         = new Chart(barChartCanvas)
              var barChartData                     = areaChartData
              barChartData.datasets[1].fillColor   = '#00a65a'
              barChartData.datasets[1].strokeColor = '#00a65a'
              barChartData.datasets[1].pointColor  = '#00a65a'
              var barChartOptions                  = {
                //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                scaleBeginAtZero        : true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines      : true,
                //String - Colour of the grid lines
                scaleGridLineColor      : 'rgba(0,0,0,1)',
                //Number - Width of the grid lines
                scaleGridLineWidth      : 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines  : true,
                //Boolean - If there is a stroke on each bar
                barShowStroke           : true,
                //Number - Pixel width of the bar stroke
                barStrokeWidth          : 2,
                //Number - Spacing between each of the X value sets
                barValueSpacing         : 5,
                //Number - Spacing between data sets within X values
                barDatasetSpacing       : 1,
                //String - A legend template
                legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                //Boolean - whether to make the chart responsive
                responsive              : true,
                maintainAspectRatio     : true
              }

              barChartOptions.datasetFill = false
              barChart.Bar(barChartData, barChartOptions)
            })
          </script>


          <script>
            $(function () {
              $('#example1').DataTable()
              $('#example2').DataTable({
                'paging'      : true,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false
              })
            })
          </script>
  @endpush

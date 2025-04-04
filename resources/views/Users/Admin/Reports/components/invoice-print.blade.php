<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>MediHelp | {{$viewReportData[0]->AvailableTestName}} Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


   <!-- Style -->
   @include('layouts.adminComponents.lib.Style')
<style>
    body {
      position: relative;
      height: 100vh;
      margin: 0;
      padding: 0;
    }
    .lab-assistant {
      position: absolute;
      bottom: 0;
      right: 0;
    }
</style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body onload="delayedPrint();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-flask" aria-hidden="true"></i> MediHelp Lab.
          <small class="pull-right">Downloaded Date: {{ date('Y-m-d') }}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>MediHelp Lab.</strong><br>
          558,<br>
          Galle Road,<br>
          Kalutara.<br>
          Tel: 034-2030200
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong>{{$viewReportData[0]->name}}</strong><br>
          {{$viewReportData[0]->address}}<br>
          Mobile:{{$viewReportData[0]->mobile}}<br>
          Email:{{$viewReportData[0]->email}}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Report #{{$viewReportData[0]->rid}}</b><br>
        <br>
        <b>Report ID:</b> {{$viewReportData[0]->rid}}<br>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Test ID</th>
            <th>Test</th>
            <th><b>Result</b></th>
            <th>Normal Range</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>{{$viewReportData[0]->tid}}</td>
            <td>{{$viewReportData[0]->AvailableTestName}}</td>
            <td>
                @php
                $resultArray = explode(',', $viewReportData[0]->result);
                $normal = 0;
                $abnormal = 0;
                @endphp

                <ul>
                @for ($i = 0; $i < count($viewReportData); $i++)
                    {{-- Your HTML or Blade code here --}}
                    {{-- Access individual elements using $viewReportData[$i] --}}
                    <li>{{$viewReportData[$i]->SubCategoryName}} -

                        @foreach($resultArray as $result)
                                       <b>{{$result}}</b>  ({{$viewReportData[$i]->Units}}) -
                                        @if ($result < $viewReportData[$i]->SubCategoryRangeMin || $result > $viewReportData[$i]->SubCategoryRangeMax)
                                        <b>Abnormal</b>
                                            @php
                                                $abnormal++;
                                            @endphp
                                        @else
                                        <b>Normal</b>
                                            @php
                                                $normal++;
                                            @endphp
                                        @endif
                                        <br>
                                        @php
                                            array_shift($resultArray);
                                        @endphp
                                        @break
                                    @endforeach


                    </li>
                @endfor

                </ul>
            </td>
            <td>
                @for ($i = 0; $i < count($viewReportData); $i++)
                <li>{{$viewReportData[$i]->SubCategoryName}} : {{$viewReportData[$i]->SubCategoryRangeMin}} - {{$viewReportData[$i]->SubCategoryRangeMax}}
                @endfor


            </td>
            <td>{{ number_format(($normal / ($abnormal + $normal)) * 100, 2) }} %</td>

          </tr>

          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p class="lead">Summary:</p>

        <p class=" well well-sm no-shadow" style="margin-top: 10px;">
          @if ((($normal/($abnormal + $normal))*100) == 100 )
          It's great news! It means that the specific markers or values that were tested fall within the normal range,
          indicating that there are no immediate concerns based on those particular tests.
          However, it's important to remember that lab tests are just one part of a larger picture of your health.
          @elseif((($normal/($abnormal + $normal))*100) >= 50)
          I wanted to update you on your recent medical report.
          It's reassuring to note that a significant portion, specifically 50%, of the tested markers or values fall within the normal range.
          This is positive news, indicating that many aspects of your health are in good condition. However,
          let's also discuss the remaining 50% to ensure a comprehensive understanding.
          We can explore any areas of concern and work together on a plan for your overall well-being.
          Please schedule an appointment at your earliest convenience to go over the results in detail.
          @else
          I wanted to update you on your recent medical report.
          Unfortunately, less than 50% of the tested markers or values fall within the normal range.
          While this might indicate some areas of concern, it's essential not to jump to conclusions.
          Medical conditions are multifaceted, and we need to explore these findings together in detail.
          Please schedule an appointment at your earliest convenience so we can discuss the results further and create an appropriate plan moving forward.
          @endif

        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">Tested Date: {{$viewReportData[0]->date}}</p>


      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
  <div class="lab-assistant">
    ........................................ <br>
    Laboratory Assistant <br>
    {{ date('Y-m-d') }}
  </div>

</div>
<!-- ./wrapper -->

<script>
  function delayedPrint() {
      setTimeout(function() {
          window.print();
      }, 200); // Delay in milliseconds (2000ms = 2 seconds)
  }
  </script>
</body>
</html>

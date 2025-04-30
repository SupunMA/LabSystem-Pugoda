<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>HORIZON | {{$viewReportData->AvailableTestName}} Test chit</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


   <!-- Style -->
   @include('layouts.adminComponents.lib.Style')

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
          <i class="fa fa-flask" aria-hidden="true"></i> HORIZON Lab.
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
          <strong>HORIZON Lab.</strong><br>
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
          <strong>{{$viewReportData->name}}</strong><br>
          {{$viewReportData->address}}<br>
          Mobile:{{$viewReportData->mobile}}<br>
          Email:{{$viewReportData->email}}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">

        <br>
        <b>test ID:</b> {{$viewReportData->tid}}<br>

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
            <th>Name</th>
            <th>Test</th>
            <th>Collection Date</th>

          </tr>
          </thead>
          <tbody>
          <tr>
            <td>{{$viewReportData->tid}}</td>
            <td>{{$viewReportData->name}}</td>
            <td>{{$viewReportData->AvailableTestName}}</td>
            @php
                $newDate = \Carbon\Carbon::parse($viewReportData->date)->addDays($viewReportData->resultDays)->format('Y-m-d');
            @endphp
            <td>{{$newDate}}</td>

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
            "Thank you for completing your tests. Although you can conveniently download your reports online,
            if you choose to collect a physical copy from the lab, please remember to bring the chit we provided you with.
            Presenting the chit will help us verify your identity and provide you with the requested reports.
            If you have any questions or prefer assistance with the online system, feel free to ask.
            We appreciate your understanding and cooperation!"

        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">Tested Date: {{$viewReportData->date}}</p>


      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
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

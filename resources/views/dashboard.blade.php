@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <!-- /top tiles -->
            <div class="row tile_count text-center">
              <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-2x fa-home green"></i> Departments</span>
                <div class="count red">{{$total["department"]}}</div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-2x fa-users green"></i> Admitted Students</span>
                <div class="count blue">{{$total["admitted"]}}</div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-2x fa-users green"></i> Registered Students</span>
                <div class="count green">{{$total["registered"]}}</div>
              </div>
            </div>
            <div class="row tile_count text-center">
              <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-2x fa-book green"></i> Subjects</span>
                <div class="count red">{{$total["subject"]}}</div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-2x fa-pencil green"></i> Attendance(Days)</span>
                <div class="count blue">{{$total["attendance"]}}</div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-2x fa-edit green"></i> Exams</span>
                <div class="count green">{{$total["exam"]}}</div>
              </div>
            </div>
            <!-- /top tiles -->
            <!-- Graph start -->
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Accounting Report<small>(Monthly)</small></h2>
                    <label class="total_bal">
                                              Balance: {{$balance}}
                                         </label>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas  height="50" id="lineChart"></canvas>
                  </div>
                </div>
              </div>

            </div>
<div class="clearfix"></div>
          </div>
        </div>
        <!-- /page content -->

@endsection
@section('extrascript')
<script src="{{ URL::asset('assets/js/Chart.min.js')}}"></script>
  <!-- Chart.js -->
  <script>
    Chart.defaults.global.legend = {
      enabled: false
    };

    // Line chart
    var ctx = document.getElementById("lineChart");
    var lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["<?php echo join($incomes['key'], '","')?>"],
        datasets: [{
          label: "Income",
          backgroundColor: "rgba(38, 185, 154, 0.31)",
          borderColor: "rgba(38, 185, 154, 0.7)",
          pointBorderColor: "rgba(38, 185, 154, 0.7)",
          pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: "rgba(220,220,220,1)",
          pointBorderWidth: 1,
          data: [<?php echo join($incomes['value'], ',')?>]
        }, {
          label: "Expence",
          backgroundColor: "rgba(3, 88, 106, 0.3)",
          borderColor: "rgba(3, 88, 106, 0.70)",
          pointBorderColor: "rgba(3, 88, 106, 0.70)",
          pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: "rgba(151,187,205,1)",
          pointBorderWidth: 1,
          data: [<?php echo join($expences['value'], ',')?>]
        }]
      },
    });



</script>
@endsection

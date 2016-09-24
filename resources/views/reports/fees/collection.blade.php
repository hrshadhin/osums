@extends('layouts.master')
@section("title", "Fee Collection-[$fromDate-$toDate]")
@section('extrastyle')
<link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">


@endsection
@section('content')

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <!-- row start -->
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Fees<small> Student Fees Collection</small></h2>
            <div class="clearfix"></div>

          </div>
          <div class="x_content">
            <div class="row">

              <form class="" method="POST" action="{{URL::route('fees.collection.report')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-5 col-sm-6 col-xs-12">
                  <label for="department_id">Date Range *:</label>
                  <div class="input-prepend input-group">
                    <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                    <input type="text" style="width: 200px" name="DateRange" id="reservation" class="form-control" value="{{$fromDate}} - {{$toDate}}" />
                  </div>
                </div>

                <div class="col-md-2 col-sm-12 col-xs-12">
                  <br>
                  <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-check"></i> Go </button>
                </div>
              </form>
            </div>
          </div>
          <br><br>
          <h2 class="text-info text-center">Collection of Fees</h2>
          <!-- Fee List -->
          @if($fees)
          <div class="row">
            <div class="col-md-12">
              <table id="feeList" class="smartTable table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Bill No</th>
                    <th>Payable Amount</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Pay Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($fees as $fee)
                  <tr>
                    <td>0{{$fee->id}}</td>
                    <td>{{$fee->payableAmount}}</td>
                    <td>{{$fee->paidAmount}}</td>
                    <td>{{$fee->dueAmount}}</td>
                    <td>{{$fee->payDate->format('F j,Y')}}</td>
                  </tr>
                    @endforeach
                    <tr>
                      <td>900000000000000009</td>
                      <td>Total Payable: <strong><i class="blue">{{$totals->payTotal}}</i></strong> tk.</td>
                      <td>Total Paid: <strong><i class="blue">{{$totals->paiTotal}}</i></strong> tk.</td>
                      <td>Total Due: <strong><i class="blue">{{$totals->dueamount}}</i></strong> tk.</td>
                      <td>-------------</td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <br>
            <h2 class="text-info text-center">Summary</h2>
            <div class="row">
              <div class="col-md-12">
                <table class="table">
                  <tbody>
                    <tr>
                      <td></td>
                      <td>Total Payable: <strong><i class="blue">{{$totals->payTotal}}</i></strong> tk.</td>
                      <td>Total Paid: <strong><i class="blue">{{$totals->paiTotal}}</i></strong> tk.</td>
                      <td>Total Due: <strong><i class="blue">{{$totals->dueamount}}</i></strong> tk.</td>
                      <td></td>
                      <td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              @else
              <h2 style="color:red">There are no fee records.</h2>
              @endif
              </div>
          </div>
          <!-- row end -->
          <div class="clearfix"></div>

        </div>
      </div>
  <!-- /page content -->
@endsection

@section('extrascript')
<!-- dataTables -->
<script src="{{ URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/buttons.flash.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/daterangepicker.js')}}"></script>
<script>
$(document).ready(function() {
  $('#reservation').daterangepicker({ format:'D/M/YYYY'});
  //datatables code
  var handleDataTableButtons = function() {
    if ($(".smartTable").length) {
      $(".smartTable").DataTable({
        responsive: true,
        iDisplayLength:100,
        dom: "Bfrtip",
        buttons: [
          {
            extend: "copy",
            className: "btn-sm",
            exportOptions: {
              columns: [0,1,2,3,4]
            }
          },
          {
            extend: "csv",
            className: "btn-sm",
            exportOptions: {
              columns: [0,1,2,3,4]
            }
          },
          {
            extend: "excel",
            className: "btn-sm",
            exportOptions: {
              columns: [0,1,2,3,4]
            }
          },
          {
            extend: "pdfHtml5",
            className: "btn-sm",
            exportOptions: {
              columns: [0,1,2,3,4]
            }
          },
          {
            extend: "print",
            className: "btn-sm"
          },
        ],
        responsive: true
      });
    }
  };

  TableManageButtons = function() {
    "use strict";
    return {
      init: function() {
        handleDataTableButtons();
      }
    };
  }();

  TableManageButtons.init();
});
</script>
@endsection

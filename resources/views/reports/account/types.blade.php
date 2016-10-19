@extends('layouts.master')
@section("title", "[$type][$fromDate-$toDate]")
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
                    <h2>Account<small> Account  information by types</small></h2>
                    <label class="total_bal">
                               Total {{$type}}: {{$total}}
                          </label>
                          <div class="clearfix"></div>

                  </div>
                  <div class="x_content">
                    <div class="row">

                        <form class="" method="POST" action="{{URL::route('accounting.reports.type')}}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="col-md-5 col-sm-6 col-xs-12">
                        <label for="department_id">Date Range *:</label>
                        <div class="input-prepend input-group">
                               <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                               <input type="text" style="width: 200px" name="DateRange" id="reservation" class="form-control" value="{{$fromDate}} - {{$toDate}}" />
                        </div>
                        </div>
                          <div class="col-md-5 col-sm-6 col-xs-12">
                        <label for="">Type *:</label>
                        <div class="input-prepend input-group">
                               <span class="add-on input-group-addon"><i class="fa fa-info"></i></span>
                               {!!Form::select('type', $types, $type, ['placeholder' => 'Pick a Type','class'=>'form-control','required'=>'required'])!!}


                        </div>
                        </div>
                          <div class="col-md-2 col-sm-12 col-xs-12">
                              <br>
                            <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-check"></i> Go </button>
                          </div>
                        </form>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Sector</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Description</th>


                        </tr>
                      </thead>
                      <tbody>
                      @foreach($accounts as $account)
                        <tr>
                          <td>{{$account->sector->name}}</td>
                                                <td>{{$account->amount}}</td>
                                                <td>{{$account->date->format('F j,Y')}}</td>
                                                <td>{{$account->description}}</td>


                        </tr>
                      @endforeach
                      <tr>
                        <td><b>Total<b></td>
                          <td>{{$total}}</td>
                          <td></td>
                          <td></td>



                      </tr>
                      </tbody>

                    </table>
                  </div>
                </div>
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
       if ($("#datatable-buttons").length) {
         $("#datatable-buttons").DataTable({
           responsive: true,
           iDisplayLength:100,
           dom: "Bfrtip",
           buttons: [
             {
               extend: "copy",
               className: "btn-sm",
               exportOptions: {
                 columns: [0,1,2,3]
               }
             },
             {
               extend: "csv",
               className: "btn-sm",
               exportOptions: {
                 columns: [0,1,2,3]
               }
             },
             {
               extend: "excel",
               className: "btn-sm",
               exportOptions: {
                 columns: [0,1,2,3]
               }
             },
             {
               extend: "pdfHtml5",
               className: "btn-sm",
               exportOptions: {
                 columns: [0,1,2,3]
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
     @if(count($accounts)==0)
     new PNotify({
       title: "Data Fetch",
       text: 'There are no transaction in date range.',
       styling: 'bootstrap3'
     });
     @endif






   });
 </script>
@endsection

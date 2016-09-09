@extends('layouts.master')

@section('title', 'AC-Sector')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/sweetalert.css')}}" rel="stylesheet">

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
                        <h2>Income<small> Income Lists</small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <form class="form-horizontal form-label-left custom-error" method="post" action="{{URL::route('accounting.income.store')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="item form-group">
                                            <label class="control-label" for="name">Sector <span class="required">*</span>
                                            </label>
                                            {!!Form::select('sectors_id', $sectors, null, ['placeholder' => 'Pick a Sector','class'=>'form-control select2_single sector','required'=>'required','id'=>'sectors_id'])!!}
                                       <span class="text-danger">{{ $errors->first('sectors_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="item form-group">
                                            <label class="control-label" for="amount">Amount <span class="required">*</span>
                                            </label>
                                            <input type="text" id="amount" class="form-control"  name="amount" required />
                                            <span class="text-danger">{{ $errors->first('amount') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="item form-group">
                                            <label class="control-label" for="date">Date <span class="required">*</span>
                                            </label>
                                            <input class="form-control accDate"  name="date" value="{{$today->format('d/m/Y')}}" required="required" />
                                            <span class="text-danger">{{ $errors->first('date') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="item form-group">
                                            <label class="control-label" for="description">Description
                                            </label>
                                            <textarea class="form-control" id="description" name="description"  required="required"> </textarea>
                                            <span class="text-danger">{{ $errors->first('description') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-lg btn-primary btn-attend"><i class="fa fa-plus"></i> Save </button>
                                    </div>

                                </div>


                            </form>
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
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($incomes as $income)
                                        <tr>

                                            <td>{{$income->sector->name}}</td>
                                            <td>{{$income->amount}}</td>
                                            <td>{{$income->date->format('F j,Y')}}</td>
                                            <td>{{$income->description}}</td>
                                            <td>
                                                <form  class="deleteForm" method="get" action="{{URL::route('accounting.income.destroy',$income->id)}}">
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class='btn btn-danger btn-xs btnDelete' href=''> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
            <script src="{{ URL::asset('assets/js/select2.full.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/sweetalert.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/daterangepicker.js')}}"></script>
        <script>
        $(document).ready(function() {
            $('.accDate').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_1",
                format:'D/M/YYYY'
            });
            $(".sector").select2({
                placeholder: "Select Sector",
                allowClear: true
            });
            //datatables code
            var handleDataTableButtons = function() {
                if ($("#datatable-buttons").length) {
                    $("#datatable-buttons").DataTable({
                        responsive: true,
                        dom: "Bfrtip",
                        buttons: [
                            {
                                extend: "copy",
                                className: "btn-sm"
                            },
                            {
                                extend: "csv",
                                className: "btn-sm"
                            },
                            {
                                extend: "excel",
                                className: "btn-sm"
                            },
                            {
                                extend: "pdfHtml5",
                                className: "btn-sm"
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

            @if(count($incomes)==0)
            new PNotify({
                title: "Data Fetch",
                text: 'There are no Incomes!',
                styling: 'bootstrap3'
            });
            @endif

            //delete warning
             $('.deleteForm').submit(function(e) {
               e.preventDefault();
               form=this;
               swal({
                   title: "Income Deletion!",
                   text: 'Are you sure to delete it?',
                   type: "warning",
                   showCancelButton: true,
                   confirmButtonColor: "#cc3f44",
                   confirmButtonText: "Yes",
                   closeOnConfirm: true,
                   html: false
               }, function( isConfirm ) {
                   if(isConfirm)
                      form.submit();
               });
              });
        });

        </script>

        @endsection

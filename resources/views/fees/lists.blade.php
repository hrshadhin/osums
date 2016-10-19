@extends('layouts.master')

@section('title', 'Fees-List')
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
                        <h2>Fees<small> All Fees List</small></h2>
                        <form class="form-horizontal form-label-left custom-error" method="post" action="{{URL::route('fees.store')}}">
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Save </button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="item form-group">
                                            <label class="control-label " for="department">Department <span class="required">*</span>
                                            </label>
                                            {!!Form::select('department_id', $departments, null, ['placeholder' => 'Pick a department','class'=>'select2_single department form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required','id'=>'department_id'])!!}
                                         <i class="fa fa-home form-control-feedback left" aria-hidden="true"></i>
                                       <span class="text-danger">{{ $errors->first('department_id') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="item form-group">
                                            <label class="control-label" for="title">Title <span class="required">*</span>
                                            </label>
                                            <input type="text" id="title" class="form-control" name="title" required />
                                            <span class="text-danger">{{ $errors->first('title') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="item form-group">
                                            <label class="control-label" for="amount">Amount(৳) <span class="required">*</span>
                                            </label>
                                            <input type="number" name="amount" required class="form-control">

                                            <span class="text-danger">{{ $errors->first('amount') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="item form-group">
                                            <label class="control-label" for="description">Description
                                            </label>
                                            <textarea type="text" name="description"  class="form-control"> </textarea>
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Title</th>
                                            <th>Amount(৳)</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fees as $fee)
                                        <tr>
                                            <td>{{$fee->department->name}}</td>
                                            <td>{{$fee->title}}</td>
                                            <td>{{$fee->amount}}</td>
                                            <td>{{$fee->description}}</td>
                                            <td>
                                                <form  class="deleteForm" method="POST" action="{{URL::route('fees.destroy',$fee->id)}}">
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
    <script>
    $(document).ready(function() {
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

        @if(count($fees)==0)
        new PNotify({
            title: "Data Fetch",
            text: 'There are no fees!',
            styling: 'bootstrap3'
        });
        @endif

        //delete warning
        $('.deleteForm').submit(function(e) {
            e.preventDefault();
            form=this;
            swal({
                title: "Fee Deletion!",
                text: 'All fees data related with this fee will be delete.<br>Are you sure to delete it?',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#cc3f44",
                confirmButtonText: "Yes",
                closeOnConfirm: true,
                html: true
            }, function( isConfirm ) {
                if(isConfirm)
                form.submit();
            });
        });
        $(".department").select2({
       placeholder: "Pick a department",
       allowClear: true
    });
    });

    </script>

    @endsection

@extends('layouts.master')

@section('title', 'Students')

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
                            <h2>Students<small> Registered Student List.</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <form class="" method="POST" action="{{URL::route('search.students.list')}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label for="department_id">Search: <span class="required">*</span></label>

                                        <input type="text" name="search_by_id" class="form-control has-feedback-left" tabindex="-1" id="search_by_id" placeholder="Search By Id">
                                        <i class="fa fa-home form-control-feedback left" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <br>
                                        <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-check"></i> Go </button>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12" id="table_content">
                                    @include('pertials.table')
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

            $(".department").select2({
                placeholder: "Select Department",
                allowClear: true
            });
            $(".session").select2({
                placeholder: "Select session",
                allowClear: true
            });
            $(".semester").select2({
                placeholder: "Select Semester",
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
            @if($selectDep!="" && count($students)==0)
            new PNotify({
                title: "Data Fetch",
                text: 'There are no student!',
                styling: 'bootstrap3'
            });
            @endif

            $('.deleteForm').submit(function(e) {
                e.preventDefault();
                var that=$(this);
                swal({
                    title: "Registration Cancel!",
                    text: 'Are you sure to cancel this registration?',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#cc3f44",
                    confirmButtonText: "Yes",
                    closeOnConfirm: true,
                    html: false
                }, function( isConfirm ) {
                    if(isConfirm)
                    {
                        var data= $('.deleteForm').serialize();
                        //console.log(data);
                        var postURL = $('.deleteForm').attr('action');
                        //console.log();
                        $.ajax({
                            url: postURL,
                            type: 'get',
                            dataType: 'json',
                            data: data,
                            success: function(data) {
                                that.parent().parent().remove();
                                new PNotify({
                                    title: data.message.title,
                                    text: data.message.body,
                                    type: 'success',
                                    styling: 'bootstrap3'
                                });


                            },
                            error: function(data){
                                var respone = JSON.parse(data.responseText);
                                $.each(respone.message, function( key, value ) {
                                    new PNotify({
                                        title: 'Error!',
                                        text: value,
                                        type: 'error',
                                        styling: 'bootstrap3'
                                    });
                                });

                            }
                        });
                    }

                });
            });

            $('#search_by_id').on('keypress',function (e) {
                if (e.which==13){
                    e.preventDefault();
                    val= $('#search_by_id').val();
                    console.log(val);
                    $.ajax({
                        type:'POST',
                        url:'{{ route('search.students.list')  }}',
                        data:{
                            _token: "{{ csrf_token() }}",
                            search_by_id:val,
                            request_type:'ajax'
                        },
                        success: function( data ) {
                            $('#table_content').html(data);
                        }
                    });
                }
            });

        });

    </script>

@endsection

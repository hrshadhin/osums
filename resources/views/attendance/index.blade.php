@extends('layouts.master')

@section('title', 'Attendance')
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
                        <h2>Attendance<small> Attendance List.</small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <form id="attendanceForm" class="form-horizontal form-label-left custom-error" novalidate method="post" action="{{URL::route('attendance.index2')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="item form-group">
                                            <label class="control-label " for="department">Department <span class="required">*</span>
                                            </label>

                                            {!!Form::select('department_id', $departments, $selectDep, ['placeholder' => 'Pick a department','class'=>'select2_single department form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required','id'=>'department_id'])!!}
                                            <i class="fa fa-home form-control-feedback left" aria-hidden="true"></i>
                                            <span class="text-danger">{{ $errors->first('department_id') }}</span>

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="item form-group">
                                            <label class="control-label" for="session">Session <span class="required">*</span>
                                            </label>
                                            {!!Form::select('session', $sessions, $session, ['placeholder' => 'Pick a Session','class'=>'select2_single session form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required' ,'id'=>'session'])!!}
                                            <i class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></i>
                                            <span class="text-danger">{{ $errors->first('session') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="item form-group">
                                            <label class="control-label" for="levelTerm">Semester <span class="required">*</span>
                                            </label>

                                            {!!Form::select('levelTerm', $semesters, $selectSem, ['placeholder' => 'Pick a Semester','class'=>'select2_single semester form-control col-md-7 col-xs-12 hass-feedback-left', 'id'=>'levelTerm','required'=>'required'])!!}
                                            <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                                            <span class="text-danger">{{ $errors->first('levelTerm') }}</span>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="item form-group">
                                            <label class="control-label" for="date">Date <span class="required">*</span>
                                            </label>
                                            <input class="form-control" id="presentDate" name="date" value="{{$today->format('d/m/Y')}}" required="required" />
                                            <span class="text-danger">{{ $errors->first('date') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="item form-group">
                                            <label class="control-label" for="subject_id">Subject <span class="required">*</span>
                                            </label>

                                            {!!Form::select('subject_id',$subjects, $selectSub, ['placeholder' => 'Pick a Subject','class'=>'select2_single subject form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required' ,'id'=>'subject_id'])!!}
                                            <i class="fa fa-book form-control-feedback left" aria-hidden="true"></i>
                                            <span class="text-danger">{{ $errors->first('subject_id') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <button type="submit" class="btn btn-lg btn-primary btn-attend"><i class="fa fa-check"></i> Go </button>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>

                                                <th>Name</th>
                                                <th>ID no</th>
                                                <th>Present</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students as $student)
                                            <tr>

                                                <td>{{$student['name']}}</td>
                                                <td>{{$student['idNo']}}</td>
                                                <td class="tdPresent">
                                                    @if($student['present']) Yes @else No @endif

                                                </td>
                                                <td>
                                                    <a title='Edit' href="#" class='btn btn-success btn-xs btnUpdate' data-present="{{$student['present']}}" data-id='{{$student['id']}}'> <i class="fa fa-pencil icon-white"></i></a>

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


    <!-- Modal For Present -->
    <div id ="presentModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Present Information<label class="control-label status confirm" id="invoiceStatus"></label></h4>
                </div>
                <div class="modal-body">

                    <form id="presentUpdateForm" class="" novalidate  method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="blue"><strong>Present:<strong></label><br>
                                    <select id="presentDrop" name="present" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>

                            </div>





                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="id" id="hiddenId" >
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary pull-left" id="btnUpdate" type="button"><i class="fa fa-refresh"></i> Update</button>
                        </form>
                        <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal For Attendance Update -->
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
        <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/daterangepicker.js')}}"></script>
        <script>
        $(document).ready(function() {
            $('#presentDate').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_1",
                format:'D/M/YYYY'
            });

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
            $(".subject").select2({
                placeholder: "Select Subject",
                allowClear: true
            });
            // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
            $('form')
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select.required', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);

            $('form').submit(function(e) {
                e.preventDefault();
                var submit = true;

                // evaluate the form using generic validaing
                if (!validator.checkAll($(this))) {
                    submit = false;
                }

                if (submit)
                this.submit();

                return false;
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

            //get subjects on semeter change
            //get subject lists
            $('#levelTerm').on('change',function (){
                var dept= $('#department_id').val();
                var session = $('#session').val();
                var semester = $(this).val();
                if(!dept || !session){
                    new PNotify({
                        title: 'Validation Error!',
                        text: 'Please Pic A Department or Write session!',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                }
                else {
                    //for subjects
                    $.ajax({
                        url:'/subject/'+dept+'/'+semester,
                        type: 'get',
                        dataType: 'json',
                        success: function(data) {
                            //console.log(data);
                            $('#subject_id').empty();
                            $('#subject_id').append('<option  value="">Pic a Subject</option>');
                            $.each(data.subjects.data, function(key, value) {
                                $('#subject_id').append('<option  value="'+value.id+'">'+value.name+'['+value.code+']</option>');

                            });
                            $(".subject").select2({
                                placeholder: "Pick a Subject",
                                allowClear: true
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
            //update button click
            var tdPresent=null;
            $('.btnUpdate').on('click',function (){
                tdPresent=$(this).closest('tr').children('td.tdPresent');
                var id = $(this).attr('data-id');
                var present = $(this).attr('data-present');
                $('#presentDrop').val(present);
                $('#hiddenId').val(id);
                $('#presentModal').modal('show');
            });
            //updat form submit
            $('#btnUpdate').on('click',function(e) {
                var data= $('#presentUpdateForm').serialize();
                var postURL = '{{URL("/")}}/attendance/'+$('#hiddenId').val();
                //console.log(postURL);
                $.ajax({
                    url: postURL,
                    type: 'post',
                    dataType: 'json',
                    data: data,
                    success: function(data) {
                        console.log(data);
                        $('#presentUpdateForm').trigger("reset");
                        new PNotify({
                            title: 'Data Update.',
                            text: data.message,
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                        tdPresent.text(data.present);
                        $('#presentModal').modal('hide');

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
            });
        });

        </script>

        @endsection

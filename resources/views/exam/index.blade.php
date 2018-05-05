@extends('layouts.master')

@section("title", "Marks-[$exam]")
@section('extrastyle')
<link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/sweetalert.css')}}" rel="stylesheet">
<style>
@media print {
      table td:last-child {display:none}
      table th:last-child {display:none}
  }
</style>
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
                        <h2>Exam<small> Student Exam Mark List</small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <form id="examForm" class="form-horizontal form-label-left custom-error" novalidate method="post" action="{{URL::route('exam.index2')}}">
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

                                            {!!Form::select('levelTerm', $semesters, $selectSem, ['placeholder' => 'Pick a Semester','class'=>'select2_single semester form-control col-md-7 col-xs-12 has-feedback-left', 'id'=>'levelTerm','required'=>'required'])!!}
                                            <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                                            <span class="text-danger">{{ $errors->first('levelTerm') }}</span>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="item form-group">
                                       <label class="control-label" for="exam">Exam <span class="required">*</span>
                                       </label>

                                       {!!Form::select('exam',$exams, $exam, ['placeholder' => 'Pick a Exam','class'=>'select2_single exam form-control','required'=>'required'])!!}
                                       <span class="text-danger">{{ $errors->first('exam') }}</span>

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
                                                <th>Id No</th>
                                                <th>Name</th>
                                                <th>Written</th>
                                                <th>Quiz</th>
                                                <th>Presentation</th>
                                                <th>Lab/Practical</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($marks as $mark)
                                            <tr>

                                                <td>{{$mark['idNo']}}</td>
                                                <td>{{$mark['name']}}</td>
                                                <td>{{$mark['raw_score']}}</td>
                                                <td>{{$mark['percentage']}}</td>
                                                <td>{{$mark['weight']}}</td>
                                                <td>{{$mark['percentage_x_weight']}}</td>
                                                <td>
                                                    <a title='Edit' href="#" class='btn btn-success btn-xs btnUpdate'  data-id='{{$mark["id"]}}'> <i class="fa fa-pencil icon-white"></i></a>

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
    <div id ="marksModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Marks Information<label class="control-label status confirm" id="invoiceStatus"></label></h4>
                </div>
                <div class="modal-body">

                    <form id="markUpdateForm" class="" novalidate  method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="blue"><strong>Written:<strong></label><br>
                                  <input type="number" id="raw_score" class="form-control"  name="raw_score"  required />

                            </div>
                            <div class="col-md-3">
                                <label class="blue"><strong>Quiz:<strong></label><br>
                                  <input type="number" id="percentage" class="form-control"  name="percentage"  required />

                            </div>
                            <div class="col-md-3">
                                <label class="blue"><strong>Presentation:<strong></label><br>
                                  <input type="number" id="weight" class="form-control"  name="weight"  required />

                            </div>
                            <div class="col-md-3">
                                <label class="blue"><strong>Lab/Practical:<strong></label><br>
                                  <input type="number" id="percentage_x_weight" class="form-control"  name="percentage_x_weight"  required />

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
        <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>

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

            @if($selectDep!="" && count($marks)==0)
            new PNotify({
                title: "Data Fetch",
                text: 'There are no marks entry!',
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
            var trRow=null;
            $('.btnUpdate').on('click',function (){
                trRow=$(this).closest('tr');
                var id = $(this).attr('data-id');
                $('#hiddenId').val(id);
                $('#raw_score').val(trRow.children('td:nth-child(3)').text());
                $('#percentage').val(trRow.children('td:nth-child(4)').text());
                $('#weight').val(trRow.children('td:nth-child(5)').text());
                $('#percentage_x_weight').val(trRow.children('td:nth-child(6)').text());
                $('#marksModal').modal('show');
            });

            //updat form submit
            $('#btnUpdate').on('click',function(e) {
                var data= $('#markUpdateForm').serialize();
                var postURL = '{{URL("/")}}/exam/'+$('#hiddenId').val();
                //console.log(postURL);
                $.ajax({
                    url: postURL,
                    type: 'post',
                    dataType: 'json',
                    data: data,
                    success: function(data) {
                        //console.log(data);
                        $('#markUpdateForm').trigger("reset");
                        new PNotify({
                            title: 'Data Update.',
                            text: data.message,
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                        trRow.children('td:nth-child(3)').text(data.marks.raw_score);
                      trRow.children('td:nth-child(4)').text(data.marks.percentage);
                        trRow.children('td:nth-child(5)').text(data.marks.weight);
                        trRow.children('td:nth-child(6)').text(data.marks.percentage_x_weight);
                        $('#marksModal').modal('hide');

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

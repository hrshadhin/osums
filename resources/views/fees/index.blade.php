@extends('layouts.master')

@section('title', 'Fee-Student')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/switchery.min.css')}}" rel="stylesheet">
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
               <form id="collectionForm" class="form-horizontal form-label-left custom-error" novalidate method="get" action="">

                  <div class="x_title">
                     <h2>Fee<small> Student Fee List </small></h2>
                     <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     @if (count($errors) > 0)
                     <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                           @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                     </div>
                     @endif
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <div class="row">
                        <div class="col-md-5">
                           <div class="item form-group">
                              <label class="control-label " for="department">Department <span class="required">*</span>
                              </label>

                              {!!Form::select('department_id', $departments, null, ['placeholder' => 'Pick a department','class'=>'select2_single department form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required','id'=>'department_id'])!!}
                     <i class="fa fa-home form-control-feedback left" aria-hidden="true"></i>
                   <span class="text-danger">{{ $errors->first('department_id') }}</span>

                           </div>
                        </div>

                        <div class="col-md-2">
                           <div class="item form-group">
                              <label class="control-label" for="session">Session <span class="required">*</span>
                              </label>
                              {!!Form::select('session', $sessions, null, ['placeholder' => 'Pick a Session','class'=>'select2_single session form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required' ,'id'=>'session'])!!}
                            <i class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></i>
                              <span class="text-danger">{{ $errors->first('session') }}</span>

                           </div>
                        </div>
                        <div class="col-md-5">
                           <div class="item form-group">
                              <label class="control-label" for="levelTerm">Semester <span class="required">*</span>
                              </label>

                              {!!Form::select('levelTerm', $semesters, null, ['placeholder' => 'Pick a Semester','class'=>'select2_single semester form-control col-md-7 col-xs-12 has-feedback-left', 'id'=>'levelTerm','required'=>'required'])!!}
                              <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                              <span class="text-danger">{{ $errors->first('levelTerm') }}</span>

                           </div>
                        </div>

                     </div>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="item form-group">
                              <label class="control-label" for="students_id">Student <span class="required">*</span>
                              </label>
                              {!!Form::select('students_id',$students, null, ['placeholder' => 'Pick a Student','class'=>'select2_single student form-control has-feedback-left','required'=>'required' ,'id'=>'students_id'])!!}
                              <i class="fa fa-user form-control-feedback left" aria-hidden="true"></i>
                              <span class="text-danger">{{ $errors->first('students_id') }}</span>

                           </div>
                        </div>
                        <div class="col-md-7">
                           <div class="item form-group">
                              <button type="submit" class="btn btn-primary btn-attend"><i class="fa fa-list"></i> Get List </button>
                           </div>
                        </div>

                     </div>
                     <hr>

                  </form>
               </div>
               <!-- row end -->
               <br><br>
               <div class="clearfix"></div>
            </div>
         </div>
         <!-- /page content -->
         @endsection
         @section('extrascript')
         <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
         <script src="{{ URL::asset('assets/js/select2.full.min.js')}}"></script>
         <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
         <script>
         $(document).ready(function() {
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
               {
                  var baseURL = "{{URL('/')}}"+"/fees-student/";
                  var stdId= $('#students_id').val();
                  var url= baseURL+stdId;
                  var win = window.open(url, '_blank');
                  if (win) {
                      //Browser has allowed it to be opened
                      win.focus();
                  } else {
                      //Browser has blocked it
                      alert('Please allow popups for this website');
                  }

               }
               return false;
            });
            <!-- /validator -->
            $(".department").select2({
               placeholder: "Pick a department",
               allowClear: true
            });
            $(".student").select2({
               placeholder: "Pick a student",
               allowClear: true
            });
            $(".semester").select2({
               placeholder: "Pick a semester",
               allowClear: true
            });
            $(".session").select2({
               placeholder: "Pick a session",
               allowClear: true
            });
            //get student lists
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
                  $.ajax({
                     url:'/students/'+dept+'/'+session+'/'+semester,
                     type: 'get',
                     dataType: 'json',
                     success: function(data) {
                        //console.log(data);
                        $('#students_id').empty();
                        $('#students_id').append('<option  value="">Pic a Student</option>');
                        $.each(data.students.data, function(key, value) {
                           $('#students_id').append('<option  value="'+value.id+'">'+value.name+'['+value.idNo+']</option>');

                        });
                        $(".student").select2({
                           placeholder: "Pick a Student",
                           allowClear: true
                        });
                     },
                     error: function(data){
                        errorManager(data);  }
                     });
                  }
               });


               var errorManager = function(data){
                  var respone = JSON.parse(data.responseText);
                  $.each(respone.message, function( key, value ) {
                     new PNotify({
                        title: 'Error!',
                        text: value,
                        type: 'error',
                        styling: 'bootstrap3'
                     });
                  });
               };
            });
            </script>
            @endsection

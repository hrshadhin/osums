@extends('layouts.master')

@section('title', 'Registration')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
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
                  <h2>Registration<small> Student semester registration</small></h2>

                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <form class="form-horizontal form-label-left" novalidate method="post" action="{{URL::route('student.registration.store')}}">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="department">Department <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           {!!Form::select('department_id', $departments, null, ['placeholder' => 'Pick a department','class'=>'select2_single department form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required','id'=>'department_id'])!!}
                           <i class="fa fa-home form-control-feedback left top-25" aria-hidden="true"></i>
                           <span class="text-danger">{{ $errors->first('department_id') }}</span>
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="session">Session <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           {!!Form::select('session', $sessions, null, ['placeholder' => 'Pick a Session','class'=>'select2_single session form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required' ,'id'=>'session'])!!}
                           <i class="fa fa-clock-o form-control-feedback left top-25" aria-hidden="true"></i>
                           <span class="text-danger">{{ $errors->first('session') }}</span>                       </div>
                     </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="students_id">Student <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           {!!Form::select('students_id', $students, null, ['placeholder' => 'Pick a Student','class'=>'select2_single student form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required' ,'id'=>'students_id'])!!}
                           <i class="fa fa-user form-control-feedback left top-25" aria-hidden="true"></i>
                           <span class="text-danger">{{ $errors->first('students_id') }}</span>
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="levelTerm">Semester <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           {!!Form::select('levelTerm', $semesters, null, ['placeholder' => 'Pick a Semester','class'=>'select2_single semester form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required'])!!}
                           <i class="fa fa-info form-control-feedback left top-25" aria-hidden="true"></i>
                           <span class="text-danger">{{ $errors->first('levelTerm') }}</span>
                        </div>
                     </div>

                     <div class="ln_solid"></div>
                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           <button id="send" type="submit" class="btn btn-success"><i class="fa fa-check"> Submit</i></button>
                        </div>
                     </div>

                  </form>
               </div>
            </div>
            <!-- row end -->
            <div class="clearfix"></div>

         </div>
      </div>
      <!-- /page content -->
      @endsection
      @section('extrascript')

      <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
      <script src="{{ URL::asset('assets/js/select2.full.min.js')}}"></script>
      <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
      <!-- validator -->
      <script>
      // initialize the validator function
      validator.message.date = 'not a real date';

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

         if (submit){
            var data= $('form').serialize();
            var postURL = this.action;
            $.ajax({
               url: postURL,
               type: 'post',
               dataType: 'json',
               data: data,
               success: function(data) {
                  //console.log(data);
                  new PNotify({
                     title: data.message.title,
                     text: data.message.body,
                     type: 'success',
                     styling: 'bootstrap3'
                  });
                  $(".student").val('').trigger('change');
                  $(".semester").val('').trigger('change');


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
      $(".session").select2({
         placeholder: "Pick a Session",
         allowClear: true
      });
      $(".semester").select2({
         placeholder: "Pick a semester",
         allowClear: true
      });

      //get students lists
      $('#session').on('change',function (){
         var dept= $('#department_id').val();
         var session = $(this).val();
         if(!dept){
            new PNotify({
               title: 'Validation Error!',
               text: 'Please Pic A Department!',
               type: 'error',
               styling: 'bootstrap3'
            });
         }
         else {
            $.ajax({
               url:'/students/'+dept+'/'+session,
               type: 'get',
               dataType: 'json',
               success: function(data) {
                  $('#students_id').empty();
                  $('#students_id').append('<option  value="">Pic a student</option>');
                  $.each(data.students, function(key, value) {
                     $('#students_id').append('<option  value="'+value.id+'">'+value.firstName+' '+value.middleName+' '+value.lastName+'['+value.idNo+']</option>');

                  });
                  $(".student").select2({
                     placeholder: "Pick a student",
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
      </script>
      @endsection

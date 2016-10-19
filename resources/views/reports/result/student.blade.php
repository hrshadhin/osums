@extends('layouts.master')

@section("title", "Mark-Sheet")
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
            <h2>Result<small> Student Result Student wise</small></h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">

              <form id="examForm" class="form-horizontal form-label-left custom-error" novalidate method="post" action="{{URL::route('result.individual.post')}}">
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
                      <label class="control-label" for="exam">Exam <span class="required">*</span>
                      </label>

                      {!!Form::select('exam',$exams, null, ['placeholder' => 'Pick a Exam','class'=>'select2_single form-control','required'=>'required' ,'id'=>'exam'])!!}
                      <span class="text-danger">{{ $errors->first('exam') }}</span>

                    </div>
                  </div>

                </div>
                <div class="row">

                  <div class="col-md-5">
                    <div class="item form-group">
                      <label class="control-label" for="students_id">Student <span class="required">*</span>
                      </label>

                      {!!Form::select('students_id',$students, null, ['placeholder' => 'Pick a Student','class'=>'select2_single student form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required' ,'id'=>'students_id'])!!}
                      <i class="fa fa-user form-control-feedback left" aria-hidden="true"></i>
                      <span class="text-danger">{{ $errors->first('students_id') }}</span>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-lg btn-primary btn-attend"><i class="fa fa-th"></i> Get Transcript </button>
                  </div>
                </form>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

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
    $(".student").select2({
      placeholder: "Select student",
      allowClear: true
    });
    //get students lists
      $('#session').change(function (){
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



  });

  </script>

  @endsection

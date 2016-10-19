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
            <h2>Result<small> Student Result Subject wise</small></h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">

              <form id="examForm" class="form-horizontal form-label-left custom-error" novalidate method="post" action="{{URL::route('result.subject.post')}}">
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
                      <label class="control-label" for="subject_id">Subject <span class="required">*</span>
                      </label>

                      {!!Form::select('subject_id',$subjects, null, ['placeholder' => 'Pick a Subject','class'=>'select2_single subject form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required' ,'id'=>'subject_id'])!!}
                      <i class="fa fa-book form-control-feedback left" aria-hidden="true"></i>
                      <span class="text-danger">{{ $errors->first('subject_id') }}</span>

                    </div>
                  </div>
                  <div class="col-md-5">
                    <button type="submit" class="btn btn-lg btn-primary btn-attend"><i class="fa fa-th"></i> Get Result Sheet </button>
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

  });

  </script>

  @endsection

@extends('layouts.master')

@section('title', 'Attendance')
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
               <form id="attendanceForm" class="form-horizontal form-label-left custom-error" novalidate method="post" action="{{URL::route('attendance.store')}}">

               <div class="x_title">
                  <h2>Attendance<small> Student Attendance </small></h2>

                  <label class="pull-right">
                     <input id="isSendSMS" type="checkbox" class="SendSMS js-switch" name="isSMS" /> Send SMS
                  </label>
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

                              {!!Form::select('subject_id',$subjects, null, ['placeholder' => 'Pick a Subject','class'=>'select2_single subject form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required' ,'id'=>'subject_id'])!!}
                              <i class="fa fa-book form-control-feedback left" aria-hidden="true"></i>
                              <span class="text-danger">{{ $errors->first('subject_id') }}</span>

                           </div>
                        </div>
                        <div class="col-md-5">

                           <button id="btnsave" type="submit" class="btn btn-success btn-attend"><i class="fa fa-check"> Submit</i></button>

                        </div>

                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="table-responsive">
                              <table id="studentList" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>

                                       <th>Id No</th>
                                       <th>Name</th>
                                       <th>Is Present? <div class="pull-right"><input type="checkbox" id="allcheck" class="js-switch allCheck" name="allcheck">All Select</div></th>

                                    </tr>
                                 </thead>
                                 <tbody>


                                    <tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>


                     </div>
                     </form>
                  </div>
                  <!-- row end -->



               </div>
            </div>
            <!-- /page content -->
            @endsection
            @section('extrascript')

            <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/select2.full.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/switchery.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/daterangepicker.js')}}"></script>
            <!-- validator -->
            <script>
            $(document).ready(function() {
               $('#btnsave').hide();
               $('#presentDate').daterangepicker({
                  singleDatePicker: true,
                  calender_style: "picker_1",
                  format:'D/M/YYYY'
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
                     //for students
                     populateStudentGrid(dept,session,semester);
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
               //fucntions
               function populateStudentGrid(dept,session,semester)
               {
                  $.ajax({
                     url:'/students/'+dept+'/'+session+'/'+semester,
                     type: 'get',
                     dataType: 'json',
                     success: function(data) {
                        //console.log(data);
                        $("#studentList").find("tr:gt(0)").remove();
                        if(data.students.data.length>0)
                        {
                           $('#btnsave').show();
                        }
                        else {
                           $('#btnsave').hide();
                        }
                        $.each(data.students.data, function(key, value) {
                           addRow(value.id,value.name,value.idNo);
                        });
                        var elems = Array.prototype.slice.call(document.querySelectorAll('.tb-switch'));
                        elems.forEach(function(html) {
                           var switchery = new Switchery(html);
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
               //add row to table
               function addRow(id,stdname,idNo) {
                  var table = document.getElementById('studentList');
                  var rowCount = table.rows.length;
                  var row = table.insertRow(rowCount);


                  var cell2 = row.insertCell(0);
                  var regiNo = document.createElement("label");

                  regiNo.innerHTML=idNo;
                  cell2.appendChild(regiNo);
                  var hdregi = document.createElement("input");
                  hdregi.name="ids[]";
                  hdregi.value=id;
                  hdregi.type="hidden";
                  cell2.appendChild(hdregi);

                  var cell4 = row.insertCell(1);
                  var name = document.createElement("label");
                  name.innerHTML=stdname;
                  cell4.appendChild(name);

                  var cell5 = row.insertCell(2);
                  var chkbox = document.createElement("input");
                  chkbox.type = "checkbox";
                  chkbox.checked=false;
                  chkbox.className="js-switch tb-switch";
                  chkbox.name="present["+id+"]";
                  chkbox.size="3";
                  cell5.appendChild(chkbox);
               };
               //make all checkbox checked
               $('.allCheck').on('change',function() {
                  $('.tb-switch').trigger('click');
               });
               //experimental code



            });

            </script>
            @endsection

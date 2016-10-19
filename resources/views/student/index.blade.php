@extends('layouts.master')

@section('title', 'Students')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">

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
                    <h2>Students<small> All Students information.</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">

                        <form class="" method="POST" action="{{URL::route('student.department')}}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="col-md-8 col-sm-12 col-xs-12">
                        <label for="department_id">Department *:</label>
                        {!!Form::select('department_id', $departments, $selectDep, ['placeholder' => 'Pick a department','class'=>'select2_single form-control has-feedback-left','tabindex'=>'-1','id'=>'department_id']) !!}
                        <i class="fa fa-home form-control-feedback left" aria-hidden="true"></i>
                          <span id="msg_department_id" class="text-danger" ></span>
                        </div>
                          <div class="col-md-4 col-sm-12 col-xs-12">
                              <br>
                            <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-check"></i> Go </button>
                          </div>
                        </form>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Photo</th>
                          <th>Name</th>
                          <th>ID No</th>
                          <th>Session</th>
                          <th>BNC Reg.</th>
                          <th>Batch No</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($students as $student)
                        <tr>
                          <td>

                              <img src="{{URL::asset('assets/images/students')}}/{{$student->photo}}" alt="{{$student->photo}}" class="" width="80px" height="70px">

                        </td>
                          <td>{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</td>
                          <td>{{$student->idNo}}</td>
                          <td>{{$student->session}}</td>
                          <td>{{$student->bncReg}}</td>
                          <td>{{$student->batchNo}}</td>
                          <td>
                         <a title='View' class='btn btn-success btn-xs btnUpdate' href='{{URL::route('student.show',$student->id)}}'> <i class="glyphicon glyphicon-zoom-out icon-white"></i></a>
                         <a title='Update' class='btn btn-info btn-xs btnUpdate' id='{{$student->id}}' href='{{URL::route('student.edit',$student->id)}}'> <i class="glyphicon glyphicon-check icon-white"></i></a>
                         <form class="deleteForm" method="POST" action="{{URL::route('student.destroy',$student->id)}}">
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

   <script>

     $(document).ready(function() {
       $(".select2_single").select2({
           placeholder: "Select Department",
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
          text: 'There are no student in this department!',
          styling: 'bootstrap3'
    });
    @endif
   });
   </script>
   <!-- /validator -->
@endsection

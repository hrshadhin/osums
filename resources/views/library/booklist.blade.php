@extends('layouts.master')

@section('title', 'Books')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
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
            <h2>Books<small> Department books information.</small></h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-md-12">

                <form role="form" action="/library/view" method="get" enctype="multipart/form-data">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="control-label" for="class">Department</label>

                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                        {!! Form::select('department',$departments,$department,['class'=>'form-control select2_single','required'=>'true']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="">&nbsp;</label>
                    <div class="input-group">
                      <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-th"></i>Get List</button>
                    </div>
                  </div>

                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">

                <table id="datatable-buttons" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Code/ISBN No</th>
                      <th>Title</th>
                      <th>Author</th>
                      <th>Department</th>
                      <th>Type </th>
                      <th>Quantity</th>
                      <th>Rack No</th>
                      <th>Row No</th>
                      <th>Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($books as $book)
                    <tr>
                      <td>{{$book->code}}</td>
                      <td>{{$book->title}}</td>
                      <td>{{$book->author}}</td>
                      <td>{{$book->department}}</td>
                      <td>{{$book->type}}</td>
                      <td>{{$book->quantity}}</td>
                      <td>{{$book->rackNo}}</td>
                      <td>{{$book->rowNo}}</td>
                      <td>{{$book->desc}}</td>

                      <td>
                        <a title='Edit' class='btn btn-success' href='{{url("/library/edit")}}/{{$book->id}}'> <i class="glyphicon glyphicon-pencil icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/library/delete")}}/{{$book->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                      </td>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              {{$books->appends(array('department' => $department))->links()}}

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
              "bPaginate": false,
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

      });
      </script>
      <!-- /validator -->
      @endsection

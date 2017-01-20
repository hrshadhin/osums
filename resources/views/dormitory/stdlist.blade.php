@extends('layouts.master')

@section('title', 'Dormitory')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
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
						<h2>Dormitory<small> Student List</small></h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">
							<div class="col-md-12">

								<form role="form" action="/dormitory/assignstd/list" method="post" enctype="multipart/form-data">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="row">
										<div class="col-md-12">

											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="class">Dormitory</label>

													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
														{{ Form::select('dormitory',$dormitories,$dormitory,['class'=>'form-control','required'=>'true'])}}
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">

													<label class="control-label" for="">&nbsp;</label>
													<div class="input-group">
														<button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-th"></i>Get List</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<br>
								</form>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<table id="datatable-buttons" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Name</th>
											<th>Contact</th>
											<th>Department</th>
											<th>Id No</th>
											<th>Guardian's Contact</th>
											<th>Room No</th>
											<th>Fee</th>
											<th>Joind Date</th>
											<th>Leave Date</th>
											<th>Is Active</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($students as $student)
										<tr>
											<td>{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</td>
											<td>{{$student->mobileNo}}</td>
											<td>{{$student->department}}</td>
											<td>{{$student->idNo}}</td>
											<td>{{$student->fatherMobileNo}}<br>{{$student->motherMobileNo}}<br>{{$student->localGuardianMobileNo}}</td>
											<td>{{$student->roomNo}}</td>
											<td>{{$student->monthlyFee}}</td>
											<td>{{date('M,j Y',strtotime($student->joinDate))}}</td>
											<td>@if($student->leaveDate){{date('M,j Y',strtotime($student->leaveDate))}}@endif</td>
											<td>{{$student->isActive}}</td>
											<td>
												<a title='Edit' class='btn btn-info' href='{{url("/dormitory/assignstd/edit")}}/{{$student->id}}'> <i class="glyphicon glyphicon-edit icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/dormitory/assignstd/delete")}}/{{$student->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
											</td>
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

			<script>

			$(document).ready(function() {

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

			});
			</script>
			@endsection

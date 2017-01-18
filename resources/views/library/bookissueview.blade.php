@extends('layouts.master')
@section('title', 'Borrow Book')
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
						<h2>Books<small> Borrow book list</small></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">
							<div class="col-md-12">
								<form role="form" action="/library/issuebookview" method="post" enctype="multipart/form-data">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<span class="text-danger">[*] Fill at least one feild from first 3 feilds or just select status and get list</span>
									<div class="row">
										<div class="col-md-12">
											<!--
											<div class="col-md-2">
											<div class="form-group">
											<label for="name">Student Regi No</label>
											<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
											<input type="text" class="form-control"  name="regiNo" placeholder="Student registration No">
										</div>
									</div>
								</div>
							-->
							<div class="col-md-2">
								<div class="form-group">
									<label for="name">Book Code/ISBN No</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
										<input type="text" class="form-control"  name="code" placeholder="Book Code">
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group ">
									<label for="idate">Issue Date</label>
									<div class="input-group">

										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
										<input type="text"   class="form-control datepicker" name="issueDate"   data-date-format="dd/mm/yyyy">
									</div>


								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group ">
									<label for="rdate">Return Date</label>
									<div class="input-group">

										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
										<input type="text"   class="form-control datepicker" name="returnDate"   data-date-format="dd/mm/yyyy">
									</div>


								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group ">
									<label for="idate">Status</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
										{!!Form::select('status', ["" => "Select Status" , "Borrowed" => "Borrowed", "Returned" => "Returned"], $status, ['class'=>'form-control','required'=>'required'])!!}
									</div>


								</div>
							</div>
							<div class="col-md-2">
								<label for="">&nbsp;</label>
								<div class="input-group">
									<button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-th"></i>Get List</button>
								</div>
							</div>

						</div>
					</div>
				</form>
				<div class="row">
					<div class="col-md-12">
						<table id="booklist" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>

									<th>Student Name</th>
									<th>Code/ISBN No</th>
									<th>Quantity</th>
									<th>Issue Date</th>
									<th>Return Date</th>
									<th>Fine</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($books))
								@foreach($books as $book)
								<tr>
									<td>{{$book->firstName}} {{$book->middleName}} {{$book->lastName}}</td>
									<td>{{$book->code}}</td>
									<td>{{$book->quantity}}</td>
									<td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$book->issueDate)->format('d/m/Y')}}</td>
									<td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$book->returnDate)->format('d/m/Y')}}</td>
									<td>{{$book->fine}}</td>
									<td>
										@if($book->status=='Borrowed')
										<a title='Edit' class='btn btn-success' href='{{url("/library/issuebookupdate")}}/{{$book->id}}'> <i class="glyphicon glyphicon-pencil icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/library/issuebookdelete")}}/{{$book->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
										@endif
									</td>
									@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
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
<script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/daterangepicker.js')}}"></script>
<script>
$(document).ready(function () {
	$('.datepicker').daterangepicker({
		 singleDatePicker: true,
		 calender_style: "picker_1",
		 format:'DD/MM/YYYY'
	});
});
</script>
@endsection

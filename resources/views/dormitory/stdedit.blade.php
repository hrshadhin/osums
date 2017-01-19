@extends('layouts.master')
@section('title', 'Dormitory')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
<style media="screen">
.select2-selection__rendered{
	margin-left: 2px !important;
	padding-left: 2px !important;
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
						<h2>Dormitory <small> Student info update</small></h2>
						<div class="clearfix"></div>
					</div>

					<div class="box-content">
						@if(isset($student))
						<form role="form" action="/dormitory/assignstd/update" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" value="{{ $student->id }}">

							<div class="row">
								<div class="col-md-12">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label" for="dormitory">Dormitory</label>

											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
												{{ Form::select('dormitory',$dormitories,$student->dormitory,['class'=>'form-control','required'=>'true'])}}
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label" for="roomNo">Room No.</label>

											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
												<input type="text"  name="roomNo" class="form-control" required="true" value="{{$student->roomNo}}" />

											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label" for="monthlyFee">Monthly Fee</label>

											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
												<input type="text"  name="monthlyFee" class="form-control" required="true" value="{{$student->monthlyFee}}" />

											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-2">
										<div class="form-group ">
											<label for="leaveDate">Leave Date</label>
											<div class="input-group">

												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
												<input type="text"   class="form-control datepicker" name="leaveDate"   data-date-format="yyyy-mm-dd">
											</div>


										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group">
											<label class="control-label" for="isActive">Is Active</label>

											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>

												{{ Form::select('isActive',['Yes'=>'Yes','No'=>'No'],$student->isActive,['class'=>'form-control','required'=>'true'])}}

											</div>
										</div>
									</div>
								</div>
							</div>
							<!--button save -->
							<div class="row">
								<div class="col-md-12">

									<button class="btn btn-primary pull-right" id="btnsave" type="submit"><i class="glyphicon glyphicon-refresh"></i> Update</button>
								</div>
							</div>
						</form>
						@else
						<div class="alert alert-danger">
							<strong>Whoops!</strong>There is no such Student!<br><br>

						</div>
						@endif
					</div>
				</div>
			</div>

			<!-- /page content -->
			@endsection
			@section('extrascript')
			<script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
			<script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
			<script src="{{ URL::asset('assets/js/daterangepicker.js')}}"></script>
			<script>

			$( document ).ready(function() {
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
						new PNotify({
							title: 'Validation Faild!',
							text: 'Fill up form correctly.',
							type: 'error',
							styling: 'bootstrap3'
						});
						submit = false;
					}

					if (submit){
						this.submit();
					}


					return false;
				});
				$('.datepicker').daterangepicker({
					singleDatePicker: true,
					calender_style: "picker_1",
					format:'DD/MM/YYYY'
				});
			});
			</script>
			@endsection

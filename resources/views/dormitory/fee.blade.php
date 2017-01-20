@extends('layouts.master')
@section('title', 'Dormitory')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
<style media="screen">
.select2-selection__rendered{
	margin-left: 2px !important;
	padding-left: 2px !important;
}
.table-condensed thead tr:nth-child(2),
.table-condensed tbody {
	display: none
}
.daterangepicker select.yearselect {
	width: 55% !important;
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
						<h2>Dormitory <small> Fee Collection</small></h2>
						<div class="clearfix"></div>
					</div>

					<div class="box-content">
						<div class="row">
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
						</div>
						<form role="form" action="/dormitory/fee" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label" for="dormitory">Dormitory</label>

														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
															{{ Form::select('dormitory',$dormitories,null,['class'=>'form-control','required'=>'true', 'id' => 'dormitory'])}}
															<span class="text-danger">{{ $errors->first('dormitory') }}</span>
														</div>
													</div>
												</div>


												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label" for="students">Student</label>

														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-user blue"></i></span>
															<select id="students" name="student" class="form-control" required="true">
																<option value="">--Select Student--</option>
															</select>
															<span class="text-danger">{{ $errors->first('student') }}</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-6">
													<div class="form-group ">
														<label for="month">Fee month</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
															<input type="text"   class="form-control datepicker" name="feeMonth" required>
															<span class="text-danger">{{ $errors->first('feeMonth') }}</span>
														</div>


													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label" for="amount">Fee Amount</label>

														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
															<input type="number"  name="feeAmount" class="form-control" required="true" placeholder="5000.00" />
															<span class="text-danger">{{ $errors->first('feeAmount') }}</span>

														</div>
													</div>
												</div>
											</div>
										</div>
										<!--button save -->
										<div class="row">
											<div class="col-md-12">

												<button class="btn btn-primary pull-right" id="btnsave" type="submit"><i class="glyphicon glyphicon-plus"></i>Save</button>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<div class="col-md-12">

												<div id="board" class="alert alert-info text-center">
													<h3 >Monthly Fees</h3>
													<strong><h2  class="yellow" id='mfee'>0.00 TK.</h2></strong>
													<h3 id="status" class="green">Status: Paid</h3>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>

						</div>
					</div>
				</form>


			</div>
		</div>
	</div>

	<!-- /page content -->
	@endsection
	@section('extrascript')
	<script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
	<script src="{{ URL::asset('assets/js/select2.full.min.js')}}"></script>
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
			showDropdowns: true,
			format: 'YYYY-MM'
		}).on('hide.daterangepicker', function (ev, picker) {
			$('.table-condensed tbody tr:nth-child(2) td').click();
		});

		$('#students').select2();
		$('#dormitory').select2();

		$('#btnsave').hide();
		$('#board').hide();

		$('#dormitory').on('change', function (e) {
			var val = $(e.target).val();
			$.ajax({
				url:'/dormitory/getstudents/'+val,
				type:'get',
				dataType: 'json',
				success: function( json ) {
					$('#students').empty();
					$('#students').append($('<option>').text("--Select Student--").attr('value',""));
					$.each(json, function(i, student) {
						// console.log(subject);

						$('#students').append($('<option>').text(student.name).attr('value', student.id));
					});

				}
			});
		});

		$('#students').on('change', function (e) {
			var val = $(e.target).val();
			$.ajax({
				url:'/dormitory/fee/info/'+val,
				type:'get',
				dataType: 'json',
				success: function( data ) {
					//console.log(data);
					$('#board').show();
					$('#mfee').text(data[0]);
					if(data[1]=="false")
					{
						$('#status').text('Status: Due');
						$('#status').removeClass();
						$('#status').addClass("text-danger");

					}
					if(data[1]=="true")
					{
						$('#status').text('Status: Paid');
						$('#status').removeClass();
						$('#status').addClass("text-success");

					}

					$('#btnsave').show();
				},
				error: function (respone) {
						$('#board').hide();
				}
			});
		});
	});
	</script>
	@endsection

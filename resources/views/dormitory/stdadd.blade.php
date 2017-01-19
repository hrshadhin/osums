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
						<h2>Dormitory <small> Add student</small></h2>
						<div class="clearfix"></div>
					</div>

					<div class="box-content">
						<form role="form" action="/dormitory/assignstd/create" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="row">
								<div class="col-md-12">

									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label" for="class">Department</label><span class="required">*</span>
												{!!Form::select('', $departments, null, ['placeholder' => 'Pick a department','class'=>'select2_single department form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required','id'=>'department_id'])!!}
												<span class="text-danger">{{ $errors->first('department_id') }}</span>
										</div>
									</div>
									<div class="col-md-2">
										<div class="item form-group">
											<label for="session">Session <span class="required">*</span>
											</label>

												{!!Form::select('', $sessions, null, ['placeholder' => 'Pick a Session','class'=>'select2_single session form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required' ,'id'=>'session'])!!}
												<span class="text-danger">{{ $errors->first('session') }}</span>
											 </div>
										</div>
										<div class="col-md-3">
											<div class="item form-group">
												 <label class="control-label" for="levelTerm">Semester <span class="required">*</span>
												 </label>

												 {!!Form::select('', $semesters, null, ['placeholder' => 'Pick a Semester','class'=>'select2_single semester form-control col-md-7 col-xs-12 has-feedback-left', 'id'=>'levelTerm','required'=>'required'])!!}
												 <span class="text-danger">{{ $errors->first('levelTerm') }}</span>

											</div>
										</div>
										<div class="col-md-3">
											<div class="item form-group">
												<label  for="students_id">Student <span class="required">*</span>
												</label>
													{!!Form::select('students_id',[], null, ['placeholder' => 'Pick a Student','class'=>'select2_single student','required'=>'required' ,'id'=>'students_id'])!!}
													<span class="text-danger">{{ $errors->first('students_id') }}</span>
											</div>
										</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="col-md-2">
										<div class="form-group ">
											<label for="joindate">Join Date</label> <span class="required">*</span>
												<input type="text" class="form-control datepicker" name="joinDate" required>
												<span class="text-danger">{{ $errors->first('joinDate') }}</span>

										</div>
									</div>
									<div class="col-md-1">
										<div class="form-group">
											<label class="control-label" for="isActive">Is Active</label> <span class="required">*</span>
												<select  name="isActive" class="form-control" required="true">
													<option value="Yes">Yes</option>
													<option value="No">No</option>
												</select>
												<span class="text-danger">{{ $errors->first('isActive') }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label" for="dormitory">Dormitory</label> <span class="required">*</span>
											{!!Form::select('dormitories_id',$dormitories, null, ['placeholder' => 'Pick a dormitory','class'=>'select2_single dormitory','required'=>'required' ,'id'=>'dormitories_id'])!!}
												<span class="text-danger">{{ $errors->first('dormitories_id') }}</span>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label class="control-label" for="roomNo">Room No.</label> <span class="required">*</span>

												<input type="text"  name="roomNo" class="form-control" required="true" placeholder="12" />
												<span class="text-danger">{{ $errors->first('roomNo') }}</span>

										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label" for="monthlyFee">Monthly Fee</label> <span class="required">*</span>

												<input type="number"  name="monthlyFee" class="form-control" required="true" placeholder="5000.00" />
												<span class="text-danger">{{ $errors->first('monthlyFee') }}</span>

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
					calender_style: "picker_1",
					format:'DD/MM/YYYY'
				},
				function(start,end){
					//console.log(start.format('DD/MM/YYYY'));
					$('#returnDate').val(start.format('DD/MM/YYYY'));
				});
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

				//get students lists
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
						$.ajax({
							url:'/students/'+dept+'/'+session+'/'+semester,
							type: 'get',
							dataType: 'json',
							success: function(data) {
								//console.log(data);
								$('#students_id').empty();
								$('#students_id').append('<option  value="">Pic a Student</option>');
								$.each(data.students.data, function(key, value) {
									$('#students_id').append('<option  value="'+value.id+'">'+value.name+'['+value.idNo+']</option>');

								});
								$(".student").select2({
									placeholder: "Pick a Student",
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

				$('select').select2();


			});
			</script>
			@endsection

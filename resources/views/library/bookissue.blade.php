@extends('layouts.master')
@section('title', 'Issuebook')
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
						<h2>Borrow Book <small> Book Issue Details</small></h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">
							<div class="col-md-12">
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
						</div>
						<form class="form-horizontal form-label-left" method="post" action="/library/issuebook" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="row">
								<div class="col-md-3">
									<div class="item form-group">
										<label for="department">Department <span class="required">*</span>
										</label>
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
									<div class="col-md-2">
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

												{!!Form::select('students_id', $students, null, ['placeholder' => 'Pick a Student','class'=>'select2_single student','required'=>'required' ,'id'=>'students_id'])!!}
												<span class="text-danger">{{ $errors->first('students_id') }}</span>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group ">
											<label for="idate">Issue Date</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
												<input class="form-control datepicker"  name="issueDate" required="required" />

											</div>
										</div>
									</div>
									</div>

								<hr class="hrclass">
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-6">
											<div class="form-group">
												<label for="name">Book Name/Author Name</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="glyphicon glyphicon-book blue"></i></span>
													{{ Form::select('',$books,null,['id' => 'bookCode','class'=>'form-control select2-list'])}}

												</div>
											</div>
										</div>
										<div class="col-md-1">
											<div class="form-group">
												<label class="control-label" for="rack">Quantity</label>

												<input type="text" id="quantity" class="form-control" placeholder="1">

											</div>

										</div>

										<div class="col-md-2">
											<div class="form-group ">
												<label for="rdate">Return Date</label>
												<div class="input-group">

													<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
													<input class="form-control datepicker" id="returnDate" value="" />

												</div>


											</div>
										</div>
										<div class="col-md-1">
											<div class="form-group">
												<label class="control-label" for="fine">Fine</label>
												<input type="text" id="fine" class="form-control" value="0.00"  placeholder="Fine Amount">

											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>&nbsp;</label>
												<div class="input-group">
													<button type="button" class="btn btn-primary" id="btnAddRow"  ><i class="glyphicon glyphicon-plus"></i></button>&nbsp;&nbsp;
													<button type="button" class="btn btn-danger" id="btnDeleteRow" ><i class="glyphicon glyphicon-trash"></i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr class="hrclass">
								<div class="row">
									<div class="col-md-12">
										<div class="table-responsive">
											<table id="bookList" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th>#</th>
														<th>Title</th>
														<th>Quantity</th>
														<th>Return</th>
														<th>Fine</th>

													</tr>
												</thead>
												<tbody>
													<tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">

												<button id="btnsave" class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i> Submit</button>

											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- row end -->
							<div class="clearfix"></div>

						</div>
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

					var btnSaveIsvisibale =function ()
					{
						var table = document.getElementById('bookList');
						var rowCount = table.rows.length;
						//console.log(rowCount);
						if(rowCount>1)
						{
							$('#btnsave').show();
						}
						else {
							$('#btnsave').hide();
						}
					};
					var addBook = function() {
						var table = document.getElementById('bookList');
						var rowCount = table.rows.length;
						var row = table.insertRow(rowCount);

						var cell1 = row.insertCell(0);
						var chkbox = document.createElement("input");
						chkbox.type = "checkbox";
						chkbox.checked=false;
						chkbox.name="sl[]";
						chkbox.size="3";
						cell1.appendChild(chkbox);

						var cell2 = row.insertCell(1);
						var title = document.createElement("label");
						title.innerHTML=$('#bookCode option:selected').text();
						cell2.appendChild(title);
						var bookCode = document.createElement("input");
						bookCode.name="bookCode[]";
						bookCode.value=$('#bookCode option:selected').val();
						bookCode.type="hidden";
						cell2.appendChild(bookCode);


						var cell3 = row.insertCell(2);
						var quantity = document.createElement("label");
						quantity.innerHTML=$('#quantity').val();
						cell3.appendChild(quantity);
						var hquantity = document.createElement("input");
						hquantity.name="quantity[]";
						hquantity.value=$('#quantity').val();
						hquantity.type="hidden";
						cell3.appendChild(hquantity);

						var cell4 = row.insertCell(3);
						var returnDate = document.createElement("label");
						returnDate.innerHTML=$('#returnDate').val();
						cell4.appendChild(returnDate);
						var hreturnDate = document.createElement("input");
						hreturnDate.name="returnDate[]";
						hreturnDate.value=$('#returnDate').val();
						hreturnDate.type="hidden";
						cell4.appendChild(hreturnDate);

						var cell5 = row.insertCell(4);
						var fine = document.createElement("label");
						fine.innerHTML=$('#fine').val();
						cell5.appendChild(fine);
						var hfine = document.createElement("input");
						hfine.name="fine[]";
						hfine.value=$('#fine').val();
						hfine.type="hidden";
						cell5.appendChild(hfine);

						btnSaveIsvisibale();
						$('select#bookCode').select2().select2("val", '');
						$('#quantity').val('');
						//$('#returnDate').val('');
						$('#fine').val('0.0');

					};
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

						<!-- /validator -->

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
						btnSaveIsvisibale();
						$('select').select2();
						//add fee to grid
						$( "#btnAddRow" ).click(function() {
							if(!$('#bookCode').val() ||
							!$('#quantity').val() ||
							!$('#returnDate').val() ||
							!$('#fine').val())
							{
								alert('Please select book,quanty,return date first!!!');
								return false;
							}
							$.ajax({
								url: '/library/issuebook-availabe/'+$('#bookCode').val()+'/'+$('#quantity').val(),
								data: {
									format: 'json'
								},
								error: function(error) {
									console.log(error);
									alert(error);
								},
								dataType: 'json',
								success: function(data) {
									//console.log(data);
									if(data.isAvailable==="Yes"){
										addBook();
									}
									else {
										alert('Book Quantity Not Available!');
									}

								},
								type: 'GET'
							});

						});
						//remove fee to grid
						$( "#btnDeleteRow" ).click(function() {
							try {
								var table = document.getElementById("bookList");

								var rowCount = table.rows.length;

								for(var i=0; i<rowCount; i++) {
									var row = table.rows[i];
									var chkbox = row.getElementsByTagName('input')[0];
									//  console.log(chkbox);
									if(null != chkbox && true == chkbox.checked) {
										table.deleteRow(i);
										rowCount--;
										i--;

									}
								}
								btnSaveIsvisibale();
							}catch(e) {
								alert(e);
							}
						});

					});
					</script>
					@endsection

@extends('layouts.master')

@section('title', 'Library')

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
						<h2>Library<small> Books report</small></h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">
							<div class="col-md-12">
								<span class="text-danger">[*]Fill up any feilds and print. Don't fill up more than one feild at a time.</span>
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label" for="type">Type</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
													{{ Form::select('type',["-1"=>'--Select--','Academic'=>'Academic','Story'=>'Story','Magazine'=>'Magazine','Other'=>'Other'],null,['id'=>'type','class'=>'form-control'])}}
												</div>
											</div>
										</div>
										<div class="col-md-2">

											<div class="form-group">
												<label class="control-label" for="type">Today Return List</label>
												<br>
												<input type="checkbox" name="today" id="today">
											</div>
										</div>
										<div class="col-md-2">

											<div class="form-group">
												<label class="control-label" for="type">Expire List</label>
												<br>
												<input type="checkbox" id="expire" name="expire">
											</div>
										</div>
										<div class="col-md-2">
											<label for="">&nbsp;</label>
											<div class="input-group">
												<button class="btn btn-primary"  type="submit" id="btnPrint"><i class="glyphicon glyphicon-print"></i> Print</button>
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
		<script type="text/javascript">
		$( document ).ready(function() {

			$( "#btnPrint" ).click(function() {
				var type = $('#type').val();
				var today =  $('#today').is(':checked');
				var expire  = $('#expire').is(':checked');
				var getUrl = window.location;
				var baseUrl = getUrl .protocol + "//" + getUrl.host;
				var url =baseUrl+"/library/reportprint/";
				if(type!="-1") {
					url +=type;
					var win = window.open(url, '_blank');
					win.focus();

				}
				else if(today)
				{
					url +="today";
					var win = window.open(url, '_blank');
					win.focus();
				}
				else if(expire)
				{
					url +="expire";
					var win = window.open(url, '_blank');
					win.focus();
				}
				else
				{
					alert('Fill up inputs feilds correclty!!!');
				}
			});

		});

		</script>
		@endsection

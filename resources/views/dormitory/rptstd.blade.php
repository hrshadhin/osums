@extends('layouts.master')
@section('title', 'Dormitory')
@section('extrastyle')
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
						<h2>Dormitory <small> Student Report</small></h2>
						<div class="clearfix"></div>
					</div>

					<div class="box-content">
						<div class="row">
							<div class="col-md-12">

								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label" for="dormitory">Dormitory</label>

										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
											{{ Form::select('dormitory',$dormitories,null,['class'=>'form-control','required'=>'true', 'id' => 'dormitory'])}}

										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">

										<label class="control-label" for="">&nbsp;</label>
										<div class="input-group">
											<button class="btn btn-primary pull-right" id="btnPrint"><i class="glyphicon glyphicon-print"></i> Print List</button>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- /page content -->
@endsection
@section('extrascript')
<script src="{{ URL::asset('assets/js/select2.full.min.js')}}"></script>
<script>
$( document ).ready(function() {
	$('select').select2();
	$( "#btnPrint" ).click(function() {
		var type = $('#dormitory').val();
		var getUrl = window.location;
		var baseUrl = getUrl .protocol + "//" + getUrl.host;
		var url =baseUrl+"/dormitory/report/std/";
		if(type!="-1") {
			url +=type;
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

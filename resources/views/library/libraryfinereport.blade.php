@extends('layouts.master')

@section('title', 'Library-Fine-Report')
@section('extrastyle')
<style media="screen">
.table-condensed thead tr:nth-child(2),
.table-condensed tbody {
	display: none
}
.daterangepicker select.yearselect {
    width: 55%;
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
						<h2>Library<small>Monthly Fine Report</small></h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">
							<div class="col-md-12">


								<div class="col-md-4">
									<div class="form-group ">
										<label for="month">Fine month</label>
										<div class="input-group">

											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
											<input type="text"   class="form-control datepicker" id="fineMonth" required  data-date-format="yyyy-mm-dd">
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
		$( document ).ready(function() {

			$('.datepicker').daterangepicker({
				singleDatePicker: true,
				showDropdowns: true,
				format: 'YYYY-MM'
			}).on('hide.daterangepicker', function (ev, picker) {
				$('.table-condensed tbody tr:nth-child(2) td').click();
			});
			$( "#btnPrint" ).click(function() {

				var month =  $('#fineMonth').val();
				var getUrl = window.location;
				var baseUrl = getUrl .protocol + "//" + getUrl.host;
				var url =baseUrl+"/library/reports/fine/";
				if(month !="" ) {
					url +=month;
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

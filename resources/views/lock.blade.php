<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
	<!-- Endless -->
		<link href="{{ URL::asset('assets/css/endless.css')}}" rel="stylesheet">
     <style>
     .input-group-btn>.btn {
       position: absolute;
    }
    </style>
  </head>

  <body style="background-color: rgb(58, 58, 58);" class=" pace-done"><div class="pace  pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
  <div class="pace-progress-inner"></div>
</div>
<div class="pace-activity"></div></div>
	<!--Modal-->
		<div class="modal fade lock-screen-wrapper in" id="lockScreen" aria-hidden="false">
  			<div class="modal-dialog">
    			<div class="modal-content">
				    <div class="modal-body">
						<div class="lock-screen-img">
							<img src="/assets/images/users/user.png" alt="">
						</div>

						<div class="text-center m-top-sm">
							<div class="h4 text-white">{{$user->firstName}} {{$user->lastName}}</div>

							<div class="input-group m-top-sm">
                <form name="login" method="post" action="{{URL::route('user.login')}}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="login" value="{{$user->login}}">
								<input type="password" class="form-control text-sm" autofocus placeholder="Enter your password" name="password">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-success" type="button" href="">
										<i class="fa fa-arrow-right"></i>
									</button>
                </form>
								</span>
							</div>
						</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<script src="{{ URL::asset('assets/js/jquery.min.js')}}"></script>
		<script src="{{ URL::asset('assets/js/bootstrap.min.js')}}"></script>

	<script>
		$(function()	{
			$('#lockScreen').modal({
				show: true,
				backdrop: 'static'
			})
		});
	</script>


<div class="modal-backdrop fade in"></div>
</body></html>

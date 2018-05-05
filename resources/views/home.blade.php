<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{AppHelper::getShortName($institute->name)}} | Home </title>

    <!-- Bootstrap -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ URL::asset('assets/css/animate.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
		<link href="{{ URL::asset('assets/css/custom.min.css')}}" rel="stylesheet">
  </head>

  <body class="login">
    <div>


      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form name="login" method="post" action="{{URL::route('user.login')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
              <h1>Login </h1>
              <div>
                <input type="text" class="form-control" name="login" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>
              <div>
								<button type="submit" class="btn btn-primary btn-lg">Login <i class="fa fa-2x fa-sign-in"></i></button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
	              @if (Session::has('success'))
	                <div class="alert alert-success">
	                    {{ Session::get('success') }}
	                </div>
	              @endif
	              @if (Session::has('error'))
	                <div class="alert alert-danger">
	                    {{ Session::get('error') }}
	                </div>
	              @endif
	              @if (Session::has('warning'))
	              <div class="alert alert-warning">
	                  {{ Session::get('warning') }}
	              </div>
	              @endif

                <div class="clearfix"></div>
                <br />

                <div>
                  <h2 style="font-size:16px;"><i class="fa fa-bank"></i> {{$institute->name}}</h2>
                  <p>©{{date('Y')}} All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>


      </div>
    </div>
  </body>
</html>

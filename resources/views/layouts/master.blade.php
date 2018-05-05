<!-- <!DOCTYPE html> -->
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>{{session('inNameShort')}} - @yield("title")</title>
    <!-- Bootstrap -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/nprogress.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/pnotify.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/pnotify.buttons.css')}}" rel="stylesheet">
    <!-- Custom Theme Style -->
		<link href="{{ URL::asset('assets/css/custom.min.css')}}" rel="stylesheet">
		<link href="{{ URL::asset('assets/css/app.css')}}" rel="stylesheet">
    @yield("extrastyle")
    <script>
      var hash = '{{session('user_session_sha1')}}';
    </script>
  </head>

  <body class="nav-md footer_fixed">

<div class="container body">
      <div class="main_container">

<div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">

<div class="navbar nav_title" style="border: 0;">
              <a href="{{URL::route('user.dashboard')}}" class="site_title"><i class="fa fa-bank"></i> <span> {{session('inNameShort')}}</span></a>
            </div>

            <div class="clearfix"></div>


            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Primary Menu</h3>
                <ul class="nav side-menu">
                  @can('Admin')
                  <li><a><i class="fa fa-home"></i> Departments <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::route('department.create')}}">Add New</a></li>
                      <li><a href="{{URL::route('department.index')}}">All Departments</a></li>

                    </ul>
                  </li>
                  <li><a><i class="fa fa-book"></i> Subjects <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::route('subject.create')}}">Add New</a></li>
                      <li><a href="{{URL::route('subject.index')}}">All Subjects</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-users"></i> Students <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::route('student.create')}}">New Admission</a></li>
                      <li><a href="{{URL::route('student.index')}}">Admited Student List</a></li>
                      <li><a href="{{URL::route('student.registration.create')}}">New Registration</a></li>
                      <li><a href="{{URL::route('student.registration.index')}}">Registered Student List</a></li>
                      </ul>
                  </li>
                  @endcan
                  @if(Gate::check('Admin') || Gate::check('Teacher'))
                  <li><a><i class="fa fa-pencil"></i> Attendance <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::route('attendance.create')}}">New </a></li>
                      <li><a href="{{URL::route('attendance.index')}}">List</a></li>
                      </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Exams <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::route('exam.create')}}">New </a></li>
                      <li><a href="{{URL::route('exam.index')}}">List</a></li>
                      </ul>
                  </li>
                  <li><a><i class="fa fa-file-text"></i> Result <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::route('result.subject')}}"> Subject Wise </a></li>
                      <li><a href="{{URL::route('result.individual')}}">Student Wise</a></li>
                      </ul>
                  </li>
                  @endif
                  @if(Gate::check('Admin') || Gate::check('Account'))
                  <li><a><i class="fa fa-money"></i> Accounting <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::route('accounting.sector.index')}}">Sector </a></li>
                      <li><a href="{{URL::route('accounting.income.index')}}">Income </a></li>
                      <li><a href="{{URL::route('accounting.expence.index')}}">Expence </a></li>
                      </ul>
                  </li>
                  <li><a><i class="glyphicon glyphicon-list-alt"></i> Fees <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::route('fees.index')}}">Fee List </a></li>
                      <li><a href="{{URL::route('fees.collection.create')}}">Fee Collection </a></li>
                      </ul>
                  </li>
                  <li><a><i class="fa fa-print"></i> Reports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::route('accounting.reports.type')}}">Account By Type </a></li>
                      <li><a href="{{URL::route('accounting.reports.balance')}}">Account Balance </a></li>
                      <li><a href="{{URL::route('fees.collection.index')}}">Student Fees </a></li>
                      <li><a href="{{URL::route('fees.collection.report')}}">Fees Collection </a></li>

                      </ul>
                  </li>
                  @endif
                  @can('Admin')
                  <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::route('user.create')}}">New</a></li>
                      <li><a href="{{URL::route('user.index')}}">All User</a></li>
                    </ul>
                  </li>
                  <li><a  href="{{URL::route('institute.index')}}"><i class="fa fa-building" ></i> Institute </a>

                  </li>
                  @endcan
                </ul>
              </div>
              <div class="menu_section">
                <h3></h3>

              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a href="{{URL::route('user.settings')}}" data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a class="fullScreen" data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a href="{{URL::route('lock')}}" data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a href="{{URL::route('user.logout')}}" data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    	<img src="/assets/images/users/user.png" alt="">{{Session::get('name')}}
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu">
                  <li>
                    <a href="{{URL::route('user.settings')}}"><i class="glyphicon glyphicon-cog"></i> Settings</a>
                  </li>
                  <li>
                    <a class="fullScreen">
                      <i class="glyphicon glyphicon-fullscreen"></i> Full Screen
                    </a>
                  </li>
                  <li>
                    <a href="{{URL::route('lock')}}"><i class="glyphicon  glyphicon-eye-close"></i> Lock Screen</a>
                  </li>
                  <li><a href="{{URL::route('user.logout')}}"><i class="glyphicon glyphicon-off"></i> Log Out</a></li>
                </ul>
              </li>
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <span class=" fa fa-book"></span> Library
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu">

                  <li><a href="/library/search"><i class="glyphicon glyphicon-search"></i> Book Search</a></li>
                  <li><a href="/library/issuebook"><i class="glyphicon glyphicon-pencil"></i> Borrow Book</a></li>
                  <li><a href="/library/issuebookview"><i class="glyphicon glyphicon-list"></i> Borrowd Book List</a></li>
                  <li class="divider"></li>
                  <li><a href="/library/view"><i class="glyphicon glyphicon-list"></i> Book List</a></li>
                  <li><a href="/library/addbook"><i class="glyphicon glyphicon-pencil"></i> Book Entry</a></li>
                  <li class="divider"></li>
                  <li><a href="/barcode"><i class="fa fa-barcode"></i> Barcode Generate</a></li>
                  <li class="divider"></li>
                  <li><a href="/library/reports"><i class="glyphicon glyphicon-print"></i> Reports</a></li>
                  <li><a href="/library/reports/fine"><i class="glyphicon glyphicon-print"></i> Monthly Fine Reports</a></li>
                </ul>
              </li>
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <span class=" fa fa-home"></span> Dormitory
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="/dormitory"><i class="glyphicon glyphicon-home"></i> Dormitory</a></li>
                  <li><a href="/dormitory/assignstd"><i class="glyphicon glyphicon-plus"></i> Assign Student</a></li>
                  <li><a href="/dormitory/assignstd/list"><i class="glyphicon glyphicon-user"></i> Student List</a></li>
                  <li class="divider"></li>
                  <li><a href="/dormitory/fee"><i class="glyphicon glyphicon-list"></i> Fee Collection</a></li>
                  <li><a href="/dormitory/report/std"><i class="glyphicon glyphicon-print"></i> Dormitory Report</a></li>
                  <li><a href="/dormitory/report/fee"><i class="glyphicon glyphicon-print"></i> Fee Reports</a></li>
                </ul>
              </li>
          </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

  <!--Child Page Content Start  -->

  @yield('content')

  <!--Child Page Content End  -->

@include('layouts.footer')

<!-- jQuery -->
<script src="{{ URL::asset('assets/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{ URL::asset('assets/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ URL::asset('assets/js/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{ URL::asset('assets/js/nprogress.js')}}"></script>

<script src="{{ URL::asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>

<script src="{{ URL::asset('assets/js/pnotify.js')}}"></script>
<script src="{{ URL::asset('assets/js/pnotify.buttons.js')}}"></script>

@yield("extrascript")
<!-- Custom Theme Scripts -->
<script src="{{ URL::asset('assets/js/custom.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/app.js')}}"></script>

<!-- PNotify -->
  <script>
    $(document).ready(function() {
      @if(Session::has('success'))
      new PNotify({
            title: '{{Session::get("success")["title"]}}',
            text: '{{Session::get("success")["body"]}}',
            type: 'success',
            styling: 'bootstrap3'
      });
      @endif
      @if(Session::has('error'))
      new PNotify({
            title: '{{Session::get("error")["title"]}}',
            text: '{{Session::get("error")["body"]}}',
            type: 'error',
            styling: 'bootstrap3'
      });
      @endif
      @if(Session::has('warning'))
      new PNotify({
            title: '{{Session::get("warning")["title"]}}',
            text: '{{Session::get("warning")["body"]}}',
            styling: 'bootstrap3'
      });
      @endif

    });
  </script>
  <!-- /PNotify -->

</body>
</html>
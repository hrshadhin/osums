@extends('layouts.master')

@section('title', 'User')

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
                    <h2>User<small> User basic information.</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form class="form-horizontal form-label-left" novalidate method="post" action="{{URL::route('user.store')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                              <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label" for="firstname">First Name <span class="required">*</span>
                              </label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-info blue"></i></span>
                                  <input id="name" type="text" class="form-control"  name="firstname" value="" placeholder="First Name" required="required" type="text">
                              </div>
                              <span class="text-danger">{{ $errors->first('firstname') }}</span>

                            </div>
                          </div>
                              <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label" for="lastname">Last Name <span class="required">*</span>
                              </label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-info blue"></i></span>
                                  <input id="name" type="text" class="form-control"  name="lastname" value="" placeholder="Last Name" required="required" type="text">
                              </div>
                              <span class="text-danger">{{ $errors->first('lastname') }}</span>

                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label" for="login">User Name<span class="required">*</span>
                              </label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-info blue"></i></span>
                                <input type="text" class="form-control"  name="login" value="" placeholder="admin33" required="required">
                              </div>
                              <span class="text-danger">{{ $errors->first('login') }}</span>

                            </div>
                          </div>
                        </div>
                          <div class="row">
                            <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label" for="group">Group<span class="required">*</span>
                              </label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-info blue"></i></span>
                                <select class="form-control"  name="group" required="required">
                                  <option value="Admin">Admin</option>
                                  <option value="Teacher">Teacher</option>
                                  <option value="Account">Account</option>
                                </select>
                              </div>
                              <span class="text-danger">{{ $errors->first('group') }}</span>

                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label" for="email">Email
                              </label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope blue"></i></span>
                                <input type="text" id="email" name="email" placeholder="xxx@domain.com" value="" class="form-control">
                              </div>
                              <span class="text-danger">{{ $errors->first('email') }}</span>

                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label" for="description">Description
                              </label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-info blue"></i></span>
                                <textarea id="description" name="description" class="form-control col-md-7 col-xs-12"></textarea>
                              </div>
                              <span class="text-danger">{{ $errors->first('description') }}</span>

                            </div>
                          </div>
                        </div>

                            <div class="row">
                            <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label" for="password">Password<span class="required">*</span>
                              </label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key blue"></i></span>
                                <input id="name" class="form-control"  name="password" value="" type="password">
                              </div>
                              <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label" for="confirmpassword">Confirm Password<span class="required">*</span>
                              </label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key blue"></i></span>
                                <input type="password" class="form-control"  name="password_confirmation" value="" required="required">
                              </div>
                              <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus"> Save</i></button>
                        </div>
                      </form>
                  </div>
                </div>
              <!-- row end -->
              <div class="clearfix"></div>

          </div>
        </div>
        <!-- /page content -->
@endsection

@extends('layouts.master')

@section('title', 'Barcode')

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
                <h2>Barcode<small> Barcode Generate</small></h2>

                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                      @if (Session::get('success'))
                          <div class="alert alert-success">
                              <button data-dismiss="alert" class="close" type="button">×</button>
                              <strong>Process Success.</strong> {{ Session::get('success')}}

                          </div>
                      @endif
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
                  <form role="form" action="/barcode" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">

                      <div class="row">
                          <div class="col-md-12">

                                  <div class="form-group">
                                      <label for="gpa">Code Starting Number</label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                          <input type="text" class="form-control" required name="code"  placeholder="5833100001">
                                      </div>
                                  </div>


                          </div>
                      </div>


                      <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-print"></i> Generate</button>
                      <br><br>
                  </form>
           </div>
            </div>
          <!-- row end -->
          <div class="clearfix"></div>

      </div>
    </div>
    <!-- /page content -->
@endsection

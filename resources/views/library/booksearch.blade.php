
@extends('layouts.master')

@section('title', 'Subject')

@section('extraStyle')
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
                        <h2>Book<small> Search</small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @if (count($errors) > 0)
                        <div class="row">
                            <div class="col-md-12">

                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" action="/library/search" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <span class="text-danger">[*]Fill up any feilds and search </span>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Code/ISBN No</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                        <input type="text" class="form-control" value="{{$inputs['code']}}"  name="code" placeholder="Book Code">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Title/Name</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                        <input type="text" class="form-control" value="{{$inputs['title']}}"  name="title" placeholder="Book Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="author">Author</label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                                        <input type="text" class="form-control" value="{{$inputs['author']}}" name="author" placeholder="Writer Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">&nbsp;</label>
                                                <div class="input-group">
                                                    <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-search"></i> Search</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                                <form role="form" action="/library/search2" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <span class="text-danger">[*]Fill up both feilds and search </span>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label" for="type">Type</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                                        {{ Form::select('type',['Academic'=>'Academic','Story'=>'Story','Magazine'=>'Magazine','Other'=>'Other'],$inputs['type'],['class'=>'form-control'])}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label" for="class">Department</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                        {!! Form::select('department',$departments,$inputs['department'],['class'=>'form-control select2_single','required'=>'true']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">&nbsp;</label>
                                                <div class="input-group">
                                                    <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-search"></i> Search</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <br>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table id="bookList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Code/ISBN No</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Department</th>
                                            <th>Type </th>
                                            <th>Quantity </th>
                                            <th>Rack No</th>
                                            <th>Row No</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($books))
                                        @foreach($books as $book)
                                        <tr>
                                            <td>{{$book->code}}</td>
                                            <td>{{$book->title}}</td>
                                            <td>{{$book->author}}</td>
                                            <td>{{$book->name}}</td>
                                            <td>{{$book->type}}</td>
                                            <td>{{$book->quantity}}</td>
                                            <td>{{$book->rackNo}}</td>
                                            <td>{{$book->rowNo}}</td>
                                            <td>
                                                <a title='Update Quantity' class='btn btn-success' href='{{url("/library/edit")}}/{{$book->id}}'> <i class="glyphicon glyphicon-pencil icon-white"></i></a>
                                            </td>
                                        </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>

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
            <script>

            </script>
            @endsection

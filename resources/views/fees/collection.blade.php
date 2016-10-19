@extends('layouts.master')

@section('title', 'Fee-Collection')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/switchery.min.css')}}" rel="stylesheet">
<style>
td:first-child,th:first-child{
   width: 6%;
}

td { text-align:center; }
th { text-align:center; }
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
               <form id="collectionForm" class="form-horizontal form-label-left custom-error" novalidate method="post" action="{{URL::route('fees.collection.store')}}">

                  <div class="x_title">
                     <h2>Fee<small> Student Fee Collection </small></h2>
                     <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
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
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <div class="row">
                        <div class="col-md-5">
                           <div class="item form-group">
                              <label class="control-label " for="department">Department <span class="required">*</span>
                              </label>

                              {!!Form::select('department_id', $departments, null, ['placeholder' => 'Pick a department','class'=>'select2_single department form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required','id'=>'department_id'])!!}
                    <i class="fa fa-home form-control-feedback left" aria-hidden="true"></i>
                  <span class="text-danger">{{ $errors->first('department_id') }}</span>

                           </div>
                        </div>

                        <div class="col-md-2">
                           <div class="item form-group">
                              <label class="control-label" for="session">Session <span class="required">*</span>
                              </label>
                              {!!Form::select('session', $sessions, null, ['placeholder' => 'Pick a Session','class'=>'select2_single session form-control col-md-7 col-xs-12 has-feedback-left','required'=>'required' ,'id'=>'session'])!!}
                            <i class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></i>
                              <span class="text-danger">{{ $errors->first('session') }}</span>

                           </div>
                        </div>
                        <div class="col-md-5">
                           <div class="item form-group">
                              <label class="control-label" for="levelTerm">Semester <span class="required">*</span>
                              </label>

                              {!!Form::select('levelTerm', $semesters, null, ['placeholder' => 'Pick a Semester','class'=>'select2_single semester form-control col-md-7 col-xs-12 has-feedback-left', 'id'=>'levelTerm','required'=>'required'])!!}
                              <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                              <span class="text-danger">{{ $errors->first('levelTerm') }}</span>

                           </div>
                        </div>

                     </div>
                     <div class="row">

                        <div class="col-md-2">
                           <div class="item form-group">
                              <label class="control-label" for="payDate">Date <span class="required">*</span>
                              </label>
                              <input class="form-control" id="collectionDate" name="payDate" value="{{$today->format('d/m/Y')}}" required="required" />
                              <span class="text-danger">{{ $errors->first('payDate') }}</span>

                           </div>
                        </div>
                        <div class="col-md-5">
                           <div class="item form-group">
                              <label class="control-label" for="students_id">Student <span class="required">*</span>
                              </label>
                              {!!Form::select('students_id',$students, null, ['placeholder' => 'Pick a Student','class'=>'select2_single student form-control has-feedback-left','required'=>'required' ,'id'=>'students_id'])!!}
                              <i class="fa fa-user form-control-feedback left" aria-hidden="true"></i>
                              <span class="text-danger">{{ $errors->first('students_id') }}</span>

                           </div>
                        </div>

                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="item form-group">
                              <label class="control-label" for="feeNames">Fee Name <span class="required">*</span>
                              </label>
                              <select name="feeNames" id="feeNames" class="fees form-control">
                                 <option value="">Pic a fee </option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="feeAmount">Fee</label> <span class="required">*</span>
                              <input id="feeAmount" type="text" class="form-control" readonly="true"  name="feeAmount" placeholder="0.00">

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label>&nbsp;</label>
                              <div class="input-group">
                                 <button type="button" class="btn btn-primary" id="btnAddRow"  ><i class="glyphicon glyphicon-plus"></i></button>&nbsp;&nbsp;
                                 <button type="button" class="btn btn-danger" id="btnDeleteRow" ><i class="glyphicon glyphicon-minus"></i></button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Fee grid -->
                     <div class="row">
                        <div class="table-responsive">
                           <table id="feeList" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Fee</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tbody>
                                 </table>

                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="col-md-6">
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="col-md-6">
                                             <label class="control-label" for="ctotal">Current Total:</label>
                                          </div>
                                          <div class="col-md-6">
                                             <input type="number" class="form-control" id="ctotal" readOnly="true" name="ctotal" value="0.00">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="col-md-6">
                                             <label class="control-label" for="ctotal">Late Fee:</label>
                                          </div>
                                          <div class="col-md-6">
                                             <input type="number" class="form-control" id="lateFee"  name="lateFee" value="0.00">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="col-md-6">
                                             <label class="control-label" for="previousdue">Previous Due:</label>
                                          </div>
                                          <div class="col-md-6">
                                             <input type="number" class="form-control" id="previousdue" readOnly="true"  name="previousdue" value="0.00">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="col-md-6">
                                             <label class="control-label" for="gtotal">Grand Total:</label>
                                          </div>
                                          <div class="col-md-6">
                                             <input type="number" class="form-control" id="gtotal" readOnly="true"  name="gtotal" value="0.00">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="col-md-6">
                                             <label class="control-label" for="paidamount">Paid Amount:</label>
                                          </div>
                                          <div class="col-md-6">
                                             <input type="number" class="form-control" id="paidamount" required="true" name="paidamount" value="0.00">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="col-md-6">
                                             <label class="control-label" for="dueamount">Due Amount:</label>
                                          </div>
                                          <div class="col-md-6">
                                             <input type="number" class="form-control" id="dueamount" readOnly="true"  name="dueamount" value="0.00">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <button class="btn btn-primary pull-right" id="btnsave" type="submit"><i class="glyphicon glyphicon-plus"></i>Save</button>
                                 </div>
                              </div>
                           </div>

                        </form>
                     </div>
                     <!-- row end -->
                     <br><br>
                     <div class="clearfix"></div>
                  </div>
               </div>
               <!-- /page content -->
               @endsection
               @section('extrascript')
               <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
               <script src="{{ URL::asset('assets/js/select2.full.min.js')}}"></script>
               <script src="{{ URL::asset('assets/js/switchery.min.js')}}"></script>
               <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
               <script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
               <script src="{{ URL::asset('assets/js/daterangepicker.js')}}"></script>
               <script src="{{ URL::asset('assets/js/feecollection.js')}}"></script>
               @endsection

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('/login', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('/lock',array('as' => 'lock', 'uses' => 'HomeController@lock'));
Route::get('/',"HomeController@index");

Route::post('/user/login',[ 'as' => 'user.login','uses'=>'UserController@login']);
Route::get('/user/logout',[ 'as' => 'user.logout','uses'=>'UserController@logout']);

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/dashboard',[ 'as' => 'user.dashboard','uses'=>'DashboardController@index']);
  Route::get('/institute',[ 'as' => 'institute.index','uses'=>'InstituteController@index']);
  Route::post('/institute',[ 'as' => 'institute','uses'=>'InstituteController@save']);

  Route::resource('user','UserController');
  Route::get('/settings',[ 'as' => 'user.settings','uses'=>'UserController@settings']);
 Route::post('/settings',[ 'as' => 'user.settings','uses'=>'UserController@postSettings']);

  Route::resource('department','DepartmentController');

  Route::resource('subject','SubjectController');
  Route::get('subject/{deparment}/{semester}',[ 'as' => 'subject.DeptAndSem','uses'=>'SubjectController@subjetsByDptSem']);


  Route::resource('student','studentController');
  Route::post('student/departmment',[ 'as' => 'student.department','uses'=>'studentController@index2']);
  Route::get('students/{dID}/{session}',[ 'as' => 'students.departmentAndsession','uses'=>'studentController@studentList']);
  Route::get('students/{dID}/{session}/{semester}',[ 'as' => 'students.registered','uses'=>'studentController@registeredStudentList']);
  Route::get('student-registration',[ 'as' => 'student.registration.create','uses'=>'studentController@regCreate']);
  Route::post('student-registration',[ 'as' => 'student.registration.store','uses'=>'studentController@regStore']);
  Route::get('student-registration/{id}/delete',[ 'as' => 'student.registration.destroy','uses'=>'studentController@regDestroy']);
  Route::get('registered-students',[ 'as' => 'student.registration.index','uses'=>'studentController@regIndex']);
  Route::post('registered-students',[ 'as' => 'student.registration.list','uses'=>'studentController@regList']);

  Route::resource('attendance','AttendanceController');
  Route::post('attendance/by-subject',[ 'as' => 'attendance.index2','uses'=>'AttendanceController@index2']);

  Route::resource('exam','ExamController');
  Route::post('exam/by-subject',[ 'as' => 'exam.index2','uses'=>'ExamController@index2']);
  Route::get('result-subject',[ 'as' => 'result.subject','uses'=>'ResultController@getSubject']);
  Route::post('result-subject',[ 'as' => 'result.subject.post','uses'=>'ResultController@postSubject']);
  Route::get('result-student',[ 'as' => 'result.individual','uses'=>'ResultController@getStudent']);
  Route::post('result-student',[ 'as' => 'result.individual.post','uses'=>'ResultController@postStudent']);

  //fees collection
  Route::resource('fees','FeesController');
  Route::get('/fees-list/{dId}',[ 'as' => 'fees.list','uses'=>'FeesController@lists']);
  Route::get('/fees-collection/create',[ 'as' => 'fees.collection.create','uses'=>'FeesController@cCreate']);
  Route::post('/fees-collection',[ 'as' => 'fees.collection.store','uses'=>'FeesController@cStore']);
  //Route::post('/fees-collection/{id}',[ 'as' => 'fees.collection.destroy','uses'=>'FeesController@cDestroy']);
  Route::get('/fees-getdue/{stdId}',[ 'as' => 'fees.getdue','uses'=>'FeesController@getDue']);

  //accounting routes
  Route::get('/accounting/sector',[ 'as' => 'accounting.sector.index','uses'=>'AccountingController@secIndex']);
  Route::post('/accounting/sector',[ 'as' => 'accounting.sector.store','uses'=>'AccountingController@secStore']);
  Route::get('/accounting/sector/{id}',[ 'as' => 'accounting.sector.destroy','uses'=>'AccountingController@secDestroy']);
  Route::get('/accounting/income',[ 'as' => 'accounting.income.index','uses'=>'AccountingController@inIndex']);
  Route::post('/accounting/income',[ 'as' => 'accounting.income.store','uses'=>'AccountingController@inStore']);
  Route::get('/accounting/income/{id}',[ 'as' => 'accounting.income.destroy','uses'=>'AccountingController@inDestroy']);
  Route::get('/accounting/expence',[ 'as' => 'accounting.expence.index','uses'=>'AccountingController@exIndex']);
  Route::post('/accounting/expence',[ 'as' => 'accounting.expence.store','uses'=>'AccountingController@exStore']);
  Route::get('/accounting/expence/{id}',[ 'as' => 'accounting.expence.destroy','uses'=>'AccountingController@exDestroy']);
  //reports
  Route::get('/accounting/reports-by-type',[ 'as' => 'accounting.reports.type','uses'=>'ReportController@reportByType']);
  Route::post('/accounting/reports-by-type',[ 'as' => 'accounting.reports.type','uses'=>'ReportController@reportByType']);
  Route::get('/accounting/reports-balance',[ 'as' => 'accounting.reports.balance','uses'=>'ReportController@reportBalance']);
  Route::post('/accounting/reports-balance',[ 'as' => 'accounting.reports.balance','uses'=>'ReportController@reportBalance']);
  Route::get('/fees-collection/report',[ 'as' => 'fees.collection.report','uses'=>'ReportController@report']);
  Route::post('/fees-collection/report',[ 'as' => 'fees.collection.report','uses'=>'ReportController@report']);
  Route::get('/fees-collection',[ 'as' => 'fees.collection.index','uses'=>'ReportController@cIndex']);
  Route::get('/fees-student/{stdId}',[ 'as' => 'fees.collection.studentfees','uses'=>'ReportController@studentFees']);

  //library routes
  Route::get('/library/addbook','libraryController@getAddbook');
  Route::post('/library/addbook','libraryController@postAddbook');
  Route::get('/library/view','libraryController@getviewbook');

  Route::get('/library/view-show','libraryController@postviewbook');

  Route::get('/library/edit/{id}','libraryController@getBook');
  Route::post('/library/update','libraryController@postUpdateBook');
  Route::get('/library/delete/{id}','libraryController@deleteBook');
  Route::get('/library/issuebook','libraryController@getissueBook');

  //check availabe book
  Route::get('/library/issuebook-availabe/{books_id}/{quantity}','libraryController@checkBookAvailability');
  Route::post('/library/issuebook','libraryController@postissueBook');

  Route::get('/library/issuebookview','libraryController@getissueBookview');
  Route::post('/library/issuebookview','libraryController@postissueBookview');
  Route::get('/library/issuebookupdate/{id}','libraryController@getissueBookupdate');
  Route::post('/library/issuebookupdate','libraryController@postissueBookupdate');
  Route::get('/library/issuebookdelete/{id}','libraryController@deleteissueBook');

  Route::get('/library/search','libraryController@getsearch');
  Route::get('/library/search2','libraryController@getsearch');
  Route::post('/library/search','libraryController@postsearch');
  Route::post('/library/search2','libraryController@postsearch2');

  Route::get('/library/reports','libraryController@getReports');
  Route::get('/library/reports/fine','libraryController@getReportsFine');

  Route::get('/library/reportprint/{do}','libraryController@Reportprint');
  Route::get('/library/reports/fine/{month}','libraryController@ReportsFineprint');

  //Hostel Routes
  Route::get('/dormitory','DormitoryController@index');
  Route::post('/dormitory/create','DormitoryController@create');
  Route::get('/dormitory/edit/{id}','DormitoryController@edit');
  Route::post('/dormitory/update','DormitoryController@update');
  Route::get('/dormitory/delete/{id}','DormitoryController@delete');

  Route::get('/dormitory/getstudents/{dormid}','DormitoryController@getstudents');

  Route::get('/dormitory/assignstd','DormitoryController@stdindex');
  Route::post('/dormitory/assignstd/create','DormitoryController@stdcreate');
  Route::get('/dormitory/assignstd/list','DormitoryController@stdshow');
  Route::post('/dormitory/assignstd/list','DormitoryController@poststdShow');
  Route::get('/dormitory/assignstd/edit/{id}','DormitoryController@stdedit');
  Route::post('/dormitory/assignstd/update','DormitoryController@stdupdate');
  Route::get('/dormitory/assignstd/delete/{id}','DormitoryController@stddelete');

  Route::get('/dormitory/fee','DormitoryController@feeindex');
  Route::post('/dormitory/fee','DormitoryController@feeadd');
  Route::get('/dormitory/fee/info/{regiNo}','DormitoryController@feeinfo');

  Route::get('/dormitory/report/std','DormitoryController@reportstd');
  Route::get('/dormitory/report/std/{dormId}','DormitoryController@reportstdprint');
  Route::get('/dormitory/report/fee','DormitoryController@reportfee');
  Route::get('/dormitory/report/fee/{dormId}/{month}','DormitoryController@reportfeeprint');

  //barcode generate
  Route::get('/barcode','barcodeController@index');
  Route::post('/barcode','barcodeController@generate');
  //db triggers crate route
  Route::get('/hrs-triggers-init',function(){
    //create tiggers for manage book stock
    //book addd trigger
    DB::unprepared('
    CREATE TRIGGER `afterBookAdd` AFTER INSERT ON `books` FOR EACH ROW
    BEGIN
    insert into stock_books
    set
    books_id = new.id,
    quantity = new.quantity;
    END
    ');
    //after book delete
    DB::unprepared('
    CREATE TRIGGER `afterBookDelete` AFTER DELETE ON `books` FOR EACH ROW
    BEGIN
    delete from borrow_books where books_id = old.id;
    delete from stock_books where books_id = old.id;
    END
    ');
    //afeter book update
    DB::unprepared('
    CREATE TRIGGER `afterBookUpdate` AFTER UPDATE ON `books` FOR EACH ROW
    BEGIN
    UPDATE stock_books
    set
    quantity = new.quantity-(old.quantity-quantity)
    WHERE books_id=old.id;
    END
    ');
    //after borrow book add
    DB::unprepared('
    CREATE TRIGGER `afterBorrowBookAdd` AFTER INSERT ON `borrow_books` FOR EACH ROW
    BEGIN
    UPDATE stock_books
    set quantity = quantity-new.quantity
    where books_id=new.books_id;
    END
    ');
    //after borrow book delete
    DB::unprepared("
    CREATE TRIGGER `afterBorrowBookDelete` AFTER DELETE ON `borrow_books` FOR EACH ROW
    IF (old.Status='Borrowed') THEN
    UPDATE stock_books
    set quantity = quantity+old.quantity
    WHERE books_id=old.books_id;
    END IF
    ");
    //after borrow book update
    DB::unprepared("
    CREATE TRIGGER `afterBorrowBookUpdate` AFTER UPDATE ON `borrow_books` FOR EACH ROW
    IF (new.Status='Returned') THEN
    UPDATE stock_books
    set quantity = quantity+new.quantity
    WHERE books_id=new.books_id;
    END IF
    ");
    return "Done!....";
  });


});

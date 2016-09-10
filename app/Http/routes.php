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
  Route::get('/accounting/reports-by-type',[ 'as' => 'accounting.reports.type','uses'=>'AccountingController@reportByType']);
  Route::post('/accounting/reports-by-type',[ 'as' => 'accounting.reports.type','uses'=>'AccountingController@reportByType']);
  Route::get('/accounting/reports-balance',[ 'as' => 'accounting.reports.balance','uses'=>'AccountingController@reportBalance']);
  Route::post('/accounting/reports-balance',[ 'as' => 'accounting.reports.balance','uses'=>'AccountingController@reportBalance']);



});

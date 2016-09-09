<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use App\Exam;
use App\Department;
use App\Attendance;
use App\Registration;
use App\Student;
use App\Subject;
use App\Account;

class DashboardController extends Controller {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		$error = Session::get('error');
		$success=Session::get('success');
		$totalAdmit = Student::count();
		$totalRegisterd = Registration::groupBy('students_id')->get();
		$totalDepartment = Department::count();
		$totalSubject = Subject::count();
		$totalAttendance = Attendance::groupBy('date')->get();
		$totalExam = Exam::groupBy('exam')->groupBy('subject_id')->get();
		$total = [
			'admitted' =>$totalAdmit,
			'registered' =>count($totalRegisterd),
			'department' =>$totalDepartment,
			'subject' =>$totalSubject,
			'attendance' =>count($totalAttendance),
			'exam' =>count($totalExam),
		];
		//graph data
		$monthlyIncome= Account::selectRaw('month(date) as month, sum(amount) as amount')
		->with(array('sector' =>  function($query){
			$query->where('type','Income');
		}))->whereHas('sector',function($query){
			$query->where('type','Income');
		})
		->groupBy('month')
		->get();
		$monthlyExpences= Account::selectRaw('month(date) as month, sum(amount) as amount')
		->with(array('sector' =>  function($query){
			$query->where('type','Expence');
		}))->whereHas('sector',function($query){
			$query->where('type','Expence');
		})
		->groupBy('month')
		->get();
		$incomeTotal = Account::with(array('sector' =>  function($query){
			$query->where('type','Income');
		}))->whereHas('sector',function($query){
			$query->where('type','Income');
		})
		->sum('amount');
		$expenceTotal = Account::with(array('sector' =>  function($query){
			$query->where('type','Expence');
		}))->whereHas('sector',function($query){
			$query->where('type','Expence');
		})
		->sum('amount');
		$incomes=$this->datahelper($monthlyIncome);
		$expences=$this->datahelper($monthlyExpences);
		$balance = $incomeTotal - $expenceTotal;
		return view('dashboard',compact('error','success','total','incomes','expences','balance'));
	}
	function datahelper($data)
	{
		$DataKey = [];
		$DataVlaue =[];
		foreach ($data as $d) {
			array_push($DataKey,date("F", mktime(0, 0, 0, $d->month, 10)));
			array_push($DataVlaue,$d->amount);

		}
		return ["key"=>$DataKey,"value"=>$DataVlaue];

	}

}

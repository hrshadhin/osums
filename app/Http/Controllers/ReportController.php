<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Validator;
use App\Account;
use App\Sector;
use Carbon\Carbon;
use App\FeeCollection;
use DB;
use App\Department;
use App\Student;
use App\Institute;
class ReportController extends Controller
{
	public function __construct()
    {
        $this->middleware('account');
    }
	protected $semesters=[
		'L1T1' => '1st Year 1st Semester',
        'L1T2' => '1st Year 2nd Semester',
        'L2T1' => '2nd Year 1st Semester',
        'L2T2' => '2nd Year 2nd Semester',
        'L3T1' => '3rd Year 1st Semester',
        'L3T2' => '3rd Year 2nd Semester',
        'L4T1' => '4th Year 1st Semester',
        'L4T2' => '4th Year 2nd Semester'
	];

	public function reportByType(Request $request){
		$types = [
			'Income' => 'Income',
			'Expence' => 'Expence',
		];
		$fromDate = Carbon::yesterday();
		$toDate = Carbon::today();
		$type="Income";
		if ($request->isMethod('post'))
		{
			$dateRange=$request->input('DateRange');
			$type=$request->input('type');
			$dateList=explode('-',$dateRange);
			$fromDate=Carbon::createFromFormat('d/m/Y', trim($dateList[0]));
			$toDate=Carbon::createFromFormat('d/m/Y', trim($dateList[1]));

		}


		$accounts = Account::with(array('sector' =>  function($query) use ($type){
			$query->where('type',$type);
		}))->whereHas('sector',function($query) use ($type) {
			$query->where('type',$type);
		})
		->where('date','>=',$fromDate->format('Y-m-d'))
		->where('date','<=',$toDate->format('Y-m-d'))
		->get();
		$total = Account::with(array('sector' =>  function($query) use ($type){
			$query->where('type',$type);
		}))->whereHas('sector',function($query) use ($type) {
			$query->where('type',$type);
		})
		->where('date','>=',$fromDate->format('Y-m-d'))
		->where('date','<=',$toDate->format('Y-m-d'))
		->sum('amount');
		$fromDate=$fromDate->format('d/m/Y');
		$toDate=$toDate->format('d/m/Y');
		return view('reports.account.types',compact('types','type','total','accounts','fromDate','toDate'));
	}
	public function reportBalance(Request $request){

		$fromDate = Carbon::yesterday();
		$toDate = Carbon::today();

		if ($request->isMethod('post'))
		{
			$dateRange=$request->input('DateRange');
			$dateList=explode('-',$dateRange);
			$fromDate=Carbon::createFromFormat('d/m/Y', trim($dateList[0]));
			$toDate=Carbon::createFromFormat('d/m/Y', trim($dateList[1]));

		}


		$incomes = Account::with(array('sector' =>  function($query){
			$query->where('type','Income');
		}))->whereHas('sector',function($query){
			$query->where('type','Income');
		})
		->where('date','>=',$fromDate->format('Y-m-d'))
		->where('date','<=',$toDate->format('Y-m-d'))
		->get();
		$incomeTotal = Account::with(array('sector' =>  function($query){
			$query->where('type','Income');
		}))->whereHas('sector',function($query){
			$query->where('type','Income');
		})
		->where('date','>=',$fromDate->format('Y-m-d'))
		->where('date','<=',$toDate->format('Y-m-d'))
		->sum('amount');
		$expences = Account::with(array('sector' =>  function($query){
			$query->where('type','Expence');
		}))->whereHas('sector',function($query){
			$query->where('type','Expence');
		})
		->where('date','>=',$fromDate->format('Y-m-d'))
		->where('date','<=',$toDate->format('Y-m-d'))
		->get();
		$expenceTotal = Account::with(array('sector' =>  function($query){
			$query->where('type','Expence');
		}))->whereHas('sector',function($query){
			$query->where('type','Expence');
		})
		->where('date','>=',$fromDate->format('Y-m-d'))
		->where('date','<=',$toDate->format('Y-m-d'))
		->sum('amount');
		$balance = $incomeTotal - $expenceTotal;
		$fromDate=$fromDate->format('d/m/Y');
		$toDate=$toDate->format('d/m/Y');
		return view('reports.account.balance',compact('incomes','expences','incomeTotal','expenceTotal','balance','fromDate','toDate'));
	}

	public function studentFees($stdId){
		$student = Student::with('department')->where('id',$stdId)->first();
		$fees= FeeCollection::where('students_id',$stdId)
		->get();
		$totals = FeeCollection::select(DB::RAW('IFNULL(sum(payableAmount),0) as payTotal,IFNULL(sum(paidAmount),0) as paiTotal,(IFNULL(sum(payableAmount),0)- IFNULL(sum(paidAmount),0)) as dueamount'))
		->where('students_id',$stdId)
		->first();
		$institute = Institute::select('name')->first();
		$metaDatas= [
			'institute' => $institute->name,
			'department' => $student->department->name,
			'session' => $student->session,
			'name'    => $student->firstName.' '.$student->middleName.' '.$student->lastName,
			'fatherName' => $student->fatherName,
			'motherName' => $student->motherName,
			'dob' => $student->dob->format('F j,Y'),
			'idNo' => $student->idNo,
			'bncReg' => $student->bncReg,

		];
		$metaData= (object)$metaDatas;
		return view('reports.fees.stdFees',compact('metaData','fees','totals'));
	}
	public function report(Request $request){

		$fromDate = Carbon::yesterday();
		$toDate = Carbon::today();
		if ($request->isMethod('post'))
		{
			$dateRange=$request->input('DateRange');
			$dateList=explode('-',$dateRange);
			$fromDate=Carbon::createFromFormat('d/m/Y', trim($dateList[0]));
			$toDate=Carbon::createFromFormat('d/m/Y', trim($dateList[1]));
		}
		$fees= FeeCollection::where('payDate','>=',$fromDate->format('Y-m-d'))
		->where('payDate','<=',$toDate->format('Y-m-d'))->get();
		$totals = FeeCollection::select(DB::RAW('IFNULL(sum(payableAmount),0) as payTotal,IFNULL(sum(paidAmount),0) as paiTotal,(IFNULL(sum(payableAmount),0)- IFNULL(sum(paidAmount),0)) as dueamount'))
		->where('payDate','>=',$fromDate->format('Y-m-d'))
		->where('payDate','<=',$toDate->format('Y-m-d'))
		->first();
		$fromDate=$fromDate->format('d/m/Y');
		$toDate=$toDate->format('d/m/Y');
		return view('reports.fees.collection',compact('totals','fees','fromDate','toDate'));
	}
	public function cIndex(){
		$students=[];
		$fees=[];
		$semesters= $this->semesters;
		$departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
		$sessions=Student::select('session','session')->distinct()->lists('session','session');
		return view('fees.index',compact('departments','sessions','students','semesters','fees'));
	}

}

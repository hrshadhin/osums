<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use DB;
use App\Department;
use App\Student;
use App\Institute;
use App\Dormitory;
use App\DormitoryStudent;
use App\DormitoryFee;

class DormitoryController extends Controller
{
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
  public function __construct()
  {
    $this->middleware('teacher');
  }
  /**
  * Display a listing of the resource.
  *
  * @return Response
  */
  public function index()
  {
    $dormitories=Dormitory::all();
    $dormitory=array();
    return view('dormitory.index',compact('dormitories','dormitory'));
  }


  /**
  * Show the form for creating a new resource.
  *
  * @return Response
  */
  public function create(Request $request)
  {
    $rules=[
      'name' => 'required',
      'numOfRoom' => 'required',
      'address' => 'required',

    ];
    $validator = \Validator::make($request->all(), $rules);
    if ($validator->fails())
    {
      return Redirect::to('/dormitory')->withErrors($validator);
    }
    else {
      $dormitory = new Dormitory;
      $dormitory->name= $request->get('name');
      $dormitory->numOfRoom=$request->get('numOfRoom');
      $dormitory->address=$request->get('address');
      $dormitory->description=$request->get('description');
      $dormitory->save();
      $notification= array('title' => 'Data Store', 'body' => 'Dormitory Created Succesfully.');
      return Redirect::to('/dormitory')->with("success",$notification);

    }
  }



  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return Response
  */
  public function edit($id)
  {
    $dormitory = Dormitory::find($id);
    $dormitories=Dormitory::all();
    return view('dormitory.index',compact('dormitories','dormitory'));
  }


  /**
  * Update the specified resource in storage.
  *
  * @param  int  $id
  * @return Response
  */
  public function update(Request $request)
  {
    $rules=[
      'name' => 'required',
      'numOfRoom' => 'required',
      'address' => 'required',

    ];
    $validator = \Validator::make($request->all(), $rules);
    if ($validator->fails())
    {
      return Redirect::to('/dormitory/edit/'.$request->get('id'))->withErrors($validator);
    }
    else {
      $dormitory = Dormitory::find($request->get('id'));
      $dormitory->name= $request->get('name');
      $dormitory->numOfRoom=$request->get('numOfRoom');
      $dormitory->address=$request->get('address');
      $dormitory->description=$request->get('description');
      $dormitory->save();
      $notification= array('title' => 'Data Update', 'body' => 'Dormitory update Succesfully.');
      return Redirect::to('/dormitory')->with("success",$notification);

    }
  }


  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return Response
  */
  public function delete($id)
  {
    $dormitory = Dormitory::find($id);
    $dormitory->delete();
    $notification= array('title' => 'Data Delete', 'body' => 'Dormitory deleted Succesfully.');
    return Redirect::to('/dormitory')->with("success",$notification);
  }


  //student assign to dormitory part goes Here
  public function stdindex()
  {
    $semesters = $this->semesters;
    $departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
    $sessions=Student::select('session','session')->distinct()->lists('session','session');
    $dormitories = Dormitory::select('id','name')->lists('name','id');
    return view('dormitory.stdadd',compact('sessions','semesters','departments','dormitories'));
  }


  public function stdcreate(Request $request)
  {
    $rules=[
      'students_id' => 'required',
      'joinDate' => 'required',
      'isActive' => 'required',
      'dormitories_id' => 'required',
      'roomNo' => 'required',
      'monthlyFee' => 'required|numeric',


    ];
    $validator = \Validator::make($request->all(), $rules);
    if ($validator->fails())
    {
      return Redirect::to('/dormitory/assignstd')->withErrors($validator);
    }
    else {
      $dormStd = new DormitoryStudent;
      $dormStd->students_id=$request->get('students_id');
      $dormStd->joinDate=$request->get('joinDate');
      //$dormStd->leaveDate=null;
      $dormStd->dormitories_id=$request->get('dormitories_id');
      $dormStd->roomNo=$request->get('roomNo');
      $dormStd->monthlyFee=$request->get('monthlyFee');
      $dormStd->isActive=$request->get('isActive');
      $dormStd->save();
      $notification= array('title' => 'Data Store', 'body' => 'Student added to dormitory Succesfully.');
      return Redirect::to('/dormitory/assignstd')->with("success",$notification);

    }
  }

  public function stdShow()
  {

    $dormitories = Dormitory::select('id','name')->lists('name','id');
    $dormitory=null;
    $students = [];
    return view('dormitory.stdlist',compact('dormitories','dormitory','students'));
  }
  public function poststdShow(Request $request)
  {
    $rules = ['dormitory' => 'required',];
    $validator = \Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return Redirect::to('/dormitory/assignstd/list')->withInput($request->all())->withErrors($validator);
    }
    else {
      $students = DB::table('dormitory_students')
      ->leftJoin('students', 'dormitory_students.students_id', '=', 'students.id')
      ->leftjoin('department', 'students.department_id', '=', 'department.id')
      ->leftjoin('dormitories', 'dormitory_students.dormitories_id', '=', 'dormitories.id')
      ->select('dormitory_students.id', 'students.idNo','students.firstName',
       'students.middleName', 'students.lastName', 'students.fatherName','students.mobileNo',
       'students.motherName', 'students.fatherMobileNo', 'students.motherMobileNo',
       'students.localGuardianMobileNo','department.name as department',
       'dormitory_students.roomNo','dormitory_students.monthlyFee',
       'dormitory_students.joinDate',
       'dormitory_students.leaveDate',
       'dormitory_students.isActive')
      ->where('dormitory_students.dormitories_id',$request->get('dormitory'))
      ->where('dormitory_students.deleted_at',NULL)
      ->get();
      $dormitories = Dormitory::select('id','name')->lists('name','id');
      $dormitory=$request->get('dormitory');
      return view('dormitory.stdlist',compact('students','dormitories','dormitory'));
    }
  }
  public function stdedit($id)
  {
    $student = DormitoryStudent::find($id);
    $dormitories = Dormitory::select('id','name')->lists('name','id');
    return view('dormitory.stdedit',compact('dormitories','student'));
  }


  /**
  * Update the specified resource in storage.
  *
  * @param  int  $id
  * @return Response
  */
  public function stdupdate(Request $request)
  {

    $rules=[
      'isActive' => 'required',
      'dormitory' => 'required',
      'roomNo' => 'required',
      'monthlyFee' => 'required|numeric',
    ];


    $validator = \Validator::make($request->all(), $rules);
    if ($validator->fails())
    {
      return Redirect::to('/dormitory/assignstd/edit/'.$request->get('id'))->withErrors($validator);
    }
    else {
      $dormStd = DormitoryStudent::find($request->get('id'));
      if($request->get('leaveDate')!=""){
        $dormStd->leaveDate=$request->get('leaveDate');
      }

      $dormStd->dormitories_id=$request->get('dormitory');
      $dormStd->roomNo=$request->get('roomNo');
      $dormStd->monthlyFee=$request->get('monthlyFee');
      $dormStd->isActive=$request->get('isActive');
      $dormStd->save();
      $notification = ['title'=>'Data Update', 'body' => 'Dormitory student info update Succesfully.'];
      return Redirect::to('/dormitory/assignstd/list')->with("success",$notification);

    }
  }


  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return Response
  */
  public function stddelete($id)
  {
    $dormstd = DormitoryStudent::find($id);
    $dormstd->delete();
    $notification = ['title'=>'Data Update', 'body' => 'Dormitory student deleted succesfully.'];
    return Redirect::to('/dormitory/assignstd/list')->with("success",$notification);
  }

  public function getstudents($dormid)
  {
    $students = DormitoryStudent::select('*')->with('student')
    ->where('dormitories_id',$dormid)
    ->where('isActive','Yes')
    ->get();
    $studentList = [];
    foreach ($students as $student) {
       $data =[
         'id' => $student->students_id.'-'.$student->id,
         'name' => $student->student->firstName.' '.$student->student->middleName.' '.$student->student->lastName.'['.$student->student->idNo.']'
       ];
       $studentList[] = $data;
    }
    return $studentList;
  }
  public function feeinfo($regiNo)
  {
    $fee = DormitoryStudent::select('monthlyFee')
    ->where('students_id',$regiNo)
    ->get();

    $isPaid= DB::table('dormitory_fees')
    ->select('students_id','feeAmount')
    ->where('students_id',$regiNo)
    ->whereRaw('EXTRACT(YEAR_MONTH FROM feeMonth) = EXTRACT(YEAR_MONTH FROM NOW())')
    ->get();

    $info=array($fee[0]->monthlyFee);
    if(count($isPaid)>0)
    {
      array_push($info,"true");
    }
    else {
      array_push($info,"false");
    }
    return $info;
  }

  public function feeindex()
  {
    $dormitories = Dormitory::select('id','name')->lists('name','id');
    $dormitories->prepend('--select a dormitory--', '');
    return view('dormitory.fee',compact('dormitories'));
  }
  public function feeadd(Request $request)
  {
    $rules=[
      'student' => 'required',
      'feeMonth' => 'required',
      'feeAmount' => 'required',
    ];
    $validator = \Validator::make($request->all(), $rules);
    if ($validator->fails())
    {
      return Redirect::to('/dormitory/fee')->withErrors($validator);
    }
    else {
      $dormFee = new DormitoryFee;
      $ids = mb_split('-',$request->get('student'));
      $dormFee->students_id=$ids[0];
      $dormFee->dormitory_students_id=$ids[1];
      $dormFee->feeMonth=$request->get('feeMonth');
      $dormFee->feeAmount=$request->get('feeAmount');
      $dormFee->save();
      $notification = ['title'=>'Data Store', 'body' => "Fee added Succesfully."];
      return Redirect::to('/dormitory/fee')->with("success",$notification);

    }
  }

  public function reportstd()
  {
    $dormitories = Dormitory::select('id','name')->lists('name','id');
    return view('dormitory.rptstd',compact('dormitories'));
  }
  public function reportstdprint($dormId)
  {
    $students = DB::table('dormitory_students')
    ->leftJoin('students', 'dormitory_students.students_id', '=', 'students.id')
    ->leftjoin('department', 'students.department_id', '=', 'department.id')
    ->leftjoin('dormitories', 'dormitory_students.dormitories_id', '=', 'dormitories.id')
    ->select('dormitory_students.id', 'students.idNo','students.firstName',
     'students.middleName', 'students.lastName', 'students.fatherName','students.mobileNo',
     'students.motherName', 'students.fatherMobileNo', 'students.motherMobileNo',
     'students.localGuardianMobileNo','department.name as department',
     'dormitory_students.roomNo','dormitory_students.monthlyFee',
     'dormitory_students.joinDate',
     'dormitory_students.leaveDate',
     'dormitory_students.isActive')
    ->where('dormitory_students.dormitories_id',$dormId)
    ->where('dormitory_students.deleted_at',NULL)
    ->where('dormitory_students.isActive',"Yes")
    ->get();
    $dormInfo = Dormitory::find($dormId);
    $institute=Institute::select('*')->first();
    $rdata =array('date'=>date('d/m/Y'),'name'=>$dormInfo->name,'totalr'=>$dormInfo->numOfRoom,'totals'=>count($students));
    return view('dormitory.rptstdprint',compact('students','rdata','institute'));
  }
  public function reportfee()
  {
    $dormitories = Dormitory::select('id','name')->lists('name','id');
    return view('dormitory.rptfee',compact('dormitories'));
  }
  public function reportfeeprint($dormId,$month)
  {

    $students = DormitoryStudent::with('student')
    ->with(array('fee' => function($query) use ($month){
     $query->whereRaw("EXTRACT(YEAR_MONTH FROM feeMonth) = EXTRACT(YEAR_MONTH FROM '".$month."-01')");
    }))
    ->where('dormitories_id',$dormId)
    ->where('isActive','Yes')
    ->get();

    $dormInfo = Dormitory::find($dormId);
    $institute=Institute::select('*')->first();

    $rdata =array('month'=>date('F-Y', strtotime($month)),'name'=>$dormInfo->name,'total'=>count($students));
    return view('dormitory.rptfeeprint',compact('students','rdata','institute'));
  }
}

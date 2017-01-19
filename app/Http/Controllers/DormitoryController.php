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

class DormitoryController extends Controller
{
  protected $semesters=[
		'L1T1' => 'First Year 1st Semester',
		'L1T2' => 'First Year 2nd Semester',
		'L2T1' => 'Second Year 1st Semester',
		'L2T2' => 'Second Year 2nd Semester',
		'L3T1' => 'Third Year 1st Semester',
		'L3T2' => 'Third Year 2nd Semester'
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
      $dormStd->leaveDate=null;
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
    $students = DB::table('Student')
    ->join('dormitory_student', 'Student.regiNo', '=', 'dormitory_student.regiNo')
    ->select('Student.regiNo', 'Student.rollNo', 'Student.firstName', 'Student.middleName', 'Student.lastName')
    ->where('dormitory_student.dormitory',$dormid)
    ->where('dormitory_student.isActive',"Yes")
    ->orderby('dormitory_student.regiNo','asc')->get();
    return $students;
  }
  public function feeinfo($regiNo)
  {
    $fee = DormitoryStudent::select('monthlyFee')
    ->where('regiNo',$regiNo)
    ->get();

    $isPaid= DB::table('dormitory_fee')
    ->select('regiNo','feeAmount')
    ->where('regiNo',$regiNo)
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
    $dormitories=Dormitory::select('name','id')->orderby('id','asc')->get();
    return View::Make('app.dormitory_fee',compact('dormitories'));
  }
  public function feeadd()
  {
    $rules=[
      'regiNo' => 'required',
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
      $dormFee->regiNo=$request->get('regiNo');
      $dormFee->feeMonth=$request->get('feeMonth');
      $dormFee->feeAmount=$request->get('feeAmount');
      $dormFee->save();
      return Redirect::to('/dormitory/fee')->with("success","Fee added Succesfully.");

    }
  }

  public function reportstd()
  {
    $dormitories=Dormitory::select('name','id')->orderby('id','asc')->get();
    return View::Make('app.dormitory_rptstd',compact('dormitories'));
  }
  public function reportstdprint($dormId)
  {
    $datas = DB::table('Student')
    ->join('Class', 'Student.class', '=', 'Class.code')
    ->join('dormitory_student', 'Student.regiNo', '=', 'dormitory_student.regiNo')
    ->select('dormitory_student.id', 'Student.regiNo', 'Student.rollNo', 'Student.firstName', 'Student.middleName', 'Student.lastName', 'Student.fatherName', 'Student.motherName', 'Student.fatherMobileNo', 'Student.motherMobileNo', 'Student.localGuardianMobile',
    'Class.Name as class','dormitory_student.roomNo','Student.section','Student.session' )
    ->where('dormitory_student.dormitory',$dormId)
    ->where('dormitory_student.isActive',"Yes")
    ->get();
    $dormInfo = Dormitory::find($dormId);
    $institute=Institute::select('*')->first();
    $rdata =array('date'=>date('d/m/Y'),'name'=>$dormInfo->name,'totalr'=>$dormInfo->numOfRoom,'totals'=>count($datas));
    $pdf = PDF::loadView('app.dormitory_rptstdprint',compact('datas','rdata','institute'));
    return $pdf->stream('dormitory-students-List.pdf');
  }
  public function reportfee()
  {
    $dormitories=Dormitory::select('name','id')->orderby('id','asc')->get();
    return View::Make('app.dormitory_rptfee',compact('dormitories'));
  }
  public function reportfeeprint($dormId,$month)
  {

    $myquery="SELECT a.regiNo,a.roomNo,CONCAT(b.firstName,' ',b.middleName,' ',b.lastName) as name,c.name as class,'Paid' as isPaid FROM dormitory_student a
    JOIN Student b ON a.regiNo=b.regiNo
    JOIN Class c ON c.code=b.class
    where a.dormitory=".$dormId."
    and EXISTS (select b.feeMonth from dormitory_fee b where b.regiNo=a.regiNo and EXTRACT(YEAR_MONTH FROM b.feeMonth) = EXTRACT(YEAR_MONTH FROM '".$month."'))

    UNION SELECT a.regiNo,a.roomNo,CONCAT(b.firstName,' ',b.middleName,' ',b.lastName) as name,c.name as class,'Due' as isPaid FROM dormitory_student a
    JOIN Student b ON a.regiNo=b.regiNo
    JOIN Class c ON c.code=b.class
    WHERE a.dormitory=".$dormId."
    and NOT EXISTS (select b.feeMonth from dormitory_fee b where b.regiNo=a.regiNo and EXTRACT(YEAR_MONTH FROM b.feeMonth) = EXTRACT(YEAR_MONTH FROM '".$month."'))
    ORDER BY regiNo";

    $datas = DB::select(DB::raw($myquery));



    $dormInfo = Dormitory::find($dormId);
    $institute=Institute::select('*')->first();

    $rdata =array('month'=>date('F-Y', strtotime($month)),'name'=>$dormInfo->name,'total'=>count($datas));
    $pdf = PDF::loadView('app.dormitory_rptfeeprint',compact('datas','rdata','institute'));
    return $pdf->stream('dormitory-free-report.pdf');
  }
}

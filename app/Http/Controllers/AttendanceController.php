<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Student;
use App\Department;
use App\Subject;
use App\Attendance;
use Validator;
use Carbon\Carbon;
use App\Transformers\AttendanceTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use App\Serializers\MySerializer;

class AttendanceController extends Controller
{
    public function __construct()
	{
        $this->middleware('teacher');
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
    public function Create()
    {
        $today = Carbon::today();
        $students=[];
        $subjects=[];
        $semesters= $this->semesters;
        $departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
        $sessions=Student::select('session','session')->distinct()->lists('session','session');
        return view('attendance.create',compact('departments','sessions','students','semesters','subjects','today'));
    }
    public function Store(Request $request)
    {
        $data=$request->all();
        $rules=[
            'session' => 'required',
            'department_id'=> 'required',
            'date'=> 'required',
            'subject_id'=> 'required',
            'levelTerm'=> 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {
            return Redirect::route('attendance.create')->withErrors($validator);
        }
        else {
            $dateJunk= Carbon::createFromFormat('d/m/Y', $data['date']);
            $exists = Attendance::select('id')
            ->where('session',$data['session'])
            ->where('department_id',$data['department_id'])
            ->where('subject_id',$data['subject_id'])
            ->where('date','=',$dateJunk->toDateString())
            ->where('levelTerm',$data['levelTerm'])
            ->first();
            if(count($exists))
            {
                $notification= array('title' => 'Validation', 'body' => 'Attendance already exists!');
                return Redirect::route('attendance.create')->with("error",$notification);
            }

            foreach ($data['ids'] as  $id){
                $isPresent=0;
                if($request->exists('present')){
                    $isPresent = $this->checkPresent($id,$data['present']);
                }

                $attendanceData[] = [
                    'session' => $data['session'],
                    'department_id' => $data['department_id'],
                    'levelTerm' => $data['levelTerm'],
                    'subject_id' => $data['subject_id'],
                    'date' => Carbon::createFromFormat('d/m/Y', $data['date']),
                    'students_id' => $id,
                    'present' => $isPresent,
                ];
            }
            $attendanceData;
            Attendance::insert($attendanceData);
            $notification= array('title' => 'Data Store', 'body' => 'Attendance saved Succesfully.');
            return Redirect::route('attendance.create')->with("success",$notification);

        }


    }
    public function index(){
        $today = Carbon::today();
        $students=[];
        $subjects=[];
        $semesters= $this->semesters;
        $departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
        $sessions=Student::select('session','session')->distinct()->lists('session','session');
        $selectDep="";
        $selectSem="";
        $selectSub = "";
        $session="";
        return view('attendance.index',compact('selectDep','selectSem','selectSub','session','departments','sessions','students','semesters','subjects','today'));

    }
    public function index2(Request $request){
        $dateJunk= Carbon::createFromFormat('d/m/Y', $request->input('date'));
        $stds=Attendance::with(array('student' =>  function($query){
            $query->select('id','idNo','firstName','middleName','lastName');
        }))
        ->where('department_id',$request->input('department_id'))
        ->where('session',$request->input('session'))
        ->where('levelTerm',$request->input('levelTerm'))
        ->where('subject_id',$request->input('subject_id'))
        ->where('date',$dateJunk->toDateString())
        ->get();
        $manager = new Manager();
        $manager->setSerializer(new MySerializer());
        $stdData= new Collection($stds,new AttendanceTransformer());
        $students=$manager->createData($stdData)->toArray();
        $departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
        $sessions=Student::select('session','session')->distinct()->lists('session','session');
        $subjects=Subject::select('id','name')->where('department_id',$request->input('department_id'))->where('levelTerm',$request->input('levelTerm'))->orderby('code','asc')->lists('name', 'id');

        $semesters= $this->semesters;

        $selectSem=$request->input('levelTerm');
        $selectSub = $request->input('subject_id');
        $selectDep=$request->input('department_id');
        $session=$request->input('session');
        $today = $dateJunk;

        return view('attendance.index',compact('selectDep','selectSub','session','sessions','departments','students','semesters','subjects','today','selectSem'));

    }
    public function update(Request $request,$id){
        $data=$request->all();
        $rules=[
            'present' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        $errors=$validator->messages()->toArray();
        if ($validator->fails())
        {
            return Response()->json([
				'error' => true,
				'message' => $errors
			], 400);
        }
        else {
            $attendance = Attendance::findOrFail($id);
            $attendance->present =$data['present'];
            $attendance->save();
            $present = $attendance->present ? 'Yes':'No';
            return Response()->json([
			'success' => true,
			'message' => "Attendance updated successfully.",
			'present' => $present
		], 200);

        }
    }
    private  function checkPresent($id,$presents)
    {
        foreach ($presents as $key => $value) {
            if($id==$key)
            {
                return 1;
            }
        }
        return 0;
    }


}

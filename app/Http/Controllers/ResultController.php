<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Student;
use App\Department;
use App\Subject;
use Validator;
use App\Institute;
use App\Exam;
use Carbon\Carbon;

class ResultController extends Controller
{
  public function __construct()
	{
		$this->middleware('teacher');

	}
  protected $semesters=[
    'L1T1' => 'First Year 1st Semester',
    'L1T2' => 'First Year 2nd Semester',
    'L2T1' => 'Second Year 1st Semester',
    'L2T2' => 'Second Year 2nd Semester',
    'L3T1' => 'Third Year 1st Semester',
    'L3T2' => 'Third Year 2nd Semester'
  ];
  protected $exams=[
    'Midterm Exam' => 'Midterm Exam',
    'Final Exam' => 'Final Exam',
    'Lab & Quiz' => 'Lab & Quiz',
  ];
  public function getSubject(){

    $subjects=[];
    $semesters= $this->semesters;

    $departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');

    return view('reports.result.subject',compact('departments','semesters','subjects'));

  }
  public function postSubject(Request $request){
    $allExams = Exam::select('exam')
    ->where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('levelTerm',$request->input('levelTerm'))
    ->where('subject_id',$request->input('subject_id'))
    ->groupBy('exam')
    ->get();
    if(count($allExams)!=3){
      $notification= array('title' => 'Not Found!', 'body' => 'All Examinations marks not submit for this subject!');
      return redirect()->back()->with("error",$notification);
    }
    $Midterm=Exam::with(array('student' =>  function($query){
      $query->select('id','idNo','firstName','middleName','lastName');
    }))
    ->where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('levelTerm',$request->input('levelTerm'))
    ->where('subject_id',$request->input('subject_id'))
    ->where('exam','Midterm Exam')
    ->get();
    $Final=Exam::where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('levelTerm',$request->input('levelTerm'))
    ->where('subject_id',$request->input('subject_id'))
    ->where('exam','Final Exam')
    ->get();
    $LabandQuiz=Exam::where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('levelTerm',$request->input('levelTerm'))
    ->where('subject_id',$request->input('subject_id'))
    ->where('exam','Lab & Quiz')
    ->get();

    $institute = Institute::select('name')->first();
    $department = Department::select('name')->where('id',$request->input('department_id'))->first();
    $semester = $this->semesters[$request->input('levelTerm')];
    $session =$request->input('session');
    $subject = Subject::select('name','code')->where('id',$request->input('subject_id'))->first();
    $date=$Final[0]->created_at;
    $metaDatas= [
      'institute' => $institute->name,
      'department' => $department->name,
      'semester' => $semester,
      'session' => $session,
      'subject' => $subject->code.'-'.$subject->name,
      'monthYear' => $date->format('F/Y'),
    ];
    $metaData= (object)$metaDatas;
    $students = $this->calculateScore($Midterm,$Final,$LabandQuiz);
    return view('reports.result.spreadsheet',compact('metaData','students'));

  }

  public function getStudent(){

    $students=[];
    $exams = $this->exams;
    $departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');

    return view('reports.result.student',compact('departments','students','exams'));

  }
  public function postStudent(Request $request){
    //first year code start
    $l1t1=Exam::with('subject')
    ->where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('students_id',$request->input('students_id'))
    ->where('exam',$request->input('exam'))
    ->where('levelTerm','l1t1')
    ->get();
    //check if first year first semester request exam data present
    if(!count($l1t1)){
      $notification= array('title' => 'Not Found!', 'body' => 'Any subject of first year first semester for '.$request->input('exam').' not present!');
      return redirect()->back()->with("error",$notification);
    }

    $L1T1data=(object)$this->dataManupulator($l1t1);
    $l1t2=Exam::with('subject')
    ->where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('students_id',$request->input('students_id'))
    ->where('exam',$request->input('exam'))
    ->where('levelTerm','l1t2')
    ->get();
    //check if first year second semester request exam data present
    if(!count($l1t2)){
      $notification= array('title' => 'Not Found!', 'body' => 'Any subject of first year second semester for '.$request->input('exam').' not present!');
      return redirect()->back()->with("error",$notification);
    }

    $L1T2data=(object)$this->dataManupulator($l1t2);
    $fyp=($L1T1data->totalPoint+$L1T2data->totalPoint);
    $fyc=$L1T1data->totalCredit+$L1T2data->totalCredit;
    $fyGPA=$fyp/$fyc;
    $fyData =[
      'grade' => $this->yearGrade($fyGPA),
      'point' => $fyGPA,
      'credit' => $fyc,
    ];
    //First Year data colection code end
    $l2t1=Exam::with('subject')
    ->where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('students_id',$request->input('students_id'))
    ->where('exam',$request->input('exam'))
    ->where('levelTerm','l2t1')
    ->get();
    //check if second year first semester request exam data present
    if(!count($l2t1)){
      $notification= array('title' => 'Not Found!', 'body' => 'Any subject of second year first semester for '.$request->input('exam').' not present!');
      return redirect()->back()->with("error",$notification);
    }
    $L2T1data=(object)$this->dataManupulator($l2t1);
    $l2t2=Exam::with('subject')
    ->where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('students_id',$request->input('students_id'))
    ->where('exam',$request->input('exam'))
    ->where('levelTerm','l2t2')
    ->get();
    //check if second year second semester request exam data present
    if(!count($l2t2)){
      $notification= array('title' => 'Not Found!', 'body' => 'Any subject of second year second semester for '.$request->input('exam').' not present!');
      return redirect()->back()->with("error",$notification);
    }
    $L2T2data=(object)$this->dataManupulator($l2t2);
    $syp=($L2T1data->totalPoint+$L2T2data->totalPoint);
    $syc=$L2T1data->totalCredit+$L2T2data->totalCredit;
    $syGPA=$syp/$syc;
    $syData =[
      'grade' => $this->yearGrade($syGPA),
      'point' => $syGPA,
      'credit' => $syc,
    ];
    //Second Year data colection code end
    $l3t1=Exam::with('subject')
    ->where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('students_id',$request->input('students_id'))
    ->where('exam',$request->input('exam'))
    ->where('levelTerm','l3t1')
    ->get();
    //check if third year first semester request exam data present
    if(!count($l3t1)){
      $notification= array('title' => 'Not Found!', 'body' => 'Any subject of Third year first semester for '.$request->input('exam').' not present!');
      return redirect()->back()->with("error",$notification);
    }
    $L3T1data=(object)$this->dataManupulator($l3t1);
    $l3t2=Exam::with('subject')
    ->where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('students_id',$request->input('students_id'))
    ->where('exam',$request->input('exam'))
    ->where('levelTerm','l3t2')
    ->get();
    //check if third year second semester request exam data present
    if(!count($l3t2)){
      $notification= array('title' => 'Not Found!', 'body' => 'Any subject of third year second semester for '.$request->input('exam').' not present!');
      return redirect()->back()->with("error",$notification);
    }
    $L3T2data=(object)$this->dataManupulator($l3t2);
    $typ=($L3T1data->totalPoint+$L3T2data->totalPoint);
    $tyc=$L3T1data->totalCredit+$L3T2data->totalCredit;
    $tyGPA=$typ/$tyc;
    $tyData =[
      'grade' => $this->yearGrade($tyGPA),
      'point' => $tyGPA,
      'credit' => $tyc,
    ];
    //third Year data colection code end
    //result Data
    $fPoint = (($fyp+$syp+$typ)/($fyc+$syc+$tyc));
    $fGrade= $this->yearGrade($fPoint);
    $fResult="FAIL";
    if($fPoint>0.00)
    {
      $fResult="PASS";
    }
    $result=[
      'point' => $fPoint,
      'grade' =>$fGrade,
      'result' => $fResult,
    ];
    $institute = Institute::select('name')->first();
    $department = Department::select('name')->where('id',$request->input('department_id'))->first();
    $session =$request->input('session');
    $student= Student::findOrFail($request->input('students_id'));
    $metaDatas= [
      'institute' => $institute->name,
      'department' => $department->name,
      'session' => $session,
      'name'    => $student->firstName.' '.$student->middleName.' '.$student->lastName,
      'fatherName' => $student->fatherName,
      'motherName' => $student->motherName,
      'dob' => $student->dob->format('F j,Y'),
      'idNo' => $student->idNo,
      'bncReg' => $student->bncReg,
      'exam' => $request->input('exam')
    ];
    $metaData= (object)$metaDatas;
    return view('reports.result.transcript',compact('metaData','L1T1data','L1T2data','fyData','L2T1data','L2T2data','syData','L3T1data','L3T2data','tyData','result'));
  }


  private function calculateScore($Midterm,$Final,$LabandQuiz)
  {
    $allData=[];
    $i=0;
    foreach ($Midterm as $student) {
      $totalScore=$student->percentage_x_weight+$Final[$i]->percentage_x_weight+$LabandQuiz[$i]->percentage_x_weight;
      $totalWeight=$student->weight+$Final[$i]->weight+$LabandQuiz[$i]->weight;
      $gradePoint=$totalScore/$totalWeight;
      $grade=$this->gradeCalculator($gradePoint);
      $singleSTD =[
        'idNo' => $student->student->idNo,
        'name' => $student->student->firstName.' '.$student->student->middleName.' '.$student->student->lastName,
        'm_Raw' => $student->raw_score,
        'm_percentage' => $student->percentage,
        'm_weight' => $student->weight,
        'm_percentage_x_weight' => $student->percentage_x_weight,
        'f_Raw' => $Final[$i]->raw_score,
        'f_percentage' => $Final[$i]->percentage,
        'f_weight' => $Final[$i]->weight,
        'f_percentage_x_weight' => $Final[$i]->percentage_x_weight,
        'l_Raw' => $LabandQuiz[$i]->raw_score,
        'l_percentage' => $LabandQuiz[$i]->percentage,
        'l_weight' => $LabandQuiz[$i]->weight,
        'l_percentage_x_weight' => $LabandQuiz[$i]->percentage_x_weight,
        'total_score' => $totalScore,
        'total_weight' =>$totalWeight,
        'grade_point' => $gradePoint,
        'grade' => $grade[0],
      ];
      $allData[]=$singleSTD;
      $i++;
    }

    return $allData;
  }

  private function gradeCalculator($point){
    $grade="F";
    $gpa="0";
    if($point>=80.00){
      $grade="A";
      $gpa="4";
    }
    else if($point>=70.00){
      $grade="B";
      $gpa="3";
    }
    else if($point>=60.00){
      $grade="C";
      $gpa="2";
    }
    else if($point>=50.00){
      $grade="D";
      $gpa="1";
    }
    else{
      $grade="F";
      $gpa="0";
    }

    return [$grade,$gpa];
  }

  private function dataManupulator($l1t1){
    $totalCredit=0;
    $totalPoint=0;
    foreach ($l1t1 as $marks) {
      $point = ($marks->percentage_x_weight/$marks->weight);
      $gGpa = $this->gradeCalculator($point);
      $subPoint=$gGpa[1]*$marks->subject->credit;
      $totalCredit +=$marks->subject->credit;
      $totalPoint +=$subPoint;
      $singleSub=[
        'course' => $marks->subject->code.': '.$marks->subject->name,
        'credit' => $marks->subject->credit,
        'grade'  => $gGpa[0],
        'point'  =>$subPoint,
      ];
      $allSubject[]=$singleSub;
    }
    $semGrade = round(($totalPoint/$totalCredit),2);
    return ['monthYear'=>$l1t1[0]->created_at->format('F,Y'),'semGrade'=>$semGrade,'totalCredit'=>$totalCredit,'totalPoint'=>$totalPoint,'subjects'=>$allSubject];
  }

  private function yearGrade($point){
    $grade="F";
    if($point>=4.00){
      $grade="A";
    }
    else if($point>=3.00){
      $grade="B";
    }
    else if($point>=2.00){
      $grade="C";
    }
    else if($point>=1.00){
      $grade="D";
    }
    else{
      $grade="F";

    }
    return $grade;

  }

}

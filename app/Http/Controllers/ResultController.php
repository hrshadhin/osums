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
    return $results=Exam::with('subject')
    ->where('department_id',$request->input('department_id'))
    ->where('session',$request->input('session'))
    ->where('students_id',$request->input('students_id'))
    ->where('exam',$request->input('exam'))
    ->get();
  }


  private function calculateScore($Midterm,$Final,$LabandQuiz)
  {
    $allData=[];
    $i=0;
    foreach ($Midterm as $student) {
      $totalScore=$student->percentage_x_weight+$Final[$i]->percentage_x_weight+$LabandQuiz[$i]->percentage_x_weight;
      $totalWeight=$student->weight+$Final[$i]->weight+$LabandQuiz[$i]->weight;
      $gradePoint=$totalScore/$totalWeight;
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
        'grade' => $this->gradeCalculator($gradePoint),
      ];
      $allData[]=$singleSTD;
      $i++;
    }

    return $allData;
  }

  private function gradeCalculator($point){
    $grade="F";
    if($point>=80.00)
      $grade="A";
    else if($point>=70.00)
      $grade="B";
    else if($point>=60.00)
      $grade="C";
    else if($point>=50.00)
      $grade="D";
    else
      $grade="F";

    return $grade;
  }

}

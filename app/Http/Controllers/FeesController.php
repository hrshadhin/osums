<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Validator;
use App\FeeCollection;
use App\Department;
use App\Fee;
use Carbon\Carbon;
use DB;
use App\Sector;
use App\Account;
use App\Student;
use Session;
use App\Registration;
use App\Institute;
class FeesController extends Controller
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
    public function index()
    {
        $departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
        $fees = Fee::with('department')->get();
        return view('fees.lists',compact('departments','fees'));
    }
    public function store(Request $request)
    {
        $data=$request->all();
        $rules=[
            'department_id' => 'required',
            'title' => 'required',
            'amount'=> 'required|numeric',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }
        else {
            Fee::create($request->all());
            $notification= array('title' => 'Data Store', 'body' => 'Fee created Succesfully.');
            return redirect()->back()->with("success",$notification);
        }

    }

    public function destroy($id)
    {
        $fee = Fee::findOrFail($id);
        $fee->delete();
        $notification= array('title' => 'Data Delete', 'body' => 'Fee deleted Succesfully.');
        return redirect()->back()->with("success",$notification);
    }
    public function show($id)
    {
        $fee = Fee::findOrFail($id);
        return Response()->json([
            'success' => true,
            'fee' => $fee->amount
        ], 200);
    }
    public function lists($dId)
    {
        $fees = Fee::select('id','title')->where('department_id',$dId)->get();
        return Response()->json([
            'success' => true,
            'fees' => $fees
        ], 200);
    }
    public function getDue($stdId)
    {
        $due = FeeCollection::select(DB::RAW('IFNULL(sum(payableAmount),0)- IFNULL(sum(paidAmount),0) as dueamount'))
        ->where('students_id',$stdId)
        ->first();
        return Response()->json([
            'success' => true,
            'due' => $due->dueamount
        ], 200);
    }



    public function cCreate(){
        $isFeeSector= Sector::where('name','Fees')->where('type','Income')->first();
        $today = Carbon::today();
        $students=[];
        $semesters= $this->semesters;
        $departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
        $sessions=Student::select('session','session')->distinct()->lists('session','session');

        if(!count($isFeeSector)){
            $notification= array('title' => 'Data Missing', 'body' => '"Fees" income sector missiong in accounting! Without it fee collection not possible.');
            session::flash('error',$notification);
        }
        return view('fees.collection',compact('departments','sessions','students','semesters','today'));
    }
    public function cStore(Request $request){
        $isFeeSector= Sector::where('name','Fees')->where('type','Income')->first();
        if(!count($isFeeSector)){
            $notification= array('title' => 'Data Missing', 'body' => '"Fees" income sector missiong in accounting! Without it fee collection not possible.');
            return redirect()->back()->with('error',$notification);
        }
        $data=$request->all();
        $rules=[
            'students_id' => 'required',
            'gtotal' => 'required|numeric',
            'lateFee'=> 'required|numeric',
            'paidamount'=> 'required|numeric',
            'dueamount'=> 'required|numeric',
            'payDate'=> 'required',
            'fees'=> 'required',
            'fee'=> 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }
        $feeData = [
            'students_id' => $data['students_id'],
            'payableAmount' => $data['gtotal'],
            'lateFee' => $data['lateFee'],
            'paidAmount' => $data['paidamount'],
            'dueAmount' => $data['dueamount'],
            'payDate' => $data['payDate']
        ];
        DB::beginTransaction();
        try {
            try {
                $feeCol = FeeCollection::create($feeData);
            }catch(\Exception $e)
            {
                DB::rollback();
                throw $e;
            }
            foreach ($data['fees'] as $key => $value){
                $feeItemData[] = [
                    'fee_collections_id' =>$feeCol->id,
                    'name' => $value,
                    'amount' => $data['fee'][$key]
                ];
            }
            try{
                DB::table('fee_collection_items')->insert($feeItemData);
            }catch(\Exception $e)
            {
                DB::rollback();
                throw $e;
            }
            if($data['paidamount']>0.00){
                $acData =[
                    'sectors_id' => $isFeeSector->id,
                    'amount'=> $data['paidamount'],
                    'date'=> $data['payDate'],
                    'description' => 'Student fee collections'
                ];
                try{
                    $isSuccess=Account::create($acData);
                }catch(\Exception $e)
                {
                    DB::rollback();
                    throw $e;
                }

            }

        }
        catch(\Exception $e){
            $trimmed = str_replace(array("\r", "\n"), ' ', $e->getMessage());
            $notification= array('title' => 'Data Store Failed', 'body' => $trimmed);
            return redirect()->back()->with("error",$notification);
        }
        DB::commit();
        $notification= array('title' => 'Data Store', 'body' => 'Fee collection Succesfully.');
        return redirect()->back()->with("success",$notification);
    }


}

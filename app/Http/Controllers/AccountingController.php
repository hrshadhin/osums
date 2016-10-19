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
class AccountingController extends Controller
{
    public function __construct()
    {
        $this->middleware('account');
    }
    public function secIndex()
    {
        $sectors = Sector::all();
        return view('account.sector',compact('sectors'));
    }
    public function secStore(Request $request)
    {
        $data=$request->all();
        $rules=[
            'name' => 'required',
            'type'=> 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }
        else {
            Sector::create($request->all());
            $notification= array('title' => 'Data Store', 'body' => 'Sector created Succesfully.');
            return redirect()->back()->with("success",$notification);
        }

    }

    public function secDestroy($id)
    {
        $sector = Sector::findOrFail($id);
        $sector->delete();
        $notification= array('title' => 'Data Delete', 'body' => 'Sector deleted Succesfully.');
        return redirect()->back()->with("success",$notification);
    }
    //for income
    public function inIndex()
    {
        $sectors = Sector::select('id','name')->where('type','Income')->orderby('name','asc')->lists('name', 'id');
        $incomes= Account::with(array('sector' =>  function($query){
            $query->where('type','Income');
        }))->whereHas('sector',function($query){
            $query->where('type','Income');
        })->get();
        $today=Carbon::now();
        return view('account.income',compact('sectors','incomes','today'));
    }
    public function inStore(Request $request)
    {
        $rules=[
            'sectors_id' => 'required',
            'amount'=> 'required:numeric',
            'date'=> 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }
        else {
            Account::create($request->all());
            $notification= array('title' => 'Data Store', 'body' => 'Income added Succesfully.');
            return redirect()->back()->with("success",$notification);
        }

    }

    public function inDestroy($id)
    {
        $income = Account::findOrFail($id);
        $income->delete();
        $notification= array('title' => 'Data Delete', 'body' => 'Income deleted Succesfully.');
        return redirect()->back()->with("success",$notification);
    }
    //for Expence
    public function exIndex()
    {
        $sectors = Sector::select('id','name')->where('type','Expence')->orderby('name','asc')->lists('name', 'id');
        $expences= Account::with(array('sector' =>  function($query){
            $query->where('type','Expence');
        }))->whereHas('sector',function($query){
            $query->where('type','Expence');
        })->get();
        $today=Carbon::now();
        return view('account.expence',compact('sectors','expences','today'));
    }
    public function exStore(Request $request)
    {
        $rules=[
            'sectors_id' => 'required',
            'amount'=> 'required:numeric',
            'date'=> 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }
        else {
            Account::create($request->all());
            $notification= array('title' => 'Data Store', 'body' => 'Income added Succesfully.');
            return redirect()->back()->with("success",$notification);
        }

    }

    public function exDestroy($id)
    {
        $income = Account::findOrFail($id);
        $income->delete();
        $notification= array('title' => 'Data Delete', 'body' => 'Income deleted Succesfully.');
        return redirect()->back()->with("success",$notification);
    }

    
}

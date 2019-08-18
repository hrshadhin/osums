<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Institute;

class instituteController extends Controller {

	public function __construct()
	{
		$this->middleware('admin');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$institute= Institute::select("*")->first();
		if(!$institute)
		{
			$institute=new Institute;
			$institute->name = "";
			$institute->establish = "";
			$institute->web = "";
			$institute->email = "";
			$institute->phoneNo = "";
			$institute->address = "";
		}

		return view('institute',compact('institute'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function save(Request $request)
	{
		$data=$request->all();
		$rules=[
				'name' => 'required',
				'establish' => 'required',
				'web' => 'required',
				'email' => 'required',
				'phoneNo' => 'required',
				'address' => 'required',


		];
		$validator = \Validator::make($data, $rules);
		if ($validator->fails())
		{
				return Redirect::to('/institute')->withinput()->withErrors($validator);
		}
		else {

  			DB::table("institute")->delete();
  			$institue=new Institute;

  			$institue->name = $data['name'];
  			$institue->establish = $data['establish'];
  		  $institue->web = $data['web'];
  		  $institue->email = $data['email'];
  		  $institue->phoneNo = $data['phoneNo'];
  			$institue->address = $data['address'];
  		 	$institue->save();
        $notification= array('title' => 'Data Store', 'body' => 'Institute  Information saved.');
  			return redirect('/institute')->with('success',$notification);

	}
}
}

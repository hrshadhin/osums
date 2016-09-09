<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Session;
use App\Institute;
use Validator;
use Hash;
class UserController extends Controller {


	/**
	* Make Login
	*
	* @return Response
	*/
	public function login()
	{

		if (Auth::attempt(array('login'=>Input::get('login'), 'password'=>Input::get('password')))) {
			$name=Auth::user()->firstname.' '.Auth::user()->lastname;
			Session::put('name', $name);

			$institute=Institute::select('name')->first();
			if(!$institute)
			{
				if (Auth::user()->group != "Admin")
				{
					return Redirect::to('/')->with('warning','Institute Information not setup yet! Please contact administrator.');
				}
				else {
					$institute=new Institute;
					$institute->name="ShanixLab";
					Session::put('inName', $institute->name);
					$notification= array('title' => 'Information Missing', 'body' => 'Please provide institute information.');
					return Redirect::to('/institute')->with('warning',$notification);

				}
			}
			else {
				Session::put('inName', $institute->name);
				$notification= array('title' => 'Login', 'body' => 'You are now logged in.');
				return Redirect::to('/dashboard')->with('success',$notification);
			}

		} else {
			return Redirect::to('/')->with('error', 'Your username/password combination was incorrect');

		}



	}

	public function logout()
	{
		Auth::logout();
		return Redirect::to('/')->with('success', 'Your are now logged out!');
	}


	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create()
	{
		//
	}


	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store()
	{

	}


	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id)
	{
		//
	}


	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($id)
	{
		//
	}


	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($id)
	{
		//
	}


	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{
		//
	}
	/**
	* Remove the specified resource from storage.
	*
	*@return Response
	*/
	public function settings()
	{
		$user = auth()->user();
		return view('user.settings',compact('user'));
	}

	public function postSettings(Request $request)
	{

		if ($request->exists('for'))
		{
			$data = $request->except(['userName','group']);
			if($request->input('for')=="info")
			{
				$rules=[
					'firstname' => 'required',
					'lastname' => 'required',
					'email' => 'email',

				];
			}
			else {
				if(!Hash::check($request->input('oldpassword'), auth()->user()->password)){
					$notification= array('title' => 'Validation Error', 'body' => 'Old Password did not match!!!');
					return Redirect::back()->with('error',$notification);
				}
				$rules=[
					'oldpassword' => 'required|min:6',
					'password' => 'required|confirmed|min:6'
				];
			}
			$validator = Validator::make($data, $rules);
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator);
			}


			$user = User::findOrFail(auth()->user()->id);
			$user->fill($data)->save();
			$notification= array('title' => 'Data Change', 'body' => 'Information Updated Successfully');
			return Redirect::back()->with('success',$notification);
		}
		return Redirect::back()->with('error','Invalid request!!!');


	}


}

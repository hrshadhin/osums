<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use App\Institute;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		$error = Session::get('error');
		$institute=Institute::select('name')->first();
		if(!$institute)
		{
			$institute=new Institute;
			$institute->name="ShanixLab";
		}
		return view('home',compact('error','institute'));
	}
	public function lock()
	{
		$user= auth()->user();
		if(!$user)
		return redirect()->to('/')->with('warning', 'Session expired,login again.');
		auth()->logout();

		return view('lock',compact('user'));
	}

}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

class DashboardController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$error = Session::get('error');
    	$success=Session::get('success');

	  	return view('dashboard',compact('error','success'));
	}


}

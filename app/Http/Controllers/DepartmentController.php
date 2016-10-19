<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator;

use App\Http\Controllers\Controller;
use App\Department;

class DepartmentController extends Controller {

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
		$departments = Department::all();
		return view('department.index',compact('departments'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
			return view('department.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$data=$request->all();
		$rules=[
        'name' => 'required',
				'code' => 'required|unique:department,code',
				'credit' => 'required|numeric',
				'years' => 'required|numeric',
				'description' => 'required|max:255'
		];
		$validator = Validator::make($data, $rules);
		if ($validator->fails())
    {
        return Redirect::route('department.create')->withInput()->withErrors($validator);
    }
		else {
                $department = new Department;
                $department->create($data);
								$notification= array('title' => 'Data Store', 'body' => 'Department Created Succesfully.');
                return Redirect::route('department.create')->with("success",$notification);
    }


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
		try
		{
		    $department = Department::findOrFail($id);
				return view('department.edit',compact('department'));
		}
		catch (Exception $e)
		{
			$notification= array('title' => 'Data Edit', 'body' => "There is no record.");
			return Redirect::route('department.index')->with("error",$notification);
		}


	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$data=$request->all();
		$rules=[
        'name' => 'required',
				'code' => 'required',
				'credit' => 'required|numeric',
				'years' => 'required|numeric',
				'description' => 'required|max:255'
		];
		$validator = Validator::make($data, $rules);
		if ($validator->fails())
    {
        return Redirect::back()->withErrors($validator);
    }
		else {
						try {
                $department = Department::findOrFail($id);
								$department->fill($data)->save();
								$notification= array('title' => 'Data Update', 'body' => 'Department Updated Succesfully.');
                return Redirect::route('department.index')->with("success",$notification);
						}
						catch (Exception $e)
						{
							$notification= array('title' => 'Data Update', 'body' => "There is no record.");
							return Redirect::route('department.index')->with("error",$notification);
						}
    }

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$department = Department::findOrFail($id);
		$department->delete();
		$notification= array('title' => 'Data Delete', 'body' => 'Department Deleted Succesfully.');
		return Redirect::route('department.index')->with("success",$notification);

	}


}

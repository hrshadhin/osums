<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use DB;
use App\Department;
use App\Book;
use App\Student;
use App\BorrowBook;
use App\Institute;
class libraryController extends Controller
{
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
	public function __construct()
	{
		$this->middleware('teacher');
	}

	public function getAddbook()
	{
		$departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
		return view('library.addbook',compact('departments'));
	}


	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function postAddbook(Request $request)
	{
		$rules=[
			'code' => 'required|max:50|unique:books,code',
			'title' => 'required|max:250',
			'author' => 'required|max:100',
			'type' => 'required',
			'department' => 'required'
		];
		$validator = \Validator::make($request->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/library/addbook')->withErrors($validator)->withInput();
		}
		else {

			$book = new Book();
			$book->code = $request->get('code');
			$book->title = $request->get('title');
			$book->author = $request->get('author');
			$book->quantity = $request->get('quantity');
			$book->rackNo = $request->get('rackNo');
			$book->rowNo = $request->get('rowNo');
			$book->type = $request->get('type');
			$book->department_id = $request->get('department');
			$book->desc = $request->get('desc');
			$book->save();
			$notification= array('title' => 'Data Store', 'body' => 'Book added succesfully.');
			return Redirect::to('/library/addbook')->with("success", $notification);


		}

	}


	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function getviewbook(Request $request)
	{
		$departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
		$department = "";
		if($request->has('department')){
			$department = $request->get('department');
		}
		$books = DB::table('books')
		->join('department', 'books.department_id', '=', 'department.id')
		->select('books.id', 'books.code', 'books.title', 'books.author','books.quantity','books.rackNo','books.rowNo','books.type','books.desc','department.name as department')
		->where('books.department_id',$department)
		->where('books.deleted_at',NULL)
		->paginate(50);

		return view('library.booklist',compact('departments','department','books'));
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function getBook($id)
	{
		$departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
		$book= Book::select('*')->find($id);
		return view('library.bookedit',compact('departments','book'));
	}


	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function postUpdateBook(Request $request)
	{
		$rules=[
			//'code' => 'required|max:50',
			'title' => 'required|max:250',
			'author' => 'required|max:100',
			'type' => 'required',
			'department' => 'required'
		];
		$validator = \Validator::make($request->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/library/edit/'.$request->get('id'))->withErrors($validator)->withInput();
		}
		else {

			$book = Book::find($request->get('id'));
			//$book->code = $request->get('code');
			$book->title = $request->get('title');
			$book->author = $request->get('author');
			$book->quantity = $request->get('quantity');
			$book->rackNo = $request->get('rackNo');
			$book->rowNo = $request->get('rowNo');
			$book->type = $request->get('type');
			$book->department_id = $request->get('department');
			$book->desc = $request->get('desc');
			$book->save();
			$notification= array('title' => 'Data Update', 'body' => 'Book updated succesfully.');
			return Redirect::to('/library/view')->with("success",$notification);

		}

	}


	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function deleteBook($id)
	{
		$book = Book::find($id);
		$book->delete();
		$notification= array('title' => 'Data Delete', 'body' => 'Book deleted succesfully.');
		return Redirect::to('/library/view')->with("success", $notification);
	}

	public function getissueBook()
	{
		$semesters = $this->semesters;
		$students=[];
		$departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
		$sessions=Student::select('session','session')->distinct()->lists('session','session');
		$books = Book::select(DB::raw("CONCAT(title,'[',author,']#',code) as name,id"))->lists('name','id');
		return view('library.bookissue',compact('students','semesters','departments','sessions','','books'));
	}

	public function postissueBook(Request $request)
	{
		$rules=[
			'students_id' => 'required',
			'issueDate' => 'required',
			'bookCode' => 'required',
			'quantity' => 'required',
			'returnDate' => 'required',

		];
		$validator = \Validator::make($request->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/library/issuebook')->withErrors($validator)->withInput();
		}
		else {

			$data=$request->all();
			$issueData = [];
			$now=\Carbon\Carbon::now();
			foreach ($data['bookCode'] as $key => $value){
				$issueData[] = [
					'students_id' => $data['students_id'],
					'issueDate' => $this->parseAppDate($data['issueDate']),
					'books_id' => $value,
					'quantity' => $data['quantity'][$key],
					'returnDate' => $this->parseAppDate($data['returnDate'][$key]),
					'fine' => $data['fine'][$key],
					'created_at' => $now,
					'updated_at' => $now,
				];

			}
			BorrowBook::insert($issueData);
			$notification= array('title' => 'Data Store', 'body' => 'Succesfully book borrowed.');
			return Redirect::to('/library/issuebook')->with("success",$notification);

		}

	}
	public function getissueBookview()
	{
		$status="";
		return view('library.bookissueview',compact('status'));
	}
	public function postissueBookview(Request $request)
	{
		if($request->get('status')!="")
		{
			$books = DB::table('borrow_books')
			->leftJoin('students', 'borrow_books.students_id', '=', 'students.id')
			->leftJoin('books', 'borrow_books.books_id', '=', 'books.id')
			->select('students.firstName', 'students.middleName', 'students.lastName',
			'books.code','borrow_books.id','borrow_books.quantity','borrow_books.issueDate',
			'borrow_books.returnDate','borrow_books.fine','borrow_books.status')
			->where('borrow_books.status','=',$request->get('status'))
			->where('borrow_books.deleted_at','=',NULL)
			->orWhere('books.code','=',$request->get('code'))
			->orWhere('borrow_books.issueDate','=',$this->parseAppDate($request->get('issueDate')))
			->orWhere('borrow_books.returnDate','=',$this->parseAppDate($request->get('returnDate')))
			->get();
			$status = $request->get('status');
			return view('library.bookissueview',compact('books','status'));

		}
		else {
			$notification= array('title' => 'Form Validation', 'body' => 'Pleae fill up at least one feild!');
			return Redirect::to('/library/issuebookview')->with("error",$notification);
		}

	}
	public function getissueBookupdate($id)
	{
		$book= BorrowBook::find($id);
		$bookInfo = Book::where('id',$book->books_id)->first();
		return view('library.bookissueedit',compact('book','bookInfo'));
	}
	public function postissueBookupdate(Request $request)
	{
		$rules=[
			'returnDate' => 'required',
			'status' => 'required',

		];
		$validator = \Validator::make($request->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/library/issuebookupdate/'.$request->get('id'))->withErrors($validator);
		}
		else {

			$book = BorrowBook::find($request->get('id'));
			$book->returnDate = $this->parseAppDate($request->get('returnDate'));
			$book->fine = $request->get('fine');
			$book->Status = $request->get('status');
			$book->save();
			$notification= array('title' => 'Data Update', 'body' => 'Succesfully book record updated.');
			return Redirect::to('/library/issuebookview')->with("success",$notification);

		}
	}

	public function deleteissueBook($id)
	{
		$book= BorrowBook::find($id);
		$book->delete();
		$notification= array('title' => 'Data Delete', 'body' => 'Succesfully book record deleted.');
		return Redirect::to('/library/issuebookview')->with("success",$notification);
	}
	public function getsearch()
	{
		$departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
		$inputs = [
			"code"=>"",
			"title"=>"",
			"author"=>"",
			"type"=>"",
			"department"=>""
		];
		return view('library.booksearch',compact('departments','inputs'));
	}
	public function postsearch(Request $request)
	{
		if($request->get('code')!="" || $request->get('title')!="" || $request->get('author') !="")
		{
			$query=Book::leftJoin('department', function($join) {
				$join->on('books.department_id', '=', 'department.id');

			})
			->leftJoin('stock_books','books.id', '=', 'stock_books.books_id')
			->select('books.id', 'books.code', 'books.title', 'books.author','stock_books.quantity','books.rackNo','books.rowNo','books.type','books.desc','department.name');
			if($request->get('code')!="") $query->where('books.code','=',$request->get('code'));
			if($request->get('title')!="")$query->orWhere('books.title','LIKE','%'.$request->get('title').'%');
			if($request->get('author') !="")$query->orWhere('books.author','LIKE','%'.$request->get('author').'%');


			$books=$query->get();

			$inputs = [
				"code" => $request->get('code'),
				"title" => $request->get('title'),
				"author" => $request->get('author'),
				"type" => "",
				"department" => ""
			];
			$departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
			return view('library.booksearch',compact('books','departments','inputs'));

		}
		else {

			return Redirect::to('/library/search')->with("error","Pleae fill up at least one feild!");

		}
	}
	public function postsearch2(Request $request)
	{
		$rules=[
			'type' => 'required',
			'department' => 'required',


		];
		$validator = \Validator::make($request->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/library/search')->withErrors($validator);
		}
		else {
			$books = DB::table('books')
			->join('department', 'books.department_id', '=', 'department.id')
			->join('stock_books','books.id', '=', 'stock_books.books_id')
			->select('books.id', 'books.code', 'books.title', 'books.author','stock_books.quantity','books.rackNo','books.rowNo','books.type','books.desc','department.name')
			->where('books.department_id',$request->get('department'))
			->where('books.type',$request->get('type'))->get();


			$inputs = [
				"code" => "",
				"title" => "",
				"author" => "",
				"type" => $request->get('type'),
				"department" => $request->get('department')
			];
			$departments = Department::select('id','name')->orderby('name','asc')->lists('name', 'id');
			return view('library.booksearch',compact('books','departments','inputs'));


		}
	}

	public function getReports()
	{

		return view('library.libraryReports');
	}

	public function Reportprint($do)
	{
		if($do=="today")
		{
			$todayReturn = DB::table('borrow_books')
			->leftJoin('students', 'borrow_books.students_id', '=', 'students.id')
			->leftJoin('books', 'borrow_books.books_id', '=', 'books.id')
			->select('students.firstName', 'students.middleName', 'students.lastName','students.idNo',
			'books.code','borrow_books.id','borrow_books.quantity','borrow_books.issueDate as date',
			'books.title','borrow_books.fine','books.author','books.type')
			->where('borrow_books.returnDate',date('Y-m-d'))
			->where('borrow_books.Status','Borrowed')
			->get();
			$rdata =array('do'=>1,'name'=>'Today Return List','total'=>count($todayReturn));

			$datas=$todayReturn;
			$institute=Institute::select('*')->first();
			return view('library.libraryreportprinttex',compact('datas','rdata','institute'));

		}
		else if($do=="expire")
		{
			$expires = DB::table('borrow_books')
			->leftJoin('students', 'borrow_books.students_id', '=', 'students.id')
			->leftJoin('books', 'borrow_books.books_id', '=', 'books.id')
			->select('students.firstName', 'students.middleName', 'students.lastName','students.idNo',
			'books.code','borrow_books.id','borrow_books.quantity','borrow_books.returnDate as date',
			'books.title','borrow_books.fine','books.author','books.type')
			->where('borrow_books.returnDate','<',date('Y-m-d'))
			->where('borrow_books.Status','Borrowed')
			->get();
			$rdata =array('do'=>2,'name'=>'Today Expire List','total'=>count($expires));

			$datas=$expires;
			$institute=Institute::select('*')->first();
			return view('library.libraryreportprinttex',compact('datas','rdata','institute'));

		}
		else {
			$books = Book::select('*')->with('stock')->where('type',$do)->get();
			$rdata =array('name'=>$do,'total'=>count($books));
			$datas=$books;
			$institute=Institute::select('*')->first();
			return view('library.libraryreportbooks',compact('datas','rdata','institute'));
		}
		return $do;
	}
	public function getReportsFine()
	{
		return view('library.libraryfinereport');
	}
	public function ReportsFineprint($monthYear)
	{
		$sqlraw="select sum(fine) as totalFine from borrow_books where status='Returned' and EXTRACT(YEAR_MONTH FROM returnDate) = EXTRACT(YEAR_MONTH FROM '".$monthYear."-01')";
		$fines = DB::select(DB::RAW($sqlraw));
		if($fines[0]->totalFine)
		{
			$total=$fines[0]->totalFine;
		}
		else
		{
			$total=0;
		}
		$institute=Institute::select('*')->first();
		$rdata =array('month'=>date('F-Y', strtotime($monthYear)),'name'=>'Monthly Fine Collection Report','total'=>$total);
		return view('library.libraryfinereportprint',compact('rdata','institute'));
	}
	private function  parseAppDate($datestr)
	{

		if($datestr=="" or $datestr== NULL)
		return $datestr="0000-00-00";
		$date = explode('/', $datestr);
		return $date[2].'-'.$date[1].'-'.$date[0];
	}

	public function checkBookAvailability($books_id,$quantity)
	{
		$availabeQuantity=DB::table('stock_books')
		->select('quantity')
		->where('books_id',$books_id)->first();
		$result = "Yes";
		if($quantity>$availabeQuantity->quantity)
		$result = "No";
		return ["isAvailable" => $result ];


	}

}

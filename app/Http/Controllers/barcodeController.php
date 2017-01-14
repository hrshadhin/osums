<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Picqer\Barcode;

class barcodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('teacher');
    }

    public function index()
    {
        return view('library.barcodeform');

    }
    /**
    * Display a listing of the resource.
    * POST /barcode
    *
    * @return Response
    */
    public function generate(Request $request)
    {

        $rules=[
            'code' => 'required|min:10|max:10'

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/barcode')->withErrors($validator);
        }
        else {
            try {

                $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                $code=$request->get('code');

                $barcodesc1=array();
                for($i=1;$i<17;$i++)
                {

                    $img=base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128));
                    $barcode = array("img"=>$img,"code"=>strval($code));
                    array_push($barcodesc1,$barcode);
                    $code+=1;
                }
                $barcodesc2=array();
                for($i=1;$i<17;$i++)
                {

                    $img=base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128));

                    $barcode = array("img"=>$img,"code"=>strval($code));
                    array_push($barcodesc2,$barcode);
                    $code+=1;
                }
                $barcodesc3=array();
                for($i=1;$i<17;$i++)
                {

                    $img=base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128));

                    $barcode = array("img"=>$img,"code"=>strval($code));
                    array_push($barcodesc3,$barcode);
                    $code+=1;
                }

                return view('library.barcode',compact('barcodesc1','barcodesc2','barcodesc3'));

            } catch (Exception $e) {
                $validator->errors()->add('Invalid', 'Please give valid number.');
                return Redirect::to('/barcode')->withErrors($validator);
            }
        }

    }

}

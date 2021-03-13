<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchchaser; 
use App\Models\Product; 
use Validator;
use Response;
use \Illuminate\Http\Response as Res;

class PurchaserController extends Controller
{

    protected $statusCode = Res::HTTP_OK;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Purchchaser::orderBy('name', 'ASC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $rules=array(
            'name' => 'required|unique:purchchasers'
            );
        $messages=array(
                'name.required' => 'purchaser name should not be empty.',
                'name.unique' => 'purchaser already registered!.',
          );
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return $this->respondWithError($errors,500);
        }

 
        $newPurchaser = new Purchchaser;
        $newPurchaser->name = $request->name;
        $newPurchaser->save();

        return response()->json([
            'message' => 'Successfully created new purchaser!'
        ], 201);

    }



    public function respondWithError($message, $errcode){
        return $this->respond([
            'status' => 'error',
            'status_code' => $errcode,
            'message' => $message,
        ]);
    }

    public function respond($data, $headers = []){
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $fromDate = date("Y-m-d H:i:s", $request->query('start_date'));
        $toDate   = date("Y-m-d H:i:s", $request->query('end_date'));
         
        $products = Purchchaser::find($id)
        ->whereBetween('purchase_timestamp',[$fromDate, $toDate]);
        $purchase = $products->products;
        return $purchase;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductPurchase;
use Validator;
use Response;
use \Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection; 

class ProductPurchaseController extends Controller
{

    
    protected $statusCode = Res::HTTP_OK;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductPurchase::orderBy('purchase_timestamp', 'ASC')->get();
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
            'purchase_id' => 'required|exists:purchchasers,id',
            'product_id' => 'required|exists:products,id',
            'purchase_timestamp' => 'required'
            );
        $messages=array(
                'purchase_timestamp.required' => 'purchaser timestamp is required.',
                'purchase_id.required' => 'purchaser id field is required!.',
                'purchase_id.exists' => 'Purchase id does not an exist!',
                'product_id.required' => 'product_id id field is required!.',
                'product_id.exists' => 'product_id id does not an exist!',
          );

 
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return $this->respondWithError($errors,500);
        }

        $purchaseProduct = new ProductPurchase([
            'purchase_id' => $request->purchase_id,
            'product_id' => $request->product_id,
            'purchase_timestamp' => date("Y-m-d H:i:s", $request->purchase_timestamp),  
        ]);
        $purchaseProduct->save();
        return response()->json([
            'message' => 'Successfully created purchase record!'
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
        $checked = $request->has('start_date') ? true: false;
        if(!$checked)
        return self::showNoParams($id);

        $fromDate = date("Y-m-d H:i:s", $request->query('start_date'));
        $toDate   = date("Y-m-d H:i:s", $request->query('end_date'));
 
       $posts = DB::table('products') ->where('purchase_id',$id)
       ->join('product_purchases', 'products.id', '=', 'product_purchases.product_id')
       ->select('products.name', 'product_purchases.purchase_timestamp')
       ->whereBetween('purchase_timestamp',[$fromDate, $toDate])
       ->orderBy('purchase_timestamp','DESC') 
       ->get()
       ->groupBy('purchase_timestamp');
       
       $Response = array('purchases' => $posts); 
       
       return $Response;
        
    }

    //When API called with no parameters
    public function showNoParams($id)
    { 
       $posts = DB::table('products') ->where('purchase_id',$id)
       ->join('product_purchases', 'products.id', '=', 'product_purchases.product_id')
       ->select('products.name', 'product_purchases.purchase_timestamp') 
       ->orderBy('purchase_timestamp','DESC') 
       ->get()
       ->groupBy('purchase_timestamp');
       
       $Response = array('purchases' => $posts); 
       
       return $Response;
        
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

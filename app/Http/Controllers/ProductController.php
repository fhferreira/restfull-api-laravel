<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use App\Acme\Transformers\ProductTransformer;

class ProductController extends ApiController
{

    protected $productTransformer;

    public function __construct(ProductTransformer $productTransformer)
    {
        $this->productTransformer = $productTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = \App\Product::all();
        #bad-pratices
        //1. All is bad
        //2. No way to attach meta data - $hidden;
        //3. Linking db structure to the API Output
        //4. No way to signal headers/response codes

        #test - curl -i http://localhost:8000/product
        #status-codes: https://www.ietf.org/rfc/rfc2616.txt

        if ( \Request::has("showCategory") && \Request::get("showCategory") == 1)
        {
            $products->load("category");
        }
        return Response::json([ 
            'data' => $this->productTransformer->transformCollection($products->toArray())
            ], 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            
            $product = \App\Product::findOrFail($id);
            
            if ( \Request::has("showCategory") && \Request::get("showCategory") == 1)
            {
                $product->load("category");
            }

            return Response::json([
                'data' => $this->productTransformer->transform($product->toArray())
                ], 200);

        } catch (\Exception $e) {

            return $this->respondNotFound("Product not found");

            //return \Response::json(['error' => [
            //    'message' => 'Product not found',
            //    'code' => 1
            //    ]
            //], 404);

        }
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

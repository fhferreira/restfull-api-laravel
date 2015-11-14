<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use App\Acme\Transformers\ProductTransformer;

class ProductController extends ApiController
{

    protected $productTransformer;

    public function __construct(ProductTransformer $productTransformer)
    {
        $this->productTransformer = $productTransformer;

        //$this->beforeFilter("auth.basic.once", ['only' => ['create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemsPerPage = 15;
        $products = new \App\Product();
        $products = $products->paginate($itemsPerPage);
        #bad-pratices
        //1. All is bad
        //2. No way to attach meta data - $hidden;
        //3. Linking db structure to the API Output
        //4. No way to signal headers/response codes

        //dd($products);

        #test - curl -i http://localhost:8000/product
        #status-codes: https://www.ietf.org/rfc/rfc2616.txt

        return $this->respondWithPaginator($this->productTransformer->transformCollection($products), $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $rules = [
                    'name'        => 'required|unique:products,name',
                    'category_id' => 'required|exists:categories,id'
                ];

        $messages = [
            'name.required'     => 'Name is required.',
            'name.unique'       => 'Name need to be unique.',
            'category.required' => 'Category is required.',
            'category.exists'   => 'Category need to exists in Categories registers.'
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            dd($request->all(), $validator);
            return $this->setStatusCode(402)->respondWithError('Validation fails');
        }

        $product = new \App\Product();
        $product->fill($request->all());
        $product->category_id = $request->get('category_id');
        $product->save();

        return $this->setStatusCode(201)->respond([
                'message' => 'Product created successfully'
            ]);
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

            return $this->respond([
                'data' => $this->productTransformer->transform($product->toArray())
                ]);

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

<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #bad-pratices
        //1. All is bad
        //2. No way to attach meta data $hidden;
        //3. Linking db structure to the API Output
        //4. No way to signal headers/response codes

        $categories = \App\Category::all(); #bad-pratice
        if (\Request::has("showProducts") && \Request::get("showProducts") == 1) {
            $categories->load("products");
        }
        return $categories;
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
            $category = \App\Category::findOrFail($id);
            if (\Request::has("showProducts") && \Request::get("showProducts") == 1) {
                $category->load("products");
            }
            return $category;
        } catch (\Exception $e) {
            return \Response::json(['message' => 'Category not found'], 404);
        }
    }
}

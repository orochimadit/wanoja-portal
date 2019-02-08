<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('products.create');
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
        $new_product = new \App\Product;
        $new_product->title = $request->get('title');
        $new_product->description = $request->get('description');
        $new_product->merk = $request->get('merk');
        // $new_product->publisher = $request->get('publisher');
        $new_product->price = $request->get('price');
        $new_product->stock = $request->get('stock');
      
        $new_product->status = $request->get('save_action');

        $cover = $request->file('cover');

        if($cover){
        $cover_path = $cover->store('product-covers', 'public');

        $new_product->cover = $cover_path;
        }
        $new_product->slug = str_slug($request->get('title'));
        $new_product->created_by = \Auth::user()->id;
        $new_product->save();
        
        if($request->get('save_action') == 'PUBLISH'){
            return redirect()
                  ->route('products.create')
                  ->with('status', 'Product successfully saved and published');
          } else {
            return redirect()
                  ->route('products.create')
                  ->with('status', 'Product saved as draft');
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

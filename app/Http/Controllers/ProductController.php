<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Product;
use App\Http\Resources\Products as ProductResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        
        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';


        if($status){
            $products = \App\Product::with('categories')->where('title', "LIKE", "%$keyword%")->where('status', strtoupper($status))->paginate(10);
        } else {
            $products = \App\Product::with('categories')->where("title", "LIKE", "%$keyword%")->paginate(10);
        }
    
        return view('products.index', ['products' => $products]);
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
        \Validator::make($request->all(), [
            "title" => "required|min:5|max:200",
            "description" => "required|min:20|max:1000",
            "merk" => "required|min:3|max:100",
            "price" => "required|digits_between:0,10",
            "stock" => "required|digits_between:0,10",
            "cover" => "required"
        ])->validate();  

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
        $new_product->categories()->attach($request->get('categories'));

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
        $product = \App\Product::findOrFail($id);

        return view('products.edit', ['product' => $product]);
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
        $product = \App\Product::findOrFail($id);

        \Validator::make($request->all(), [
            "title" => "required|min:5|max:200",
            "slug" => [
                "required",
                Rule::unique("products")->ignore($product->slug, "slug")
            ],
            "description" => "required|min:20|max:1000",
            "merk" => "required|min:3|max:100",
            "price" => "required|digits_between:0,10",
            "stock" => "required|digits_between:0,10",
            "cover" => "required"
        ])->validate();  

        
        $product->title = $request->get('title');
        $product->slug = $request->get('slug');
        $product->description = $request->get('description');
        $product->merk= $request->get('merk');
        //$book->publisher = $request->get('publisher');
        $product->stock = $request->get('stock');
        $product->price = $request->get('price');
    
        $new_cover = $request->file('cover');
    
        if($new_cover){
            if($product->cover && file_exists(storage_path('app/public/' . $product->cover))){
                \Storage::delete('public/'. $product->cover);
            }
    
            $new_cover_path = $new_cover->store('product-covers', 'public');
    
            $product->cover = $new_cover_path;
        }
    
        $product->updated_by = \Auth::user()->id;
    
        $product->status = $request->get('status');
    
        $product->save();
    
        $product->categories()->sync($request->get('categories'));
    
        return redirect()->route('products.edit', ['id'=>$product->id])->with('status', 'Product successfully updated');
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
        $product = \App\Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('status', 'Product moved to trash');
    }
    public function trash(){
        $products = \App\Product::onlyTrashed()->paginate(10);
      
        return view('products.trash', ['products' => $products]);
      }

      public function restore($id){
        $product = \App\Product::withTrashed()->findOrFail($id);
      
        if($product->trashed()){
          $product->restore();
          return redirect()->route('products.trash')->with('status', 'Product successfully restored');
        } else {
          return redirect()->route('products.trash')->with('status', 'Product is not in trash');
        }
      }
      public function deletePermanent($id){
        $product = \App\Product::withTrashed()->findOrFail($id);
      
        if(!$product->trashed()){
          return redirect()->route('products.trash')->with('status', 'Product is not in trash!')->with('status_type', 'alert');
        } else {
          $product->categories()->detach();
          $product->forceDelete();
      
          return redirect()->route('products.trash')->with('status', 'Product permanently deleted!');
        }
      }

      public function top($count)
    {
        $criteria = Product::select('*')
            ->orderBy('views', 'DESC')
            ->limit($count)
            ->get();        
        return new ProductResourceCollection($criteria);
    }
    public function indexApi()
    {
        $criteria = Product::paginate(6);
        return new ProductResourceCollection($criteria);
    }

    public function search($keyword)
    {
        $criteria = Product::select('*')
        ->where('title', 'LIKE', "%".$keyword."%")
        ->orderBy('views', 'DESC')
        ->get();
        return new ProductResourceCollection($criteria);
    }

    //menambahkan cart 
    public function cart(Request $request)
    {
        //$request->carts = '[{"id":3,"quantity":4}]';
        $carts = json_decode($request->carts, true);
        $product_carts = [];
        foreach($carts as $cart){
            $id = (int)$cart['id'];
            $quantity = (int)$cart['quantity'];
            $product = Product::find($id);
            if($product){
                $note = 'unsafe';
                if($product->stock >= $quantity){
                    $note = 'safe';
                }
                else {
                    $quantity = (int) $product->stock;
                    $note = 'out of stock'; 
                }
                $product_carts[] = [
                    'id' => $id,
                    'title' => $product->title,
                    'cover' => $product->cover,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'note' => $note
                ];
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'carts',
            'data' => $product_carts,
        ], 200); 
        //foreach ($carts as $cart) {
            //var_dump(($request->carts));
        //}
        //$book_carts = [];
        //Book::find
    }
}

@extends('layouts.global')

@section('title') Product list @endsection 

@section('content') 
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered table-stripped">
        <thead>
          <tr>
            <th><b>Cover</b></th>
            <th><b>Title</b></th>
            <th><b>Author</b></th>
            <th><b>Status</b></th>
            <th><b>Categories</b></th>
            <th><b>Stock</b></th>
            <th><b>Price</b></th>
            <th><b>Action</b></th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
            <tr>
              <td>
                @if($product->cover)
                  <img src="{{asset('storage/' . $product->cover)}}" width="96px"/>
                @endif
              </td>
              <td>{{$product->title}}</td>
              <td>{{$product->merk}}</td>
              <td>
                @if($product->status == "DRAFT")
                  <span class="badge bg-dark text-white">{{$product->status}}</span>
                @else 
                  <span class="badge badge-success">{{$product->status}}</span>
                @endif 
              </td>
              <td>
                <ul class="pl-3">
                @foreach($product->categories as $category)
                  <li>{{$category->name}}</li>  
                @endforeach
                </ul>
              </td>
              <td>{{$product->stock}}</td>
              <td>{{$product->price}}</td>
              <td>
                [TODO: actions]
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="10">
              {{$products->appends(Request::all())->links()}}
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection
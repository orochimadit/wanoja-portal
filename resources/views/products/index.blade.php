@extends('layouts.global')

@section('title') Product list @endsection 

@section('content') 
  <div class="row">
  

    <div class="col-md-12">
    @if(session('status'))
        <div class="alert alert-success">
          {{session('status')}}
        </div>
      @endif

    <div class="row">
  <div class="col-md-6">
  <form
  action="{{route('products.index')}}">

<div class="input-group">
    <input name="keyword" type="text" value="{{Request::get('keyword')}}" class="form-control" placeholder="Filter by title">
    <div class="input-group-append">
      <input type="submit" value="Filter" class="btn btn-primary">
    </div>
</div>

</form>
  </div>
  <div class="col-md-6">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
        <a class="nav-link {{Request::get('status') == NULL && Request::path() == 'products' ? 'active' : ''}}" href="{{route('products.index')}}">All</a>
      </li>
      <li class="nav-item">
          <a class="nav-link {{Request::get('status') == 'publish' ? 'active' : '' }}" href="{{route('products.index', ['status' => 'publish'])}}">Publish</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{Request::get('status') == 'draft' ? 'active' : '' }}" href="{{route('products.index', ['status' => 'draft'])}}">Draft</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{Request::path() == 'products/trash' ? 'active' : ''}}" href="{{route('products.trash')}}">Trash</a>
      </li>
    </ul>
  </div>
</div>

<hr class="my-3">
    <div class="row mb-3">
  <div class="col-md-12 text-right">
    <a
      href="{{route('products.create')}}"
      class="btn btn-primary"
    >Create Product</a>
  </div>
</div>
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
                <a
                href="{{route('products.edit', ['id' => $product->id])}}"
                class="btn btn-info btn-sm"
                > Edit </a>
                <form
                    method="POST"
                    class="d-inline"
                    onsubmit="return confirm('Move product to trash?')"
                    action="{{route('products.destroy', ['id' => $product->id ])}}"
                    >

                    @csrf 
                    <input 
                    type="hidden" 
                    value="DELETE"
                    name="_method">

                    <input 
                    type="submit" 
                    value="Trash" 
                    class="btn btn-danger btn-sm">

                    </form>
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
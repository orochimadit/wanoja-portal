@extends('layouts.global')

@section('title') Edit Product @endsection 

@section('content')

<div class="row">
  <div class="col-md-8">

    @if(session('status'))
      <div class="alert alert-success">
        {{session('status')}}
      </div>
    @endif

    <form
      enctype="multipart/form-data"
      method="POST"
      action="{{route('products.update', ['id' => $product->id])}}"
      class="p-3 shadow-sm bg-white"
    >

    @csrf 
    <input type="hidden" name="_method" value="PUT">

    <label for="title">Title</label><br>
    <input
      type="text"
      class="form-control"
      value="{{$product->title}}"
      name="title"
      placeholder="Product title"
    />
    <br>

    <label for="cover">Cover</label><br>
    <small class="text-muted">Current cover</small><br>
    @if($product->cover)
      <img src="{{asset('storage/' . $product->cover)}}" width="96px"/>
    @endif
    <br><br>
    <input 
      type="file" 
      class="form-control"
      name="cover"
    >
    <small class="text-muted">Kosongkan jika tidak ingin mengubah cover</small>
    <br><br>

    <label for="slug">Slug</label><br>
    <input 
      type="text"
      class="form-control"
      value="{{$product->slug}}"
      name="slug"
      placeholder="enter-a-slug"
    />
    <br>

    <label for="description">Description</label> <br>
    <textarea name="description" id="description" class="form-control">{{$product->description}}</textarea>
    <br>

    <label for="categories">Categories</label>
    <select multiple class="form-control" name="categories[]" id="categories"></select>
    <br>
    <br>

    <label for="stock">Stock</label><br>
    <input type="text" class="form-control" placeholder="Stock" id="stock" name="stock" value="{{$product->stock}}">
    <br>

    <label for="merk">Merk</label>
    <input placeholder="Merk" value="{{$product->merk}}" type="text" id="merk" name="merk" class="form-control">
    <br>


    <label for="price">Price</label><br>
    <input type="text" class="form-control" name="price" placeholder="Price" id="price" value="{{$product->price}}">
    <br>

    <label for="">Status</label>
    <select name="status" id="status" class="form-control">
      <option {{$product->status == 'PUBLISH' ? 'selected' : ''}} value="PUBLISH">PUBLISH</option>
      <option {{$product->status == 'DRAFT' ? 'selected' : ''}} value="DRAFT">DRAFT</option>
    </select>
    <br>

    <button class="btn btn-primary" value="PUBLISH">Update</button>

    </form>
  </div>
</div>

@endsection

@section('footer-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
$('#categories').select2({
  ajax: {
    url: 'http://127.0.0.1:8000/ajax/categories/search',
    processResults: function(data){
      return {
        results: data.map(function(item){return {id: item.id, text: item.name} })
      }
    }
  }
});

var categories = {!! $product->categories !!}

    categories.forEach(function(category){
      var option = new Option(category.name, category.id, true, true);
      $('#categories').append(option).trigger('change');
    });
</script>
@endsection
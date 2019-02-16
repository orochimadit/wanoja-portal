@extends('layouts.global')



@section('title') Create book @endsection 

@section('content')
  <div class="row">
    <div class="col-md-8">
    @if(session('status'))
  <div class="alert alert-success">
    {{session('status')}}
  </div>
@endif
      <form 
        action="{{route('products.store')}}"
        method="POST"
        enctype="multipart/form-data"
        class="shadow-sm p-3 bg-white"
        >

        @csrf

        <label for="title">Title</label> <br>
        <input type="text" class="form-control {{$errors->first('title') ? "is-invalid" : ""}} " name="title" placeholder="Product title" value="{{old('title')}}">
        <div class="invalid-feedback">
          {{$errors->first('title')}}
        </div>
        <br>

        <label for="cover">Cover</label>
        <input type="file" class="form-control {{$errors->first('covers') ? "is-invalid" : ""}}" name="cover">
        <div class="invalid-feedback">
          {{$errors->first('cover')}}
        </div>
        <br>

        <label for="description">Description</label><br>
        <textarea name="description" id="description" class="form-control {{$errors->first('covers') ? "is-invalid" : ""}}" 
        placeholder="Give a description about this Product">{{old('description')}}</textarea>
        <div class="invalid-feedback">
          {{$errors->first('description')}}
        </div>
        <br>

        <label for="stock">Stock</label><br>
        <input type="number" class="form-control {{$errors->first('stock') ? "is-invalid" : ""}}" id="stock" name="stock" min=0 value=0>
        <div class="invalid-feedback">
          {{$errors->first('stock')}}
        </div>
        <br>

        <label for="merk">Merk</label><br>
        <input type="text" class="form-control {{$errors->first('merk') ? "is-invalid" : ""}}" name="merk" id="merk" placeholder="Product Merk">
        <div class="invalid-feedback">
          {{$errors->first('merk')}}
        </div>
        <br>

        <!-- <label for="publisher">Publisher</label>  <br>
        <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Book publisher">
        <br> -->
        <label for="categories">Categories</label><br>

        <select name="categories[]"  multiple id="categories" class="form-control">
        </select>
        <br><br/>
        
        <label for="Price">Price</label> <br>
        <input type="number" class="form-control {{$errors->first('merk') ? "is-invalid" : ""}}" name="price" id="price" placeholder="Product price">
        <div class="invalid-feedback">
          {{$errors->first('price')}}
        </div>
        <br>

        <button 
          class="btn btn-primary" 
          name="save_action" 
          value="PUBLISH">Publish</button>

        <button 
          class="btn btn-secondary" 
          name="save_action" 
          value="DRAFT">Save as draft</button>
      </form>
    </div>
  </div>
@endsection

@section('footer-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
// $(document).ready(function() {
//    // $('.js-example-basic-single').select2();
// });
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
</script>
@endsection
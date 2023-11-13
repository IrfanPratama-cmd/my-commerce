@extends('layout.main')

@section('container')
<div class="card">
    <div class="card-body">
        <form action="/products/{{$product->id}}" method="post" class="mb-5" enctype="multipart/form-data">
            @method('put')
            @csrf
          <div class="mb-3">
              <label for="product_name" class="form-label">Product Name</label>
              <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name"
              name="product_name" value="{{ old('product_name', $product->product_name) }}"  required autofocus>
              @error('product_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
          </div>
          <div class="mb-3">
            <label for="product_code" class="form-label">Product Code</label>
            <input type="text" class="form-control @error('product_code') is-invalid @enderror" id="product_code"
            name="product_code" value="{{ old('product_code', $product->product_code) }}"  required autofocus>
            @error('product_code')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <div class="input-group">
                <select class="form-select" name="category_id" id="example-select">
                    <option selected disabled>Select Category</option>
                        @foreach ($category as $c)
                        @if(old('category_id', $product->category_id) == $c->id)
                            <option value="{{ $c->id }}" selected>{{ $c->category_name }}</option>
                        @else
                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                        @endif
                        @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <div class="input-group">
                <select class="form-select" name="brand_id" id="example-select">
                    <option selected disabled>Select Brand</option>
                        @foreach ($brand as $b)
                        @if(old('brand_id', $product->brand_id) == $b->id)
                            <option value="{{ $b->id }}" selected>{{ $b->brand_name }}</option>
                        @else
                            <option value="{{ $b->id }}">{{ $b->brand_name }}</option>
                        @endif
                        @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="name"
            name="stock" value="{{ old('stock', $product->stock) }}"  required autofocus>
            @error('stock')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" id="name"
            name="price" value="{{ old('stock', $product->price) }}"  required autofocus>
            @error('price')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            @error('description')
            <p class="text-danger">{{ $message }}</p>
            @enderror
            <input id="description" type="hidden" name="description" value="{{ old('description', $product->description) }}">
            <trix-editor input="description"></trix-editor>
        </div>

        <div class="mb-3">
            <label for="asset" class="form-label">Product Image</label>
            <input type="hidden" name="oldImage" value="{{ $asset->file_name }}">
            @if ($asset->file_name)
              <img src="{{ url('public/product/' . $asset->file_name) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block ">
            @else
              <img class="img-preview img-fluid mb-3 col-sm-5">
            @endif
            <input class="form-control @error('asset') is-invalid @enderror" type="file" id="image" name="asset"
            onchange="previewImage()">
            @error('asset')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary">Create Product</button>
        </form>
      </div>
</div>




  <script>

    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
        imgPreview.src = oFREvent.target.result;
        }
    }
    </script>

@endsection

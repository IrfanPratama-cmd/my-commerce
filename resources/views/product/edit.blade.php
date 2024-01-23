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
            <label for="asset" class="form-label">Product Cover</label>
            <input type="hidden" name="oldImage" value="{{ $asset->file_name }}">
            @if ($asset->file_name)
              <img src="{{ url('product-asset/' . $asset->file_name) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block ">
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
          <div class="mb-3">
            <div class="form-group">
                <label for="document" class="form-label">Product Image</label>
                <div class="needsclick dropzone" id="document-dropzone">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Edit Product</button>
        </form>
      </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>


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

<script>
    var uploadedDocumentMap = {}
    Dropzone.options.documentDropzone = {
      url: "{{ route('product.uploads') }}",
      thumbnailWidth: 100,
      thumbnailHeight: 100,
      maxFilesize: 2, // MB
      addRemoveLinks: true,
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      },
      success: function (file, response) {
        $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
        uploadedDocumentMap[file.name] = response.name
      },
      removedfile: function (file) {
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
          name = file.file_name
        } else {
          name = uploadedDocumentMap[file.name]
        }
        $('form').find('input[name="document[]"][value="' + name + '"]').remove()
      },
      init: function () {
        var existingFiles = {!! json_encode($images) !!};

            // Menampilkan file yang sudah ada di Dropzone
            for (var i = 0; i < existingFiles.length; i++) {
                var mockFile = existingFiles[i];
                this.emit("addedfile", mockFile);
                this.emit("thumbnail", mockFile, "/product-asset/" + mockFile.file_name);
                this.emit("complete", mockFile);

                console.log(mockFile)
            }

            // Menangani penghapusan file
            this.on("removedfile", function (file) {
                // Logika untuk menghapus file dari server atau database
                // Contoh Ajax request:
                // $.ajax({
                //     type: 'POST',
                //     url: '/delete-image',
                //     data: { filename: file.name },
                //     success: function(data) {
                //         console.log('File deleted successfully');
                //     }
                // });
            });
            @if(isset($project) && $project->document)
            var files =
                {!! json_encode($project->document) !!}
            for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
            }
            @endif
      }
    }
  </script>

@endsection

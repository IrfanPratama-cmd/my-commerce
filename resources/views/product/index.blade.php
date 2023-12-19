@extends('data-table.main')

@section('table')
    @can('create-category')
    <a class="btn btn-primary" href="/create-products"> Add New Product</a>
    @endauth

    @if(session('success'))
    <script>
        Swal.fire('Success', '{{ session('success') }}', 'success');
    </script>
    @endif

    <div class="row py-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{-- {{$dataTable->table()}} --}}
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModelexa" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="postForm" name="postForm" class="form-horizontal" enctype="multipart/form-data">
                       <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="product_code" class="col-sm-6 control-label">Product Code</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Enter Product Name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product_name" class="col-sm-6 control-label">Product Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category" class="col-sm-6 control-label">Category</label>
                            <div class="col-sm-12">
                                <select class="form-select" name="category_id" id="category_id">
                                    <option selected disabled>Select Category</option>
                                        @foreach ($category as $c)
                                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="brand" class="col-sm-6 control-label">Brand</label>
                            <div class="col-sm-12">
                                <select class="form-select" name="brand_id" id="brand_id">
                                    <option selected disabled>Select Brand</option>
                                        @foreach ($brand as $b)
                                            <option value="{{ $b->id }}">{{ $b->brand_name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stock" class="col-sm-6 control-label">Stock</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter Stock Product" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price" class="col-sm-6 control-label">Price</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price Product" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="" required="">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-2 control-label">Image</label>
                            <div class="col-sm-12">
                                <input id="image" type="file" name="image" accept="image/*" onchange="readURL(this);">
                                <input type="hidden" name="image" id="image">
                            </div>
                          </div>

                          <img id="modal-preview" src="https://via.placeholder.com/150" alt="Preview" class="form-group hidden" width="100" height="100">

                        <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Product
                         </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $(function () {

        var SITEURL = '{{URL::to('')}}';

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "/products",
          columns: [
              {data: 'no', name: 'no'},
              {data: 'product_code', name: 'product_code'},
              {data: 'product_name', name: 'product_name'},
              {data: 'category.category_name', name: 'category.category_name'},
              {data: 'brand.brand_name', name: 'brand.brand_name'},
              {data: 'stock', name: 'stock'},
              {data: 'formatted_price', name: 'price'},
            //   {data: 'price', name: 'price'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

        $('#createCategory').click(function () {
            $('#savedata').val("create-category");
            $('#id').val('');
            $('#postForm').trigger("reset");
            $('#modelHeading').html("Create New category");
            $('#ajaxModelexa').modal('show');
        });

        $('body').on('click', '.editProduct', function () {
            var id = $(this).data('id');
            console.log(id);
            $.get("products" +'/' + id , function (data) {
                $('#modelHeading').html("Edit Product");
                $('#savedata').val("edit-product");
                $('#ajaxModelexa').modal('show');
                $('#id').val(data.id);
                $('#product_code').val(data.product_code);
                $('#product_name').val(data.product_name);
                $('#category_id').val(data.category_id);
                $('#brand_id').val(data.brand_id);
                $('#stock').val(data.stock);
                $('#price').val(data.price);
            })
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            // $(this).html('Sending..');

            $.ajax({
            data: $('#postForm').serialize(),
            url: "/products",
            type: "POST",
            dataType: 'json',
            success: function (data) {

                $('#postForm').trigger("reset");
                $('#ajaxModelexa').modal('hide');
                table.draw();
                Swal.fire({
                    icon: 'success',
                    title: 'category created successfully!',
                });
            },
            error: function (data) {
                console.log('Error:', data);
                $('#savedata').html('Save Changes');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                });
            }
        });
        });

        function readURL(input, id) {
            id = id || '#modal-preview';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(id).attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
                $('#modal-preview').removeClass('hidden');
                $('#start').hide();
            }
        }

        $('body').on('click', '.deleteProduct', function () {
            var id = $(this).data("id");

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: `/products/${id}`,
                        success: function (data) {
                            if(data.response){
                                Swal.fire('Deleted!', data.response, 'success');
                                $(`[data-id="${id}"]`).closest('tr').remove();
                            }else{
                                Swal.fire('Error!', data.error, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', data.response, 'error');
                        }
                    });
                }
            });
        });

    });
</script>
@endsection


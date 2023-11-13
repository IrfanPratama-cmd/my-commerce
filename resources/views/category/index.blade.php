@extends('data-table.main')

@section('table')
    @can('create-category')
    <a class="btn btn-primary" href="javascript:void(0)" id="createCategory"> Add New Category</a>
    @endauth

    <div class="row py-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{-- {{$dataTable->table()}} --}}
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category Code</th>
                                <th>Category Name</th>
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
                    <form id="postForm" name="postForm" class="form-horizontal">
                       <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="category_code" class="col-sm-6 control-label">Category Code</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="category_code" name="category_code" placeholder="Enter Category Name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category_name" class="col-sm-6 control-label">Category Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name" value="" required>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Category
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

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "/categories",
          columns: [
              {data: 'no', name: 'no'},
              {data: 'category_code', name: 'category_code'},
              {data: 'category_name', name: 'category_name'},
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

        $('body').on('click', '.editCategory', function () {
            var id = $(this).data('id');
            console.log(id);
            $.get("categories" +'/' + id , function (data) {
                $('#modelHeading').html("Edit Category");
                $('#savedata').val("edit-category");
                $('#ajaxModelexa').modal('show');
                $('#id').val(data.id);
                $('#category_code').val(data.category_code);
                $('#category_name').val(data.category_name);
            })
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            // $(this).html('Sending..');

            $.ajax({
            data: $('#postForm').serialize(),
            url: "/categories",
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

        $('body').on('click', '.deleteCategory', function () {
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
                        url: `/categories/${id}`,
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


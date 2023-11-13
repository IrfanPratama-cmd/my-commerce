@extends('data-table.main')

@section('table')
    @can('create-role')
    <a class="btn btn-primary" href="javascript:void(0)" id="createRole"> Add New Permission</a>
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
                                <th>Permission Name</th>
                                <th>Guard Name</th>
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
                            <label for="name" class="col-sm-6 control-label">Permission Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Permission Name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="guard_name" class="col-sm-6 control-label">Guard Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="guard_name" name="guard_name" placeholder="Enter Guard Name" value="" required>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Permission
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
          ajax: "/permissions",
          columns: [
              {data: 'no', name: 'no'},
              {data: 'name', name: 'name'},
              {data: 'guard_name', name: 'guard_name'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

        $('#createRole').click(function () {
            $('#savedata').val("create-group");
            $('#id').val('');
            $('#postForm').trigger("reset");
            $('#modelHeading').html("Create New Group");
            $('#ajaxModelexa').modal('show');
        });

        $('body').on('click', '.editGroup', function () {
            var id = $(this).data('id');
            console.log(id);
            $.get("permissions" +'/' + id , function (data) {
                $('#modelHeading').html("Edit Group");
                $('#savedata').val("edit-group");
                $('#ajaxModelexa').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#guard_name').val(data.guard_name);
            })
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            // $(this).html('Sending..');

            $.ajax({
            data: $('#postForm').serialize(),
            url: "/permissions",
            type: "POST",
            dataType: 'json',
            success: function (data) {

                $('#postForm').trigger("reset");
                $('#ajaxModelexa').modal('hide');
                table.draw();
                Swal.fire({
                    icon: 'success',
                    title: 'Role created successfully!',
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

        $('body').on('click', '.deleteRole', function () {
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
                        url: `/permissions/${id}`,
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


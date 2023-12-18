@extends('data-table.main')

@section('table')
    @can('create-user')
    <a class="btn btn-primary" href="javascript:void(0)" id="createUser"> Create New User</a>
    @endcan

    @if(session('success'))
        <script>
            Swal.fire('Success', '{{ session('success') }}', 'success');
        </script>
    @endif

    <div class="row py-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Email Verified At</th>
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
                            <label for="name" class="col-sm-6 control-label">User Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter User Name" value="" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="email" class="col-sm-6 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Guard Name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role" class="col-sm-6 control-label">Role</label>
                            <div class="col-sm-12">
                                <select class="form-select" name="role_id" id="role_id">
                                    <option selected disabled>Select Role</option>
                                        @foreach ($role as $r)
                                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-primary" id="savedata" value="create">Create User
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
          ajax: "/users",
          columns: [
              {data: 'no', name: 'no'},
              {data: 'name', name: 'name'},
              {data: 'role.name', name: 'role.name'},
              {data: 'email', name: 'email'},
              {data: 'email_verified_at', name: 'email_verified_at'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

        $('#createUser').click(function () {
            $('#savedata').val("create-user");
            $('#id').val('');
            $('#postForm').trigger("reset");
            $('#modelHeading').html("Create New User");
            $('#ajaxModelexa').modal('show');
        });

        $('body').on('click', '.editGroup', function () {
            var id = $(this).data('id');
            console.log(id);
            $.get("roles" +'/' + id , function (data) {
                $('#modelHeading').html("Edit Group");
                $('#savedata').val("edit-group");
                $('#ajaxModelexa').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#role_id').val(data.role_id);
            })
        });

        $('#savedata').click(function (e) {
            e.preventDefault();

            $.ajax({
            data: $('#postForm').serialize(),
            url: "/users",
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

        $('body').on('click', '.deleteUser', function () {
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
                        url: `/users/${id}`,
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


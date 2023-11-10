@extends('layouts.base')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Student</h1>        
    </div>
    <div class="card-body">
        <!-- Page body -->
        <table id="student-table" class="display table text-nowrap mb-3 table-centered">
            <thead class="table-light">
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Enrollment Status</th>
                    <th>Date Created</th>
                    <th>Date Updated</th>
                    <th>Action</th>
                    <!-- Add more table headers for other columns -->
                </tr>
            </thead>
            <tbody>
                <!-- DataTable will populate data here -->
            </tbody>
        </table>
    </div>

</div>
<!-- /.container-fluid -->

@endsection

<!-- edit modal -->
<div class="modal fade" id="editprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Edit Student Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
            <form action="" method="post" id="formedit" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="FacultyID" id="FacultyID"value="" required>
                <div>
                    <p >Student ID</p>
                    <p id="FacultyIDText"></p>
                </div>
                <div class="mb-3">
                    <label for="FirstName" class="col-form-label">First Name</label>
                    <input type="text" name="FirstName" class="form-control" id="FirstName" required>
                </div>
                <div class="mb-3">
                    <label for="LastName" class="col-form-label">Last Name</label>
                    <input type="text" name="LastName" class="form-control" id="LastName" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="text" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                <label for="message-text" class="col-form-label">Status</label>
                    <select name="EnrollmentStatus" id="EnrollmentStatus" class="form-control" required>
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                    </select>
                </div>
                <div class="modal-footer">
                <input type="submit" class="btn btn-primary" id="save_edit">
                </div>
            </div>
            </form>
            
        </div>
    </div>
</div>
<!-- edit modal -->
<!-- delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete company product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body justify-content-center">
                <form action=" " method="post" id="formdelete">
                    @csrf
                    <input type="hidden" name="del_ID" id="del_ID" value="" required>
                    
                    <p>Are you sure you want to delete user [<span id="del_name"></span>] ?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- delete modal -->

@section('scripts')
<script>
    $(document).ready(function() {
       
        $('#student-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.students') }}",
            columns: [
                { data: 'FacultyID', name: 'FacultyID' },
                { data: 'FirstName', name: 'FirstName' },
                { data: 'LastName', name: 'LastName' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
                { data: 'EnrollmentStatus', name: 'EnrollmentStatus' },
                { data: 'DateCreated', name: 'DateCreated' },
                { data: 'LastUpdated', name: 'LastUpdated' },
                {data: 'action',
                name: 'action',
                orderable: false,
                searchable: false},     
            ],
            scrollX: true, // Enable horizontal scrolling
            scrollY: true, // Set a fixed vertical scrolling height (adjust as needed)
            scrollCollapse: true,
        });
        // Handle click events for the "Edit" and "Delete" links
        $('body').on('click', '.btn-edit', function(){
            var FirstName = $(this).attr('FirstName');
            var LastName = $(this).attr('LastName');
            var FacultyID = $(this).attr('FacultyID');
            var EnrollmentStatus = $(this).attr('EnrollmentStatus');
            var email = $(this).attr('email');

            $('#FirstName').val(FirstName);
            $('#LastName').val(LastName);
            $('#FacultyID').val(FacultyID);
            $('#FacultyIDText').text(FacultyID);
            $('#EnrollmentStatus').val(EnrollmentStatus);
            $('#email').val(email);
            $('#editprofile').modal('show');
        });
        $("#save_edit").click(function(e){
            e.preventDefault();
            $("#save_edit").prop("value", "Saving .....");

            $.ajax(
                {
                type: 'POST',
                url: "{{ route('student.update') }}",
                data:  $('#formedit').serialize(),
                success:function(data){
                    console.log(data.status);
                    $("#save_edit").prop("value", "Save");
                    $('#editprofile').modal('hide');
                    $('#student-table').DataTable().ajax.reload();
                    if (data.status==1) {
                        toastr.success('Profile Updated', {timeOut: 5000});
                    }
                    else {
                        toastr.warning('Failed Try again ', {timeOut: 5000});
                    }
                }      
            });
        });
        //Delete
        $('body').on('click', '.btn-delete', function(){
            var FacultyID = $(this).attr('FacultyID');

            $('#del_ID').val(FacultyID);
            $('#del_name').text(FacultyID);
            $('#deleteModal').modal('show');
        });
        $("#confirmDelete").click(function(e){
            e.preventDefault();
            $("#confirmDelete").prop("value", "Deleting .....");
            var del_ID=$('#del_ID').val();
            $.ajax(
                {
                type: 'POST',
                url: "{{ route('student.delete') }}",
                data:  $('#formdelete').serialize(),
                success:function(data){
                    $("#confirmDelete").prop("value", "Delete");
                    $('#deleteModal').modal('hide');
                    $('#student-table').DataTable().ajax.reload();
                    if (data.status==1) {
                        toastr.success('User Removed', {timeOut: 5000});
                    }
                    else {
                        toastr.warning('Failed Try again ', {timeOut: 5000});
                    }
                }      
            });
        });

    });
</script>
@endsection
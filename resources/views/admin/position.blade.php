@extends('layouts.base')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Position</h1>        
    </div>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".gd-example-modal-lg">+Add</button>

    <!--New Position-->
    <div class="modal fade gd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!--New Position Button-->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelOne">New Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <!--New Position Form-->
                <div class="modal-body">
                    <form action="/createposition" method="post" id="my-form" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Position') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                        <input type="submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Page body -->
    <table id="position-table" class="display table text-nowrap mb-3 table-centered">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Date Created</th>
                <th>Date Updated</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- DataTable will populate data here -->
        </tbody>
    </table>

</div>
<!-- /.container-fluid -->

@endsection
<!-- edit modal -->
<div class="modal fade" id="editposition" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Edit Position</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
            <form action="" method="post" id="formedit" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id"value="" required>
                
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Position') }}</label>

                    <div class="col-md-6">
                        <input id="name" name="name" type="text" class="form-control "  value="" required>
                    </div>
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
                <h5 class="modal-title" id="deleteModalLabel">Delete Candidate Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body justify-content-center">
                <form action=" " method="post" id="formdelete">
                    @csrf
                    <input type="hidden" name="del_ID" id="del_ID" value="" required>
                    
                    <p>Are you sure you want to delete Position[<span id="del_name"></span>] ?</p>
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
       
        $('#position-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.position') }}",
            columns: [
                { data: 'name', name: 'name' },
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
            var ID = $(this).attr('ID');
            var Position = $(this).attr('name');

            $('#id').val(ID);
            $('#name').val(Position);
            $('#editposition').modal('show');
        });
        $("#save_edit").click(function(e){
            e.preventDefault();
            $("#save_edit").prop("value", "Saving .....");

            $.ajax(
                {
                type: 'POST',
                url: "{{ route('position.update') }}",
                data:  $('#formedit').serialize(),
                success:function(data){
                    console.log(data.status);
                    $("#save_edit").prop("value", "Save");
                    $('#editposition').modal('hide');
                    $('#position-table').DataTable().ajax.reload();
                    if (data.status==1) {
                        toastr.success('position Updated', {timeOut: 5000});
                    }
                    else {
                        toastr.warning('Failed Try again ', {timeOut: 5000});
                    }
                }      
            });
        });
        //Delete
        $('body').on('click', '.btn-delete', function(){
            var ID = $(this).attr('ID');
            var Name = $(this).attr('name');

            $('#del_ID').val(ID);
            $('#del_name').text(Name);
            $('#deleteModal').modal('show');
        });
        $("#confirmDelete").click(function(e){
            e.preventDefault();
            $("#confirmDelete").prop("value", "Deleting .....");
            var del_ID=$('#del_ID').val();
            $.ajax(
                {
                type: 'POST',
                url: "{{ route('position.delete') }}",
                data:  $('#formdelete').serialize(),
                success:function(data){
                    $("#confirmDelete").prop("value", "Delete");
                    $('#deleteModal').modal('hide');
                    $('#position-table').DataTable().ajax.reload();
                    if (data.status==1) {
                        toastr.success('position Deleted', {timeOut: 5000});
                    }
                    else if (data.status==0){
                        toastr.warning('Failed Try again ', {timeOut: 5000});
                    }
                }      
            });
        });
    });
    
</script>
@endsection
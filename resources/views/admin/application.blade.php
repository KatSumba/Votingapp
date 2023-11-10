@extends('layouts.base')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Applications</h1>        
    </div>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".gd-example-modal-lg">+Add</button>

    <!--New Application-->
    <div class="modal fade gd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!--New Application Button-->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelOne">New Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <!--New Application Form-->
                <div class="modal-body">
                    <form action="/createapplication" method="post" id="my-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                           <label for="recipient-user" class=" col-md-4 col-form-label text-md-end">Applicant</label>
                           <div class="col-md-6">
                                <select name="userId" class="form-control" id="user" required>
                                    <option  value="" disabled selected>--Select--</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->FacultyID }}">{{ $user->FacultyID }} - {{ $user->FirstName }} {{ $user->LastName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="position" class="col-md-4 col-form-label text-md-end">{{ __('Position') }}</label>

                            <div class="col-md-6">
                                <select name="positions" class="form-control" id="Position" required>
                                    <option  value="" disabled selected>--Select--</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->name }}">{{ $position->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="manifesto" class="col-md-4 col-form-label text-md-end">{{ __('Manifesto') }}</label>

                            <div class="col-md-6">
                                <textarea id="Manifesto" class="form-control @error('Manifesto') is-invalid @enderror" name="Manifesto" required autofocus></textarea>
                                <p id="word-count">Word count: 0</p>

                                @error('Manifesto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="slogan" class="col-md-4 col-form-label text-md-end">{{ __('Slogan') }}</label>

                            <div class="col-md-6">
                                <input id="Slogan" type="Slogan" class="form-control @error('Slogan') is-invalid @enderror" name="Slogan" value="{{ old('Slogan') }}" required autocomplete="Slogan">

                                @error('Slogan')
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
    <table id="application-table" class="display table text-nowrap mb-3 table-centered">
        <thead class="table-light">
            <tr>
                <th>Faculty ID</th>
                <th>Manifesto</th>
                <th>Position</th>
                <th>Slogan</th>
                <th>Status</th>
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
<div class="modal fade" id="editapplication" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Edit Candidate Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
            <form action="" method="post" id="formedit" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ApplicationID" id="ApplicationID"value="" required>
                <div class="row mb-3">
                    <p class="col-md-4 col-form-label text-md-end">Student ID</p>
                    <p id="FacultyIDText" class="col-md-6 col-form-label" ></p>
                </div>
                <div class="row mb-3">
                    <label for="position" class="col-md-4 col-form-label text-md-end">{{ __('Position') }}</label>

                    <div class="col-md-6">
                        <select name="Position" class="form-control" id="Position" required>
                            <option  value="" disabled selected>--Select--</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->name }}">{{ $position->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="manifesto" class="col-md-4 col-form-label text-md-end">{{ __('Manifesto') }}</label>

                    <div class="col-md-6">
                        <textarea id="Manifesto" class="form-control @error('Manifesto') is-invalid @enderror" name="Manifesto" value="" required autofocus></textarea>
                        <p id="word-count">Word count: 0</p>

                        @error('Manifesto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="slogan" class="col-md-4 col-form-label text-md-end">{{ __('Slogan') }}</label>

                    <div class="col-md-6">
                        <input id="Slogan" type="text" class="form-control @error('Slogan') is-invalid @enderror" name="Slogan" value=" " required>

                        @error('Slogan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="message-text" class="col-md-4 col-form-label text-md-end">Status</label>
                    <div class="col-md-6">
                        <select name="ApplicationStatus" id="EnrollmentStatus" class="form-control" required>
                            <option value="approved">approved</option>
                            <option value="rejected">rejected</option>
                            <option value="pending">pending</option>
                        </select>
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
                    
                    <p>Are you sure you want to delete Application for Candidate[<span id="del_name"></span>] ?</p>
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

<!-- Read more modal -->
<div class="modal fade" id="description-modal" tabindex="-1" role="dialog" aria-labelledby="description-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="description-modal-label">Description</h5>
                
                <button type="button" class="close desc_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- The full description will be displayed here -->
            </div>
            <div class="modal-footer">
                <button type="button" id="desc_close"class="btn btn-secondary desc_close " data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Read more modal -->


@section('scripts')
<script>
    // New Application
    const manifestoTextarea = document.getElementById('Manifesto');
    const wordCountDisplay = document.getElementById('word-count');

    manifestoTextarea.addEventListener('input', function () {
        const text = manifestoTextarea.value;
        const words = text.split(/\s+/).filter(word => word.length > 0).length;
        wordCountDisplay.textContent = `Word count: ${words} /150`;

        // Check if the word count is less than 150 and add a custom validation class
        if (words < 150) {
            manifestoTextarea.classList.add('invalid-word-count');
        } else {
            manifestoTextarea.classList.remove('invalid-word-count');
        }
    });


    $(document).ready(function() {
       
        $('#application-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.application') }}",
            columns: [
                { data: 'FacultyID', name: 'FacultyID' },
                { data: 'Manifesto', name: 'Manifesto',  
                    render: function (data, type, row) {
                        if (type === 'display' && data.length > 50) {
                            
                            // Display only the first 15 characters and add a "Read More" link
                            return data.substr(0, 15) + '... <a href="#" class="read-more" data-toggle="modal" data-target="#description-modal" data-full-manifesto="' + data + '">Read More</a>';
                        }
                        return data;
                    }
                },
                { data: 'Position', name: 'Position' },
                { data: 'Slogan', name: 'Slogan' },
                { data: 'ApplicationStatus', name: 'ApplicationStatus' },
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
        // Handle "Read More" clicks
        $('#application-table tbody').on('click', '.read-more', function (e) {
            e.preventDefault();
            // var fullManifesto = $(this).data('full-manifesto');
            // var data= fullManifesto.text();
            var cell = $(this).closest('td');
            var data = cell.text(); // Get the full description
            // var Manifesto = $(this).attr('Manifesto');

            // $('#Manifesto').val(Manifesto);

            $('#description-modal .modal-body').text(data); // Set modal content
            $('#description-modal').modal('show'); // Show the modal
        });
        $(".desc_close").click(function(e){
            $('#description-modal').modal('hide');
        });
        // Handle click events for the "Edit" and "Delete" links
        $('body').on('click', '.btn-edit', function(){
            var ApplicationID = $(this).attr('ApplicationID');
            var Position = $(this).attr('Position');
            var FacultyID = $(this).attr('FacultyID');
            var ApplicationStatus = $(this).attr('ApplicationStatus');
            var Manifesto = $(this).attr('Manifesto');
            var Slogan = $(this).attr('Slogan');

            $('#ApplicationID').val(ApplicationID);
            $('#FacultyIDText').text(FacultyID);
            $('#Position').val(Position);
            $('#ApplicationStatus').val(ApplicationStatus);
            $('#Manifesto').val(Manifesto);
            $('#Slogan').val(Slogan);
            $('#editapplication').modal('show');
        });
        $("#save_edit").click(function(e){
            e.preventDefault();
            $("#save_edit").prop("value", "Saving .....");

            $.ajax(
                {
                type: 'POST',
                url: "{{ route('application.update') }}",
                data:  $('#formedit').serialize(),
                success:function(data){
                    console.log(data.status);
                    $("#save_edit").prop("value", "Save");
                    $('#editapplication').modal('hide');
                    $('#application-table').DataTable().ajax.reload();
                    if (data.status==1) {
                        toastr.success('application Updated', {timeOut: 5000});
                    }
                    else {
                        toastr.warning('Failed Try again ', {timeOut: 5000});
                    }
                }      
            });
        });
        //Delete
        $('body').on('click', '.btn-delete', function(){
            var ApplicationID = $(this).attr('ApplicationID');
            var FacultyID = $(this).attr('FacultyID');

            $('#del_ID').val(ApplicationID);
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
                url: "{{ route('application.delete') }}",
                data:  $('#formdelete').serialize(),
                success:function(data){
                    $("#confirmDelete").prop("value", "Delete");
                    $('#deleteModal').modal('hide');
                    $('#application-table').DataTable().ajax.reload();
                    if (data.status==1) {
                        toastr.success('Application Deleted', {timeOut: 5000});
                    }
                    else if (data.status==0) {
                        toastr.warning('Failed Try again ', {timeOut: 5000});
                    }
                }      
            });
        });
    });
    
</script>
@endsection
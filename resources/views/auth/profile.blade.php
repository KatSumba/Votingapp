@extends('layouts.base')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Profile</h1>
        
    </div>
    <!-- Page body -->
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;">
                    <h5 class="my-3">{{ Auth::user()->FirstName}} {{ Auth::user()->LastName}}</h5>
                    <p class="text-muted mb-1">{{ Auth::user()->FacultyID}}</p>
                    <p class="text-muted mb-4">Enrollment Status: {{ Auth::user()->EnrollmentStatus}}</p>
                    <div class="d-flex justify-content-center mb-2">
                    
                    <button type="button" class="btn btn-primary mb-3 " data-bs-toggle="modal" data-bs-target=".gd-example-modal-lg">Edit Profile</button>


     
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Faculty ID</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ Auth::user()->FacultyID}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Full Name</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ Auth::user()->FirstName}} {{ Auth::user()->LastName}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ Auth::user()->email}}</p>
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Enrollment Status</p>
                    </div>
                    <div class="col-sm-2">
                        @if (Auth::user()->EnrollmentStatus =='active')
                            <p class="rounded p-1 text-success"style="background-color: rgba(25, 135, 84, 0.1); border-radius: 50%;">Active</p>
                        @endif
                        @if(Auth::user()->EnrollmentStatus =='inactive')
                            <p class="rounded p-1 text-danger"style="background-color: rgba(220,53,69,.1); border-radius: 50%;">Inactive</p>
                        @endif
                    </div>
                    </div>
                    <hr>
                    
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
    
</div>
<!-- /.container-fluid -->


<!-- Edit Modal -->
<div class=" modal fade gd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="row modal-dialog modal-lg">
        <div class="col-12 modal-content">
            <!--New Application Button-->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <!--New Application Form-->
            <div class="modal-body">
                
                <form action="/editprofile" method="post" class="file-upload" id="my-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-5 gx-5 justify-content-center">
                        <!-- Upload profile -->
                        <div class="col-md-6">
                            <div class="bg-secondary-soft px-4 py-5 rounded">
                                <div class="row g-3">
                                    <h4 class="mb-4 mt-0">Upload your profile photo</h4>
                                    <div class="text-center">
                                        <!-- Image upload -->
                                        <div class="square position-relative display-2 mb-3">
                                            <i class="fas fa-fw fa-user position-absolute top-50 start-50 translate-middle text-secondary"></i>
                                        </div>
                                        <!-- Button -->
                                        <input type="file" id="customFile" name="file" hidden="">
                                        <label class="btn btn-success-soft btn-block" for="customFile">Upload</label>
                                        <button type="button" class="btn btn-danger-soft">Remove</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- Contact detail -->
                        <div class="col-md-6 mb-5 mb-xxl-0">
                            <div class="bg-secondary-soft px-4 py-5 rounded">
                                <div class="row g-3">
                                    <h4 class="mb-4 mt-0">Contact detail</h4>
                                    <!-- First Name -->
                                    <div class="col-md-12">
                                        <label class="form-label">First Name *</label>
                                        <input type="text" class="form-control" name="FirstName" placeholder="" aria-label="First name" value="{{$user->FirstName}}" required>
                                    </div>
                                    <!-- Last name -->
                                    <div class="col-md-12">
                                        <label class="form-label">Last Name *</label>
                                        <input type="text" class="form-control" name="LastName" placeholder="" aria-label="Last name" value="{{$user->LastName}}" required>
                                    </div>
                                    <!-- Email -->
                                    <div class="col-md-12">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email" class="form-control" value="{{$user->email}}" required>
                                    </div>
                                </div> <!-- Row END -->
                            </div>
                            
                        </div>
                        <!-- Buttons -->
                        <div class="gap-3 d-md-flex justify-content-md-center text-center">
                            <button type="submit" class="btn btn-primary mb-3 ">Update profile</button>
                        </div>
                    </div> <!-- Row END -->
                </form>
            </div>
            
        </div>
    </div>
</div>

@endsection



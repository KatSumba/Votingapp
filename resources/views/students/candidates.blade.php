@extends('layouts.base')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Qualified Candidates</h1>
        
    </div>
    
    
    <!-- Page body -->
    <section style="background-color: #eee;">
        <div class="container py-5">
            <!-- Position Section -->
            @foreach ($positions as $position)
                <div class="mb-10">
                    <div class="text-center">
                        <h3 class="h3 m-5 text-gray-800">{{$position}}</h3>
                    </div>

                    
                    <div class="row justify-content-center">
                        <!-- Candidate Section -->
                        @foreach ($applications as $application)
                            @if ($application->Position === $position)
                                @foreach($infos as $info)
                                    @if($application->FacultyID ===$info->FacultyID)
                                        <div class="col-md-4">
                                            <div class="card mb-4">
                                                <div class="card-body text-center">
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                                                    class="rounded-circle img-fluid" style="width: 150px;">
                                                    <h5 class="my-3">{{$application->FacultyID}}</h5>
                                                    <h5 class="my-3">{{$info->FirstName}} {{$info->LastName}}</h5>

                                                    <div class="row ">
                                                        <div class="col-sm-6 ">
                                                            <p class="text-muted mb-1 text-sm-end">Office: </p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <p class="text-muted mb-1 text-sm-start">{{$application->Position}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <p class="text-muted mb-1 text-sm-end">Slogan: </p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <p class="text-muted mb-1 text-sm-start">{{$application->Slogan}}</p>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-center mb-2">
                                                        <button type="button" class="btn btn-link mb-3 " data-bs-toggle="modal" data-bs-target=".{{$application->slug}}">Read more</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Know more Modal -->
                                        <div class=" modal fade {{$application->slug}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="row modal-dialog modal-lg">
                                                <div class="col-12 modal-content">
                                                    <!--New Application Button-->
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabelOne">Know More</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true"></span>
                                                        </button>
                                                    </div>
                                                    <!--New Application Form-->
                                                    <div class="modal-body">
                                                        <div class="row justify-content-center">
                                                            <div class=" col-md-6 card mb-4">
                                                                <div class="card-body text-center">
                                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                                                                    class="rounded-circle img-fluid" style="width: 150px;">
                                                                    <h5 class="my-3">{{$application->FacultyID}}</h5>
                                                                    <h5 class="my-3">{{$info->FirstName}} {{$info->LastName}}</h5>
                                                                    <div class="row justify-content-center">
                                                                        <div class="col-sm-3">
                                                                            <p class="text-muted mb-1 text-sm-end">Office: </p>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <p class="text-muted mb-1 text-sm-start">{{$application->Position}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row justify-content-center">
                                                                        <div class="col-sm-3">
                                                                            <p class="text-muted mb-1 text-sm-end">Slogan: </p>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <p class="text-muted mb-1 text-sm-start">{{$application->Slogan}}</p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class=" col-md-6 card mb-4" style="border: none;">
                                                                <div class="card-body text-center">
                                                                    <h5 class="my-3">Manifesto</h5>
                                                                    <p class="text-muted mb-1 ">{{$application->Manifesto}}
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Know more Modal -->
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                        
                </div>
            @endforeach
            

            

            <!-- More positions and candidates -->
        </div>
    </section>

</div>
<!-- /.container-fluid -->



@endsection
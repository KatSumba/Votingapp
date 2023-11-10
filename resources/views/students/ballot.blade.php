@extends('layouts.base')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ballot</h1>
        
    </div>
    @if ($existingVote)
        <div class="row justify-content-center">
            <div class="alert alert-warning col-md-6" role="alert">
                Your vote has already been recorded. If you believe this to be wrong, please contact your administrator.
            </div>
        </div>
        
    @else
        <!-- Page body -->
        <section style="background-color: #eee;">
            
            <!-- Each Position Has a form -->
            <!-- Position Section -->
            <form action="/castvote" method="post">
                @csrf
                @foreach ($positions as $position)
                    <!-- Section -->
                    <div class="mb-10">
                        <div class="text-center">
                            <h3 class="h3 mb-2 text-gray-800">{{$position->position}}</h3>
                        </div>

                    </div>
                    @php
                        $count = $loop->iteration; // This will give you the current iteration count
                    @endphp

                    <!-- Candidate Section -->
                    @foreach ($applications as $application)
                        @if ($application->Position === $position->position)
                            @foreach($infos as $info)
                                @if($application->FacultyID ===$info->FacultyID)
                                    
                                    <!-- Options -->
                                    <div class="row d-flex justify-content-center align-items-center h-100">
                                        <!-- Option 1 -->
                                        <div class="card mb-5 col-md-7" style="border-radius: 15px;">
                                            <div class="card-body p-2">
                                                
                                                <div class="row d-flex justify-content-center align-items-center">
                                                    <a href="#!" class="col-sm-1">
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                                                        class="img-fluid rounded-circle me-3" width="35">
                                                    </a>
                                                    <p class="mb-0 text-uppercase col-sm-4"><span
                                                        class="text-muted small">{{$application->FacultyID}} - {{$info->FirstName}} {{$info->LastName}}</span>
                                                    <p class="mt-3 text-uppercase col-sm-3"><span
                                                        class="text-muted small">{{$application->Slogan}}</span></p>
                                                    <p class="mb-0 text-uppercase col-sm-3"><span
                                                        class="text-muted small text-md-end">-{{$application->Position}}</span></p>
                                                    <input type="radio" class="mb-0 text-uppercase col-sm-1"id="age1" name="voteID{{$count}}" value="{{$application->slug}}">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Option 1 -->
                                    <!-- End Options -->
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endforeach    
                    <!-- End Section -->
                    
                @endforeach
                <div class="row d-flex justify-content-end align-items-center h-100">
                    
                    <div class="mb-5 col-md-4" style="border-radius: 15px;">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        
        </section>
    @endif

</div>
<!-- /.container-fluid -->

@endsection


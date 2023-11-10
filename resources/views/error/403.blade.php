@extends('layouts.base')
@section('content')
               <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- 404 Error Text -->
                    <div class="text-center">
                        <div class="error mx-auto" data-text="404">403</div>
                        <p class="lead text-gray-800 mb-5">Forbiden</p>
                        <p class="text-gray-500 mb-0">It seems you've stumbled upon a glitch in the matrix... Access Denied</p>
                        @if (auth()->check() && auth()->user()->role == 1)
                            <a href="/home">&larr; Back to Dashboard</a>
                        @endif
                        @if (auth()->check() && auth()->user()->role == 0)
                            <a href="/home">&larr; Back to Dashboard</a>
                        @endif
                    </div>

                </div>
                <!-- /.container-fluid -->

@endsection            
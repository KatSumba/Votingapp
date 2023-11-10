@extends('layouts.app')

@section('content')

<div class="container text-center mt-5">
    <!-- Voting Icon (Font Awesome) -->
    <i class="fas fa-vote-yea fa-5x text-primary"></i>
    
    <!-- Welcome Message -->
    <h1 class="mt-3">Welcome to Evoting</h1>
    
    <!-- Get Started Button -->
    <a href="/login" class="btn btn-primary mt-3">Get Started</a>
</div>

@endsection
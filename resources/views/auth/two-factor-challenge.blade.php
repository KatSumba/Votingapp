@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Two-Factor Authentication') }}</div>

                <div class="card-body">

                    <p>An OTP has been sent to your email address. Please check your email and enter the code below:</p>

                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf

                        <label for="code">One-Time Password (OTP)</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="code" required autofocus autocomplete="off">

                        @error('code')
                            <p>{{ $message }}</p>
                        @enderror

                        <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

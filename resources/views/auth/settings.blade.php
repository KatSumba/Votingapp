@extends('layouts.base')

@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status')}}
    </div>
@endif
<h1>Settings</h1>
<div class="container">
    <div class="card mb-4">
        <div class="card-body text-center">
            @if(! auth()->user()->two_factor_secret)
                <p>2FA is disabled </p>
                <form method="POST" action="{{ route('two-factor.enable') }}">
                    @csrf
                    <button type='submit' class="btn btn-success">Enable </button>

                </form>
            @else
                <p>2FA is enabled </p>
                <form method="POST" action="{{ route('two-factor.disable') }}">
                    @csrf
                    @method('DELETE')
                    <button type='submit' class="btn btn-danger">Disable </button>

                </form> 
                @if(session('status') == 'two-factor-authentication-enabled')
                    <p>Scan the following QR code into your authenticator application </p>
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                @endif
            @endif
        </div>
    </div>
</div>

                    

@endsection
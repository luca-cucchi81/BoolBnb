@extends('layouts.guest.app')
@section('main')
<div class="auth">
    <div class="container">
        <div class="form">
            <h2>Reset Password</h2>
            @if (session('status'))
                <span class="alert alert-danger">
                    {{session('status')}}
                </span>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" placeholder="Insert your email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-button">
                    <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

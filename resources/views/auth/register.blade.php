@extends('layouts.guest.app')
@section('main')
<div class="auth">
    <div class="container">
        <div class="form">
            <h2>Register</h2>
            <form method="POST" action="{{route('register')}}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" placeholder="Type your full name" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" placeholder="Insert your email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="pass" type="password" placeholder="Insert your password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" placeholder="Confirm your password" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>
                <div class="form-button">
                    <button type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

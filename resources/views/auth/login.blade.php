@extends('layouts.guest.app')
@section('main')
<div class="auth">
    <div class="container">
        <div class="form">
            <h2>Login</h2>
            <form method="POST" action="{{route('login')}}">
                @csrf
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" placeholder="Insert your email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" placeholder="Insert your password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @if (Route::has('password.request'))
                        <a class="forgot" href="{{route('password.request')}}">Forgot your Password?</a>
                    @endif
                    @error('password')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="checkbox" name="remember" id="remember" {{old('remember') ? 'checked' : '' }}>
                    <label class="check-label" for="remember">Remember Me</label>
                </div>
                <div class="form-button">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

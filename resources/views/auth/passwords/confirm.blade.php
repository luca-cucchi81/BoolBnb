@extends('layouts.guest.app')
@section('main')
<div class="auth">
    <div class="container">
        <div class="form">
            <h2>Confirm your Password</h2>
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="form-group">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @if (Route::has('password.request'))
                        <a class="forgot" href="{{route('password.request')}}">Forgot your Password?</a>
                    @endif
                    @error('password')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                    </div>
                </div>
                <div class="form-button">
                    <button type="submit" class="btn btn-primary">Confirm Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

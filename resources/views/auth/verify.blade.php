@extends('layouts.guest.app')
@section('main')
<div class="container">
    <div class="form">
        <h2>Verify your Email</h2>
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
        <formmethod="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit">{{ __('click here to request another') }}</button>.
        </form>
    </div>
</div>
@endsection

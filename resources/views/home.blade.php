@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a class="btn btn-primary" href="{{route('admin.apartments.index')}}">Vai agli Appartamenti</a>
                    <a class="btn btn-primary" href="{{route('admin.messages.index')}}">Vai ai messaggi</a>
        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

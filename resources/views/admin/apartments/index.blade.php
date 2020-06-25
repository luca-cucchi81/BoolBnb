@extends('layouts.admin.app')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Apartments</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            @if ($apartments->contains('user_id', $userId))
                {{-- <div class="row"> --}}
                <div class="v-50 mx-auto">
                    <a class="btn btn-success" id="create-apt" href="{{route('admin.apartments.create')}}">Insert a new Apartment</a>
                </div>
                {{-- </div> --}}
                <table class="table table-index">
                    <thead class="table-active">
                        <tr>
                            <th class="text-center">TITLE</th>
                            <th class="text-center">ADDRESS</th>
                            <th class="text-center">VISIBILITY</th>
                            <th colspan="3" class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apartments as $apartment)
                            @if (Auth::id() == $apartment->user_id)
                            <tr>
                                <td>{{$apartment->title}}</td>
                                <td>{{$apartment->address}}</td>
                                <td class="text-center">
                                    @if ($apartment->visibility == 1)
                                        <i class="fas fa-eye"></i>
                                    @else
                                        <i class="fas fa-eye-slash"></i>
                                    @endif
                                </td>
                                <td><a class="btn btn-primary" href="{{route('admin.apartments.show', $apartment->id)}}">VIEW</a></td>
                                <td><a class="btn btn-warning" href="{{route('admin.apartments.edit', $apartment->id)}}">EDIT</a></td>
                                <td>
                                    <form action="{{route('admin.apartments.destroy', $apartment->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">REMOVE</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="row">
                    <div class="v-50 mx-auto">
                        <a class="btn btn-success" id="create-apt" href="{{route('admin.apartments.create')}}">Insert your first Apartment</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

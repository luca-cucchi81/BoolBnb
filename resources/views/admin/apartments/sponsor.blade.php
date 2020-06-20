@extends('layouts.app')
@section('content')
    <form action={{route('admin.sponsorships.store')}} method="post">
        @csrf
        @method("POST")
        <div class="container plan-container">
            <div class="row">
                <div class="col-md-12 plan-card-col">
                @foreach ($sponsorships as $sponsorship)
                    <div class="card plan-standard-card">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">EUR {{$sponsorship["price"]}}</h6>
                            <p class="card-text">DURATA: {{$sponsorship["duration"]}} GIORNI</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sponsorship" value="{{$sponsorship["id"]}}">
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        <input type="hidden" name="apartment" value="{{$apartment->id}}">
        <button type="submit" class="d-none" id="invia">Conferma pagamento</button>
    </form>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js'></script>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div id="dropin-container"></div>
                <button id="submit-button">Verifica metodo di pagamento</button>
            </div>
        </div>
    </div>
    <script src="{{asset('js/admin/sponsor.js')}}" charset="utf-8"></script>
@endsection

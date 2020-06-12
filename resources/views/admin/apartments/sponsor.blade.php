@extends('layouts.app')
@section('content')
    <form method ="POST">
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
                                <input class="form-check-input" type="radio" name="payment" value="{{$sponsorship["id"]}}">
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="{{$apartment->id}}">
        <div id='dropin-container' class=""></div>
        <button id="submit" type="button" name="button"><a href="#">VAI AL PAGAMENTO</a></button>
    </form>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js'></script>
    <div class='container'>
    <div class='row'>
    <div class='col-md-8 col-md-offset-2'>
    <div id='dropin-container'></div>
    <button id='submit-button'>Request payment method</button>
    </div>
    </div>
    </div>
    <script>
    var button = document.querySelector('#submit-button');
    braintree.dropin.create({
    authorization: 'sandbox_s9cpwv6d_7q3bydbjsbv3fhzh',
    container: '#dropin-container'
    }, function (createErr, instance) {
    button.addEventListener('click', function () {
    instance.requestPaymentMethod(function (err, payload) {
    $.get('{{ route('payment.make') }}', {payload}, function (response) {
    if (response.success) {
    alert('Payment successfull!');
    } else {
    alert('Payment failed');
    }
    }, 'json');
    });
    });
    });
    </script>
@endsection

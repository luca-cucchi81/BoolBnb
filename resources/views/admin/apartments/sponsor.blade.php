@extends('layouts.app')
@section('content')
    <form action={{route('admin.apartments.pivot')}} method="post">
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
<script>
    var button = document.querySelector('#submit-button');
    braintree.dropin.create({
        authorization: "sandbox_s9xqyk6g_xz56dq67js5wg4tb",
        container: '#dropin-container'
    }, function (createErr, instance) {
        button.addEventListener('click', function () {
            $('#invia').removeClass('d-none');
            $('#submit-button').addClass('d-none');
            $('.braintree-toggle').click(function(){
                $('#submit-button').removeClass('d-none');
                $('#invia').addClass('d-none');
            });
            instance.requestPaymentMethod(function (err, payload) {
                $.get('{{route('admin.payment.make')}}', {payload}, function (response) {
                    if (response.success) {

                    } else {
                        alert('Payment failed');
                    }
                }, 'json');
            });
        });
    });
</script>
@endsection

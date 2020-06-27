$(document).ready(function () {
    var button = document.querySelector('#submit-button'); // Funzione che crea il layout per inserire la carta come metodo di pagamento
    braintree.dropin.create({
        authorization: "sandbox_s9xqyk6g_xz56dq67js5wg4tb",
        container: '#dropin-container'
    }, function (createErr, instance) {
        button.addEventListener('click', function () { // Al click del bottone verifica mi compare il bottone di invio del form
            $('#submit-button').addClass('d-none');
            $('.braintree-toggle').click(function(){
                $('#submit-button').removeClass('d-none');
                $('#invia').addClass('d-none');
            });
            setTimeout(function () {
                $('#invia').removeClass('d-none');
            }, 1000);
            instance.requestPaymentMethod(function (err, payload) {
                $.get("{{'route('admin.payment.make')}}", {payload}, function (response) {
                    console.log({response});
                    if (response.success) {

                    } else {
                        alert('Payment failed');
                    }
                }, 'json');
            });
        });
    });
});

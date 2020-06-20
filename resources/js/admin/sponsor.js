$(document).ready(function () {
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
                $.get("{{'route('admin.payment.make')}}", {payload}, function (response) {
                    if (response.success) {

                    } else {
                        alert('Payment failed');
                    }
                }, 'json');
            });
        });
    });
});

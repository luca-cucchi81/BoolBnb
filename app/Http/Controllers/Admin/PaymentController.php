<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Braintree\Transaction;

class PaymentController extends Controller
{
    public function make(Request $request) // Funzione che simula un pagamento e restituisce un Json con il risultato
    {
        $payload = $request->input('payload', false);
        $nonce = $payload['nonce'];
        $status = Transaction::sale([
            'amount' => '10.00',
            'paymentMethodNonce' => $nonce,
            'options' => [
               'submitForSettlement' => True
                 ]
          ]);

        return response()->json($status);
    }
}

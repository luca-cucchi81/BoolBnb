<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree\Transaction;

class PaymentController extends Controller
{
    public function make(Request $request)
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

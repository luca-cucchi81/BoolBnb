<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function storeSession(Request $request){
        $request->session()->put('user_id', Auth::id());
    }
}

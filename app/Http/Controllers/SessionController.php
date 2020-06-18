<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SessionController extends Controller {
   public function accessSessionData(Request $request) {
       dd($request -> session()->all());
      if($request->session()->has('user_id'))
         echo $request->session()->get('user_id');
      else
         echo 'No data in the session';
   }
   public function storeSessionData(Request $request) {
      $request->session()->put('user_id', Auth::id());
      $now = Carbon::now();
      $request->session()->put('now', $now);
      $request->session()->put('ciao', 'ciao');
   }
   public function deleteSessionData(Request $request) {
      $request->session()->forget('my_name');
      echo "Data has been removed from session.";
   }
}

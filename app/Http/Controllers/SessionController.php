<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SessionController extends Controller {
   public function accessSessionData(Request $request) {
      if($request->session()->has('user_id'))
         echo $request->session()->get('user_id');
      else
         echo 'No data in the session';
   }
   public function storeSessionData(Request $request) {
      $request->session()->put('user_id', Auth::id());
      echo "Data has been added to session";
   }
   public function deleteSessionData(Request $request) {
      $request->session()->forget('my_name');
      echo "Data has been removed from session.";
   }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RedirectController extends Controller
{
    public function redirect_login()
    {
        //'http://localhost/fleet_ordering_app/dashboard'
  		return redirect()->intended(config('app.hostname') .'/' .config('app.app_url') .'/claim-list');
    }

    public function redirect_logout()
    {
      
        //'http://localhost/fleet_ordering_app/dashboard'
  		return Redirect::to(config('app.hostname') .'/' .config('app.webapps_url'));
    }
}

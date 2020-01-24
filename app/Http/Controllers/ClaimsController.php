<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClaimsController extends Controller
{
    //

    public function index(){
        return view('claim_list');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        if(session('user')['user_type_id'] == 42){
             return redirect()->route('claim-list');
        }
        
        else if(session('user')['user_type_id'] == 43){
             return redirect()->route('admin-claims');
        }
    }
}

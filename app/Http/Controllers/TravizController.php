<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TravizController extends Controller
{
    public function service_campaign2020()
    {   
        $data = [
            'title' => 'test'
        ];
        return view('traviz.service_campaign_2020', $data);
    }
}

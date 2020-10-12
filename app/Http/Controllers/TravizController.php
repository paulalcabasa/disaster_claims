<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TravizController extends Controller
{
    public function index()
    {   
        $data = [
            'title' => 'test'
        ];
        return view('traviz.entry', $data);
    }
}

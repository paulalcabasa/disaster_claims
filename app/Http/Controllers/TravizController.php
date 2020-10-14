<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Traviz;
use App\Models\Dealer;

class TravizController extends Controller
{
    public function service_campaign2020()
    {   
        $dealers = Dealer::orderBy('account_name', 'ASC')->get();
      
        $data = [
            'dealers' => $dealers
        ];
        return view('traviz.service_campaign_2020', $data);
    }

    public function findVehicle(Request $request)
    {
        $param = $request->searchParam;
        $traviz = new Traviz;
        $details = $traviz->getDetails($param);
        return response()->json($details);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\ModelParts;

class VehicleController extends Controller
{

    public function get(Request $request, Vehicle $vehicle){
        $vehicleDetails = $vehicle->getDetails($request->cs_no);
        return $vehicleDetails;
    }

    public function getAffectedUnits(){
        $vehicle = new Vehicle;
        return $vehicle->getAffectedUnits();
    }

    

}

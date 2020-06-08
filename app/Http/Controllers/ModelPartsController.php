<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleModel;
use App\Models\ModelParts;
use DB;

class ModelPartsController extends Controller
{
    public function get(Request $request, ModelParts $modelParts) {
        $parts = $modelParts->getParts($request->model_id);

        $data = [];

        foreach($parts as $part){
            array_push($data,
            [
                'part_id'      => $part->part_id,
                'part_no'      => $part->part_no,
                'description'  => $part->description,
                'checked_flag' => false,
            ]);
        }
        return $data;
    }

    public function getModelParts() {
       $sql = "SELECT mdl.model_name,
                      mp.description part_description
                FROM ipc.ipc_dcm_models mdl
                    LEFT JOIN ipc.ipc_dcm_model_parts mp
                    ON mp.model_id = mdl.model_id";

        $query = DB::select($sql);

        return $query;

    }

    public function chromeMatrix(){
        $data = [];
        $parts = ModelParts::distinct()->get(['description']);
        $vehicles = VehicleModel::all();

       
        $headers = ['Model'];

        $chrome_matrix = [];

        foreach($parts as $part){
            array_push($headers, $part->description);
        }
        
        foreach($vehicles as $vehicle){
            $vehicle_data = [];
            array_push($vehicle_data, $vehicle->model_name);
            
            $vehicle_parts = ModelParts::select('description')->where('model_id', $vehicle->model_id)->pluck('description')->toArray();

            foreach($parts as $part){
              
                if(in_array($part->description, $vehicle_parts)){
                    array_push($vehicle_data, 'Y');
                }
                else {
                    array_push($vehicle_data, 'N');
                }
            }
            
            array_push($chrome_matrix,$vehicle_data);

        }
        
        $data = [
            'header' => $headers,
            'chrome_matrix' => $chrome_matrix
        ];

        return view('chrome_matrix',$data);
    }

}

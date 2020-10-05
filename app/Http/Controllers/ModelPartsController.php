<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleModel;
use App\Models\ModelParts;
use App\Models\Vehicle;
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
       $sql = "SELECT mdl.model_id,
                        mdl.model_name
                FROM ipc.ipc_dcm_models mdl";
        $query = DB::select($sql);

        return $query;

    }

    public function getParts(Request $request){
        $modelParts = new ModelParts;
        $parts = $modelParts->getParts($request->model_id);
        return response()->json($parts,200);
    }

    public function chromeMatrix(){
        $data = [];
        $parts = ModelParts::distinct()
                ->where('status','A')->get(['description']);
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

    public function store(Request $request){
        $model  = $request->model;
        $parts = $request->parts;

         DB::beginTransaction();

        try {
            

            foreach($parts as $part){
                if($part['delete_flag'] == 'Y'){
                    // delete
                    $modelParts = ModelParts::find($part['part_id']);
                    $modelParts->status = 'I';
                    $modelParts->updated_by =  session('user')['user_id'];
                    $modelParts->update_user_source = session('user')['source_id'];
                    $modelParts->save();
                }
                if($part['part_id'] != ""){
                    // update
                    $modelParts = ModelParts::find($part['part_id']);
                    $modelParts->description = $part['description'];
                    if($part['delete_flag'] == 'Y'){
                        $modelParts->status = 'I';
                    }
                    $modelParts->updated_by =  session('user')['user_id'];
                    $modelParts->update_user_source = session('user')['source_id'];
                    $modelParts->save();
                }
                else {
                    // insert
                    $modelParts = new ModelParts;
                    $modelParts->description = $part['description'];
                    $modelParts->model_id = $model['model_id'];
                    $modelParts->created_by =  session('user')['user_id'];
                    $modelParts->create_user_source = session('user')['source_id'];
                    $modelParts->save();
                }
            }
            DB::commit();
            return [
                'message'  => 'Parts has been updated.',
                'error'    => false
            ];
        } catch(\Exception $e) {
            DB::rollBack();
            return [
                'message'  => 'Error :' . $e,
                'error'    => true
            ];

        }
        return response()->json([
            $model,
            $parts
        ]);
    }

    public function affectedUnitsChrome(){
        $data = [];
        $parts = ModelParts::distinct()
                ->where('status','A')->get(['description']);
      
        //$vehicles = VehicleModel::all();

        $m_vehicle = new Vehicle;
        $affectedUnits = $m_vehicle->getAffectedUnitsForChrome();
       
        $headers = ['Model', 'CS No.'];

        $chrome_matrix = [];

        foreach($parts as $part){
            array_push($headers, $part->description);
        }
        
        foreach($affectedUnits as $vehicle){
            $vehicle_data = [];
            array_push($vehicle_data, $vehicle->sales_model);
            array_push($vehicle_data, $vehicle->cs_number);
            
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

        return view('affected_units_chrome',$data);
    }

}

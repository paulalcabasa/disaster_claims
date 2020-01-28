<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelParts;


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

}

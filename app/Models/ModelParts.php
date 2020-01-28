<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelParts extends Model
{
    protected $table = "IPC.IPC_DCM_MODEL_PARTS";
	protected $connection = "oracle";

    public function getParts($modelId){
        try{
            $query = $this->where('model_id',$modelId)->get();
            return $query;
        } catch(Exception $e) {
            return false;
        } 
    }

    
}

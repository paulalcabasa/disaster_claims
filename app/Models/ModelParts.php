<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ModelParts extends Model
{
    protected $table = "IPC.IPC_DCM_MODEL_PARTS";
    protected $primaryKey = "part_id";
	protected $connection = "oracle";

    public function getParts($modelId){
        try{
            
            $sql = "SELECT prt.part_id,
                            prt.description,
                            prt.model_id,
                            'N' delete_flag,
                            prt.part_no
                    FROM ipc.ipc_dcm_model_parts prt
                    WHERE prt.model_id = :model_id
                        AND prt.status = 'A'";
          /*   $query = $this->where('model_id',$modelId)
                ->select()    
                ->get(); */
            $query = DB::select($sql,['model_id' => $modelId]);
            return $query;
        } catch(Exception $e) {
            return false;
        } 
    }

    
}

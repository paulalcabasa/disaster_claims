<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimLines extends Model
{
    protected $table = "IPC.IPC_DCM_CLAIM_LINES AS cl";
    protected $connection = "oracle";
    protected $primaryKey  = "claim_line_id";
    public $timestamps = false;

    public function getParts($claimHeaderId){
        return $this
                ->leftJoin('ipc.ipc_dcm_model_parts AS mp', 'mp.part_id','cl.part_id')
                ->where('claim_header_id',$claimHeaderId)->get();
    }
}

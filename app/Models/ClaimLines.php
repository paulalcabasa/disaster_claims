<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimLines extends Model
{
    protected $table = "IPC.IPC_DCM_CLAIM_LINES";
    protected $connection = "oracle";
    protected $primaryKey  = "claim_line_id";
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $table = "IPC.IPC_DCM_MODELS";
	protected $connection = "oracle";
}

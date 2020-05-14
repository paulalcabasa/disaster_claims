<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $connection = 'oracle_portal';
    protected $table = 'ipc_portal.user_details';
    protected $primaryKey = 'user_detail_id';
    const UPDATED_AT = 'date_updated';
}

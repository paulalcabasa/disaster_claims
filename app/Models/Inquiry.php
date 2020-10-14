<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = "ipc.ipc_dcm_inquiries";
    protected $primaryKey = "id";
    protected $connection = "oracle";
    protected $fillable = ['registered_owner', 'contact_person', 'contact_number', 'email_address', 'preferred_servicing_dealer', 'cs_no'];
}

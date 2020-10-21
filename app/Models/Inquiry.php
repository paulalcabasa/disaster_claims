<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Inquiry extends Model
{
    protected $table = "ipc.ipc_dcm_inquiries";
    protected $primaryKey = "id";
    protected $connection = "oracle";
    protected $fillable = ['registered_owner', 'contact_person', 'contact_number', 'email_address', 'preferred_servicing_dealer', 'cs_no'];

    public function getPendingEmail(){
        $sql = "SELECT inquiry.id,
                        inquiry.registered_owner,
                        inquiry.contact_person,
                        inquiry.contact_number,
                        inquiry.email_address,
                        inquiry.cs_no,
                        inquiry.date_sent,
                        dlr.account_name,
                        dlr.dealer_name,
                        dlr_crt.email dealer_crt_email,
                        traviz.engine_no,
                        traviz.vin,
                        cust.party_name || ' - ' || cust.account_name selling_dealer
                FROM ipc.ipc_dcm_inquiries inquiry
                    LEFT JOIN ipc_portal.dealers dlr
                        ON inquiry.preferred_servicing_dealer = dlr.id
                    LEFT JOIN ipc.ipc_dcm_dealer_crt_emails dlr_crt
                        ON dlr_crt.dealer_id = dlr.id
                    LEFT JOIN  ipc.ipc_dcm_traviz traviz
                        ON traviz.cs_no = inquiry.cs_no
                    INNER JOIN ra_customer_trx_all rcta
                        ON rcta.attribute3 = traviz.cs_no
                    INNER JOIN ipc_dms.oracle_customers_v cust
                        ON cust.site_use_id = rcta.bill_to_site_use_id
                    LEFT JOIN ipc_ar_invoices_with_cm cm
                        ON rcta.customer_trx_id = cm.orig_trx_id
                WHERE inquiry.date_sent IS NULL";
        $query = DB::select($sql);
        return $query;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Traviz extends Model
{
    
    public function getDetails($param){
        $sql = "SELECT  msn.serial_number cs_no,
                        msn.attribute2 vin,
                        cust.account_name,
                        cust.party_name customer_name,
                        traviz.engine_no
                FROM  ipc.ipc_dcm_traviz traviz
                    INNER JOIN mtl_serial_numbers msn
                        ON traviz.cs_no = msn.serial_number
                    INNER JOIN mtl_system_items_b msib
                        ON msn.inventory_item_id = msib.inventory_item_id
                    INNER JOIN ra_customer_trx_all rcta
                        ON rcta.attribute3 = msn.serial_number
                    INNER JOIN ipc_dms.oracle_customers_v cust
                        ON cust.site_use_id = rcta.bill_to_site_use_id
                    LEFT JOIN ipc_ar_invoices_with_cm cm
                        ON rcta.customer_trx_id = cm.orig_trx_id
                WHERE 1 = 1
                    AND msib.organization_id IN (121)
                    AND msib.inventory_item_status_code = 'Active'
                    AND msib.attribute9 IS NOT NULL
                    AND msib.item_type = 'FG'
                    AND msn.c_attribute30 IS NULL
                    AND rcta.cust_trx_type_id = 1002
                    AND cm.orig_trx_id IS NULL
                    AND (traviz.cs_no = :param
                        OR traviz.vin = :param)";
        
        $params = [
            'param' => $param,
        ];

        $query = DB::select($sql,$params);

        $data =  !empty($query) ? $query[0] : $query;

        return $data;
    }
}

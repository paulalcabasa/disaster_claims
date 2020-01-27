<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Vehicle extends Model
{

    public function getDetails($cs_no){
        $sql = "SELECT msib.inventory_item_id,
                        msn.serial_number cs_number,
                        msib.organization_id,
                        ipc_dms.ipc_get_vehicle_variant (msib.segment1) model_variant,
                        NVL (msib.attribute8, 'NO COLOR')               color,
                        msib.segment1                                   prod_model,
                        msib.description                                prod_model_desc,
                        msib.attribute9                                 sales_model,
                        msib.attribute29                                vehicle_type,
                        msn.attribute2 vin_no,
                        dm.model_id
                FROM mtl_serial_numbers msn
                    LEFT JOIN mtl_system_items_b msib
                        ON msn.inventory_item_id = msib.inventory_item_id
                    LEFT JOIN ipc.ipc_dcm_models dm
                        ON dm.model_name = msib.attribute9
                WHERE 1 = 1
                    AND msib.organization_id IN (121)
                        AND msib.inventory_item_status_code = 'Active'
                        AND msib.attribute9 IS NOT NULL
                        AND msib.item_type = 'FG'
                        AND msn.serial_number = :cs_no
                        AND msn.serial_number IN (SELECT cs_number FROM ipc.ipc_dcm_affected_units)
                        AND msn.serial_number NOT IN (SELECT cs_no FROM ipc.ipc_dcm_claim_header)";
        
        $params = [
            'cs_no' => $cs_no
        ];

        $query = DB::select($sql,$params);

        $data =  !empty($query) ? $query[0] : $query;

        return response()->json($data);

    }

}

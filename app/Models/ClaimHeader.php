<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ClaimHeader extends Model
{
    protected $table = "IPC.IPC_DCM_CLAIM_HEADER";
    protected $connection = "oracle";
    protected $primaryKey  = "claim_header_id";
    public $timestamps = false;

    public function getDealerClaims($customer_id){
        $sql = "SELECT ch.claim_header_id,
                        ch.cs_no,
                        msib.attribute9 variant,
                        ipc_dms.ipc_get_vehicle_variant (msib.segment1) model,
                        to_char(ch.creation_date,'mm/dd/yyyy') creation_date,
                        LISTAGG(parts.description, ', ') WITHIN GROUP (ORDER BY parts.description) parts,
                        st.status
                FROM ipc.ipc_dcm_claim_header ch
                    LEFT join mtl_serial_numbers msn
                        ON ch.cs_no = msn.serial_number
                    LEFT JOIN mtl_system_items_b msib
                        ON msn.inventory_item_id = msib.inventory_item_id
                    LEFT JOIN ipc.ipc_dcm_claim_lines cl
                        ON cl.claim_header_id = ch.claim_header_id
                    LEFT JOIN  ipc.ipc_dcm_model_parts parts
                        ON parts.part_id = cl.part_id
                    LEFT JOIN ipc.ipc_dcm_status st
                        ON st.id = ch.status
                WHERE 1 = 1
                    AND ch.customer_id = :customer_id
                    AND msib.organization_id IN (121)
                    AND msib.inventory_item_status_code = 'Active'
                    AND msib.attribute9 IS NOT NULL
                    AND msib.item_type = 'FG'
                GROUP BY
                    ch.claim_header_id,
                    ch.cs_no,
                    msib.attribute9 ,
                    msib.segment1,
                    ch.creation_date,
                    st.status";
        
        $params = [
            'customer_id' => $customer_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function getAllClaims(){
        $sql = "SELECT ch.claim_header_id,
                        ch.cs_no,
                        msib.attribute9 variant,
                        ipc_dms.ipc_get_vehicle_variant (msib.segment1) model,
                        to_char(ch.creation_date,'mm/dd/yyyy') creation_date,
                        cust.party_name customer_name,
                        cust.account_name,
                        LISTAGG(parts.description, ', ') WITHIN GROUP (ORDER BY parts.description) parts,
                        st.status
                FROM ipc.ipc_dcm_claim_header ch
                    LEFT join mtl_serial_numbers msn
                        ON ch.cs_no = msn.serial_number
                    LEFT JOIN mtl_system_items_b msib
                        ON msn.inventory_item_id = msib.inventory_item_id
                    LEFT JOIN ipc_dms.oracle_customers_v cust
                        ON cust.cust_account_id = ch.customer_id
                        AND cust.profile_class = 'Dealers-Vehicle'
                    LEFT JOIN ipc.ipc_dcm_claim_lines cl
                        ON cl.claim_header_id = ch.claim_header_id
                    LEFT JOIN  ipc.ipc_dcm_model_parts parts
                        ON parts.part_id = cl.part_id
                    LEFT JOIN ipc.ipc_dcm_status st
                        ON st.id = ch.status
                WHERE 1 = 1
                    AND msib.organization_id IN (121)
                    AND msib.inventory_item_status_code = 'Active'
                    AND msib.attribute9 IS NOT NULL
                    AND msib.item_type = 'FG'
                GROUP BY
                    ch.claim_header_id,
                    ch.cs_no,
                    msib.attribute9 ,
                    msib.segment1,
                    ch.creation_date,
                    cust.account_name,
                    cust.party_name,
                    st.status
                ";
    
        $query = DB::select($sql);
        return $query;
    }


    public function getDetails($claim_header_id){
        $sql = "SELECT ch.claim_header_id,
                        ch.cs_no,
                        msib.attribute9 variant,
                        ipc_dms.ipc_get_vehicle_variant (msib.segment1) model,
                        to_char(ch.creation_date,'mm/dd/yyyy') creation_date
                FROM ipc.ipc_dcm_claim_header ch
                    LEFT join mtl_serial_numbers msn
                        ON ch.cs_no = msn.serial_number
                    LEFT JOIN mtl_system_items_b msib
                        ON msn.inventory_item_id = msib.inventory_item_id
                WHERE 1 = 1
                    AND ch.claim_header_id = :claim_header_id
                    AND msib.organization_id IN (121)
                    AND msib.inventory_item_status_code = 'Active'
                    AND msib.attribute9 IS NOT NULL
                    AND msib.item_type = 'FG'
                ";
        
        $params = [
            'claim_header_id' => $claim_header_id
        ];

        $query = DB::select($sql,$params);
        
        $data =  !empty($query) ? $query[0] : $query;

        return $data;
    }
}

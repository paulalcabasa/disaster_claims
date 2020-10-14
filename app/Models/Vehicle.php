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
                        dm.model_id,
                        rcta.trx_number,
                        cust.account_name,
                        cust.party_name customer_name,
                        TO_CHAR(TO_DATE(replace(rcta.attribute5,' ',''),'YYYY/MM/DD HH24:MI:SS'),'MM/DD/YYYY') pullout_date
                FROM mtl_serial_numbers msn
                    LEFT JOIN mtl_system_items_b msib
                        ON msn.inventory_item_id = msib.inventory_item_id
                    LEFT JOIN ipc.ipc_dcm_models dm
                        ON upper(dm.model_name) = upper(msib.attribute9)
                    LEFT JOIN ra_customer_trx_all rcta
                        ON rcta.attribute3 = msn.serial_number
                    LEFT JOIN ipc_dms.oracle_customers_v cust
                        ON CUST.SITE_USE_ID = rcta.bill_to_site_use_id
                WHERE 1 = 1
                    AND msib.organization_id IN (121)
                        AND msib.inventory_item_status_code = 'Active'
                        AND msib.attribute9 IS NOT NULL
                        AND msib.item_type = 'FG'
                        AND msn.serial_number = :cs_no
                        AND msn.serial_number IN (SELECT cs_number FROM ipc.ipc_dcm_affected_units)
                        AND msn.serial_number NOT IN (SELECT cs_no FROM ipc.ipc_dcm_claim_header)
                        AND rcta.sold_to_customer_id = :customer_id";
        
        $params = [
            'cs_no' => $cs_no,
            'customer_id' => session('user')['customer_id']
        ];

        $query = DB::select($sql,$params);

        $data =  !empty($query) ? $query[0] : $query;

        return response()->json($data);
    }

    public function getAffectedUnits(){
        $sql = "SELECT msib.inventory_item_id,
                        msn.serial_number cs_number,
                        msib.organization_id,
                        ipc_dms.ipc_get_vehicle_variant (msib.segment1) model_variant,
                        NVL (msib.attribute8, 'NO COLOR')               color,
                        msib.segment1                                   prod_model,
                        msib.description                                prod_model_desc,
                        CASE WHEN msib.organization_id = 88 THEN 
                            (SELECT attribute9 FROM mtl_system_items_b WHERE inventory_item_id = msib.inventory_item_id AND organization_id = 121) 
                        ELSE msib.attribute9 END  sales_model,
                        msib.attribute29                                vehicle_type,
                        msn.attribute2 vin_no,
                       (CASE WHEN ipc_dms.ipc_get_vehicle_variant (msib.segment1) IN ('MU-X','D-MAX') AND msib.organization_id = 88 THEN 'IPC' ELSE NVL(ato.location, msn.c_attribute29) END) location,
                        TO_CHAR(TO_DATE(replace(rcta.pullout_date,' ',''),'YYYY/MM/DD HH24:MI:SS'),'MM/DD/YYYY') pullout_date,
                        nvl(cust.account_name,rcta.customer_name) account_name,
                        to_char(rs.declare_date,'MM/DD/YYYY') retail_sale_date
                FROM ipc.ipc_dcm_affected_units afu
                    LEFT JOIN mtl_serial_numbers msn
                        ON msn.serial_number = AFU.CS_NUMBER
                    LEFT JOIN mtl_system_items_b msib
                        ON msn.inventory_item_id = msib.inventory_item_id
                        AND msn.current_organization_id = msib.organization_id
                    LEFT JOIN (SELECT rct.trx_number, 
                                        rct.trx_date, 
                                        rct.attribute3 cs_number, 
                                        rct.attribute5 pullout_date, 
                                        rct.sold_to_customer_id,
                                        rct.bill_to_site_use_id,
                                        
                                        ac.customer_name
                                    FROM ra_customer_trx_all rct
                                        LEFT JOIN ipc_vehicle_cm cm
                                            ON rct.customer_trx_id = cm.orig_trx_id
                                            and cm.CM_TRX_TYPE_ID != 10081
                                        LEFT JOIN ar_customers ac
                                         ON ac.customer_id = rct.sold_to_customer_id
                                    WHERE 1 = 1 
                                    AND cm.orig_trx_id IS NULL 
                                    AND rct.cust_trx_type_id = 1002
                        ) rcta
                            ON afu.cs_number = rcta.cs_number
                       LEFT JOIN ipc_dms.oracle_customers_v cust
                                            ON cust.site_use_id = rcta.bill_to_site_use_id
                        left join ipc_dms.crms_retail_sales rs
                                  on rs.cs_no = afu.cs_number
                        LEFT JOIN (SELECT cs_number,
                            destination_to location 
                            FROM (
                                SELECT cs_number,
                                        destination_to,
                                        transfer_date,
                                        RANK ()  OVER (PARTITION BY cs_number ORDER BY transfer_date DESC, date_created DESC) rnk
                                    FROM ipc.ipc_vehicle_ato ato
                                    WHERE     1 = 1)
                            WHERE rnk = 1) ato
                            ON ato.cs_number = afu.cs_number
                WHERE 1 = 1
                    AND msn.c_attribute30 IS NULL";
        $query = DB::select($sql);  
        return $query;
    }

    public function getStatistics($dealer_id = null){

        $where = "";

        if($dealer_id != ""){
            $where = "AND  rcta.sold_to_customer_id = " . $dealer_id;
        }
        $sql = "SELECT count(afu.id) affected_units,
                        sum(case when CH.CLAIM_HEADER_ID is not null then 1 else 0 end) claims,
                        sum(case when rcta.trx_number is not null then 1 else 0 end) invoiced,
                        sum(case when rs.cs_no is not null then 1 else 0 end) retail_sales
                FROM ipc.ipc_dcm_affected_units  afu
                        left join ipc.ipc_dcm_claim_header ch
                            on afu.cs_number  = ch.cs_no
                    left join (SELECT rct.trx_number, rct.trx_date, rct.attribute3 cs_number, rct.attribute5 pullout_date, sold_to_customer_id
                                        FROM ra_customer_trx_all rct
                                            LEFT JOIN ipc_vehicle_cm cm
                                                ON rct.customer_trx_id = cm.orig_trx_id
                                                and cm.CM_TRX_TYPE_ID != 10081
                                        WHERE 1 = 1 
                                        AND cm.orig_trx_id IS NULL 
                                        AND rct.cust_trx_type_id = 1002
                        ) rcta
                            ON afu.cs_number = rcta.cs_number
                    left join ipc_dms.crms_retail_sales rs
                        on rs.cs_no = afu.cs_number
                WHERE 1 = 1" . $where;
        $query = DB::select($sql);  
        $data =  !empty($query) ? $query[0] : $query;
        return response()->json($data);
    }

    public function getAllUnclaimed($dealer_id = null){

        $where = "";

        if($dealer_id != null){
            $where = "AND cust.cust_account_id = " . $dealer_id;
        }
        
        $sql = "SELECT cust.account_name,
                        msn.serial_number cs_number,
                        ipc_dms.ipc_get_vehicle_variant (msib.segment1) model,
                        msib.attribute9  variant
                FROM ipc.ipc_dcm_affected_units afu
                    LEFT JOIN mtl_serial_numbers msn
                        ON msn.serial_number = AFU.CS_NUMBER
                    LEFT JOIN mtl_system_items_b msib
                        ON msn.inventory_item_id = msib.inventory_item_id
                        AND msn.current_organization_id = msib.organization_id
                    LEFT JOIN (SELECT rct.trx_number, 
                                        rct.trx_date, 
                                        rct.attribute3 cs_number, 
                                        rct.attribute5 pullout_date, 
                                        rct.sold_to_customer_id,
                                        rct.bill_to_site_use_id
                                    FROM ra_customer_trx_all rct
                                        LEFT JOIN ipc_vehicle_cm cm
                                            ON rct.customer_trx_id = cm.orig_trx_id
                                            and cm.CM_TRX_TYPE_ID != 10081
                                                    
                                    WHERE 1 = 1 
                                    AND cm.orig_trx_id IS NULL 
                                    AND rct.cust_trx_type_id = 1002
                        ) rcta
                            ON afu.cs_number = rcta.cs_number
                    LEFT JOIN ipc_dms.oracle_customers_v cust
                                            ON cust.site_use_id = rcta.bill_to_site_use_id
                        left join ipc_dms.crms_retail_sales rs
                                on rs.cs_no = afu.cs_number
                    LEFT JOIN ipc.ipc_dcm_claim_header ch
                        ON ch.cs_no = afu.cs_number
                WHERE 1 = 1
                    AND msn.c_attribute30 IS NULL
                    AND ch.cs_no IS NULL
                    ".$where;
        $query = DB::select($sql);  
        return $query;
    }

    public function getAffectedUnitsForChrome(){
        $sql = "SELECT affected_units.*,
                        dcm_models.model_id
                FROM (
                SELECT msib.inventory_item_id,
                                        msn.serial_number cs_number,
                                        msib.organization_id,
                                        ipc_dms.ipc_get_vehicle_variant (msib.segment1) model_variant,
                                        NVL (msib.attribute8, 'NO COLOR')               color,
                                        msib.segment1                                   prod_model,
                                        msib.description                                prod_model_desc,
                                        CASE WHEN msib.organization_id = 88 THEN 
                                            (SELECT attribute9 FROM mtl_system_items_b WHERE inventory_item_id = msib.inventory_item_id AND organization_id = 121) 
                                        ELSE msib.attribute9 END  sales_model,
                                        msib.attribute29                                vehicle_type,
                                        msn.attribute2 vin_no,
                                    (CASE WHEN ipc_dms.ipc_get_vehicle_variant (msib.segment1) IN ('MU-X','D-MAX') AND msib.organization_id = 88 THEN 'IPC' ELSE NVL(ato.location, msn.c_attribute29) END) location,
                                        TO_CHAR(TO_DATE(replace(rcta.pullout_date,' ',''),'YYYY/MM/DD HH24:MI:SS'),'MM/DD/YYYY') pullout_date,
                                        nvl(cust.account_name,rcta.customer_name) account_name,
                                        to_char(rs.declare_date,'MM/DD/YYYY') retail_sale_date
                                FROM ipc.ipc_dcm_affected_units afu
                                    LEFT JOIN mtl_serial_numbers msn
                                        ON msn.serial_number = AFU.CS_NUMBER
                                    LEFT JOIN mtl_system_items_b msib
                                        ON msn.inventory_item_id = msib.inventory_item_id
                                        AND msn.current_organization_id = msib.organization_id
                                    LEFT JOIN (SELECT rct.trx_number, 
                                                        rct.trx_date, 
                                                        rct.attribute3 cs_number, 
                                                        rct.attribute5 pullout_date, 
                                                        rct.sold_to_customer_id,
                                                        rct.bill_to_site_use_id,
                                                        
                                                        ac.customer_name
                                                    FROM ra_customer_trx_all rct
                                                        LEFT JOIN ipc_vehicle_cm cm
                                                            ON rct.customer_trx_id = cm.orig_trx_id
                                                            and cm.CM_TRX_TYPE_ID != 10081
                                                        LEFT JOIN ar_customers ac
                                                        ON ac.customer_id = rct.sold_to_customer_id
                                                    WHERE 1 = 1 
                                                    AND cm.orig_trx_id IS NULL 
                                                    AND rct.cust_trx_type_id = 1002
                                        ) rcta
                                            ON afu.cs_number = rcta.cs_number
                                    LEFT JOIN ipc_dms.oracle_customers_v cust
                                                            ON cust.site_use_id = rcta.bill_to_site_use_id
                                        left join ipc_dms.crms_retail_sales rs
                                                on rs.cs_no = afu.cs_number
                                        LEFT JOIN (SELECT cs_number,
                                            destination_to location 
                                            FROM (
                                                SELECT cs_number,
                                                        destination_to,
                                                        transfer_date,
                                                        RANK ()  OVER (PARTITION BY cs_number ORDER BY transfer_date DESC, date_created DESC) rnk
                                                    FROM ipc.ipc_vehicle_ato ato
                                                    WHERE     1 = 1)
                                            WHERE rnk = 1) ato
                                            ON ato.cs_number = afu.cs_number
                                
                                WHERE 1 = 1
                                    AND msn.c_attribute30 IS NULL
                ) affected_units
                LEFT JOIN IPC.IPC_DCM_MODELS dcm_models
                    ON dcm_models.model_name  = affected_units.sales_model
             
                ";
        $query = DB::select($sql);  
        return $query;
    }

    

}

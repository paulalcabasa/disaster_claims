<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Report extends Model
{
    protected $connection = "crms";

    public function getRsTravis()
    {
        $sql = "SELECT DISTINCT 
                    rs.cs_no                                      
                    ,v.engine_no                                 
                    ,v.vin                                  
                    ,v.model
                    ,IF(c.addr_city IS NULL OR LENGTH(TRIM(c.addr_city)) = 0, 'No Data', m.name)  AS city
                    ,IF(c.addr_city IS NULL OR LENGTH(TRIM(c.addr_city)) = 0, 'No Data', p.name)  AS province
                    ,IF(c.addr_city IS NULL OR LENGTH(TRIM(c.addr_city)) = 0, 'No Data', r.short_name) AS region
                    ,CONCAT_WS('-', rs.dealer_id, d.dealer_name)    AS dealer
                    ,DATE_FORMAT(v.invoice_date, '%m/%d/%Y')        AS invoice_date
                    ,DATE_FORMAT(v.pullout_date, '%m/%d/%Y')        AS pullout_date
                    ,sf_utils_format_lnfnmi(c.fname, c.mname, c.lname, c.suffix) AS customer
                    ,CASE
                        WHEN c.acct_type = 'I' THEN 'Indv'
                        WHEN c.acct_type = 'C' THEN 'Com'
                        WHEN c.acct_type = 'F' THEN 'Flt'
                        ELSE 'No Data'
                    END                                            AS acct_type
                    ,DATE_FORMAT(rdr.delivery_date, '%m/%d/%Y')     AS delivery_date

            /* */
                FROM t_crm_retail_sale rs JOIN (t_crm_vehicle v JOIN t_crm_vehicle_tran t ON v.db_id = t.db_id
                                                                JOIN t_crm_customer_vehicle cv ON v.db_id = cv.vehicle_db_id
                                            )
                                            ON rs.vehicle_db_id = v.db_id 

                                    LEFT JOIN (t_crm_customer c LEFT JOIN t_aum_pgac_region r       ON c.addr_region = r.psgc
                                                                LEFT JOIN t_aum_pgac_province p     ON c.addr_region = p.region_psgc AND c.addr_province = p.psgc
                                                                LEFT JOIN t_aum_pgac_municipality m ON c.addr_province = m.province_psgc AND c.addr_city = m.psgc
                                                )
                                            ON rs.customer_db_id = c.db_id

                                    LEFT JOIN t_crm_rdr rdr ON  rs.vehicle_db_id = rdr.vehicle_db_id /* this causes duplicates -> add distinct modifier */
                                    LEFT JOIN t_crm_dealer d ON rs.dealer_id = d.dealer_id
            /* */
            WHERE v.model LIKE '%TRAV%'
                AND c.acct_type = 'I'

            UNION 

            SELECT DISTINCT
                    rs.cs_no                                       AS cs_no
                    ,v.engine_no                                    AS engine_no
                    ,v.vin                                          AS vin
                            ,v.model
                    ,IF(c.co_addr_city IS NULL OR LENGTH(TRIM(c.co_addr_city)) = 0, 'No Data', m.name)       AS city
                    ,IF(c.co_addr_city IS NULL OR LENGTH(TRIM(c.co_addr_city)) = 0, 'No Data', p.name)       AS province
                    ,IF(c.co_addr_city IS NULL OR LENGTH(TRIM(c.co_addr_city)) = 0, 'No Data', r.short_name) AS region

                    ,CONCAT_WS('-', rs.dealer_id, d.dealer_name)    AS dealer
                    ,DATE_FORMAT(v.invoice_date, '%m/%d/%Y')        AS invoice_date
                    ,DATE_FORMAT(v.pullout_date, '%m/%d/%Y')        AS pullout_date
                    ,c.company_name AS customer
                    ,CASE
                        WHEN c.acct_type = 'I' THEN 'Indv'
                        WHEN c.acct_type = 'C' THEN 'Com'
                        WHEN c.acct_type = 'F' THEN 'Flt'
                        ELSE 'No Data'
                    END                                            AS acct_type
                    ,DATE_FORMAT(rdr.delivery_date, '%m/%d/%Y')     AS delivery_date
            /* */
                FROM t_crm_retail_sale rs JOIN (t_crm_vehicle v JOIN t_crm_vehicle_tran t ON v.db_id = t.db_id
                                                                JOIN t_crm_customer_vehicle cv ON v.db_id = cv.vehicle_db_id
                                            )
                                            ON rs.vehicle_db_id = v.db_id 

                                    LEFT JOIN (t_crm_customer c LEFT JOIN t_aum_pgac_region r       ON c.co_addr_region = r.psgc
                                                                LEFT JOIN t_aum_pgac_province p     ON c.co_addr_region = p.region_psgc AND c.co_addr_province = p.psgc
                                                                LEFT JOIN t_aum_pgac_municipality m ON c.co_addr_province = m.province_psgc AND c.co_addr_city = m.psgc
                                            )
                                            ON rs.customer_db_id = c.db_id

                                    LEFT JOIN t_crm_rdr rdr ON  rs.vehicle_db_id = rdr.vehicle_db_id /* this causes duplicates -> add distinct modifier */
                                    LEFT JOIN t_crm_dealer d ON rs.dealer_id = d.dealer_id
            /* */
            WHERE v.model LIKE '%TRAV%'  
                AND (c.acct_type = 'C' OR c.acct_type = 'F')";

        $query = DB::connection('crms')->select($sql);
        return $query;
    }

    public function getPulloutTraviz(){
        $sql = "SELECT hp.party_name,
                       hcaa.account_name,
                       rcta.trx_number,
                       to_char(rcta.trx_date,'MM/DD/YYYY') invoice_date,
                       rcta.attribute3 cs_number,
                       CASE WHEN REGEXP_LIKE(rcta.attribute5 , '^[0-9]{2}-\w{3}-[0-9]{2}$') THEN TO_CHAR(rcta.attribute5 ,'MM/DD/YYYY')
                             WHEN REGEXP_LIKE(rcta.attribute5 , '^[0-9]{2}-\w{3}-[0-9]{4}$') THEN TO_CHAR(rcta.attribute5 ,'MM/DD/YYYY')
                             WHEN REGEXP_LIKE(rcta.attribute5 , '^[0-9]{4}/[0-9]{2}/[0-9]{2}') THEN TO_CHAR(TO_DATE(rcta.attribute5 ,'YYYY/MM/DD HH24:MI:SS'),'MM/DD/YYYY')
                             ELSE NULL
                           END
                           AS pullout_date,
                        (CASE WHEN (MSIB.attribute8 IS NULL OR MSIB.attribute8 = 'NO COLOR') THEN NULL ELSE MSIB.attribute8 END) body_color,
                       msib.attribute9 sales_model,
                       msn.attribute2  vin,
                       msn.attribute3  engine_no,
                       msn.attribute6  key_number,
                       msn.attribute5 buyoff_date,
                       NVL(ato.location, msn.c_attribute29) location,
                       ivp.pullout_type
                FROM ra_customer_trx_all rcta
                       LEFT JOIN ipc_ar_invoices_with_cm cm
                          ON rcta.customer_trx_id = cm.orig_trx_id
                       LEFT JOIN mtl_serial_numbers msn
                          ON rcta.attribute3 = msn.serial_number
                       LEFT JOIN mtl_system_items_b msib
                          ON     msn.inventory_item_id = msib.inventory_item_id
                             AND msn.current_organization_id = msib.organization_id
                       LEFT JOIN hz_cust_accounts_all hcaa
                          ON rcta.sold_to_customer_id = hcaa.cust_account_id
                       LEFT JOIN hz_parties hp ON hcaa.party_id = hp.party_id
                       left join (SELECT cs_number,
                                   destination_to location 
                                   FROM (
                                        SELECT cs_number,
                                               destination_to,
                                               transfer_date,
                                               RANK ()  OVER (PARTITION BY cs_number ORDER BY transfer_date DESC, date_created DESC) rnk
                                          FROM ipc.ipc_vehicle_ato ato
                                         WHERE     1 = 1
                                            AND transfer_date <= sysdate)
                                   WHERE rnk = 1) ato
                        on msn.serial_number = ato.cs_number
                        left join ipc.ipc_vehicle_pullout ivp
                        on msn.serial_number = ivp.cs_number
                WHERE     1 = 1
                       AND cm.orig_trx_id IS NULL
                       AND rcta.attribute5 IS NOT NULL
                       AND rcta.cust_trx_type_id = 1002
                       AND rcta.attribute3 IS NOT NULL
                       AND msn.c_attribute30 IS NULL
                       AND  msib.attribute9 like 'TRAV%'";
        $query = DB::connection('oracle')->select($sql);
        return $query;
    }
}

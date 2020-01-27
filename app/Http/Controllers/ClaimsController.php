<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClaimHeader;
use App\Models\ClaimLines;
use Carbon\Carbon;
use DB;
class ClaimsController extends Controller
{
    
    public function index(){
        return view('claim_list');
    }

    public function store(Request $request){
        $csNo = $request->csNo;
        $parts = $request->parts;
        
         try{

            DB::beginTransaction();
            
            $claimHeader                     = new ClaimHeader;
            $claimHeader->cs_no              = $csNo;
            $claimHeader->created_by         = session('user')['user_id'];
            $claimHeader->create_user_source = session('user')['source_id'];
            $claimHeader->customer_id        = session('user')['customer_id'];
            $claimHeader->creation_date      = Carbon::now();
            $claimHeader->save();
            $claimHeaderId = $claimHeader->claim_header_id;

            foreach($parts as $part){
                if($part['checked_flag']){
                    $claimLines = new ClaimLines;
                    $claimLines->claim_header_id = $claimHeaderId;
                    $claimLines->part_id = $part['part_id'];
                    $claimLines->save();
                }
            }

            DB::commit();
        }catch(\Exception $e){
            return [
                'status' => 500,
                'message' => 'Unexpected error occured!, please contact system developer.'
            ];
            DB::rollback();
        }
        
        return [
            'status' => 200,
            'messge' => 'Your claim has been submitted.'
        ];
    }

    public function getClaims(){
        $claimHeader = new ClaimHeader;
        $data = $claimHeader->getDealerClaims(session('user')['customer_id']);    
        return $data;
    }

    public function show(Request $request){
        $claimHeader = new ClaimHeader;
        $claimLines = new ClaimLines;
        $header = $claimHeader->getDetails($request->claim_header_id);
        return $header;
    }
}

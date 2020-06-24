<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClaimHeader;
use App\Models\ClaimLines;
use Carbon\Carbon;
use App\Models\Vehicle;
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
               // if($part['checked_flag']){
                $claimLines = new ClaimLines;
                $claimLines->claim_header_id = $claimHeaderId;
                $claimLines->part_id = $part['part_id'];
                $claimLines->available_flag = $part['checked_flag'] ? 'Y' : 'N';
                $claimLines->save();
               // }
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

    public function getAllClaims(){
        $claimHeader = new ClaimHeader;       
        $data = $claimHeader->getAllClaims();
        $data = [
            'claims' => $data
        ];
        return view('admin.claims',$data);
    }

    public function show(Request $request){
        $claimHeader = new ClaimHeader;
        $claimLines = new ClaimLines;
        $header = $claimHeader->getDetails($request->claim_header_id);
        $parts = $claimLines->getParts($request->claim_header_id);

        $partsData = [];

        foreach($parts as $part){
            array_push($partsData,
            [
                'claim_line_id'  => $part->claim_line_id,
                'part_id'        => $part->part_id,
                'part_no'        => $part->part_no,
                'description'    => $part->description,
                'available_flag' => $part->available_flag == 'Y' ? true : false,
            ]);
        }

        return [
            'claimDetails' => $header,
            'parts'  => $partsData
        ];
    }

    public function getStatistics(){
        $vehicle = new  Vehicle;
        return $vehicle->getStatistics();
    }

    public function getDealerClaims(){
        $claimHeader = new ClaimHeader; 
        $vehicle = new Vehicle;      
        $data = $claimHeader->getDealerClaims(session('user')['customer_id']);
     
        $stats = $vehicle->getStatistics(session('user')['customer_id']);
        $data = [
            'claims' => $data,
            'stats' => $stats
        ];
        return view('claim_list',$data);
    }

    public function unclaimed(){
        $vehicle = new Vehicle;       
        $data = $vehicle->getAllUnclaimed(session('user')['customer_id']);
        $data = [
            'unclaimed' => $data
        ];
        return view('unclaimed',$data);
    }

    public function update(Request $request){
        $header = $request->header;
        $parts = $request->parts;

        foreach($parts as $part){
            $claimLines                     = ClaimLines::find($part['claim_line_id']);
            $claimLines->available_flag = $part['available_flag'] ? 'Y' : 'N';
            $claimLines->save();
        }
    }

    public function submit(Request $request){
        $header = $request->claim;
        $claimHeader = ClaimHeader::find($header['claim_header_id']);
        $claimHeader->status = 2;
        $claimHeader->updated_by =  session('user')['user_id'];
        $claimHeader->update_user_source = session('user')['source_id'];
        $claimHeader->update_date = Carbon::now();
        $claimHeader->save();
       
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function store(Request $request){
        $inquiry = new Inquiry;
        $inquiry->registered_owner = $request->inquiry['registered_owner'];
        $inquiry->contact_person = $request->inquiry['contact_person'];
        $inquiry->contact_number = $request->inquiry['contact_number'];
        $inquiry->email_address = $request->inquiry['email_address'];
        $inquiry->preferred_servicing_dealer = $request->inquiry['preferred_servicing_dealer'];
        $inquiry->cs_no = $request->vehicle['cs_no'];
        $inquiry->save();
        return [
            'message' => 'Inquiry for this model has been sent.',
            'status' => 'success'
        ];
    }
}

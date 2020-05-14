<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Dealer;

class ProfileController extends Controller
{
    public function index(){
     
        $credentials = User::where('user_id', session('user')['user_id'])->first();
        $user_details = UserDetail::where('user_id', session('user')['user_id'])->first();

        if(session('user')['user_type_id'] == 42){
            $dealer = Dealer::where('cust_account_id',session('user')['customer_id'])->first();
        }
        else {
            $dealer = [
                'account_name' => ''
            ];
        }

        $user = session('user');
        $data = [
            'user' => $user_details,
            'credentials' => $credentials,
            'dealer' => $dealer,
            'user_type' => session('user')['user_type_id']
        ];
        return view('profile',$data);
    }

    public function updateDetails(Request $request){
        $userDetail = UserDetail::where('user_id', session('user')['user_id'])->first();
        $userDetail->first_name = $request->user['first_name'];
        $userDetail->middle_name = $request->user['middle_name'];
        $userDetail->last_name = $request->user['last_name'];
        $userDetail->email = $request->user['email'];
        $userDetail->save();
    }

    public function updateCredentials(Request $request){
        $credentials = User::where('user_id', session('user')['user_id'])->first();
        $credentials->passcode = $request->new_password;
        $credentials->save();
    }
}

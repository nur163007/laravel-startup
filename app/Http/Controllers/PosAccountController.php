<?php

namespace App\Http\Controllers;

use App\Models\PosAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PosAccountController extends Controller
{
//    pos account data request function
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'business_name' => 'required|string|min:10|max:50',
            'business_type' => 'required|max:11',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $posdata = PosAccount::create([
            'package' => $request->package,
            'billing_cycle' => $request->billing_cycle,
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'website' => $request->website,
            'email' => $request->email,
            'state' => $request->state,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'nid' => $request->nid,
            'verification_link' =>sha1(time()),
        ]);
    }
}

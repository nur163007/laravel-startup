<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MailController;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;


class RegistrationController extends Controller
{
    public function _construct(){
        $this->middleware('auth:api',['except'=>['login','register']]);
    }

    public function showRegisterFrom(){
        return view('admin.register');
    }

    public function getTerms(){
        return view('admin.terms');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|min:3|max:70',
            'email' => 'required|string|email|max:80|unique:registrations',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->addDays(1);

        $request_type = $request->request_type;
        if ($request_type == 1){
            $user = Registration::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company' => $request->company,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'state' => $request->state,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
                'nid' => $request->nid,
                'request_type' => $request->request_type,
                'verification_link' =>sha1(time()),
                'expired_in'=>$newDateTime
            ]);
        }elseif ($request_type == 2){
            if ($request->partnerHiddenId == null){
                $user = Registration::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'company' => $request->company,
                    'company_type' => $request->company_type,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'state' => $request->state,
                    'city' => $request->city,
                    'zip_code' => $request->zip_code,
                    'country' => $request->country,
                    'nid' => $request->nid,
                    'request_type' => $request->request_type,
                    'partner_ref' => 3,
                    'verification_link' =>sha1(time()),
                    'expired_in'=>$newDateTime
                ]);
            }else{
                $user = Registration::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'company' => $request->company,
                    'company_type' => $request->company_type,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'state' => $request->state,
                    'city' => $request->city,
                    'zip_code' => $request->zip_code,
                    'country' => $request->country,
                    'nid' => $request->nid,
                    'request_type' => $request->request_type,
                    'partner_ref' => $request->partnerHiddenId,
                    'verification_link' =>sha1(time()),
                    'expired_in'=>$newDateTime
                ]);
            }

            $package = DB::insert("INSERT INTO user_packages (registration_id,package_id,billing_period,is_extended_support,support_amount,registration_amount,billing_amount)
                                        VALUES($user->id,$request->package,$request->billing_cycle,$request->is_extended_support,$request->support_amount,$request->registration_amount,$request->billing_amount);");
        }

        if ($user != null){
            MailController::sendSignupEmail($user->first_name,$user->email,$user->verification_link);
//            dd(MailController::sendSignupEmail($user->firstname,$user->email,$user->verification_link))
             return response()->json([
                'msg' =>'Registration data sent to your email, please verified',
                 'user'=>$user,
             ],200);
        }

    }

    public function verifyEmail(){
        $verifyLink = \Illuminate\Support\Facades\Request::get('code');
        $register = Registration::where(['verification_link'=>$verifyLink])->first();
        if ($register != null && $register->is_email_verified == 0){

            $expired_date = Carbon::createFromFormat('Y-m-d H:s:i', $register->expired_in);
            $todate = Carbon::createFromFormat('Y-m-d H:s:i', now());
//            $diff_in_days = $to->diffInDays($from);

            if ($todate > $expired_date){
                return response()->json('Request time is expired.');
//                return redirect('/')->with('error','Request time is expired.');
            }else{
                $register->is_email_verified = 1;
                $register->save();

                $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz@_#?';
                $password =  substr(str_shuffle($data), 0, 10);

                if ($register->request_type == 1){
                    $user = User::create([
                        'username' => $register->email,
                        'first_name' => $register->first_name,
                        'last_name' => $register->last_name,
                        'email' => $register->email,
                        'mobile' => $register->mobile,
                        'company' => $register->company,
                        'company_type' => $register->company_type,
                        'address' => $register->address,
                        'state' => $register->state,
                        'city' => $register->city,
                        'zip_code' => $register->zip_code,
                        'country' => $register->country,
                        'role' => 3,
                        'nid' => $register->nid,
                        'partner_ref' => $register->partner_ref,
                        'password' => bcrypt($password),
                        'is_email_verified' => 1,
                        'is_active' => 1,
                    ]);
                }elseif ($register->request_type == 2) {
                    $user = User::create([
                        'username' => $register->email,
                        'first_name' => $register->first_name,
                        'last_name' => $register->last_name,
                        'email' => $register->email,
                        'mobile' => $register->mobile,
                        'company' => $register->company,
                        'company_type' => $register->company_type,
                        'address' => $register->address,
                        'state' => $register->state,
                        'city' => $register->city,
                        'zip_code' => $register->zip_code,
                        'country' => $register->country,
                        'role' => 4,
                        'nid' => $register->nid,
                        'partner_ref' => $register->partner_ref,
                        'password' => bcrypt($password),
                        'is_email_verified' => 1,
                        'is_active' => 1,
                    ]);

                    $user_pac = DB::update("UPDATE user_packages SET user_id = $user->id where registration_id = $register->id;");
                }
            }


//            $password = bcrypt($user->password);
            if ($user != null){
                MailController::sendVerifyEmail($user->first_name,$user->email,$password);
                return redirect('/')->with('alert_success','Your account is active now,your username and password sent to your verified email.');
            }
        }else{
            return response()->json('Already verified your email.');
        }
    }

    public function loginForm(){
        return view('admin.login');
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'username' => 'required|string',
            'password' => 'required|string|min:5|',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        if(!$token = auth()->attempt($validator->validated())){
            return response()->json(['error' =>'unauthorized'],401);
        }

        return $this->respondWithToken($token);
    }

       protected function respondWithToken($token){
       return response()->json([
           'msg' => 'logged in successfully',
           'success' => true,
           'access_token'=>$token,
           'token_type'=>'Bearer',
           'created_at' => Date::now(),
           'expires_in'=>auth()->factory()->getTTL()*60*8,
           'user'=>auth()->user()
       ]);
   }

   public function logout(Request $request){
            // Auth::logout();
             return response()->json(['msg' =>'user logged out','success'=>true]);
//            try {
//                // Adds token to blacklist.
//                $forever = true;
//                JWTAuth::parseToken()->invalidate( $forever );
//
//                return response()->json(['msg' =>'user logged out','success'=>true]);
//            } catch ( TokenExpiredException $exception ) {
//                return response()->json( ['msg' =>'token has expired','success'=>false], 401 );
//            } catch ( TokenInvalidException $exception ) {
//                return response()->json( ['msg' =>'invalid token','success'=>false], 401 );
//
//            } catch ( JWTException $exception ) {
//                return response()->json( ['msg' =>'jwt exception','success'=>false], 500 );
//            }
   }

}

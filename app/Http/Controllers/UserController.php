<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use App\Models\Module;
use App\Models\Privilege;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Contracts\Activity;
use Carbon\Carbon;


class UserController extends Controller
{
    public function userIndex(){
        return view('admin.user.index');
    }

    public function userData(){
        $user= DB::table('users as u')
            ->join('roles as r','u.role','=','r.id')
            ->select('u.*','r.name as rolename')->get();
        return response()->json(['data'=>$user],200);
    }
    public function getRole(){
        $role = Role::where('id','!=',1)->get();
        return response()->json($role,200);
    }

   public function userStore(Request $request)
   {

       $userId = $request->hiddenUserId;

       if ($userId == 0) {
       $user = User::create([
           'username' => $request->email,
           'firstname' => $request->firstname,
           'lastname' => $request->lastname,
           'email' => $request->email,
           'mobile' => $request->mobile,
           'role' => $request->role,
           'dob' => $request->dob,
           'company' => $request->company,
           'department' => $request->department,
           'designation' => $request->designation,
           'nid' => $request->nid,
           'passport' => $request->passport,
           'password' => bcrypt($request->password),
           'emailverified' => 1,
           'address1' => $request->address1,
           'address2' => $request->address2,
           'state' => $request->state,
           'country' => $request->country,
       ]);
           $password = $request->password;
           if ($user != null){
               MailController::sendVerifyEmail($user->firstname,$user->email,$password);
               return response()->json([
                   'msg'=>'Account is active now,Username and password sent to the verified email.',
                   'success' =>true
               ],200);
           }
   }else{
        $user = User::findOrFail($userId);
        if ($user->username != $request->email){
            $user->username = $request->email;
            $user->email = $request->email;
        }
        if ($request->password != ''){
           $user->password = bcrypt($request->password);
        }
         $user->firstname = $request->firstname;
         $user->lastname = $request->lastname;
         $user->mobile = $request->mobile;
         $user->role = $request->role;
         $user->dob =  $request->dob;
         $user->company = $request->company;
         $user->department = $request->department;
         $user->designation = $request->designation;
         $user->nid = $request->nid;
         $user->passport = $request->passport;
         $user->address1 = $request->address1;
         $user->address2 = $request->address2;
         $user->state = $request->state;
         $user->country = $request->country;
         $user->update();
       }

       if ($request->password == ''){
           return response()->json([
               'msg'=>'Account is updated now.',
               'success' =>true
           ],200);
       }else {
           $password = $request->password;
           if ($user != null) {
               MailController::sendVerifyEmail($user->firstname, $user->email, $password);
               return response()->json([
                   'msg' => 'Account is updated now,Username and password sent to the verified email.',
                   'success' => true
               ], 200);
           }
       }

   }

   public function editUser($id){
       $user = User::findOrFail($id);
       return response()->json(['user'=>$user],200);
   }

   public function deleteUser($id){
       $user = User::findOrFail($id);
       $user->delete();
       return response()->json([
           'msg'=>'User deleted',
           'success'=>true
       ],200);
   }

    public function roleIndex(){
        return view('admin.user.roles');
    }

    public function roleData(){
        $role = Role::where('id','!=',1)->get();
        return response()->json(['data'=>$role],200);
    }

    public function roleStore(Request $request)
    {
        $roleId = $request->hiddenRoleId;

        if ($roleId == 0) {
            $role = Role::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            if ($role != null){
                return response()->json([
                    'msg'=>'Role data store successfully.',
                    'success' =>true
                ],200);
            }
        }else{
            $role = Role::findOrFail($roleId);
            $role->name = $request->name;
            $role->description = $request->description;
            $role->update();

            if ($role != null) {
                return response()->json([
                    'msg' => 'Role data updated successfully',
                    'success' => true
                ], 200);
            }
        }
    }
    public function editRole($id){
        $role = Role::findOrFail($id);
        return response()->json($role,200);
    }

    public function deleteRole($id){
        $role = Role::findOrFail($id);

        $user = User::WHERE('role','=',$id)->get();
        $count = $user->count();

        if ($count > 0){
            return response()->json([
                'msg'=>'This role has users,it could not be deleted!',
                'success'=>false
            ],200);
        }else{
            $delete = DB::DELETE("DELETE FROM `privileges` WHERE `roleid` = $id;");
            $role->delete();
            return response()->json([
                'msg'=>'Role deleted',
                'success'=>true
            ],200);
        }
    }

    public function getProfile(){
        return view('admin.user.profile');
    }

    public function getEditProfile(){
        return view('admin.user.edit-profile');
    }

    public function getChangePassword(Request $request){
        $id = $request->userid;
        // dd($id);
        $password = User::findOrFail($id);

        $old_pass = $password->password;

        $current_pass =$request->oldpassword;
        $new_pass = $request->newpassword;
        $confirm_pass = $request->confirmpassword;

        if(Hash::check($current_pass, $old_pass)){
//             dd("ok");
            if ($new_pass == $confirm_pass) {
                $password->password = Hash::make($new_pass);
                $password->save();

                return response()->json(['msg' =>'Password change successfully','success'=>true]);
            }
            else{
                return response()->json(['msg' =>'New password not matched','success'=>false]);
            }
        }
        else{
            return response()->json(['msg' =>'Previous password incorrect','success'=>false]);
        }
    }

    public function getChangeProfileData(Request $request){
        $id = $request->userid;
        // dd($id);
        $user = User::findOrFail($id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->company = $request->company;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zip_code = $request->zip_code;
        $user->country = $request->country;
// dd($member);

        if($user->update()){
            return response()->json(['user'=>$user,'msg' =>'Profile updated successfully','success'=>true]);
        }
        else{
            return response()->json(['msg' =>'Something Error Found !, Please try again.','success'=>false]);
        }
    }

    public function getChangeProfileImage(Request $request){
        $id = $request->userid;

        $userProfile = User::findOrFail($id);

        $date = Carbon::now()->format('his')+rand(1000,9999);

        if($image = $request->file('profile')){
            $extention = $request->file('profile')->getClientOriginalExtension();
            $imageName = $date.'.'.$extention;
            $path = public_path('assets/images/users/profile');
            $image->move($path,$imageName);

            if(file_exists('assets/images/users/profile/'.$userProfile->avatar) AND !empty($userProfile->avatar)){
                unlink('assets/images/users/profile/'.$userProfile->avatar);
            }

            $userProfile->avatar = $imageName;
        }
        else{

            $userProfile->avatar = $userProfile->avatar;
        }

        if($userProfile->update()){
            return response()->json(['userProfile'=>$userProfile,'msg' =>'Profile picture updated successfully','success'=>true]);
        }
        else{
            return response()->json(['msg' =>'Something Error Found !, Please try again.','success'=>false]);
        }
    }

    public function getChangeNID(Request $request){
        $id = $request->userid;

        $userdata = User::findOrFail($id);
        $userdata->is_completed =1;
        $userdata->update();

//        $niddata = DB::table('docs')->select('docs.*')->where('user_id',$id)->get();
        $niddata = DB::select("SELECT * from docs where user_id = $id and doc_type ='3'");

        //FRONT PART OF NID UPLOAD
        if (!empty($niddata)) {
            foreach ($niddata as $val) {
            if ($val->user_id == $id && $val->doc_title != null && $val->doc_title == 'NID FRONT PART') {
                $date1 = Carbon::now()->format('his') + rand(1000, 9999);
                if ($front = $request->file('front_part')) {
                    $extention = $request->file('front_part')->getClientOriginalExtension();
                    $imageName = $date1 . '.' . $extention;
                    $path = public_path('documents/nid/front');
                    $front->move($path, $imageName);

                    if (file_exists('documents/nid/front/' . $val->doc_path) and !empty($val->doc_path)) {
                        unlink('documents/nid/front/' . $val->doc_path);
                    }

                    $nid = DB::update("UPDATE `docs` SET `doc_path`='$imageName' WHERE user_id = $id and doc_type=3 and doc_title ='NID FRONT PART';");
                }
            } elseif ($val->user_id == $id && $val->doc_title != null && $val->doc_title == 'NID BACK PART') {
                // BACK PART OF NID UPLOAD
                $date2 = Carbon::now()->format('his') + rand(1000, 9999);
                if ($back = $request->file('back_part')) {
                    $extention = $request->file('back_part')->getClientOriginalExtension();
                    $imageName = $date2 . '.' . $extention;
                    $path = public_path('documents/nid/back');
                    $back->move($path, $imageName);

                    if (file_exists('documents/nid/back/' . $val->doc_path) and !empty($val->doc_path)) {
                        unlink('documents/nid/back/' . $val->doc_path);
                    }

                    $nid = DB::update("UPDATE `docs` SET `doc_path`='$imageName' WHERE user_id = $id and doc_type=3 and doc_title ='NID BACK PART';");
                }
                $user_update =DB::update("UPDATE users SET registration_status = 2 where id=$id;");
                if ($nid) {
                    return response()->json(['niddata' => $nid, 'msg' => 'NID updated successfully', 'success' => true]);
                } else {
                    return response()->json(['msg' => 'Something Error Found !, Please try again.', 'success' => false]);
                }
            }
        }
        }else{


            $date1 = Carbon::now()->format('his')+rand(1000,9999);
            $date2 = Carbon::now()->format('his')+rand(1000,9999);

            if($front = $request->file('front_part')){
                $extention = $request->file('front_part')->getClientOriginalExtension();
                $frontimageName = $date1.'.'.$extention;
                $path = public_path('documents/nid/front');
                $front->move($path,$frontimageName);

                $nid = DB::insert("insert into `docs` (`user_id`, `doc_type`, `doc_title`, `doc_path`,`is_uploaded`) values ($id, 3, 'NID FRONT PART', '$frontimageName',1);");
            }
            if($back = $request->file('back_part')){
                $extention = $request->file('back_part')->getClientOriginalExtension();
                $backimageName = $date2.'.'.$extention;
                $path = public_path('documents/nid/back');
                $back->move($path,$backimageName);

                $nid = DB::insert("insert into `docs` (`user_id`, `doc_type`, `doc_title`, `doc_path`,`is_uploaded`) values ($id, 3, 'NID BACK PART', '$backimageName',1);");
            }

            $user_update =DB::update("UPDATE users SET registration_status = 2 where id=$id;");

            if ($nid){
                return response()->json(['niddata'=>$nid,'msg' =>'NID Store successfully','success'=>true]);
            }else{
                return response()->json(['msg' =>'Something Error Found !, Please try again.','success'=>false]);
            }
        }

    }

    public function getNIDdata($id){
        $niddata = DB::select("SELECT * from docs where user_id = $id;");
        if ($niddata){
            return response()->json(['data'=>$niddata,'success'=>true]);
        }
    }


}

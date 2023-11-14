<?php

namespace App\Http\Controllers;

use App\Mail\SignupEmail;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class MailController extends Controller
{
    public static function sendSignupEmail($name, $email,$verification_link){
        $data =[
            'first_name'=>$name,
            'verification_link'=>$verification_link,
            'base_url'=>Config::get('app.url')
        ];
        Mail::to($email)->send(new SignupEmail($data));
    }

    public static function sendVerifyEmail($name, $email,$password){
        $data =[
            'first_name'=>$name,
            'password'=>$password,
            'username'=>$email
        ];
        Mail::to($email)->send(new VerifyEmail($data));
    }
}

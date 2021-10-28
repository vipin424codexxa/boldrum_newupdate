<?php

namespace App\Http\Controllers\AUth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupEmail;
use App\Mail\ForgotEmail;
class MailController1 extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    //
    public static function SendSignupEmail($first_name, $email, $verification_code){
        $data=[
            'name'=>$first_name,
            'email'=>$email,
            'verification_code'=>$verification_code,
        ];
        Mail::to($email)->queue(new SignupEmail($data));
    }
    public static function SendSForgotPassword($user){
       
        Mail::to($user->email)->queue(new ForgotEmail($user));
    }
   
}

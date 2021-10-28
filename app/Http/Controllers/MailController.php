<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupEmail;
use App\Mail\InviteEmail;
class MailController extends Controller
{
    //
    public static function SendSignupEmail($first_name, $email, $verification_code){
        $data=[
            'name'=>$first_name,
            'email'=>$email,
            'verification_code'=>$verification_code,
        ];
        Mail::to($email)->queue(new SignupEmail($data));
    }
    public static function SendInviteEmail($data){
        Mail::to($data->email)->queue(new InviteEmail($data));
    }
}

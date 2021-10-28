<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin\ClubAdmin;
class AuthController extends Controller
{
    //
 
    function get_login(){
        return view('Admin.Auth.login');
    }
    function forgotpassword(){
        return view('Admin.Auth.forgotpassword');
    }
    
     public function profile_edit(){
        $sessionId=Auth()->user()->id;
        $profiles=User::where('id',$sessionId)->get();
        return view('Admin.Auth.profile',compact('profiles'));
    }

public function profile_update(Request $request){
    $request->validate([
        'name' => 'required',
        'club_name' => 'required'
    ]);
    $sessionId=Auth()->user()->id;
    $profiles=User::where('id',$sessionId)->first();
    $profiles->update($request->all());

    return redirect('/profile')
        ->with('success', 'Profile updated successfully');
}
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if(!Auth::user()->is_verified){
                Session::flush();
                Auth::logout();
                return redirect("login")->withError('You are not verify user Once verify and after then login');
            }
            return redirect()->intended('index')
                        ->withSuccess('Signed in');
        }  
        return redirect("login")->withError('Incorrect email and password');
    }

public function registration()
{
    return view('Admin.Auth.register');
}

public function postRegistration(Request $request)
{  
    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:users',
        'club_name' => 'required',
        'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'min:6'
    ]);
    $user=new User;
    $user->name=$request->first_name.' '.$request->last_name;
    $user->email=$request->email;
    $user->password=Hash::make($request->password);
    $user->view_password=$request->password;
    $user->verification_code=sha1(time());
    $user->type=2;
    $user->club_name=$request->club_name;
    $user->save();
    
    if($user !=null){
        MailController1::SendSignupEmail($user->name,$user->email,$user->verification_code);
        return redirect()->back()->with('success','your account has been created and please check your email verification link.');
    }
    return redirect()->back()->with('error','something went wrong!!');
}

public function postforgotpassword(Request $request)
{  
    $request->validate([
         'email' => 'required|email',
      ]);
    $user= User::where('email',$request->email)->first(); 
    if($user){
        MailController1::SendSForgotPassword($user);
        return redirect()->back()->with('success','Forgot password send in your email please check');
    }
    return redirect()->back()->with('error','something went wrong!!');
}


public function postforgot_api(Request $request)
{  
    $request->validate([
         'email' => 'required|email',
      ]);
    $user= User::where('email',$request->email)->first(); 
    if($user){
        MailController1::SendSForgotPassword($user);
        return response()->json(['success','Forgot password send in your email please check']);
    }
    return  response()->json(['error','something went wrong!!']);
}



    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
    
public function verify($vcode){
    $users=User::where('verification_code',$vcode)->first();
    $users->is_verified = 1;
    $users->user_status = 1;
    $users->save();    
    return redirect("login")->withSuccess('Your account successfully verify. Please login now');

}
public function change_password(){
    return view('Admin.Auth.changepass');
}
function get_password(Request $request){
   $sessionId=Auth()->user()->id;
    $input = $request->all();
    $userid = User::where('id',$sessionId)->first();
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    ]);
        try {
            if ((Hash::check(request('old_password'), $userid->password)) == false) {
                return redirect()->back()->with('error','Check your old password.');
            } else if ((Hash::check(request('new_password'),$userid->password)) == true) {
                return redirect()->back()->with('error','Please enter a password which is not similar then current password.');
            } else {
                $user = User::find($sessionId);
                $user->password = Hash::make($request->new_password);
                $user->view_password=$request->new_password;
                $user->save();
                return redirect()->back()->with('success','Password updated successfully.');
            }
        } catch (\Exception $ex) {
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            } else {
                $msg = $ex->getMessage();
            }
            return redirect()->back()->with('success','Password updated successfully.');
    
    }

}


}

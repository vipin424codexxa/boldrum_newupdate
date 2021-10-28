<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Admin\Club;
use App\Models\Admin\Role;
use App\Models\Admin\Ballroom;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }

    public function index() {
        $sessionid=Auth()->user()->id;
        $data = User::join('clubs', 'clubs.id', '=', 'users.club_id')
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->select('users.*','clubs.club_name','roles.role_name');
        if(Auth()->user()->type == 2){
            $data=$data->where('users.user_id',$sessionid);
        }
        if(Auth()->user()->type == 1){
            $data=$data->where('users.type','!=',Auth()->user()->type)->get();
        }else{
            $data=$data->where('users.type',3)->get();
        }
        return view('Admin.user',['items'=>$data]);
     }
     public function create() {
        $sessionid=Auth()->user()->id;
        $users=club::where('user_id', $sessionid)->get();
        $roles=Role::all();
        $balls=Ballroom::where('user_id', $sessionid)->get();
        return view('Admin.adduser',compact('users','roles','balls'));
     }
     public function store(Request $request) {
        $users = User::where('email', '=', $request->input('email'))->first();
            if ($users === null) {
            $request->validate([
                'club_id'=>'required',
                'role_id'=>'required',
                'name'=>'required',
                'email'=>'required|email|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
                'password'=>'required|min:6',
                'creation_date'=>'required|date',
                'profile_picture'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            $upcomingImage = '';
            if($request->profile_picture){
            $upcomingImage = date('YmdHis') . "." . $request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('upload'),$upcomingImage);

            $news = $request->input('ball_id');
            $news = implode(',', $news); 

            $data= new User;
            $data->club_id=$request->club_id;
            $data->role_id=$request->role_id;
            $data['ball_id'] = $news;
            $data->name=$request->name;
            $data->email=$request->email;
            $data->password=Hash::make($request->password);
            $data->view_password=$request->password;
            $data->creation_date=$request->creation_date;
            $data->profile_picture=$upcomingImage;
            $data->user_status="1";
            $data->user_id=Auth()->user()->id;
            $data->save();
            return redirect('/users')->with('success','User has been added!!');
        }
            }else{
                return redirect()->back()->with('error','User Already Exist!!');
            }
     }
   
     public function destroy($id) {
        $data=User::find($id);
        $data->delete();
        return redirect()->back()->with('success','Your User has been Deleted!!');
     }
     
    public function edit($id) {
        $sessionid=Auth()->user()->id;
        $users=club::where('user_id', $sessionid)->get();
        $roles=Role::all();
        $balls=Ballroom::where('user_id', $sessionid)->get();
        $data=User::find($id);
        return view('Admin.edituser',compact('data','users','roles','balls'));
     }
     
     
     public function inviteUser($id) {
        $data=User::find($id);         
        MailController::SendInviteEmail($data);
        return redirect()->back()->with('success','User invite successfully');
     }
     
     public function update(Request $request)
     {

         $data = User::findOrFail($request->id);
            $request->validate([
                'club_id'=>'required',
                'role_id'=>'required',
                'name'=>'required',
                'email'=>'required',
                'password'=>'required|min:6',
                'creation_date'=>'required|date',
                'profile_picture'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            $upcomingImage = '';
            if($request->profile_picture){
            $upcomingImage = date('YmdHis') . "." . $request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('upload'),$upcomingImage);

            $news = $request->input('ball_id');
            $news = implode(',', $news); 

            $data->club_id=$request->club_id;
            $data->role_id=$request->role_id;
            $data['ball_id'] = $news;
            $data->name=$request->name;
            $data->email=$request->email;
            $data->password=Hash::make($request->password);
            $data->view_password=$request->password;
            $data->creation_date=$request->creation_date;
            $data->profile_picture=$upcomingImage;
            $data->user_status="1";
            $data->user_id=Auth()->user()->id;
            $data->save();
   return redirect('/users')->with('success','User has been Updated!!');
    }
}
     
     
     
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Club;
use App\Models\Admin\Role;
use App\Models\Admin\Ballroom;
use App\Models\Admin\Material;
use App\Models\Admin\Club_Material;
use App\Models\Admin\Team;
use App\Models\Admin\Year;
use App\Models\User;
use Auth;
use Session;
class AdminController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');

    }

    function get_clubs(){
        $session_id = Auth()->user()->id;
        $data=club::where('user_id',$session_id)->get();
        return view('Admin.clubs',['items'=>$data]);
    }
    function add_clubs(){
        return view('Admin.addclub');
    }
    function Insert_clubs(Request $request){
        // dd($request->all());
        $request->validate([
            'club_name'=>'required',
            'phone'=>'required|max:10',
            'address1'=>'required',
            'address2'=>'required',
            'city'=>'required',
            'zipcode'=>'required|max:6',
            'website'=>'required',
            'cvr'=>'required|max:8',
            'logo'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $upcomingImage = '';
        if($request->logo){
        $upcomingImage = date('YmdHis') . "." . $request->logo->getClientOriginalExtension();
        $request->logo->move(public_path('upload'),$upcomingImage);

        $data= new club;
        $data->club_name=$request->club_name;
        $data->phone=$request->phone;
        $data->address1=$request->address1;
        $data->address2=$request->address2;
        $data->city=$request->city;
        $data->zipcode=$request->zipcode;
        $data->website=$request->website;
        $data->cvr=$request->cvr;
        $data->user_id=Auth()->user()->id;
        $data->logo=$upcomingImage;
        $data->save();
        return redirect('/clubs')->with('success','Your club has been added!!');
    }
}
function Deleteclub($id){
    $data=club::find($id);
    $data->delete();
    return redirect()->back()->with('success','Your Club has been Deleted!!');
}

function get_roles(){
    $data=Role::all();
    return view('Admin.roles',['items'=>$data]);
}

function Insert_roles(Request $request){
    $request->validate([
        'role_name'=>'required',
    ]);
    // dd($req->all());
    $data= new Role;
    $data->role_name=$request->role_name;
    $data->user_id=Auth()->user()->id;
    $data->save();

    return redirect('/roles');
}

function get_ballrooms(){
    $sessionId=Auth()->user()->id;
    $data=Ballroom::where('user_id',$sessionId)->get();
    return view('Admin.ballrooms',['items'=>$data]);
}

function add_ballroom(){
    $sessionId=Auth()->user()->id;
    $teams=Team::where('user_id', $sessionId)->get();
    $years=Year::where('user_id', $sessionId)->get();
    $items=Ballroom::where('user_id',$sessionId)->get();
    return view('Admin.addballroom',compact('teams','years','items'));
}
function Insert_ballroom(Request $req){
   
    $data= new Ballroom;
    $data->name=$req->name;
    $data->owner=$req->owner;
    $data->creation_date=$req->creation_date;
    $data->user_id=Auth()->user()->id;
    $data->team_name=$req->team_name;
    $data->year=$req->year;
    $data->save();
    return redirect('/ballrooms')->with('success','Ballroom has been added!!');
}
function Deleteballroom($id){
    $data=Ballroom::find($id);
    $data->delete();
    return redirect()->back()->with('success','Ballroom has been Deleted!!');
}
function get_material(){
    $session_id = Auth()->user()->id;
    $data=Material::where('user_id',$session_id)->get();
    return view('Admin.materials',['materials'=>$data]);
}

function add_material(){
    return view('Admin.addmaterial');
}
function Insert_material(Request $req){
    $req->validate([
        'mat_name'=>'required',
        'price'=>'required',
        'supplier'=>'required',
        'mat_image'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'icon'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);
    $materialImage = '';
    if($req->mat_image){
    $materialImage = date('YmdHis') . "." . $req->mat_image->getClientOriginalExtension();
    $req->mat_image->move(public_path('upload'),$materialImage);

    $materialIcon = '';
    if($req->icon){
    $materialIcon = date('Ymd') . "." . $req->icon->getClientOriginalExtension();
    $req->icon->move(public_path('upload'),$materialIcon);

    $data= new Material;
    $data->mat_name=$req->mat_name;
    $data->price=$req->price;
    $data->supplier=$req->supplier;
    $data->mat_image=$materialImage;
    $data->icon=$materialIcon;
    $data->user_id=Auth()->user()->id;
    $data->save();
    return redirect('/materials')->with('success','Material has been added!!');
    }
    }
}


function club_material(){
    $sessionId=Auth()->user()->id;
    $data=DB::table('club_materials')
    ->join('clubs', 'clubs.id','=','club_materials.club_id')
    ->join('ballrooms', 'ballrooms.id','=','club_materials.ballroom_id')
    ->where('club_materials.user_id',$sessionId)
    ->get();
    
    $dval = [];
    foreach($data as $k=>$item)
    {
    $dname = [];
    $dval[$k] = $item;
        foreach(explode(",",$item->material_id) as $n)
        {
            $dname1= Material::where('id',$n)->first();
            $dname[]=$dname1->mat_name;
        }
        $dval[$k]->material_id=implode(",",$dname);
     }
    return view('Admin.clubmaterial',['materials'=>$dval]);
}
 function get_cmaterial(){
    $sessionId=Auth()->user()->id;
    $clubs=club::where('user_id',$sessionId)->get();
    $mats=Material::where('user_id',$sessionId)->get();
    $ball=Ballroom::where('user_id',$sessionId)->get();
     return view('Admin.addcmaterial',compact('clubs','mats','ball'));
 }
 function Insert_cmaterial(Request $req){
    $req->validate([
        'club_id'=>'required',
        'material_id'=>'required',
    ]);
    $material = $req->input('material_id');
    $material = implode(',', $material); 

    $data= new Club_Material;
    $data->club_id=$req->club_id;
    $data['material_id'] = $material;
    $data->ballroom_id=$req->ballroom_id;
    $data->user_id=Auth()->user()->id; 
    $data->save();
     return redirect('/club-material')->with('success','Add Club Material has been Successfully');
 }
 function DeleteMaterial($id){
    $data=Material::find($id);
    $data->delete();
    return redirect()->back()->with('success','Material has been Deleted!!');
}

function get_team(){
    $sessionId=Auth()->user()->id;
    $teams=Team::where('user_id',$sessionId)->get();
    $years=Year::where('user_id',$sessionId)->get();
    return view('Admin.team.team',['somes'=>$teams,'years'=>$years]);
}
public function add_team(Request $req){
    $req->validate([
        'team_name'=>'required',
        'year'=>'required',
    ]);
    $teams=new Team;
    $teams->team_name=$req->team_name;
    $teams->year=$req->year;
    $teams->user_id=Auth()->user()->id;
    $teams->save();
    return redirect('/team')->with('success','Team has been Added!!');

}
public function add_year(Request $req){
    $req->validate([
        'year_name'=>'required',
    ]);
    $teams=new Year;
    $teams->year_name=$req->year_name;
    $teams->user_id=Auth()->user()->id;
    $teams->save();
    return redirect('/year')->with('success','Year has been Added!!');

}

function get_year(){
    $sessionId=Auth()->user()->id;
    $year=Year::where('user_id',$sessionId)->get();
    return view('Admin.year.year',['somes'=>$year]);
}


public function Deleteteam($id){
     $data=Team::find($id);
    $data->delete();
    return redirect()->back()->with('success','Team has been Deleted!!'); 
}

}

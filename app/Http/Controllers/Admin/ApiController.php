<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Admin\Role;
use App\Models\Admin\Order;
use App\Models\Admin\Material;
use App\Models\Admin\User_role;
use App\Models\Admin\Ballroom;
use App\Models\Admin\Ballroom_item;
use App\Models\Admin\Order_detail;
use App\Models\User;
use Carbon\Carbon;

class ApiController extends Controller
{
    
 // homeapi List api Controller---
    function get_roles(){
  $roles_data=Role::all();
    return response()->json([
        'Msg'=>'Success',
        'Count'=>1,
        'Roles_list'=>$roles_data,
    ]);
}
// user login api
function Userlogin(Request $request){
    $user=User::where('email',$request->email)->first();
    if(!$user ||!Hash::check($request->password,$user->password)){
        return response()->json([
            'msg'=>'Incorrect Email or Password!!',
            'Count'=>0,
        ]);
    }else{
        $data=DB::table('roles')
        ->join('users', 'users.role_id','=','roles.id')
        ->select('roles.role_name')    
        ->where('role_id',$user->role_id)->value('role_name');
        return response()->json([
            'msg'=>'Success',
            'Count'=>1,
             "Userid"=>$user->id,
             "Rolename"=>$data,
             "Username"=>$user->name,
            ]);
    }
  
}
function get_password(Request $request){
    $input = $request->all();
    $userid = User::where('id',$request->id)->first();;
    $rules = array(
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    );
    $validator = Validator::make($input, $rules);
    if ($validator->fails()) {
        $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
    } else {
        try {
            if ((Hash::check(request('old_password'), $userid->password)) == false) {
                $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
            } else if ((Hash::check(request('new_password'),$userid->password)) == true) {
                $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
            } else {
                $user = User::find($request->id);
                $user->password = Hash::make($request->new_password);
                $user->view_password =$request->new_password;
                $user->save();
                $arr = array("status" => 200, "message" => "Password updated successfully.");
            }
        } catch (\Exception $ex) {
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            } else {
                $msg = $ex->getMessage();
            }
            $arr = array("status" => 400, "message" => $msg, "data" => array());
        }
    }
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Update_password"=>$arr,
        ]);
}
function homePage(Request $request){
    $userId=User::where('id',$request->id)->value('club_id');
    $userId1=User::where('id',$request->id)->value('id');
    $data=DB::table('users')
    ->select('users.ball_id')
    ->where(['club_id'=>$userId,'id'=>$userId1])->value('name');
    $string = $data;
    $integerIDs = array_map('intval', explode(',', $string));
     $items = Ballroom::whereIn('id',$integerIDs)->get();
    $allmatrial = Material::get();
    $array = json_decode(json_encode($items), true);
    //  $mdata = [];
    // foreach($allmatrial as $k=>$v){
    //     $mdata[$k]=$v;
    //     $mdata[$k]['count']=Order::where('material_id',$v->id)->count();
    // }
    $count = count($array) ;
    for($i=0;$i<$count;$i++) {
        $id =$array[$i]['id'];

       $p = $this->getPendingRequest($id,$userId);
       $c = $this->getCancelRequest($id,$userId);
       $d = $this->getSuccessRequest($id,$userId);
       $e = $this->getCompleteRequest($id,$userId);
       $materials = $this->getMaterials($id,$userId);
        $array[$i]['Pending_orders']=$p;
        $array[$i]['Cancel_orders']=$c;
        $array[$i]['Progress_orders']=$d;
        $array[$i]['Approved_orders']=$e;
        $array[$i]['Material_stock']=$materials;
    }
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "dashboard_page"=>$array
        ]);
}

function getPendingRequest($id,$userId){
    $query=Order::where([
        ['ballroom_id', '=', $id],
        ['club_id', '=',$userId],
        ['status','=','pending'],

    ])->count();
    return $query;
}

function getCancelRequest($id,$userId){
    $query=Order::where([
        ['ballroom_id', '=', $id],
        ['club_id', '=',$userId],
        ['status','=','cancelled'],

    ])->count();
    return $query;
}

function getSuccessRequest($id,$userId){
    $query=Order::where([
        ['ballroom_id', '=', $id],
        ['club_id', '=',$userId],
        ['status','=','progress'],

    ])->count();
    return $query;
}

function getCompleteRequest($id,$userId){
    $query=Order::where([
        ['ballroom_id', '=', $id],
        ['club_id', '=',$userId],
        ['status','=','approved'],

    ])->count();
    return $query;
}

function getMaterials($id,$userId){
    $products = Order::where([
        ['ballroom_id', '=', $id],
        ['orders.club_id', '=',$userId],
        ['status','=','success']])
   ->groupBy('material_id','mat_name','icon')
   ->join('materials', 'materials.id', '=', 'orders.material_id')
   ->select([
       'orders.material_id',
       'materials.mat_name',
       'materials.icon as mat_icon',
       DB::raw('sum(orders.quantity) AS quantity'),
   ])

    ->get();
    return $products;
}


// searchMaterialApi
function searchMaterialApi($request){
    $categories= DB::table('orders')
    ->join('materials', 'materials.id','=','orders.material_id')
    ->join('users', 'users.id','=','orders.user_id')
    ->join('ballrooms', 'ballrooms.id','=','orders.ballroom_id')
    ->select('orders.id','orders.creation_date','orders.quantity','orders.status','orders.message','users.name as user_name','ballrooms.name as ballroom_name','materials.mat_name as material_name','materials.mat_image',
    'materials.icon as material_icon','materials.supplier','materials.price')
    ->where("materials.mat_name",'like','%' .$request. '%')
    ->orwhere("users.name" ,'like','%' .$request. '%')
    ->get();
    return response()->json([
        'Msg'=>"success",
        'Count'=>1,
       'Search_result'=>$categories,
   ]);
   
}

// shorting order
public function shortOrders(Request $request){
$sortParams = "";
$sortOrder = "";
$nameReq =  $request->name;
$dateReq = $request->date;
$qtyReq = $request->quantity;
if($nameReq != 0) {
$sortParams =  "materials.mat_name";
$sortOrder =  $nameReq == 1 ? "desc" : "asc";
}
if($dateReq != 0) {
$sortParams =  "orders.creation_date";
$sortOrder =  $dateReq == 1 ? "desc" : "asc";
}
if($qtyReq != 0) {
$sortParams =  "orders.quantity";
$sortOrder =  $nameReq == 1 ? "desc" : "asc";
}
$currentStatus=Order::join('materials', 'materials.id','=','orders.material_id')
->join('users', 'users.id','=','orders.user_id')
->join('ballrooms', 'ballrooms.id','=','orders.ballroom_id')
->select('orders.id','orders.creation_date','orders.approved_date','orders.rejected_date','orders.rejected_message','orders.quantity','orders.status','orders.message','users.name as user_name','ballrooms.name as ballroom_name','materials.mat_name as material_name','materials.mat_image',
'materials.icon as material_icon','materials.supplier','materials.price')
->where('orders.user_id',$request->user_id)
->where(['orders.status'=>'pending'])
->orWhere(['orders.status'=>'progress'])
->orderBy($sortParams,$sortOrder)->get();
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Short_order"=>$currentStatus
        ]);
}

function get_currentStatus(Request $req){
 $currentStatus=Order::join('materials', 'materials.id','=','orders.material_id')
 ->join('users', 'users.id','=','orders.user_id')
 ->join('ballrooms', 'ballrooms.id','=','orders.ballroom_id')
 ->select('orders.id','orders.creation_date','orders.approved_date','orders.rejected_date','orders.rejected_message','orders.quantity','orders.status','orders.message','users.name as user_name','ballrooms.name as ballroom_name','materials.mat_name as material_name','materials.mat_image',
 'materials.icon as material_icon','materials.supplier','materials.price')
 ->where('orders.board_id',$req->board_id)
 ->orderBy('creation_date','desc')->get();
 return response()->json([
    'msg'=>'Success',
    'Count'=>1,
    "Order_Status"=>$currentStatus
    ]);
}

function get_awaiting(Request $request){
    $getwait=User::join('clubs','clubs.id','=','users.club_id')
    ->join('roles','roles.id','=','users.role_id')
    ->select('users.id')
    ->where('club_id',$request->club_id)->get();
    $stringch = $getwait;
    $array = json_decode(json_encode($stringch), true);
    $idValue=[]; 
    $count = count($array) ;
    for($i=0;$i<$count;$i++) {
    $idValue[$i] =$array[$i]['id']; }
    $items = DB::table('orders')->whereIn('user_id',$idValue)->get();
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Order_Status"=>$items
        ]);
}
function club_material(Request $req){
    $data=DB::table('club_materials')
    ->join('clubs', 'clubs.id','=','club_materials.club_id')
    ->select('club_materials.material_id','club_materials.club_id')
    ->where('club_materials.ballroom_id',$req->id)->get();
    $array = json_decode(json_encode($data), true);
    
    
    $count = count($array) ;
    
    $iid=[];
    for($i=0;$i<$count;$i++) {
        $id =$array[$i]['material_id'];
        
       // print_r($i);
    $string = $data;
    $integerID = array_map('intval', explode(',', $id));
  $items=DB::table('materials')->whereIn('id',$integerID)->get();  
  
  foreach($items as $d){
    array_push($iid,$d);
    //print_r($d);
}
    }




    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Material_list"=>$iid
        ]);
}


function orders(Request $req){
    $userGet=User::where('id',$req->user_id)->value('club_id');
    $clubGet=User::where('id',$req->user_id)->value('user_id');
    $userData=new Order;
    $userData->user_id=$req->user_id;
    $userData->creation_date=$req->creation_date;
    $userData->status="pending";
    $userData->message=$req->message;
    $userData->ballroom_id=$req->ballroom_id;
    $userData->material_id=$req->material_id;
    $userData->quantity=$req->quantity;
    $userData->club_id=$userGet;
    $userData->club_owner_id=$clubGet;
    $userData->save();
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Orders"=>$userData
        ]);
}



function boardmember_approved(Request $req){
    $orders = Order::where(['id' => $req->id])->value('quantity');
    $userId = User::where(['id' => $req->board_id])->value('id');
    $status = Order::where(['id' => $req->id])->value('status');
    $newTask = Order::where('id',$req->id)->get();
    $common;
    if($status!="success"){
    $new = Order::find($req->id);
    $new->status=$req->status;
    $new->approved_date=Carbon::now();
    $new->rejected_date=$req->rejected_date;
    $new->rejected_message=$req->rejected_message;
    $new->board_id=$userId;
    $new->save();
    }else{
         return response()->json([
        'msg'=>'false',
        'count'=>1,
        'status'=>"Already approved!!"
        ]);
    }
//    echo $common;
    return response()->json([
        'msg'=>'Success',
        'count'=>1,
        'Approved_order'=>$new,
        ]);
}


// trainer approved order
public function trainer_approved(Request $req){
      $orders = Order::where(['id' => $req->id])->value('quantity');
    $userId = User::where(['id' => $req->user_id])->value('id');
    $status = Order::where(['id' => $req->id])->value('status');
    $newTask = Order::where('id',$req->id)->get();
    $common;
    if($status!="success"){
    $new = Order::where('id',$req->id)->first();
    $new->status=$req->status;
    $new->approved_date=Carbon::now();
    $new->rejected_date=$req->rejected_date;
    $new->rejected_message=$req->rejected_message;
    $new->save();
//         foreach($newTask as $data){
//             $common = Order_detail::where(['material_id' => $data->material_id, 
//             'ballroom_id' => $data->ballroom_id])->first();
//             if($common){
//                 $q=Order_detail::where(['quantity' =>$common->quantity])->value('quantity');
//                 $common->material_id=$data->material_id;
//                 $common->ballroom_id=$data->ballroom_id;
//                 $common->quantity=$q+$orders;
//                 $common->save();
//             }else{
//       DB::table('order_details')->insert([
//             'material_id' =>$data->material_id,
//             'quantity' => $data->quantity,
//             'ballroom_id' => $data->ballroom_id, 
//             'status'=>$req->status,
//             'user_id'=>$data->user_id,
//             'message'=>$data->message,
//             'creation_date'=>$data->creation_date,
//       ]);
//         $common = Order_detail::where(['material_id' => $data->material_id, 
//         'ballroom_id' => $data->ballroom_id])->get();  
//     }

// }
    }else{
         return response()->json([
        'msg'=>'false',
        'count'=>1,
        'status'=>"Already approved!!"
        ]);
    }
//    echo $common;
    return response()->json([
        'msg'=>'Success',
        'count'=>1,
        'Approved_order'=>$new,
        ]);
  
    
}

function order_progress(Request $req){
    $orders = Order::where(['id' => $req->id])->value('quantity');
    $userId = User::where(['id' => $req->board_id])->value('id');
    $status = Order::where(['id' => $req->id])->value('status');
    $newTask = Order::where('id',$req->id)->get();
    $common;
    if($status!="progress"){
    $new = Order::find($req->id);
    $new->status="progress";
    $new->approved_date=Carbon::now();
    $new->rejected_date=$req->rejected_date;
    $new->rejected_message=$req->rejected_message;
    $new->board_id=$userId;
    $new->save();

    }else{
         return response()->json([
        'msg'=>'false',
        'count'=>1,
        'status'=>"Already Progress!!"
        ]);
    }
//    echo $common;
    return response()->json([
        'msg'=>'Success',
        'count'=>1,
        'Progress_order'=>$new,
        ]);
}

function get_Log(Request $request){
    $orderLog=Order::join('materials', 'materials.id','=','orders.material_id')
         ->join('ballrooms', 'ballrooms.id','=','orders.ballroom_id')
         ->join('users', 'users.id','=','orders.user_id')
         ->select('orders.id','users.name as username','orders.creation_date','orders.status','orders.message','ballrooms.name','materials.mat_name','materials.icon as mat_icon','orders.quantity','orders.approved_date','orders.rejected_date','orders.rejected_message','orders.board_id')
        ->where('orders.board_id',$request->board_id)->get();
    return response()->json([
        'msg'=>'Success',
        'count'=>1,
        'Order_Log'=>$orderLog,
        ]);
}

function ballroom_details(Request $request){
    $userId=User::where('id',$request->user_id)->value('id');
    //dd($userId);
        $data = Order::where([
        ['orders.ballroom_id', '=', $request->ballroom_id],
        ['orders.user_id','=',$userId],
         ['status','=','success']])
  ->groupBy('material_id','mat_name','icon','mat_image')
  ->join('materials', 'materials.id', '=', 'orders.material_id')
  ->select([
      'orders.material_id',
      'materials.mat_name',
      'materials.icon as mat_icon',
      'mat_image',
      DB::raw('sum(orders.quantity) AS quantity'),
  ])->get();

    $dat=DB::table('orders')
    ->join('materials', 'materials.id','=','orders.material_id')
    ->select(
    'materials.id','materials.mat_name','materials.mat_image',
    'materials.icon','orders.quantity')
    ->where('orders.user_id',$userId)
    ->where('orders.ballroom_id',$request->ballroom_id)
    ->where('status','pending')
    ->get();
    if($request->status='success'){
        $data;
    }else{
        $dat;
    }
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Available_stock"=>$data,
        'Pending_stock'=>$dat
        ]);
}

public function edit_material_stock(Request $request){
    $user = Order::find($request->material_id);
    $user = Order::where('material_id',$request->material_id)
    ->where('orders.user_id',$request->user_id)
    ->where('orders.ballroom_id',$request->ballroom_id)
    ->where('status','success')
    ->first();
    $user->quantity = $request->quantity;
        if($user->save())
    {
    $data=DB::table('orders')
    ->join('materials', 'materials.id','=','orders.material_id')
    ->select('materials.mat_name','materials.mat_image','materials.icon','orders.quantity')
    ->where('orders.user_id',$request->user_id)
    ->where('orders.ballroom_id',$request->ballroom_id)
    ->where('orders.material_id',$request->material_id)
    ->where('orders.status','success')
    ->get();
    }
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Update_StockList"=>$data
        ]);
//}
// return response()->json([
//     'msg'=>'Something went wrong',
//     'Count'=>0,
//     ]);
}
function approve_List(Request $request){
    $userId=User::where('id',$request->user_id)->value('club_id');
   // dd($userId);
    $getorder=DB::table('orders')
    ->join('materials', 'materials.id','=','orders.material_id')
    ->join('users', 'users.id','=','orders.user_id')
    ->join('ballrooms', 'ballrooms.id','=','orders.ballroom_id')
    ->select('orders.id','orders.creation_date','orders.quantity','orders.status','orders.message','users.name as user_name','ballrooms.name as ballroom_name','materials.mat_name as material_name','materials.mat_image',
    'materials.icon as material_icon','materials.supplier','materials.price')
    ->where(['orders.club_id'=>$userId])
    ->where(['orders.status'=>'pending'])
    ->orWhere(['orders.status'=>'progress'])
    ->orWhere(['orders.status'=>'approved'])
    ->get();
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Approved_list"=>$getorder
        ]);
}
function Get_profile(Request $req){
    $imageName = '';
    if($req->profile_picture){
    $imageName = date('YmdHis') . "." . $req->profile_picture->getClientOriginalExtension();
    $req->profile_picture->move(public_path('upload'),$imageName);}

         $profile=User::find($req->id);
         if($req->profile_picture==null){
         $profile->id=$req->id;
         $profile->name=$req->name;
         $profile->save();
         }else{
        $profile->id=$req->id;
         $profile->name=$req->name;
         $profile->profile_picture=$imageName;
         $profile->save();
         }
     return response()->json([
        "Msg"=>"Success",
        "Count"=>1,
        "user_id"=>$profile->id,
        "username"=>$profile->name,
        "profile_picture"=>$profile->profile_picture
      ]);

    
 }

 function Get_user(Request $request){
    $userData=User::find($request->id);
    $clubname=DB::table('users')
    ->join('clubs', 'clubs.id','=','users.club_id')
    ->select('clubs.club_name')
    ->where('club_id',$userData->club_id)->value('club_name');
    $rolename=DB::table('users')
    ->join('roles', 'roles.id','=','users.role_id')
    ->select('roles.role_name')
    ->where('role_id',$userData->role_id)->value('role_name');
    return response()->json([
        "Msg"=>"Success",
        "Count"=>1,
        "user_id"=>$request->id,
        "username"=>$userData->name,
        "email"=>$userData->email,
        "password"=>$userData->view_password,
        "clubname"=>$clubname,
        "rolename"=>$rolename,
        "profile_picture"=>$userData->profile_picture,
      ]);
 }
}

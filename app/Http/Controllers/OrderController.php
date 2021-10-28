<?php

namespace App\Http\Controllers;
use App\Models\Admin\Order;
use App\Models\Admin\Club;
use App\Models\Admin\Role;
use App\Models\Admin\Ballroom;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }

    public function index() {
        $sessionid=Auth()->user()->id;
        $data = Order::latest('id');
        if(Auth()->user()->type==2){
            $data=$data->where('club_owner_id',Auth()->user()->id);
        }
        $data=$data->get();
        return view('Admin.order.index',['items'=>$data]);
     }
    
}

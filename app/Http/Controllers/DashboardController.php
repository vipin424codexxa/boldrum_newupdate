<?php

namespace App\Http\Controllers;

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
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    function index(){
        $clubs=club::where('user_id',Auth()->user()->id)->count();
        $ball=Ballroom::where('user_id',Auth()->user()->id)->count();
        $users=User::where('user_id',Auth()->user()->id)->where('type',3)->count();
        $materials=Material::where('user_id',Auth()->user()->id)->count();
        return view('Admin.layout.index',compact('clubs','ball','users','materials'));
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Admin\Club;
use App\Models\Admin\Role;
use App\Models\Admin\Ballroom;

use Illuminate\Http\Request;

class ClubConttroler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() {
      
    }
    public function create() {
       
    }
    public function store(Request $request) {
         
    }
    public function edit() {
      
    }
    public function update(Request $request) {
      
    }   
    public function destroy($id) {
       
    }
    
}

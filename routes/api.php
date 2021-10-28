<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\Auth\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/users', function (Request $request) {
    return $request->user();
});
Route::get('roles_list',[ApiController::class,'get_roles']);
Route::post('user_login',[ApiController::class,'Userlogin']);
Route::post('dashboard',[ApiController::class,'homePage']);
Route::post('material_list',[ApiController::class,'club_material']);
Route::post('add_material',[ApiController::class,'ballroom_item']);
Route::post('material_orders',[ApiController::class,'orders']);
//SearchMaterial data Api
Route::get('search-materials/{name}',[ApiController::class,'searchMaterialApi']);
Route::post('short-order',[ApiController::class,'shortOrders']);
Route::post('trainer-approved',[ApiController::class,'trainer_approved']);
Route::post('board_approved',[ApiController::class,'boardmember_approved']);
Route::post('board_progress',[ApiController::class,'order_progress']);
Route::post('get_ballroom_details',[ApiController::class,'ballroom_details']);
Route::post('edit_stock_list',[ApiController::class,'edit_material_stock']);
Route::get('approved_list',[ApiController::class,'approve_List']);
Route::post('set_user_profile',[ApiController::class,'Get_profile']);
Route::post('get_user_details',[ApiController::class,'Get_user']);
Route::post('order_overview',[ApiController::class,'get_currentStatus']);
Route::post('order_awaiting',[ApiController::class,'get_awaiting']);
Route::post('order_log',[ApiController::class,'get_Log']);
Route::post('change_password',[ApiController::class,'get_password']);
Route::post('post-forgotpassword', [AuthController::class, 'postforgot_api']);
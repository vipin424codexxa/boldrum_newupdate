<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




// start Admin panel Routes...
Route::get('/register', [AuthController::class, 'registration'])->name('register');
Route::get('/forgotpassword', [AuthController::class, 'forgotpassword'])->name('forgotpassword');
Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('post-forgotpassword', [AuthController::class, 'postforgotpassword'])->name('postforgotpassword');
Route::get('logout', [AuthController::class, 'logout'])->name('logout'); 

Route::get('/',[AuthController::class,'get_login'])->name('login');
Route::get('/login',[AuthController::class,'get_login']);
Route::get('/index',[DashboardController::class,'index']);
Route::get('/clubs',[AdminController::class,'get_clubs']);
Route::get('/add-club',[AdminController::class,'add_clubs']);
Route::post('/add-club',[AdminController::class,'Insert_clubs']);
Route::get('/delete_club/{id}',[AdminController::class,'Deleteclub']);

Route::get('/verify/{vcode}',[AuthController::class,'verify']);
Route::get('/change-pass',[AuthController::class,'change_password']);
Route::get('/profile',[AuthController::class,'profile_edit']);
Route::post('/profile-update', [AuthController::class, 'profile_update'])->name('update.post');
Route::post('/update-password',[AuthController::class,'get_password']);
Route::resource('users', UserController::class);
Route::resource('order', OrderController::class);
Route::get('users/inviteUser/{id}', [UserController::class,'inviteUser'])->name('inviteUser');
Route::post('/usersupdate', [UserController::class,'update'])->name('usersupdate');

Route::get('/roles',[AdminController::class,'get_roles']);
Route::get('/add-roles',[AdminController::class,'add_roles']);
Route::post('/add-roles',[AdminController::class,'Insert_roles']);

Route::get('/ballrooms',[AdminController::class,'get_ballrooms']);
Route::get('/add-ballroom',[AdminController::class,'add_ballroom']);
Route::post('/add-ballroom',[AdminController::class,'Insert_ballroom']);
Route::get('/delete_ballroom/{id}',[AdminController::class,'Deleteballroom']);

Route::get('/materials',[AdminController::class,'get_material']);
Route::get('/add-material',[AdminController::class,'add_material']);
Route::post('/add-material',[AdminController::class,'Insert_material']);
Route::get('/delete_ballroom/{id}',[AdminController::class,'Deleteballroom']);
Route::get('/club-material',[AdminController::class,'club_material']);
Route::get('/addcmaterial',[AdminController::class,'get_cmaterial']);
Route::Post('/add-cmaterial',[AdminController::class,'Insert_cmaterial']);
Route::get('/delete_material/{id}',[AdminController::class,'DeleteMaterial']);


Route::get('/team',[AdminController::class,'get_team']);
Route::post('/add-team',[AdminController::class,'add_team']);
Route::get('/delete_team/{id}',[AdminController::class,'Deleteteam']);

Route::get('/year',[AdminController::class,'get_year']);
Route::post('/add-year',[AdminController::class,'add_year']);
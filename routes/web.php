<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\FresherController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RequestController;
// use App\Http\Controllers\Auth\LoginController;
use App\Models\Timesheet;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Laravel\Socialite\Facades\Socialite;
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

Route::group(['middleware' => ['role:fresher']], function () {
  ///home
 
  ////timesheet
  Route::get('/timesheet', function () {
    return view('fresher.timesheet');
  })->name('timesheet');
  Route::get("/timesheet_fresher", [TimesheetController::class, 'timesheet_fresher']);
  /////////////////////////////////

  //////REPORT

  Route::get("/report", [ReportController::class, 'check_today_report'])->name('report');
  Route::get("/report_fresher", [ReportController::class, 'report_fresher']);
  Route::post("/add_report", [ReportController::class, 'add_report']);
  Route::post("/edit_report", [ReportController::class, 'edit_report']);

  ////////////Request
  Route::get('/request', function () {
    return view('fresher.request');
  });
  Route::post("/add_request", [RequestController::class, 'add_request']);
  Route::get("/view_request", [RequestController::class, 'display_list_request']);



});
//ADMIN
//////DASHBOARD
Route::group(['middleware' => ['role_or_permission:admin_default|Super_Admin|Report management|Timesheet management|Fresher management']], function () {
  Route::get("/dashboard", [AdminController::class, 'dashboard_data'])->name('dashboard');
});

//////////  REPORT PERMISSION
Route::group(['middleware' => ['permission:Report management']], function () {
  Route::get("/report_data", [ReportController::class, 'report_data']);
  Route::get("/report_ajax", [ReportController::class, 'getData']);
});

///////////   TIMESHEET PERMISSION
Route::group(['middleware' => ['permission:Timesheet management']], function () {
  Route::get("/", [DemoController::class, 'readtable'])->name('demo');
  Route::get("/demo_ajax", [DemoController::class, 'getData']);
  /////Request
  Route::get('/request_admin', function () {
    return view('admin.request');
  });
  Route::get("/view_request_admin", [RequestController::class, 'display_list_request_admin']);
});

///////////   FRESHER MANAGEMENT PERMISSION
Route::group(['middleware' => ['permission:Fresher management']], function () {
  Route::get("/fresher_ajax", [DemoController::class, 'display_list_fresher']);
  Route::get("/email_ajax", [DemoController::class, 'mail_ajax']);
  Route::get("/fresher_data", [DemoController::class, 'fresher_management_data']);
  Route::get("/detail/{id}", [DemoController::class, 'view_detail'])->name('fresher_detail');
  //add fresher
  Route::post("/add_fresher", [DemoController::class, 'add_fresher']);
  Route::post("/detail/update", [DemoController::class, 'update_fresher']);
  Route::post("/detail/update_ava", [DemoController::class, 'update_ava']);
});

Route::group(['middleware' => ['permission:super']], function () {
  Route::get('/admin', function () {
    return view('super_admin.admin_management');
  });
  Route::get("/admin", [AdminController::class, 'data_prepare']);
  Route::post("/add_admin", [AdminController::class, 'add_admin']);
  Route::get("/admin_search", [AdminController::class, 'display_list_admin']);
  Route::get("/detail_admin/{id}", [AdminController::class, 'view_detail'])->name('admin_detail');
  Route::post("/detail_admin/update_admin", [AdminController::class, 'update_admin']);
  Route::post("/detail_admin/update_ava", [AdminController::class, 'update_ava']);
  //////
});
/////ADMIN LOGIN
Route::get('/login', function () {
  return view('admin.login');
});

Route::post("/login_admin", [LoginController::class, 'login_admin']);
///////////
/////super admin manage admin

//PROFILE FRESHER
Route::get("/profile", [FresherController::class, 'view_profile']);
Route::post("/reset_pass", [FresherController::class, 'reset_pass']);
Route::post("update_ava", [FresherController::class, 'update_ava']);
/////
///PROFILE_ADMIN
Route::get("/profile_admin", [AdminController::class, 'view_profile']);
///
Route::get('/please', function () {
  return view('admin.fresher_detail');
});


Route::get('/auth/redirect', function () {
  return Socialite::driver('google')->redirect();
})->name('login.google');


Route::get("/auth/callback", [LoginController::class, 'logindemo']);

//logout

Route::get('/logout', function () {
  Auth::logout();
  return view('auth.login');
});

//fresher request

/////////////////////

//admin request

///////

Auth::routes();
//Route::group(['middleware' => ['permission:report_manage']], function () {
//


//});

//super_admin
//roles
Route::get("/role", [RoleController::class, 'view_role_management'])->name('role1');
Route::post("/add_role", [RoleController::class, 'add_role']);
Route::get("/check_exist_role", [RoleController::class, 'check_exist_role']);
Route::get("/display_admin_list", [RoleController::class, 'display_list_fresher']);
Route::get("/detail_role/{id}", [RoleController::class, 'view_detail'])->name('role_detail');
Route::post("/detail_role/update_role", [RoleController::class, 'update_role']);

////////////

Route::get('/home', function () {
  return view('fresher.home');
})->name('home');
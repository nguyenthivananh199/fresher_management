<?php

namespace App\Http\Controllers;

use App\Models\Student_test;
use App\Models\User;
use App\Models\Timesheet;
use App\Models\Absence_request;
use App\Http\Requests\AddFresherRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FresherController extends Controller
{
    //
    function update_ava(Request $request)
    {
        if (!$request->hasFile('pic')) {
            // Nếu không thì in ra thông báo
            return "Mời chọn file cần upload";
        }

        // Nếu có thì thục hiện lưu trữ file vào public/images
        $image = $request->file('pic');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $pic_name = $request->id . date("YmdHis") . '.jpg';
        $storedInPath = $image->move('img', $pic_name);

        //update in db
        $user = User::find($request->id);
        $user->img = '/img/' . $pic_name;
        $user->save();
        //delete old one direct in public
        $image_path = '/home/vananh/final/public' . $request->pre_img;  // Value is not URL but directory file path
        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        return redirect()->back();
    }
    function view_profile(){
        $user = Auth::user();
        return view('fresher.profile', ['user' => $user]);
    }
    function reset_pass(Request $request){
        $user1 = Auth::user();
        $t=Hash::check($request->pre_pass,$user1->password);
        if($t==1){
            $user=User::find($user1->id);
            //correct case
            $user->password=Hash::make($request->new_pass);
            $user->save();
            //logout
            Auth::logout();
            return redirect()->route('login')->withErrors(['Reset password successfully']);
        }else{
            //wrong case
            return redirect()->back()->withErrors(['Incorrect password,please try again']);
        }
    }
}

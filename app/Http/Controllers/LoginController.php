<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    //
    function login_admin(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'Active'])) {
            // The user is active, not suspended, and exists.
            $id = Auth::id();
            $user=User::find($id);
            $role = $user->getRoleNames();
            
            if($role[0]=='fresher'){
                return redirect()->route('home');
            }else{
                return redirect()->route('dashboard');
            }
        }else{
            return redirect()->route('login')->withErrors(['Fail, account undefined']);
        }
    }
    function logindemo()
    {
        $user = Socialite::driver('google')->user();
        // Auth::login($user);
        $user_exist = User::where('email', $user->email)->where('status','Active')->first();
        if(isset($user_exist->id)){
            Auth::login($user_exist);
            $role = $user_exist->getRoleNames();
            if($role[0]=='fresher'){
                
                return redirect()->route('home');
            }else{
                return redirect()->route('dashboard');
            }
        }else{
            return redirect()->route('login')->withErrors(['Account undefined']);
        }
    }
}

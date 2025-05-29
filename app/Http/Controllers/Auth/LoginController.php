<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    
    protected function authenticated(Request $request, $user){    
        if($user->user_type == "Admin"){    
            return redirect()->route('admin.dashboard');
        }elseif($user->user_type == "Advertiser"){
            if($user->email_verified_at != null){
                return redirect()->route('advertiser.dashboard');
            }else{
                return view('auth.verify', ['message' => 'Please verify your email before logging in.']);
            }
        }elseif($user->user_type == "Publisher"){
            if($user->email_verified_at != null){
                return redirect()->route('publisher.dashboard');
            }else{
                return view('auth.verify', ['message' => 'Please verify your email before logging in.']);
            }
        }else{
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Your account has no valid role.']);
            //echo "Please do Registeration first.";
        }        
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout the user
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the token
        return redirect('/login'); // Redirect to login page
    }

}

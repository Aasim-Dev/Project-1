<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
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
            return redirect()->route('advertiser.dashboard');
        }elseif($user->user_type == "Publisher"){
            return redirect()->route('publisher.dashboard');
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

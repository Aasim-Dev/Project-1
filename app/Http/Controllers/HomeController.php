<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if($user->email_verified_at == null){
            return view('auth.login', ['message' => 'Please verify your email before logging in.']);
        }elseif($user->email_verified_at != null){
            if($user->user_type == "Admin"){
                return redirect()->route('admin.dashboard');
            }elseif($user->user_type == "Advertiser"){
                return redirect()->route('advertiser.dashboard');
            }elseif($user->user_type == "Publisher"){
                return redirect()->route('publisher.dashboard');
            }else{
                return redirect()->route('auth.login');
            }
        }
        return view('home');
    }

    public function login(){
        return view('auth.login');
    }

    // public function register_post(Request $request){
    //     dd($request->all());
    // }
}

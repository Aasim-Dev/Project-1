<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Wallet;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = view('emails.verify-email');

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => $data['user_type'],
            'register_from' => $data['register_from'] ?? null,
            'client_token' => Str::random(12),
        ]);
    }

    public function showPartnerForm()
    {
        return view('auth.registerpartner');
    }

    public function showAdvertiserForm(){
        return view('auth.registeradvertiser');
    }

    public function registerLP(Request $request){
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);
        //dd($user->id);
        Wallet::create([
            'user_id' => $user->id,
            'transaction_id' => Str::random(12),
            'transaction_reference' => Str::random(12),
            'order_type' => 'reward',
            'description' => 'reward from the LP.',
            'payment_status' => 'COMPLETED',
            'payment_type' => 'reward',
            'credit_debit' => 'credit',
            'amount' => 50,
            'total' => 50,
        ]);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    public function registerForm(Request $request){
        $this->validator($request->all())->validate();
        //dd($request->name);
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        return view('emails.verify-email', compact('user'));
    }

    // protected function authenticated(Request $request, $user){
    //     if($user->user_type == "Admin"){
    //         return redirect()->route('admin.dashboard');
    //     }elseif($user->user_type == "Advertiser"){
    //         return redirect()->route('advertiser.dashboard');
    //     }elseif($user->user_type == "Publisher"){
    //         return redirect()->route('publisher.dashboard');
    //     }else{
    //         Auth::logout();
    //         return redirect()->route('register')->withErrors(['email' => 'Your account has no valid role.']);
    //         //echo "Please do Registeration first.";
    //     }
    // }

}

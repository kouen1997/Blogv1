<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Session;
use Socialite;
use Carbon\Carbon;

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
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getLogin()
    {   
        if (Auth::check()) {
            
            return redirect('/admin/dashboard');

        } else {
            return view('auth.login');
        }
    }
    public function postLogin(LoginRequest $request)
    {
        
        $userdata = array(
            'username'  => $request->username,
            'password'  => $request->password
        );
        
   
        if (Auth::attempt($userdata)) {

              return redirect('/admin/dashboard');
                
        } else {      

            Session::flash('danger', "The credentials you entered did not match our records.");
            return back();
            
        }
        
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        
        $userExists = User::where('email', $user->email)->first();

        if ($userExists) {
          
            auth()->login($userExists, true);
            return redirect('/admin/dashboard');

        } else {

            $newUser            = new User;
            $newUser->name      = $user->name;
            $newUser->email     = $user->email;
            $newUser->provider  = $provider;
            $newUser->save();

            auth()->login($newUser, true);
            return redirect('/admin/dashboard');
        }

    }

    public function logout() {
        if (Auth::user()){
            Auth::logout();
            Session::flush();
            return redirect('/login');
        } else {
            return redirect('/login');  
        }
    }

}

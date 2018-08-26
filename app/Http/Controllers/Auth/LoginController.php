<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }
    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
    public function socialLogin($social)
 
    {
  
        return Socialite::driver($social)->redirect();
  
    }
    public function handleProviderCallback($social)
 
    {
  
        $userSocial = Socialite::driver($social)->user();
  
        $user = User::where(['email' => $userSocial->getEmail()])->first();
  
        if($user){
  
            Auth::login($user);
  
            return redirect()->action('HomeController@index');
  
        }else{
  
            return view('auth.register',['name' => $userSocial->getName(), 'email' => $userSocial->getEmail()]);
  
        }
  
    }
}

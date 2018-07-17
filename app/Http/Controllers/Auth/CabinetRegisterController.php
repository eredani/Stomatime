<?php

namespace App\Http\Controllers\Auth;

use App\Cabinet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Jobs\SendCabineteEmail;
class CabinetRegisterController extends Controller
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


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:cabinet', ['except' => ['logout']]);
    }

    public function index()
    {
        return view('auth.cabinet-register');
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
            'name' => 'required|string|max:40',
            'email' => 'required|string|email|max:130|unique:cabinets',
            'password' => 'required|string|min:6|confirmed',
            'g-recaptcha-response' => 'required|captcha',
            'judet' => 'required|max:40',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Cabinet
     */
    protected function create(array $data)
    {
        return Cabinet::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'judet' => $data['judet'],
            'password' => Hash::make($data['password']),
            'email_token' => base64_encode($data['email']),
    
        ]);
    }
    public function register(Request $request)
    { 

        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        dispatch(new SendCabineteEmail($user));
        return view('verification');
 
    }
        /**
        * Handle a registration request for the application.
        *
        * @param $token
        * @return \Illuminate\Http\Response
        */
    public function verify($token)
    {
        $user = Cabinet::where('email_token',$token)->first();
        $user->verified = 1;
        if($user->save())
        {
        return view('emailconfirm',['user'=>$user]);
        }
    }
}

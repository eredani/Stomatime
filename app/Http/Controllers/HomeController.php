<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Pusher\Laravel\Facades\Pusher;
use Auth;
use Storage;
use File;
use App\Cabinet;
use App\Sali;
use App\Specializari;
use App\Servicii;
use App\Doctori;
use App\StarsCabs;
use App\Jobs\SendVerificationEmail;
use Illuminate\Support\Facades\Hash;
use DB;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','IsVerified','2fa']);
    }
    public function viewServicii($id)
    {

        $cabinet= Cabinet::where('id',$id)->where('type','>',0)->where('public',1)->exists();
        if(!$cabinet)
        {
            return redirect()->back();
        }
        $info = Cabinet::where('id',$id)->select('id','name')->first();
        return view('cabinet.servicii')->with(['info'=>$info]);
    }
    public function setProfile(Request $request)
    { 
        $this->validate($request, [

            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    
        ]);
        $factory = new \ImageOptimizer\OptimizerFactory();
        $optimizer = $factory->get();
        $path= $request->file('profile')->store('/public/avatars');
        $optimizer->optimize('/var/www/html/stomatime/storage/app/'.$path);
        
        $user=Auth::user();
        if(Auth::user()->img_profile==null)
        {
            $user->img_profile=$path;
        }
        else
        {
            Storage::delete(Auth::user()->img_profile);
            $user->img_profile=$path;
        }
        $user->save();
        return redirect()->back()->with('success','Fotografia a fost salvată.');
    
    }
    public function setting()
    {
        $image="";
        if(Auth::user()->img_profile==null)
        {
            $image="//placehold.it/150";
        }
        else
        {
            $image = Storage::url(Auth::user()->img_profile);
        }
        if(Auth::user()->google2fa_secret==null)
        {
            $google2fa = app('pragmarx.google2fa');
        
            $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();
        
            $QR_Image = $google2fa->getQRCodeInline(
                config('app.name'),
                Auth::user()->email,
                $registration_data['google2fa_secret']
            );
            return view('pacient.setting', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret'],'image'=>$image]);
        }
        else
        {
            return view('pacient.setting',['image'=>$image]);
        }
    }
    public function editProfile(Request $req)
    {
        
        if($req->input('pass1')==$req->input('pass') && Hash::check($req->input('pass'),Auth::user()->password))
        {
            $setemail=false;
            $user = Auth::user();
            if($req->input('email')!=Auth::user()->email)
            {
                $user->email=$req->input('email');
                $user->email_token=base64_encode($req->input('email'));
                $user->verified=0;
                $setemail=true;
            }
            if($req->input('name')!=Auth::user()->name)
            {
                $user->name=htmlspecialchars($req->input('name'));
            }
            if($req->input('newpass')!=null)
            {
                $user->password=Hash::make($req->input('newpass'));
            }
            $user->save();
            $userf=Auth::user();
            if($setemail)
            {
                dispatch(new SendVerificationEmail($userf));
            }
            return redirect()->back()->with('success','Profilul a fost modificat.');
        }
        else
        {
         return redirect()->back()->with('fail','Parolele nu corespund sau parola nu există.');
        }
    }
    public function enableTwoAuth(Request $req)
    {
        $user = Auth::user();
        $user->google2fa_secret = ($req->input('secret'));
        $user->save();
        return redirect()->back();
    }
    public function disableTwoAuth(Request $req)
    {
        $user = Auth::user();
        $user->google2fa_secret = null;
        $user->save();
        return redirect()->back();
    }
    public function index($s = null)
    {  
        return view('home');
    }
    public function view($id)
    {

        $cabinet= Cabinet::where('id',$id)->where('type','>',0)->exists();
        if(!$cabinet)
        {
            return redirect()->back();
        }
        $info = Cabinet::where('id',$id)->select('name','id')->first();
        return view('pacient.view')->with(['info'=>$info,'id'=>Auth::user()->id]);
    }
    public function setScore(Request $req)
    {
        $scor = $req->input('score');
        $idCab = $req->input('cabinet');
        if($scor>0 && $scor<6)
        {
            if(Cabinet::where('id',$idCab)->exists())
            {
                if (StarsCabs::where('id_cab', $idCab)->where('id_client', Auth::user()->id)->exists())
                {
                    $last_date=StarsCabs::where('id_cab', $idCab)->where('id_client', Auth::user()->id)->first();
                    $time = time();
                    if(abs($time- strtotime($last_date->updated_at)) > 100)
                    {
                        StarsCabs::where('id_cab', $idCab)->where('id_client', Auth::user()->id)->update(['scor' => $scor]);
                        $msg['status']="success";
                        $msg['msg']="Scorul a fost modificat!";
                        return $msg;
                    }
                    $msg['status']="fail";
                    $msg['msg']="Mai asteaptă!";
                    return $msg;

                } else {
                    $star = new StarsCabs;
                    $star->id_client=Auth::user()->id;
                    $star->id_cab=$idCab;
                    $star->scor=$scor;
                    $star->save();
                    $msg['status']="success";
                    $msg['msg']="Scorul a fost înregistrat!";
                    return $msg;
                }
            }
            else
                {
                    $msg['status']="fail";
                    $msg['msg']="Cabinetul nu există!";
                    return  $msg;
            }
        }
        else
        {
            $msg['status']="fail";
            $msg['msg']="Scorul nu este bun!";
            return  $msg;
        }

    }
    public function viewMedic($id,$idm)
    {
        $doctor= Doctori::where('id',$idm)->where('id_cab',$id)->exists();
        if(!$doctor)
        {
            return redirect()->back();
        }
        $info = Cabinet::where('id',$id)->select('name','id')->first();
        return view('cabinet.medic')->with(['info'=>$info,'idmedic'=>$idm]);
    }
}
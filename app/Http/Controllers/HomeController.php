<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Pusher;
use Auth;
use Storage;
use File;
use App\Cabinet;
use App\Sali;
use App\Specializari;
use App\Servicii;
use App\Doctori;
use App\StarsCabs;
use App\StarsMedic;
use App\Programari;
use App\Jobs\SendVerificationEmail;
use Illuminate\Support\Facades\Hash;
use DB;
use Nexmo\Laravel\Facade\Nexmo;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','IsVerified','2fa']);
    }
    public function cancel(Request $req)
    {
        
        $id_medic=$req->input('id_medic');
        $id_cab=$req->input('id_cab');
        $id=$req->input('id');
        if(DB::connection('stomatime_'.$id_cab)->table('programari')->where('id',$id)->where('id_cab',$id_cab)->where('id_doctor',$id_medic)->where('id_client',Auth::user()->id)->exists())
        {
            DB::connection('stomatime_'.$id_cab)->table('programari')->where('id',$id)->where('id_cab',$id_cab)->where('id_doctor',$id_medic)->where('id_client',Auth::user()->id)->update(['status'=>2]);
            $msg['status']="success";
            $msg['msg']="Programarea a fost anulată";
            return $msg;
        }
        $msg['status']="fail";
        $msg['msg']="Ceva nu a mers bine";
        return $msg;
    }
    public function confirmare(Request $req)
    {
        $cod=$req->input('cod');
        $id_medic=$req->input('id_medic');
        $id_cab=$req->input('id_cab');
        $id=$req->input('id');
        if(DB::connection('stomatime_'.$id_cab)->table('programari')->where('id',$id)->where('id_cab',$id_cab)->where('confirmat',0)->where('id_doctor',$id_medic)->where('id_client',Auth::user()->id)->where('code',$cod)->exists())
        {
            DB::connection('stomatime_'.$id_cab)->table('programari')->where('id',$id)->where('id_cab',$id_cab)->where('confirmat',0)->where('id_doctor',$id_medic)->where('id_client',Auth::user()->id)->where('code',$cod)->update(['confirmat'=>1]);
            $msg['status']="success";
            $msg['msg']="Programarea a fost confirmată";
            return $msg;
        }
        $msg['status']="fail";
        $msg['msg']="Codul nu este bun";
        return $msg;

    }
    private function Pushers($data,$channel,$event)
    {
        $options = array(
            'cluster' => 'eu',
            'encrypted' => true
          );
          $pusher = new Pusher\Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
          );
        
          $pusher->trigger($channel, $event, $data);
    }
    public function programari($me=null)
    {
        if($me!==null)
        {
            $azi = date("Y-m-d");  
            $program = DB::connection('stomatime_'.$id_cab)->table('programari')->select(['id','id_cab','id_doctor','numar','data','ora','status','confirmat'])->where('id_client',Auth::user()->id)->where('data','>=',$azi)->get();
            foreach($program as $key=>$programare)
            {
                $medicdata = DB::connection('stomatime_'.$id_cab)->table('doctori')->where('id',$programare->id_doctor)->where('id_cab',$programare->id_cab)->first();
                $cabinetdata = Cabinet::where('id',$programare->id_cab)->first();
                $program[$key]->medic=$medicdata->nume ." ". $medicdata->prenume;
                $program[$key]->cabinet=$cabinetdata->name;
                $program[$key]->numar="40".$programare->numar;
            }
            return  $program;
        }
        return view('pacient.programari')->with(['id'=>Auth::user()->id]);
    }
    public function getProgram(Request $req)
    {
        $id_medic=$req->input('id_medic');
        $id_cab=$req->input('id_cab');
        $date=$req->input('data');
        if(Auth::guard('web')->check() &&  Cabinet::where('id',$id_cab)->exists() && DB::connection('stomatime_'.$id_cab)->table('doctori')->where('id',$id_medic)->where('id_cab',$id_cab)->exists())
        {
            $dt=strtotime($date);
            if(DB::connection('stomatime_'.$id_cab)->table('programari')->where('id_cab',$id_cab)->where('id_doctor',$id_medic)->where('data',date('Y-m-d',$dt))->exists())
            {
                $oreocupate = DB::connection('stomatime_'.$id_cab)->table('programari')->select('ora')->where('id_cab',$id_cab)->where('id_doctor',$id_medic)->where('data',date('Y-m-d',$dt))->get();
          
                return $oreocupate;
            }
            else
            {
               
                return null;
            }
        }
        else
        {
            $msg['status']="fail";
            $msg['msg']="Ceva este gresit.";
            return $msg;
        }
    }
    public function programare(Request $req)
    {
        $id_cab=$req->input('id_cab');
        $id_medic=$req->input('id_medic');
        $data=$req->input('data');
        $ora=$req->input('ora');
        $nr=$req->input('nr');
        if(DB::connection('stomatime_'.$id_cab)->table('doctori')->where('id',$id_medic)->where('id_cab',$id_cab)->exists())
        { 
            if(DB::connection('stomatime_'.$id_cab)->table('programari')->where('id_client',Auth::user()->id)->where('confirmat',0)->where('status','!=',2)->exists())
            {
                $msg['status']="fail";
                $msg['msg']="Se pare ca ai o programare ne confirmată. Confirmă sau anulează programarea din contul tau înainte să faci alta.";
                return $msg;
            }
            else
            {
                if(strlen ($nr)==10)
                {
                    $code=rand(1000,9999);
                    $nrsend = "4".$nr;
                    $dt=strtotime($data);
                    $cabinet = Cabinet::select(['name'])->where('id',$id_cab)->first();
                
                    $msgmobile = $code." este codul pentru confirmarea programarii din data de " .date('Y-m-d',$dt). " ora ".$ora. " pentru ".$cabinet->name;

                   
                     Nexmo::message()->send([
                         'to'   => $nrsend,
                         'from' => 'Stomatime',
                         'text' => $msgmobile
                     ]);
                    $programare = new Programari;
                    $programare->setConnection('stomatime_'.$id_cab);
                    $programare->id_cab=$id_cab;
                    $programare->id_doctor=$id_medic;
                    $programare->id_client=Auth::user()->id;
                    $programare->data=date('Y-m-d',$dt);
                    $programare->ora=$ora;
                    $programare->numar=$nr;
                    $programare->code=$code;
                    $programare->save();
                    $push['msg']=Auth::user()->name  ." a facut o programare.";
                    $this->Pushers($push,(string)('programare'.$id_cab),(string)'new');                   
                    $msg['status']="success";
                    $msg['id']=$programare->id;
                    $msg['msg']="Programarea a fost înregistrată, te rugăm să o confirmi prin adresa de email.";
                    return $msg;
                }
                else
                {
                    $msg['status']="fail";
                    $msg['msg']="Numărul nu este valid.";
                    return $msg;
                }
            }
        }
        else
        {
            $msg['status']="fail";
            $msg['msg']="Medicul nu există.";
            return $msg;
        }
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
        $optimizer->optimize('/home/stomatime/www/Stomatime/storage/app/'.$path);
        
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
    public function index()
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
        $info = Cabinet::where('id',$id)->select('name','id','tawk')->first();
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
    public function setScoreMedic(Request $req)
    {
        $scor = $req->input('score');
        $idMedic = $req->input('medic');
        $idCab = $req->input('cabinet');
        if($scor>0 && $scor<6)
        {
            if(Cabinet::where('id',$idCab)->exists())
            {
                if (DB::connection('stomatime_'.$idCab)->table('starMedic')->where('id_cab', $idCab)->where('id_client', Auth::user()->id)->where('id_medic',$idMedic)->exists())
                {
                    $last_date=DB::connection('stomatime_'.$idCab)->table('starMedic')->where('id_cab', $idCab)->where('id_client', Auth::user()->id)->where('id_medic',$idMedic)->first();
                    $time = time();
                    if(abs($time- strtotime($last_date->updated_at)) > 100)
                    {
                        DB::connection('stomatime_'.$idCab)->table('starMedic')->where('id_cab', $idCab)->where('id_client', Auth::user()->id)->where('id_medic',$idMedic)->update(['scor' => $scor]);
                        $msg['status']="success";
                        $msg['msg']="Scorul a fost modificat!";
                        return $msg;
                    }
                    $msg['status']="fail";
                    $msg['msg']="Mai asteaptă!";
                    return $msg;

                } else {
                    $star = new StarsMedic;
                    $star->setConnection('stomatime_'.$idCab);
                    $star->id_client=Auth::user()->id;
                    $star->id_cab=$idCab;
                    $star->id_medic=$idMedic;
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
        $doctor= DB::connection('stomatime_'.$id)->table('doctori')->where('id',$idm)->where('id_cab',$id)->exists();
        if(!$doctor)
        {
            return redirect()->back();
        }
        $info = Cabinet::where('id',$id)->select('name','id')->first();
        return view('cabinet.medic')->with(['info'=>$info,'idmedic'=>$idm]);
    }
}
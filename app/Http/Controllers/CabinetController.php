<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Storage;
use Nexmo\Laravel\Facade\Nexmo;
use File;
use DB;
use Validation;
use App\Sali;
use App\Specializari;
use App\Servicii;
use App\Doctori;
use App\User;
use App\Cabinet;
use App\Programari;
use App\Jobs\SendCabineteEmail;
use Illuminate\Support\Facades\Hash;
class CabinetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:cabinet','IsVerified','CabVf']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmare(Request $req)
    {
        $id_medic=$req->input('id_medic');
        $id_client=$req->input('id_client');
        $id=$req->input('id');
        if(DB::connection('stomatime_'.Auth::user()->id)->table('programari')->where('id',$id)->where('id_cab',Auth::user()->id)->where('status',0)->where('id_doctor',$id_medic)->where('id_client',$id_client)->exists())
        {
            DB::connection('stomatime_'.Auth::user()->id)->table('programari')->where('id',$id)->where('id_cab',Auth::user()->id)->where('status',0)->where('id_doctor',$id_medic)->where('id_client',$id_client)->update(['status'=>1]);
            $msg['status']="success";
            $msg['msg']="Programarea a fost confirmată";
            return $msg;
        }
        $msg['status']="fail";
        $msg['msg']="Codul nu este bun";
        return $msg;

    }
    public function programari()
    {
            $azi = date("Y-m-d");  
            $program = DB::connection('stomatime_'.Auth::user()->id)->table('programari')->select(['id','id_cab','id_doctor','id_client','numar','data','ora','status','confirmat'])->where('id_cab',Auth::user()->id)->where('data','>=',$azi)->get();
            foreach($program as $key=>$programare)
            {
                $medicdata = DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id',$programare->id_doctor)->where('id_cab',$programare->id_cab)->first();
                $pacientdata = User::where('id',$programare->id_client)->first();
                $cabinetdata = Cabinet::where('id',$programare->id_cab)->first();
                $program[$key]->medic=$medicdata->nume ." ". $medicdata->prenume;
                $program[$key]->pacient=$pacientdata->name;
                $program[$key]->cabinet=$cabinetdata->name;
                $program[$key]->numar="40".$programare->numar;
            }
            return  $program;
    }
    public function medicEditProgram(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [
            'id'=>'required|numeric'
        ]);
        $medicexist=DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->exists();
        if(!$medicexist)
        {
            return redirect()->back()->with(['error'=>"Medicul nu există."]);
        }
        $dr = new Doctori;
        $dr->setConnection('stomatime_'.Auth::user()->id);
        $doctor=$dr->find($req->input('id'));
        $doctor->orar=json_encode($req->input('program'));
        $doctor->save();
        return redirect()->back()->with(['success'=>"Programul a fost editat."]);
    }
    public function medicAddSpeci(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'specializare'=>'required',
            'id'=>'required|numeric'
    
        ]);
        $ex=DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->select('id_specializari')->exists();
        $medicexist=DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->select('id_specializari')->get();
        if(!$ex)
        {
            return redirect()->back()->with(['error'=>"Medicul nu există."]);
        }
        $cont=0;
        foreach($req->input('specializare') as $speci)
        {
            $exist = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->find($speci);
            if($exist!=null)
            {
                $cont++;
            }
        }
        if(count($req->input('specializare'))!=$cont)
        {
            return redirect()->back()->with(['error'=>"O specializare selectată nu se află în baza de date."]);
        }
        $doctor=DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->find($req->input('id'));
        
        $doctor->id_specializari=json_encode(array_merge($req->input('specializare'),json_decode($medicexist[0]->id_specializari,true)));
        $doctor->save();
          return redirect()->back()->with(['success'=>"Specializările au fost modificate."]);
    }
    public function medicDelSpeci(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'specializare'=>'required',
            'id'=>'required|numeric'
    
        ]);
        $medicexist=DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->exists();
        if(!$medicexist)
        {
            return redirect()->back()->with(['error'=>"Medicul nu există."]);
        }
        $cont=0;
        foreach($req->input('specializare') as $speci)
        {
            $exist = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->find($speci);
            if($exist!=null)
            {
                $cont++;
            }
        }
        if(count($req->input('specializare'))!=$cont)
        {
            return redirect()->back()->with(['error'=>"O specializare selectată nu se află în baza de date."]);
        }
        $med= new Doctori;
        $med->setConnection('stomatime_'.Auth::user()->id);
        //DB::connection('stomatime_'.Auth::user()->id)->table('doctori')
        $medic = $med->find($req->input('id'));
        $specializari=json_decode($medic->id_specializari,true);
        foreach($specializari as $c => $spec)
        {
            foreach($req->input('specializare') as $delspec)
            {
                if($spec==$delspec)
                {
                    unset($specializari[$c]);
                }
            }
            
        }
        $medic->id_specializari=json_encode(array_values($specializari));
        $medic->save();
        return redirect()->back()->with(['success'=>"Specializările au fost modificate."]);
    }
    public function medicSetSpeci(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'specializare'=>'required',
            'id'=>'required|numeric'
    
        ]);
        $medicexist=DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->exists();
        if(!$medicexist)
        {
            return redirect()->back()->with(['error'=>"Medicul nu există."]);
        }
        $cont=0;
        foreach($req->input('specializare') as $speci)
        {
            $exist = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->find($speci);
            if($exist!=null)
            {
                $cont++;
            }
        }
        if(count($req->input('specializare'))!=$cont)
        {
            return redirect()->back()->with(['error'=>"O specializare selectată nu se află în baza de date."]);
        }
        $med= new Doctori;
        $med->setConnection('stomatime_'.Auth::user()->id);
        $medic= $med->find($req->input('id'));
        $medic->id_specializari=json_encode($req->input('specializare'));
        $medic->save();
         return redirect()->back()->with(['success'=>"Specializarea a fost setată."]);
    }
    public function medicSetSala(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'sala' => 'required',
            'id'=> 'required|numeric',
    
        ]);
        $exist=DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->exists();
        $existsala=DB::connection('stomatime_'.Auth::user()->id)->table('sali')->where('id',$req->input('sala'))->where('id_cab',Auth::user()->id)->exists();
        if(!$exist)
        {
            return redirect()->back()->with('fail','Medicul nu a fost găsit în baza de date.');
        }
        else
        {
            if($req->input('sala')=="sterge")
            {
                  $med= new Doctori;
                $med->setConnection('stomatime_'.Auth::user()->id);
                $doctor=$med->find($req->input('id'));
                $doctor->id_sala=null;
                $doctor->save();
                return redirect()->back()->with('success','Cabinetul a fost sters.');
            }
            if($existsala)
            {
                $med= new Doctori;
                $med->setConnection('stomatime_'.Auth::user()->id);
                $doctor=$med->find($req->input('id'));
                $doctor->id_sala=$req->input('sala');
                $doctor->save();
                return redirect()->back()->with('success','Cabinetul a fost setat.');
            }
            return redirect()->back()->with('fail','Cabinetul nu exista.');
        }

    }
    public function medicImg(Request  $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'src' => 'required|string',
            'id'=> 'required|numeric',
    
        ]);
        $factory = new \ImageOptimizer\OptimizerFactory();
        $optimizer = $factory->get();
        $path= $req->file('profile')->store("/public/medici/".Auth::user()->id);
        $optimizer->optimize('/var/www/html/stomatime/storage/app/'.$path);
        $doctor=DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->find($req->input('id'));
        if($doctor->img_profile==$req->input('src'))
        {
            Storage::delete($doctor->img_profile);
            $doctor->img_profile=Storage::url($path);
        }
        else
        {
            $doctor->img_profile=Storage::url($path);
        }
        $doctor->save();
        return redirect()->back()->with('success','Fotografia a fost salvată.');

    
    }
    public function config()
    {
        $active = session('active');
        if($active==null)
        {
            $active='specializari';
        }
       $specializari = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id_cab', Auth::user()->id)->get();
       
       $servicii = DB::connection('stomatime_'.Auth::user()->id)->table('servicii')->where('id_cab', '=', Auth::user()->id)->get();
       $sali = DB::connection('stomatime_'.Auth::user()->id)->table('sali')->where('id_cab', Auth::user()->id)->orderBy('etaj','ASC')->orderBy('numar','ASC')->get();
        $medici = DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id_cab', Auth::user()->id)->get();
        if(count($medici)==0)
        {
            $medici=null;
        }
       if(count($specializari)==0)
       {
        $specializari=null;
       }
       else
       {
        if(count($servicii)==0)
        {
            $servicii=null;
        }
       }
       if(count($sali)==0)
       {

        $sali=null;
       }
       return view('cabinet.config')->with(['spec'=>$specializari,'servicii'=>$servicii,'sali'=>$sali,'active'=>$active,'medici'=>$medici]);
    
    }
    public function delServ(Request $req)
    {
        session(['active' => 'specializari']);
        $active = session('active');
        $exist = DB::connection('stomatime_'.Auth::user()->id)->table('servicii')->where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->count();
        if($exist!=0)
        {
            $serv= DB::connection('stomatime_'.Auth::user()->id)->table('servicii')->where('id',$req->input('id'))->delete();

            return redirect()->back()->with(['error'=>"Serviciul a fost sters.",'active'=>$active]);
        }
        else
        {
            return redirect()->back()->with(['error'=>"Serviciul nu există în baza de date.",'active'=>$active]);
        }
        return $req;
    }
    public function addServ(Request $req)
    {
        session(['active' => 'specializari']);
        $active = session('active');
        $this->validate($req, [

            'specializare' => 'required|string',
            'pret' => 'required|numeric',
            'durata' => 'required|numeric',
            'serviciu' => 'required|string',
    
        ]);
        $explode = explode("(*)", $req->input('specializare'));
        $id=$explode[1];
        $denumire = htmlspecialchars ($req->input('serviciu'));
        $serviciu = filter_var($denumire, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $existid = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id', '=', $id)->first();
        if($existid === null)
       {
        return redirect()->back()->with(['error'=>"Se pare ca specializarea selectată nu mai este in baza de date.",'actice'=>$active]);
       }
       else
       {
        $exist = DB::connection('stomatime_'.Auth::user()->id)->table('servicii')->where('id_cab', '=', Auth::user()->id)->where('denumire',$denumire)->where('id_specializare',$id)->first();
        if ($exist === null)
        {
        $servicii = new servicii();
          $servicii->setConnection('stomatime_'.Auth::user()->id);
        $servicii->id_cab=Auth::user()->id;
        $servicii->id_specializare=$id;
        $servicii->denumire=$denumire;
        $servicii->pret=$req->input('pret');
        $servicii->durata=$req->input('durata');
        $servicii->save();
        return redirect()->back()->with(['success'=>"Serviciul: $denumire a fost adăugată în baza de date.",'active'=>$active]);
        }
        else 
        {
            return redirect()->back()->with(['error'=>"Serviciul: $denumire există în baza de date.",'active'=>$active]);
        }
       }
    }
    public function addSpeci(Request $req)
    {
        session(['active' => 'specializari']);
        $this->validate($req, [
            'specializare' => 'required|string'
        ]);
        $active = session('active');
        $speci = htmlspecialchars ($req->input("specializare"));
        $special = filter_var($speci, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $exist = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id_cab', '=', Auth::user()->id)->where('specializare',$speci)->first();
        if ($exist === null) 
        {
        $specializare = new specializari();
        $specializare->setConnection('stomatime_'.Auth::user()->id);
        $specializare->id_cab=Auth::user()->id;
        $specializare->specializare=$speci;
        $specializare->save();
        return redirect()->back()->with(['success'=>"Specializarea: $speci a fost adăugată în baza de date.",'active'=>$active]);
        }
        else 
        {
            return redirect()->back()->with(['error'=>"Specializarea: $speci există în baza de date.",'active'=>$active]);
        }
    }
    public function delSpeci(Request $req)
    {
        session(['active' => 'specializari']);
        $active = session('active');
        $id=$req->input('id');
        $exist = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id_cab', '=', Auth::user()->id)->where('id',$id)->first();
        if ($exist != null) 
        {
            $spec = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id',$id)->delete();
          
            DB::connection('stomatime_'.Auth::user()->id)->table('servicii')->where('id_cab', '=', Auth::user()->id)->where('id_specializare',$id)->delete();
            $medici = DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id_cab',Auth::user()->id)->where('id_specializari','!=','null')->get();
            foreach($medici as $medic)
            {
                $specializaremedic = json_decode($medic->id_specializari,true);
                $cont=0;
                foreach($specializaremedic as $c => $sp)
                {
                    if($sp==$id)
                    {
                        unset($specializaremedic[$c]);
                        $cont++;
                    }
                }
                if($cont>0)
                {
                    $me = DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->find($medic->id);
                    $me->id_specializari=json_encode(array_values($specializaremedic));
                    $me->save();
                }
            }
            return redirect()->back()->with(['success'=>"Specializarea a fost stearsă din baza de date.",'active'=> $active ]);
        }
        else 
        {
            return redirect()->back()->with(['error'=>"Specializarea nu se găseste în baza de date.",'active'=> $active ]);
        }
    }
    public function index()
    {

        $info = Cabinet::where('id',Auth::user()->id)->select('id','name')->first();
        return view('cabinet')->with(['info'=>$info]);
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
            $image = Auth::user()->img_profile;
        }
    
        return view('cabinet.setting',['image'=>$image]);
    
    
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
                $user->name=$req->input('name');
            }
            if($req->input('newpass')!=null)
            {
                $user->password=Hash::make($req->input('newpass'));
            }
            $user->save();
            $userf=Auth::user();
            if($setemail)
            {
                dispatch(new SendCabineteEmail($userf));
            }
            return redirect()->back()->with('success','Profilul a fost modificat.');
        }
        else
        {
         return redirect()->back()->with('fail','Parolele nu corespund sau parola nu există.');
        }
    }
    public function setProfile(Request $request)
    { 
        $this->validate($request, [

            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    
        ]);

        $factory = new \ImageOptimizer\OptimizerFactory();
        $optimizer = $factory->get();
        $path= $request->file('profile')->store('/public/cabinete');
        $optimizer->optimize('/home/stomatime/www/storage/app/'.$path);
        $path= Storage::url($path);
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
    public function setPublicProfile(Request $request)
    {
        $validate = $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'numar' => 'numeric|required',
            'public' => 'boolean',
        ]);
        $cab = Auth::user();
        $cab->descriere=htmlspecialchars($request->input('descriere'));
        $cab->adresa=htmlspecialchars($request->input('adresa'));
        $cab->moto=htmlspecialchars($request->input('slogan'));
        $cab->lat=$request->input('lat');
        $cab->long=$request->input('long');
        $cab->numar=$request->input('numar');
        if($request->input('tawk')!==null)
        {
         
            if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$request->input('tawk')) && strpos($request->input('tawk'),"https://embed.tawk.to/")!== false) 
            {
                $cab->tawk=$request->input('tawk');
            }
        }
        else{
            $cab->tawk=null;
        }
        if($request->input('public')!==null)
        {
            $cab->public=$request->input('public');
        }
        else
        {
            $cab->public=0;
        }
        $cab->program=json_encode($request->input('program'));
        $cab->save();
        return redirect()->back()->with(['success'=>"Profilul a fost actualizat."]);
    }
    public function addSala(Request $req)
    {
        session(['active' => 'cabinet']);
        $active = session('active');
        $validate = $req->validate([
            'cabinet' => 'required|numeric',
            'etaj' => 'required|numeric',
        ]);
        $exist = DB::connection('stomatime_'.Auth::user()->id)->table('sali')->where('id_cab', Auth::user()->id)->where('numar',$req->input('cabinet'))->where('etaj',$req->input('etaj'))->get(); 
        if (count($exist) == 0) 
        {
            $sala = new sali();
            $sala->setConnection('stomatime_'.Auth::user()->id);
            $sala->id_cab=Auth::user()->id;
            $sala->etaj= $req->input('etaj');
            $sala->numar= $req->input('cabinet');
            $sala->save();
            return redirect()->back()->with(['success'=>"Cabinetul a fost salvat.",'active'=> $active]);
        }
        else
        {
            return redirect()->back()->with(['error'=>"Cabinetul există in baza de date.",'active'=> $active]);
        }
    }
    public function delSala(Request $req)
    {
        session(['active' => 'cabinet']);
        $active = session('active');
        $validate = $req->validate([
            'id' => 'required|numeric',
        ]);
        $exist = DB::connection('stomatime_'.Auth::user()->id)->table('sali')->where('id_cab', Auth::user()->id)->where('id',$req->input('id'))->get(); 
        if (count($exist) == 0) 
        {
            return redirect()->back()->with(['error'=>"Cabinetul nu există in baza de date.",'active'=>'specializari']);
        }
        else
        {
            $spec = DB::connection('stomatime_'.Auth::user()->id)->table('sali')->where('id',$req->input('id'))->delete();
        
            DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id_sala',$req->input('id'))
                    ->update(['id_sala'=> null]);
                    return redirect()->back()->with(['error'=>"Cabinetul a fost sters.",'active'=>$active]);
        }


    }
    public function addMedic(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nume' => 'required|string|max:35',
            'prenume' => 'required|string|max:35',
            'descriere' => 'required|string|max:255',
            'profesie' => 'required|string|max:100',
            'disponibilitate' => 'required|numeric',
            'sala' => 'numeric',
            'specializare'=>'array|min:1',
            'gen'=>'required|string|max:1',
    
        ]);
        if($req->input('specializare')!=null)
        {
        $cont=0;
            foreach($req->input('specializare') as $speci)
            {
                $exist = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id',$speci)->exists();
                if($exist)
                {
                    $cont++;
                }
            }
            if(count($req->input('specializare'))!=$cont)
            {
                return redirect()->back()->with(['error'=>"O specializare selectată nu se află în baza de date."]);
            }
        }
        if($req->input('sala')!=null)
        {
            $existsala=DB::connection('stomatime_'.Auth::user()->id)->table('sali')->where('id',$req->input('sala'))->exists();
            if(!$existsala)
            {
                return redirect()->back()->with(['error'=>"Sala introdusă nu există."]);
            }
        }
        $doctor = new doctori;
        $doctor->setConnection('stomatime_'.AUth::user()->id);
        try{
            $factory = new \ImageOptimizer\OptimizerFactory();
            $optimizer = $factory->get();
            $path= $req->file('profile')->store("/public/medici/".Auth::user()->id);
            $optimizer->optimize('/home/stomatime/www/storage/app/'.$path);
            $doctor->img_profile=Storage::url($path);
        }catch (Exception $e)
        {

        }

        $doctor->nume=$req->input('nume');
        $doctor->prenume=$req->input('prenume');
        $doctor->descriere=$req->input('descriere');
       
        $doctor->frecventa=$req->input('disponibilitate');
        $doctor->gen=$req->input('gen');
        $doctor->profesie=$req->input('profesie');
        $doctor->id_cab=Auth::user()->id;
        if($req->input('sala')!=null)
        {
            $doctor->id_sala=$req->input('sala');
        }
        
        if($req->input('specializare')!=null)
        {
            $doctor->id_specializari=json_encode($req->input('specializare'));
        }
        if($req->input('program')!=null)
        {
            $doctor->orar=json_encode($req->input('program'));
        }
        $doctor->save();
        return redirect()->back()->with(['success'=>"Medicul a fost adăugat."]);
    }
}
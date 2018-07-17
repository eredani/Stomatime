<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Storage;
use Nexmo\Laravel\Facade\Nexmo;
use File;
use Validation;
use App\Sali;
use App\Specializari;
use App\Servicii;
use App\Doctori;

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
    public function mediceditprogram(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [
            'id'=>'required|numeric'
        ]);
        $medicexist=Doctori::where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->get();
        if(count($medicexist)==0)
        {
            return redirect()->back()->with(['error'=>"Medicul nu există."]);
        }
        $doctor = Doctori::find($req->input('id'));
        $doctor->orar=json_encode($req->input('program'));
        $doctor->save();
        return redirect()->back()->with(['success'=>"Programul a fost editat."]);
    }
    public function medicaddspeci(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'specializare'=>'required',
            'id'=>'required|numeric'
    
        ]);
        $medicexist=Doctori::where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->select('id_specializari')->get();
        if(count($medicexist)==0)
        {
            return redirect()->back()->with(['error'=>"Medicul nu există."]);
        }
        $cont=0;
        foreach($req->input('specializare') as $speci)
        {
            $exist = Specializari::find($speci);
            if($exist!=null)
            {
                $cont++;
            }
        }
        if(count($req->input('specializare'))!=$cont)
        {
            return redirect()->back()->with(['error'=>"O specializare selectată nu se află în baza de date."]);
        }
        $doctor=Doctori::find($req->input('id'));
        
        $doctor->id_specializari=json_encode(array_merge($req->input('specializare'),json_decode($medicexist[0]->id_specializari,true)));
        $doctor->save();
          return redirect()->back()->with(['success'=>"Specializările au fost modificate."]);
    }
    public function medicdelspeci(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'specializare'=>'required',
            'id'=>'required|numeric'
    
        ]);
        $medicexist=Doctori::where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->get();
        if(count($medicexist)==0)
        {
            return redirect()->back()->with(['error'=>"Medicul nu există."]);
        }
        $cont=0;
        foreach($req->input('specializare') as $speci)
        {
            $exist = Specializari::find($speci);
            if($exist!=null)
            {
                $cont++;
            }
        }
        if(count($req->input('specializare'))!=$cont)
        {
            return redirect()->back()->with(['error'=>"O specializare selectată nu se află în baza de date."]);
        }
        $medic=Doctori::find($req->input('id'));
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
    public function medicsetspeci(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'specializare'=>'required',
            'id'=>'required|numeric'
    
        ]);
        $medicexist=Doctori::where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->get();
        if(count($medicexist)==0)
        {
            return redirect()->back()->with(['error'=>"Medicul nu există."]);
        }
        $cont=0;
        foreach($req->input('specializare') as $speci)
        {
            $exist = Specializari::find($speci);
            if($exist!=null)
            {
                $cont++;
            }
        }
        if(count($req->input('specializare'))!=$cont)
        {
            return redirect()->back()->with(['error'=>"O specializare selectată nu se află în baza de date."]);
        }
        $medic=Doctori::find($req->input('id'));
        $medic->id_specializari=json_encode($req->input('specializare'));
        $medic->save();
         return redirect()->back()->with(['success'=>"Specializarea a fost setată."]);
    }
    public function medicsetsala(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'sala' => 'required',
            'id'=> 'required|numeric',
    
        ]);
        $exist=Doctori::where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->get();
        $existsala=Sali::where('id',$req->input('sala'))->where('id_cab',Auth::user()->id)->get();
        if(count($exist)==0)
        {
            return redirect()->back()->with('fail','Medicul nu a fost găsit în baza de date.');
        }
        else
        {
            if($req->input('sala')=="sterge")
            {
                $doctor=Doctori::find($req->input('id'));
                $doctor->id_sala=null;
                $doctor->save();
                return redirect()->back()->with('success','Cabinetul a fost sters.');
            }
            if(count($existsala)==1)
            {
                $doctor=Doctori::find($req->input('id'));
                $doctor->id_sala=$req->input('sala');
                $doctor->save();
                return redirect()->back()->with('success','Cabinetul a fost setat.');
            }
            return redirect()->back()->with('fail','Cabinetul nu exista.');
        }

    }
    public function medicimg(Request  $req)
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
        $doctor=Doctori::find($req->input('id'));
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
       $specializari = Specializari::where('id_cab', '=', Auth::user()->id)->get();
       $servicii = Servicii::where('id_cab', '=', Auth::user()->id)->get();
       $sali = Sali::where('id_cab', '=', Auth::user()->id)->orderBy('etaj','ASC')->orderBy('numar','ASC')->get();
        $medici = Doctori::where('id_cab', '=', Auth::user()->id)->get();
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
    public function delserv(Request $req)
    {
        session(['active' => 'specializari']);
        $active = session('active');
        $exist = Servicii::where('id',$req->input('id'))->where('id_cab',Auth::user()->id)->count();
        if($exist!=0)
        {
            $serv= Servicii::find($req->input('id'));
            $serv->delete();
            return redirect()->back()->with(['error'=>"Serviciul a fost sters.",'active'=>$active]);
        }
        else
        {
            return redirect()->back()->with(['error'=>"Serviciul nu există în baza de date.",'active'=>$active]);
        }
        return $req;
    }
    public function addserv(Request $req)
    {
        session(['active' => 'specializari']);
        $active = session('active');
        $this->validate($req, [

            'specializare' => 'required',
            'pret' => 'required|numeric',
            'durata' => 'required|numeric',
            'serviciu' => 'required',
    
        ]);
        $explode = explode("(*)", $req->input('specializare'));
        $id=$explode[1];
        $denumire = $req->input('serviciu');
        $serviciu = filter_var($denumire, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $existid = Specializari::where('id', '=', $id)->first();
        if($existid === null)
       {
        return redirect()->back()->with(['error'=>"Se pare ca specializarea selectată nu mai este in baza de date.",'actice'=>$active]);
       }
       else
       {
        $exist = Servicii::where('id_cab', '=', Auth::user()->id)->where('denumire',$denumire)->first();
        if ($exist === null) 
        {
        $servicii = new servicii();
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
    public function addspeci(Request $req)
    {
        session(['active' => 'specializari']);
        $active = session('active');
        $speci = filter_var($req->input("specializare"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $exist = Specializari::where('id_cab', '=', Auth::user()->id)->where('specializare',$speci)->first();
        if ($exist === null) 
        {
        $specializare = new specializari();
        $specializare->id_cab=Auth::user()->id;
        $specializare->specializare=$req->input('specializare');
        $specializare->save();
        return redirect()->back()->with(['success'=>"Specializarea: $speci a fost adăugată în baza de date.",'active'=>$active]);
        }
        else 
        {
            return redirect()->back()->with(['error'=>"Specializarea: $speci există în baza de date.",'active'=>$active]);
        }
    }
    public function delspeci(Request $req)
    {
        session(['active' => 'specializari']);
        $active = session('active');
        $id=$req->input('id');
        $exist = Specializari::where('id_cab', '=', Auth::user()->id)->where('id',$id)->first();
        if ($exist != null) 
        {
            $spec = Specializari::find($id);
            $spec->delete();
            Servicii::where('id_cab', '=', Auth::user()->id)->where('id_specializare',$id)->delete();
            $medici = Doctori::where('id_cab',Auth::user()->id)->where('id_specializari','!=','null')->get();
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
                    $me = Doctori::find($medic->id);
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
        /*Nexmo::message()->send([
            'to'   => '40725912720',
            'from' => 'Stomatime',
            'text' => 'Pentru confirmarea programarii foloseste codul: 6611512'
        ]);*/
        return view('cabinet');
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
    public function editprofile(Request $req)
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
    public function setprofile(Request $request)
    { 
        $this->validate($request, [

            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    
        ]);

        $factory = new \ImageOptimizer\OptimizerFactory();
        $optimizer = $factory->get();
        $path= $request->file('profile')->store('/public/cabinete');
        $optimizer->optimize('/var/www/html/stomatime/storage/app/'.$path);
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
    public function setpublicprofile(Request $request)
    {
        $validate = $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'numar' => 'required|numeric',
            'program' => 'required',
        ]);
        $cab = Auth::user();
        $cab->descriere=htmlspecialchars($request->input('descriere'));
        $cab->adresa=$request->input('adresa');
        $cab->moto=htmlspecialchars($request->input('slogan'));
        $cab->lat=$request->input('lat');
        $cab->long=$request->input('long');
        $cab->numar=$request->input('numar');
        $cab->program=json_encode($request->input('program'));
        $cab->save();
        return redirect()->back()->with(['success'=>"Profilul a fost actualizat."]);
    }
    public function addsala(Request $req)
    {
        session(['active' => 'cabinet']);
        $active = session('active');
        $validate = $req->validate([
            'cabinet' => 'required|numeric',
            'etaj' => 'required|numeric',
        ]);
        $exist = Sali::where('id_cab', Auth::user()->id)->where('numar',$req->input('cabinet'))->where('etaj',$req->input('etaj'))->get(); 
        if (count($exist) == 0) 
        {
            $sala = new sali();
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
    public function delsala(Request $req)
    {
        session(['active' => 'cabinet']);
        $active = session('active');
        $validate = $req->validate([
            'id' => 'required|numeric',
        ]);
        $exist = Sali::where('id_cab', Auth::user()->id)->where('id',$req->input('id'))->get(); 
        if (count($exist) == 0) 
        {
            return redirect()->back()->with(['error'=>"Cabinetul nu există in baza de date.",'active'=>'specializari']);
        }
        else
        {
            $spec = Sali::find($req->input('id'));
            $spec->delete(); 
            Doctori::where('id_sala',$req->input('id'))
                    ->update(['id_sala'=> null]);
                    return redirect()->back()->with(['error'=>"Cabinetul a fost sters.",'active'=>$active]);
        }


    }
    public function addmedic(Request $req)
    {
        session(['active' => 'doctor']);
        $this->validate($req, [

            'profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nume' => 'required|string|max:35',
            'prenume' => 'required|string|max:35',
            'descriere' => 'required|string|max:255',
            'disponibilitate' => 'required|numeric',
            'sala' => 'numeric',
            'specializare'=>'string',
            'gen'=>'required|string|max:1',
    
        ]);
        if($req->input('specializare')!=null)
        {
        $cont=0;
            foreach($req->input('specializare') as $speci)
            {
                $exist = Specializari::find($speci);
                if($exist!=null)
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
            $existsala=Sali::find($req->input('sala'));
            if($existsala==null)
            {
                return redirect()->back()->with(['error'=>"Sala introdusă nu există."]);
            }
        }
         $doctor = new doctori;
        if($req->input('profile')!=null)
        {
        $factory = new \ImageOptimizer\OptimizerFactory();
        $optimizer = $factory->get();
        $path= $req->file('profile')->store("/public/medici/".Auth::user()->id);
        $optimizer->optimize('/var/www/html/stomatime/storage/app/'.$path);
        $doctor->img_profile=Storage::url($path);
        }
        $doctor->nume=$req->input('nume');
        $doctor->prenume=$req->input('prenume');
        $doctor->descriere=$req->input('descriere');
       
        $doctor->frecventa=$req->input('disponibilitate');
        $doctor->gen=$req->input('gen');
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cabinet;
use App\Doctori;
use App\Sali;
use App\Specializari;
use App\Servicii;
use App\StarsCabs;
use App\StarsMedic;
use App\Programari;
use DB;
use Auth;
class API extends Controller
{
    public function getCabinete($option=null)
    {
        if($option=="main")
        {
            $count = Cabinet::count();
            if($count==0)
            {
                $data=[];
                return $data;
            }
            else
            {
                $cabinete = Cabinet::orderBy(DB::raw('RAND()'))->select(['descriere','id','img_profile','moto','name','adresa','numar'])->where('verified',1)->where('adresa',"!=",null)->where('type','>',0)->where('public',1)->take(4)->get();
                foreach ($cabinete as $contor=>$cabinet)
                {
                    $cincistele = StarsCabs::where('id_cab',$cabinet->id)->where('scor',5)->count();
                    $patrustele = StarsCabs::where('id_cab',$cabinet->id)->where('scor',4)->count();
                    $treistele = StarsCabs::where('id_cab',$cabinet->id)->where('scor',3)->count();
                    $douastele = StarsCabs::where('id_cab',$cabinet->id)->where('scor',2)->count();
                    $ostea = StarsCabs::where('id_cab',$cabinet->id)->where('scor',1)->count();
                    if(($cincistele+$patrustele+$treistele+$douastele+$ostea)>0)
                    {
                        $scorfinal = (5*$cincistele + 4*$patrustele + 3*$treistele + 2*$douastele + $ostea)/($cincistele+$patrustele+$treistele+$douastele+$ostea);
                    }
                    else
                    {
                        $scorfinal=0;
                    }
                    $cabinete[$contor]["stele"]=$scorfinal;
                    $cabinete[$contor]["voturi"]=($cincistele+$patrustele+$treistele+$douastele+$ostea);

                }
                return $cabinete;
            }
        }
        elseif(filter_var($option, FILTER_VALIDATE_INT))
        {
            if(Auth::guard('web')->check())
            if(Cabinet::where('id',$option)->exists())
            {
            $cabinete = Cabinet::select(['id','descriere','img_profile','moto','name','adresa','numar','program','email','long','lat'])->where('verified',1)->where('id',$option)->get();
                foreach($cabinete as $index=>$cabinet)
                {

                    if($cabinet->program!=null)
                    {
                       $cabinet['program']=json_decode($cabinet->program);
                    }
                    else{
                        $cabinet['program']=[];
                    }
                    $cabinet['doctori']= DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id_cab',$cabinet->id)->get();
                   
                    $cdoctori=0;
                    foreach(($cabinet['doctori']) as $c=>$doctor)
                    { 
                        
                        
                        $scorfinal=0;
                        $voturi=0;
                        if(DB::connection('stomatime_'.Auth::user()->id)->table('starMedic')->where('id_cab',$cabinet->id)->where('id_medic',$doctor->id)->exists())
                        {
                            $cincistele = DB::connection('stomatime_'.Auth::user()->id)->table('starMedic')->where('id_cab',$cabinet->id)->where('id_medic',$doctor->id)->where('scor',5)->count();
                            $patrustele = DB::connection('stomatime_'.Auth::user()->id)->table('starMedic')->where('id_cab',$cabinet->id)->where('id_medic',$doctor->id)->where('scor',4)->count();
                            $treistele = DB::connection('stomatime_'.Auth::user()->id)->table('starMedic')->where('id_cab',$cabinet->id)->where('id_medic',$doctor->id)->where('scor',3)->count();
                            $douastele = DB::connection('stomatime_'.Auth::user()->id)->table('starMedic')->where('id_cab',$cabinet->id)->where('id_medic',$doctor->id)->where('scor',2)->count();
                            $ostea = DB::connection('stomatime_'.Auth::user()->id)->table('starMedic')->where('id_cab',$cabinet->id)->where('id_medic',$doctor->id)->where('scor',1)->count();
                            if(($cincistele+$patrustele+$treistele+$douastele+$ostea)>0)
                            {
                                $scorfinal = (5*$cincistele + 4*$patrustele + 3*$treistele + 2*$douastele + $ostea)/($cincistele+$patrustele+$treistele+$douastele+$ostea);
                                $voturi=($cincistele+$patrustele+$treistele+$douastele+$ostea);
                            }
                        }
                        $doctor->stele= (string)$scorfinal;
                        $doctor->voturi= (string)$voturi;
                        if(count(json_decode($doctor->id_specializari))>0)
                        {
                                $specializariarray=[];
                                foreach (json_decode($doctor->id_specializari) as $cc=>$idspec)
                                {
                                    $specializariarray[$cc]= DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id_cab',$cabinet->id)->where('id',$idspec)->get();
                                }
                           $doctor->specializari= $specializariarray;
                        }
                        else
                        {
                            $doctor->specializari= [];
                        }
                        $doctor->orar=json_decode($doctor->orar);
                        unset($doctor->id_specializari);
                        $doctor->sala=DB::connection('stomatime_'.Auth::user()->id)->table('sali')->where('id_cab',$cabinet->id)->where("id",$doctor->id_sala)->get();
                        $cabinet['doctori'][$c]=$doctor;
                        $cdoctori=$cdoctori+1;
                    }
                    $cabinet['specializari']= DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id_cab',$cabinet->id)->get();
                    $countspeci=0;
                    $stea = StarsCabs::select(['scor'])->where('id_client',Auth::guard('web')->user()->id)->where('id_cab',$option)->get();
                    if(sizeof($stea)===0)
                    {
                        $stea=0;
                    }
                    else
                    {
                        $stea=$stea[0]->scor;
                    }
                    $cabinete[$index]['scor']=$stea;
                    foreach($cabinet['specializari'] as $contor=>$specializare)
                    {
                        $specializare->servicii=DB::connection('stomatime_'.Auth::user()->id)->table('servicii')->where('id_cab',$cabinet->id)->where('id_specializare',$specializare->id)->get();
                        $cabinet['specializari'][$contor]=$specializare;
                        $countspeci++;
                    }  
                    $cabinete[$index]['countspecializari']=$countspeci;
                    $cabinete[$index]['countdoctori']=$cdoctori;
                    $cabinete[$index]=$cabinet;
                }
            return $cabinete;
            }
            else
            {
                return "Nu exista acest cabinet.";
            }
            else{
                return "Nu esti logat.";
            }
        }
        elseif($option==null)
        {
            $cabinete = Cabinet::orderBy(DB::raw('RAND()'))->select(['id','name','img_profile','judet','adresa','moto','descriere'])->where('verified',1)->where('type','>',0)->where('public',1)->get();
            foreach ($cabinete as $contor=>$cabinet)
            {
                $cincistele = StarsCabs::where('id_cab',$cabinet->id)->where('scor',5)->count();
                $patrustele = StarsCabs::where('id_cab',$cabinet->id)->where('scor',4)->count();
                $treistele = StarsCabs::where('id_cab',$cabinet->id)->where('scor',3)->count();
                $douastele = StarsCabs::where('id_cab',$cabinet->id)->where('scor',2)->count();
                $ostea = StarsCabs::where('id_cab',$cabinet->id)->where('scor',1)->count();
                if(($cincistele+$patrustele+$treistele+$douastele+$ostea)>0)
                {
                    $scorfinal = (5*$cincistele + 4*$patrustele + 3*$treistele + 2*$douastele + $ostea)/($cincistele+$patrustele+$treistele+$douastele+$ostea);
                }
                else
                {
                    $scorfinal=0;
                }
                $cabinete[$contor]['stele']=$scorfinal;
                $cabinete[$contor]['voturi']=($cincistele+$patrustele+$treistele+$douastele+$ostea);
            }
            return $cabinete;
        }
        else
        {
            return "Invalid";
        }
     
    }
    public function getSpecializari($id)
    {
        if(Auth::guard('web')->check())
        if(Cabinet::where('id',$id)->exists())
        {
            $cabinete = Cabinet::where('verified',1)->where('id',$id)->where('public',1)->where('type','>',0)->get();
            $specializari=[];
            foreach($cabinete as $index=>$cabinet) {
                $specializari = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id_cab', $cabinet->id)->get();
                foreach ($specializari as $contor => $specializare) {
                    $specializare->servicii = DB::connection('stomatime_'.Auth::user()->id)->table('servicii')->where('id_cab', $cabinet->id)->where("id_specializare", $specializare->id)->get();
                    $specializari[$contor] = $specializare;
                }
            }
            return json_decode($specializari);
        }
        else
        {
            return "Nu exista acest cabinet.";
        }
        else{
            return "Nu esti logat.";
        }
    }
    public function getMedic($id_cab,$id_medic)
    {
        if(Auth::guard('web')->check())
        {
            $exists =DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id_cab',$id_cab)->where('id',$id_medic)->exists();
            if($exists)
            {
                
              $doctor = DB::connection('stomatime_'.Auth::user()->id)->table('doctori')->where('id_cab',$id_cab)->where('id',$id_medic)->get();
               
              foreach($doctor as $index=>$det)
              {
                  $doctor[$index]->orar= json_decode($det->orar,true);
                  $doctor[$index]->sala=DB::connection('stomatime_'.Auth::user()->id)->table('sali')->where('id_cab',$id_cab)->where("id",$det->id_sala)->get();
                  $scor=0;
                  if(DB::connection('stomatime_'.Auth::user()->id)->table('starMedic')->where('id_cab',$id_cab)->where('id_medic',$id_medic)->where('id_client',Auth::user()->id)->exists())
                    {
                        $scor=DB::connection('stomatime_'.Auth::user()->id)->table('starMedic')->where('id_cab',$id_cab)->where('id_medic',$id_medic)->where('id_client',Auth::user()->id)->get();
                        $scor=$scor[0]->scor;
                    }
                    $doctor[$index]->scor= $scor;
                  if(count(json_decode($det->id_specializari))>0)
                  {
                          $specializariarray=[];
                          foreach (json_decode($det->id_specializari) as $cc=>$idspec)
                          {
                              $specializariarray[$cc]= DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id_cab',$id_cab)->where('id',$idspec)->get();
                          }
                     $doctor[$index]->specializari= $specializariarray;
                     unset($doctor[$index]->id_specializari);
                  }
                  else
                  {
                    unset($doctor[$index]['id_specializari']);
                      $doctor[$index]->specializari= [];
                  }
              }
              return $doctor;
            }
            else
            {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back();
        }
    }
    
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cabinet;
use App\Doctori;
use App\Sali;
use App\Specializari;
use App\Servicii;
use App\StarsCabs;
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
                $cabinete = Cabinet::orderBy(DB::raw('RAND()'))->select(['descriere','id','img_profile','moto','name','adresa','numar'])->where('verified',1)->where('adresa',"!=",null)->where('type','>',0)->where('public',1)->take(3)->get();
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
                       $cabinet["program"]=json_decode($cabinet->program);
                    }
                    else{
                        $cabinet["program"]=[];
                    }
                    $cabinet["doctori"]= Doctori::where('id_cab',$cabinet->id)->get();
                    $cdoctori=0;
                    foreach($cabinet["doctori"] as $c=>$doctor)
                    {
                        if(count(json_decode($doctor["id_specializari"]))>0)
                        {
                                $specializariarray=[];
                                foreach (json_decode($doctor["id_specializari"]) as $cc=>$idspec)
                                {
                                    $specializariarray[$cc]= Specializari::where('id_cab',$cabinet->id)->where('id',$idspec)->get();
                                }
                           $doctor["specializari"]= $specializariarray;
                        }
                        else
                        {
                            $doctor["specializari"]= [];
                        }
                        $doctor["orar"]=json_decode($doctor->orar);
                        unset($doctor["id_specializari"]);
                        $doctor["sala"]=Sali::where('id_cab',$cabinet->id)->where("id",$doctor->id_sala)->get();
                        $cabinet["doctori"][$c]=$doctor;
                        $cdoctori=$cdoctori+1;
                    }
                    $cabinet["specializari"]= Specializari::where('id_cab',$cabinet->id)->get();
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
                        $specializare['servicii']=Servicii::where('id_cab',$cabinet->id)->where('id_specializare',$specializare->id)->get();
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
                $cabinete[$contor]["stele"]=$scorfinal;
                $cabinete[$contor]["voturi"]=($cincistele+$patrustele+$treistele+$douastele+$ostea);
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
        if(Cabinet::where('id',$id)->exists())
        {
            $cabinete = Cabinet::where('verified',1)->where('id',$id)->where('public',1)->where('type','>',0)->get();
            $specializari=[];
            foreach($cabinete as $index=>$cabinet) {
                $specializari = Specializari::where('id_cab', $cabinet->id)->get();
                foreach ($specializari as $contor => $specializare) {
                    $specializare['servicii'] = Servicii::where('id_cab', $cabinet->id)->where("id_specializare", $specializare->id)->get();
                    $specializari[$contor] = $specializare;
                }
            }
            return json_decode($specializari);
        }
        else
        {
            return "Nu exista acest cabinet.";
        }
    }
}

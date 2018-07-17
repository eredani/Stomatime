<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cabinet;
use App\Doctori;
use App\Sali;
use App\Specializari;
use App\Servicii;
use DB;
class API extends Controller
{
    public function getcabinete($option=null)
    {
        if($option=="main")
        {
            $count = Cabinet::count();
            if($count==0)
            {
                return null;
            }
            else
            {         
                $data = Cabinet::orderBy(DB::raw('RAND()'))->select(['descriere','img_profile','moto','name','adresa','numar'])->where('verified',1)->where('adresa',"!=",null)->where('type','>',0)->take(3)->get();
                return $data;
            }
        }
        elseif(filter_var($option, FILTER_VALIDATE_INT))
        {
            if(Cabinet::where('id',$option)->exists())
            {
            $cabinete = Cabinet::select(['id','descriere','img_profile','moto','name','adresa','numar','program','email'])->where('verified',1)->where('id',$option)->get();    
                foreach($cabinete as $index=>$cabinet)
                {
                    if($cabinet->program!=null)
                    {
                       $cabinet["program"]=json_decode($cabinet->program);
                    }
                    $cabinet["doctori"]= Doctori::where('id_cab',$cabinet->id)->get();
                    $cdoctori=0;
                    foreach($cabinet["doctori"] as $c=>$doctor)
                    {
                        if($doctor["id_specializari"]!=null)
                        {
                            $doctor["specializari"]= Specializari::where('id_cab',$cabinet->id)->get();
                            $doctor["orar"]=json_decode($doctor->orar);
                            unset($doctor["id_specializari"]);  
                        }         
                        
                        $doctor["sala"]=Sali::where('id_cab',$cabinet->id)->where("id",$doctor->id_sala)->get();
                        $cabinet["doctori"][$c]=$doctor;
                        $cdoctori=$cdoctori+1;
                    }
                   
                   
                    $cabinet["specializari"]= Specializari::where('id_cab',$cabinet->id)->get();
                    $countspeci=0;
                    foreach($cabinet["specializari"] as $contor=>$specializare)
                    {
                        $specializare["servicii"]=Servicii::where('id_cab',$cabinet->id)->where("id_specializare",$specializare->id)->get();
                        $cabinet["specializari"][$contor]=$specializare;
                        $countspeci++;
                    }  
                    $cabinete[$index]["countspecializari"]=$countspeci;
                    $cabinete[$index]["countdoctori"]=$cdoctori;
                    $cabinete[$index]=$cabinet;
                }
            return $cabinete;
            }
            else
            {
                return "Nu exista acest cabinet.";
            }
           
        }
        elseif($option==null)
        {
            $data = Cabinet::orderBy(DB::raw('RAND()'))->where('verified',1)->where('type','>=',0)->get();
            return $data; 
        }
        else
        {
            return "Invalid";
        }
     
    }
    public function getspecializari($id,$option=null)
    {

    }
}

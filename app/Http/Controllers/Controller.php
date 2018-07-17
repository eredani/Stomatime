<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Seo;
use App\Cabinet;
use DB;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {

        Seo::set('global-title', 'Stomatime');
        Seo::set('global-description', 'Stomatime este o platforma online pentru toate cabinetele din Romania, dar si pentru pacientii acestora. Stomatime cuprinde mai multe stomatologii unde un client isi poate face un cont pe platforma, iar la randul lui isi poate face o rezervare la orice cabinet este afiliat cu noi. Pacientii isi pot vedea istoricul programarilor, pot schimba o programare foarte usor fara.');
    
        Seo::set('logo-url', 'http://stomatime.com/favicon.ico');
        Seo::set('latitude', 48.8256);
        Seo::set('longitude', 2.3258);
    
        Seo::set('email', 'organization email');
        Seo::set('phone', '+40725912720');
        Seo::set('opening-hours', 'Mo,Tu,We,Th,Fr 09:00-20:00');
        Seo::set('street-address', '');
        Seo::set('address-locality', 'Romania');
        Seo::set('address-region', '');
        Seo::set('address-country', 'RO');
        Seo::set('postal-code', '75008');
        Seo::set('area-served', 'RO');
    
        Seo::setSimilarTo('https://www.facebook.com/stomatime');
        Seo::setSimilarTo('https://twitter.com/stomatime');
    
        Seo::setContactPoint([
            'type' => 'text',
            'phone' => '+40725912720',
            'area-served' => 'RO',
            'opening-hours' => 'Mo,Tu,We,Th,Fr 09:00-20:00',
            'available-languages' => ['Romania']
        ]);
    
        Seo::set('og-locale', 'ro_RO');
        Seo::set('og-image-url', 'http://stomatime.com/favicon.ico');
        Seo::set('og-image-type', 'image/ico');
        Seo::set('og-image-width', 1200);
        Seo::set('og-image-height', 630);
    
        Seo::set('fb-app-id', 'My facebook app ID');
        Seo::set('twitter-sign', '@My_Twitter_Account');
        Seo::set('title', 'Stomatime');
          Seo::set('description', "Stomatime este o platforma online pentru toate cabinetele din Romania, dar si pentru pacientii acestora. Stomatime cuprinde mai multe stomatologii unde un client isi poate face un cont pe platforma, iar la randul lui isi poate face o rezervare la orice cabinet este afiliat cu noi. Pacientii isi pot vedea istoricul programarilor, pot schimba o programare foarte usor fara.");
          Seo::set('keywords', "dentisti,stomatologie,cabinet,doctori,dentar,stomatologie,dinti,stomatologic,soft gestiune cabinete, aplicatie stomatologie, gestiune pacienti, soft medical, soft cabinet stomatologic, medicina dentara, stoma Bucuresti, clinici, soft gestiune clinici, software");
          Seo::set('breadcrumblist', [
            ['title' => 'Page short title', 'url' => 'Stomatime'],
            ['title' => 'Sub-Page short title', 'url' => 'Stomatime'],
        ]);	

            return view('welcome');
       
    }

}

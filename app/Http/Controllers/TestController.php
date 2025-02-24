<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {  
 

        $array_prov = Config::get('ids_remotos_prov.array_prov');
        $array_gpstools = Config::get('ids_remotos_gpstools.array_gpstools');
 


        $no_coinciden_a = [];
        $no_coinciden_b = [];

        foreach ($array_prov as $valor_a) {
            if (!in_array($valor_a, $array_gpstools)) {
                $no_coinciden_a[] = $valor_a;
            }
        }

        foreach ($array_gpstools as $valor_b) {
            if (!in_array($valor_b, $array_prov)) {
                $no_coinciden_b[] = $valor_b;
            }
        }

        return [
            'no_coinciden_a' => $no_coinciden_a,
            'no_coinciden_b' => $no_coinciden_b
        ];
       



    }
    

}

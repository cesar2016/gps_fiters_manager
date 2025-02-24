<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class FormaterController extends Controller
{
    //

    public function formater(Request $request)
    {         

        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['msg' => 'Ups!, El archivo no tienen extension .csv  / '.$validator->errors()]);
    
        }
        

        if ($request->hasFile('csv_file')) {

            $archivo = $request->file('csv_file');
            $nombreOriginal = $archivo->getClientOriginalName();

           

            $file = $request->file('csv_file');
            $filePath = $file->getRealPath();
    
            $data = []; // Inicializamos un array para almacenar los datos
    
            if (($handle = fopen($filePath, "r")) !== false) {
                // Saltar la primera fila si contiene encabezados
                fgetcsv($handle);
    
                while (($row = fgetcsv($handle)) !== false) {
                    // Agregar cada fila como un elemento del array
                    $data[] = $row;                    

                }
                fclose($handle);
            }         

            return $this->compare_filters($data);
                

        } else {
            return response()->json(['error' => 'No se ha subido ningún archivo'], 400);
        }
    }


    function defineCluster($country) {               
             

        $cluster_and = ["ecuador", "chile", "peru"];
        $cluster_cen = ["elsalvador", 'salvador, "nicaragua", "guatemala", "costarica"'];
        $cluster_dom = ["dominicana"];
        $cluster_cen_HN = ["default", "honduras"];        
        

        if (in_array($country, $cluster_and)) {                
            return 'and';
        }
        if (in_array($country, $cluster_cen)) {
            return 'cen';
        }
        if (in_array($country, $cluster_dom)) {
            return 'dom';
        }
        if (in_array($country, $cluster_cen_HN)) {
            return 'cen_hn';
        }


    }

    // FUncion para estandarizar los string
    function normalizeString($string) {
        // Convertir a minúsculas
        $stringMinuscula = strtolower($string);
    
        // Eliminar espacios en blanco
        $stringSinEspacios = str_replace(' ', '', $stringMinuscula);
    
        return $stringSinEspacios;
    }


    public function compare_filters($filters){
        
        
        $comparations = [];    
         
        for ($i= 0; $i < count($filters) ; $i++) { 
            
            $e = 0;
            $cluster = $this->defineCluster( $this->normalizeString($filters[$e][0]) ); 
            $pais = $this->normalizeString( $filters[$i][0] );  
            
           
            if( $cluster == 'cen_hn')
                return $this-> compare_HN($filters);

            if( $cluster == 'and')
                $url_api = "https://aws-us-east-2-andina-cvideo-mfw-ott-uat.clarovideo.net/services/epg/version_config?device_type=ott&device_category=web&device_model=web&device_manufacturer=generic&authpn=amco&authpt=12e4i8l6a581a&region=".strtolower($pais)."&api_version=5.93";

            if( $cluster == 'cen')
                $url_api="https://aws-us-east-2-cnampa-cvideo-mfw-ott-uat.clarovideo.net/services/epg/version_config?authpn=amco&authpt=12e4i8l6a581a&region=".strtolower($pais)."&device_category=web&device_manufacturer=generic&device_model=web&device_type=ott&api_version=5.93";

            if( $cluster == 'dom')
                $url_api = "https://aws-us-east-2-dom-cvideo-mfw-ott-uat.clarovideo.net/services/epg/version_config?device_type=ott&device_category=web&device_model=web&device_manufacturer=generic&authpn=amco&authpt=12e4i8l6a581a&region=dominicana&api_version=5.93";

            
            $response = Http::get($url_api);

            // Obtener el cuerpo de la respuesta como un objeto JSON
            $data = $response->json();


            $validateOtt = $data['response']['OTT'] == $filters[$i][1] ? '' : 'bg-danger text-white';
            $validateNagra = $data['response']['NAGRA'] == $filters[$i][2] ? '' : 'bg-danger text-white';
            $validateROKU = $data['response']['ROKU'] == $filters[$i][3] ? '' : 'bg-danger text-white';
            $validateIPTV = $data['response']['IPTV'] == $filters[$i][4] ? '' : 'bg-danger text-white';
            $validateIPTV4K = $data['response']['IPTV4K'] == $filters[$i][5] ? '' : 'bg-danger text-white';

            array_push(
                
                $comparations, 
                 [ strtoupper($filters[$i][0]) => [

                        'OTT' => $data['response']['OTT'].','.$filters[$i][1].','.$validateOtt,
                        'NAGRA' => $data['response']['NAGRA'].','.$filters[$i][2].','.$validateNagra,
                        'ROKU' => $data['response']['ROKU'] .','.$filters[$i][3].','.$validateROKU,
                        'IPTV' => $data['response']['IPTV'] .','.$filters[$i][4].','.$validateIPTV,
                        'IPTV4K' => $data['response']['IPTV4K'].','.$filters[$i][5].','.$validateIPTV4K
                    ]    
                 ]
            
            );

           
            
        }

        //return response()->json($comparations);

        return view(

            'table_data', ['comparations' => $comparations, 'type_zona' => 'PAIS', 'cluster' => strtoupper($cluster) ],            
        
        );

    }

    public function compare_HN($filters)
    
    {
        $comparations = [];         

        for ($i= -1; $i < 11 ; $i++) { 

            
            $zone = $i >= 0 ? $i : '';
           
            $url_api = "https://aws-us-east-2-ccam-cvideo-mfw-iptv-uat.clarovideo.net/services/epg/version_config?subregion=".$zone."&authpn=amco&authpt=12e4i8l6a581a&region=honduras&device_category=stb&device_manufacturer=ZTE&device_model=ZXV10&device_type=ptv&api_version=5.93";
            
            $response = Http::get($url_api);

            // Obtener el cuerpo de la respuesta como un objeto JSON
            $data = $response->json();


            $validateOtt = $data['response']['OTT'] == $filters[$i+1][1] ? '' : 'bg-danger text-white';
            $validateNagra = $data['response']['NAGRA'] == $filters[$i+1][2] ? '' : 'bg-danger text-white';
            $validateROKU = $data['response']['ROKU'] == $filters[$i+1][3] ? '' : 'bg-danger text-white';
            $validateIPTV = $data['response']['IPTV'] == $filters[$i+1][4] ? '' : 'bg-danger text-white';
            $validateIPTV4K = $data['response']['IPTV4K'] == $filters[$i+1][5] ? '' : 'bg-danger text-white';

            $zoneKey = $i >= 0 ? $i : 'default';
            array_push(
                
                $comparations, 
                 [ 'ZONA_'.$zoneKey => [

                        'OTT' => $data['response']['OTT'].','.$filters[$i+1][1].','.$validateOtt,
                        'NAGRA' => $data['response']['NAGRA'].','.$filters[$i+1][2].','.$validateNagra,
                        'ROKU' => $data['response']['ROKU'] .','.$filters[$i+1][3].','.$validateROKU,
                        'IPTV' => $data['response']['IPTV'] .','.$filters[$i+1][4].','.$validateIPTV,
                        'IPTV4K' => $data['response']['IPTV4K'].','.$filters[$i+1][5].','.$validateIPTV4K
                    ]    
                 ]
            
            );

           
            
        }

        return view(

            'table_data', ['comparations' => $comparations, 'type_zona' => 'ZONA', 'cluster' => strtoupper('CEN')],            
        
        );

    }

    public function testing(Request $request)
    {  

        return response()->json(['error' => 'Testing Web-Dev_Cesar2024'], 200);

    }
    


}


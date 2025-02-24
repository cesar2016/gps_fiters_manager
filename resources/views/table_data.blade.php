<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

        <!-- Styles / Scripts -->
         
        
    </head>
    <body class="bg-gray-50 ">
         
            <div class="container flex flex-col items-center justify-center">     
                @if (@$comparations)
                <div class="content">
                    <table class="table table-striped table-bordered">
                        <thead class="table-bordered thead-dark">
                            <tr align="center">
                                <th  colspan="1" class="text-warning" >{{ $cluster }}</th>
                                <th  colspan="2" >OTT</th>
                                <th  colspan="2" >NAGRA</th>
                                <th  colspan="2" >ROKU</th>
                                <th  colspan="2" >IPTV</th>
                                <th  colspan="2" >IPTV4K</th>
                            </tr>
                            <tr  align="center">
                                <th  scope="col" >{{ $type_zona }}</th>
                                <th  scope="col" >Exc</th>
                                <th  scope="col" >API</th>
                                <th  scope="col" >Exc</th>
                                <th  scope="col" >API</th>
                                <th  scope="col" >Exc</th>
                                <th  scope="col" >API</th>
                                <th  scope="col" >Exc</th>
                                <th  scope="col" >API</th>
                                <th  scope="col" >Exc</th>                                    
                                <th  scope="col" >API</th>
                            </tr>
                        </thead>
                        <tbody  align="center">
                            @foreach ($comparations as $zoneData)

                            @php
                                $name_zone = str_replace('ZONA_', '', array_keys($zoneData)[0]) == 'default' ? 'default ( HN )' 
                                : str_replace('ZONA_', '', array_keys($zoneData)[0]);
                            @endphp
                             
                                <tr>
                                    <td scope="col" > {{ 

                                        $name_zone;
                                        
                                        }}</td>
                                    @foreach ($zoneData as $zone => $platformData)
                                        
                                            @foreach ($platformData as $platform => $value)

                                            @php
                                                $delimiter = ",";
                                                $text = explode($delimiter, $value);
                                            @endphp
                                                <td class="{{ $text[2] }}">
                                                    
                                                        <span class="">{{$text[1] }}</span>                                                       
                                                    
                                                </td>
                                                <td class="{{ $text[2] }}">
                                                    
                                                    <span class="">{{ $text[0] }}</span>                                              
                                                    
                                                </td>
                                            @endforeach
                                        
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                      
                @endif 
                 
            </div>
        </div>
    </body>
 
</html>

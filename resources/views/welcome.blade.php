<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

        <title>QA_Rotaciones</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
     
        
    </head>
    <body class="bg-gray-50 ">
        <div class="content jumbotron">
            
            
            <div class="container flex flex-col items-center justify-center">  

                <div class="alert alert border-dark"> 
                    <form method="POST" id="upload_file" enctype="multipart/form-data"> 
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Buscar CSV</label>
                            @csrf
                            <input type="file" name="csv_file" class="form-control-file" id="exampleFormControlFile1">
                            
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Importar ..</button>
                    </form>
                </div>   

                <div hidden=true id="alert_error" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> <span id="msg_error_server" ></span>
                    <button type="button" id="close" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <hr>
        
                    <p class="fw-bold">PASOS para crear el archivos CSV para subir</p> 
                    <p class="fs-6">
                        <ul>
                            <li> 1- Seleccionar y copiar completo tal cual el cuadro de valores del SIC </li>
                            <li> 2- Pegar en drive, excelSheet, etc </li>
                            <li> 3- Guardar en formato .CSV                             
                            <li> 4- Subir y esperar que finalice el proseso de carga </li>
                        </ul>
                    </p>

            </div>                
            
            <div class="content" id="view_table"></div>

            
            
        </div>

        

        <!-- MOdales -->
        <div class="modal
            fade" id="loader" tabindex="-1" aria-labelledby="modalLoaderLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLoaderLabel1">Consultando apis de epg </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="spinner-border
                    text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                    </div> 

                    <p>Por favor espere ...</p>
                </div>
            </div>
        </div>        

         
    </body> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('my_js/functions.js') }}"></script>
    <script>
        $('.close').click(function () {
            $("#alert_error").alert('close')
        });
    </script>
</html>

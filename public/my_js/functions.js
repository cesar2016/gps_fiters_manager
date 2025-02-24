$(function () {
     
    var URI = window.location.origin;

    $('#alert_error').hide();

    $(document).submit('#upload_file',function(e){

        e.preventDefault();

        
        getData()     

        function getData(){

            $('#loader').modal('show');
            //const datos_products = $("#form-new-product").serialize();   

            var file_hn = new FormData(document.getElementById("upload_file"));

            $.ajax({
                type: "POST",
                url:  URI+'/formater',   
                data: file_hn,
                contentType: false,
                processData: false,
                success: function(response) {

                    console.log(response.msg);
                    
                    if(response.msg){

                        $("#msg_error_server").html(response.msg)
                        $("#alert_error").attr('hidden', false)
                        $("#alert_error").show()
                         
                    }else{

                        $('#view_table').html(response)
                        $('#loader').modal('hide');
                    }
                    
                    $('#loader').modal('hide');
                    

                },
                error: function(error) {      

                    $("#msg_error_server").html(error)
                    $("#alert_error").attr('hidden', false)
                    $("#alert_error").show()
                    $('#loader').modal('hide');

                }
            });

            $('#loader').modal('hide');


        }

        
        


    })


})
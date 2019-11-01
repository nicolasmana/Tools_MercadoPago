<?php

//Permitimos cualquier lugar 
header('Access-Control-Allow-Origin: *'); 
//Le decimos los métodos (POST, GET, PUT, DELETE...) 
header('Access-Control-Allow-Methods: GET, POST');   
//Indicamos el formato de salida, lo más normal JSON 
header('Content-Type: application/json'); 
header('Accept-Language: application/json'); 


  //$data = json_decode( file_get_contents( 'php://input' ), true );

  $fichero = 'log.txt';
  // Abre el fichero para obtener el contenido existente
  $actual = file_get_contents($fichero);
  // Añade una nueva persona al fichero
  
  $resul = json_decode( file_get_contents( 'php://input' ), true );
  
    $info = PHP_EOL.date("F j, Y, g:i a")." - Topic: ".$resul['topic']." - Id: ".$resul['id'].".";
        
        // Escribe el contenido al fichero
        //Para fines prácticos del ejemplo, solamente se guardarán las notificaciones en un log. Más info de notificaciones en: https://www.mercadopago.cl/developers/es/api-docs/basic-checkout/ipn/
     file_put_contents($fichero, $info, FILE_APPEND);
     
  
  

//$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
  //         "Descripcion: OPTIONS".PHP_EOL.
    //       "-------------------------".PHP_EOL;
   //file_put_contents('./Logs/API_POST_PAYMENT/log_options_'.date("j.n.Y").'.txt', $log, FILE_APPEND);




?>


<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

ok

</body>
</html>

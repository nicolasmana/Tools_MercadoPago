<?php

//Por cuestiones prácticas este ejemplo se realizó con un usuario de Argentina, en los comentarios irán encontrando las modificaciones para cada país.
//The following example was made with an Argentinian user for practical reasons. In the comments below you´ll find the information for every country.
//MLA=Argentina
//MLC=Chile
//MLU=Uruguay
//MCO=Colombia
//MLB=Brasil
//MPE=Perú
//MLM=México

//Accedemos al archivo con el SDK para poder trabajar / We get the MP SDK so we can start working
//SDK info: https://www.mercadopago.com.ar/developers/es/plugins_sdks/
require_once ('lib/mercadopago.php');

//Primero vamos a definir las credenciales de nuestra cuenta de MP / First we are going to set our MP credentials.
//Credentials in:https://www.mercadopago.com/mla/account/credentials
$mp = new MP ("TEST-503998113953746-102911-b3d1303a58daeeb44a215bb846b0518f-371925775");
//¡¡¡Recuerda que también hay que modificar la public_key en el html, línea 171, para probar con tu usuario!!!
//¡¡¡Remember that you also have to change the public key in the html, line 171, in order to test with your user!!!



$cuotas=(int)$_POST['installments'];


// Solamente para ARGENTINA!!! Separo el posteo dependiendo si el pago se hizo con issuer o no - ONly for Argentina!!! Depending on wether the payment was made with an specifical issuer or not.
//En Argentina ciertos bines de tarjeta comparten bancos, por lo que necesitamos que el user lo especifique para procesar el pago.
if(isset($_POST['issuers'])){
    $payment_data = array(
    "transaction_amount" => 100,
    "token" => $_POST['token'],
    "description" => "Prueba Checkout",
    "installments" => $cuotas,
    "external_reference"=>"Order_1234",
    "payment_method_id" => $_POST['paymentMethodId'],
    "issuer_id"=>$_POST['issuers'],
    "payer" => array (
     "email" => $_POST['email'])
    );
}else{
    $payment_data = array(
    "transaction_amount" => 100,
    "token" => $_POST['token'],
    "description" => "Prueba Checkout",
    "installments" => $cuotas,
    "external_reference"=>"Order_1234",
    "payment_method_id" => $_POST['paymentMethodId'],
    "payer" => array (
     "email" => $_POST['email'])
    );
};

// ¡¡¡En este ejemplo solo utilizaremos cierta info del payer, pero mientras mas información nos envíen mejor trabajará nuestro scoreo de fraude y mejor será la aprobación!!!!
// Ejemplo en la última parte de: https://www.mercadopago.com.ar/developers/es/guides/payments/api/receiving-payment-by-card/


$payment = $mp->post("/v1/payments", $payment_data);
// var_dump ($payment);

// Tomo ciuertos datos para mostrarlos en la respuesta
$id_pago=$payment['response']['id'];
$id_interno=$payment['response']['external_reference'];
$estado=$payment['response']['status'];



 ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/appIcons.ico">

    <title>Ejemplo de Checkout básico</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">


        <h2>Tu pago fue procesado</h2>

        <!-- En esta secció mostramos el resultado del pago procesado - On this site we show the client the result of the transaction -->

        <br></br>

        <div class="row justify-content-center">

              <div class="card center" align="center" style="width: 18rem;">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><?php echo "Estado del pago: $estado"; ?></li>
                  <li class="list-group-item"><?php echo "Id de pago de MercadoPago: $id_pago"; ?></li>
                  <li class="list-group-item"><?php echo "Id de pago de Sitio de pruebas: $id_interno"; ?></li>
                </ul>
              </div>

        </div>

         <br></br>

        <a href="index.html">Volvamos a comprar algo más</a>
        <br>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="assets/jquery-slim.min.js"><\/script>')</script>
    <script src="assets/popper.min.js"></script>
    <script src="assets/bootstrap.min.js"></script>
    <script src="assets/holder.min.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>

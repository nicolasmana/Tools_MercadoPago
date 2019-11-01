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
   require __DIR__  . '/vendor/autoload.php';

   //Primero vamos a definir las credenciales de nuestra cuenta de MP / First we are going to set our MP credentials.
   //Credentials in:https://www.mercadopago.com/mla/account/credentials
   MercadoPago\SDK::setClientId("1757905361309297"); //---> Estas son las credenciales de un test user. This are the credentials of a test user
   MercadoPago\SDK::setClientSecret("i8yUWKbwGkKjHOQnQT06mzT11fD59Hhi"); //---> Estas son las credenciales de un test user. This are the credentials of a test user

   //Test payments workflow: https://www.mercadopago.com.ar/developers/es/guides/payments/web-checkout/testing/
   //Another test user to use as payer: test_user_3514882@testuser.com


   # Instancio al SDK para comenzar a definir campos de la preferencia / Create a preference object
    $preference = new MercadoPago\Preference();

    # Defino el item / Create an item object
    $item = new MercadoPago\Item();
    $item->id = "1234";
    $item->title = "Mochila";
    $item->quantity = 1;
    $item->currency_id = "ARS"; //Currencies -> MLA=ARS, MLC=CLP, MLU=UYU, MLB=BRL, MLM=MXN, MCO= ,MPE=PEN
    $item->unit_price = 920; //No acepta decimales para MCO ni MLC. We do not accept float values for MCO or MLC.

    # Defino la info del pagador / Create a payer object
    $payer = new MercadoPago\Payer();
   //  $payer->name = $_POST['name'];
   //  $payer->surname = $_POST['lastName'];
   //  $payer->email = $_POST["email"];

   //  //Info de teléfono - Importante para la aprobación del pago
   //  $payer->phone = array(
   //    "area_code" => "",
   //    "number" => $_POST['phone']
   //  );

   //  //Identificación - Importante para la aprobación del pago
   //  $payer->identification = array(
   //    "type" => $_POST['docType'],
   //    "number" => $_POST['doc']
   //  );

   // //  //Dirección
   //  $payer->address = array(
   //   "street_name" => $_POST['street'],
   //   "street_number" => $_POST['street_number'],
   //   "zip_code" => $_POST['zip']
   // );


    //Se modifican los medios de pago que queremos excluir en la preferencia - We define the excluded payment methods in the preference.
    //Payment methods in: https://api.mercadolibre.com/sites/MLA/payment_methods?marketplace=NONE
    //(Se puede reemplazar MLA en el link con otro prefijo para ver los medios de pagos del resto de los países / You can replace MLA wiht another prefix to see the rest of the payment methods for the different countries).

    //$preference->payment_methods = array(
    // "excluded_payment_methods" => array(
    //   array("id" => "")
    // ),

    // "excluded_payment_types" => array(
    //   array("id" => "")
    // ),

     //Optional - Defino el máximo de cuotas aceptadas / We set the maximum amount of installments accepted
     // "installments" => 12
     //Optional - Defino la cantidad de cuotas por default / We sset the default installments once we open the checkout
     // "default_installments" => 6
     //Optional - Defino el medio de pago por default que le va a aparecer al cliente en el checkout / We set the default payment method that is going to appear first in the checkout.
     // "default_payment_method"=>"master"

    //);

   //Defino las url a las cuales voy a redirigir al usuario dependiendo del resultado del flujo de pagos. Tienen que ser url publicas, no pueden ser localhost por ejemplo
   //We set the urls that we are going to redirect the user depending the outcome of the payment. It has to be a public url, it cannot be localhost for example.
   $preference->back_urls = array(
     "success" => "https://www.google.com/",
     "failure" => "https://www.google.com/",
     "pending" => "https://www.google.com/"
    );

   //Si queremos que el user sea redirigido automáticamente luego de terminar el pago / If we want to redirect the user automatically after making the payment.
   $preference->auto_return = "approved";

   //Optional - Recommended - Se define la external_reference para hacer el trackeo interno de los pagos / We define an external_reference that you can use to track your operations internally. 245 characters.
   // $preference->external_reference="Order_1234";


   //Definimos la url a la cual queremos que nos lleguen las notificaciones sobre los pagos / We define the url where we want to receive all the payment notifications. It has to be a public url, it cannot be localhost for example.
   // $preference->notification_url="https://hookbin.com/pzYPVgkd2dT3b3qVWEbg";



   //Seteamos los tiempos por si queremos que las preferencias de pago expiren despues de un tiempo. Si no lo completamos no expira / We define when we want the preference to expire. If you do not set the time, it will not expire.
   // $expiry1 = '2018-11-30 04:23:34';
   // $expiry2 = '2018-11-30 12:23:34';
   // $preference->expiration_date_from= date('Y-m-d\TH:i:s.000P', strtotime($expiry1));
   // $preference->expiration_date_to= date('Y-m-d\TH:i:s.000P', strtotime($expiry2));


    # Defino la preferenia con los campos que fui completando / Setting preference properties
    $preference->items = array($item);
    $preference->payer = $payer;
    # Guardo y creo la preferencia / Save and posting preference
    $preference->save();

    //Redirigo al user al init_point para que pueda ver el checkout / Reiret the user to the init_point to complete the payment flow.
    header('Location: '.$preference->init_point);




?>

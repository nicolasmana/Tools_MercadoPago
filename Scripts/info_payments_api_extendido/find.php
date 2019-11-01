<?php
require_once ('lib/mercadopago.php');
$access_token = "<access_token>";

$myfile = fopen("user.txt", "w");

/* BUSCAR EN CUST 164352247*/
$response = file_get_contents('https://api.mercadopago.com/v1/payments/search?collector.id=308363094&marketplace=NONE&range=date_created&begin_date=2019-2-24T00:00:00.001-04:00&end_date=2019-2-24T23:59:50.999-04:00&status_detail=cc_rejected_high_risk&sort=date_created&criteria=desc&limit=1000&access_token='. $access_token);

$responseJson = json_decode($response,true);
$total = $responseJson["paging"]["total"];

if ($total>0){
    
    $txtTitulo = "ID,EXTERNAL,DATE_CREATED,CARDHOLDER_NAME,CARDHOLDER_DNI, LAST_FOUR_DIGITS,AUTH_CODE,PAYER_EMAIL,STATUS_DETAIL,ADDRESS_NAME,ADDRESS_NUMBER,ADDRESS_ZIP,PHONE,DNI,AMOUNT,SHIP_A_NAME,SHIP_A_NUMBER";
    fwrite($myfile, $txtTitulo);
    fwrite($myfile, "\n");
    
    for ($i = 1; $i <= $total; $i++){

                $paymentID = $responseJson["results"][$i]["id"];
                $external_reference = $responseJson["results"][$i]["external_reference"];
                $dateCreated = $responseJson["results"][$i]["date_created"];
                $cardholder_name = $responseJson["results"][$i]["card"]["cardholder"]["name"];
                $cardholder_dni = $responseJson["results"][$i]["card"]["cardholder"]["identification"]["number"];
                $last_four_digits = $responseJson["results"][$i]["card"]["last_four_digits"];
                $authorization_code = $responseJson["results"][$i]["authorization_code"];
                $payer_email = $responseJson["results"][$i]["payer"]["email"];
                $status_detail = $responseJson["results"][$i]["status_detail"];
                $addressName = $responseJson["results"][$i]["additional_info"]["payer"]["address"]["street_name"];
                $addressNumber = $responseJson["results"][$i]["additional_info"]["payer"]["address"]["street_number"];
                $addressZip = $responseJson["results"][$i]["additional_info"]["payer"]["address"]["zip_code"];
                $phone = $responseJson["results"][$i]["additional_info"]["payer"]["phone"]["number"];
                $payerIdentification = $responseJson["results"][$i]["payer"]["identification"]["number"];
                $transaction_amount = $responseJson["results"][$i]["transaction_amount"];
                $sAddress = $responseJson["results"][$i]["additional_info"]["shipments"]["receiver_address"]["street_name"];
                $sNumber = $responseJson["results"][$i]["additional_info"]["shipments"]["receiver_address"]["street_number"];
                
                
                $txtLine = $paymentID . "," . $external_reference . "," . $dateCreated . "," . $cardholder_name . "," . $cardholder_dni . "," . $last_four_digits . "," . $authorization_code . "," . $payer_email . "," . $status_detail . "," . $addressName . "," . $addressNumber . "," . $addressZip . "," . $phone . "," . $payerIdentification . "," . $transaction_amount . "," . $sAddress . "," . $sNumber;
                fwrite($myfile, $txtLine);
                fwrite($myfile, "\n");
    }
}

fclose($myfile);


<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel</title>
</head>
<body>
<h1>Leer Archivo Excel</h1>
			<?php
			require_once 'PHPExcel/Classes/PHPExcel.php';

			//definir el nombre del archivo del cual obtengo los datos
			$archivo = "pagina.xlsx";
			$inputFileType = PHPExcel_IOFactory::identify($archivo);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($archivo);
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			for ($row = 2; $row <= $highestRow; $row++){
					//Defino de que celdas voy a obtener la info
					$item=$sheet->getCell("A".$row)->getValue();
					$external=$sheet->getCell("B".$row)->getValue();
					$monto=$sheet->getCell("C".$row)->getValue();
					//Se define la url de redireccionamiento una vez que se aprueba el pago
					$url=$sheet->getCell("D".$row)->getValue();


					//Ejecuto el CURL

					$at="<access_token>";

					$ch = curl_init();


					curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/checkout/preferences?access_token=$at");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n\t\"items\": [\n\t\t{\n\t\t\t\"id\": \"item-ID-1234\",\n\t\t\t\"title\": \"$item\",\n\t\t\t\"currency_id\": \"ARS\",\n\t\t\t\"picture_url\": \"\",\n\t\t\t\"description\": \"$item\",\n\t\t\t\"category_id\": \"art\", \n\t\t\t\"quantity\": 1,\n\t\t\t\"unit_price\": $monto\n\t\t} \n\t],\n\t\"back_urls\": {\n\t\t\"success\": \"$url\",\n\t\t\"failure\": \"http://www.failure.com\",\n\t\t\"pending\": \"http://www.pending.com\"\n\t},\n\t\"auto_return\": \"approved\",\n\t\"payment_methods\": {\n\t\t\"excluded_payment_methods\": [\n\t\t\t{\n\t\t\t\t\"id\": \"\"\n\t\t\t}\n\t\t],\n\t\t\"excluded_payment_types\": [\n\t\t\t{\n\t\t\t\t\"id\": \"\"\n\t\t\t}\n\t\t\t],\n\t\t\"installments\": 12,\n\t\t\"default_installments\": 6\n  },\n\t\"notification_url\": \"https://requestb.in/1m8n7yf1\",\n\t\"external_reference\": \"$external\"\n}\n");
					curl_setopt($ch, CURLOPT_POST, 1);

					$headers = array();
					$headers[] = "Accept-Language: application/json";
					$headers[] = "Cache-Control: no-cache";
					$headers[] = "Content-Type: application/json";
					$headers[] = "Postman-Token: 6ff8721e-24bb-29d0-0943-7970fc2a2bd1";
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

					$result = curl_exec($ch);
					if (curl_errno($ch)) {
						echo 'Error:' . curl_error($ch);
					}
					curl_close ($ch);

					$result2=json_decode($result,true);


						//Definir el nombre del archivo donde se van a guardar los id
							$fichero = 'log.txt';
						  // Abre el fichero para obtener el contenido existente
						  $actual = file_get_contents($fichero);
						  // Añade una nueva persona al fichero

						  $resul = json_decode( file_get_contents( 'php://input' ), true );

						  	//Defino los campos que quiero obtener de la API. Para fines prácticos se trae todo el resultado, se podrían restringir
						    $info = $row.",".$external.",".$result2["init_point"].",".PHP_EOL;

						      // Escribe el contenido al fichero

						     file_put_contents($fichero, $info, FILE_APPEND);
			}
			?>
</body>
</html>



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
					$payer=$sheet->getCell("A".$row)->getValue();
					$amount=$sheet->getCell("B".$row)->getValue();
					$description2=$sheet->getCell("C".$row)->getValue();


					//Ejecuto el CURL

					$at="APP_USR-6539182953809720-022114-1fd0da2c570a2aa0061859f00fceb049__LD_LA__-270171469";

					$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/money_requests?access_token=$at");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, "{
					    'currency_id' : 'ARS',
					    'payer_email' : $payer,
					    'amount' : $amount,
					    'description' : $description2,
					    'concept_type' : 'off_platform'
					}");
					curl_setopt($ch, CURLOPT_POST, 1);

					$headers = array();
					$headers[] = "Cache-Control: no-cache";
					$headers[] = "Content-Type: application/json";
					$headers[] = "Postman-Token: be1791d7-b6d2-74e9-b246-c0e1cad4ed79";
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

					$result = curl_exec($ch);
					if (curl_errno($ch)) {
					    echo 'Error:' . curl_error($ch);
					}
					curl_close ($ch);
					


						//Definir el nombre del archivo donde se van a guardar los id
							$fichero = 'log.txt';
						  // Abre el fichero para obtener el contenido existente
						  $actual = file_get_contents($fichero);
						  // Añade una nueva persona al fichero

						  $resul = json_decode( file_get_contents( 'php://input' ), true );

						  	//Defino los campos que quiero obtener de la API. Para fines prácticos se trae todo el resultado, se podrían restringir
						    $info = $result.",".PHP_EOL;

						      // Escribe el contenido al fichero

						     file_put_contents($fichero, $info, FILE_APPEND);
			}
			?>
</body>
</html>

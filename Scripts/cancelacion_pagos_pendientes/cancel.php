

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
			$archivo = "pagos.xlsx";
			$inputFileType = PHPExcel_IOFactory::identify($archivo);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($archivo);
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			for ($row = 2; $row <= $highestRow; $row++){
					//Defino de que celdas voy a obtener la info
					$cell=$sheet->getCell("A".$row)->getValue();

					//Ejecuto el CURL

					$at="<access_token>";

					$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/payments/'.$cell.'?access_token='.$at);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"status\":\"cancelled\"}\n\n");
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");


					$headers = array();
					$headers[] = "Cache-Control: no-cache";
					$headers[] = "Content-Type: application/x-www-form-urlencoded";
					$headers[] = "Postman-Token: 0073aa65-4164-4889-8fb6-1ec2e3bba048";
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
						    $info = $cell."= ".$result.",".PHP_EOL;

						      // Escribe el contenido al fichero
						        
						     file_put_contents($fichero, $info, FILE_APPEND);
			}
			?>
</body>
</html>

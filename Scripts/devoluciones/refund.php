

<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel</title>
</head>
<body>
<h1>Leer Archivo Excel</h1>
			<?php
			require_once 'PHPExcel/Classes/PHPExcel.php';

			//definir el nombre del archivo de donde voy a sacar la info. En este caso es el excel pagos.xlsx
			$archivo = "pagos.xlsx";
			$inputFileType = PHPExcel_IOFactory::identify($archivo);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($archivo);
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			for ($row = 2; $row <= $highestRow; $row++){

					//Defino las celdas de donde voy a sacar los datos
					$cell=$sheet->getCell("A".$row)->getValue();


					//Aquí ingreso el access token de mi cuenta de MP que puedo encontrar en https://www.mercadopago.com/mlc/account/credentials
					$at="<ingresar el access token de mi cuenta de MP";

					//Ejecuto el CURL

					$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payments/$cell/refunds?access_token=$at");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);

					$headers = array();
					$headers[] = "Cache-Control: no-cache";
					$headers[] = "Content-Type: application/json";
					$headers[] = "Postman-Token: 2e3cd51f-0753-3a5b-3c20-250111a6e324";
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

						  	//Defino los campos que quiero obtener de la API
						    // $info = $cell.",".$result["status"].",".$result["amount"].",".$result["date_created"].PHP_EOL;
						  	$info = $cell."= ".$result.",".PHP_EOL;

						      // Escribe el contenido al fichero
						        
						     file_put_contents($fichero, $info, FILE_APPEND);
			}
			?>
</body>
</html>



<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel</title>
</head>
<body>
<h1>Leer Archivo Excel</h1>
			<?php
			//Abro librería de php excel
			require_once 'PHPExcel/Classes/PHPExcel.php';

			//definir el nombre del archivo con la info a buscar
			$archivo = "pagos.xlsx";
			$inputFileType = PHPExcel_IOFactory::identify($archivo);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($archivo);
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			for ($row = 2; $row <= $highestRow; $row++){
					//Defino de donde voy a sacar los datos
					$cell=$sheet->getCell("A".$row)->getValue();
					$cell2=$sheet->getCell("B".$row)->getValue();

					//Ejecuto el CURL
					$at="<access_token>";

					$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payments/$cell/refunds?access_token=$at");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					//si se quiere devolver un monto en específico para todos los pagos, solamente se cambia el siguiente campo y se ingnora el del excel
					curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"amount\":$cell2}");
					curl_setopt($ch, CURLOPT_POST, 1);

					$headers = array();
					$headers[] = "Cache-Control: no-cache";
					$headers[] = "Content-Type: application/x-www-form-urlencoded";
					$headers[] = "Postman-Token: 53057107-8d5e-3637-2386-ceb15e0ab7c2";
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

					$result = curl_exec($ch);
					if (curl_errno($ch)) {
					    echo 'Error:' . curl_error($ch);
					}
					curl_close ($ch);



						//Definir el nombre del archivo donde se van a guardar los resultados
							$fichero = 'log.txt';
						  // Abre el fichero para obtener el contenido existente
						  $actual = file_get_contents($fichero);

						  $resul = json_decode( file_get_contents( 'php://input' ), true );

						  	//Defino los campos que quiero obtener de la API
						    $info = $cell."= ".$result.",".PHP_EOL;

						     // Escribe el contenido al fichero

						     file_put_contents($fichero, $info, FILE_APPEND);
			}
			?>
</body>
</html>

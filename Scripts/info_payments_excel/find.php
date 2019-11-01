

<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel</title>
</head>
<body>
<h1>Leer Archivo Excel</h1>
			<?php
			require_once 'PHPExcel/Classes/PHPExcel.php';

			//definir el nombre del archivo
			$archivo = "pagina.xlsx";
			$inputFileType = PHPExcel_IOFactory::identify($archivo);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($archivo);
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			for ($row = 2; $row <= $highestRow; $row++){
					$cell=$sheet->getCell("A".$row)->getValue();


					$at="<access_token>";

					$payment = file_get_contents("https://api.mercadopago.com/v1/payments/$cell?access_token=$at");
					$paymentJson = json_decode($payment,true);



						//Definir el nombre del archivo donde se van a guardar los id
							$fichero = 'log.txt';
						  // Abre el fichero para obtener el contenido existente
						  $actual = file_get_contents($fichero);
						  // Añade una nueva persona al fichero

						  $resul = json_decode( file_get_contents( 'php://input' ), true );

						    
						    //Defino los campos que quiero obtener de la API
						    $info = $cell.",".$paymentJson["collector"]["email"].",".$paymentJson["payer"]["email"].",".$paymentJson["payer_id"].",".$paymentJson["card"]["cardholder"]["name"].",".$paymentJson["status"].PHP_EOL;

						      // Escribe el contenido al fichero
						       
						     file_put_contents($fichero, $info, FILE_APPEND);
			}
			?>
</body>
</html>

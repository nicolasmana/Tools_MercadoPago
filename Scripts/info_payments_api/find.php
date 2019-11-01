

<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel</title>
</head>
<body>
<h1>Leer Archivo Excel</h1>
			<?php

			$at="<access_token>";

			$day=date("d");
			$day2=date("d")-2;
			$month=date("m");
			$year=date("y");

			//periodo de tiempo para cancelar los pagos (en días)
			


			//Busco los pagos dos días para atrás que estén pendientes

			$payment = file_get_contents("https://api.mercadopago.com/v1/payments/search?collector.id=217046322&access_token=ADM-601-092411-a85ef6f01f3eb6cb1acd484c1996d8a8-nmana-62867623&sort=date_created&criteria=desc&status=in_process");


			$paymentJson = json_decode($payment,true);

			foreach ($paymentJson as $key => $value) {
				
				//Busco los pagos
			
				foreach ( $value as $key => $values) {
					$id=$values["id"];
					$status2=$values["status"];
					$status3=$values["status_detail"];
					$nombre=$values["payer"]["first_name"];
					$apellido=$values["payer"]["last_name"];
					$monto=$values["transaction_amount"];
					$medio=$values["payment_method_id"];



							//Definir el nombre del archivo donde se van a guardar los id
								$fichero = 'log.txt';
							  // Abre el fichero para obtener el contenido existente
							  $actual = file_get_contents($fichero);

							  // Añade una nueva persona al fichero

						  		$resul = json_decode( file_get_contents( 'php://input' ), true );

						  		 //Defino los campos que quiero obtener de la API
						    	$info = $id.",".$status2.",".$nombre.",".$apellido.",".$monto.",".$medio.PHP_EOL;


							      // Escribe el contenido al fichero
							        
						     file_put_contents($fichero, $info, FILE_APPEND);
					     }
					 }
			// }
			?>
</body>
</html>

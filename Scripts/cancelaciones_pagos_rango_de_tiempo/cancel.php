<?php
		//se obtienen en https://www.mercadopago.com/mla/account/credentials
			$at="";
		
		//periodo de tiempo para cancelar los pagos (en horas). Coupon: pagos en pending y card pagos in_process

			$couponExpirationHours= 10;
			$cardExpirationHours= 10;

			//Defino las fechas a cancelar
				$couponExpirationDate= gmdate("Y-m-d\TH:i:s", strtotime("-{$couponExpirationHours} hours"));
				$cardExpirationDate= gmdate("Y-m-d\TH:i:s", strtotime("-{$cardExpirationHours} hours"));

					//Parámetros de fecha
						$day=date("d");
						// $day2=date("d")-2;
						$month=date("m");
						$year=date("y");


		//Busco los pagos x días para atrás que estén pendientes. Se define el rango de fechas como quieran. 

			$payment = file_get_contents("https://api.mercadopago.com/v1/payments/search?access_token=$at&limit=1000&range=date_created&begin_date=$couponExpirationDate.999-04:00&end_date=20".$year."-".$month."-".$day."T23:59:59.999-00:00&status=pending");

			$paymentJson = json_decode($payment,true);



		//Busco los pagos x días para atrás que están in_process. Se define el rango de fechas como quieran. 

			$payment2 = file_get_contents("https://api.mercadopago.com/v1/payments/search?access_token=$at&limit=1000&range=date_created&begin_date=".$cardExpirationDate.".001-04:00&end_date=20".$year."-".$month."-".$day."T23:59:59.999-00:00&status=in_process");

			$paymentJson2 = json_decode($payment2,true);



		//Cancelo los pagos pending
			foreach ($paymentJson as $key => $value) {
				
				//Busco los pagos
			
				foreach ( $value as $key => $values) {
					$valor=$values["id"];
					$status2=$values["status"];
				
				 

						//Los cancelo

						//Ejecuto el CURL

						$ch = curl_init();

						curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/payments/'.$valor.'?access_token='.$at);
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

							   // Escribe el contenido al fichero
							        
						     file_put_contents($fichero, $result, FILE_APPEND);

							}

					     }
		// 


		//Cancelo todos los pagos in_process

			foreach ($paymentJson2 as $key => $value) {
				
				//Busco los pagos
			
				foreach ( $value as $key => $values) {
					$valor=$values["id"];
					$status2=$values["status"];
				
				 

						//Los cancelo

						//Ejecuto el CURL

						$ch = curl_init();

						curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/payments/'.$valor.'?access_token='.$at);
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
								$fichero = 'log_process.txt';
							  // Abre el fichero para obtener el contenido existente
							  $actual = file_get_contents($fichero);

							   // Escribe el contenido al fichero
							        
						     file_put_contents($fichero, $result, FILE_APPEND);

							}

					     }
					 


?>


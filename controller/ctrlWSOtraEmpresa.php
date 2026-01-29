<?php
session_start();
if (!isset($_SESSION["labAccess"])) {
  header("location:../index.php");
  exit();
}
if ($_SESSION["labAccess"] <> "Yes") {
  header("location:../index.php");
  exit();
}
$labIdUser = $_SESSION['labIdUser'];
$labIdDepUser = $_SESSION['labIdDepUser'];
$labIdServicioUser = $_SESSION['labIdServicio'];
$labIdServicioDepUser = $_SESSION['labIdServicioDep'];

require_once '../model/Lab.php';
$la = new Lab();

function to_pg_array($set) {
  settype($set, 'array'); // can be called with a scalar or array
  $result = array();
  foreach ($set as $t) {
    if (is_array($t)) {
      $result[] = to_pg_array($t);
    } else {
      $t = str_replace('"', '\\"', $t); // escape double quote
      if (!is_numeric($t)) // quote only non-numeric values
      $t = '"' . $t . '"';
      $result[] = $t;
    }
  }
  return '{' . implode(",", $result) . '}'; // format
}

if(isset($_POST['accion'])){

	switch ($_POST['accion']) {
	  case 'REG_ORDEN_DIAGNOSTICA':
		$datos = array();
		$rs = $la->get_datosDiagnosticaDetalleAtencionEnvio($_POST['id_atencion']);
		$nr = (int)count($rs);
		if ($nr > 0) {
			$rsD = $la->get_datosDiagnosticaDetalleExamenEnvio($_POST['id_atencion']);
			$nrD = (int)count($rsD);
			if ($nrD > 0) {
			}
		}
			
		if ($nr==0 && $nrD==0){
			$resultado = array(
				0 => 'NEA', //No Existe Atencion
				1 => $nr."-".$nrD
			);
		} else if ($nr==1 && $nrD==0){
			$resultado = array(
				0 => 'NEE', //No existen examenenes homologados con el interfaz.
				1 => $nr."-".$nrD
			);
		} else {
			$datos = array(
				"establecimiento_id" => $rs[0]['establecimiento_id'],
				"tipo_atencion_id" => $rs[0]['tipo_atencion_id'],
				"numero_registro_atencion" => $rs[0]['numero_registro_atencion'],
				"fecha_atencion" => $rs[0]['fecha_atencion'],
				"embarazada" => $rs[0]['check_gestante'] == "t" ? true : false,
				"servicio" => null,
				"medico" => null,
				"paciente" => array(
					"tipo_identificacion"=> $rs[0]['tipo_identificacion_pac'],
					"numero_identificacion"=> $rs[0]['numero_identificacion_pac'],
					"nombres"=> $rs[0]['nombres_pac'],
					"apellido_paterno"=> $rs[0]['primer_apellido_pac'],
					"apellido_materno"=> $rs[0]['segundo_apellido_pac'],
					"fecha_nacimiento"=> $rs[0]['fecha_nacimiento_pac'],
					"sexo"=> $rs[0]['sexo_pac'],
					"numero_historia_clinica"=> $rs[0]['numero_historia_clinica_pac'],
					"correo"=> $rs[0]['correo_pac'],
					"telefono_celular"=> $rs[0]['telefono_celular']
				  ),
				  "examenes" => $rsD
			);
			
			//Para probar el envío pintar esto
			//echo json_encode($datos); exit();
			
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'http://200.123.9.235:8020/api/Ordenes/orden',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => json_encode($datos),
			  CURLOPT_HTTPHEADER => array(
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1lIjoiRElSSVNMQUIiLCJleHAiOjE3MzgxNTczOTcsImlzcyI6Imh0dHA6Ly9EaWFnbm9zdGljYVBlcnVhbmFBUEkiLCJhdWQiOiJhdWRpZW5jaWFMaWJyZSJ9.a33qkiM2zTiCnwuh-sO7k0Q7a9rrLW6lEbrDxSjZAj8'
			  ),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			
			$array = json_decode($response,TRUE);
			if(isset($array["data"])){
				//$resultado = json_decode($response,TRUE);
				$rs = $la->reg_atencion_laboratorio_api_tercero('DIAGNOSTICA', $_POST['id_atencion'], $array["data"]["id_externo"], $array["data"]["numero_orden_externo"], $labIdUser);
				$resultado = array(
					0 => 'RC', //Registrado Correctamente
					1 => $array["data"]["id_externo"],
					2 => $array["data"]["numero_orden_externo"]
				);
				
			} else {
				//$resultado = json_decode($response,TRUE);
				//print_r($array);
				if(isset($array["errors"]["orden1"])){
					$error = $array["errors"]["orden1"];
				} else {
					$error = $array["errors"];
				}
				$resultado = array(
					0 => 'ER', //Error
					1 => $error,
					//3 => $datos
				);
			}
			
			echo json_encode($resultado);
		
		}
		//echo json_encode($resultado);
	  break;
	  case 'EDIT_ORDEN_DIAGNOSTICA': 
		$datos = array();
		$rs = $la->get_datosDiagnosticaDetalleAtencionEnvio($_POST['id_atencion']);
		$nr = (int)count($rs);
		if ($nr > 0) {
			$rsD = $la->get_datosDiagnosticaDetalleExamenEnvio($_POST['id_atencion']);
			$nrD = (int)count($rsD);
			if ($nrD > 0) {
			}
		}
			
		if ($nr==0 && $nrD==0){
			$resultado = array(
				0 => 'NEA', //No Existe Atencion
				1 => $nr."-".$nrD
			);
		} else if ($nr==1 && $nrD==0){
			$resultado = array(
				0 => 'NEE', //No existen examenenes homologados con el interfaz.
				1 => $nr."-".$nrD
			);
		} else {
			$datos = array(
				"establecimiento_id" => $rs[0]['establecimiento_id'],
				"tipo_atencion_id" => $rs[0]['tipo_atencion_id'],
				"numero_registro_atencion" => $rs[0]['numero_registro_atencion'],
				"fecha_atencion" => $rs[0]['fecha_atencion'],
				"embarazada" => $rs[0]['check_gestante'] == "t" ? true : false,
				"servicio" => null,
				"medico" => null,
				"paciente" => array(
					"tipo_identificacion"=> $rs[0]['tipo_identificacion_pac'],
					"numero_identificacion"=> $rs[0]['numero_identificacion_pac'],
					"nombres"=> $rs[0]['nombres_pac'],
					"apellido_paterno"=> $rs[0]['primer_apellido_pac'],
					"apellido_materno"=> $rs[0]['segundo_apellido_pac'],
					"fecha_nacimiento"=> $rs[0]['fecha_nacimiento_pac'],
					"sexo"=> $rs[0]['sexo_pac'],
					"numero_historia_clinica"=> $rs[0]['numero_historia_clinica_pac'],
					"correo"=> $rs[0]['correo_pac'],
					"telefono_celular"=> $rs[0]['telefono_celular']
				  ),
				  "examenes" => $rsD
			);
			
			//Para probar el envío pintar esto
			//echo json_encode($datos); exit();
			
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'http://200.123.9.235:8020/api/Ordenes/orden',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => json_encode($datos),
			  CURLOPT_HTTPHEADER => array(
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1lIjoiRElSSVNMQUIiLCJleHAiOjE3MzgxNTczOTcsImlzcyI6Imh0dHA6Ly9EaWFnbm9zdGljYVBlcnVhbmFBUEkiLCJhdWQiOiJhdWRpZW5jaWFMaWJyZSJ9.a33qkiM2zTiCnwuh-sO7k0Q7a9rrLW6lEbrDxSjZAj8'
			  ),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			
			$array = json_decode($response,TRUE);
			if(isset($array["data"])){
				//$resultado = json_decode($response,TRUE);
				$rs = $la->reg_atencion_laboratorio_api_tercero('DIAGNOSTICA', $_POST['id_atencion'], $array["data"]["id_externo"], $array["data"]["numero_orden_externo"], $labIdUser);
				$resultado = array(
					0 => 'RC', //Registrado Correctamente
					1 => $array["data"]["id_externo"],
					2 => $array["data"]["numero_orden_externo"]
				);
				
			} else {
				//$resultado = json_decode($response,TRUE);
				//print_r($array);
				if(isset($array["errors"]["orden1"])){
					$error = $array["errors"]["orden1"];
				} else {
					$error = $array["errors"];
				}
				$resultado = array(
					0 => 'ER', //Error
					1 => $error,
					//3 => $datos
				);
			}
			
			echo json_encode($resultado);
		
		}
		//echo json_encode($resultado);
	  break;
	  case "ELIM_ORDEN_DIAGNOSTICA":
		$rs = $la->get_datosDiagnosticaDetalleAtencionEnvio($_POST['id_atencion']);
		$datos = array("motivo" => $_POST['motivo']);
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://200.123.9.235:8020/api/Ordenes/eliminar', //Producción
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'DELETE',
		  CURLOPT_POSTFIELDS => json_encode($datos),
		  CURLOPT_HTTPHEADER => array(
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Bearer pJEJWRHfKUCLJVmiEWFo1pwjDGIgyaMNVPK40iN92RRx5LKdPuZlEyBtWeVv'  //--Producción
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		
		print_r($response);
	  break;
	}
} else {

switch ($_GET['accion']) {
  case "GET_MEDICO_POR_EESS":

  break;
}
	
}
?>

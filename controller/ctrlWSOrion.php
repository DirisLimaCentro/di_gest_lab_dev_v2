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
	  case 'POST_REG_ATENCION':
		$rs = $la->get_datosOrionDetalleAtencionEnvio($_POST['id_atencion']);
		$nr = (int)count($rs);
		if ($nr > 0) {
			$rsD = $la->get_datosOrionDetalleExamenEnvio($_POST['id_atencion']);
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
				"sucursal_id" => $rs[0]['sucursal_id'],
				"categoria_id" => $rs[0]['categoria_id'],
				"categoria_id_externo" => null,
				"tipo_atencion_id" => null,
				"tipo_atencion_id_externo" => null,
				"tipo_paciente_id" => null,
				"tipo_paciente_id_externo" => null,
				"servicio_id" => null,
				"servicio_id_externo" => null,
				"usuario_ingresa_id" => null,
				"usuario_ingresa_id_externo" => null,
				"embarazada" => null,
				"numero_orden_externa" => $rs[0]['numero_orden_externa'],
				"fecha_orden" => $rs[0]['fecha_orden'],
				"valor_total" => null,
				"valor_descuento" => null,
				"valor_abono" => null,
				"paciente" => array(
					"tipo_identificacion"=> $rs[0]['tipo_identificacion_pac'],
					"numero_identificacion"=> $rs[0]['numero_identificacion_pac'],
					"nombres"=> $rs[0]['nombres_pac'],
					"apellidos"=> $rs[0]['apellidos_pac'],
					"fecha_nacimiento"=> $rs[0]['fecha_nacimiento_pac'],
					"sexo"=> $rs[0]['sexo_pac'],
					"numero_historia_clinica"=> $rs[0]['numero_historia_clinica_pac'],
					"correo"=> $rs[0]['correo_pac'],
					"telefono_celular"=> $rs[0]['telefono_celular']
				  ),
				  "medico"=> null,
				  /*"medico"=> array(
					"ìd_externo"=> null,
					"numero_identificacion"=> null,
					"nombres"=> null,
					"apellidos"=> null
				  ),*/
				  "examenes" => $rsD
			);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  //CURLOPT_URL => 'https://demo.orion-labs.com/api/v1/ordenes', //Desarrollo
			  CURLOPT_URL => 'https://redsaludlimacentro.orion-labs.com/api/v1/ordenes', //Producción
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
				'Authorization: Bearer pJEJWRHfKUCLJVmiEWFo1pwjDGIgyaMNVPK40iN92RRx5LKdPuZlEyBtWeVv'  //--Producción, cambiar el cod_depen_orionlab a 9, y en desarrollo es 1
				//'Authorization: Bearer eD4oMEiPqnAyk8A4H2kXcI1B6FEwDdJoQdBgthIuyHKh98CkIOM3h1GOOlrr'  //--Desarrollo, cambiar el cod_depen_orionlab a 1, y en produccion es 9
			  ),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			
			$array = json_decode($response,TRUE);
			if(isset($array["data"])){
				//$resultado = json_decode($response,TRUE);
				$rs = $la->reg_atencion_laboratorio_orion($_POST['id_atencion'], $array["data"]["id"], $array["data"]["numero_orden"], $labIdUser);
				$resultado = array(
					0 => 'RC', //Registrado Correctamente
					1 => $array["data"]["id_externo"],
					2 => $array["data"]["numero_orden_externo"]
				);
				
			} else {
				//$resultado = json_decode($response,TRUE);
				//print_r($array);
				if(isset($array["errors"]["paciente.apellidos"])){
					$error = $array["errors"]["paciente.apellidos"];
				} else {
					$error = $array["errors"];
				}
				$resultado = array(
					0 => 'ER', //Error
					1 => $error
				);
			}
		}
		echo json_encode($resultado);
	  break;
	  case 'POST_EDIT_ATENCION':
		$rs = $la->get_datosOrionDetalleAtencionEnvio($_POST['id_atencion']);
		$nr = (int)count($rs);
		if ($nr > 0) {
			$rsD = $la->get_datosOrionDetalleExamenEnvio($_POST['id_atencion'], '2');
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
				"sucursal_id" => $rs[0]['sucursal_id'],
				"categoria_id" => $rs[0]['categoria_id'],
				"categoria_id_externo" => null,
				"tipo_atencion_id" => null,
				"tipo_atencion_id_externo" => null,
				"tipo_paciente_id" => null,
				"tipo_paciente_id_externo" => null,
				"servicio_id" => null,
				"servicio_id_externo" => null,
				"usuario_ingresa_id" => null,
				"usuario_ingresa_id_externo" => null,
				"embarazada" => null,
				"numero_orden_externa" => $rs[0]['numero_orden_externa'],
				"fecha_orden" => $rs[0]['fecha_orden'],
				"valor_total" => null,
				"valor_descuento" => null,
				"valor_abono" => null,
				"paciente" => array(
					"tipo_identificacion"=> $rs[0]['tipo_identificacion_pac'],
					"numero_identificacion"=> $rs[0]['numero_identificacion_pac'],
					"nombres"=> $rs[0]['nombres_pac'],
					"apellidos"=> $rs[0]['apellidos_pac'],
					"fecha_nacimiento"=> $rs[0]['fecha_nacimiento_pac'],
					"sexo"=> $rs[0]['sexo_pac'],
					"numero_historia_clinica"=> $rs[0]['numero_historia_clinica_pac'],
					"correo"=> $rs[0]['correo_pac'],
					"telefono_celular"=> $rs[0]['telefono_celular']
				  ),
				  "medico"=> null,
				  "examenes" => $rsD
			);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://redsaludlimacentro.orion-labs.com/api/v1/ordenes/'.$rs[0]['id_sistema_externo'], //Producción
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'PATCH',
			  CURLOPT_POSTFIELDS => json_encode($datos),
			  CURLOPT_HTTPHEADER => array(
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: Bearer pJEJWRHfKUCLJVmiEWFo1pwjDGIgyaMNVPK40iN92RRx5LKdPuZlEyBtWeVv'  //--Producción
			  ),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			
			$array = json_decode($response,TRUE);
			if(isset($array["data"])){
				//$resultado = json_decode($response,TRUE);
				$rs = $la->reg_atencion_laboratorio_orion($_POST['id_atencion'], $array["data"]["id"], $array["data"]["numero_orden"], $labIdUser);
				$resultado = array(
					0 => 'RC', //Registrado Correctamente
					1 => $array["data"]["id"],
					2 => $array["data"]["numero_orden"]
				);
				
			} else {
				//$resultado = json_decode($response,TRUE);
				//print_r($array);
				if(isset($array["errors"]["paciente.apellidos"])){
					$error = $array["errors"]["paciente.apellidos"];
				} else {
					$error = $array["errors"];
				}
				$resultado = array(
					0 => 'ER', //Error
					1 => $error
				);
			}
		}
		echo json_encode($resultado);
	  break;
	  case "POST_ELIM_ATENCION":
		$rs = $la->get_datosOrionDetalleAtencionEnvio($_POST['id_atencion']);
		$datos = array("motivo" => $_POST['motivo']);
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://redsaludlimacentro.orion-labs.com/api/v1/ordenes/'.$rs[0]['id_sistema_externo'], //Producción
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

<?php

include __DIR__ . '/api_dni/models/Token.php';

function esIpPrivada($ip)
{
  return (
    preg_match('/^10\./', $ip) ||
    preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $ip) ||
    preg_match('/^192\.168\./', $ip)
  );
}

function obtenerIpCliente()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    return $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; // Puede tener múltiples IPs
  } else {
    return $_SERVER['REMOTE_ADDR'];
  }
}

function formatFechaNacimiento($fecha) {
	// Intentamos crear la fecha en formato yyyy-mm-dd
	$date = date_create_from_format('Y-m-d', $fecha);
	// Si falla, intentamos crear la fecha en formato dd/mm/yyyy
	if (!$date) {
		$date = date_create_from_format('d/m/Y', $fecha);
	}
	// Si se pudo crear la fecha en cualquiera de los dos formatos, la formateamos a dd/mm/yyyy
	if ($date) {
		return date_format($date, 'd/m/Y');
	} else {
		// Manejo de errores si la fecha no tiene un formato válido
		return 'Formato de fecha no válido';
	}
}

define('HOST', 'app1.dirislimacentro.gob.pe');
define('PROTOCOL', 'https');

$db = new Token();
$result = $db->getToken();

$data_token = $result["row"];
$exp_date = $data_token ? new DateTime($result["row"]["fecha_limite"]) : '';
$cur_date = $data_token ? new DateTime() : '';
$expirado = $data_token ? $cur_date > $exp_date : true;

if ($data_token == null || $expirado) {

  $curl = curl_init();
  $url = PROTOCOL . "://" . HOST . "/api_dlc/api_dni/index.php/auth";
  $username = 'ADMIN_OGTI';
  $password = 'D1r1SLC@2025.';

  $params = [
    'username' => $username,
    'password' => $password
  ];

  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_HTTPHEADER => array('Cookie: PHPSESSID=o6pjsjv8qtcar2g9qo6rbrhnbm'),
  ));
  $response = curl_exec($curl);
  $response = json_decode($response);
  curl_close($curl);

  $data['id'] = null;
  $data['token'] = isset($response->token) ? $response->token : '';
  $data['fecha_exp'] = date('Y-m-d H:i:s', time() + (3600 * 23));

  $result['error'] = isset($response->error) ? $response->error : '';

  if (!$result['error']) $result = $db->saveToken($data);
  if (!$result['error']) $result['token'] = $data['token'];
} else {
  $result['token'] = $data_token["token"];
}

//if ($result['error']) exit(json_encode($result));
if($result["error"]){
	$datos = array(
		0 => "C",
		1 => $result["error"],
	);
	echo json_encode($datos);
} else {

	//OBTENER PARAMETROS:
	$_GET['id_tipo_consulta'] = '1';
	$_GET['id_tipo'] = '1';
	$_GET['nro_doc'] = $_POST['txtNroDoc'];
	$_GET['id_sistema_origen'] = '25';
	$_GET['id_usuario_origen'] = $labIdUser;
	$_GET['nom_usuario_origen'] = $labNomUser;
	//$_POST['interfaz_origen'] = 'REG_USUARIO';

	$id_tipo_consulta = isset($_GET['id_tipo_consulta']) ? $_GET['id_tipo_consulta'] : '';

	$id_tipo = isset($_GET['id_tipo']) ? $_GET['id_tipo'] : '';
	$nro_doc = isset($_GET['nro_doc']) ? $_GET['nro_doc'] : '';
	$id_sistema_origen = isset($_GET['id_sistema_origen']) ? $_GET['id_sistema_origen'] : '';
	$id_usuario_origen = isset($labIdUser) ? $labIdUser : '';
	$nom_usuario_origen = isset($labNomUser) ? $labNomUser : '';
	$interfaz_origen = isset($_POST['interfaz']) ? $_POST['interfaz'] : '';
	
	if(!empty($interfaz_origen)){
		switch($interfaz_origen){
			case "usuario":
				$interfaz_origen = 'REG_USUARIO';
			break;
			case "profesional":
				$interfaz_origen = 'REG_PROFESIONAL';
			break;
			case "reglaboratorio":
				$interfaz_origen = 'REG_ATENCIONLAB';
			break;
			case "editlaboratorio":
				$interfaz_origen = 'EDIT_ATENCIONLAB';
			break;
			case "reglaboratorioref":
				$interfaz_origen = 'REG_ATENCIONLABREF';
			break;
			case "regpap":
				$interfaz_origen = 'REG_ATENCIONPAP';
			break;
			case "editpap":
				$interfaz_origen = 'EDIT_ATENCIONPAP';
			break;
			default:
				$interfaz_origen = '';
			break;
		}
	}
	
	$ip_pc = obtenerIpCliente();
	$ip_publica = esIpPrivada($ip_pc)?file_get_contents('https://api.ipify.org'):$ip_pc;
	$nombre_pc = gethostbyaddr($ip_pc);

	if (!$id_tipo_consulta) $result["error"] = "El tipo de consulta es requerido. Por favor, contáctese con la OGTI de la DIRIS LC.";
	else if (!$id_tipo) $result["error"] = "El tipo de documento es requerido. Por favor, contáctese con la OGTI de la DIRIS LC.";
	else if (!$nro_doc) $result["error"] = "El número de documento es requerido. Por favor, contáctese con la OGTI de la DIRIS LC.";
	else if (!$id_sistema_origen) $result["error"] = "El id del sistema es requerido. Por favor, contáctese con la OGTI de la DIRIS LC.";
	else if (!$id_usuario_origen) $result["error"] = "El id de usuario requerido. Por favor, contáctese con la OGTI de la DIRIS LC.";
	else if (!$nom_usuario_origen) $result["error"] = "El nombre de usuario es requerido. Por favor, contáctese con la OGTI de la DIRIS LC.";
	else if (!$interfaz_origen) $result["error"] = "La interfaz de origen es requerida. Por favor, contáctese con la OGTI de la DIRIS LC.";

	$token = $result['token'];
	$result['row'] = null;
	unset($result['token']);

	$action = '';
	switch($id_tipo_consulta){
	  case '1' : $action = 'consulta_reniec';break;
	  case '2' : $action = 'consulta_sis';break;
	  default: $result["error"] = $result["error"]?$result["error"]:"Tipo de consulta no es valido";
	}

	//if($result["error"]) exit(json_encode($result));
	if($result["error"]){
		$datos = array(
			0 => "C",
			1 => $result["error"],
		);
		echo json_encode($datos);
	} else {

		$url = PROTOCOL . "://" . HOST . "/api_dlc/api_dni/index.php/$action";
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => array(
			'id_tipo' => $id_tipo,
			'dni' => $nro_doc,
			'id_sistema_origen' => $id_sistema_origen,
			'id_usuario_origen' => $id_usuario_origen,
			'nom_usuario_origen' => $nom_usuario_origen,
			'interfaz_origen' => $interfaz_origen,
			'ip_pc' => $ip_pc,
			'ip_publica' => $ip_publica,
			'nombre_pc' => $nombre_pc
		  ),
		  CURLOPT_HTTPHEADER => array(
			'Authorization: ' . $token
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		//echo $response;
		$result = json_decode($response, true);//con esto se convierte de object a array

		if($result['row']){
			if($labIdDepUser == "67"){
				$nro_hc = "00";
			}
			if($result['row']['id_sexo']=='1'){$abrev_sexo='M';}else{$abrev_sexo='F';}
			if(($result['row']['fecha_nacimiento'] == "") OR ($result['row']['fecha_nacimiento'] == "--")){
			  $fecNacPac = "";
			  $edad = "";
			} else {
			  $fecNacPac = formatFechaNacimiento($result['row']['fecha_nacimiento']);
			  $rsE = $t->function_calculaEdad($fecNacPac, date("d/m/Y"));
			  $edad = $rsE[0];
			}
				
			//isset($result['row']['departamento_domicilio']) ? $result['row']['departamento_domicilio'] : '';
			$nomDpto = "";
			$nomTipVia = "";
			$nomPobla = "";
			$nomMZ = "";
			$nomLT = "";
			$direccion = isset($result['row']['domicilio_direccion_actual']) ? trim($result['row']['domicilio_direccion_actual']) : '';
			if($direccion == "SIN DATOS"){$direccion='';}
			$etnia = "";

			$datos = array(
			  0 => 0,
			  1 => $_POST['txtIdTipDoc'],
			  2 => 'DNI',
			  3 => $_POST['txtNroDoc'],
			  4 => trim($result['row']['nombres']),
			  5 => trim($result['row']['primer_apellido']),
			  6 => trim($result['row']['segundo_apellido']),
			  7 => $result['row']['id_sexo'],
			  8 => $abrev_sexo,
			  9 => $fecNacPac,
			  10 => $nro_hc,//Nro HC
			  11 => '',//Nro Tel fijo
			  12 => '',//Nro Tel Movil
			  13 => '',//Email
			  14 => $result['row']['id_distrito_domicilio'],//Id Ubigeo
			  15 => '',//Nombre departamento
			  16 =>	'',//Nombre Provincia
			  17 => '',//Nombre Distrito
			  18 => $direccion,
			  19 => '',//Referencia Dirección
			  20 => $edad,
			  21 => 'PER',
			  22 => $etnia,
			  23 => 'MINSA'
			);
			echo json_encode($datos);
		} else {
		  $datos = array(
			0 => "C",
			1 => $result['error'],
		  );
		  echo json_encode($datos);
		}
	}
}
/*MINSA ANTERIOR
	$result=file_get_contents("http://200.123.29.214/sismed_/ajaxDNI.php?nro_doc=".$_POST['txtNroDoc']."&app=LAB");
	$result = json_decode($result, true);//con esto se convierte de object a array
	
	if($result['row']['sexo']=='1'){$abrev_sexo='M';}else{$abrev_sexo='F';}
	if(($result['row']['fecha_nacimiento'] == "") OR ($result['row']['fecha_nacimiento'] == "--")){
	  $fecNacPac = "";
	  $edad = "";
	} else {
	  //if (27\/11\/1989)
	  //$fecNacPac = date_create($result['row']['fecha_nacimiento']);
	  //$fecNacPac = date_format($fecNacPac, "d/m/Y");
	  $fecNacPac = formatFechaNacimiento($result['row']['fecha_nacimiento']);
	  $rsE = $t->function_calculaEdad($fecNacPac, date("d/m/Y"));
	  $edad = $rsE[0];
	}
	if($labIdDepUser == "67"){
		$nro_hc = "00";
	}
	$nomDpto = "";
	$nomTipVia = "";
	$nomPobla = "";
	$nomMZ = "";
	$nomLT = "";
	$direccion = "";
	
	$etnia = "";
				
	$datos = array(
	  0 => 0,
	  1 => $_POST['txtIdTipDoc'],
	  2 => 'DNI',
	  3 => $_POST['txtNroDoc'],
	  4 => trim($result['row']['nombres']),
	  5 => trim($result['row']['apellido_paterno']),
	  6 => trim($result['row']['apellido_materno']),
	  7 => $result['row']['sexo'],
	  8 => $abrev_sexo,
	  9 => $fecNacPac,
	  10 => $nro_hc,//Nro HC
	  11 => '',//Nro Tel fijo
	  12 => '',//Nro Tel Movil
	  13 => '',//Email
	  14 => $result['row']['id_distrito'],//Id Ubigeo
	  15 => '',//Nombre departamento
	  16 =>	'',//Nombre Provincia
	  17 => '',//Nombre Distrito
	  18 => $direccion,
	  19 => '',//Referencia Dirección
	  20 => $edad,
	  21 => 'PER',
	  22 => $etnia,
	  23 => 'MINSA'
	);
	echo json_encode($datos);
	*/

/*
	/// WS Minsa Anterior
	$login = 'usr_mpi';
	$password = 'D1r1sC3ntr0$mp1';
	$grant_type= 'password';
	$cadena=$login."|".time();
	$signature=hash_hmac('sha256', $cadena, $password);
	$url= "https://apimanager.minsa.gob.pe:8243/token?grant_type=password&username=usr_diriscentro_mpi&password=$password";
	$headers = array(
	'Content-Type: application/x-www-form-urlencoded',
	'Authorization: Basic SmZCaEplemtUTFF6ZjBFNkgyVFpOZmpzYmhNYTpOZjIyaGFMXzI2SEppdTNzNVc2VFNGTVN1eU1h'
	);
	$data=array(
	"username" => 'usr_diriscentro_mpi',
	"password" => 'D1r1sC3ntr0$mp1',
	"grant_type"=> 'password'
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	$result=curl_exec ($ch);
	curl_close ($ch);
	$a=json_decode($result,true);
	//print_r($a);
	if(isset($a['access_token'])){
		$token= $a['access_token'];
		//------CONSULTANDO DATOS-----
		$url= "https://apimanager.minsa.gob.pe:8243/mpi/v1.0.0/consulta-mpi";
		$headers = array(
		'Content-Type: application/json',
		'Authorization: Bearer '.$token
		);
		$data=array(
		"tipDocumento" => '1',
		"nroDocumento"=> $_POST['txtNroDoc']
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result=curl_exec ($ch);
		$a=json_decode($result,true);
		curl_close ($ch);
		//exit(print_r($a));
		if($a['desRespuesta'] == "No se encontró información para los datos ingresados" OR $a['desRespuesta'] == "El DNI solicitado se encuentra cancelado en el archivo magnético del RUIPN"){
			//if($a['desRespuesta'] == "No se encontró información para los datos ingresados"){
			$datos = array(
				0 => "E", //No existe DNI
				1 => 'MINSA'
			);
			echo json_encode($datos);
			exit();
		} else {
			if (trim($a['prenombres']) == ""){
				$dataminsa = 0;
			} else {
				if($a['genero']=='1'){$abrev_sexo='M';}else{$abrev_sexo='F';}
				if($a['fecNacimiento'] == ""){
				  $fecNacPac = "";
				  $edad = "";
				} else {
				  $fecNacPac = date_create($a['fecNacimiento']);
				  $fecNacPac = date_format($fecNacPac, "d/m/Y");
				  $rsE = $t->function_calculaEdad($fecNacPac, date("d/m/Y"));
				  $edad = $rsE[0];
				}
				$nomDpto = "";
				$nomTipVia = "";
				$nomPobla = "";
				$nomMZ = "";
				$nomLT = "";
						
				if(trim($a['prefijoDptoPisoInterior']) <> "SIN DATOS"){
					if(trim($a['prefijoDptoPisoInterior']) == "01"){
						$nomDpto = "DPTO.";
					} else if(trim($a['prefijoDptoPisoInterior']) == "02"){
						$nomDpto = "PISO.";
					} else{//Interior
						$nomDpto = "INT.";
					}
				}
				if(trim($a['prefijoDireccion']) <> "SIN DATOS"){
					if(trim($a['prefijoDireccion']) == "01"){
						$nomTipVia = "";
					} else if(trim($a['prefijoDireccion']) == "02"){
						$nomTipVia = "JR.";
					} else{
						$nomTipVia = "";
					}
				}
				if(trim($a['prefijoUrbCondResid']) <> "SIN DATOS"){
					if(trim($a['prefijoUrbCondResid']) == "10"){
						$nomPobla = "COOP.";
					} else{
						$nomPobla = "";
					}
				}
				
				if(trim($a['manzana']) <> "SIN DATOS"){
						$nomMZ = "MZ. " . trim($a['manzana']);
				}
				if(trim($a['lote']) <> "SIN DATOS"){
						$nomLT = "LT. " . trim($a['lote']);
				}
				
				if(trim($a['prefijoDireccion']) <> "SIN DATOS"){
					$direccion = $nomTipVia . " " . $a['direccion'] . " " . $a['numDireccion'] . " " . $nomDpto . " " . $a['interior']. " " . $nomPobla . " " . $a['urbanizacion'] . " " . $nomMZ . " " . $nomLT;
				} else {
					$direccion = $a['direccion'];
				}
				
					
				$datos = array(
				  0 => 0,
				  1 => $_POST['txtIdTipDoc'],
				  2 => 'DNI',
				  3 => $_POST['txtNroDoc'],
				  4 => trim($a['prenombres']),
				  5 => trim($a['apePadre']),
				  6 => trim($a['apeMadre']),
				  7 => $a['genero'],
				  8 => $abrev_sexo,
				  9 => $fecNacPac,
				  10 => '',//Nro HC
				  11 => '',//Nro Tel fijo
				  12 => '',//Nro Tel Movil
				  13 => '',//Email
				  14 => trim($a['codUbiDepartamentoDomicilio'].$a['codUbiProvinciaDomicilio'].$a['codUbiDistritoDomicilio']),//Id Ubigeo
				  15 => '',//Nombre departamento
				  16 =>	'',//Nombre Provincia
				  17 => '',//Nombre Distrito
				  18 => $direccion,
				  19 => '',//Referencia Dirección
				  20 => $edad,
				  21 => 'PER',
				  22 => trim($a['etnia']),
				  23 => 'MINSA'
				);
				echo json_encode($datos);
				exit();
				/*foreach($a as $key => $value){
					if ($key!='imgFoto' && $key!='imgFirma')	{
					echo $key." = > ". $value.'<br>';
					}
				}
				echo "<img src='data:image/png;base64,".($a['imgFirma'])."'><br>";
				echo "<img src='data:image/png;base64,".($a['imgFoto'])."'>";//*/
	/*		}
		}*/
	/*} else {
		$dataminsa = 0;	
	}*/
?>
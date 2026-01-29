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
$labIdServicioDepUser = $_SESSION['labIdServicioDep'];

require_once '../model/ITS.php';
$ate = new ITS();

function to_pg_array($set) {
  settype($set, 'array'); // can be called with a scalar or array
  $result = array();
  foreach ($set as $t) {
    if (is_array($t)) {
      $result[] = to_pg_array($t); //siempre entra por está opción por que es array y luego va a leer uno por uno y pasa al else
    } else {
      $t = str_replace('"', '\\"', $t); // Si hay una comillas en el contenido de la variable variable lo agrega \\
	  if ($t == ""){
		  $t = "NULL";//el contenido en blanco lo convierto a Null
	  } else {
		if (!is_numeric($t)) // Verifica si el contenido no es numerico(osea los texto) y lo agrega la comilla " y a los numericos lo deja sin comilla
		$t = '"' . $t . '"';
	  }
      $result[] = $t;
    }
  }
  return '{' . implode(",", $result) . '}'; // format
}

function to_nro_dils($dils) {
	if($dils <> ""){
		$nro_dils = str_replace('_', '', $dils);
		$nro_dils = explode("/", $nro_dils);
		$nro_dils = $nro_dils[1];
	} else {
		$nro_dils = "";
	}
	return $nro_dils;
}

switch ($_POST['accion']) {
  case 'POST_ADD_REGSOLICITUD':
  
  
  $arr_paciente[0] = array($_POST['id_paciente'], $_POST['id_tipodocpac'], $_POST['nro_docpac'], trim($_POST['nom_pac']), trim($_POST['primer_apepac']), trim($_POST['segundo_apepac']), $_POST['id_sexopac'], $_POST['fec_nacpac'], trim($_POST['id_paisnacpac']), trim($_POST['id_etniapac']) , trim($_POST['id_ubigeopac']), trim($_POST['direccion_pac']), $_POST['ref_dirpac'], trim($_POST['nro_telfipac']), trim($_POST['nro_telmopac']), $_POST['email_pac'], $_POST['nro_hcpac']);
  //									1							2								3								4			5						6			7						8						9							10								11							12								13							14					15									16						17
  $arr_atencion[0] = array($_POST['id_tipopaciente'], $_POST['id_tipopacienteprivado'], $_POST['id_tiposeguimiento'], $_POST['fur_pac'], $_POST['fpp_pac'], $_POST['fec_cpn'], $_POST['eg_cpn'], $_POST['id_ipressdiag'], $_POST['det_ipressdiag'], $_POST['id_momentodiag'], $_POST['anio_diagprevio'], $_POST['chk_diagpreviotratamiento'], $_POST['eg_apnmomentodiag'], $_POST['obs_madre'], $_POST['id_tipoculminaembarazo'], $_POST['id_tipoparto'], $_POST['fec_partootro']);
  
  $nro_dils1 = to_nro_dils($_POST['nro_dils1']);
  $nro_dils2 = to_nro_dils($_POST['nro_dils2']);
  $nro_dils3 = to_nro_dils($_POST['nro_dils3']);
  //										1							2			3					4					5			6					7					8				9					10						11								12								13								14								15							16								17							18									19									20										21								22									23								24									25										26									27									28											29											30								31								32						33							34								35							36
  $arr_detatencion[0] = array($_POST['fec_pruebarapida'], $_POST['fec_dils1'], $nro_dils1, $_POST['chk_dils1'], $_POST['fec_dils2'], $nro_dils2, $_POST['chk_dils2'], $_POST['fec_dils3'], $nro_dils3, $_POST['chk_dils3'], $_POST['chk_pacalergica'], $_POST['fec_pacnoalerdosis1'], $_POST['chk_pacnoalerdosis1'], $_POST['fec_pacnoalerdosis2'], $_POST['chk_pacnoalerdosis2'], $_POST['fec_pacnoalerdosis3'], $_POST['chk_pacnoalerdosis3'], $_POST['fec_pacalerprusensi'], $_POST['fec_pacalerprudesensi'], $_POST['chk_pacalerprudesensirefe'], $_POST['chk_pacalertratamientofinal'], $_POST['fec_pacaler1radosis_hosp'], $_POST['chk_pacaler1radosis_hosp'], $_POST['fec_pacaler2dadosis_hosp'], $_POST['chk_pacaler2dadosis_hosp'], $_POST['fec_pacaler3radosis_hosp'], $_POST['chk_pacaler3radosis_hosp'], $_POST['det_pacalerotrotratamiento'], $_POST['fec_inipacalerotrotratamiento'], $_POST['total_dosispacalerotrotratamiento'], $_POST['nro_contactosi'], $_POST['chk_nro_contactosi'], $_POST['nro_contactono'], $_POST['chk_nro_contactono'], $_POST['nro_contactodesco'], $_POST['chk_nro_contactodesco']);
  if($_POST['id_tipoculminaembarazo'] == "1"){
	$nro_menordils1 = to_nro_dils($_POST['nro_menordils1']);
	$nro_menordils2 = to_nro_dils($_POST['nro_menordils2']);
	  //							1						2						3							4							5								6									7					8						9							10						11							12					13								14							15					16							17							18						19							20									21							22							23										24									25								26							27										28									29										30										31							32
	$arr_menor[0] = array($_POST['id_menor'], $_POST['id_tipodocmenor'], $_POST['nro_docmenor'], trim($_POST['nom_menor']), trim($_POST['primer_apemenor']), trim($_POST['segundo_apemenor']), $_POST['id_sexomenor'], $_POST['fec_nacmenor'], $_POST['id_paisnacmenor'], $_POST['id_etniamenor'], $_POST['id_eessnacmenor'], $_POST['nro_hcmenor'], $_POST['id_financiadormenor'], $_POST['peso_nacmenor'], $_POST['eg_nacmenor'], $_POST['apgar_nacmenor'], $_POST['fec_menordils1'], $nro_menordils1, $_POST['chk_menordils1'], trim($_POST['fec_menordils2']), $nro_menordils2, trim($_POST['chk_menordils2']), $_POST['chk_puncionlumbarmenor'], $_POST['fec_puncionlumbarmenor'], $_POST['nro_puncionlumbarmenor'], $_POST['id_estadofinalmenor'], $_POST['chk_tratamientofinalmenor'], $_POST['id_tratamientofinalmenor'], $_POST['fec_initratamientofinalmenor'], $_POST['nro_diatratamientofinalmenor'], $_POST['fec_fallecimientomenor'], $_POST['obs_menor']);
  } else {
	$arr_menor[0] = array('');
  }
  $arr_referencia[0] = array('');
  $arr_seguimiento[0] = array('');

  if($_POST['id'] == "0"){
    $action = "C";
  } else {
    $action = "E";
  }
  $paramReg[0]['accion'] = $action;
  $paramReg[0]['id'] = $_POST['id'];
  $paramReg[0]['paciente'] = to_pg_array($arr_paciente);
  $paramReg[0]['atencion'] = to_pg_array($arr_atencion);
  $paramReg[0]['detatencion'] = to_pg_array($arr_detatencion);
  if($_POST['nro_docmenor'] <> ""){
	$paramReg[0]['menor'] = to_pg_array($arr_menor);
  } else {
	  $paramReg[0]['menor'] = null;
  }
  $paramReg[0]['referencia'] = to_pg_array($arr_referencia);
  $paramReg[0]['seguimiento'] = to_pg_array($arr_seguimiento);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser ."|". $labIdServicioDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $ate->post_reg_its_sifilis($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar la atención";
    exit();
  }
  echo "OK|".$rs;
  exit();
  break;
}
?>

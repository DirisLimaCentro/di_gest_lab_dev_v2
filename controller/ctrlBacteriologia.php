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

require_once '../model/Bacteriologia.php';
$ba = new Bacteriologia();

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

switch ($_POST['accion']) {
    case 'POST_ADD_REGSOLICITUD':
	
	if($_POST['id_servicio'] == ""){$id_servicio=null;} else {$id_servicio=$_POST['id_servicio'];}
	if($_POST['nro_cama'] == ""){$nro_cama=null;} else {$nro_cama=$_POST['nro_cama'];}
	//if($_POST['id_diagnostico'] == ""){$id_diagnostico=null;} else {$id_diagnostico=$_POST['id_diagnostico'];}
	if(trim($_POST['det_diagnostico']) == ""){$det_diagnostico=null;} else {$det_diagnostico=$_POST['det_diagnostico'];}
	if(trim($_POST['nro_muestra']) == ""){$nro_muestra=null;} else {$nro_muestra=$_POST['nro_muestra'];}
	
  $nroArrayD = (int) 0;
  if($_POST['id_diagnostico'] <> ""){
    foreach ($_POST['id_diagnostico'] as $clave=>$valor){
      if ($valor == "99"){
        $diagnostico[$nroArrayD] = array($valor, $det_diagnostico);
      } else {
        $diagnostico[$nroArrayD] = array($valor, '');
      }
      $nroArrayD ++;
    }
  } else {
    $diagnostico[0] = array('');
  }	
	
    $arr_paciente[0] = array($_POST['txtIdPac'], $_POST['txtIdTipDocPac'], $_POST['txtNroDocPac'], trim($_POST['txtNomPac']), trim($_POST['txtPriApePac']), trim($_POST['txtSegApePac']), $_POST['txtIdSexoPac'], $_POST['txtFecNacPac'], trim($_POST['txtNroTelFijoPac']), trim($_POST['txtNroTelMovilPac']) , trim($_POST['txtEmailPac']), trim($_POST['txtUBIGEOPac']), $_POST['txtDirPac'], trim($_POST['txtDirRefPac']), trim($_POST['txtNroHCPac']), $_POST['txtIdPaisNacPac'], $_POST['txtIdEtniaPac']);
    $arr_apoderado[0] = array($_POST['txtIdSoli'], $_POST['txtIdTipDocSoli'], $_POST['txtNroDocSoli'], trim($_POST['txtNomSoli']), trim($_POST['txtPriApeSoli']), trim($_POST['txtSegApeSoli']), $_POST['txtIdSexoSoli'], $_POST['txtFecNacSoli'], trim($_POST['txtNroTelFijoSoli']), trim($_POST['txtNroTelMovilSoli']) , trim($_POST['txtEmailSoli']), $_POST['txtIdPaisNacSoli'], $_POST['txtIdEtniaSoli'], trim($_POST['txtIdParenSoli']));
									// 1						2		3					4								5						6						7										8							9							10					11						12						13									14							15							16							17							18							19
    $arr_solicitud[0] = array($_POST['id_dependencia'], $id_servicio, $nro_cama, $_POST['id_tipomuestra'], $_POST['id_antecedente'], $_POST['id_detantecedente'], $_POST['nro_mestratamiento'], $_POST['id_esquematratamiento'], trim($_POST['det_esquematratamiento']), $nro_muestra, $_POST['id_examen'], $_POST['id_pruebarapida'], $_POST['id_pruebaconvencional'], trim($_POST['desc_factor']), $_POST['fecha_atencion'], $_POST['id_calidadmuestra'], trim($_POST['desc_observacion']), $_POST['txtTipPac'], $_POST['txtIdTipPacParti']);
    $paramReg[0]['accion'] = 'C';
	$paramReg[0]['id'] = 0;
    $paramReg[0]['paciente'] = to_pg_array($arr_paciente);
    $paramReg[0]['apoderado'] = to_pg_array($arr_apoderado);
    $paramReg[0]['solicitud'] = to_pg_array($arr_solicitud);
	$paramReg[0]['diagnostico'] = to_pg_array($diagnostico);
    $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
    /*print_r($paramReg);
	exit();*/
    $rs = $ba->post_reg_solicitud($paramReg);
    if ($rs == "E") {
        echo "ER|Error al ingresar la atención";
        exit();
    }
    echo "OK|".$rs;

    exit();
    break;
	case 'POST_ADD_REGENVIO':
		$nroArrayS = (int) 0;
		$idSolicitud = explode(",", $_POST['id_atencion']);
		foreach ($idSolicitud as $clave => $valor){
			$arr_solicitud[$nroArrayS] = array($valor, '');
			$nroArrayS ++;
		}
		$paramReg[0]['accion'] = 'CE'; //Crear desde Referencia
		$paramReg[0]['id'] = 0;
		$paramReg[0]['detalle'] = to_pg_array($arr_solicitud);
		$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser . "|" . $_POST['id_dependencia_destino'];
		/*print_r($paramReg);
		exit();*/
		$rs = $ba->post_reg_envio($paramReg);
		echo $rs;
	break;
	case 'POST_ADD_REGENVIOLABREF':
		$nroArrayS = (int) 0;
		$idSolicitud = explode(",", $_POST['id_atencion']);
		foreach ($idSolicitud as $clave => $valor){
			$arr_solicitud[$nroArrayS] = array($valor, '');
			$nroArrayS ++;
		}
		$paramReg[0]['accion'] = 'CL'; //Crear desde Referencia
		$paramReg[0]['id'] = 0;
		$paramReg[0]['detalle'] = to_pg_array($arr_solicitud);
		$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser . "|" . $_POST['id_dependencia_destino'];
		/*print_r($paramReg);
		exit();*/
		$rs = $ba->post_reg_envio($paramReg);
		echo $rs;
	break;
	case 'POST_ADD_REGENVIORECEPCIONLABEESS':
		$arr_solicitud[0] = array('');
		$paramReg[0]['accion'] = 'RLE'; //Recepcionar Laboratorio del EESS
		$paramReg[0]['id'] = $_POST['txtIdEnv'];
		$paramReg[0]['detalle'] = to_pg_array($arr_solicitud);
		$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $ba->post_reg_envio($paramReg);
		echo $rs;
	break;
	case 'POST_ADD_REGENVIORECEPCIONLABREF':
		$arr_solicitud[0] = array('');
		$paramReg[0]['accion'] = 'RLR'; //Recepcionar Laboratorio Referencial
		$paramReg[0]['id'] = $_POST['txtIdEnv'];
		$paramReg[0]['detalle'] = to_pg_array($arr_solicitud);
		$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $ba->post_reg_envio($paramReg);
		echo $rs;
	break;
    case 'POST_ADD_REGRESPUESTA':
		$arr_paciente[0] = array('');
		$arr_apoderado[0] = array('');
		$arr_solicitud[0] = array($_POST['id'], $_POST['id_tipprocedimiento'], $_POST['id_calidadmuestra'], trim($_POST['desc_aspecto']), $_POST['id_resultado'], $_POST['nro_colonia'], trim($_POST['desc_observacion']), $_POST['id_estadovalid']);
		$diagnostico[0] = array('');
		$paramReg[0]['accion'] = 'CR';
		$paramReg[0]['id'] = $_POST['id_atencion'];
		$paramReg[0]['paciente'] = to_pg_array($arr_paciente);
		$paramReg[0]['apoderado'] = to_pg_array($arr_apoderado);
		$paramReg[0]['solicitud'] = to_pg_array($arr_solicitud);
		$paramReg[0]['diagnostico'] = to_pg_array($diagnostico);
		$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $ba->post_reg_solicitud($paramReg);
		if ($rs == "E") {
			echo "ER|Error al ingresar la atención";
			exit();
		}
		echo "OK|".$rs;
		exit();
    break;

}
?>

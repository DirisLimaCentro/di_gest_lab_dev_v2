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

require_once '../model/Dependencia.php';
$d = new Dependencia();

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
  case 'GET_SHOW_DETDEPENDENCIA':
  $rs = $d->get_datosDepenendenciaPorId($_POST['idDep']);
  $nr = count($rs);
  if ($nr > 0) {
    $chkTipCorre = "0";
    $nomTipCorre = "NO";
    $chkImpriTicket = "0";
    $nomImpriTicket = "NO";
    $tipImpresora = "";
    $nomTipImpresora = "";
    if($rs[0]['check_tipocorre'] == "t"){
      $chkTipCorre = "1";
      $nomTipCorre = "SI";
    }
    if($rs[0]['check_impriticket'] == "t"){
      $chkImpriTicket = "1";
      $nomImpriTicket = "SI";
    }
    if($rs[0]['tip_impresora'] == "1"){
      $tipImpresora = $rs[0]['tip_impresora'];
      $nomTipImpresora = "TICKETERA";
    }
    if($rs[0]['tip_impresora'] == "2"){
      $tipImpresora = $rs[0]['tip_impresora'];
      $nomTipImpresora = "NORMAL";
    }
    if($rs[0]['check_envlamisede'] == "t"){
      $chkEnvLamiSede = "1";
      $nomEnvLamiSede = "SI";
    } else {
      $chkEnvLamiSede = "0";
      $nomEnvLamiSede = "NO";		
	}
		
    $datos = array(
      0 => $rs[0]['id_dependencia'],
      1 => $rs[0]['id_tipdepen'],
      2 => $rs[0]['nom_tipdepen'],
      3 => trim($rs[0]['codref_depen']),
      4 => trim($rs[0]['abrev_depen']),
      5 => $rs[0]['nom_depen'],
      6 => trim($rs[0]['cat_depen']),
      7 => trim($rs[0]['id_ubigeo']),
      8 => trim($rs[0]['departamento']),
      9 => trim($rs[0]['provincia']),
      10 => trim($rs[0]['distrito']),
      11 => trim($rs[0]['direc_depen']),
      12 => $chkTipCorre,
      13 => $nomTipCorre,
      14 => $chkImpriTicket,
      15 => $nomImpriTicket,
      16 => $tipImpresora,
      17 => $nomTipImpresora,
	  18 => $chkEnvLamiSede,
      19 => $nomEnvLamiSede,
      20 => $rs[0]['id_estado'],
      21 => $rs[0]['nom_estado'],
    );
    echo json_encode($datos);
  } else {
    $datos = array(
      0 => '0'
    );
  }
  break;
  case 'POST_ADD_REGDEPENDENCIA':
  if($_POST['txtIdDep'] == "0"){
    $accion = 'C';
  } else {
    $accion = 'E';
  }
  $arr_area[0] = array($_POST['txtIdDep'], $_POST['txtIdTipDep'], trim($_POST['txtCodRefDep']), trim($_POST['txtAbrevDep']), trim($_POST['txtNomDep']), $_POST['txtIdCatDep'], $_POST['txtIdUbigDep'], trim($_POST['txtDirDep']), trim($_POST['txtTipCorre']), trim($_POST['txtImpriTicket']), trim($_POST['txtTipImpresora']), trim($_POST['txtEnvLamiSede']));
  $paramReg[0]['accion'] = $accion;
  $paramReg[0]['dependencia'] = to_pg_array($arr_area);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $d->post_reg_dependencia($paramReg);
  echo $rs;
  exit();
  break;
}
?>

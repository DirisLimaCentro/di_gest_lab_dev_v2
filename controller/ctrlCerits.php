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

require_once '../model/Cerits.php';
$ce = new Cerits();

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
  $arr_paciente[0] = array($_POST['txtIdPac'], $_POST['txtIdTipDocPac'], $_POST['txtNroDocPac'], trim($_POST['txtNomPac']), trim($_POST['txtPriApePac']), trim($_POST['txtSegApePac']), $_POST['txtIdSexoPac'], $_POST['txtFecNacPac'], trim($_POST['txtNroTelFijoPac']), trim($_POST['txtNroTelMovilPac']) , trim($_POST['txtEmailPac']), trim($_POST['txtUBIGEOPac']), $_POST['txtDirPac'], trim($_POST['txtDirRefPac']), trim($_POST['txtNroHCPac']), $_POST['txtIdPaisNacPac'], $_POST['txtIdEtniaPac']);
  $arr_solicitud[0] = array($_POST['txtIdAtencion'], $_POST['txtTipPac']);

  if($_POST['txtIdAtencion'] == "0"){
    $action = "C";
  } else {
    $action = "E";
  }
  $paramReg[0]['accion'] = $action;
  $paramReg[0]['paciente'] = to_pg_array($arr_paciente);
  $paramReg[0]['solicitud'] = to_pg_array($arr_solicitud);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser ."|". $labIdServicioDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $ce->post_reg_constanciaits($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar la atención";
    exit();
  }
  echo "OK|".$rs;
  exit();
  break;
}
?>

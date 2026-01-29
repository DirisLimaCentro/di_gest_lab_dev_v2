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

require_once '../model/Area.php';
$a = new Area();

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
  case 'GET_SHOW_DETAREA':
  $rs = $a->get_datosAreaPorId($_POST['idArea']);
  $nr = count($rs);
  if ($nr > 0) {
    $datos = array(
      0 => $rs[0]['id_area'],
      1 => $rs[0]['nro_area'],
      2 => $rs[0]['abrev_area'],
      3 => $rs[0]['area'],
      4 => $rs[0]['visible'],
      5 => $rs[0]['nom_visible'],
      6 => $rs[0]['estado'],
      7 => $rs[0]['nom_estado']
    );
    echo json_encode($datos);
  } else {
    $datos = array(
      0 => '0'
    );
  }
  break;
  case 'GET_SHOW_NUEVONROORDAREA':
    $rs = $a->get_datosNueOrdArea();
    echo $rs;
  break;
  case 'POST_ADD_REGAREA':
  if($_POST['txtIdArea'] == "0"){
    $accion = 'C';
  } else {
    $accion = 'E';
  }
  $arr_area[0] = array($_POST['txtIdArea'], $_POST['txtOrdArea'], trim($_POST['txtAbrevArea']), trim($_POST['txtDescArea']), $_POST['txtIdVisiArea'], $_POST['txtIdEstArea']);
  $paramReg[0]['accion'] = $accion;
  $paramReg[0]['area'] = to_pg_array($arr_area);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $a->post_reg_area($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar el usuario";
    exit();
  }
  echo "OK|".$rs;
  exit();
  break;
  case 'GET_REG_CAMBIOORDAREA':
  $arr_area[0] = array($_POST['idArea']);
  $paramReg[0]['accion'] = $_POST['tipAcc'];
  $paramReg[0]['area'] = to_pg_array($arr_area);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $a->post_reg_area($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar el usuario";
    exit();
  }
  echo "OK|".$rs;
  exit();
  break;
  case 'GET_SHOW_NUEVONROORDAREA':
    $rs = $a->get_datosNueOrdArea();
    echo $rs;
  break;
}
?>

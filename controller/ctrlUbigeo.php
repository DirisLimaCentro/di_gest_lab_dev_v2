<?php
session_start();
require_once '../model/Ubigeo.php';
$ub = new Ubigeo();

switch ($_POST['accion']) {
  case 'GET_SHOW_LISTAPROVINCIAANDDISTRITO':
  $rs = $ub->get_listaProvinciaAndDistritoPorIdDepartamento($_POST['idDepPac']);
  echo json_encode($rs);
  break;
}
?>

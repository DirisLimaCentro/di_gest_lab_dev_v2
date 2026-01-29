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

include '../../assets/lib/fpdf/fpdf.php';

require_once '../../model/Lab.php';
$lab = new Lab();

$idAtencion = $_GET['valid'];

$rs = $lab->get_datosTicket_id_atencion($idAtencion);

//print_r($rs['apellidos_pac']); exit();

header("Content-disposition: attachment; filename=ticket.prn");
header("Content-Type: application/force-download");
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 0");
$bod='^XA
^LH0,0
^FO10,15^ADN,10,10^FD' . $rs['apellidos_pac'] . ' ' . $rs['nombres_pac'] . '^FS
^FO10,35^ADN,10,10^FD' . $rs['tipo_documento_pac'] . '. ' . $rs['numero_documento_pac'] . '  Sexo: ' . $rs['sexo_pac'] . '  Edad: ' . $rs['edad_anio_pac'] . '^FS

^FO35,185^ACN,20,15^FA20^FD' . $rs['numero_orden'] . '-' . $rs['codigo_sufijo_muestra'] . '^FS
^BY2,3,200
^FO35,75^BCN,100,N,Y,N^FD' . $rs['numero_orden'] . '-' . $rs['codigo_sufijo_muestra'] . '^FS ^FO50,210^AC1,15,5^FA20^FD' . $rs['fecha_atencion'] . '      ' . $rs['sufijo_muestra'] . '^FS
^XZ';
echo $bod;
?>

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
$labIdRolUser = $_SESSION['labIdRolUser'];

require_once '../../model/Atencion.php';
$ate = new Atencion();

$id_tipodoc = $_GET['idTipDoc'];
$nro_doc = $_GET['nroDoc'];
$nombre_pac = $_GET['nomRS'];
$fecIni = $_GET['fecIni'];
$fecFin = $_GET['fecFin'];
$nro_atencion = $_GET['nroAte'];
$es_urgente = (isset($_GET['optUrgente'])) ? $_GET['optUrgente'] : '';
$id_producto = (isset($_GET['idProducto'])) ? $_GET['idProducto'] : '';
$nro_atencion_otroapp = (isset($_GET['nroAteOtro'])) ? $_GET['nroAteOtro'] : '';
$id_tipoprod = (isset($_GET['id_tipoprod'])) ? $_GET['id_tipoprod'] : '';

//Configure the directory where you have the dompdf
 require_once "../../assets/lib/dompdf/autoload.inc.php";
// Si o si para poder Dompdf
use Dompdf\Dompdf;
$dompdf = new Dompdf();

// Obtener el número de la página actual
$canvas = $dompdf->get_canvas();
$totalPages = $canvas->get_page_count();
$pageNumber = $canvas->get_page_number();
//Imagen cabecera
$ruta_imagen = '../../assets/images/logo_diris.png';
$contenido_imagen = file_get_contents($ruta_imagen);
$base64_image = base64_encode($contenido_imagen);
$src_img = "data:image/png;base64,$base64_image";

$param[0]['id_tipodoc'] = $id_tipodoc;
$param[0]['nro_doc'] = $nro_doc;
$param[0]['nombre_pac'] = $nombre_pac;
$param[0]['fec_cita_ini'] = $fecIni;
$param[0]['fec_cita_fin'] = $fecFin;
$param[0]['idDepAten'] = $labIdDepUser;
$param[0]['nro_atencion'] = $nro_atencion;
$param[0]['es_urgente'] = $es_urgente;
$param[0]['id_producto'] = $id_producto;
$param[0]['nro_atencionotro'] = $nro_atencion_otroapp;
$param[0]['id_tipoprod'] = $id_tipoprod;
$param[0]['id_tipo_correlativo'] = $_SESSION['labIdTipoCorrelativo'];
$param[0]['id_estado_reg_no_asistio'] = 1;

if($nro_atencion <> ""){
	$param[0]['fec_cita_ini'] = "";
	$param[0]['fec_cita_fin'] = "";
}

if($nro_atencion_otroapp <> ""){
	$param[0]['fec_cita_ini'] = "";
	$param[0]['fec_cita_fin'] = "";	
}

if($nombre_pac <> ""){
	$param[0]['fec_cita_ini'] = "";
	$param[0]['fec_cita_fin'] = "";	
}

if($nro_doc <> ""){
	$param[0]['fec_cita_ini'] = "";
	$param[0]['fec_cita_fin'] = "";	
}
$param[0]['origen_dep'] = "";
if($_SESSION['labIdDepUser'] == "67"){
	$param[0]['origen_dep'] = "LR";
}
/*print_r($param);
exit();*/
$rsC = $ate->get_repDatosAtencionCita($param);
//exit(print_r($rsC));

$tamanio_texto = ($_GET['opt_impresion_lista'] == "H")? '12': '10';
$tamanio_datos = ($_GET['opt_impresion_lista'] == "H")? '12': '9';
$tamanio_nro_ate = ($_GET['opt_impresion_lista'] == "H")? '13': '11';
$tamanio_examen = ($_GET['opt_impresion_lista'] == "H")? '11': '10';
$titulo_ate = ($_GET['opt_impresion_lista'] == "H")? 'N° Atención': 'Atención';
$tamanio_hoja = ($_GET['opt_impresion_lista'] == "H")? 'landscape': 'portrait';


$html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>DIRIS - SRLAB</title>
<style>
/* Estilos generales */
body {
    font-family: \'Calibri, sans-serif\';
    font-size: ' . $tamanio_texto . 'px;
    text-align: justify;
    margin-top: 103px;
}
* {
	margin: 2px;
	padding: 1px;
    font-family: \'Arial, Calibri, sans-serif\';
	font-color: color:#000;
}

hr {
    height: 1px;
    padding: 0;
    margin: 1em 0;
    border: 0;
    border-top: 1px solid #CCC;
}

.header {
    margin-bottom: 0px;
}
.footer {
    margin-bottom: 0px;
}
 
/* Estilos para el pie de página */
.footer-container {
    position: fixed;
    bottom: 30px; /* Ajusta la distancia del pie de página desde la parte inferior */
    width: 100%;
    text-align: left;
}

.header-container {
    height: 80px; /* Altura específica del encabezado */
    position: fixed;
    top: 10px;
    left: 0;
    right: 0;
    z-index: 1000;
}
    
.header-container p {
    position: absolute;
    top: 600px; /* Ajusta la posición vertical según necesites */
}

img {
    opacity: 0.5;
    text-align: center;
}

/*Margen superior*/
@page :first {
    margin-top: 5px;
}
@page {
    margin-top: 5px;
}
.page-break {
    page-break-before: always;
}

.linea {
    line-height: normal;
}

.segunda-linea {
    margin-left: 21px; /* Ajusta el margen izquierdo de la segunda línea según tus necesidades */
}

</style>
</head>
<body>
	<div class="header-container">
		<p>
			<table style="border: 1px; width: 100%">
				<tr>
					<td colspan="2" style=""><img src=' . $src_img . ' class="logo" width="350" height="30" style="top:-40px;"/></td>
					<td style="">
						<span style="font-size:16px !important; font-weight: bold;">
							LISTA DE TRABAJO DEL ' . $_GET["fecIni"] . ' AL ' . $_GET["fecFin"] . '
						</span>
					</td>
					<td></td>
					
				</tr>
				<tr>
					<td colspan="2"><b>Establecimiento:</b>' . $_SESSION["labNomDepUser"] . '</td>
					<td colspan="2"><b></b></td>
				</tr>
			</table>
			<table style="border: 1px; width: 100%;">
				<tr>
					<th style="background-color:#B4B3B3; width: 8%; padding: 2px;"> ' . $titulo_ate . ' </th>
					<th style="background-color:#B4B3B3; width: 22%; padding: 2px;">Datos de paciente</th>
					<th style="background-color:#B4B3B3; width: 70%; padding: 3px;">Lista de exámenes</th>
				</tr>
			</table>
		</p>
	</div>
	<div class="page">
		<table style="border: 1px; width: 100%;">';
		foreach ($rsC as $row) {
			if($row['id_tipo_genera_correlativo'] == "1"){
				$nroAtencion = $row['nro_atencion'] . "-". $row['anio_atencion'];
			} else {
				$nroAtencion = substr($row['nro_atencion'], 0, 6)."<b>".substr($row['nro_atencion'],6)."</b>";
			}
			$rsP = $ate->get_datosProductoPorIdAtencionAndIdTipoProducto($row['id'], $_GET['id_tipoprod']);
			$producto = '<table style="width: 100%; border: none">';
			foreach ($rsP as $rowP) {
				//$producto .= $rowP['nom_producto']. '_____________________________________________<br/>';
				$producto .= '<tr><td style="border-bottom: 1px solid #CBC6C6; padding-bottom: 2px;">' . $rowP['nom_producto'] . ':</td></tr>';
			}
			$producto .= '</table>';
			$html .= '
				<tr>
					<td style="width: 8%; text-align: center; padding: 2px; border-bottom: 1px solid black; vertical-align: top; font-size: ' . $tamanio_nro_ate . 'px !important;">'. $nroAtencion . '&nbsp;<br/>'. $row['nro_atencion_orionlab'] .'&nbsp;</td>
					<td style="width: 22%; text-align: left; padding: 2px; border-bottom: 1px solid black; font-size: ' . $tamanio_datos . 'px !important; vertical-align: top">'. $row['abrev_tipodoc'] . ':' . $row['nrodoc'] . ' <b style="padding: 0px; margin: 0px;">HC:</b>' . $row['nro_hc'] . ' <b style="padding: 0px; margin: 0px;">E:</b>' . $row['edad_pac'] . ' <b style="padding: 0px; margin: 0px;">S:</b>' . $row['abrev_sexo'] . '<br/>' . $row['nombre_rs'] . '</td>
					<td style="width: 70%; text-align: left; border-bottom: 1px solid black; font-size: ' . $tamanio_examen . 'px !important; vertical-align: top">' . $producto . '</td>
				</tr>
			';
		}
$html .= '
		</table>
	</div>
</body>
</html>
';
$dompdf->loadHtml($html);

 // (Optional) Setup the paper size and orientation
 $dompdf->setPaper('A4', $tamanio_hoja);
 // Render the HTML as PDF
 $dompdf->render();
 // Output the generated PDF to Browser
 //$dompdf->stream();
 $dompdf->stream("la_hoja_trabajo.pdf", array("Attachment" => false));

?>

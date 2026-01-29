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

require_once '../../model/Bacteriologia.php';
$bac = new Bacteriologia();

class PDF extends FPDF{
}

$pdf=new PDF('L','mm','A5');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,4);
$pdf->SetMargins(8,4,7);
$pdf->AliasNbPages();
$pdf->AddPage();

$idSolicitud = $_GET['id_solicitud'];
$rsSBAC = $bac->get_datosSolicitud($idSolicitud);
if($rsSBAC[0]['id_estadoreg'] == "3"){
	$nombreUser = $_SESSION['labApePatPer'] . " " . $_SESSION['labApeMatPer'] . " " . $_SESSION['labNomPer'];
}
else {
  $nombreUser = "";
  }

$pdf->Ln(1);
$pdf->Image('../../assets/images/logo_diris.png',8,4,55);
$pdf->SetFont('Arial','B',8);
$pdf->SetX(115);
$pdf->MultiCell(60, 3, utf8_decode('Estrategia Sanitaria Prevención y Control de la Tuberculosis'), 0, 'C', false);
$pdf->SetFont('Arial','B',10);

$pdf->Ln(2);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0, 6, utf8_decode('ANEXO N° 1  FORMATO DE SOLICITUD DE INVESTIGACIÓN BACTERIOLÓGICA'),0,1,'C', false);

/*
$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(77, 3, utf8_decode('Dirección de Redes Integradas de Salud Lima Centro Red de Salud:'),0,0,'L', false);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(118, 3, utf8_decode($rsSBAC[0]['dir_depen']),'B',1,'L', false);
*/

$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(10, 3, 'EESS:',0,0,'L', false);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(77, 3, utf8_decode($rsSBAC[0]['nom_depen']),'B',0,'L', false);
$pdf->SetFont('Arial','',7);
$pdf->Cell(15, 3, '2. Servicio:',0,0,'R', false);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(63, 3, utf8_decode($rsSBAC[0]['nom_servicio']),'B',0,'L', false);
$pdf->SetFont('Arial','',7);
$pdf->Cell(15, 3, utf8_decode('Cama N°:'),0,0,'R', false);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(15, 3, $rsSBAC[0]['nro_cama'],1,1,'C', false);

$pdf->Ln(1);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(120, 3, utf8_decode($rsSBAC[0]['nombre_rs']),'B',0,'C', false);
$pdf->SetFont('Arial','',7);
$pdf->Cell(22, 3, 'Edad:',0,0,'R', false);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(15, 3, $rsSBAC[0]['edad_pac'],1,0,'C', false);
$pdf->SetFont('Arial','',7);
$pdf->Cell(23, 3, 'Sexo:',0,0,'R', false);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(15, 3, $rsSBAC[0]['nom_sexo'],1,1,'C', false);
$pdf->SetFont('Arial','',7);
$pdf->Cell(120, 3, 'Apellidos y Nombres',0,1,'C', false);

$pdf->Ln(1);
$pdf->SetX(13);
$pdf->SetFont('Arial','',7);
$pdf->Cell(18, 3, utf8_decode('Hist. Clínica:'),0,0,'L', false);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(32, 3, $rsSBAC[0]['nro_hc'],1,0,'C', false);
$pdf->SetFont('Arial','',7);
$pdf->Cell(15, 3, '',0,0,'L', false);
$pdf->Cell(10, 3, $rsSBAC[0]['abrev_tipodoc'].':',0,0,'R', false);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(40, 3, $rsSBAC[0]['nrodoc'],1,0,'C', false);
$pdf->SetFont('Arial','',7);
$pdf->Cell(7, 3, '',0,0,'L', false);
$pdf->Cell(15, 3, utf8_decode('Teléfono:'),0,0,'R', false);
$telF = "";
$telM = "";
if($rsSBAC[0]['telf_fijo'] <> ""){
  $telF = $rsSBAC[0]['telf_fijo'];
  if($rsSBAC[0]['telf_movil'] <> ""){
    $telM = " / ".$rsSBAC[0]['telf_movil'];
  }
} else {
  $telF = "";
  if($rsSBAC[0]['telf_movil'] <> ""){
    $telM = $rsSBAC[0]['telf_movil'];
  }
}
$pdf->Cell(53, 3, $telF . $telM,1,1,'C', false);

$pdf->Ln(1);
$pdf->SetX(13);
$pdf->SetFont('Arial','',7);
$pdf->Cell(18, 3, utf8_decode('Dirección:'),0,0,'L', false);
$pdf->Cell(172, 3, utf8_decode($rsSBAC[0]['descrip_dir']),'B',1,'L', false);

$pdf->Ln(1);
$pdf->SetX(13);
$pdf->SetFont('Arial','',7);
$pdf->Cell(18, 3, utf8_decode('Provincia:'),0,0,'L', false);
$pdf->Cell(70, 3, utf8_decode($rsSBAC[0]['provincia']),'B',0,'L', false);
$pdf->Cell(13, 3, '',0,0,'L', false);
$pdf->Cell(14, 3, utf8_decode('Distrito:'),0,0,'R', false);
$pdf->Cell(75, 3, utf8_decode($rsSBAC[0]['distrito']),'B',1,'L', false);

$pdf->Ln(1);
$pdf->SetX(13);
$pdf->SetFont('Arial','',7);
$pdf->Cell(18, 3, utf8_decode('Referencia:'),0,0,'L', false);
$pdf->Cell(91, 3, utf8_decode($rsSBAC[0]['descrip_ref']),'B',0,'L', false);
$pdf->Cell(5, 3, '',0,0,'L', false);
$pdf->Cell(26, 3, utf8_decode('Correo electrónico:'),0,0,'R', false);
$pdf->Cell(50, 3, utf8_decode($rsSBAC[0]['emailpac']),'B',1,'L', false);

$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(37, 3, '4. Tipo de Muestra:',0,0,'L', false);
$pdf->Cell(12, 3, 'Esputo:',0,0,'R', false);
$tipME = ($rsSBAC[0]['id_tipmuestra'] == "1") ? 'X' : '';
$tipMO = ($rsSBAC[0]['id_tipmuestra'] == "2") ? 'X' : '';
$pdf->Cell(8, 3, $tipME,1,0,'C', false);
$pdf->Cell(20, 3, 'Otro:',0,0,'R', false);
$pdf->Cell(8, 3, $tipMO,1,0,'C', false);
$pdf->Cell(20, 3, 'Especificar: ',0,0,'R', false);
$pdf->Cell(90, 3, utf8_decode($rsSBAC[0]['tipo_muestra']),'B',1,'L', false);

$pdf->Ln(1);
$pacante = ($rsSBAC[0]['id_antecedente'] == "1") ? 'X' : '';
$pacdetante1 = "";
$pacdetante2 = "";
$pacdetante3 = "";
switch ($rsSBAC[0]['id_detantecedente']) {
  case '1':
  $pacdetante1 = "X";
  break;
  case '2':
  $pacdetante2 = "X";
  break;
  case '3':
  $pacdetante3 = "X";
  break;
}
$pdf->SetFont('Arial','',7);
$pdf->Cell(37, 3, utf8_decode('5. Antecedente de tratamiento:'),0,0,'L', false);
$pdf->Cell(20, 3, 'Nunca Tratado:',0,0,'R', false);
$pdf->Cell(8, 3, $pacante,1,0,'C', false);
$pdf->Cell(37, 3, utf8_decode('Antes Tratado:  Recaída:'),0,0,'R', false);
$pdf->Cell(8, 3, $pacdetante1,1,0,'C', false);
$pdf->Cell(27, 3, utf8_decode('Abandono Recup:'),0,0,'R', false);
$pdf->Cell(8, 3, $pacdetante2,1,0,'C', false);
$pdf->Cell(18, 3, utf8_decode('Fracaso:'),0,0,'R', false);
$pdf->Cell(8, 3, $pacdetante3,1,1,'C', false);

$pdf->Ln(1);
$diag1 = "";
$diag2 = "";
$diag3 = "";
$diag99 = "";

$rsBACD = $bac->get_datosSolicitudDiagnostico($idSolicitud);
if (count($rsBACD) <> "0"){
	foreach ($rsBACD as $rowD) {
		if ($rowD['id_diagnostico'] == "1") $diag1 = 'X';
		if ($rowD['id_diagnostico'] == "2") $diag2 = 'X';
		if ($rowD['id_diagnostico'] == "3") $diag3 = 'X';
		if ($rowD['id_diagnostico'] == "99") $diag99 = $rowD['desc_diagnostico'];
	}	
}

$pdf->SetFont('Arial','',7);
$pdf->Cell(37, 3, utf8_decode('6. Diagnóstico:'),0,0,'L', false);
$pdf->Cell(12, 3, 'S.R.',0,0,'R', false);
$pdf->Cell(8, 3, $diag1,1,0,'C', false);
$pdf->Cell(26, 3, utf8_decode('Seg. Diagnóstico:'),0,0,'R', false);
$pdf->Cell(8, 3, $diag2,1,0,'C', false);
$pdf->Cell(20, 3, 'Rx Anormal:',0,0,'R', false);
$pdf->Cell(8, 3, $diag3,1,0,'C', false);
$pdf->Cell(18, 3, 'Otro:',0,0,'R', false);
$pdf->Cell(58, 3, utf8_decode($diag99),'B',1,'L', false);

$pdf->Ln(1);
$controltrata1 = "";
$controltrata2 = "";
$controltrata3 = "";
$controltrata4 = "";
$controltrata5 = "";
switch ($rsSBAC[0]['id_esquema']) {
  case '1':
  $controltrata1 = "X";
  break;
  case '2':
  $controltrata2 = "X";
  break;
  case '3':
  $controltrata3 = "X";
  break;
  case '4':
  $controltrata4 = "X";
  break;
  case '99':
  $controltrata5 = $rsSBAC[0]['esquema'];
  break;
}
$pdf->SetFont('Arial','',7);
$pdf->Cell(37, 3, utf8_decode('7. Control de tratamiento:'),0,0,'L', false);
$pdf->Cell(12, 3, 'Mes:',0,0,'R', false);
$pdf->Cell(7, 3, $rsSBAC[0]['mes_tratamiento'],1,0,'C', false);
$pdf->Cell(27, 3, utf8_decode('Esq. TB sensible:'),0,0,'R', false);
$pdf->Cell(7, 3, $controltrata1,1,0,'C', false);
$pdf->Cell(17, 3, utf8_decode('Esq. DR:'),0,0,'R', false);
$pdf->Cell(7, 3, $controltrata2,1,0,'C', false);
$pdf->Cell(18, 3, utf8_decode('Esq. MDR:'),0,0,'R', false);
$pdf->Cell(7, 3, $controltrata3,1,0,'C', false);
$pdf->Cell(18, 3, utf8_decode('Esq. XDR:'),0,0,'R', false);
$pdf->Cell(7, 3, $controltrata4,1,0,'C', false);
$pdf->Cell(10, 3, utf8_decode('Otros:'),0,0,'R', false);
$pdf->Cell(21, 3, $controltrata5,1,1,'L', false);

$prusenci1 = "";
$prusenci2 = "";
$prusenci3 = "";
$detprusenci1 = "";
$detprusenci2 = "";
$detprusenci3 = "";
switch ($rsSBAC[0]['id_examen_solicitado']) {
  case '':
  break;
  case '2':
  $prusenci1 = "X";
  $detprusenci1 = $rsSBAC[0]['tipo_prueba_rapida'];
  break;
  case '3':
  $prusenci2 = "X";
  $detprusenci2 = $rsSBAC[0]['tipo_prueba_convencional'];
  break;
  default:
  $prusenci3 = "X";
  $detprusenci3 = '';
  break;
}

$pdf->Ln(1);
$exbaci1 = "";
$exbaci2 = "";
$exbaci3 = "";
switch ($rsSBAC[0]['baciloscopia_nro_muestra']) {
  case '':
  break;
  case '1':
  $exbaci1 = "X";
  break;
  case '2':
  $exbaci2 = "X";
  break;
  default:
  $exbaci3 = $rsSBAC[0]['baciloscopia_nro_muestra'];
  break;
}
$pdf->SetFont('Arial','',7);
$pdf->Cell(37, 3, utf8_decode('8. Ex. solicitado: Baciloscopia:'),0,0,'L', false);
$pdf->Cell(12, 3, '1ra M',0,0,'R', false);
$pdf->Cell(8, 3, $exbaci1,1,0,'C', false);
$pdf->Cell(20, 3, '2da M',0,0,'R', false);
$pdf->Cell(8, 3, $exbaci2,1,0,'C', false);
$pdf->Cell(34, 3, utf8_decode('Otras (especificar N°)'),0,0,'R', false);
$pdf->Cell(15, 3, $exbaci3,1,0,'C', false);
$pdf->Cell(18, 3, 'Cultivo',0,0,'R', false);
$pdf->Cell(19, 3, $prusenci3,1,1,'C', false);

$pdf->Ln(1);
$pdf->SetX(11);
$pdf->SetFont('Arial','',7);
$pdf->Cell(34, 3, utf8_decode('Prueba de Sencibilidad:'),0,0,'L', false);
$pdf->Cell(12, 3, utf8_decode('Rápida:'),0,0,'R', false);
$pdf->Cell(8, 3, $prusenci1,1,0,'C', false);
$pdf->Cell(15, 3, 'Especificar:',0,0,'R', false);
$pdf->Cell(40, 3, utf8_decode($detprusenci1),'B',0,'L', false);
$pdf->Cell(20, 3, utf8_decode('Convencional:'),0,0,'R', false);
$pdf->Cell(8, 3, $prusenci2,1,0,'C', false);
$pdf->Cell(15, 3, 'Especificar:',0,0,'R', false);
$pdf->Cell(40, 3, utf8_decode($detprusenci2),'B',1,'L', false);

$pdf->Ln(1);
$pdf->SetX(11);
$pdf->SetFont('Arial','',7);
$pdf->Cell(34, 3, utf8_decode('Otro examen (especificar):'),0,0,'L', false);
$pdf->Cell(158, 3, utf8_decode($detprusenci3),'B',1,'L', false);

$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(0, 3, utf8_decode('9. Factores de riesgo TB resiente a medicamentos:   '.$rsSBAC[0]['desc_factor']),0,'L', false);

$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(50, 3, utf8_decode('10. Fecha de obtención de la muestra:'),0,0,'L', false);
$pdf->Cell(35, 3, $rsSBAC[0]['fec_atencion'],'B',0,'C', false);
$caliM1 = ($rsSBAC[0]['id_calidadmuestra'] == "1") ? 'X' : '';
$caliM2 = ($rsSBAC[0]['id_calidadmuestra'] == "2") ? 'X' : '';
$pdf->Cell(50, 3, utf8_decode('11. Calidad de la muestra: Adecuada:'),0,0,'R', false);
$pdf->Cell(8, 3, $caliM1,1,0,'C', false);
$pdf->Cell(19, 3, utf8_decode('Inadecuada:'),0,0,'R', false);
$pdf->Cell(8, 3, $caliM2,1,1,'C', false);

$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(0, 3, utf8_decode('12. Datos del solicitante:'),0,1,'L', false);

$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(25, 3, utf8_decode('Apellidos y Nombres:'),0,0,'L', false);
$pdf->Cell(170, 3, utf8_decode($rsSBAC[0]['nombre_rssoli']),'B',1,'L', false);
/*
$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(25, 3, utf8_decode('Teléfono Celular:'),0,0,'L', false);
$telFSoli = "";
$telMSoli = "";
if($rsSBAC[0]['telf_fijosoli'] <> ""){
  $telFSoli = $rsSBAC[0]['telf_fijosoli'];
  if($rsSBAC[0]['telf_movilsoli'] <> ""){
    $telMSoli = " / ".$rsSBAC[0]['telf_movilsoli'];
  }
} else {
  $telFSoli = "";
  if($rsSBAC[0]['telf_movil'] <> ""){
    $telMSoli = $rsSBAC[0]['telf_movilsoli'];
  }
}
$pdf->Cell(50, 3, $telFSoli . $telMSoli,'B',0,'C', false);
$pdf->Cell(5, 3, '',0,0,'L', false);
$pdf->Cell(26, 3, utf8_decode('Correo electrónico:'),0,0,'R', false);
$pdf->Cell(89, 3, utf8_decode($rsSBAC[0]['emailsoli']),'B',1,'L', false);
*/
$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(0, 3, utf8_decode('13. Observaciones:    '.$rsSBAC[0]['desc_observacion']),0,1, false);

$pdf->Ln(1);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(0, 4, utf8_decode('(PARA SER LLENADO POR EL LABORATORIO)'),'LTR',1,'C', false);
$pdf->SetFont('Arial','',7);
$pdf->Cell(0, 3, utf8_decode('14. RESULTADOS'),'LR',1,'L', false);

$pdf->Cell(15, 3, '','L',0,'C', false);
$pdf->Cell(23, 3, '','LTR',0,'C', false);
$pdf->Cell(23, 3, '','LTR',0,'L', false);
$pdf->Cell(20, 3, utf8_decode('N° de'),'LTR',0,'C', false);
$pdf->Cell(37, 3, '','LTR',0,'L', false);
$pdf->Cell(65, 3, 'Resultados (Solo anotar en la casilla correspondiente)',1,0,'C', false);
$pdf->Cell(12, 3, '','R',1,'C', false);

$pdf->Cell(15, 3, '','L',0,'C', false);
$pdf->Cell(23, 3, 'Fecha','LR',0,'C', false);
$pdf->Cell(23, 3, 'Procedimiento','LR',0,'L', false);
$pdf->Cell(20, 3, 'Registro de','LR',0,'C', false);
$pdf->Cell(37, 3, 'Aspecto macroscopico','LR',0,'C', false);
$pdf->Cell(37, 3, 'Resultado','LR',0,'C', false);
$pdf->Cell(28, 3, utf8_decode('N° BARRR/'),'LR',0,'C', false);
$pdf->Cell(12, 3, '','R',1,'C', false);

$pdf->Cell(15, 3, '','L',0,'C', false);
$pdf->Cell(23, 3, '','LR',0,'C', false);
$pdf->Cell(23, 3, '','LR',0,'L', false);
$pdf->Cell(20, 3, 'Laboratorio','LR',0,'C', false);
$pdf->Cell(37, 3, '','LR',0,'C', false);
$pdf->Cell(37, 3, '','LR',0,'C', false);
$pdf->Cell(28, 3, 'Colonias','LR',0,'C', false);
$pdf->Cell(12, 3, '','R',1,'C', false);



$fecresul = "";
$nroregresul = "";
$aspecresul = "";
$resultado = "";
$coloniaresul = "";

$rsRBAC = $bac->get_datosResultado($idSolicitud, 1);
if (count($rsRBAC) <> "0"){
  $fecresul = $rsRBAC[0]['fec_resultado'];
  $nroregresul = $rsRBAC[0]['nro_reglab'];
  $anioregresul = $rsRBAC[0]['anio_reglab'];
  $aspecresul = $rsRBAC[0]['aspecto_macroscopico'];
  $resultado = $rsRBAC[0]['resultado'];
  $coloniaresul = $rsRBAC[0]['nro_colonia'];

}
$pdf->Cell(15, 3, '','L',0,'C', false);
$pdf->Cell(23, 3, $fecresul,1,0,'C', false);
$pdf->Cell(23, 3, 'BASILOSCOPIA',1,0,'L', false);
$pdf->Cell(20, 3, $nroregresul,1,0,'C', false);
$pdf->Cell(37, 3, $aspecresul,1,0,'C', false);
$pdf->Cell(37, 3, $resultado,1,0,'C', false);
$pdf->Cell(28, 3, $coloniaresul,1,0,'C', false);
$pdf->Cell(12, 3, '','R',1,'C', false);

$fecresul = "";
$nroregresul = "";
$aspecresul = "";
$resultado = "";
$coloniaresul = "";
$rsRBAC = "";

$rsRBAC = $bac->get_datosResultado($idSolicitud, 2);
if (count($rsRBAC) <> "0"){
  $fecresul = $rsRBAC[0]['fec_resultado'];
  $nroregresul = $rsRBAC[0]['nro_reglab'];
  $anioregresul = $rsRBAC[0]['anio_reglab'];
  $aspecresul = $rsRBAC[0]['aspecto_macroscopico'];
  $resultado = $rsRBAC[0]['resultado'];
  $coloniaresul = $rsRBAC[0]['nro_colonia'];
}

$pdf->Cell(15, 3, '','L',0,'C', false);
$pdf->Cell(23, 3, $fecresul,1,0,'C', false);
$pdf->Cell(23, 3, 'CULTIVO',1,0,'L', false);
$pdf->Cell(20, 3, $nroregresul,1,0,'C', false);
$pdf->Cell(37, 3, $aspecresul,1,0,'C', false);
$pdf->Cell(37, 3, $resultado,1,0,'C', false);
$pdf->Cell(28, 3, $coloniaresul,1,0,'C', false);
$pdf->Cell(12, 3, '','R',1,'C', false);

$pdf->Cell(0, 2, '','LR',1,'C', false);
$pdf->SetFont('Arial','',7);
$pdf->Cell(50, 3, '15. Apellidos y Nombres del Laboratorista:','L',0,'L', false);
$pdf->Cell(78, 3, utf8_decode($nombreUser),'B',0,'L', false);
$pdf->SetFont('Arial','',7);
$pdf->Cell(28, 3, '16. Fecha de entrega:',0,0,'R', false);
//$pdf->Cell(34, 3, $rsSBAC[0]['fec_entregaresul'],'B',0,'L', false);
$pdf->Cell(34, 3, '','B',0,'L', false);
$pdf->Cell(5, 3, '','R',1,'C', false);

//$pdf->MultiCell(0, 3, utf8_decode('17. Observaciones:  ' . $rsSBAC[0]['descrip_observacionresul']),'LBR','L', false);
$pdf->MultiCell(0, 3, utf8_decode('17. Observaciones:  ' . ''),'LBR','L', false);

$pdf->Output();
?>

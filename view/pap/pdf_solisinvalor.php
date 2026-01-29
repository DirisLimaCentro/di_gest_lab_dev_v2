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
$labNomUser = $_SESSION['labNomUser'];

include '../../assets/lib/fpdf/fpdf.php';

require_once '../../model/Pap.php';
$pap = new Pap();
require_once '../../model/Tipo.php';
$t = new Tipo();

$rsHI = $t->get_datosfecHoraActual();

class PDF extends FPDF{
}

$pdf=new PDF('L','mm','A5');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,4);
$pdf->SetMargins(8,4,8);
$pdf->AliasNbPages();
//$pdf->AddPage();

$idSolicitud = $_GET['id_solicitud'];
$tipo = 0;
if(isset($_GET['id_tipo'])){
	$idSolicitud = $_GET['id_persona'];
	$tipo = $_GET['id_tipo'];
}

$rs = $pap->get_datosSolicitud($idSolicitud, $tipo);
//exit(print_r($rs));
foreach ($rs as $rsSPAP) {
	$id_papsoli = $rsSPAP['id_papsoli'];
	$pdf->AddPage();
	$pdf->Ln(1);
	$pdf->Image('../../assets/images/logo_diris.png',8,4,68);
	$pdf->SetFont('Arial','',8);
	$pdf->SetX(162);
	$pdf->Cell(40, 4, utf8_decode('N° Orden:'), 'LTR', 1, 'L', false);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(162);
	$pdf->Cell(40, 4, $rsSPAP['nro_ordenatencion']."-".$rsSPAP['anio_ordensoli'],'LBR',1,'C', false);
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',11);
	//$pdf->Cell(0, 6, utf8_decode('RED DE SALUD CUIDAD / LABORATORIO DE REFERENCIA DE CITOLOGÍA'),0,1,'C', false);
	$pdf->Cell(0, 6, utf8_decode('LABORATORIO DE REFERENCIA DE CITOLOGÍA'),0,1,'C', false);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0, 6, utf8_decode('EXAMEN CÉRVICO UTERINO PARA PAP'),0,1,'C', false);
	$pdf->SetY(21);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(15, 4, 'HCL.:','LTB',0,'L', false);
	$pdf->SetY(21);
	$pdf->SetX(23);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25, 4, $rsSPAP['nro_hc'],'TBR',1,'L', false);

	$pdf->Ln(2);
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(52, 4, 'ESTABLECIMIENTO DE SALUD:','LTB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(90, 4, utf8_decode($rsSPAP['nom_depen']),'TBR',0,'L', false);
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(23, 4, utf8_decode('FEC. ATENCIÓN:'),'LTB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(29, 4, $rsSPAP['fec_atencion']." ".$rsSPAP['hora_atencion'],'TBR',1,'L', false);

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(42, 4, 'PACIENTE:','LTB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(100, 4, utf8_decode($rsSPAP['nombre_rs']),'TBR',0,'L', false);
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(23, 4, 'EDAD:','LTB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(29, 4, $rsSPAP['edad_pac'],'TBR',1,'L', false);

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(23, 4, utf8_decode($rsSPAP['abrev_tipodoc'].':'),'LTB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(40, 4, utf8_decode($rsSPAP['nrodoc']),'TB',0,'L', false);
	$telF = "";
	$telM = "";
	if($rsSPAP['telf_fijo'] <> ""){
	  $telF = $rsSPAP['telf_fijo'];
	  if($rsSPAP['telf_movil'] <> ""){
		$telM = " / ".$rsSPAP['telf_movil'];
	  }
	} else {
	  $telF = "";
	  if($rsSPAP['telf_movil'] <> ""){
		$telM = $rsSPAP['telf_movil'];
	  }
	}

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(23, 4, utf8_decode('TELÉFONO:'),'LTB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(56, 4, $telF . $telM,'TB',0,'L', false);
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(23, 4, 'TIENE SIS:','LTB',0,'L', false);
	$sis = ($rsSPAP['check_tipopac'] == "t") ? 'SI' : 'NO';
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(29, 4, $sis,'TBR',1,'L', false);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(23, 4, utf8_decode('DIRECCIÓN:'),'LTB',0,'L', false);
	$ref = ($rsSPAP['descrip_ref'] == "") ? '' : ' REF. '.$rsSPAP['descrip_ref'];
	$dir = $rsSPAP['distrito'] . " - " . $rsSPAP['descrip_dir'] . $ref;
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(171, 4, utf8_decode($dir),'TBR',1,'L', false);

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(17, 4, utf8_decode('PESO (Kg):'),'LTB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(10, 4, number_format($rsSPAP['peso_pac'], 2, '.', ''),'TB',0,'L', false);
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(18, 4, utf8_decode('TALLA (Mts):'),'TB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(10, 4, number_format($rsSPAP['talla_pac'], 2, '.', ''),'TB',0,'L', false);
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(19, 4, utf8_decode('P.A. (mmHg):'),'TB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(11, 4, $rsSPAP['pa_pac'],'TB',0,'L', false);

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(6, 4, utf8_decode('IRS:'),'TB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(6, 4, $rsSPAP['edad_iris'],'TB',0,'L', false);

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(8, 4, utf8_decode('FUR:'),'TB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(20, 4, utf8_decode($rsSPAP['fec_fur']),'TB',0,'L', false);
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(10, 4, 'GEST:','TB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(4, 4, $rsSPAP['nro_gest'],'BT',0,'L', false);
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(10, 4, 'PARA:','TB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(13, 4,  $rsSPAP['nro_parapri'] . "-". $rsSPAP['nro_parase'] . "-". $rsSPAP['nro_parater'] . "-". $rsSPAP['nro_paracua'] ,'TB',0,'L', false);
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(17, 4, 'GESTANTE:','TB',0,'L', false);
	$gestante = ($rsSPAP['check_gestante'] == "t") ? 'SI' : 'NO';
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(15, 4, $gestante,'TBR',1,'L', false);

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(33, 4, utf8_decode('ANTICONCEPTIVOS:'),'LTB',0,'L', false);

	$anti1 = '( )';
	$anti2 = '( )';
	$anti3 = '( )';
	$anti4 = '( )';
	$anti5 = '( )';//Ninguno
	$anti6 = '';//Otro
	$anti7 = '( )';

	$rsSPAPA = $pap->get_datosAnticonceptivoPorIdSolicitud($id_papsoli);
	if (count($rsSPAPA) <> 0){
	  foreach ($rsSPAPA as $rowA) {
		if ($rowA['id_tipanticonceptivo'] == "1") $anti1 = '(X)';
		if ($rowA['id_tipanticonceptivo'] == "2") $anti2 = '(X)';
		if ($rowA['id_tipanticonceptivo'] == "3") $anti3 = '(X)';
		if ($rowA['id_tipanticonceptivo'] == "4") $anti4 = '(X)';
		if ($rowA['id_tipanticonceptivo'] == "5") $anti5 = '(X)';
		if ($rowA['id_tipanticonceptivo'] == "7") $anti7 = '(X)';
		if ($rowA['id_tipanticonceptivo'] == "6") $anti6 = $rowA['det_tipanticonceptivo'];
	  }
	}

	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(161, 4, utf8_decode('   DIU' . $anti1 . '   ORAL' . $anti2 . '   INYEC' . $anti3 . '   IMPLANTE' . $anti4 . '   TRH' . $anti7 . '   OTRO: ' . $anti6),'TBR',1,'L', false);

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(41, 4, utf8_decode('TAMIZAJE ANTERIOR:'),'LTB',0,'L', false);
	//$papante = ($rsSPAP['id_tamizajeante'] <> "0") ? 'SI(X)  NO( )' : 'SI( )  NO(X)';
	$papante = $rsSPAP['nom_tamizaje'];
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(27, 4, $papante,'TB',0,'L', false);
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(25, 4, 'RESULTADO:','TB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	if($rsSPAP['id_resultamiante'] <> ""){
	  $resulPosi = ($rsSPAP['id_resultamiante'] == "1") ? '(X)' : '( )';
	  $resulNega = ($rsSPAP['id_resultamiante'] == "2") ? '(X)' : '( )';
	  $pdf->Cell(45, 4, 'NEGATIVO' . $resulNega . '  POSITIVO' . $resulPosi,'TB',0,'L', false);
	} else {
	  $pdf->Cell(45, 4, '--','TB',0,'L', false);
	}

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(25, 4, utf8_decode('AÑO TAMIZAJE:'),'TB',0,'L', false);
	$pdf->SetFont('Arial','' ,8);
	if($rsSPAP['anio_tamizajeante'] <> ""){
	  $pdf->Cell(31, 4, $rsSPAP['anio_tamizajeante'],'TBR',1,'L', false);
	} else {
	  $pdf->Cell(31, 4, '--','TBR',1,'L', false);
	}

	if($rsSPAP['id_tamizajeante'] == "1" OR $rsSPAP['id_tamizajeante'] == "2"){

	  $esca1 = ($rsSPAP['id_anorescamosaante'] == "1") ? '(X)' : '( )';
	  $esca2 = ($rsSPAP['id_anorescamosaante'] == "2") ? '(X)' : '( )';
	  $esca3 = ($rsSPAP['id_anorescamosaante'] == "3") ? '(X)' : '( )';
	  $esca4 = ($rsSPAP['id_anorescamosaante'] == "4") ? '(X)' : '( )';
	  $esca5 = ($rsSPAP['id_anorescamosaante'] == "5") ? '(X)' : '( )';
	  $esca6 = ($rsSPAP['id_anorescamosaante'] == "5") ? '(X)' : '( )';
	  $pdf->SetFont('Arial','' ,8);
	  $pdf->Cell(0, 4, utf8_decode('  ASCUS '.$esca1.'   L.I.E. de bajo grado '.$esca2.'   ASCH '.$esca3.'   L.I.E. de alto grado '.$esca4.'   CARCINOMA IN SITU '.$esca5.'   CARCINOMA INVASOR '.$esca6),'LBR',1,'L', false);

	  $glandu1 = ($rsSPAP['id_anorglandularante'] == "1") ? '(X)' : '( )';
	  $glandu2 = ($rsSPAP['id_anorglandularante'] == "2") ? '(X)' : '( )';
	  $glandu3 = ($rsSPAP['id_anorglandularante'] == "3") ? '(X)' : '( )';
	  $glandu4 = ($rsSPAP['id_anorglandularante'] == "4") ? '(X)' : '( )';
	  $pdf->SetFont('Arial','' ,8);
	  $pdf->Cell(64, 4, utf8_decode('  CÉLULAS GLANDULARES ATÍPICAS '.$glandu1),'L',0,'L', false);
	  $pdf->Cell(130, 4, utf8_decode('  CÉLULAS GLANDULARES ATÍPICAS SUGESTIVAS DE NEOPLASIA '.$glandu2),'R',1,'L', false);
	  $pdf->Cell(64, 4, utf8_decode('  ADENOCARCINOMA IN SITU '.$glandu3),'LB',0,'L', false);
	  $pdf->Cell(130, 4, utf8_decode('  ADENOCARCINOMA '.$glandu4),'BR',1,'L', false);
	  $ejeYimgExa =  71;
	  $ejeYimgFir =  108;
	} else {
	  $ejeYimgExa =  59;
	  $ejeYimgFir =  108;
	}
	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(35, 4, utf8_decode('SÍNTOMAS ACTUALES:'),'LTB',0,'L', false);

	$sinto1 = '( )';
	$sinto2 = '( )';
	$sinto3 = '( )';
	$sinto4 = '( )';
	$sinto5 = '( )';
	$sinto6 = '';//Otro
	$sinto7 = '( )';

	$rsSPAPS = $pap->get_datosSintomaPorIdSolicitud($id_papsoli);
	if (count($rsSPAPS) <> 0){
	  foreach ($rsSPAPS as $rowA) {
		if ($rowA['id_tipsintoma'] == "1") $sinto1 = '(X)';
		if ($rowA['id_tipsintoma'] == "2") $sinto2 = '(X)';
		if ($rowA['id_tipsintoma'] == "3") $sinto3 = '(X)';
		if ($rowA['id_tipsintoma'] == "4") $sinto4 = '(X)';
		if ($rowA['id_tipsintoma'] == "5") $sinto5 = '(X)';
		if ($rowA['id_tipsintoma'] == "7") $sinto7 = '(X)';
		if ($rowA['id_tipsintoma'] == "6") $sinto6 = $rowA['det_tipsintoma'];
	  }
	}
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(159, 4, utf8_decode('   DOLOR' . $sinto2 . '   LEUCORREA' . $sinto3 . '   PRURITO' . $sinto4 . '   COITORRAGIA' . $sinto5 . '  SANGRADO ESPONTÁNEO' . $sinto7 . '   OTRO: ' . $sinto6),'TBR',1,'L', false);

	$exa1 = '( )';
	$exa2 = '( )';
	$exa3 = '( )';
	$exa4 = '( )';
	$exa5 = '( )';

	$rsSPAPE = $pap->get_datosExaCervicoPorIdSolicitud($id_papsoli);
	if (count($rsSPAPE) <> 0){
	  foreach ($rsSPAPE as $rowE) {
		if ($rowE['id_tipexacervico'] == "1") $exa1 = '(X)';
		if ($rowE['id_tipexacervico'] == "2") $exa2 = '(X)';
		if ($rowE['id_tipexacervico'] == "3") $exa3 = '(X)';
		if ($rowE['id_tipexacervico'] == "4") $exa4 = '(X)';
		if ($rowE['id_tipexacervico'] == "5") $exa5 = '(X)';
	  }
	}

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(0, 5, utf8_decode('EXAMEN CERVICO UTERINO (ESPÉCULO)'),'LTR',1,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(0, 4, utf8_decode($exa1 . ' CONGESTIÓN (Amarrillo)'),'LR',1,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(0, 4, utf8_decode($exa2 . ' EROSIÓN (Azul)'),'LR',1,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(0, 4, utf8_decode($exa3 . ' ULCERACIÓN (Rojo)'),'LR',1,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(0, 4, utf8_decode($exa4 . ' PÓLIPOS (Anaranjado)'),'LR',1,'L', false);
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(0, 4, utf8_decode($exa5 . ' TUMORACIÓN (Verde)'),'LR',1,'L', false);
	$pdf->Cell(0, 1, '','LBR',1,'L', false);

	$pdf->SetFont('Arial','B' ,8);
	$pdf->Cell(0, 4, utf8_decode('DIAGNÓSTICO CLÍNICO:'),'LTR',1,'L', false);
	$diag1 = '';
	$diag2 = '';
	$giag3 = '';

	$diag = "";
	$rsPAPD = $pap->get_datosDiagnosticoPorIdSolicitud($id_papsoli);
	if (count($rsPAPD) <> 0){
	  foreach ($rsPAPD as $rowD) {
		  $diag .= $rowD['id_diagnostico'] . " - " . $rowD['nom_cie'] . "     ";
	  }
	}
	$pdf->SetFont('Arial','' ,8);
	$pdf->Cell(0, 4, utf8_decode(trim($diag)),'LBR',1,'L', false);

	$pdf->Image('examen/'.$rsSPAP['id_papsoli'].'.png',95,$ejeYimgExa,44);


		$pdf->Ln(2);
		$pdf->SetFont('Arial','',5);
		$pdf->Cell(78,3,$rsHI[0]['fechora_actual'] . " (".$labNomUser.")",0,0,'');

	$pdf->Ln(5);
	$url = "../genecrud/profesional/";
	$nomArchiJpg = $rsSPAP['id_profesional'].".jpg";
	if (file_exists($url . $nomArchiJpg)) {
	  $pdf->Image($url.$nomArchiJpg,162,$pdf->GetY(),23);
	}
	$nomArchiPng = $rsSPAP['id_profesional'].".png";
	if (file_exists($url . $nomArchiPng)) {
	  $pdf->Image($url.$nomArchiPng,162,$pdf->GetY(),23);
	}

	$pdf->Ln(15);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(78,3,'',0,0,'');
	$pdf->Cell(53,3,utf8_decode(""),0,0,'C');
	$pdf->Cell(7,3,'',0,0,'');
	$pdf->Cell(53,3,utf8_decode($rsSPAP['nombre_rsprof']),'T',1,'C');
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(78,3,'',0,0,'');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(53,3,utf8_decode(""),0,0,'C');
	$pdf->Cell(7,3,'',0,0,'');
	$pdf->Cell(53,3,utf8_decode($rsSPAP['abreviatura_colegiaturaprof']. ". ".$rsSPAP['nro_colegiaturaprof']),0,1,'C');

		if($rsSPAP['id_estadoreg'] == "3" Or $rsSPAP['id_estadoreg'] == "4"){
		  $rsSPAPR = $pap->get_datosResultado($id_papsoli);
		  //print_r($rsSPAPR);
		  if(count($rsSPAPR) <> 0){
			$pdf->AddPage();
			$pdf->Ln(1);
			$pdf->Image('../../assets/images/logo_diris.png',8,4,68);
			$pdf->SetFont('Arial','',8);
			$pdf->SetX(162);
			$pdf->Cell(40, 4, utf8_decode('N° de Registro Laboratorio:'), 'LTR', 1, 'L', false);
			$pdf->SetFont('Arial','B',10);
			$pdf->SetX(162);
			$pdf->Cell(40, 4, $rsSPAPR[0]['nro_reglab'] . "-" . $rsSPAPR[0]['anio_reglab'],'LBR',1,'C', false);
			$pdf->Ln(2);
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(0, 6, utf8_decode('INFORME CITOLÓGICO CÉRVICO UTERINO'),0,1,'C', false);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0, 6, utf8_decode('SISTEMA BETHESDA'),0,1,'C', false);

			$pdf->SetY(21);
			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(15, 4, 'HCL.:','LTB',0,'L', false);
			$pdf->SetY(21);
			$pdf->SetX(23);
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(25, 4, $rsSPAPR[0]['nro_hc'],'TBR',1,'L', false);


			$pdf->SetY(21);
			$pdf->SetX(155);
			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(25, 4, utf8_decode('N° Orden EESS:'),'LTB',0,'L', false);
			$pdf->SetY(21);
			$pdf->SetX(180);
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(22, 4, $rsSPAP['nro_ordenatencion']."-".$rsSPAP['anio_ordensoli'],'TBR',1,'C', false);
			//jose


			//Jose


			$pdf->Ln(2);
			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(52, 4, 'ESTABLECIMIENTO DE SALUD:','LTB',0,'L', false);
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(90, 4, utf8_decode($rsSPAP['nom_depen']),'TBR',0,'L', false);
			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(23, 4, utf8_decode('FEC. ATENCIÓN:'),'LTB',0,'L', false);
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(29, 4, $rsSPAP['fec_atencion']." ".$rsSPAP['hora_atencion'],'TBR',1,'L', false);

			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(25, 4, 'PACIENTE:','LTB',0,'L', false);
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(117, 4, utf8_decode($rsSPAP['nombre_rs']),0,0,'L', false);
			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(23, 4, 'EDAD:','LTB',0,'L', false);
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(29, 4, $rsSPAP['edad_pac'],'TBR',1,'L', false);

			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(23, 4, utf8_decode($rsSPAP['abrev_tipodoc'].':'),'LTB',0,'L', false);
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(40, 4, utf8_decode($rsSPAP['nrodoc']),'TB',0,'L', false);
			$telF = "";
			$telM = "";
			if($rsSPAP['telf_fijo'] <> ""){
			  $telF = $rsSPAP['telf_fijo'];
			  if($rsSPAP['telf_movil'] <> ""){
				$telM = " / ".$rsSPAP['telf_movil'];
			  }
			} else {
			  $telF = "";
			  if($rsSPAP['telf_movil'] <> ""){
				$telM = $rsSPAP['telf_movil'];
			  }
			}

			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(23, 4, utf8_decode('TELÉFONO:'),'LTB',0,'L', false);
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(56, 4, $telF . $telM,'TB',0,'L', false);
			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(23, 4, 'TIENE SIS:','LTB',0,'L', false);
			$sis = ($rsSPAP['check_tipopac'] == "1") ? 'SI(X)  NO( )' : 'SI( )  NO(X)';
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(29, 4, $sis,'TBR',1,'L', false);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(23, 4, utf8_decode('DIRECCIÓN:'),'LTB',0,'L', false);
			$ref = ($rsSPAP['descrip_ref'] == "") ? '' : ' REF. '.$rsSPAP['descrip_ref'];
			$dir = $rsSPAP['distrito'] . " - " . $rsSPAP['descrip_dir'] . $ref;
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(171, 4, utf8_decode($dir),'TBR',1,'L', false);
			
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(62, 4, utf8_decode('PROFESIONAL QUE REALIZÓ LA ATENCIÓN:'),'LTB',0,'L', false);
			$pdf->SetFont('Arial','' ,8);
			$pdf->Cell(132, 4, utf8_decode($rsSPAP['nombre_rsprof']. " - ". $rsSPAP['abreviatura_colegiaturaprof'].". ".$rsSPAP['nro_colegiaturaprof'] .""),'TBR',1,'L', false);

			//Jose

			$pdf->Ln(2);
			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(0, 4, utf8_decode('* CALIDAD DE MUESTRA:'),'LTR',1,'L', false);

			if($rsSPAPR[0]['id_tipinsatisfactoria'] <> ""){
			  $pdf->SetFont('Arial','B',8);
			  $pdf->Cell(29, 4, 'INSATISFACTORIA:','L',0,'L', false);
			  $resulInsa1 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "1") ? '(X)' : '( )';
			  $resulInsa2 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "2") ? '(X)' : '( )';
			  $resulInsa3 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "3") ? '(X)' : '( )';
			  $resulInsa4 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "4") ? '(X)' : '( )';
			  $pdf->SetFont('Arial','' ,8);
			  $pdf->Cell(165, 4, utf8_decode('Escasas células' . $resulInsa1 . ',  >75% Leucocitos PMN' . $resulInsa2 . ',  >75% Hematíes' . $resulInsa3 . ', Mala fijación' . $resulInsa4 . ''),'R',1,'L', false);
			} else {
			  $pdf->SetFont('Arial','B',8);
			  $pdf->Cell(26, 4, 'SATISFACTORIA:','L',0,'L', false);
			  $resulSatis = ($rsSPAPR[0]['id_tipsatisfactoria'] == "1") ? 'Con(X)   ó  Sin( )' : 'Con( )   ó  Sin(X)';
			  $pdf->SetFont('Arial','' ,8);
			  $pdf->Cell(168, 4, utf8_decode($resulSatis . ' Células Endocervicales'),'R',1,'L', false);

			  if($rsSPAPR[0]['negalesion'] == "1"){
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(0, 4, utf8_decode('NEGATIVO PARA LESIÓN INTRAEPITELIAL Y/O MALIGNIDAD: (X)'),'LTBR',1,'L', false);
			  } else {
				if($rsSPAPR[0]['id_anorescamosa'] <> ""){
				  $esca1 = ($rsSPAPR[0]['id_anorescamosa'] == "1") ? '(X)' : '( )';
				  $esca2 = ($rsSPAPR[0]['id_anorescamosa'] == "2") ? '(X)' : '( )';
				  $esca3 = ($rsSPAPR[0]['id_anorescamosa'] == "3") ? '(X)' : '( )';
				  $esca4 = ($rsSPAPR[0]['id_anorescamosa'] == "4") ? '(X)' : '( )';
				  $esca5 = ($rsSPAPR[0]['id_anorescamosa'] == "5") ? '(X)' : '( )';
				  $esca6 = ($rsSPAPR[0]['id_anorescamosa'] == "6") ? '(X)' : '( )';
				  $pdf->SetFont('Arial','B' ,8);
				  $pdf->Cell(0, 4, utf8_decode('ANORMALIDAD DE CÉLULAS EPITELIALES ESCAMOSAS:'),'TLR',1,'L', false);
				  $pdf->SetFont('Arial','' ,8);
				  $pdf->Cell(0, 4, utf8_decode('  ASCUS '.$esca1.'   L.I.E. de bajo grado '.$esca2.'   ASCH '.$esca3.'   L.I.E. de alto grado '.$esca4.'   CARCINOMA IN SITU '.$esca5.'   CARCINOMA INVASOR '.$esca6),'LBR',1,'L', false);
				} else {
				  $glandu1 = ($rsSPAPR[0]['id_anorglandular'] == "1") ? '(X)' : '( )';
				  $glandu2 = ($rsSPAPR[0]['id_anorglandular'] == "2") ? '(X)' : '( )';
				  $glandu3 = ($rsSPAPR[0]['id_anorglandular'] == "3") ? '(X)' : '( )';
				  $glandu4 = ($rsSPAPR[0]['id_anorglandular'] == "4") ? '(X)' : '( )';
				  $pdf->SetFont('Arial','B' ,8);
				  $pdf->Cell(0, 4, utf8_decode('ANORMALIDAD DE CÉLULAS EPITELIALES GLANDULARES:'),'LR',1,'L', false);
				  $pdf->SetFont('Arial','' ,8);
				  $pdf->Cell(64, 4, utf8_decode('  CÉLULAS GLANDULARES ATÍPICAS '.$glandu1),'L',0,'L', false);
				  $pdf->Cell(130, 4, utf8_decode('  CÉLULAS GLANDULARES ATÍPICAS SUGESTIVAS DE NEOPLASIA '.$glandu2),'R',1,'L', false);
				  $pdf->Cell(64, 4, utf8_decode('  ADENOCARCINOMA IN SITU '.$glandu3),'LB',0,'L', false);
				  $pdf->Cell(130, 4, utf8_decode('  ADENOCARCINOMA '.$glandu4),'BR',1,'L', false);
				}
			  }
			  $benig1 = '( )';
			  $benig2 = '( )';
			  $benig3 = '( )';
			  $benig4 = '( )';
			  $benig5 = '( )';
			  $benig6 = '( )';
			  $benig7 = '( )';
			  $benig8 = '( )';
			  $detbenig1 = '( )';
			  $detbenig2 = '( )';
			  $detbenig3 = '( )';

			  $rsSPAPRCC = $pap->get_datosCambioCelPorIdRespuesta($rsSPAPR[0]['id_papresul']);
			  if (count($rsSPAPRCC) <> 0){
				foreach ($rsSPAPRCC as $rowCC) {
				  if ($rowCC['id_tipcambiocel'] == "1") $benig1 = '(X)';
				  if ($rowCC['id_tipcambiocel'] == "2") $benig2 = '(X)';
				  if ($rowCC['id_tipcambiocel'] == "3") $benig3 = '(X)';
				  if ($rowCC['id_tipcambiocel'] == "4") $benig4 = '(X)';
				  if ($rowCC['id_tipcambiocel'] == "5") $benig5 = '(X)';
				  if ($rowCC['id_tipcambiocel'] == "6") $benig6 = '(X)';
				  if ($rowCC['id_tipcambiocel'] == "7") $benig7 = '(X)';
				  if ($rowCC['id_tipcambiocel'] == "8"){
					$benig8 = '(X)';
					if ($rowCC['det_tipcambiocel'] == "1") $detbenig1 = '(X)';
					if ($rowCC['det_tipcambiocel'] == "2") $detbenig2 = '(X)';
					if ($rowCC['det_tipcambiocel'] == "3") $detbenig3 = '(X)';
				  }
				}

				$pdf->SetFont('Arial','B' ,8);
				$pdf->Cell(0, 4, utf8_decode('CAMBIO CELULARES BENIGNOS:'),'LR',1,'L', false);
				$pdf->SetFont('Arial','' ,8);
				$pdf->Cell(64, 4, utf8_decode('  METAPLASIA ESCAMOSA '.$benig1),'L',0,'L', false);
				$pdf->Cell(130, 4, utf8_decode('  CÁNDIDA '.$benig5),'R',1,'L', false);
				$pdf->Cell(64, 4, utf8_decode('  ATROFIA '.$benig2),'L',0,'L', false);
				$pdf->Cell(130, 4, utf8_decode('  VAGINOSIS '.$benig6),'R',1,'L', false);
				$pdf->Cell(64, 4, utf8_decode('  CAMBIO POR DIU '.$benig3),'L',0,'L', false);
				$pdf->Cell(130, 4, utf8_decode('  HERPES '.$benig7),'R',1,'L', false);
				$pdf->Cell(64, 4, utf8_decode('  TRICHOMONAS VAGINALES '.$benig4),'LB',0,'L', false);
				$pdf->Cell(130, 4, utf8_decode('  INFLAMACIÓN PMN '.$benig8.' :  L '.$detbenig1.'  M '.$detbenig2.'  S '.$detbenig3),'BR',1,'L', false);
			  }
			}
			$pdf->SetFont('Arial','B' ,8);
			$pdf->Cell(0, 4, utf8_decode('OBSERVACIONES:'),'LTR',1,'L', false);
			$pdf->SetFont('Arial','' ,8);
			$pdf->MultiCell(0, 4, utf8_decode($rsSPAPR[0]['obs_resul']),'LBR','L', false);

			$pdf->SetFont('Arial','',5);
			$pdf->Cell(78,3,$rsHI[0]['fechora_actual'] . " (".$labNomUser.")",0,0,'');

			$pdf->Ln(5);

			$imgX1 = 40;
			$izq1 = 20;
			$imgX2 = 100;
			$izq2 = 78;
			$imgX3 = 155;
			$izq3 = 135;

			$url = "../genecrud/profesional/";
			$pdf->SetY(110);

			/*$nomArchiJpg = $rsSPAP['id_profesional'].".jpg";
			if (file_exists($url . $nomArchiJpg)) {
			  $pdf->Image($url.$nomArchiJpg,$imgX1,$pdf->GetY(),23);
			}
			$nomArchiPng = $rsSPAP['id_profesional'].".png";
			if (file_exists($url . $nomArchiPng)) {
			  $pdf->Image($url.$nomArchiPng,$imgX1,$pdf->GetY(),23);
			}
			$pdf->Ln(17);
			$pdf->SetFont('Arial','',6);
			$pdf->Cell($izq1,3,'',0,0,'');
			$pdf->Cell(53,3,utf8_decode($rsSPAP['nombre_rsprof']),'T',1,'C');
			$pdf->Cell($izq1,3,'',0,0,'');
			$pdf->Cell(53,3,utf8_decode($rsSPAP['nom_profesionprof']),0,1,'C');
			$pdf->Cell($izq1,3,'',0,0,'');
			$pdf->Cell(53,3,utf8_decode($rsSPAP['abreviatura_colegiaturaprof']. ". ".$rsSPAP['nro_colegiaturaprof']),0,1,'C');*/

			$pdf->SetY(110);
			$nomArchiJpg = $rsSPAPR[0]['id_tecnologo'].".jpg";
			if (file_exists($url . $nomArchiJpg)) {
			  $pdf->Image($url.$nomArchiJpg,$imgX2,$pdf->GetY(),23);
			}
			$nomArchiPng = $rsSPAPR[0]['id_tecnologo'].".png";
			if (file_exists($url . $nomArchiPng)) {
			  $pdf->Image($url.$nomArchiPng,$imgX2,$pdf->GetY(),23);
			}
			$pdf->Ln(17);
			$pdf->SetFont('Arial','',6);
			$pdf->Cell($izq2,3,'',0,0,'');
			$pdf->Cell(53,3,utf8_decode($rsSPAPR[0]['nombre_rstec']),'T',1,'C');
			$pdf->Cell($izq2,3,'',0,0,'');
			$pdf->Cell(53,3,utf8_decode($rsSPAPR[0]['nom_profesiontec']),0,1,'C');
			$pdf->Cell($izq2,3,'',0,0,'');
		    $nro_rnetec = "";
		    if(trim($rsSPAPR[0]['nro_rnetec']) <> ""){
				$nro_rnetec = " - RNE." . $rsSPAPR[0]['nro_rnetec'];
		    }
			$pdf->Cell(53,3,utf8_decode($rsSPAPR[0]['abreviatura_colegiaturatec'].". ".$rsSPAPR[0]['nro_colegiaturatec'] . $nro_rnetec),0,1,'C');

			$pdf->SetY(110);
			$nomArchiJpg = $rsSPAPR[0]['id_encargadolab'].".jpg";
			if (file_exists($url . $nomArchiJpg)) {
			  $pdf->Image($url.$nomArchiJpg,$imgX3,$pdf->GetY(),23);
			}
			$nomArchiPng = $rsSPAPR[0]['id_encargadolab'].".png";
			if (file_exists($url . $nomArchiPng)) {
			  $pdf->Image($url.$nomArchiPng,$imgX3,$pdf->GetY(),23);
			}
			$pdf->Ln(17);
			$pdf->SetFont('Arial','',6);
			$pdf->Cell($izq3,3,'',0,0,'');
			$pdf->Cell(53,3,utf8_decode($rsSPAPR[0]['nombre_rsenclab']),'T',1,'C');
			$pdf->Cell($izq3,3,'',0,0,'');
			$pdf->Cell(53,3,utf8_decode($rsSPAPR[0]['nom_profesionlab']),0,1,'C');
			$pdf->Cell($izq3,3,'',0,0,'');
			$nro_rneenclab = "";
			if(trim($rsSPAPR[0]['nro_rneenclab']) <> ""){
				$nro_rneenclab = " - RNE." . $rsSPAPR[0]['nro_rneenclab'];
			}
			$pdf->Cell(53,3,utf8_decode($rsSPAPR[0]['abreviatura_colegiaturalab'].". ".$rsSPAPR[0]['nro_colegiaturaenclab'] . $nro_rneenclab),0,1,'C');

		  }
		}
}
$pdf->Output();
?>

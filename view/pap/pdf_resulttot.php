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

class PDF extends FPDF{
}

$pdf=new PDF('P','mm','A4');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,4);
$pdf->SetMargins(8,4,8);
$pdf->AliasNbPages();

$rsHI = $t->get_datosfecHoraActual();

if(isset($_GET['id_envio'])){
  $rsC = $pap->get_repDatosDetEnviado($_GET['id_envio']);
  foreach ($rsC as $row) {
    if($row['idestado_envdet'] <> "4"){
      $pdf->AddPage();
      $rsSPAP = $pap->get_datosSolicitud($row['id_papsoli']);
      $rsSPAPR = $pap->get_datosResultado($row['id_papsoli']);
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
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(15, 4, 'HCL.:','LTB',0,'L', false);
      $pdf->SetY(21);
      $pdf->SetX(23);
      $pdf->SetFont('Arial','',9);
      $pdf->Cell(25, 4, $rsSPAPR[0]['nro_hc'],'TBR',1,'L', false);

      $pdf->SetY(21);
      $pdf->SetX(155);
      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(25, 4, utf8_decode('N° Orden EESS:'),'LTB',0,'L', false);
      $pdf->SetY(21);
      $pdf->SetX(180);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(22, 4, $rsSPAP[0]['nro_ordenatencion']."-".$rsSPAP[0]['anio_ordensoli'],'TBR',1,'C', false);

      $pdf->Ln(2);
      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(45, 4, 'ESTABLECIMIENTO DE SALUD:','LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(97, 4, utf8_decode($rsSPAP[0]['nom_depen']),'TBR',0,'L', false);
      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(23, 4, utf8_decode('FEC. ATENCIÓN:'),'LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(29, 4, $rsSPAP[0]['fec_atencion']." ".$rsSPAP[0]['hora_atencion'],'TBR',1,'L', false);

      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(18, 4, 'PACIENTE:','LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(124, 4, utf8_decode($rsSPAP[0]['nombre_rs']),0,0,'L', false);
      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(23, 4, 'EDAD:','LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(29, 4, $rsSPAP[0]['edad_pac'],'TBR',1,'L', false);

      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(23, 4, utf8_decode($rsSPAP[0]['abrev_tipodoc'].':'),'LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(40, 4, utf8_decode($rsSPAP[0]['nrodoc']),'TB',0,'L', false);
      $telF = "";
      $telM = "";
      if($rsSPAP[0]['telf_fijo'] <> ""){
        $telF = $rsSPAP[0]['telf_fijo'];
        if($rsSPAP[0]['telf_movil'] <> ""){
          $telM = " / ".$rsSPAP[0]['telf_movil'];
        }
      } else {
        $telF = "";
        if($rsSPAP[0]['telf_movil'] <> ""){
          $telM = $rsSPAP[0]['telf_movil'];
        } else {
          $telM = " -- ";
        }
      }

      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(23, 4, utf8_decode('TELÉFONO:'),'LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(56, 4, $telF . $telM,'TB',0,'L', false);
      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(23, 4, 'TIENE SIS:','LTB',0,'L', false);
      $sis = ($rsSPAP[0]['check_tipopac'] == "t") ? 'SI(X)  NO( )' : 'SI( )  NO(X)';
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(29, 4, $sis,'TBR',1,'L', false);

      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(19, 4, utf8_decode('DIRECCIÓN:'),'LTB',0,'L', false);
      $ref = ($rsSPAP[0]['descrip_ref'] == "") ? '' : ' REF. '.$rsSPAP[0]['descrip_ref'];
      $dir = $rsSPAP[0]['distrito'] . " - " . $rsSPAP[0]['descrip_dir'] . $ref;
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(175, 4, utf8_decode($dir),'TBR',1,'L', false);
	  
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(62, 4, utf8_decode('PROFESIONAL QUE REALIZÓ LA ATENCIÓN:'),'LTB',0,'L', false);
	  $pdf->SetFont('Arial','' ,8);
	  $pdf->Cell(132, 4, utf8_decode($rsSPAP[0]['nombre_rsprof']. " - ". $rsSPAP[0]['abreviatura_colegiaturaprof'].". ".$rsSPAP[0]['nro_colegiaturaprof'] .""),'TBR',1,'L', false);
	  
      $pdf->Ln(2);
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(0, 4, utf8_decode('* CALIDAD DE MUESTRA:'),'LTR',1,'L', false);

      if($rsSPAPR[0]['id_tipinsatisfactoria'] <> ""){
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(29, 4, 'INSATISFACTORIA:','L',0,'L', false);
        $resulInsa1 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "1") ? '(X)' : '( )';
        $resulInsa2 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "2") ? '(X)' : '( )';
        $resulInsa3 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "3") ? '(X)' : '( )';
        $resulInsa4 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "4") ? '(X)' : '( )';
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(165, 4, utf8_decode('Escasas células' . $resulInsa1 . ',  >75% Leucocitos PMN' . $resulInsa2 . ',  >75% Hematíes' . $resulInsa3 . ', Mala fijación' . $resulInsa4 . ''),'R',1,'L', false);
      } else {
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(26, 4, 'SATISFACTORIA:','L',0,'L', false);
        $resulSatis = ($rsSPAPR[0]['id_tipsatisfactoria'] == "1") ? 'Con(X)   ó  Sin( )' : 'Con( )   ó  Sin(X)';
        $pdf->SetFont('Arial','',9);
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
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(0, 4, utf8_decode('ANORMALIDAD DE CÉLULAS EPITELIALES ESCAMOSAS:'),'TLR',1,'L', false);
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(0, 4, utf8_decode('  ASCUS '.$esca1.'   L.I.E. de bajo grado '.$esca2.'   ASCH '.$esca3.'   L.I.E. de alto grado '.$esca4.'   CARCINOMA IN SITU '.$esca5.'   CARCINOMA INVASOR '.$esca6),'LBR',1,'L', false);
          } else {
            $glandu1 = ($rsSPAPR[0]['id_anorglandular'] == "1") ? '(X)' : '( )';
            $glandu2 = ($rsSPAPR[0]['id_anorglandular'] == "2") ? '(X)' : '( )';
            $glandu3 = ($rsSPAPR[0]['id_anorglandular'] == "3") ? '(X)' : '( )';
            $glandu4 = ($rsSPAPR[0]['id_anorglandular'] == "4") ? '(X)' : '( )';
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(0, 4, utf8_decode('ANORMALIDAD DE CÉLULAS EPITELIALES GLANDULARES:'),'LR',1,'L', false);
            $pdf->SetFont('Arial','',9);
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

          $pdf->SetFont('Arial','B',9);
          $pdf->Cell(0, 4, utf8_decode('CAMBIO CELULARES BENIGNOS:'),'LR',1,'L', false);
          $pdf->SetFont('Arial','',9);
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
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(0, 4, utf8_decode('OBSERVACIONES:'),'LTR',1,'L', false);
      $pdf->SetFont('Arial','',9);
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

      /*$nomArchiJpg = $rsSPAP[0]['id_profesional'].".jpg";
      if (file_exists($url . $nomArchiJpg)) {
        $pdf->Image($url.$nomArchiJpg,$imgX1,$pdf->GetY(),23);
      }
      $nomArchiPng = $rsSPAP[0]['id_profesional'].".png";
      if (file_exists($url . $nomArchiPng)) {
        $pdf->Image($url.$nomArchiPng,$imgX1,$pdf->GetY(),23);
      }
      $pdf->Ln(17);
      $pdf->SetFont('Arial','',6);
      $pdf->Cell($izq1,3,'',0,0,'');
      $pdf->Cell(53,3,utf8_decode($rsSPAP[0]['nombre_rsprof']),'T',1,'C');
      $pdf->Cell($izq1,3,'',0,0,'');
      $pdf->Cell(53,3,utf8_decode($rsSPAP[0]['nom_profesionprof']),0,1,'C');
      $pdf->Cell($izq1,3,'',0,0,'');
      $pdf->Cell(53,3,utf8_decode($rsSPAP[0]['abreviatura_colegiaturaprof'].". ".$rsSPAP[0]['nro_colegiaturaprof']),0,1,'C');*/

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

      /******************************************************************************************************************************************************************************************/
      // jose

      $pdf->SetY(155);

      $pdf->Ln(1);
      $pdf->Image('../../assets/images/logo_diris.png',8,155,68);
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
      $pdf->SetY(173);
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(15, 4, 'HCL.:','LTB',0,'L', false);
      $pdf->SetY(173);
      $pdf->SetX(23);
      $pdf->SetFont('Arial','',9);
      $pdf->Cell(25, 4, $rsSPAPR[0]['nro_hc'],'TBR',1,'L', false);

      /**** Jose ****/
      $pdf->SetY(173);
      $pdf->SetX(155);
      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(25, 4, utf8_decode('N° Orden EESS:'),'LTB',0,'L', false);
      $pdf->SetY(173);
      $pdf->SetX(180);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(22, 4, $rsSPAP[0]['nro_ordenatencion']."-".$rsSPAP[0]['anio_ordensoli'],'TBR',1,'C', false);

      $pdf->Ln(2);
      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(45, 4, 'ESTABLECIMIENTO DE SALUD:','LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(97, 4, utf8_decode($rsSPAP[0]['nom_depen']),'TBR',0,'L', false);
      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(23, 4, utf8_decode('FEC. ATENCIÓN:'),'LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(29, 4, $rsSPAP[0]['fec_atencion']." ".$rsSPAP[0]['hora_atencion'],'TBR',1,'L', false);

      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(18, 4, 'PACIENTE:','LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(124, 4, utf8_decode($rsSPAP[0]['nombre_rs']),0,0,'L', false);
      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(23, 4, 'EDAD:','LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(29, 4, $rsSPAP[0]['edad_pac'],'TBR',1,'L', false);

      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(23, 4, utf8_decode($rsSPAP[0]['abrev_tipodoc'].':'),'LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(40, 4, utf8_decode($rsSPAP[0]['nrodoc']),'TB',0,'L', false);
      $telF = "";
      $telM = "";
      if($rsSPAP[0]['telf_fijo'] <> ""){
        $telF = $rsSPAP[0]['telf_fijo'];
        if($rsSPAP[0]['telf_movil'] <> ""){
          $telM = " / ".$rsSPAP[0]['telf_movil'];
        }
      } else {
        $telF = "";
        if($rsSPAP[0]['telf_movil'] <> ""){
          $telM = $rsSPAP[0]['telf_movil'];
        } else {
          $telM = " -- ";
        }
      }

      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(23, 4, utf8_decode('TELÉFONO:'),'LTB',0,'L', false);
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(56, 4, $telF . $telM,'TB',0,'L', false);
      $pdf->SetFont('Arial','B' ,8);
      $pdf->Cell(23, 4, 'TIENE SIS:','LTB',0,'L', false);
      $sis = ($rsSPAP[0]['check_tipopac'] == "t") ? 'SI(X)  NO( )' : 'SI( )  NO(X)';
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(29, 4, $sis,'TBR',1,'L', false);

      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(19, 4, utf8_decode('DIRECCIÓN:'),'LTB',0,'L', false);
      $ref = ($rsSPAP[0]['descrip_ref'] == "") ? '' : ' REF. '.$rsSPAP[0]['descrip_ref'];
      $dir = $rsSPAP[0]['distrito'] . " - " . $rsSPAP[0]['descrip_dir'] . $ref;
      $pdf->SetFont('Arial','' ,8);
      $pdf->Cell(175, 4, utf8_decode($dir),'TBR',1,'L', false);
	  
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(62, 4, utf8_decode('PROFESIONAL QUE REALIZÓ LA ATENCIÓN:'),'LTB',0,'L', false);
	  $pdf->SetFont('Arial','' ,8);
	  $pdf->Cell(132, 4, utf8_decode($rsSPAP[0]['nombre_rsprof']. " - ". $rsSPAP[0]['abreviatura_colegiaturaprof'].". ".$rsSPAP[0]['nro_colegiaturaprof'] .""),'TBR',1,'L', false);

      $pdf->Ln(2);
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(0, 4, utf8_decode('* CALIDAD DE MUESTRA:'),'LTR',1,'L', false);

      if($rsSPAPR[0]['id_tipinsatisfactoria'] <> ""){
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(29, 4, 'INSATISFACTORIA:','L',0,'L', false);
        $resulInsa1 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "1") ? '(X)' : '( )';
        $resulInsa2 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "2") ? '(X)' : '( )';
        $resulInsa3 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "3") ? '(X)' : '( )';
        $resulInsa4 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "4") ? '(X)' : '( )';
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(165, 4, utf8_decode('Escasas células' . $resulInsa1 . ',  >75% Leucocitos PMN' . $resulInsa2 . ',  >75% Hematíes' . $resulInsa3 . ', Mala fijación' . $resulInsa4 . ''),'R',1,'L', false);
      } else {
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(26, 4, 'SATISFACTORIA:','L',0,'L', false);
        $resulSatis = ($rsSPAPR[0]['id_tipsatisfactoria'] == "1") ? 'Con(X)   ó  Sin( )' : 'Con( )   ó  Sin(X)';
        $pdf->SetFont('Arial','',9);
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
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(0, 4, utf8_decode('ANORMALIDAD DE CÉLULAS EPITELIALES ESCAMOSAS:'),'TLR',1,'L', false);
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(0, 4, utf8_decode('  ASCUS '.$esca1.'   L.I.E. de bajo grado '.$esca2.'   ASCH '.$esca3.'   L.I.E. de alto grado '.$esca4.'   CARCINOMA IN SITU '.$esca5.'   CARCINOMA INVASOR '.$esca6),'LBR',1,'L', false);
          } else {
            $glandu1 = ($rsSPAPR[0]['id_anorglandular'] == "1") ? '(X)' : '( )';
            $glandu2 = ($rsSPAPR[0]['id_anorglandular'] == "2") ? '(X)' : '( )';
            $glandu3 = ($rsSPAPR[0]['id_anorglandular'] == "3") ? '(X)' : '( )';
            $glandu4 = ($rsSPAPR[0]['id_anorglandular'] == "4") ? '(X)' : '( )';
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(0, 4, utf8_decode('ANORMALIDAD DE CÉLULAS EPITELIALES GLANDULARES:'),'LR',1,'L', false);
            $pdf->SetFont('Arial','',9);
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

          $pdf->SetFont('Arial','B',9);
          $pdf->Cell(0, 4, utf8_decode('CAMBIO CELULARES BENIGNOS:'),'LR',1,'L', false);
          $pdf->SetFont('Arial','',9);
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
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(0, 4, utf8_decode('OBSERVACIONES:'),'LTR',1,'L', false);
      $pdf->SetFont('Arial','',9);
      $pdf->MultiCell(0, 4, utf8_decode($rsSPAPR[0]['obs_resul']),'LBR','L', false);

      $pdf->SetFont('Arial','',5);
      $pdf->Cell(78,3,$rsHI[0]['fechora_actual'] . " (".$labNomUser.")",0,0,'');

      $pdf->Ln(5);
      $url = "../genecrud/profesional/";

      $imgX1 = 40;
      $izq1 = 20;
      $imgX2 = 100;
      $izq2 = 78;
      $imgX3 = 155;
      $izq3 = 135;
      $pdf->SetY(260);
      /*$nomArchiJpg = $rsSPAP[0]['id_profesional'].".jpg";
      if (file_exists($url . $nomArchiJpg)) {
        $pdf->Image($url.$nomArchiJpg,$imgX1,$pdf->GetY(),23);
      }
      $nomArchiPng = $rsSPAP[0]['id_profesional'].".png";
      if (file_exists($url . $nomArchiPng)) {
        $pdf->Image($url.$nomArchiPng,$imgX1,$pdf->GetY(),23);
      }
      $pdf->Ln(17);
      $pdf->SetFont('Arial','',6);
      $pdf->Cell($izq1,3,'',0,0,'');
      $pdf->Cell(53,3,utf8_decode($rsSPAP[0]['nombre_rsprof']),'T',1,'C');
      $pdf->Cell($izq1,3,'',0,0,'');
      $pdf->Cell(53,3,utf8_decode("OBSTETRA"),0,1,'C');
      $pdf->Cell($izq1,3,'',0,0,'');
      $pdf->Cell(53,3,utf8_decode("COP. ".$rsSPAP[0]['nro_colegiaturaprof']),0,1,'C');*/

      $pdf->SetY(260);
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

      $pdf->SetY(260);
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
  
} else { //diferente a envio


  $pdf->AddPage();
  $rsSPAP = $pap->get_datosSolicitud($_GET['id_solicitud']);
  $rsSPAPR = $pap->get_datosResultado($_GET['id_solicitud']);
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
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(15, 4, 'HCL.:','LTB',0,'L', false);
  $pdf->SetY(21);
  $pdf->SetX(23);
  $pdf->SetFont('Arial','',9);
  $pdf->Cell(25, 4, $rsSPAPR[0]['nro_hc'],'TBR',1,'L', false);

  $pdf->SetY(21);
  $pdf->SetX(155);
  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(25, 4, utf8_decode('N° Orden EESS:'),'LTB',0,'L', false);
  $pdf->SetY(21);
  $pdf->SetX(180);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(22, 4, $rsSPAP[0]['nro_ordenatencion']."-".$rsSPAP[0]['anio_ordensoli'],'TBR',1,'C', false);

  $pdf->Ln(2);
  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(45, 4, 'ESTABLECIMIENTO DE SALUD:','LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(97, 4, utf8_decode($rsSPAP[0]['nom_depen']),'TBR',0,'L', false);
  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(23, 4, utf8_decode('FEC. ATENCIÓN:'),'LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(29, 4, $rsSPAP[0]['fec_atencion']." ".$rsSPAP[0]['hora_atencion'],'TBR',1,'L', false);

  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(18, 4, 'PACIENTE:','LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(124, 4, utf8_decode($rsSPAP[0]['nombre_rs']),0,0,'L', false);
  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(23, 4, 'EDAD:','LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(29, 4, $rsSPAP[0]['edad_pac'],'TBR',1,'L', false);

  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(23, 4, utf8_decode($rsSPAP[0]['abrev_tipodoc'].':'),'LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(40, 4, utf8_decode($rsSPAP[0]['nrodoc']),'TB',0,'L', false);
  $telF = "";
  $telM = "";
  if($rsSPAP[0]['telf_fijo'] <> ""){
    $telF = $rsSPAP[0]['telf_fijo'];
    if($rsSPAP[0]['telf_movil'] <> ""){
      $telM = " / ".$rsSPAP[0]['telf_movil'];
    }
  } else {
    $telF = "";
    if($rsSPAP[0]['telf_movil'] <> ""){
      $telM = $rsSPAP[0]['telf_movil'];
    } else {
      $telM = " -- ";
    }
  }

  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(23, 4, utf8_decode('TELÉFONO:'),'LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(56, 4, $telF . $telM,'TB',0,'L', false);
  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(23, 4, 'TIENE SIS:','LTB',0,'L', false);
  $sis = ($rsSPAP[0]['check_tipopac'] == "t") ? 'SI(X)  NO( )' : 'SI( )  NO(X)';
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(29, 4, $sis,'TBR',1,'L', false);

  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(19, 4, utf8_decode('DIRECCIÓN:'),'LTB',0,'L', false);
  $ref = ($rsSPAP[0]['descrip_ref'] == "") ? '' : ' REF. '.$rsSPAP[0]['descrip_ref'];
  $dir = $rsSPAP[0]['distrito'] . " - " . $rsSPAP[0]['descrip_dir'] . $ref;
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(175, 4, utf8_decode($dir),'TBR',1,'L', false);
  
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(62, 4, utf8_decode('PROFESIONAL QUE REALIZÓ LA ATENCIÓN:'),'LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(132, 4, utf8_decode($rsSPAP[0]['nombre_rsprof']. " - ". $rsSPAP[0]['abreviatura_colegiaturaprof'].". ".$rsSPAP[0]['nro_colegiaturaprof'] .""),'TBR',1,'L', false);

  $pdf->Ln(2);
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(0, 4, utf8_decode('* CALIDAD DE MUESTRA:'),'LTR',1,'L', false);

  if($rsSPAPR[0]['id_tipinsatisfactoria'] <> ""){
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(29, 4, 'INSATISFACTORIA:','L',0,'L', false);
    $resulInsa1 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "1") ? '(X)' : '( )';
    $resulInsa2 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "2") ? '(X)' : '( )';
    $resulInsa3 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "3") ? '(X)' : '( )';
    $resulInsa4 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "4") ? '(X)' : '( )';
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(165, 4, utf8_decode('Escasas células' . $resulInsa1 . ',  >75% Leucocitos PMN' . $resulInsa2 . ',  >75% Hematíes' . $resulInsa3 . ', Mala fijación' . $resulInsa4 . ''),'R',1,'L', false);
  } else {
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(26, 4, 'SATISFACTORIA:','L',0,'L', false);
    $resulSatis = ($rsSPAPR[0]['id_tipsatisfactoria'] == "1") ? 'Con(X)   ó  Sin( )' : 'Con( )   ó  Sin(X)';
    $pdf->SetFont('Arial','',9);
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
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(0, 4, utf8_decode('ANORMALIDAD DE CÉLULAS EPITELIALES ESCAMOSAS:'),'TLR',1,'L', false);
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(0, 4, utf8_decode('  ASCUS '.$esca1.'   L.I.E. de bajo grado '.$esca2.'   ASCH '.$esca3.'   L.I.E. de alto grado '.$esca4.'   CARCINOMA IN SITU '.$esca5.'   CARCINOMA INVASOR '.$esca6),'LBR',1,'L', false);
      } else {
        $glandu1 = ($rsSPAPR[0]['id_anorglandular'] == "1") ? '(X)' : '( )';
        $glandu2 = ($rsSPAPR[0]['id_anorglandular'] == "2") ? '(X)' : '( )';
        $glandu3 = ($rsSPAPR[0]['id_anorglandular'] == "3") ? '(X)' : '( )';
        $glandu4 = ($rsSPAPR[0]['id_anorglandular'] == "4") ? '(X)' : '( )';
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(0, 4, utf8_decode('ANORMALIDAD DE CÉLULAS EPITELIALES GLANDULARES:'),'LR',1,'L', false);
        $pdf->SetFont('Arial','',9);
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

      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(0, 4, utf8_decode('CAMBIO CELULARES BENIGNOS:'),'LR',1,'L', false);
      $pdf->SetFont('Arial','',9);
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
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(0, 4, utf8_decode('OBSERVACIONES:'),'LTR',1,'L', false);
  $pdf->SetFont('Arial','',9);
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

  /*$nomArchiJpg = $rsSPAP[0]['id_profesional'].".jpg";
  if (file_exists($url . $nomArchiJpg)) {
    $pdf->Image($url.$nomArchiJpg,$imgX1,$pdf->GetY(),23);
  }
  $nomArchiPng = $rsSPAP[0]['id_profesional'].".png";
  if (file_exists($url . $nomArchiPng)) {
    $pdf->Image($url.$nomArchiPng,$imgX1,$pdf->GetY(),23);
  }
  $pdf->Ln(17);
  $pdf->SetFont('Arial','',6);
  $pdf->Cell($izq1,3,'',0,0,'');
  $pdf->Cell(53,3,utf8_decode($rsSPAP[0]['nombre_rsprof']),'T',1,'C');
  $pdf->Cell($izq1,3,'',0,0,'');
  $pdf->Cell(53,3,utf8_decode("OBSTETRA"),0,1,'C');
  $pdf->Cell($izq1,3,'',0,0,'');
  $pdf->Cell(53,3,utf8_decode("COP. ".$rsSPAP[0]['nro_colegiaturaprof']),0,1,'C');*/


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

  $pdf->SetY(155);

  $pdf->Ln(1);
  $pdf->Image('../../assets/images/logo_diris.png',8,155,68);
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
  $pdf->SetY(173);
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(15, 4, 'HCL.:','LTB',0,'L', false);
  $pdf->SetY(173);
  $pdf->SetX(23);
  $pdf->SetFont('Arial','',9);
  $pdf->Cell(25, 4, $rsSPAPR[0]['nro_hc'],'TBR',1,'L', false);

  /**** Jose ****/
  $pdf->SetY(173);
  $pdf->SetX(155);
  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(25, 4, utf8_decode('N° Orden EESS:'),'LTB',0,'L', false);
  $pdf->SetY(173);
  $pdf->SetX(180);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(22, 4, $rsSPAP[0]['nro_ordenatencion']."-".$rsSPAP[0]['anio_ordensoli'],'TBR',1,'C', false);

  $pdf->Ln(2);
  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(45, 4, 'ESTABLECIMIENTO DE SALUD:','LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(97, 4, utf8_decode($rsSPAP[0]['nom_depen']),'TBR',0,'L', false);
  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(23, 4, utf8_decode('FEC. ATENCIÓN:'),'LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(29, 4, $rsSPAP[0]['fec_atencion']." ".$rsSPAP[0]['hora_atencion'],'TBR',1,'L', false);

  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(18, 4, 'PACIENTE:','LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(124, 4, utf8_decode($rsSPAP[0]['nombre_rs']),0,0,'L', false);
  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(23, 4, 'EDAD:','LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(29, 4, $rsSPAP[0]['edad_pac'],'TBR',1,'L', false);

  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(23, 4, utf8_decode($rsSPAP[0]['abrev_tipodoc'].':'),'LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(40, 4, utf8_decode($rsSPAP[0]['nrodoc']),'TB',0,'L', false);
  $telF = "";
  $telM = "";
  if($rsSPAP[0]['telf_fijo'] <> ""){
    $telF = $rsSPAP[0]['telf_fijo'];
    if($rsSPAP[0]['telf_movil'] <> ""){
      $telM = " / ".$rsSPAP[0]['telf_movil'];
    }
  } else {
    $telF = "";
    if($rsSPAP[0]['telf_movil'] <> ""){
      $telM = $rsSPAP[0]['telf_movil'];
    } else {
      $telM = " -- ";
    }
  }

  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(23, 4, utf8_decode('TELÉFONO:'),'LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(56, 4, $telF . $telM,'TB',0,'L', false);
  $pdf->SetFont('Arial','B' ,8);
  $pdf->Cell(23, 4, 'TIENE SIS:','LTB',0,'L', false);
  $sis = ($rsSPAP[0]['check_tipopac'] == "t") ? 'SI(X)  NO( )' : 'SI( )  NO(X)';
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(29, 4, $sis,'TBR',1,'L', false);

  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(19, 4, utf8_decode('DIRECCIÓN:'),'LTB',0,'L', false);
  $ref = ($rsSPAP[0]['descrip_ref'] == "") ? '' : ' REF. '.$rsSPAP[0]['descrip_ref'];
  $dir = $rsSPAP[0]['distrito'] . " - " . $rsSPAP[0]['descrip_dir'] . $ref;
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(175, 4, utf8_decode($dir),'TBR',1,'L', false);
  
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(62, 4, utf8_decode('PROFESIONAL QUE REALIZÓ LA ATENCIÓN:'),'LTB',0,'L', false);
  $pdf->SetFont('Arial','' ,8);
  $pdf->Cell(132, 4, utf8_decode($rsSPAP[0]['nombre_rsprof']. " - ". $rsSPAP[0]['abreviatura_colegiaturaprof'].". ".$rsSPAP[0]['nro_colegiaturaprof'] .""),'TBR',1,'L', false);

  $pdf->Ln(2);
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(0, 4, utf8_decode('* CALIDAD DE MUESTRA:'),'LTR',1,'L', false);

  if($rsSPAPR[0]['id_tipinsatisfactoria'] <> ""){
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(29, 4, 'INSATISFACTORIA:','L',0,'L', false);
    $resulInsa1 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "1") ? '(X)' : '( )';
    $resulInsa2 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "2") ? '(X)' : '( )';
    $resulInsa3 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "3") ? '(X)' : '( )';
    $resulInsa4 = ($rsSPAPR[0]['id_tipinsatisfactoria'] == "4") ? '(X)' : '( )';
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(165, 4, utf8_decode('Escasas células' . $resulInsa1 . ',  >75% Leucocitos PMN' . $resulInsa2 . ',  >75% Hematíes' . $resulInsa3 . ', Mala fijación' . $resulInsa4 . ''),'R',1,'L', false);
  } else {
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(26, 4, 'SATISFACTORIA:','L',0,'L', false);
    $resulSatis = ($rsSPAPR[0]['id_tipsatisfactoria'] == "1") ? 'Con(X)   ó  Sin( )' : 'Con( )   ó  Sin(X)';
    $pdf->SetFont('Arial','',9);
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
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(0, 4, utf8_decode('ANORMALIDAD DE CÉLULAS EPITELIALES ESCAMOSAS:'),'TLR',1,'L', false);
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(0, 4, utf8_decode('  ASCUS '.$esca1.'   L.I.E. de bajo grado '.$esca2.'   ASCH '.$esca3.'   L.I.E. de alto grado '.$esca4.'   CARCINOMA IN SITU '.$esca5.'   CARCINOMA INVASOR '.$esca6),'LBR',1,'L', false);
      } else {
        $glandu1 = ($rsSPAPR[0]['id_anorglandular'] == "1") ? '(X)' : '( )';
        $glandu2 = ($rsSPAPR[0]['id_anorglandular'] == "2") ? '(X)' : '( )';
        $glandu3 = ($rsSPAPR[0]['id_anorglandular'] == "3") ? '(X)' : '( )';
        $glandu4 = ($rsSPAPR[0]['id_anorglandular'] == "4") ? '(X)' : '( )';
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(0, 4, utf8_decode('ANORMALIDAD DE CÉLULAS EPITELIALES GLANDULARES:'),'LR',1,'L', false);
        $pdf->SetFont('Arial','',9);
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

      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(0, 4, utf8_decode('CAMBIO CELULARES BENIGNOS:'),'LR',1,'L', false);
      $pdf->SetFont('Arial','',9);
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
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(0, 4, utf8_decode('OBSERVACIONES:'),'LTR',1,'L', false);
  $pdf->SetFont('Arial','',9);
  $pdf->MultiCell(0, 4, utf8_decode($rsSPAPR[0]['obs_resul']),'LBR','L', false);

  $pdf->SetFont('Arial','',5);
  $pdf->Cell(78,3,$rsHI[0]['fechora_actual'] . " (".$labNomUser.")",0,0,'');

  $pdf->Ln(5);
  $url = "../genecrud/profesional/";

  $imgX1 = 40;
  $izq1 = 20;
  $imgX2 = 100;
  $izq2 = 78;
  $imgX3 = 155;
  $izq3 = 135;
  $pdf->SetY(260);
  /*$nomArchiJpg = $rsSPAP[0]['id_profesional'].".jpg";
  if (file_exists($url . $nomArchiJpg)) {
    $pdf->Image($url.$nomArchiJpg,$imgX1,$pdf->GetY(),23);
  }
  $nomArchiPng = $rsSPAP[0]['id_profesional'].".png";
  if (file_exists($url . $nomArchiPng)) {
    $pdf->Image($url.$nomArchiPng,$imgX1,$pdf->GetY(),23);
  }
  $pdf->Ln(17);
  $pdf->SetFont('Arial','',6);
  $pdf->Cell($izq1,3,'',0,0,'');
  $pdf->Cell(53,3,utf8_decode($rsSPAP[0]['nombre_rsprof']),'T',1,'C');
  $pdf->Cell($izq1,3,'',0,0,'');
  $pdf->Cell(53,3,utf8_decode("OBSTETRA"),0,1,'C');
  $pdf->Cell($izq1,3,'',0,0,'');
  $pdf->Cell(53,3,utf8_decode("COP. ".$rsSPAP[0]['nro_colegiaturaprof']),0,1,'C');*/

  $pdf->SetY(260);
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

  $pdf->SetY(260);
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
$pdf->Output();

?>

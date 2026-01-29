<?php
session_start();

if (!isset($_SESSION["labAccess"])) {
  header("location:../../");
  exit();
}
if ($_SESSION["labAccess"] <> "Yes") {
  header("location:../../");
  exit();
}
$labIdUser = $_SESSION['labIdUser'];
$labIdDepUser = $_SESSION['labIdDepUser'];

include '../../assets/lib/fpdf/fpdf.php';

require_once '../../model/Lab.php';
$la = new Lab();

class PDF extends FPDF
{
  //Cabecera de página
  function Header()
  {
    require_once '../../model/Dependencia.php';
    $d = new Dependencia();
    require_once '../../model/Lab.php';
	$la = new Lab();
    //Logo
    $this->Image('../../assets/images/logo_diris.png',8,8,48);

    $this->SetFont('Arial','B',11);
    $this->Cell(0,7,utf8_decode("SOLICITUD DE PROCESAMIENTO DE EXAMENES"),0,1,'C');

    $this->Ln(2);
    $this->SetFont('Arial','B',8);
    $this->Cell(37,5,utf8_decode("Establecimiento de salud:"),0,0,'L');
    $rsE = $la->get_datosEnvio($_GET['idEnv']);
    $rsD = $d->get_datosDepenendenciaPorId($rsE[0]["id_dependencia_origen"]);
    $this->SetFont('Arial','',8);
    $this->Cell(115,5,utf8_decode($rsD[0]["nom_depen"]),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(12,5,utf8_decode("Distrito:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(76,5,utf8_decode($rsD[0]["distrito"]),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(21,5,utf8_decode("Fecha envío:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(20,5,$rsE[0]["fec_envio"],0,1,'L');

    $this->SetFont('Arial','B',8);
    $this->Cell(30,5,utf8_decode("Examen solicitado:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(210,5,utf8_decode($rsE[0]["nom_producto"]),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(21,5,utf8_decode("Número envío:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(22,5,utf8_decode(str_pad($rsE[0]["nro_envio"],  4, "0", STR_PAD_LEFT) . "-" . $rsE[0]["anio_envio"]),0,1,'L');
	
    $this->SetFont('Arial','B',7);
    $this->Cell(10, 4, utf8_decode('Item'), 'LTR', 0, 'C', false);
	$this->Cell(27, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(97, 4, utf8_decode('Paciente'), 'LTR', 0, 'C', false);
	$this->Cell(23, 4, utf8_decode('H.C.'), 'LTR', 0, 'C', false);
    $this->Cell(18, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(9, 4, utf8_decode('Edad'), 'LTR', 0, 'C', false);
    $this->Cell(6, 4, utf8_decode('SIS'), 'LTR', 0, 'C', false);
	$this->Cell(27, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(64, 4, utf8_decode('Laboratorio'), 1, 1, 'C', false);
    //12
    $this->Cell(10, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(27, 4, utf8_decode('Documento'), 'LBR', 0, 'C', false);	
    $this->Cell(97, 4, utf8_decode(''), 'LBR', 0, 'C', false);
	$this->Cell(23, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(18, 4, utf8_decode('Atención'), 'LBR', 0, 'C', false);
    $this->Cell(9, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(6, 4, utf8_decode(''), 'LBR', 0, 'C', false);
	$this->Cell(27, 4, utf8_decode('Teléfono'), 'LBR', 0, 'C', false);
    $this->Cell(28, 4, utf8_decode('Código / N° registro'), 'LBR', 0, 'C', false);
    $this->Cell(36, 4, utf8_decode('Resultado'), 'LBR', 1, 'C', false);

    //$this->Cell(0, 4, utf8_decode('Resultado'), 1, 1, 'C', false);
  }

  //Pie de página
  function Footer(){
 //Posición: a 1,5 cm del final (Siempre va en el footer)
    $this->SetY(-35);
	/*
    require_once '../../model/Lab.php';
	$la = new Lab();
	$rsE = $la->get_datosEnvio($_GET['idEnv']);
	if($rsE[0]["id_estado_env"] == "4"){
		$this->Image('./psa_firma_miguel_lab_ref.png',150,$this->GetY(),45);
		$this->Image('./psa_visto_bueno_lab_ref.png',210,175,25);
	}*/
    $this->SetFont('Arial','',7);
    $this->Cell(210,4,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'L');
    }
}


  $pdf=new PDF('L','mm','A4');
  //$pdf->SetLeftMargin(6);
  $pdf->SetAutoPageBreak(true,35); //Siempre cuando se va a poner el pie de página
  $pdf->SetMargins(8,6,8);
  $pdf->AliasNbPages();
  $pdf->AddPage();

  //$pdf->Cell(0, 4, 'JOSE', 1, 1, 'L', false);

  $rsC = $la->get_repDatosDetEnviado($_GET['idEnv']);
  /*print_r($rsC);
  exit();*/
  $item = 0;
  foreach ($rsC as $row) {
    $item ++;
	$nroRegLab ='';
	$resulLab = '';
	if($labIdDepUser == "67"){
		if ($row['id_estado_enviodet'] <> "4"){
			$nroRegLab = $row['cod_ref_nro_atencion'];
			$resulLab = $row['det_resul'];
		} else {
			$nroRegLab ='RECHAZADO';
			$resulLab = $row['abrev_rechazo'];
		}
    } else {
		if ($row['id_estado_envio'] == "4"){
			if ($row['id_estado_enviodet'] <> "4"){
				$nroRegLab =$row['cod_ref_nro_atencion'];
				$resulLab = $row['det_resul'];
			} else {
				$nroRegLab ='RECHAZADO';
				$resulLab = $row['abrev_rechazo'];
			}
		}
    }
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(10, 7, $item, 'LBR', 0, 'C', false);
	$pdf->Cell(27, 7, utf8_decode($row['abrev_tipodocpac']. ": ".$row['nro_docpac']), 'LBR', 0, 'L', false);
    $pdf->Cell(97, 7, utf8_decode($row['nombre_rspac']), 'LBR', 0, 'L', false);
	$pdf->Cell(23, 7, utf8_decode($row['nro_hc']), 'LBR', 0, 'C', false);
	$pdf->SetFont('Arial','',8);
	if($row['id_tipo_genera_correlativo'] == "1"){
		$nro_atencion = "<b>".$row['nro_atencion']."-".$row['anio_atencion']."</b>";
	} else {
		$nro_atencion = substr($row['nro_atencion'], 0, 6).substr($row['nro_atencion'],6);
	}	
    $pdf->Cell(18, 7, $nro_atencion, 'BR', 0, 'C', false);
	$pdf->SetFont('Arial','',9);
    $pdf->Cell(9, 7, utf8_decode($row['edad_pac']), 'LBR', 0, 'C', false);
    $pdf->Cell(6, 7, utf8_decode($row['nom_sispac']), 'LBR', 0, 'C', false);
	$pdf->Cell(27, 7, utf8_decode($row['nro_telefono']), 'LBR', 0, 'C', false);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(28, 7, $nroRegLab, 'LBR', 0, 'C', false); //
    $pdf->Cell(36, 7, str_replace(".",",",$resulLab), 'LBR', 1, 'C', false);
  }

  if($item <= 15){
    $pdf->Ln(2);
    $pdf->Cell(75,1,'','',0,'');
    $pdf->Cell(60,1,'','B',0,'');
    $pdf->Cell(18,1,'******','',0,'C');
    $pdf->Cell(60,1,'','B',1,'');
  }

  $pdf->Output();
  ?>

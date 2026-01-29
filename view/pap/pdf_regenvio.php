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

require_once '../../model/Pap.php';
$pap = new Pap();

class PDF extends FPDF
{
  //Cabecera de página
  function Header()
  {
    require_once '../../model/Dependencia.php';
    $d = new Dependencia();
    require_once '../../model/Pap.php';
    $pap = new Pap();
    //Logo
    $this->Image('../../assets/images/logo_diris.png',8,8,48);

    $this->SetFont('Arial','B',11);
    $this->Cell(0,7,utf8_decode("Solicitud de Citología: Registro General (PAP)"),0,1,'C');

    $this->Ln(2);
    $this->SetFont('Arial','B',8);
    $this->Cell(37,5,utf8_decode("Establecimiento de salud:"),0,0,'L');
    $rsE = $pap->get_datosEnvio($_GET['idEnv']);
    $rsD = $d->get_datosDepenendenciaPorId($rsE[0]["id_dependencia"]);
    $this->SetFont('Arial','',8);
    $this->Cell(115,5,utf8_decode($rsD[0]["nom_depen"]),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(12,5,utf8_decode("Distrito:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(76,5,utf8_decode($rsD[0]["distrito"]),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(21,5,utf8_decode("Fecha envío:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(20,5,$rsE[0]["fec_papenvio"],0,1,'L');

    $this->SetFont('Arial','B',8);
    $this->Cell(23,5,utf8_decode("Responsable(s):"),0,0,'L');
    $rsRE = $pap->get_datosResponsableAtencionPorIdEnvio($_GET['idEnv']);
    /*print_r($rsRE);
    exit();*/
    $nRE = 0;
    $cantResp = count($rsRE);
    $nomProf = "";
    $nomProf1 = "";
    foreach ($rsRE as $row) {
      if($nRE == 0){
        $nomProf.= $row['nombre_rsprof'];
      } else {
        if($cantResp <= 3){
          $nomProf.= " / " . $row['nombre_rsprof'];
        } else {
          if($nRE <=3){
            $nomProf.= " / " . $row['nombre_rsprof'];
          } else {
            if($nRE ==4){
              $nomProf1.= $row['nombre_rsprof'];
            } else {
              $nomProf1.= " / " . $row['nombre_rsprof'];
            }
          }
        }
      }
      $nRE ++;
    }
    $this->SetFont('Arial','',8);
    $this->Cell(217,5,utf8_decode($nomProf),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(21,5,utf8_decode("Número envío:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(22,5,utf8_decode(str_pad($rsE[0]["nro_papenv"],  4, "0", STR_PAD_LEFT) . "-" . $rsE[0]["anio_papenv"]),0,1,'L');
    if($nomProf1 <> ""){
      $this->SetFont('Arial','B',8);
      $this->Cell(23,5,utf8_decode(""),0,0,'L');
      $this->SetFont('Arial','',8);
      $this->Cell(217,5,utf8_decode($nomProf1),0,1,'L');
    }
    $this->SetFont('Arial','B',7);
    $this->Cell(10, 4, utf8_decode('Item'), 'LTR', 0, 'C', false);
    $this->Cell(20, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(17, 4, utf8_decode('Abrev.'), 'LTR', 0, 'C', false);
    $this->Cell(90, 4, utf8_decode('Paciente'), 'LTR', 0, 'C', false);
    $this->Cell(26, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(18, 4, utf8_decode('H.C.'), 'LTR', 0, 'C', false);
    $this->Cell(10, 4, utf8_decode('Edad'), 'LTR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode('SIS'), 'LTR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(66, 4, utf8_decode('Laboratorio'), 1, 1, 'C', false);

    //12

    $this->Cell(10, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(20, 4, utf8_decode('Lámina'), 'LBR', 0, 'C', false);
    $this->Cell(17, 4, utf8_decode('Paciente'), 'LBR', 0, 'C', false);
    $this->Cell(90, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(26, 4, utf8_decode('Documento'), 'LBR', 0, 'C', false);
    $this->Cell(18, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(10, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('COP/CMP'), 'LBR', 0, 'C', false);
    $this->Cell(31, 4, utf8_decode('N° Lámina'), 'LBR', 0, 'C', false);
    $this->Cell(35, 4, utf8_decode('Resultado'), 'LBR', 1, 'C', false);

    //$this->Cell(0, 4, utf8_decode('Resultado'), 1, 1, 'C', false);
  }

  //Pie de página
  function Footer()
  {
    //Posición: a 1,5 cm del final (Siempre va en el footer)
    $this->SetY(-30);

    require_once '../../model/Pap.php';
    $pap = new Pap();

    $this->SetFont('Arial','',7);
    $this->Cell(210,4,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'L');
    $url = "../genecrud/profesional/";

    $rsE = $pap->get_datosEnvio($_GET['idEnv']);
    $cntE = count($rsE);
    if($cntE <> 0){
      if($rsE[0]["id_estadoenvio"] <> 4){
        $rsRE = $pap->get_datosResponsableAtencionPorIdEnvio($_GET['idEnv']);
        $cntPR = count($rsRE);
        if($cntPR == 1){
          $imgX1 = 182;
          $izq1 = 160;
        } else if($cntPR == 2){
          $imgX1 = 122;
          $izq1 = 100;
          $imgX2 = 192;
          $izq2 = 170;
        } else if($cntPR == 3){
          $imgX1 = 102;
          $izq1 = 80;
          $imgX2 = 164;
          $izq2 = 140;
          $imgX3 = 222;
          $izq3 = 200;
        } else if($cntPR == 4){
          $imgX1 = 52;
          $izq1 = 30;
          $imgX2 = 112;
          $izq2 = 90;
          $imgX3 = 174;
          $izq3 = 150;
          $imgX4 = 232;
          $izq4 = 210;
        } else if($cntPR == 5){
          $imgX1 = 25;
          $izq1 = 3;
          $imgX2 = 80;
          $izq2 = 58;
          $imgX3 = 137;
          $izq3 = 113;
          $imgX4 = 190;
          $izq4 = 168;
          $imgX5 = 247;
          $izq5 = 224;
        }
        $cnt = 1;
        /*print_r($cntPR);
        exit();*/
        foreach ($rsRE as $row) {
          if($cntPR == 1){
            $nomArchiJpg = $row['id_profesional'].".jpg";
            if (file_exists($url . $nomArchiJpg)) {
              $this->Image($url.$nomArchiJpg,$imgX1,$this->GetY(),23);
            }
            $nomArchiPng = $row['id_profesional'].".png";
            if (file_exists($url . $nomArchiPng)) {
              $this->Image($url.$nomArchiPng,$imgX1,$this->GetY(),23);
            }
            $this->Ln(15);
            $this->SetFont('Arial','',6);
            $this->Cell($izq1,3,'',0,0,'');
            $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
            $this->SetFont('Arial','',5);
            $this->Cell($izq1,3,'',0,0,'');
            $this->SetFont('Arial','',6);
            $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
          }
          if($cntPR == 2){
            if($cnt == 1){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX1,$this->GetY(),23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX1,$this->GetY(),23);
              }
              $this->Ln(15);
              $this->SetFont('Arial','',6);
              $this->Cell($izq1,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq1,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
            if($cnt == 2){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX2,$this->GetY()-23,23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX2,$this->GetY()-23,23);
              }
              $this->SetY(195);
              $this->SetFont('Arial','',6);
              $this->Cell($izq2,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq2,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
          }
          if($cntPR == 3){
            if($cnt == 1){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX1,$this->GetY(),23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX1,$this->GetY(),23);
              }
              $this->Ln(15);
              $this->SetFont('Arial','',6);
              $this->Cell($izq1,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq1,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
            if($cnt == 2){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX2,$this->GetY()-20,23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX2,$this->GetY()-20,23);
              }
              $this->SetY(195);
              $this->SetFont('Arial','',6);
              $this->Cell($izq2,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq2,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
            if($cnt == 3){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX3,$this->GetY()-20,23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX3,$this->GetY()-20,23);
              }
              $this->SetY(195);
              $this->SetFont('Arial','',6);
              $this->Cell($izq3,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq3,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
          }
          if($cntPR == 4){
            if($cnt == 1){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX1,$this->GetY(),23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX1,$this->GetY(),23);
              }
              $this->Ln(15);
              $this->SetFont('Arial','',6);
              $this->Cell($izq1,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq1,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
            if($cnt == 2){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX2,$this->GetY()-20,23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX2,$this->GetY()-20,23);
              }
              $this->SetY(195);
              $this->SetFont('Arial','',6);
              $this->Cell($izq2,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq2,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
            if($cnt == 3){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX3,$this->GetY()-20,23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX3,$this->GetY()-20,23);
              }
              $this->SetY(195);
              $this->SetFont('Arial','',6);
              $this->Cell($izq3,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq3,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
            if($cnt == 4){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX4,$this->GetY()-20,23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX4,$this->GetY()-20,23);
              }
              $this->SetY(195);
              $this->SetFont('Arial','',6);
              $this->Cell($izq4,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq4,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
          }
		  if($cntPR == 5){
            if($cnt == 1){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX1,$this->GetY(),23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX1,$this->GetY(),23);
              }
              $this->Ln(15);
              $this->SetFont('Arial','',6);
              $this->Cell($izq1,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq1,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
            if($cnt == 2){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX2,$this->GetY()-20,23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX2,$this->GetY()-20,23);
              }
              $this->SetY(195);
              $this->SetFont('Arial','',6);
              $this->Cell($izq2,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq2,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
            if($cnt == 3){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX3,$this->GetY()-20,23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX3,$this->GetY()-20,23);
              }
              $this->SetY(195);
              $this->SetFont('Arial','',6);
              $this->Cell($izq3,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq3,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
            if($cnt == 4){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX4,$this->GetY()-20,23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX4,$this->GetY()-20,23);
              }
              $this->SetY(195);
              $this->SetFont('Arial','',6);
              $this->Cell($izq4,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq4,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
            if($cnt == 5){
              $nomArchiJpg = $row['id_profesional'].".jpg";
              if (file_exists($url . $nomArchiJpg)) {
                $this->Image($url.$nomArchiJpg,$imgX5,$this->GetY()-20,23);
              }
              $nomArchiPng = $row['id_profesional'].".png";
              if (file_exists($url . $nomArchiPng)) {
                $this->Image($url.$nomArchiPng,$imgX5,$this->GetY()-20,23);
              }
              $this->SetY(195);
              $this->SetFont('Arial','',6);
              $this->Cell($izq5,3,'',0,0,'');
              $this->Cell(53,3,utf8_decode($row['nombre_rsprof']),'T',1,'C');
              $this->SetFont('Arial','',5);
              $this->Cell($izq5,3,'',0,0,'');
              $this->SetFont('Arial','',6);
              $this->Cell(53,3,utf8_decode($row['abreviatura_colegiatura'].". ".$row['nro_colegiatura']),0,1,'C');
            }
          }
          $cnt ++;
        }
    } else {
      $rsPAP = $pap->get_datosResponsableValidaLaboratorioPorIdEnvio($_GET['idEnv']);
      //print_r($rsPAP);

      $imgX1 = 122;
      $izq1 = 100;
      $imgX2 = 192;
      $izq2 = 170;




        $nomArchiJpg = $rsPAP[0]['id_tecnologo'].".jpg";
        if (file_exists($url . $nomArchiJpg)) {
          $this->Image($url.$nomArchiJpg,$imgX1,$this->GetY(),23);
        }
        $nomArchiPng = $rsPAP[0]['id_tecnologo'].".png";
        if (file_exists($url . $nomArchiPng)) {
          $this->Image($url.$nomArchiPng,$imgX1,$this->GetY(),23);
        }
        $this->Ln(15);
        $this->SetFont('Arial','',6);
        $this->Cell($izq1,3,'',0,0,'');
        $this->Cell(53,3,utf8_decode($rsPAP[0]['nombre_rstec']),'T',1,'C');
        $this->SetFont('Arial','',5);
        $this->Cell($izq1,3,'',0,0,'');
        $this->SetFont('Arial','',6);
        $this->Cell(53,3,utf8_decode($rsPAP[0]['abreviatura_colegiaturatec'].". ".$rsPAP[0]['nro_colegiaturatec']),0,1,'C');
        //encargada
        $nomArchiJpg = $rsPAP[0]['id_encargadolab'].".jpg";
        if (file_exists($url . $nomArchiJpg)) {
          $this->Image($url.$nomArchiJpg,$imgX2,$this->GetY()-23,23);
        }
        $nomArchiPng = $rsPAP[0]['id_encargadolab'].".png";
        if (file_exists($url . $nomArchiPng)) {
          $this->Image($url.$nomArchiPng,$imgX2,$this->GetY()-23,23);
        }
        $this->SetY(195);
        $this->SetFont('Arial','',6);
        $this->Cell($izq2,3,'',0,0,'');
        $this->Cell(53,3,utf8_decode($rsPAP[0]['nombre_rsenclab']),'T',1,'C');
        $this->SetFont('Arial','',5);
        $this->Cell($izq2,3,'',0,0,'');
        $this->SetFont('Arial','',6);
        $this->Cell(53,3,utf8_decode($rsPAP[0]['abreviatura_colegiaturalab'].". ".$rsPAP[0]['nro_colegiaturaenclab']),0,1,'C');
    }
  }
    }
  }

  $pdf=new PDF('L','mm','A4');
  //$pdf->SetLeftMargin(6);
  $pdf->SetAutoPageBreak(true,35); //Siempre cuando se va a poner el pie de página
  $pdf->SetMargins(8,6,8);
  $pdf->AliasNbPages();
  $pdf->AddPage();

  //$pdf->Cell(0, 4, 'JOSE', 1, 1, 'L', false);

  $rsC = $pap->get_repDatosDetEnviado($_GET['idEnv']);
  /*print_r($rsC);
  exit();*/
  $item = 0;
  foreach ($rsC as $row) {
    $item ++;
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(10, 7, $item, 'LBR', 0, 'C', false);
    $pdf->Cell(20, 7, $row['nro_ordensoli']."-".$row['anio_ordensoli'], 'BR', 0, 'C', false);

    $arrNomFalle = explode(" ", $row['nombre_pac']);
    $cntNomFalle = count($arrNomFalle);
    $priNomFalle = mb_substr($arrNomFalle[0], 0, 1); // porción1
    $otroNomFalle = "";
    for($i = 1; $i < $cntNomFalle; $i++){
      $otroNomFalle.= "".mb_substr($arrNomFalle[$i], 0, 1);
    }

    if($labIdDepUser == "67"){
      if($row['nro_reglab'] == ""){
        $nroRegLab = "";
        $resulLab = "";
      } else {
        $nroRegLab = $row['nro_reglab'] . "-" . $row['anio_reglab'];
        if($row['idestado_env'] == "4"){
          $resulLab = $row['nom_resul'];
        } else {
          $resulLab = "";
        }
      }
    } else {
      $nroRegLab = "";
      $resulLab = "";
      if($row['idestado_env'] == "4"){
        $nroRegLab = $row['nro_reglab'] . "-" . $row['anio_reglab'];
        $resulLab = $row['nom_resul'];
      }
    }

    $pdf->Cell(17, 7, utf8_decode($row['abrev_rspac'].$priNomFalle.$otroNomFalle), 'LBR', 0, 'C', false);
    $pdf->Cell(90, 7, utf8_decode($row['nombre_rspac']), 'LBR', 0, 'L', false);
    $pdf->Cell(26, 7, utf8_decode($row['abrev_tipodocpac']. ": ".$row['nro_docpac']), 'LBR', 0, 'L', false);
    $pdf->Cell(18, 7, utf8_decode($row['nro_hc']), 'LBR', 0, 'C', false);
    $pdf->Cell(10, 7, utf8_decode($row['edad_pac']), 'LBR', 0, 'C', false);
    $pdf->Cell(8, 7, utf8_decode($row['nom_sispac']), 'LBR', 0, 'C', false);
    $pdf->Cell(16, 7, utf8_decode($row['nro_coleprofe']), 'LBR', 0, 'C', false);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(31, 7, $nroRegLab, 'LBR', 0, 'C', false);
    $pdf->Cell(35, 7, $resulLab, 'LBR', 1, 'C', false);
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

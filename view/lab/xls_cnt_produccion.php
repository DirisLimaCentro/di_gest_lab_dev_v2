<?php
ini_set('memory_limit', '2048M');
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

require_once '../../model/Atencion.php';
$at = new Atencion();
require_once '../../model/Producto.php';
$pr = new Producto();
require_once '../../model/Dependencia.php';
$d = new Dependencia();


/** Include PHPExcel */
require_once '../../assets/lib/PHPExcel/Classes/PHPExcel.php';
require_once '../../assets/lib/PHPExcel/Classes/PHPExcel/IOFactory.php';

/*
// Set document properties
$objPHPExcel->getProperties()->setCreator("DIRIS-OTI")
->setLastModifiedBy("DIRIS-OTI")
->setTitle("Office 2007 XLSX Test Document")
->setSubject("Office 2007 XLSX Test Document")
->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
->setKeywords("office 2007 openxml php")
->setCategory("Test result file");
*/

$file_path = "plantilla_xls_cnt_atencion.xlsx";
$objPHPExcel = new PHPExcel();


$estiloInformacionTitulotprod = new PHPExcel_Style();
$estiloInformacionTitulotprod->applyFromArray(array(
  'font' => array(
    'name' => 'Calibri',
	'bold' => true,
    'size' => 9,
    'color' => array(
      'rgb' => '000000'
    )
  ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array(
        'rgb' => '3a2a47'
      )
    )
  ),
  'alignment' => array(
    //'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  ),
)
);

$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray(array(
  'font' => array(
    'name' => 'Calibri',
    'size' => 9,
    'color' => array(
      'rgb' => '000000'
    )
  ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array(
        'rgb' => '3a2a47'
      )
    ),
    'top' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array(
        'rgb' => '3a2a47'
      )
    )
  ),
)
);

$estiloNumero = new PHPExcel_Style();
$estiloNumero->applyFromArray(array(
  'font' => array(
    'name' => 'Calibri',
	'bold' => true,
    'size' => 9,
    'color' => array(
      'rgb' => '000000'
    )
  ),
  'numberformat' => array(
    'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER
  ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array(
        'rgb' => '3a2a47'
      )
    ),
    'top' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array(
        'rgb' => '3a2a47'
      )
    )
  ),
)
);

$estiloNumerocuerpo = new PHPExcel_Style();
$estiloNumerocuerpo->applyFromArray(array(
  'font' => array(
    'name' => 'Calibri',
	'bold' => false,
    'size' => 9,
    'color' => array(
      'rgb' => '000000'
    )
  ),
  'numberformat' => array(
    'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER
  ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array(
        'rgb' => '3a2a47'
      )
    ),
    'top' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array(
        'rgb' => '3a2a47'
      )
    )
  ),
)
);


try {
	$inputFileType = PHPExcel_IOFactory::identify($file_path);
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	//  Tell the reader to include charts when it loads a file
	$objReader->setIncludeCharts(TRUE);
	//  Load the file
	$objPHPExcel = $objReader->load($file_path);
} catch (Exception $e) {
    exit('Error cargando el archivo ' . $e->getMessage());
}

$meses = [
    1 => "ENERO",
    2 => "FEBRERO",
    3 => "MARZO",
    4 => "ABRIL",
    5 => "MAYO",
    6 => "JUNIO",
    7 => "JULIO",
    8 => "AGOSTO",
    9 => "SETIEMBRE",
    10 => "OCTUBRE",
    11 => "NOVIEMBRE",
    12 => "DICIEMBRE"
];


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "AÑO " . $_GET['anio'] . " MES " . $meses[$_GET['mes']]);

$rsDep = $d->get_datosDepenendenciaPorId($labIdDepUser);
//print_r($rsDep);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', $rsDep[0]['nom_depen']);

$max = 11;
$count = 0;

$cnt_total=0;
$tot_sis = 0;
$tot_demanda = 0;
$tot_estrategia = 0;
$tot_exonerado = 0;
$param[0]['anio'] = $_GET['anio'];
$param[0]['mes'] = $_GET['mes'];
$param[0]['idDepAten'] = $labIdDepUser;
$rsTotales = $at->get_repCntAtencionPorAnioMesAndIdDependencia($param);
foreach ($rsTotales as $rowTotArea) {
  if($rowTotArea['id_plan'] == "1"){
	  $tot_sis = $rowTotArea['cnt_atencion'] ;
  }
  if($rowTotArea['id_plan'] == "2"){
	  $tot_demanda = $rowTotArea['cnt_atencion'] ;
  }
  if($rowTotArea['id_plan'] == "3"){
	  $tot_estrategia = $rowTotArea['cnt_atencion'] ;
  }
  if($rowTotArea['id_plan'] == "4"){
	  $tot_exonerado = $rowTotArea['cnt_atencion'] ;
  }
  $cnt_total= $rowTotArea['cnt_atencion'] + $cnt_total;
}
  
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $tot_sis);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $tot_demanda);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $tot_estrategia);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $tot_exonerado);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $cnt_total);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "C" . $max . ":G" . $max);
$max++;


$tot_exa_total = 0;
$tot_exa_sis = 0;
$tot_exa_demanda = 0;
$tot_exa_estrategia = 0;
$tot_exa_exonerado = 0;
  
$sWhere=''; $sOrder=' Order By orden_por_tipo_producto'; $sLimit='';
$param[0]['id_estado'] = '1';
$param[0]['nom_producto'] = '';
$maxHema = 13;
$maxBio = 13;
$maxImn = 13;
$maxMic = 13;
$maxPaq = 13;
$itemHema = 0;
$itemBio = 0;
$itemImn = 0;
$itemMic = 0;
$itemPaq = 0;
$rsTP = $pr->get_listaTipoProducto();
foreach ($rsTP as $rowTP) {
	$max++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $rowTP['nombre_tipo_producto']);
	/*$rsTipProd_demanda = $at->get_repIndicadorProduccionPorAnioMes($_GET['anio'], $_GET['mes'], $labIdDepUser, 2, $rowTP['id']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $rsTipProd_demanda);
	$rsTipProd_sis = $at->get_repIndicadorProduccionPorAnioMes($_GET['anio'], $_GET['mes'], $labIdDepUser, 1, $rowTP['id']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $rsTipProd_sis);
	$rsTipProd_estrategia = $at->get_repIndicadorProduccionPorAnioMes($_GET['anio'], $_GET['mes'], $labIdDepUser, 3, $rowTP['id']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $rsTipProd_estrategia);
	$rsTipProd_exonerado = $at->get_repIndicadorProduccionPorAnioMes($_GET['anio'], $_GET['mes'], $labIdDepUser, 4, $rowTP['id']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $rsTipProd_exonerado);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $rsTipProd_sis + $rsTipProd_demanda + $rsTipProd_estrategia + $rsTipProd_exonerado);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulotprod, "A" . $max . ":B" . $max);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "C" . $max . ":G" . $max);*/
	
	/*$tot_exa_sis = $tot_exa_sis + $rsTipProd_sis;
	$tot_exa_demanda = $tot_exa_demanda + $rsTipProd_demanda;
	$tot_exa_estrategia = $tot_exa_estrategia + $rsTipProd_estrategia;
	$tot_exa_exonerado = $tot_exa_exonerado + $rsTipProd_exonerado;*/
		
	if($rowTP['id'] == "1"){
		if($itemHema == 0) {
			$maxHema = $max;
			$itemHema++;
		}
	}
	if($rowTP['id'] == "2"){
		if($itemBio == 0) {
			$maxBio = $max;
			$itemBio++;
		}
	}
	if($rowTP['id'] == "3"){
		if($itemImn == 0) {
			$maxImn = $max;
			$itemImn++;
		}
	}
	if($rowTP['id'] == "4"){
		if($itemMic == 0) {
			$maxMic = $max;
			$itemMic++;
		}
	}
	if($rowTP['id'] == "6"){
		if($itemPaq == 0) {
			$maxPaq = $max;
			$itemPaq++;
		}
	}

	if($rowTP['id'] == "1"){
		$rsProd_demandaHema = 0;
		$rsProd_sisHema = 0;
		$rsProd_estrategiaHema = 0;
		$rsProd_exoneradoHema = 0;
	}
	
	if($rowTP['id'] == "2"){
		$rsProd_demandaBio = 0;
		$rsProd_sisBio = 0;
		$rsProd_estrategiaBio = 0;
		$rsProd_exoneradoBio = 0;
	}
	
	if($rowTP['id'] == "3"){
		$rsProd_demandaImn = 0;
		$rsProd_sisImn = 0;
		$rsProd_estrategiaImn = 0;
		$rsProd_exoneradoImn = 0;
	}
	
	if($rowTP['id'] == "4"){
		$rsProd_demandaMic = 0;
		$rsProd_sisMic = 0;
		$rsProd_estrategiaMic = 0;
		$rsProd_exoneradoMic = 0;
	}
	
	if($rowTP['id'] == "6"){
		$rsProd_demandaPaq = 0;
		$rsProd_sisPaq = 0;
		$rsProd_estrategiaPaq = 0;
		$rsProd_exoneradoPaq = 0;
	}

	unset($param[0]['id_tipo_producto']);
	$param[0]['id_tipo_producto'] = $rowTP['id'];
	$count = 0;
	$rs = $pr->get_tblDatosProducto($sWhere, $sOrder, $sLimit, $param);
	$nr = count($rs);
	if ($nr > 0) {
	  foreach ($rs as $row) {
		$count++;
		$max++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $count);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $row['nom_producto']);//tipo doc
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":B" . $max);
		$rsProd_demanda = $at->get_repIndicadorProduccionPorAnioMes($_GET['anio'], $_GET['mes'], $labIdDepUser, 2, $rowTP['id'],$row['id_producto'],$row['es_toma_muestra']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $rsProd_demanda);
		$rsProd_sis = $at->get_repIndicadorProduccionPorAnioMes($_GET['anio'], $_GET['mes'], $labIdDepUser, 1, $rowTP['id'],$row['id_producto'],$row['es_toma_muestra']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $rsProd_sis);
		$rsProd_estrategia = $at->get_repIndicadorProduccionPorAnioMes($_GET['anio'], $_GET['mes'], $labIdDepUser, 3, $rowTP['id'],$row['id_producto'],$row['es_toma_muestra']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $rsProd_estrategia);
		$rsProd_exonerado = $at->get_repIndicadorProduccionPorAnioMes($_GET['anio'], $_GET['mes'], $labIdDepUser, 4, $rowTP['id'],$row['id_producto'],$row['es_toma_muestra']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $rsProd_exonerado);
		
		$rsCntMa = $at->get_repIndicadorProduccionPorAnioMesManual($_GET['anio'], $_GET['mes'], $labIdDepUser, 0, 0,$row['id_producto']);
		if(count($rsCntMa) <> "0"){
			$rsProd_demanda = $rsCntMa[0]['cnt_pagante'] + $rsProd_demanda;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $rsProd_demanda);
			$rsProd_sis = $rsCntMa[0]['cnt_sis'] + $rsProd_sis;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $rsProd_sis);
			$rsProd_estrategia = $rsCntMa[0]['cnt_estrategia'] + $rsProd_estrategia;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $rsProd_estrategia);
			$rsProd_exonerado = $rsCntMa[0]['cnt_exonerado'] + $rsProd_exonerado;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $rsProd_exonerado);
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $rsProd_sis + $rsProd_demanda + $rsProd_estrategia + $rsProd_exonerado);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumerocuerpo, "C" . $max . ":G" . $max);
		
		if($rowTP['id'] == "1"){
			$rsProd_demandaHema = $rsProd_demandaHema + $rsProd_demanda;
			$rsProd_sisHema = $rsProd_sisHema + $rsProd_sis;
			$rsProd_estrategiaHema = $rsProd_estrategiaHema + $rsProd_estrategia;
			$rsProd_exoneradoHema = $rsProd_exoneradoHema + $rsProd_exonerado;
		}
		if($rowTP['id'] == "2"){
			$rsProd_demandaBio = $rsProd_demandaBio + $rsProd_demanda;
			$rsProd_sisBio = $rsProd_sisBio + $rsProd_sis;
			$rsProd_estrategiaBio = $rsProd_estrategiaBio + $rsProd_estrategia;
			$rsProd_exoneradoBio = $rsProd_exoneradoBio + $rsProd_exonerado;
		}
		if($rowTP['id'] == "3"){
			$rsProd_demandaImn = $rsProd_demandaImn + $rsProd_demanda;
			$rsProd_sisImn = $rsProd_sisImn + $rsProd_sis;
			$rsProd_estrategiaImn = $rsProd_estrategiaImn + $rsProd_estrategia;
			$rsProd_exoneradoImn = $rsProd_exoneradoImn + $rsProd_exonerado;
			
		}
		if($rowTP['id'] == "4"){
			$rsProd_demandaMic = $rsProd_demandaMic + $rsProd_demanda;
			$rsProd_sisMic = $rsProd_sisMic + $rsProd_sis;
			$rsProd_estrategiaMic = $rsProd_estrategiaMic + $rsProd_estrategia;
			$rsProd_exoneradoMic = $rsProd_exoneradoMic + $rsProd_exonerado;
		}
		if($rowTP['id'] == "6"){
			$rsProd_demandaPaq = $rsProd_demandaPaq + $rsProd_demanda;
			$rsProd_sisPaq = $rsProd_sisPaq + $rsProd_sis;
			$rsProd_estrategiaPaq = $rsProd_estrategiaPaq + $rsProd_estrategia;
			$rsProd_exoneradoPaq = $rsProd_exoneradoPaq + $rsProd_exonerado;
		}
		
	  }
	}
}

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$maxHema, $rsProd_demandaHema + $rsProd_sisHema + $rsProd_estrategiaHema + $rsProd_exoneradoHema);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$maxHema, $rsProd_demandaHema);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$maxHema, $rsProd_sisHema);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$maxHema, $rsProd_estrategiaHema);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$maxHema, $rsProd_exoneradoHema);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "B".$maxHema.":G".$maxHema);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$maxBio, $rsProd_demandaBio + $rsProd_sisBio + $rsProd_estrategiaBio + $rsProd_exoneradoBio);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$maxBio, $rsProd_demandaBio);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$maxBio, $rsProd_sisBio);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$maxBio, $rsProd_estrategiaBio);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$maxBio, $rsProd_exoneradoBio);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "B".$maxBio.":G".$maxBio);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$maxImn, $rsProd_demandaImn + $rsProd_sisImn + $rsProd_estrategiaImn + $rsProd_exoneradoImn);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$maxImn, $rsProd_demandaImn);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$maxImn, $rsProd_sisImn);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$maxImn, $rsProd_estrategiaImn);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$maxImn, $rsProd_exoneradoImn);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "B".$maxImn.":G".$maxImn);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$maxMic, $rsProd_demandaMic + $rsProd_sisMic + $rsProd_estrategiaMic + $rsProd_exoneradoMic);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$maxMic, $rsProd_demandaMic);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$maxMic, $rsProd_sisMic);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$maxMic, $rsProd_estrategiaMic);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$maxMic, $rsProd_exoneradoMic);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "B".$maxMic.":G".$maxMic);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$maxPaq, $rsProd_demandaPaq + $rsProd_sisPaq + $rsProd_estrategiaPaq + $rsProd_exoneradoPaq);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$maxPaq, $rsProd_demandaPaq);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$maxPaq, $rsProd_sisPaq);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$maxPaq, $rsProd_estrategiaPaq);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$maxPaq, $rsProd_exoneradoPaq);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "B".$maxPaq.":G".$maxPaq);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G12', $rsProd_demandaHema + $rsProd_sisHema + $rsProd_estrategiaHema + $rsProd_exoneradoHema + $rsProd_demandaBio + $rsProd_sisBio + $rsProd_estrategiaBio + $rsProd_exoneradoBio + $rsProd_demandaImn + $rsProd_sisImn + $rsProd_estrategiaImn + $rsProd_exoneradoImn + $rsProd_demandaMic + $rsProd_sisMic + $rsProd_estrategiaMic + $rsProd_exoneradoMic + $rsProd_demandaPaq + $rsProd_sisPaq + $rsProd_estrategiaPaq + $rsProd_exoneradoPaq);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D12', $rsProd_demandaHema +  $rsProd_demandaBio + $rsProd_demandaImn + $rsProd_demandaMic + $rsProd_demandaPaq);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C12', $rsProd_sisHema + $rsProd_sisBio + $rsProd_sisImn + $rsProd_sisMic + $rsProd_sisPaq);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E12', $rsProd_estrategiaHema + $rsProd_estrategiaBio + $rsProd_estrategiaImn + $rsProd_estrategiaMic + $rsProd_estrategiaPaq);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F12', $rsProd_exoneradoHema + $rsProd_exoneradoBio + $rsProd_exoneradoImn + $rsProd_exoneradoMic + $rsProd_exoneradoPaq);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "C12:G12");



$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_ses'.date("Ymdhis").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setIncludeCharts(TRUE);
ob_end_clean(); // ob_end_clean Limpia el búfer de salida y desactiva el búfer de salida
$objWriter->save('php://output');

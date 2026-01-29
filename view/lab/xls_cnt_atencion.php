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


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "DESDE " . $_GET['fecIni'] . " HASTA " . $_GET['fecFin']);

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
$param[0]['fecIniAte'] = $_GET['fecIni'];
$param[0]['fecFinAte'] = $_GET['fecFin'];
$param[0]['idDepAten'] = $labIdDepUser;
$rsTotales = $at->get_repCntAtencionPorFechaAndIdDependencia($param);
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
  
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $cnt_total);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $tot_demanda);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $tot_sis);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $tot_estrategia);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $tot_exonerado);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "C" . $max . ":G" . $max);
$max++;


$tot_exa_total = 0;
$tot_exa_sis = 0;
$tot_exa_demanda = 0;
$tot_exa_estrategia = 0;
$tot_exa_exonerado = 0;
  
$sWhere=''; $sOrder=''; $sLimit='';
$param[0]['id_estado'] = '1';
$param[0]['nom_producto'] = '';
$rsTP = $pr->get_listaTipoProducto();
foreach ($rsTP as $rowTP) {
	$max++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $rowTP['nombre_tipo_producto']);
	$rsTipProd_demanda = $at->get_repIndicadorAtencionesPorFecha($_GET['fecIni'], $_GET['fecFin'], $labIdDepUser, 2, $rowTP['id']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $rsTipProd_demanda);
	$rsTipProd_sis = $at->get_repIndicadorAtencionesPorFecha($_GET['fecIni'], $_GET['fecFin'], $labIdDepUser, 1, $rowTP['id']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $rsTipProd_sis);
	$rsTipProd_estrategia = $at->get_repIndicadorAtencionesPorFecha($_GET['fecIni'], $_GET['fecFin'], $labIdDepUser, 3, $rowTP['id']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $rsTipProd_estrategia);
	$rsTipProd_exonerado = $at->get_repIndicadorAtencionesPorFecha($_GET['fecIni'], $_GET['fecFin'], $labIdDepUser, 4, $rowTP['id']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $rsTipProd_exonerado);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $rsTipProd_sis + $rsTipProd_demanda + $rsTipProd_estrategia + $rsTipProd_exonerado);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulotprod, "A" . $max . ":B" . $max);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "C" . $max . ":G" . $max);
	
	$tot_exa_sis = $tot_exa_sis + $rsTipProd_sis;
	$tot_exa_demanda = $tot_exa_demanda + $rsTipProd_demanda;
	$tot_exa_estrategia = $tot_exa_estrategia + $rsTipProd_estrategia;
	$tot_exa_exonerado = $tot_exa_exonerado + $rsTipProd_exonerado;
		
	unset($param[0]['id_tipo_producto']);
	$param[0]['id_tipo_producto'] = $rowTP['id'];
	
	$rs = $pr->get_tblDatosProducto($sWhere, $sOrder, $sLimit, $param);
	$nr = count($rs);
	if ($nr > 0) {
	  foreach ($rs as $row) {
		$count++;
		$max++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $count);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $row['nom_producto']);//tipo doc
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":B" . $max);

		$rsProd_demanda = $at->get_repIndicadorAtencionesPorFecha($_GET['fecIni'], $_GET['fecFin'], $labIdDepUser, 2, $rowTP['id'],$row['id_producto']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $rsProd_demanda);		
		$rsProd_sis = $at->get_repIndicadorAtencionesPorFecha($_GET['fecIni'], $_GET['fecFin'], $labIdDepUser, 1, $rowTP['id'],$row['id_producto']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $rsProd_sis);
		$rsProd_estrategia = $at->get_repIndicadorAtencionesPorFecha($_GET['fecIni'], $_GET['fecFin'], $labIdDepUser, 3, $rowTP['id'],$row['id_producto']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $rsProd_estrategia);
		$rsProd_exonerado = $at->get_repIndicadorAtencionesPorFecha($_GET['fecIni'], $_GET['fecFin'], $labIdDepUser, 4, $rowTP['id'],$row['id_producto']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $rsProd_exonerado);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $rsProd_sis + $rsProd_demanda + $rsProd_estrategia + $rsProd_exonerado);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumerocuerpo, "C" . $max . ":G" . $max);
	  }
	}
}

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G12', $tot_exa_sis + $tot_exa_demanda + $tot_exa_estrategia + $tot_exa_exonerado);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D12', $tot_exa_demanda);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C12', $tot_exa_sis);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E12', $tot_exa_estrategia);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F12', $tot_exa_exonerado);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "C12:G12");



$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="rep_lab_cnt_atencion'.date("Ymdhis").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setIncludeCharts(TRUE);
ob_end_clean(); // ob_end_clean Limpia el búfer de salida y desactiva el búfer de salida
$objWriter->save('php://output');

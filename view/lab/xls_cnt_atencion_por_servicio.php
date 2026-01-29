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

require_once '../../model/Lab.php';
$lab = new Lab();

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../assets/lib/PHPExcel/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("DIRIS-OTI")
->setLastModifiedBy("DIRIS-OTI")
->setTitle("Office 2007 XLSX Test Document")
->setSubject("Office 2007 XLSX Test Document")
->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
->setKeywords("office 2007 openxml php")
->setCategory("Test result file");


//Dar estilo al los titulos
$styleTituloPrincipal = array(
  'font' => array(
    'bold' => true,
    'size' => 11,
  ),
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  ),
);
$styleTituloSecundario = array(
  'font' => array(
    'bold' => true,
    'size' => 10,
  ),
  'alignment' => array(
    //'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  ),
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

$estiloInformacionprod = new PHPExcel_Style();
$estiloInformacionprod->applyFromArray(array(
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
    'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
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

$estiloInformacionTitulo = new PHPExcel_Style();
$estiloInformacionTitulo->applyFromArray(array(
  'font' => array(
    'name' => 'Calibri',
    'size' => 6,
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
  'fill' => array(
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
    'startcolor' => array(
      'rgb' => 'E8E5E5'
    )
  ),
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  ),
)
);

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
  'fill' => array(
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
    'startcolor' => array(
      'rgb' => 'E8E5E5'
    )
  ),
  'alignment' => array(
    //'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  ),
)
);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objActSheet = $objPHPExcel->getActiveSheet();

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.50);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.50);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(75);

//Poner fuente y tamaño de letra
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

//Ancho automatico de una celda
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(10);
//Dar altura a una fila
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(12);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE DE ATENCIONES SOLICITADAS POR PROFESIONALES Y/O SERVICIOS');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'REPORTE DEL '. $_GET['fecIni'] .' AL ' . $_GET['fecFin'] . '');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', '');
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleTituloPrincipal);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleTituloSecundario);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A4', 'ITEM')
->setCellValue('B4', 'SERVICIO')
->setCellValue('C4', 'SIS')
->setCellValue('D4', 'PAGANTE')
->setCellValue('E4', 'ESTRATEGIA')
->setCellValue('F4', 'EXONERADO')
->setCellValue('G4', 'TOTAL');
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulotprod, "A4:G4");


$rsTP = $lab->get_datosReporteCntAtencionesPorServicio($labIdDepUser,$_GET['fecIni'],$_GET['fecFin']);
$max = 4;

foreach ($rsTP as $rowTP) {
	$max++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $rowTP['nom_servicio']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $rowTP['cnt_sis']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $rowTP['cnt_pag']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $rowTP['cnt_est']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $rowTP['cnt_exo']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, '=SUM(C'.$max.':F'.$max.')');
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulotprod, "A" . $max . ":G" . $max);

	$item = 0;	
	$rs = $lab->get_datosReporteCntAtencionesProfesionalPorServicio($labIdDepUser,$rowTP['id_servicioori'],$_GET['fecIni'],$_GET['fecFin']);
	$nr = count($rs);
	if ($nr > 0) {
	  foreach ($rs as $row) {
		$item++;
		$max++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $item);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $row['nombre_medico']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $row['cnt_sis']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $row['cnt_pag']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $row['cnt_est']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $row['cnt_exo']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, '=SUM(C'.$max.':F'.$max.')');

		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":G" . $max);
	  }
	}
}


$objPHPExcel->getActiveSheet()->setTitle('cnt por servicios');

$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a clientes web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reportelab_atencion_por_servicios.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

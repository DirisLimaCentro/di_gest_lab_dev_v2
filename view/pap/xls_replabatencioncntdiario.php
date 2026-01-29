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

require_once '../../model/Pap.php';
$pap = new Pap();


/* ini_set('memory_limit','100M'); // mem
ini_set('max_execution_time', 3000); */
/**
* PHPExcel
*
* Copyright (C) 2006 - 2013 PHPExcel
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*
* @category   PHPExcel
* @package    PHPExcel
* @copyright  Copyright (c) 2006 - 2013 PHPExcel (http://www.codeplex.com/PHPExcel)
* @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
* @version    1.7.9, 2013-06-02
*/
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
    'size' => 10,
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
$estiloNumero = new PHPExcel_Style();
$estiloNumero->applyFromArray(array(
  'font' => array(
    'name' => 'Calibri',
    'size' => 8,
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
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objActSheet = $objPHPExcel->getActiveSheet();

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.50);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.50);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100);

//Poner fuente y tamaño de letra
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

//Ancho automatico de una celda
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(8);
//Dar altura a una fila
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(12);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', ' CANTIDAD DE LECTURA POR FECHA');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', utf8_encode('RANGO DE FECHA: ' . $_GET['fecIni'] . ' AL ' . $_GET['fecFin']));
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', '');
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleTituloPrincipal);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleTituloPrincipal);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A4', 'Fec. lectura')
->setCellValue('B4', 'Profesional')
->setCellValue('C4', 'Establecimiento')
->setCellValue('D4', 'Nro. Envío')
->setCellValue('E4', 'Desde')
->setCellValue('F4', 'Hasta')
->setCellValue('G4', 'Cantidad');
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A4:G4");

$param[0]['fecIniAte'] = $_GET['fecIni'];
$param[0]['fecFinAte'] = $_GET['fecFin'];
$param[0]['idProfe'] = $_GET['idProfe'];

$rs = $pap->get_repDatosPLaboratorioCntLecturaPorFechayProfesional($param);

$nr = count($rs);
$max = 4;
$count = 0;
if ($nr > 0) {
  foreach ($rs as $row) {
    $max++;

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $row['fecresul']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $row['nombre_rsprof']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $row['nom_depen']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $row['nro_papenv']."-".$row['anio_papenv']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $row['minreglab']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $row['maxreglab']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $row['cntreglab']);
        $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":G" . $max);
  }
}
// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('cntlectura');

// Redirect output to a clientes web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte_PAPCntLectura.xls"');
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

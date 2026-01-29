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
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("N")->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension("O")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("P")->setWidth(40);
//$objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setWidth(13); */
//Dar altura a una fila
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(12);
/* $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(12);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(12);
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(12);
$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(13);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(17);
$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(12); */
/*
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Nro. Documento RUC / DNI')
//->setCellValue('B1', $_GET['txtNroRUCEmp'])
->setCellValue('A2', 'Nombre / Raz�n Social')
->setCellValue('B2', $_GET['txtNomEmp']);
$objActSheet->setCellValueExplicit('B1', $_GET['txtNroRUCEmp'], PHPExcel_Cell_DataType::TYPE_STRING);
*/

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', ' REPORTE DE ENVÍO DE CITOLOGÍA');
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'RANGO DE FECHA: ' . $_GET['fecIni'] . ' AL ' . $_GET['fecFin']);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', '');
$objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:P2');
$objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($styleTituloPrincipal);
$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->applyFromArray($styleTituloPrincipal);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A4', 'Item')
->setCellValue('B4', 'Código')
->setCellValue('C4', 'Fec. Recepcion')
->setCellValue('D4', 'Mes')
->setCellValue('E4', 'Doc. Identidad')
->setCellValue('F4', 'HC')
->setCellValue('G4', 'SIS')
->setCellValue('H4', 'Apellidos y Nombres')
->setCellValue('I4', 'Edad')
->setCellValue('J4', 'Establecimiento')
->setCellValue('K4', 'Resultado')
->setCellValue('L4', 'Bethesda')
->setCellValue('M4', 'Fec. Resultado')
->setCellValue('N4', 'Realizado Por')
->setCellValue('O4', 'Fec. V.B')
->setCellValue('P4', 'V.B. Por');
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A4:P4");

$param[0]['idEnv'] = $_GET['idEnv'];

$rs = $pap->get_repDatosPAPEnvioLaboratorio($param);

$nr = count($rs);
$max = 4;
$count = 0;
if ($nr > 0) {
  foreach ($rs as $row) {
    $max++;
    $count++;

    if($row['nro_reglab'] == ""){
      $anioLab = "";
    } else {
      $anioLab = $row['anio_reglab'];
    }

    switch ($row['mes_paprecep']) {
      case '1':
      $nomMesRecep = "Enero";
      break;
      case '2':
      $nomMesRecep = "Febrero";
      break;
      case '3':
      $nomMesRecep = "Marzo";
      break;
      case '4':
      $nomMesRecep = "Abril";
      break;
      case '5':
      $nomMesRecep = "Mayo";
      break;
      case '6':
      $nomMesRecep = "Junio";
      break;
      case '7':
      $nomMesRecep = "Julio";
      break;
      case '8':
      $nomMesRecep = "Agosto";
      break;
      case '9':
      $nomMesRecep = "Setiembre";
      break;
      case '10':
      $nomMesRecep = "Octubre";
      break;
      case '11':
      $nomMesRecep = "Noviembre";
      break;
      case '12':
      $nomMesRecep = "Diciembre";
      break;
    }

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $count);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $row['nro_reglab']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $row['fec_paprecep']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $nomMesRecep);//tipo doc
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $row['abrev_tipodocpac'].": ".$row['nro_docpac']); //nro doc//$rsPer[0]['nro_documento'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F' . $max, $row['nro_hc'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $row['nom_sispac']);//sis
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $max, $row['nombre_rspac']);//pacciente
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $max, $row['edad_pac']);//edad
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $max, $row['nom_depen']);//edad
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $max, $row['nom_resul']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $max, $row['nom_bethesa']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $max, $row['fec_resul']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $max, $row['nombre_rstec']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $max, $row['fec_validresul']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $max, $row['nombre_rsenclab']);
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":P" . $max);

    //$dateTimeNow = time();
    //$objPHPExcel->getActiveSheet()->setCellValue('Q' . $max, PHPExcel_Shared_Date::PHPToExcel($dateTimeNow));
    //$objPHPExcel->getActiveSheet()->getStyle('Q' . $max)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
  }
}
// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('reporte');

// Redirect output to a clientes web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte_PAPLab.xls"');
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

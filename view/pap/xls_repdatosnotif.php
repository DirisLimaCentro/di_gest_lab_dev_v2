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
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setWidth(30);

/*$objPHPExcel->getActiveSheet()->getColumnDimension("O")->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension("P")->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setWidth(13); */
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
->setCellValue('A1', utf8_encode('Nro. Documento RUC / DNI'))
//->setCellValue('B1', utf8_encode($_GET['txtNroRUCEmp']))
->setCellValue('A2', utf8_encode('Nombre / Raz�n Social'))
->setCellValue('B2', $_GET['txtNomEmp']);
$objActSheet->setCellValueExplicit('B1', $_GET['txtNroRUCEmp'], PHPExcel_Cell_DataType::TYPE_STRING);
*/

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', ' REPORTE DE DATOS DE NOTIFICACIÓN PARA ENTREGA DE RESULTADOS');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'AÑO: ' . $_GET['anio']);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', '');
$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($styleTituloPrincipal);
$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($styleTituloPrincipal);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A4', utf8_encode('TIPO_DOC'))
->setCellValue('B4', utf8_encode('NRO_DOC'))
->setCellValue('C4', utf8_encode('PACIENTE'))
->setCellValue('D4', 'NRO_HC')
->setCellValue('E4', utf8_encode('EDAD'))
->setCellValue('F4', 'EMAIL')
->setCellValue('G4', 'TELF_FIJO')
->setCellValue('H4', 'TELF_MOVIL')
->setCellValue('I4', 'DISTRITO')
->setCellValue('J4', utf8_encode('DIRECIÓN'))
->setCellValue('K4', utf8_encode('REFERENCIA'))
->setCellValue('L4', utf8_encode('FEC_TOMA'))
->setCellValue('M4', 'PROFESIONAL_TOMA');
//->setCellValue('N4', 'FEC_ENTREGA')
//->setCellValue('O4', 'ESTADO');
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A4:M4");

$param[0]['anio'] = $_GET['anio'];
$param[0]['iddep'] = $labIdDepUser;
$param[0]['id_resultado'] = "3";

$rs = $pap->get_repDatosPAPNoficacion($param);

$nr = count($rs);
$max = 4;
$count = 0;
if ($nr > 0) {
  foreach ($rs as $row) {
    $max++;
    $count++;

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $row['abrev_tipodoc']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B' . $max, $row['nrodoc'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $row['nombre_pac']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $row['nro_hc']);//tipo doc
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $row['edad_pac']); //nro doc//$rsPer[0]['nro_documento'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $row['email']); //hc//$rsPer[0]['nro_documento'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $row['telf_fijo']);//sis
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $max, $row['telf_movil']);//pacciente
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $max, $row['distrito']);//edad
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $max, $row['descrip_dir']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $max, $row['descrip_ref']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $max, $row['fec_atencion']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $max, $row['nombre_rsprof']);
    //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $max, $row['fec_entrega']);
    //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $max, $row['nomestado']);
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":M" . $max);
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

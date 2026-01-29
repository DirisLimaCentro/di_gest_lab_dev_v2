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
$labIdDepUser = $_SESSION['labIdDepUser'];

ini_set('memory_limit', '2048M');

require_once '../../model/Profesional.php';
$pro = new Profesional();

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
$objPHPExcel->getProperties()->setCreator("DIRIS-LC")
->setLastModifiedBy("DIRIS-LC")
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
//Dar estilo al los titulos
$styleTituloPrincipal_left = array(
  'font' => array(
    'bold' => true,
    'size' => 10,
  ),
  'alignment' => array(
    //'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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

//Poner fuente y tama�o de letra
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

//Ancho automatico de una celda
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setWidth(20);

//Dar altura a una fila
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);

$rango_edad = "";
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'RELACIÓN DE USUARIOS');
$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleTituloPrincipal);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'ESTABLECIMIENTO DE SALUD')
->setCellValue('B3', 'TIPO DOC.')
->setCellValue('C3', 'NRO. DOCUMENTO')
->setCellValue('D3', 'APELLIDOS Y NOMBRES')
->setCellValue('E3', 'PROFESION')
->setCellValue('F3', 'NRO. COLE')
->setCellValue('G3', 'CONDICION LABORAL')
->setCellValue('H3', 'SERVICIO')
->setCellValue('I3', 'CARGO')
->setCellValue('J3', 'USUARIO')
->setCellValue('K3', 'ROL USUARIO')
->setCellValue('L3', 'FECHA DE REGISTRO');
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A3:L3");

if(($_SESSION['labIdRolUser'] == "6") OR ($_SESSION['labIdRolUser'] == "7") OR ($_SESSION['labIdRolUser'] == "8") OR ($_SESSION['labIdRolUser'] == "9") OR ($_SESSION['labIdRolUser'] == "10")){
	$id_modulo_lab = 1;
}else if(($_SESSION['labIdRolUser'] == "2") OR ($_SESSION['labIdRolUser'] == "5") OR ($_SESSION['labIdRolUser'] == "15") OR ($_SESSION['labIdRolUser'] == "16")){
	$id_modulo_lab = 2;
}else if(($_SESSION['labIdRolUser'] == "19") OR ($_SESSION['labIdRolUser'] == "20")){
	$id_modulo_lab = 4;
}else if($_SESSION['labIdRolUser'] == "1"){
	$id_modulo_lab = 0;
} else {
	$id_modulo_lab = 99;
}

//print_r($_SESSION['labIdRolUser']."-".$id_modulo_lab); exit();

$id_dependencia=$_GET['id_establecimiento'];

$rs = $pro->get_repDatosProfesionalPorServicio($id_modulo_lab, $id_dependencia);
//print_r($rs); exit();
$nr = count($rs);
$max = 3;
$count = 0;
if ($nr > 0) {
  foreach ($rs as $row) {
    $max++;
    $count++;

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $row['nom_depen']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $row['abrev_tipodoc']);
    $objActSheet->setCellValueExplicit('C' . $max, $row['nro_doc'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $row['nombre_profesional']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $row['nom_profesion']); 
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $row['nro_colegiatura']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $row['nom_condi_laboral']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $max, $row['nom_servicio']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $max, $row['nom_cargo']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $max, $row['nom_usuario']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $max, $row['nom_rol']);
    $objActSheet->setCellValueExplicit('L' . $max, $row['fec_registro'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":L" . $max);
  }
}
// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('reporte');

// Redirect output to a clientes web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte_usuarios_x_eess.xls"');
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

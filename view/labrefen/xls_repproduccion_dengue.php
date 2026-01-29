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

require_once '../../model/Tipo.php';
$la = new Tipo();

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
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("N")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("O")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("P")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setWidth(20);

//Dar altura a una fila
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);

$rango_edad = "";
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'RELACIÓN DE RESULTADO DE EXAMEN DENGUE');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'RESULTADOS DEL ' . $_GET['fecIni'] . ' AL ' . $_GET['fecFin']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->applyFromArray($styleTituloPrincipal);
$objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($styleTituloPrincipal_left);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'CODIGO ATENCIÓN')
->setCellValue('B3', 'ESTABLECIMIENTO DE PROCEDENCIA')
->setCellValue('C3', 'FECHA RECEPCIÓN')
->setCellValue('D3', 'APELLIDOS Y NOMBRES')
->setCellValue('E3', 'TIPO DOC.')
->setCellValue('F3', 'NRO. DOC.')
->setCellValue('G3', 'SEXO')
->setCellValue('H3', 'EDAD')
->setCellValue('I3', 'EXAMEN')
->setCellValue('J3', 'FECHA TOMA MUESTRA')
->setCellValue('K3', 'FECHA VALIDACION')
->setCellValue('L3', 'USUARIO PROCESA')
->setCellValue('M3', 'USUARIO VALIDACION')
->setCellValue('N3', 'RESULTADO')
->setCellValue('O3', 'OBSERVACIONES')
->setCellValue('P3', 'METODO')
->setCellValue('Q3', 'USUARIO CREACION');
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A3:Q3");
$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('P3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('Q3')->getAlignment()->setWrapText(true);


$param[0]['id_establecimiento'] = 67;
$param[0]['fecIniAte'] = $_GET['fecIni'];
$param[0]['fecFinAte'] = $_GET['fecFin'];

$rs = $la->get_detalleRepDatosLabReferencialExamenPorFecha($param);
$nr = count($rs);
$max = 3;
$count = 0;
if ($nr > 0) {
  foreach ($rs as $row) {
    $max++;
    $count++;

    if($row['id_sexo'] == "1"){
      $nom_sexo = "M";
    } else {
      $nom_sexo = "F";
    };
    $objActSheet->setCellValueExplicit('A' . $max, $row['nro_atencion_manual'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $row['nomdepen_origen']);
    $objActSheet->setCellValueExplicit('C' . $max, $row['fec_atencion'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $row['nombre_rs']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $row['abrev_tipodoc']);
	$objActSheet->setCellValueExplicit('F' . $max, $row['nrodoc'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $nom_sexo);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $max, $row['edad']);
	$nom_producto = str_replace("TOMA DE MUESTRA ", "", $row['nom_producto']);
	$nom_producto = str_replace("PARA ", "", $nom_producto);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $max, $nom_producto);
    $objActSheet->setCellValueExplicit('J' . $max, $row['fecha_toma'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objActSheet->setCellValueExplicit('K' . $max, $row['fec_valid_resul'], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $max, $row['usu_ing_resul']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $max, $row['usu_valid_resul']);
	$rsDet = $la->get_detalleRepDatosLabReferencialExamenPorFechaDet($row['id_atencion'], $row['id_producto']);
	$column = 'M';
	foreach ($rsDet as $rowDet) {
		$column++;
		if($rowDet['idtipo_ingresol'] <> "3"){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column . $max, $rowDet['det_result']);
		} else {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column . $max, $rowDet['nombreseleccion_resul']);
		}
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $max, $row['usu_create_resul']);
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":Q" . $max);
  }
}
// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('reporte_dengue');

// Redirect output to a clientes web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte_dengue.xls"');
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

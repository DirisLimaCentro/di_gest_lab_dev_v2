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

require_once '../../model/Atencion.php';
$a = new Atencion();

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
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("N")->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension("O")->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension("P")->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension("R")->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension("S")->setWidth(15);

//Dar altura a una fila
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);

$rango_edad = "";
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE DE ATENCIONES EN LABORATORIO CLINICO');
if($_GET['condicion_edad'] == "1"){$rango_edad=" - EDADES DESDE " . $_GET['edad_desde'] . " HASTA " .  $_GET['edad_hasta'] . " AÑOS";}
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'RESULTADOS DEL ' . $_GET['fecIni'] . ' AL ' . $_GET['fecFin'] . $rango_edad);
$objPHPExcel->getActiveSheet()->mergeCells('A1:S1');
$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray($styleTituloPrincipal);
$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray($styleTituloPrincipal_left);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'NRO. ATENCIÓN')
->setCellValue('B3', 'FECHA REGISTRO')
->setCellValue('C3', 'FECHA ATENCIÓN/CITA')
->setCellValue('D3', 'ORIGEN ATENCIÓN')
->setCellValue('E3', 'APELLIDOS Y NOMBRES')
->setCellValue('F3', 'TIPO DOC.')
->setCellValue('G3', 'NRO. DOC.')
->setCellValue('H3', 'HISTORIA CLÍNICA')
->setCellValue('I3', 'SEXO')
->setCellValue('J3', 'EDAD AÑO')
->setCellValue('K3', 'EDAD MES')
->setCellValue('L3', 'EDAD DIA')
->setCellValue('M3', 'CELULAR')
->setCellValue('N3', 'DISTRITO')
->setCellValue('O3', 'DIRECCIÓN')
->setCellValue('P3', 'SERVICIO PROCEDENCIA')
->setCellValue('Q3', 'PROFESIONAL SOLICITANTE')
->setCellValue('R3', 'ESTABLECIMIENTO PROCEDENCIA')
->setCellValue('S3', 'ESTADO RESULTADO');

$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A3:S3");
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('P3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('Q3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('R3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('S3')->getAlignment()->setWrapText(true);



$param[0]['chk_dep_procedencia'] = (empty($_GET['condicion_dep_procedencia'])) ? "" : "1";
$param[0]['id_dep_procedencia'] = '';

$param[0]['idDepAten'] = $labIdDepUser;
$param[0]['fecIniAte'] = $_GET['fecIni'];
$param[0]['fecFinAte'] = $_GET['fecFin'];
$param[0]['chk_gestante'] = $_GET['chk_gestante'];
$param[0]['condicion_eg'] = $_GET['condicion_eg'];
$param[0]['nro_eg'] = $_GET['nro_eg'];
$param[0]['id_producto'] = $_GET['id_producto'];
$param[0]['condicion_edad'] = $_GET['condicion_edad'];
$param[0]['edad_desde'] = $_GET['edad_desde'];
$param[0]['edad_hasta'] = $_GET['edad_hasta'];
$param[0]['condicion_urgente'] = $_GET['condicion_urgente'];
if(!empty($_GET['condicion_dep_procedencia'])){
	$param[0]['id_dep_procedencia'] = $_GET['id_dep_procedencia'];
}

$rs = $a->get_repDatosAtencion($param);
$nr = count($rs);
$max = 3;
$count = 0;
if ($nr > 0) {
  foreach ($rs as $row) {
	$max++;
	
	if($row['id_tipo_genera_correlativo'] == "1"){
		$nroAtencion = $row['nro_atencion']."-".$row['anio_atencion'];
	} else {
		$nroAtencion = substr($row['nro_atencion'], 0, 6).substr($row['nro_atencion'],6);
	}
	
    if($row['id_sexo_pac'] == "1"){
      $nom_sexo = "M";
    } else {
      $nom_sexo = "F";
    };
	if($row['id_tipo_genera_correlativo'] == "1"){
		$nroAtencion = $row['nro_atencion'] . "-". $row['anio_atencion'];
	} else {
		$nroAtencion = substr($row['nro_atencion'], 0, 6).substr($row['nro_atencion'],6);
	}
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $nroAtencion);
	$objActSheet->setCellValueExplicit('B' . $max, $row['fec_atencion'], PHPExcel_Cell_DataType::TYPE_STRING);
	$objActSheet->setCellValueExplicit('C' . $max, $row['fec_cita'], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $row['sigla_plan']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $row['nombre_rs']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $row['abrev_tipodoc']);
	$objActSheet->setCellValueExplicit('G' . $max, $row['nrodoc'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objActSheet->setCellValueExplicit('H' . $max, $row['nro_hc'], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $max, $nom_sexo);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $max, $row['edad_anio_pac']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $max, $row['edad_mes_pac']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $max, $row['edad_dia_pac']);
	$objActSheet->setCellValueExplicit('M' . $max, $row['nro_telefonomovil'], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $max, $row['distrito']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $max, $row['descrip_dir']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $max, $row['servicioori']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $max, $row['nombre_medico']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $max, $row['nom_depenori']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $max, $row['nom_estadoresul']);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":S" . $max);

  }
}

// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('reporte');

// Redirect output to a clientes web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte_sep.xls"');
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

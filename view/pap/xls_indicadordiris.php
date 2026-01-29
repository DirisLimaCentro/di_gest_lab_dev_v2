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
if ($_POST['opt'] == "prof"){
	$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(40);
} else if ($_POST['opt'] == "men") {
	$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(15);
} else {
	$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(15);
}
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(18);

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
//->setCellValue('B1', utf8_encode($_POST['txtNroRUCEmp']))
->setCellValue('A2', utf8_encode('Nombre / Raz�n Social'))
->setCellValue('B2', $_POST['txtNomEmp']);
$objActSheet->setCellValueExplicit('B1', $_POST['txtNroRUCEmp'], PHPExcel_Cell_DataType::TYPE_STRING);
*/
if ($_POST['mes'] == ""){$nom_mes = "TODOS";} else {$nom_mes = $_POST['mes'];};

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', ' DEPORTE DE REGISTRO DE PAPANICOLAOU');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'AÑO: ' . $_POST['anio'] . ' MES: ' . $nom_mes);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', '');

if ($_POST['opt'] == "prof"){
	$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
	$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
	$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleTituloPrincipal);
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleTituloPrincipal);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A4', 'ESTABLECIMIENTO')
	->setCellValue('B4', 'PROFESIONAL')
	->setCellValue('C4', 'MUESTRAS (M)')
	->setCellValue('D4', 'NEGATIVOS (N)')
	->setCellValue('E4', 'POSITIVOS (P)')
	->setCellValue('F4', 'INSATISFACTORIAS (I)')
	->setCellValue('G4', 'RECHAZADAS (R)')
	->setCellValue('H4', 'ENTREGADO A PACIENTE (EP)');
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A4:H4");
} else if ($_POST['opt'] == "est") {
	$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
	$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
	$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleTituloPrincipal);
	$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleTituloPrincipal);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A4', 'ESTABLECIMIENTO')
	->setCellValue('B4', 'MUESTRAS (M)')
	->setCellValue('C4', 'NEGATIVOS (N)')
	->setCellValue('D4', 'POSITIVOS (P)')
	->setCellValue('E4', 'INSATISFACTORIAS (I)')
	->setCellValue('F4', 'RECHAZADAS (R)')
	->setCellValue('G4', 'ENTREGADO A PACIENTE (EP)');
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A4:G4");
} else {
	$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
	$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
	$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleTituloPrincipal);
	$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleTituloPrincipal);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A4', 'MES')
	->setCellValue('B4', 'MUESTRAS (M)')
	->setCellValue('C4', 'NEGATIVOS (N)')
	->setCellValue('D4', 'POSITIVOS (P)')
	->setCellValue('E4', 'INSATISFACTORIAS (I)')
	->setCellValue('F4', 'RECHAZADAS (R)')
	->setCellValue('G4', 'ENTREGADO A PACIENTE (EP)');
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A4:G4");
}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

$decodedText = html_entity_decode($_POST['data']);
$myArray = json_decode($decodedText, true);

$max = 4;
if ($_POST['opt'] == "prof"){
	foreach (array_sort($myArray, 0, SORT_DESC) as &$valor) {
		$max++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $valor[0]); 
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $valor[1]);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, str_replace(",", "", $valor[2]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, str_replace(",", "", $valor[3]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, str_replace(",", "", $valor[4]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, str_replace(",", "", $valor[5]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, str_replace(",", "", $valor[6]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $max, str_replace(",", "", $valor[7]));
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":H" . $max);
	}
} else if ($_POST['opt'] == "est") {
	foreach (array_sort($myArray, 0, SORT_DESC) as &$valor) {
		$max++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $valor[0]); 
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, str_replace(",", "", $valor[1]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, str_replace(",", "", $valor[2]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, str_replace(",", "", $valor[3]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, str_replace(",", "", $valor[4]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, str_replace(",", "", $valor[5]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, str_replace(",", "", $valor[6]));
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":G" . $max);
	}	
} else {
	foreach ($myArray as &$valor) {
		$max++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $valor[0]); 
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, str_replace(",", "", $valor[1]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, str_replace(",", "", $valor[2]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, str_replace(",", "", $valor[3]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, str_replace(",", "", $valor[4]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, str_replace(",", "", $valor[5]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, str_replace(",", "", $valor[6]));
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":G" . $max);
	}
}
//exit();


/*
$param[0]['anio'] = $_POST['anio'];
$param[0]['mes'] = $_POST['mes'];
$param[0]['id_dependencia'] = $_POST['id_dependencia'];
$param[0]['id_estado'] = $_POST['id_estado'];

$rs = $pap->get_repDatosDetalleIndicador($param);
$nr = count($rs);
$max = 4;
$count = 0;
if ($nr > 0) {
  foreach ($rs as $row) {
    $max++;
    $count++;

    if($row['telf_movil'] == ""){
      $telefono = $row['telf_fijo'];
    } else {
      $telefono = $row['telf_movil'];
    }

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $count);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $row['nom_depen']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $row['abrev_tipodocpac']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D' . $max, $row['nro_docpac'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $row['nombre_rspac']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $row['edad_pac']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G' . $max, $row['nro_hc'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $max, $row['nom_tipopac']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $max, $row['distrito']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $max, $telefono);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $max, $row['fec_atencion']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $max, $row['fec_resultado']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $max, $row['nom_estadoresulfinal']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $max, $row['fec_entregapac']);
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":N" . $max);
  }
}
*/
// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('reporte');

// Redirect output to a clientes web browser (Excel5)
/*header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte_indicadores.xls"');
header('Cache-Control: max-age=0');*/
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
header('Content-Type: application/xlsx');
header('Content-Disposition: attachment;filename="reporte_indicadores.xlsx"');
header('Cache-Control: max-age=0');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;



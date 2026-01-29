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

require_once '../../model/Producto.php';
$pr = new Producto();
require_once '../../model/Producton.php';
$prn = new Producton();
require_once '../../model/Componente.php';
$c = new Componente();


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
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(20);
//Dar altura a una fila
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(12);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE DE PRODUCTO');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'LISTA DE PRODUCTOS A NIVEL DLC');
if(!empty($_GET['id_establecimiento'])) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'ESTABLECIMIENTO: '.$_GET['nom_establecimiento']);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', '');
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleTituloPrincipal);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleTituloSecundario);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A4', utf8_encode('ITEM'))
->setCellValue('B4', utf8_encode('CODIGO'))
->setCellValue('C4', utf8_encode('PRODUCTO'))
->setCellValue('D4', 'PREPARACION DEL PACIENTE')
->setCellValue('E4', utf8_encode('PRECIO SIS'))
->setCellValue('F4', 'PRECIO DEMANDA')
->setCellValue('G4', 'CNT. COMPONENTES');
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A4:G4");

$param[0]['id_establecimiento'] = $_GET['id_establecimiento'];

$rsTP = $pr->get_listaTipoProducto();
$max = 4;
$count = 0;
foreach ($rsTP as $rowTP) {
	$max++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $rowTP['nombre_tipo_producto']);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulotprod, "A" . $max . ":G" . $max);
	unset($param[0]['id_tipo']);
	$param[0]['id_tipo'] = $rowTP['id'];
	
	$rs = $pr->get_repDatosProductoDependencia($param);
	$nr = count($rs);
	if ($nr > 0) {
	  foreach ($rs as $row) {
		$count++;
		$max++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $max, $count);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $max, $row['cod_producto_orionlab']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $max, $row['nom_producto']);//tipo doc
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $max, $row['descrip_prepapro']); //nro doc//$rsPer[0]['nro_documento'], PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $max, $row['prec_sis']); //hc//$rsPer[0]['nro_documento'], PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $max, $row['prec_parti']);//sis
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $max, $row['cnt_comp']);//pacciente
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A" . $max . ":D" . $max);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "E" . $max . ":F" . $max);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "G" . $max . ":G" . $max);
	  }
	}
}
// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('productos');

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1);


//Poner fuente y tamaño de letra
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

//Ancho automatico de una celda
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(20);
//Dar altura a una fila
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(12);

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', ' REPORTE DE PRODUCTO');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A2', 'LISTA DE PRODUCTOS A NIVEL DLC');
if(!empty($_GET['id_establecimiento'])) $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A2', 'ESTABLECIMIENTO: '.$_GET['nom_establecimiento']);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A3', '');
$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleTituloPrincipal);
$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleTituloSecundario);

$objPHPExcel->setActiveSheetIndex(1)
->setCellValue('A4', utf8_encode('ITEM'))
->setCellValue('B4', utf8_encode('CODIGO'))
->setCellValue('C4', utf8_encode('TIPO'))
->setCellValue('D4', utf8_encode('PRODUCTO'))
->setCellValue('E4', 'PREPARACION DEL PACIENTE')
->setCellValue('F4', utf8_encode('PRECIO SIS'))
->setCellValue('G4', 'PRECIO DEMANDA')
->setCellValue('H4', 'CNT. COMPONENTES');
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "A4:H4");

if(isset($_GET['id_establecimiento'])){
	$idDep = $_GET['id_establecimiento'];
} else {
	$idDep = Null;
}

unset($param[0]['id_tipo']);
$param[0]['id_tipo'] = 0;
$rs = $pr->get_repDatosProductoDependencia($param);
$max = 5;
$count = 0;
if ($nr > 0) {
  foreach ($rs as $row) {
    $count++;

    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A' . $max, $count);
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B' . $max, $row['codref_producto']);//$row['cod_producto_orionlab']
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C' . $max, $row['nomtipo_producto']);
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $max, $row['nom_producto']);//tipo doc
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $max, $row['descrip_prepapro']); //nro doc//$rsPer[0]['nro_documento'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F' . $max, $row['prec_sis']); //hc//$rsPer[0]['nro_documento'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $max, $row['prec_parti']);//sis
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H' . $max, $row['cnt_comp']);//pacciente
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionprod, "A" . $max . ":E" . $max);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloNumero, "F" . $max . ":G" . $max);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionprod, "H" . $max . ":H" . $max);
	
	$countComp = 0;
	$rsComp = $prn->get_datosComponentePoridProductoAndIdDependenciaActivo($row['id_producto'], $idDep);
	$nrComp = count($rsComp);
	if ($nrComp > 0) {
			$max++;
			$objPHPExcel->setActiveSheetIndex(1)
			->setCellValue('C' . $max, '')
			->setCellValue('D' . $max, 'COMPONENTE')
			->setCellValue('E' . $max, 'U.M.')
			->setCellValue('F' . $max, 'METODO')
			->setCellValue('G' . $max, 'GRUPO');
			$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionTitulo, "C" . $max.":H" . $max);
		foreach ($rsComp as $rowComp) {
			$countComp ++;
			$max++;
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C' . $max, $rowComp['id_componente_grupo']);//$rowComp['id_componente_grupo']$countComp
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $max, $rowComp['componente']);
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $max, $rowComp['uni_medida']);
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F' . $max, $rowComp['metodocomponente']);
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $max, $rowComp['descripcion_grupo']);
			$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "C" . $max . ":G" . $max);
		}
	}
	$max++;
  }
}
$objPHPExcel->getActiveSheet()->setTitle('prod componente');

$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a clientes web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte_LabProducto.xls"');
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

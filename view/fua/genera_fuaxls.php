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
/*
ini_set('display_errors', false);
ini_set('display_startup_errors', false);
ini_set("memory_limit", "-1");
set_time_limit(9000);
*/
require_once '../../model/Atencion.php';
$at = new Atencion();

require_once '../../model/Profesional.php';
$pro = new Profesional();

require_once '../../model/Usuario.php';
$u = new Usuario();

$idAtencion = $_GET['nroAtencion'];
$rsA = $at->get_datosAtencion($idAtencion);

//Nombre del archivo
$file_path = (realpath(dirname(__FILE__))) . "/FUA_LABORATORIO.xlsx";
//echo $file_path; exit();
// Create new PHPExcel object
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';

$objPHPExcel = new PHPExcel();


try {
  //read file from path
  //PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
  $inputFileType = PHPExcel_IOFactory::identify($file_path);
  //exit(print_r('File Type: ' . $inputFileType));
  // Leemos un archivo Excel 2007
  $objReader = PHPExcel_IOFactory::createReader($inputFileType);
  //$objReader->setReadDataOnly(true);
  $objPHPExcel = $objReader->load($file_path);
  //exit(print_r($objPHPExcel));
} catch (Exception $e) {
  exit('Error cargando el archivo "' . pathinfo($inputFileName, PATHINFO_BASENAME)
  . '": ' . $e->getMessage());
}

// Change the file first Sheet
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X7', date('y'))->setCellValue('AB7','')->setCellValue('A13',$rsA[0]['codref_depen'])->setCellValue('T13',$rsA[0]['nom_depen'])->setCellValue('AB7',$rsA[0]['nro_fua']);

$id_tipAtencion1 = "";
$id_tipAtencion2 = "";
$id_tipAtencion3 = "";
switch ($rsA[0]['id_tipatencion']) {
  case '1':
  $id_tipAtencion1 = "X";
  break;
  case '2':
  $id_tipAtencion2 = "X";
  break;
  case '3':
  $id_tipAtencion3 = "X";
  break;
}
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ16', $id_tipAtencion1)->setCellValue('AJ18', $id_tipAtencion2)->setCellValue('AJ19', $id_tipAtencion3)->setCellValue('AM18', $rsA[0]['codref_depenorigen'])->setCellValue('AV18', $rsA[0]['nom_depenorigen'])->setCellValue('BJ18', $rsA[0]['nro_referenciaori']);

$tdi = "";
switch ($rsA[0]['id_tipodoc']) {
  case '1':
  $tdi = "2";
  break;
  case '2':
  $tdi = "3";
  break;
  default:
  $tdi = "";
  break;
}
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A25', $tdi)->setCellValue('C25', $rsA[0]['nrodoc'])->setCellValue('W25', $rsA[0]['id_codsis'])->setCellValue('Z25', $rsA[0]['nro_sis']);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A28', $rsA[0]['primer_apepac'])->setCellValue('AK28', $rsA[0]['segundo_apepac'])->setCellValue('A31', $rsA[0]['nombre_pac']);

$idsexoM = ($rsA[0]['id_sexo'] == "1") ? 'X' : '';
$idsexoF = ($rsA[0]['id_sexo'] == "2") ? 'X' : '';
$fecNac1 = "";
$fecNac2 = "";
$fecNac3 = "";
$fecNac4 = "";
$fecNac5 = "";
$fecNac6 = "";
$fecNac7 = "";
$fecNac8 = "";
if($rsA[0]['fec_nac'] <> ""){
  $fecNac = str_replace("/","",$rsA[0]['fec_nac']);
  $arrFec = str_split($fecNac);
  $fecNac1 = $arrFec[0];
  $fecNac2 = $arrFec[1];
  $fecNac3 = $arrFec[2];
  $fecNac4 = $arrFec[3];
  $fecNac5 = $arrFec[4];
  $fecNac6 = $arrFec[5];
  $fecNac7 = $arrFec[6];
  $fecNac8 = $arrFec[7];
}
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E35', $idsexoM)->setCellValue('E36', $idsexoF)
->setCellValue('R38', $fecNac1)
->setCellValue('V38', $fecNac2)
->setCellValue('Y38', $fecNac3)
->setCellValue('AA38', $fecNac4)
->setCellValue('AE38', $fecNac5)
->setCellValue('AH38', $fecNac6)
->setCellValue('AK38', $fecNac7)
->setCellValue('AO38', $fecNac8)->setCellValue('AR35', $rsA[0]['nro_hc']);

$idGestante = ($rsA[0]['id_gestante'] == "1") ? 'X' : '';
$fecPar1 = "";
$fecPar2 = "";
$fecPar3 = "";
$fecPar4 = "";
$fecPar5 = "";
$fecPar6 = "";
$fecPar7 = "";
$fecPar8 = "";
if($rsA[0]['fec_partogestante'] <> ""){
  $fecPar = str_replace("/","",$rsA[0]['fec_partogestante']);
  $arrFec = str_split($fecPar);
  $fecPar1 = $arrFec[0];
  $fecPar2 = $arrFec[1];
  $fecPar3 = $arrFec[2];
  $fecPar4 = $arrFec[3];
  $fecPar5 = $arrFec[4];
  $fecPar6 = $arrFec[5];
  $fecPar7 = $arrFec[6];
  $fecPar8 = $arrFec[7];
}
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E42', $idGestante)
->setCellValue('R35', $fecPar1)
->setCellValue('V35', $fecPar2)
->setCellValue('Y35', $fecPar3)
->setCellValue('AA35', $fecPar4)
->setCellValue('AE35', $fecPar5)
->setCellValue('AH35', $fecPar6)
->setCellValue('AK35', $fecPar7)
->setCellValue('AO35', $fecPar8);

$fecAte1 = "";
$fecAte2 = "";
$fecAte3 = "";
$fecAte4 = "";
$fecAte5 = "";
$fecAte6 = "";
$fecAte7 = "";
$fecAte8 = "";
if($rsA[0]['fec_atencion'] <> ""){
  $fecAte = str_replace("/","",$rsA[0]['fec_atencion']);
  $arrFec = str_split($fecAte);
  $fecAte1 = $arrFec[0];
  $fecAte2 = $arrFec[1];
  $fecAte3 = $arrFec[2];
  $fecAte4 = $arrFec[3];
  $fecAte5 = $arrFec[4];
  $fecAte6 = $arrFec[5];
  $fecAte7 = $arrFec[6];
  $fecAte8 = $arrFec[7];
}

$horaAte = explode(":", $rsA[0]['hora_atencion']);
$hAte = str_pad($horaAte[0], 2, "0", STR_PAD_LEFT);
$mAte = str_pad($horaAte[1], 2, "0", STR_PAD_LEFT);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A54', $fecAte1)->setCellValue('B54', $fecAte2)->setCellValue('C54', $fecAte3)->setCellValue('D54', $fecAte4)->setCellValue('G54', $fecAte5)->setCellValue('L54', $fecAte6)->setCellValue('N54', $fecAte7)->setCellValue('P54', $fecAte8)
->setCellValue('T53', $hAte)->setCellValue('Y53', $mAte);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J78', $rsA[0]['peso_pac'])
->setCellValue('Y78', $rsA[0]['talla_pac'])
->setCellValue('AN78', $rsA[0]['pa_pac']);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C83', $rsA[0]['edad_gestacion']);

$exisApoderadoS = ($rsA[0]['id_solicitante'] == "") ? 'X' : '';
$exisApoderadoN = ($rsA[0]['id_solicitante'] <> "") ? 'X' : '';
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO110', $exisApoderadoS);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO112', $exisApoderadoN);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW117', trim($rsA[0]['nombre_soli']));
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW118', trim($rsA[0]['primer_apesoli']. " " .$rsA[0]['segundo_apesoli']));
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AX121', trim("(" . $rsA[0]['abrev_tipodocsoli'] . ") " . $rsA[0]['nrodoc_soli']));

$nrodocprof = "";
$nomprof = "";
$nrocoleprof = "";
$nrorneprof = "";
$codprofesionprof = "";
$espeprof = "";
$egreprof = "";


$rsUsu = $u->get_datosUsuarioPorId($rsA[0]['id_usuprofesionaling']);
$idProf = $rsUsu[0]['id_persona'];
$idDep = $rsA[0]['id_dependencia'];
$rsPro = $pro->get_datosProfesionalPorIdPerAndIdDep($idProf, $idDep);
if (count($rsPro) <> 0) {
  $nrodocprof = $rsPro[0]['nro_docpro'];
  $nomprof = $rsPro[0]['nombre_rspro'];
  $nrocoleprof = $rsPro[0]['nro_colegiatura'];
  $nrorneprof = $rsPro[0]['nro_rne'];
  $codprofesionprof = $rsPro[0]['cod_refprofesion'];
  $espeprof = $rsPro[0]['nom_servicio'];
  $egreprof = "";
}
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A103', $nrodocprof)->setCellValue('O103', $nomprof)->setCellValue('BF103', $nrocoleprof)->setCellValue('O105', $codprofesionprof)->setCellValue('Z105', $espeprof)->setCellValue('BA105', $nrorneprof)->setCellValue('BL105', $egreprof);


// Change the file two Sheet
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('W2', date('y'));

$rsCtp = $at->get_datosCptPorIdAtencion($idAtencion);
if(count($rsCtp) <> 0){
  $maxSheet1 = 26;
  foreach ($rsCtp as $rowCpt) {
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$maxSheet1, $rowCpt['id_cpt']);
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$maxSheet1, $rowCpt['denominacion_cpt']);
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L'.$maxSheet1, '1');
    $rsDCA = $at->get_datosIngDetComponenteAtencionPorIdCpt($idAtencion, $rowCpt['id_cpt']);
    if(count($rsDCA) == 0){
      $ejeCtp = 0;
      $resulCtp = "";
    } else {
      if(count($rsDCA) == 1) {
        $ejeCtp = 1;
        foreach ($rsDCA as $rowDCA) {
          $ejeCtp = $rowDCA['ing_result'];
          $resulCtp = $rowDCA['det_result'];
        }
      } else {
        $ejeCtp = 1;
        $resulCtp = "";
        foreach ($rsDCA as $rowDCA) {
          if ($rowDCA['ing_result'] == 0) {
            $ejeCtp = 0;
            break;
          }
        }
      }
    }
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M'.$maxSheet1, $ejeCtp);
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N'.$maxSheet1, '1');
    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O'.$maxSheet1, $resulCtp);
    $maxSheet1 ++;
  }
}

// Set active sheet index to the two sheet, so Excel opens this as the two sheet
$objPHPExcel->setActiveSheetIndex(1);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//-------------------------------------------------------------------------------------------
/*
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$fileName = 'FUA_LABORATORIO1.xlsx';
$objWriter->save($fileName);
*/

// Redirect output to a clientes web browser (Excel5)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="FUA.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
//*/

/*
$data = file_get_contents($fileName); // Read the file's contents
force_download($fileName, $data);
unlink($fileName);
exit;//*/
/*
// Set document properties
$objPHPExcel->getProperties()->setCreator("Disyanjak Bandung")->setLastModifiedBy("Disyanjak Bandung")->setTitle("Daftar SMS")->setSubject("Daftar SMS")->setDescription("Daftar SMS untuk ke WP")->setKeywords("office PHPExcel php")->setCategory("Test result file");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Phone No.')->setCellValue('A2', 'JOSE');
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Daftar SMS');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$fileName = 'send_sms_';
$objWriter->save($fileName . '.xlsx');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($fileName . '.xls');
//*/

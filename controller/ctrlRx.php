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
$labIdServicioDepUser = $_SESSION['labIdServicioDep'];

require_once '../model/Rx.php';
$rx = new Rx();

function to_pg_array($set) {
  settype($set, 'array'); // can be called with a scalar or array
  $result = array();
  foreach ($set as $t) {
    if (is_array($t)) {
      $result[] = to_pg_array($t);
    } else {
      $t = str_replace('"', '\\"', $t); // escape double quote
      if (!is_numeric($t)) // quote only non-numeric values
      $t = '"' . $t . '"';
      $result[] = $t;
    }
  }
  return '{' . implode(",", $result) . '}'; // format
}

switch ($_POST['accion']) {
  case 'POST_ADD_ATENCION':
    $arr_paciente[0] = array($_POST['txtIdPac'], $_POST['txtIdTipDocPac'], $_POST['txtNroDocPac'], trim($_POST['txtNomPac']), trim($_POST['txtPriApePac']), trim($_POST['txtSegApePac']), $_POST['txtIdSexoPac'], $_POST['txtFecNacPac'], trim($_POST['txtNroTelFijoPac']), trim($_POST['txtNroTelMovilPac']) , trim($_POST['txtEmailPac']), trim($_POST['txtUBIGEOPac']), $_POST['txtDirPac'], trim($_POST['txtDirRefPac']), trim($_POST['txtNroHCPac']), $_POST['txtIdPaisNacPac'], $_POST['txtIdEtniaPac']);
    $arr_apoderado[0] = array($_POST['txtIdSoli'], $_POST['txtIdTipDocSoli'], $_POST['txtNroDocSoli'], trim($_POST['txtNomSoli']), trim($_POST['txtPriApeSoli']), trim($_POST['txtSegApeSoli']), $_POST['txtIdSexoSoli'], $_POST['txtFecNacSoli'], trim($_POST['txtNroTelFijoSoli']), trim($_POST['txtNroTelMovilSoli']) , trim($_POST['txtEmailSoli']), $_POST['txtIdPaisNacSoli'], $_POST['txtIdEtniaSoli'], trim($_POST['txtIdParenSoli']));
    $arr_atencion[0] = array($_POST['txtIdAtencion'], $_POST['txtTipPac'],$_POST['txtIdTipPacParti'],$_POST['txtIdDepRef'], $_POST['txtIdTipExa'], trim($_POST['txtObsSoli']), $_POST['nomcarpeta'], $_POST['txtTBC']);
    if($_POST['txtIdAtencion'] == "0"){
      $action = "C";
    } else {
      $action = "E";
    }
    $paramReg[0]['accion'] = $action;
    $paramReg[0]['paciente'] = to_pg_array($arr_paciente);
    $paramReg[0]['apoderado'] = to_pg_array($arr_apoderado);
    $paramReg[0]['atencion'] = to_pg_array($arr_atencion);
    $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser ."|". $labIdServicioDepUser;
    /*print_r($paramReg);
    exit();*/
    $rs = $rx->post_reg_atencion($paramReg);
    if ($rs == "E") {
      echo "ER|Error al ingresar la atención";
      exit();
    }
    echo "OK|".$rs;
  break;
  case 'POST_UPLOAD_ARCHIVOS':
    $folder = '../view/rx/uploads/'.$_POST['folder'].'/';
    if (!file_exists($folder)) {
      mkdir($folder, 0777, false);
    }

    switch ($_POST['caso']) {
      case 'carga':
        $tempFile = $_FILES['file']['tmp_name'];
        $targetFile =  $folder. $_FILES['file']['name'];
        move_uploaded_file($tempFile,$targetFile);
      break;
      case 'elimina':
        if (file_exists($folder.$_POST['file'])) unlink($folder.$_POST['file']);
      break;
    }
  break;
  case 'GET_SHOW_ARCHIVOS':
  $folder = '../view/rx/uploads/'.$_POST['folder'].'/';
  $cntF = 0;
  if (is_dir($folder)){
    if ($dh = opendir($folder)){
      echo "<ul class=\"list-group list-group-unbordered\">";
      while (($file = readdir($dh)) !== false){
        if ($file != "." && $file != "..") {
          //echo "diferente a . y ..";
          $cntF ++;
          $ruta="./DownloadFile.php?FileName=".$file."&nomCarp=".$_POST['folder'];
          ?>
          <li class="list-group-item">
            <a class="archivo text-muted" href="<?php echo trim($ruta) ;?>"><i class="fa fa-file-code-o"></i> <?php echo trim($file);?></a>
            <?php
            if(isset($_POST['idEst'])){
              ?>
              <a class="eliarchivo pull-right text-muted" href="#" onclick="eli_archivos('<?php echo trim($file);?>')"><span class="glyphicon glyphicon-trash"></span></a>
              <?php
            }
            ?>
          </li>
          <?php
        }
      }
      echo "</ul>";
      closedir($dh);
      if($cntF == 0){
        echo '<b><span class="text-muted">No se encontró ningún archivo.</span></b>';
      }
    } else {
      echo '<b><span class="text-muted">No se encontró ningún archivo.</span></b>';
    }
  } else {
    echo '<b><span class="text-muted">No se encontró ningún archivo.</span></b>';
  }
  echo '<input type="hidden" name="cntFC" id="cntFC" value="'.$cntF.'"/>';
  break;
}
?>

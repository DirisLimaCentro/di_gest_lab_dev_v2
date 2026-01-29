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

require_once '../model/Profesional.php';
$pro = new Profesional();

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
  case 'GET_SHOW_EXISPROFESIONAL':
  $rs = $pro->post_valid_exis_profesional($_POST['txtIdTipDoc'], $_POST['txtNroDoc']);
  echo $rs;
  break;
  case 'POST_ADD_REGPROFESIONAL':
  $url = "../view/genecrud/profesional/";
  $fec_nac = ($_POST['txtFecNacPac'] == "") ? Null : $_POST['txtFecNacPac'];
  $arr_persona[0] = array($_POST['txtIdPer'], $_POST['txtIdTipDoc'], $_POST['txtNroDoc'], trim($_POST['txtNomPac']), trim($_POST['txtPriApePac']), trim($_POST['txtSegApePac']), $_POST['txtIdSexoPac'], $fec_nac, trim($_POST['txtNroTelFijoPac']), trim($_POST['txtNroTelMovilPac']) , trim($_POST['txtEmailPac']), $_POST['txtValidReniec']);
  $arr_profesion[0] = array($_POST['txtIdProfesional'], $_POST['txtIdProfesion'], trim($_POST['txtNroCole']), trim($_POST['txtNroRne']), trim($_POST['id_condicional_laboral']));
  if($_POST['txtIdProfesional'] == "0"){
	  $action = "C";
  } else {
	  $action = "E";
  }
  $paramReg[0]['accion'] = $action;
  $paramReg[0]['persona'] = to_pg_array($arr_persona);
  $paramReg[0]['profesion'] = to_pg_array($arr_profesion);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $pro->post_reg_profesional($paramReg);
  $resultado = substr($rs, 0, 2);
  if ($resultado <> "ER") {
    if(isset($_FILES['file'])){

      $file = explode(".", $_FILES['file']['name']);
      $tipArchi = $file[1]; // porción2
      $rsProfe = explode("|", $rs);
      $idProfe = $rsProfe[1]; // porción2

      //if (file_exists($url . $_FILES['file']['name'])) {
      if (file_exists($url . $idProfe.".".$tipArchi)) {
        //unlink($url . $_FILES['file']['name']);
        unlink($url . $idProfe.".".$tipArchi);
      }

      //if (move_uploaded_file($_FILES['file']['tmp_name'], $url . $_FILES['file']['name'])) {
      if (move_uploaded_file($_FILES['file']['tmp_name'], $url . $idProfe.".".$tipArchi)) {
        echo $rs;
        exit();
      } else {
        echo "ER|Error al intentar cargar la firma.";
        exit();
      }
    } else {
      echo $rs;
      exit();
    }
  }
  echo $rs;
  break;
  case 'POST_UPD_FIRMAPROFESIONAL':
  $file = explode(".", $_FILES['file']['name']);
  $tipArchi = $file[1]; // porción2
  $idProfe = $_POST['txtIdProfesional']; // porción2
  $url = "../view/genecrud/profesional/";

  if (file_exists($url . $idProfe.".jpg")) {
    unlink($url . $idProfe.".jpg");
  }
  if (file_exists($url . $idProfe.".png")) {
    unlink($url . $idProfe.".png");
  }

  if (move_uploaded_file($_FILES['file']['tmp_name'], $url . $idProfe.".".$tipArchi)) {
    echo "OK|Firma actualizada correctamente";
    exit();
  } else {
    echo "ER|Error al intentar cargar la firma.";
    exit();
  }
  break;
  case 'POST_ADD_REGSERVICIOPROFESIONAL':
	  $arr_persona[0] = array('');
	  $arr_profesion[0] = array($_POST['id_profesionalservicio'], $_POST['txtIdProfesional'], $_POST['txtIdDep'], $_POST['txtIdServicioDep'], $_POST['txtIdCargo'], $_POST['txtIdUsuario'], $_POST['txtIdRol']);
	  if($_POST['id_profesionalservicio'] == "0"){
		  $action = "CS";
	  } else {
		  $action = "ES";
	  }
	  $paramReg[0]['accion'] = $action;
	  $paramReg[0]['persona'] = to_pg_array($arr_persona);
	  $paramReg[0]['profesion'] = to_pg_array($arr_profesion);
	  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
	  /*print_r($paramReg);
	  exit();*/
	  $rs = $pro->post_reg_profesional($paramReg);
	  echo $rs;
  break;
  case 'POST_DEL_REGSERVICIOPROFESIONAL':
  $arr_persona[0] = array('');
  $arr_profesion[0] = array($_POST['txtId'], $_POST['txtIdProfesional']);
  $paramReg[0]['accion'] = 'DS';
  $paramReg[0]['persona'] = to_pg_array($arr_persona);
  $paramReg[0]['profesion'] = to_pg_array($arr_profesion);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  $rs = $pro->post_reg_profesional($paramReg);
  echo $rs;
  break;
  case "SHOW_DETPRODUCTOATENCION":
  $rsP = $pro->get_datosUsuarioPorIdProfesional($_POST['idProf']);
  $idUsu = "";
  $nomUsu = "";
  if (count($rsP) <> 0){
    $idUsu  = $rsP[0]["id_usuario"];
    $nomUsu  = $rsP[0]["nom_usuario"];
  ?>
  <button class="btn btn-primary btn-sm" type="button" onclick="reg_servicio('ins','<?php echo $_POST['idProf']?>','<?php echo $idUsu?>','<?php echo $nomUsu?>');" tabindex="0"><i class="glyphicon glyphicon-plus"></i> Registrar nueva Dependencia/Servicio</button>
  <table class="table table-bordered" style="margin-bottom: 0px;">
    <thead class="bg-green">
      <tr>
        <th></th>
        <th>Dependencia</th>
        <th>Servicio</th>
        <th>Cargo</th>
        <th>Usuario</th>
        <th>Rol</th>
        <th>Estado</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $rs = $pro->get_datosServicioPorIdProfesional($_POST['idProf']);
      $a = 1;
      foreach ($rs as $row) {
        $btn = '';
		$btnEdit = '';
        if ($row['estado'] == "1") {
			$btnEdit = '<a style="font-size: 1.2em" class="glyphicon glyphicon-pencil text-success" onclick="event.preventDefault();reg_servicio(\'upd\',\''.$row['id'].'\')" href="#"></a>';
            $styleEst = "bg-green";
            $btn = '<a style="font-size: 1.2em" class="fa fa-times text-danger" onclick="event.preventDefault();cambiarEstadoServicio(\''.$row['id'].'\',\''.$row['id_profesional'].'\')" href="#"></a>';
        } else {
            $styleEst = "bg-red";
        }
        $nomEstado = '<span class="badge ' . $styleEst . '"><small>' . $row['nom_estado'] . '</small></span>';
        echo "<tr>";
        echo "<td class='text-center'><small><b>" . $a++ . "</b></small></td>";
        echo "<td class=''><small><b>" . $row['nom_depen'] . "</b></small></td>";
        echo "<td class=''><small>" . $row['nom_servicio'] . "</small></td>";
        echo "<td class='text-center'><small>" . $row['nom_cargo'] . "</small></td>";
        echo "<td class='text-center'><small><b>" . $row['nom_usuario'] . "</b></small></td>";
        echo "<td class='text-center'><small>" . $row['nom_rol'] . "</small></td>";
        echo "<td class='text-center'><small>" . $nomEstado . "</small></td>";
        echo "<td class='text-center'><small>" . $btnEdit . " " . $btn . "</small>"
		?>
			<div id="pr_<?php echo $row['id']; ?>" style="display: none;"><?php echo json_encode($row); ?></div>
		<?php echo "</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
  <?php
  } else {
	  ?>
    <!--echo "<b class=\"text-danger\">Primero registre al usuario para poder relacionar el profesional a una dependencia.</b>";-->
		<button class="btn btn-primary btn-sm" type="button" onclick="reg_servicio('ins','<?php echo $_POST['idProf']?>','<?php echo $idUsu?>','<?php echo $nomUsu?>');" tabindex="0"><i class="glyphicon glyphicon-plus"></i> Registrar nueva Dependencia/Servicio</button>
	<?php
  }
  break;
}
?>

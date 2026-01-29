<?php
require_once '../model/Usuario.php';
$u = new Usuario();
require_once '../model/Menu.php';
$ma = new Menu();
require_once '../model/Profesional.php';
$pro = new Profesional();
require_once '../model/Dependencia.php';
$d = new Dependencia();

switch ($_POST['accion']) {
  case 'POST_LOGIN':
  $rs = $u->get_ValidUserLogin($_POST['nomUser'], $_POST['passUser']);
  if(count($rs) == 0){
    echo "<script language='JavaScript'>";
    echo "$('.alert').show();";
    echo "$('.alert').addClass('alert-danger').html('Usuario o contrase&ntilde;a no son v&aacute;lidos, intente nuevamente.');";
    echo "$('#txtPass').val('');";
    echo "$('#txtUser').focus();";
    echo "</script>";
  }
  break;
  case 'login':
  $rs = $u->get_ValidUserLogin($_POST['txtUser'], $_POST['txtPass']);
  if(count($rs) > 0){
    $activo = "1";
  } else {
    $activo = "0";
  }
  switch ($activo) {
    case "1":
    session_start();
    $_SESSION['labIdUser'] = $rs[0]['id_usuario'];
    $_SESSION['labNomUser'] = $rs[0]['nom_usuario'];
    $_SESSION['labNomPer'] = $rs[0]['nombre_rs'];
    $_SESSION['labApePatPer'] = $rs[0]['primer_ape'];
    $_SESSION['labApeMatPer'] = $rs[0]['segundo_ape'];
    $_SESSION['labCantRol'] = $rs[0]['cant_rol'];

    $_SESSION['labIdProfesion'] = "";
    $_SESSION['labCodRefProfesion'] = "";
    $_SESSION['labNomProfesion'] = "";
    $_SESSION['labNroColeProf'] = "";
    $_SESSION['labNroNREProf'] = "";

    $_SESSION['labIdServicioDep'] = "";
    $_SESSION['labIdDepUser'] = "";
    $_SESSION['labNomDepUser'] = "";
    $_SESSION['labIdServicio'] = "";
    $_SESSION['labNomServicio'] = "";

    $_SESSION['labIdRolUser'] = "";
    $_SESSION['labAbrevRolUser'] = "";
    $_SESSION['labNomRolUser'] = "";
	
	$_SESSION['labEnvAmericana'] = "";
	$_SESSION['labEnvDiagnostica'] = "";

    $_SESSION['labAccess'] = 'Yes';
    if($rs[0]['cant_rol'] == 1){
      $rsRD = $u->get_RolUserPorDep($rs[0]['id_usuario']);
      $_SESSION['labIdProfesion'] = $rsRD[0]['id_profesional'];
      $_SESSION['labCodRefProfesion'] = $rsRD[0]['cod_refprofesion'];
      $_SESSION['labNomProfesion'] = $rsRD[0]['profesion'];
      $_SESSION['labNroColeProf'] = $rsRD[0]['nro_colegiatura'];
      $_SESSION['labNroNREProf'] = $rsRD[0]['nro_rne'];

      $_SESSION['labIdServicioDep'] = $rsRD[0]['id_serviciodep'];
      $_SESSION['labIdDepUser'] = $rsRD[0]['id_dependencia'];
	  $_SESSION['labIdTipoCorrelativo'] = $rsRD[0]['lab_id_tipo_generacorrelativo'];
      $_SESSION['labNomDepUser'] = $rsRD[0]['nom_depen'];
      $_SESSION['labIdServicio'] = $rsRD[0]['id_servicio'];
      $_SESSION['labNomServicio'] = $rsRD[0]['nom_servicio'];

      $_SESSION['labIdRolUser'] = $rsRD[0]['id_rol'];
      $_SESSION['labAbrevRolUser'] = $rsRD[0]['abrev_rol'];
      $_SESSION['labNomRolUser'] = $rsRD[0]['nom_rol'];
	  
	  $_SESSION['labEnvAmericana'] = $rsRD[0]['envia_americana'];
	  $_SESSION['labEnvDiagnostica'] = $rsRD[0]['envia_diagnostica'];

      $labAccesoMan = array();
      $_SESSION['labAccesoMenuUsu'] = $labAccesoMan;
      $rsam = $ma->get_DetAccesoUser($rsRD[0]['id_profesionalservicio']);
      foreach ($rsam as $row) {
          $labAccesoMan[$row['id_menu']][] = $row['nom_detmenu'] . "|" . $row['link_detmenu'];
      }
      $_SESSION['labAccesoMenuUsu'] = $labAccesoMan;

      header('location: ../view/pages/');
    } else if ($rs[0]['cant_rol'] > 1){
	  header('location: ../view/pages/servicio.php');
    } else {
      header('location:../');
    }
    break;
    default:
    echo "<script language='JavaScript'>";
    echo "$('.alert').show();";
    echo "$('.alert').addClass('alert-danger').html('Usuario o contrase&ntilde;a no son v&aacute;lidos, intente nuevamente.');";
    echo "$('#txtPass').val('');";
    echo "$('#txtUser').focus();";
    echo "</script>";
    break;
  }
  break;
  case 'POST_CHANGEDEP':
session_start();
if (!isset($_SESSION["labAccess"])) {
  header("location:../index.php");
  exit();
}
if ($_SESSION["labAccess"] <> "Yes") {
  header("location:../index.php");
  exit();
}
  $rs = $d->get_datosDepenendenciaPorId($_POST['idDep']);
  echo $rs[0]['id_dependencia'];
  $_SESSION['labIdDepUser'] = $rs[0]['id_dependencia'];
  $_SESSION['labNomDepUser'] = $rs[0]['nom_depen'];
  echo "OK";
  break;
  case 'POST_LOGIN_ROLPORDEP':
	session_start();
	$rsRD = $u->get_RolUserPorDep($_SESSION['labIdUser'], $_POST['id_dependencia']);
	$_SESSION['labIdProfesion'] = $rsRD[0]['id_profesional'];
	$_SESSION['labCodRefProfesion'] = $rsRD[0]['cod_refprofesion'];
	$_SESSION['labNomProfesion'] = $rsRD[0]['profesion'];
	$_SESSION['labNroColeProf'] = $rsRD[0]['nro_colegiatura'];
	$_SESSION['labNroNREProf'] = $rsRD[0]['nro_rne'];

	$_SESSION['labIdServicioDep'] = $rsRD[0]['id_serviciodep'];
	$_SESSION['labIdDepUser'] = $rsRD[0]['id_dependencia'];
	$_SESSION['labIdTipoCorrelativo'] = $rsRD[0]['lab_id_tipo_generacorrelativo'];
	$_SESSION['labNomDepUser'] = $rsRD[0]['nom_depen'];
	$_SESSION['labIdServicio'] = $rsRD[0]['id_servicio'];
	$_SESSION['labNomServicio'] = $rsRD[0]['nom_servicio'];

	$_SESSION['labIdRolUser'] = $rsRD[0]['id_rol'];
	$_SESSION['labAbrevRolUser'] = $rsRD[0]['abrev_rol'];
	$_SESSION['labNomRolUser'] = $rsRD[0]['nom_rol'];
	
	$_SESSION['labEnvAmericana'] = $rsRD[0]['envia_americana'];
	$_SESSION['labEnvDiagnostica'] = $rsRD[0]['envia_diagnostica'];

	$labAccesoMan = array();
	$_SESSION['labAccesoMenuUsu'] = $labAccesoMan;
	$rsam = $ma->get_DetAccesoUser($rsRD[0]['id_profesionalservicio']);
	foreach ($rsam as $row) {
	  $labAccesoMan[$row['id_menu']][] = $row['nom_detmenu'] . "|" . $row['link_detmenu'];
	}
	$_SESSION['labAccesoMenuUsu'] = $labAccesoMan;
  break;

}
?>

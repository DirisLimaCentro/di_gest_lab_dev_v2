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

require_once '../model/Componente.php';
$c = new Componente();

require_once '../model/Grupo.php';
$g = new Grupo();

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
  case 'GET_SHOW_DETCOMPONENTE':
  $rs = $c->get_datosComponentePorId($_POST['idComp']);
  $nr = count($rs);
  if ($nr > 0) {
    $datos = array(
      0 => $rs[0]['id_componente'],
      1 => $rs[0]['descrip_comp'],
      2 => trim($rs[0]['id_unimedida']),
      3 => trim($rs[0]['uni_medida']),
      4 => trim($rs[0]['descrip_valor']),
      5 => $rs[0]['idtipo_ingresol'],
      6 => $rs[0]['ing_solu'],
      7 => trim($rs[0]['idtipocaracter_ingresul']),
      8 => $rs[0]['nomtipocaracter_ingresul'],
      9 => trim($rs[0]['detcaracter_ingresul']),
	  10 => $rs[0]['idseleccion_ingresul'],
	  11 => $rs[0]['nombre_selecresultado'],
      12 => $rs[0]['id_estado'],
      13 => $rs[0]['nom_estado'],
    );
    echo json_encode($datos);
  } else {
    $datos = array(
      0 => '0'
    );
  }
  break;
  case 'POST_ADD_REGCOMPONENTE':
  if($_POST['txtIdComp'] == "0"){
    $accion = 'C';
  } else {
    $accion = 'E';
  }
  $arr_area[0] = array($_POST['txtIdComp'], $_POST['txtNomComp'], trim($_POST['txtIdUnidMed']), trim($_POST['txtValRefComp']), trim($_POST['txtIngSoluComp']), $_POST['optTipoCaracResult'], trim($_POST['txtDetCaracResul']), $_POST['txtIngSeleccion']);
  $paramReg[0]['accion'] = $accion;
  $paramReg[0]['componente'] = to_pg_array($arr_area);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $c->post_reg_componente($paramReg);
  echo $rs;
  exit();
  break;
  case 'POST_ADD_REGCOMPONENTEDET':
  $arr_comp[0] = array($_POST['txtIdGrupoArea'], $_POST['txtIdComp']);
  $paramReg[0]['accion'] = 'C';
  $paramReg[0]['componentedet'] = to_pg_array($arr_comp);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $c->post_reg_componentedet($paramReg);
  echo $rs;
  exit();
  break;
  case 'GET_REG_CAMBIOORDCOMPONENTEDET':
  $arr_area[0] = array($_POST['idCompDet'], $_POST['idGrupoArea']);
  $paramReg[0]['accion'] = $_POST['tipAcc'];
  $paramReg[0]['componentedet'] = to_pg_array($arr_area);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $c->post_reg_componentedet($paramReg);
  echo $rs;
  exit();
  break;
  case 'GET_SHOW_GRUPOPORIDAREA':
  $rs = $g->get_datosGrupoPorIdArea($_POST['idArea'], 1);
  $nr = count($rs);
  ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th><small>Orden</small></th>
          <th><small>Grupo</small></th>
          <th><small>Visible</small></th>
          <th><small>Cant. Comp.</small></th>
          <th><small>&nbsp;</small></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($nr > 0) {
          foreach ($rs as $row) {

            $btnOpemComp = '<button class="btn btn-success btn-xs" onclick="open_compdet(\'' . $row['id_grupoarea'] . '\',\'' . $row['grupo'] . '\');"><i class="glyphicon glyphicon-list-alt"></i></button>';

            echo "<tr>";
            echo "<td class='text-center'><small><b>" . $row['nro_grupoarea'] . "</b></small></td>";
            echo "<td><small>" . $row['grupo'] . "</small></td>";
            echo "<td><small>" . $row['nom_visible'] . "</small></td>";
            echo "<td class='text-center'><small><b>" . $row['cnt_comp'] . "</b></small></td>";
            echo "<td class='text-center'><small>" . $btnOpemComp . "</small></td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  break;
  case 'GET_SHOW_DETCOMPPORIDGRUPOAREA':
  $rs = $c->get_datosDetCompPorIdGrupoArea($_POST['idGrupoArea'], 1);
  $nr = count($rs);
  ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th><small>Orden</small></th>
          <th><small>&nbsp;</small></th>
          <th><small>Componente</small></th>
          <th><small>Unidad de medida</small></th>
          <th><small>Valor referencia</small></th>
          <th><small>Estado</small></th>
          <th><small>&nbsp;</small></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($nr > 0) {
          foreach ($rs as $row) {

            $btnEdit = '<button class="btn btn-success btn-xs" onclick="edit_registro(\'' . $row['id_componentedet'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';

            if ($row['estado'] == "1") {
              $styleEst = "bg-green";
              $btnBajar = '<button class="btn btn-primary btn-xs" onclick="cambiar_orden(\'B\',\'' . $row['id_componentedet'] . '|' . $row['nro_comp'] . '\');"><i class="glyphicon glyphicon-circle-arrow-up"></i></button>';
              $btnSubir = '<button class="btn btn-primary btn-xs" onclick="cambiar_orden(\'S\',\'' . $row['id_componentedet'] . '|' . $row['nro_comp'] . '\');"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>';
            } else {
              $styleEst = "bg-red";
              $btnBajar = '<button class="btn btn-primary btn-xs" disabled><i class="glyphicon glyphicon-circle-arrow-up"></i></button>';
              $btnSubir = '<button class="btn btn-primary btn-xs" disabled><i class="glyphicon glyphicon-circle-arrow-down"></i></button>';
            }
            $nomEstado = '<span class="badge ' . $styleEst . '">' . $row['nom_estado'] . '</span>';
            echo "<tr>";
            echo "<td class='text-center'><small><b>" . $row['nro_comp'] . "</b></small></td>";
            echo "<td class='text-center'><small>" . $btnBajar . " " . $btnSubir . "</small></td>";
            echo "<td><small>" . $row['componente'] . "</small></td>";
            echo "<td><small>" . $row['uni_medida'] . "</small></td>";
            echo "<td><small>" . nl2br($row['valor_ref']) . "</small></td>";
            echo "<td class='text-center'><small>" . $nomEstado . "</small></td>";
            echo "<td class='text-center'><small>" . $btnEdit . "</small></td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  break;
  case 'POST_ADD_REGCOMPPORCPT':
  if($_POST['txtTipIng'] == "C"){
    $action = 'C';
  } else {
    if($_POST['txtIdCpt'] == "1"){
      $action = 'I';
    } else {
      $action = 'A';
    }
  }

  $paramReg[0]['accion'] = $action;
  $paramReg[0]['detcompcpt'] = $_POST['txtIdCpt'] . "|" . $_POST['txtIdCompDet'];
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $c->post_reg_componentedetcpt($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar el usuario";
    exit();
  }
  echo "OK|".$rs;
  exit();
  break;
  case 'GET_SHOW_COMPPORIDCPT':
  $rs = $c->get_datosComponentePorIdCpt($_POST['idCpt']);
  $nr = count($rs);
  ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th><small>Componente</small></th>
          <th><small>Grupo</small></th>
          <th><small>Area</small></th>
          <th><small>Estado</small></th>
          <th><small>&nbsp;</small></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($nr > 0) {
          foreach ($rs as $row) {

            if ($row['estado'] == "1") {
              $btnEdit = '<button class="btn btn-danger btn-xs" onclick="cambio_estado(\'' . $row['id_componentedetcpt'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-remove"></i></button>';
              $styleEst = "bg-green";
            } else {
              $btnEdit = '<button class="btn btn-success btn-xs" onclick="cambio_estado(\'' . $row['id_componentedetcpt'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-ok"></i></button>';
              $styleEst = "bg-red";
            }
            $nomEstado = '<span class="badge ' . $styleEst . '">' . $row['nom_estado'] . '</span>';
            echo "<tr>";
            echo "<td><small>" . $row['componente'] . "</small></td>";
            echo "<td><small>" . $row['grupo'] . "</small></td>";
            echo "<td><small>" . $row['area'] . "</small></td>";
            echo "<td class='text-center'><small>" . $nomEstado . "</small></td>";
            echo "<td class='text-center'><small>" . $btnEdit . "</small></td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  break;
  case 'GET_SHOW_LISTACOMPDETPORIDGRUPOAREA':
  $rs = $c->get_listaCompDetPorIdGrupoArea($_POST['txtIdGrupoArea']);
  echo json_encode($rs);
  break;
  case 'GET_SHOW_COMPPORIDPRODUCTO':
  $rs = $c->get_datosComponentePorIdProducto($_POST['idProd']);
  $nr = count($rs);
  ?>
  <!--<div class="table-responsive">-->
    <div class="panel panel-default" id="parent" style="overflow: auto;">
    <table id="fixTable" class="table table-bordered table-hover">
      <thead>
        <tr>
		  <th>Producto<br/>Relacionado</th>
          <th>Componente</th>
          <th>Grupo</th>
          <th>Area</th>
          <th>Estado</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($nr > 0) {
          foreach ($rs as $row) {

            if ($row['estado'] == "1") {
              $btnEdit = '<button class="btn btn-danger btn-xs" onclick="cambio_estado(\'' . $row['id_componentedetprod'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-remove"></i></button>';
              $styleEst = "bg-green";
            } else {
              $btnEdit = '<button class="btn btn-success btn-xs" onclick="cambio_estado(\'' . $row['id_componentedetprod'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-ok"></i></button>';
              $styleEst = "bg-red";
            }
            $nomEstado = '<span class="badge ' . $styleEst . '">' . $row['nom_estado'] . '</span>';
            echo "<tr>";
			echo "<td><small>" . $row['nom_productoori'] . "</small></td>";
            echo "<td><small><b>" . $row['componente'] . "</b></small></td>";
            echo "<td><small>" . $row['grupo'] . "</small></td>";
            echo "<td><small>" . $row['area'] . "</small></td>";
            echo "<td class='text-center'><small>" . $nomEstado . "</small></td>";
            echo "<td class='text-center'><small>" . $btnEdit . "</small></td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  break;
  case 'POST_ADD_REGCOMPPORPRODUCTO':
  $txtIdPerfil = "";
  if($_POST['txtTipIng'] == "CC"){
    $action = 'CC';
	$txtIdPerfil = $_POST['txtIdPerfil'];
  } else if($_POST['txtTipIng'] == "CP"){
    $action = 'CP';
	$txtIdPerfil = $_POST['txtIdPerfil'];
  } else {
    if($_POST['txtIdProd'] == "1"){
      $action = 'I';
    } else {
      $action = 'A';
    }
  }

  $paramReg[0]['accion'] = $action;
  $paramReg[0]['detcompprod'] = $_POST['txtIdProd'] . "|" . $_POST['txtIdCompDet'] . "|" . $txtIdPerfil;
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $c->post_reg_componentedetproducto($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar el registro";
    exit();
  }
  echo "OK|".$rs;
  exit();
  break;
  case 'POST_ADD_REGMETODO':
  if($_POST['accion_sp'] == "ELI"){
	  $arr_datos[0] = array('');
	  $paramReg[0]['accion'] ="EM";
	  $paramReg[0]['id'] =$_POST['id_metodo'];
	  $paramReg[0]['valreferencial'] = to_pg_array($arr_datos);
	  $paramReg[0]['userIngreso'] = $labIdUser;
	  /*print_r($paramReg);
	  exit();*/
	  $rs = $c->post_reg_componentevalref($paramReg);
	  echo $rs;
	  exit();
  } else {
	  if($_POST['id_metodo'] == "0"){
		$accion = 'IM';
	  } else {
		$accion = 'AM';
	  }
	  $arr_datos[0] = array($_POST['abrev_metodo'], $_POST['nombre_metodo'], $_POST['descrip_metodo']);
	  $paramReg[0]['accion'] = $accion;
	  $paramReg[0]['id'] = $_POST['id_metodo'];
	  $paramReg[0]['valreferencial'] = to_pg_array($arr_datos);
	  $paramReg[0]['userIngreso'] = $labIdUser;
	  /*print_r($paramReg);
	  exit();*/
	  $rs = $c->post_reg_componentevalref($paramReg);
	  echo $rs;
	  exit();
  }
  break;
  case 'POST_ADD_REGCOMPONENTEMETODO':
  if($_POST['accion_sp'] == "ELI"){
	  $arr_datos[0] = array('');
	  $paramReg[0]['accion'] ="EMC";
	  $paramReg[0]['id'] =$_POST['id_comp_metodo'];
	  $paramReg[0]['valreferencial'] = to_pg_array($arr_datos);
	  $paramReg[0]['userIngreso'] = $labIdUser;
	  /*print_r($paramReg);
	  exit();*/
	  $rs = $c->post_reg_componentevalref($paramReg);
	  echo $rs;
	  exit();
  } else {
	  if($_POST['id_comp_metodo'] == "0"){
		$accion = 'IMC';
	  } else {
		$accion = 'AMC';
	  }
	  $arr_datos[0] = array($_POST['id_metodo'], $_POST['id_tipo_ing_valref']);
	  $paramReg[0]['accion'] = $accion;
	  $paramReg[0]['id'] = $_POST['id_componente'];
	  $paramReg[0]['valreferencial'] = to_pg_array($arr_datos);
	  $paramReg[0]['userIngreso'] = $labIdUser;
	  /*print_r($paramReg);
	  exit();*/
	  $rs = $c->post_reg_componentevalref($paramReg);
	  echo $rs;
	  exit();
  }
  break;
  case 'POST_ADD_REGCOMPVALREFERENCIAL':
  if($_POST['txtTipIng'] == "ELI"){
	  $arr_datos[0] = array('');
	  $paramReg[0]['accion'] ="EVR";
	  $paramReg[0]['id'] =$_POST['id_valor_referencial'];
	  $paramReg[0]['valreferencial'] = to_pg_array($arr_datos);
	  $paramReg[0]['userIngreso'] = $labIdUser;
	  /*print_r($paramReg);
	  exit();*/
	  $rs = $c->post_reg_componentevalref($paramReg);
	  echo $rs;
	  exit();
  } else {
	  if($_POST['txtIdValComp'] == "0"){
		$accion = 'IVR';
	  } else {
		$accion = 'AVR';
	  }
	  $arr_datos[0] = array($_POST['txtIdSexo'], $_POST['txtAnioMin'], trim($_POST['txtMesMin']), trim($_POST['txtDiaMin']), trim($_POST['txtAnioMax']), trim($_POST['txtMesMax']), trim($_POST['txtDiaMax']), trim($_POST['txtLimInf']), trim($_POST['txtLimSup']), trim($_POST['txtDescrip']));
	  $paramReg[0]['accion'] = $accion;
	  $paramReg[0]['id'] = $_POST['id_comp_metodo'];
	  $paramReg[0]['valreferencial'] = to_pg_array($arr_datos);
	  $paramReg[0]['userIngreso'] = $labIdUser;
	  /*print_r($paramReg);
	  exit();*/
	  $rs = $c->post_reg_componentevalref($paramReg);
	  echo $rs;
	  exit();
  }
  break;
  case 'GET_SHOW_COMPVALORREFPORIDCOMP':
  $rs = $c->get_datosValorReferencialPorIdCompMet($_POST['id_comp_metodo']);
  $nr = count($rs);
  ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th><small>Sexo</small></th>
          <th><small>Edad Mínima</small></th>
          <th><small>Edad Máxima</small></th>
          <th><small>Lim. Inf.</small></th>
          <th><small>Lim. Sup.</small></th>
          <th><small>Descripción</small></th>
          <th><small>Estado</small></th>
          <th><small>&nbsp;</small></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($nr > 0) {
          foreach ($rs as $row) {

            if ($row['estado'] == "1") {
              $btnEdit = '<button class="btn btn-danger btn-xs" onclick="cambio_estado_valorref(\'' . $row['id'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-remove"></i></button>';
              $styleEst = "bg-green";
            } else {
              $btnEdit = '<button class="btn btn-success btn-xs" onclick="cambio_estado_valorref(\'' . $row['id'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-ok"></i></button>';
              $styleEst = "bg-red";
            }
            $nomEstado = '<span class="badge ' . $styleEst . '">' . $row['nom_estado'] . '</span>';
            echo "<tr>";
            echo "<td class='text-center'><small>" . $row['id_sexo'] . "</small></td>";
            echo "<td><small>" . $row['edadanio_min'] . " años " . $row['edadmes_min'] . " meses " . $row['edaddia_min'] . " dias</small></td>";
            echo "<td><small>" . $row['edadanio_max'] . " años " . $row['edadmes_max'] . " meses " . $row['edaddia_max'] . " dias</small></td>";
            echo "<td><small>" . $row['lim_inf'] . "</small></td>";
            echo "<td><small>" . $row['lim_sup'] . "</small></td>";
            echo "<td><small>" . nl2br($row['descip_valref']) . "</small></td>";
            echo "<td class='text-center'><small><small>" . $nomEstado . "</small></small></td>";
            echo "<td class='text-center'><small>" . $btnEdit . "</small></td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  break;
  case 'GET_SHOW_DETSELECCIONRESULTADOPORIDSELECCION':
	  $rs = $c->get_listaDetSeleccionResultadoPorIdSeleccion($_POST['id_comp_seleccion']);
	  echo json_encode($rs);
  break;
  case 'GET_SHOW_LISTATIPOSELECCIONRESULTADO':
	  $rs = $c->get_listaTipoSeleccionResultado();
	  echo json_encode($rs);
  break;
  case 'POST_ADD_REGSELECCIONRESULTADO':
		if($_POST['accion_proc'] == "VDD"){
			$arr_selecresul[0] = array('');
		} else if($_POST['accion_proc'] == "BD"){
			$arr_selecresul[0] = array($_POST['nro_orden_actu']);
		} else if($_POST['accion_proc'] == "SD"){
			$arr_selecresul[0] = array($_POST['nro_orden_actu']);
		} else if($_POST['accion_proc'] == "EN"){
			$arr_selecresul[0] = array('');
		} else if($_POST['accion_proc'] == "ED"){
			$arr_selecresul[0] = array('');
		} else {
			$arr_selecresul[0] = array(trim($_POST['abreviatura']), trim($_POST['nombre']));
		}
		$paramReg[0]['accion'] = $_POST['accion_proc'];
		$paramReg[0]['id'] = $_POST['id'];
		$paramReg[0]['datos'] = to_pg_array($arr_selecresul);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $c->post_reg_componente_seleccionresul($paramReg);
		echo $rs;
		exit();
  break;
}
?>

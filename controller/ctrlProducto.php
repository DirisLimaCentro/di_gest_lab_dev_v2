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

require_once '../model/Producto.php';
$p = new Producto();


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
  case 'GET_SHOW_DETPRODUCTO':
  $rs = $p->get_datosProductoPorId($_POST['txtIdProd']);
  $nr = count($rs);
  if ($nr > 0) {
    $datos = array(
      0 => $rs[0]['id_producto'],
      1 => trim($rs[0]['codref_producto']),
      2 => trim($rs[0]['nom_producto']),
      3 => trim($rs[0]['descrip_prepapro']),
      4 => trim($rs[0]['descrip_insupro']),
      5 => trim($rs[0]['descrip_obspro']),
      6 => $rs[0]['idtipo_producto'],
      7 => $rs[0]['nomtipo_producto'],
      8 => $rs[0]['id_estado'],
      9 => $rs[0]['nom_estado'],
    );
    echo json_encode($datos);
  } else {
    $datos = array(
      0 => '0'
    );
  }
  break;
  case 'POST_ADD_REGPRODUCTO':
  if($_POST['txtIdProd'] == "0"){
    $action = 'C';
  } else {
    $action = 'E';
  }
  $arr_prod[0] = array($_POST['txtIdProd'], $_POST['txtCodProd'], trim($_POST['txtIdTipProd']), trim($_POST['txtNomProd']), trim($_POST['txtPrepaProd']), $_POST['txtInsuProd'], trim($_POST['txtObsProd']));
  $paramReg[0]['accion'] = $action;
  $paramReg[0]['producto'] = to_pg_array($arr_prod);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $p->post_reg_producto($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar el registro";
    exit();
  }
  echo $rs;
  exit();
  break;
  case 'POST_CAMBIA_EST_PRODUCTO':
	  $arr_prod[0] = array($_POST['id_producto'], $_POST['idtipo_producto'], $_POST['id_estado_actual']);
	  $paramReg[0]['accion'] = 'CE';
	  $paramReg[0]['producto'] = to_pg_array($arr_prod);
	  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
	  /*print_r($paramReg);
	  exit();*/
	  $rs = $p->post_reg_producto($paramReg);
	  if ($rs == "E") {
		echo "ER|Error al ingresar el registro";
		exit();
	  }
	  echo $rs;
	  exit();
  break;
  case 'GET_SHOW_DEPPORIDPRODUCTO':
  $rs = $p->get_datosDependenciaPorIdProducto($_POST['idProd']);
  $nr = count($rs);
  ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th><small>Dependencia</small></th>
          <th><small>Precio SIS</small></th>
          <th><small>Precio Part.</small></th>
		  <th><small>Ameri-<br/>cana</small></th>
		  <th><small>Diagnós-<br/>tica</small></th>
          <th><small>Estado</small></th>
          <th><small>&nbsp;</small></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($nr > 0) {
          foreach ($rs as $row) {

            if ($row['estado'] == "1") {
              $btnEst = '<button class="btn btn-danger btn-xs" onclick="cambio_estado_dep(\'' . $row['id_productodepen'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-remove"></i></button>';
              $btnEdit = '<button class="btn btn-success btn-xs" onclick="edit_dependencia(\'' . $row['id_productodepen'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
              $styleEst = "bg-green";
            } else {
              $btnEst = '<button class="btn btn-success btn-xs" onclick="cambio_estado_dep(\'' . $row['id_productodepen'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-ok"></i></button>';
              $btnEdit = '';
              $styleEst = "bg-red";
            }
            $nomEstado = '<span class="badge ' . $styleEst . '">' . $row['nom_estado'] . '</span>';
            echo "<tr>";
            echo "<td><small>" . $row['nom_depen'] . "</small></td>";
            echo "<td><small>" . $row['prec_sis'] . "</small></td>";
            echo "<td><small>" . $row['prec_parti'] . "</small></td>";
			$esamericana = $row['es_americana'] == "SI" ? "0" : "1";
			$esdiagnostica = $row['es_diagnostica'] == "SI" ? "0" : "1";
			$styleamericana = $row['es_americana'] == "SI" ? "btn-success" : "btn-danger";
			$stylediagnostica = $row['es_diagnostica'] == "SI" ? "btn-success" : "btn-danger";
			?>
			<td class="text-center"><button class="btn <?php echo $styleamericana ?> btn-xs" onclick="cambio_estado_dep_ws('AMER', <?php echo $row['id_productodepen'] ?>, '<?php echo $esamericana ?>');"><?php echo $row['es_americana'] ?></button></td>
			<td class="text-center"><button class="btn <?php echo $stylediagnostica ?> btn-xs" onclick="cambio_estado_dep_ws('DIAG', <?php echo $row['id_productodepen'] ?>, '<?php echo $esdiagnostica ?>');"><?php echo $row['es_diagnostica'] ?></button></td>
			<?php
            echo "<td class='text-center'><small>" . $nomEstado . "</small></td>";
            echo "<td class='text-center'><small>" . $btnEdit.$btnEst . "</small></td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  break;
  case 'GET_SHOW_ORDENPRODUCTOPORTIPOPRODUCTO':
  $param[0]['id_tipo']=$_POST['idtipo'];
  $param[0]['id_establecimiento']=0;
  $rs = $p->get_repDatosProductoDependencia($param);
  $nr = count($rs);
  ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
		  <tr>
			  <th>Orden</th>
			  <th><i class="fa fa-cogs"></i></th>
			  <th>Código</th>
			  <th>Producto</th>
		  </tr>
		</thead>
      <tbody>
        <?php
        if ($nr > 0) {
          foreach ($rs as $row) {

            $btnBajar = '<button class="btn btn-primary btn-xs" onclick="cambiar_orden(\'' . $_POST['idtipo'] . '\',\'B\',\'' . $row['id_producto'] . '|' . $row['orden_por_tipo_producto'] . '\');"><i class="glyphicon glyphicon-circle-arrow-up"></i></button>';
            $btnSubir = '<button class="btn btn-primary btn-xs" onclick="cambiar_orden(\'' . $_POST['idtipo'] . '\',\'S\',\'' . $row['id_producto'] . '|' . $row['orden_por_tipo_producto'] . '\');"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>';
			echo "<tr>";
            echo "<td class='text-center'><small><b>" . $row['orden_por_tipo_producto'] . "</b></small></td>";
            echo "<td class='text-center'><small>" . $btnBajar . " " . $btnSubir . "</small></td>";
            echo "<td><small>" . $row['codref_producto'] . "</small></td>";
            echo "<td><small>" . $row['nom_producto'] . "</small></td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  break;
  case 'GET_REG_CAMBIOORDENPRODUCTOPORTIPOPRODUCTO':
	  $arr_prod[0] = array($_POST['idprod'], $_POST['idtipo']);
	  $paramReg[0]['accion'] = $_POST['accion_proc'];
	  $paramReg[0]['producto'] = to_pg_array($arr_prod);
	  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
	  /*print_r($paramReg);
	  exit();*/
	  $rs = $p->post_reg_producto($paramReg);
	  echo $rs;
  break;
  case 'GET_SHOW_DETDEPPRODUCTO':
  $rs = $p->get_datosDependenciaProductoPorId($_POST['txtIdProdDep']);
  $nr = count($rs);
  if ($nr > 0) {
    $datos = array(
      0 => $rs[0]['id_productodepen'],
      1 => $rs[0]['id_producto'],
      2 => $rs[0]['id_dependencia'],
      3 => trim($rs[0]['codref_producto']),
      4 => $rs[0]['nom_producto'],
      5 => trim($rs[0]['codref_depen']),
      6 => $rs[0]['nom_depen'],
      7 => $rs[0]['prec_sis'],
      8 => $rs[0]['prec_parti'],
      9 => $rs[0]['id_estado'],
      10 => $rs[0]['nom_estado']
    );
    echo json_encode($datos);
  } else {
    $datos = array(
      0 => '0'
    );
  }
  break;
  case 'POST_ADD_REGDEPPORPRODUCTO':
	if($_POST['txtTipIng'] == "C"){
		$idProd = $_POST['txtIdProd'];
		$idDep = $_POST['txtIdDep'];
		$preSIS = $_POST['txtPreSIS'];
		$prePart = $_POST['txtPrePart'];
		if($_POST['txtIdProdDep'] == "0"){
			$array_id_dep = explode(",", $idDep);
			//$nro = 0;
			foreach ($array_id_dep as $id_dep) {
				$paramReg[0]['accion'] = 'C';
				$paramReg[0]['detproddep'] = $_POST['txtIdProdDep'] . "|" . $idProd . "|" . $id_dep . "|" . $preSIS . "|" . $prePart;
				$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
				//$nro++;
				/*print_r($paramReg);
				exit();*/
				$rs = $p->post_reg_productodepen($paramReg);
			}
			if ($rs == "E") {
				echo "ER|Error al ingresar el registro";
				exit();
			}
			echo "OK|".$rs;
			exit();
		} else {
			$paramReg[0]['accion'] = 'E';
			$paramReg[0]['detproddep'] = $_POST['txtIdProdDep'] . "|" . $idProd . "|" . $idDep . "|" . $preSIS . "|" . $prePart;
			$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
			/*print_r($paramReg);
			exit();*/
			$rs = $p->post_reg_productodepen($paramReg);
			if ($rs == "E") {
			echo "ER|Error al ingresar el registro";
			exit();
			}
			echo "OK|".$rs;
			exit();
		}
	} else if($_POST['txtTipIng'] == "E") {
		if($_POST['txtIdEstProdDep'] == "1"){
		  $action = 'I';
		} else {
		  $action = 'A';
		}
		$idProd = 0;
		$idDep = 0;
		$preSIS = 0;
		$prePart = 0;

		$paramReg[0]['accion'] = $action;
		$paramReg[0]['detproddep'] = $_POST['txtIdProdDep'] . "|" . $idProd . "|" . $idDep . "|" . $preSIS . "|" . $prePart;
		$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $p->post_reg_productodepen($paramReg);
		if ($rs == "E") {
		echo "ER|Error al ingresar el registro";
		exit();
		}
		echo "OK|".$rs;
		exit();
	} else {
		$paramReg[0]['accion'] = $_POST['txtTipIng'];
		$paramReg[0]['detproddep'] = $_POST['txtIdProdDep'] . "|" . $_POST['txtIdEstProdDep'];
		$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $p->post_reg_productodepen($paramReg);
		if ($rs == "E") {
		echo "ER|Error al ingresar el registro";
		exit();
		}
		echo "OK|".$rs;
		exit();
	}
  break;
  case 'POST_SHOW_PRODUCTOPORPERFIL':
	$rs = $p->get_listaProductoLaboratorioPorIdDepAndIdPerfil($labIdDepUser, $_POST['id_perfil']);
	echo json_encode($rs);
  break;
}
?>

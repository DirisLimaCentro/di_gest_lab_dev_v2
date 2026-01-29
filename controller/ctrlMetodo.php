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
  case 'GET_SHOW_DETMETODO':
	$rs = $c->get_listaMetodos($_POST['id']);
	$nr = count($rs);
	if ($nr > 0) {
		$datos = array(
		  0 => $rs[0]['id'],
		  1 => $rs[0]['abreviatura_metodo'],
		  2 => trim($rs[0]['nombre_metodo']),
		  3 => trim($rs[0]['descrip_metodo']),
		  4 => $rs[0]['estado'],
		  5 => $rs[0]['nom_estado'],
		);
		echo json_encode($datos);
	} else {
		$datos = array(
			0 => '0'
		);
	}
  break;
  case 'GET_SHOW_LISTAMETODOPORCOMP':
	$rs = $c->get_listaMetodoPorIdComponente($_POST['id_componente'], 1);
	echo json_encode($rs);
  break;
  case 'GET_SHOW_LISTAMETODOSACTIVO':
	  $rs = $c->get_listaMetodos(0,1);
	  echo json_encode($rs);
  break;
	case 'GET_SHOW_METODOS':
		$rs = $c->get_listaMetodos();
		$nr = count($rs);
		?>
		<div class="table-responsive">
		<table class="table table-bordered table-hover">
		  <thead>
			<tr>
				<th><small>Abreviatura</small></th>
                <th><small>Nombre</small></th>
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
					$btnEdit = '<button class="btn btn-success btn-xs" onclick="edit_registro_metodo(\'' . $row['id'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
					$btnEst = '<button class="btn btn-danger btn-xs" onclick="cambio_estado_metodo(\'' . $row['id'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-remove"></i></button>';
					$styleEst = "bg-green";
				} else {
					$btnEdit = '';
					$btnEst = '<button class="btn btn-success btn-xs" onclick="cambio_estado_metodo(\'' . $row['id'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-ok"></i></button>';
					$styleEst = "bg-red";
				}
				$nomEstado = '<span class="badge ' . $styleEst . '">' . $row['nom_estado'] . '</span>';
				echo "<tr>";
				echo "<td><small>" . $row['abreviatura_metodo'] . "</small></td>";
				echo "<td><small>" . $row['nombre_metodo'] . "</small></td>";
				echo "<td><small>" . nl2br($row['descrip_metodo']) . "</small></td>";
				echo "<td class='text-center'><small><small>" . $nomEstado . "</small></small></td>";
				echo "<td class='text-center'><small>" . $btnEdit . $btnEst . "</small></td>";
				echo "</tr>";
			  }
			}
			?>
		  </tbody>
		</table>
		</div>
		<?php
	break;
	case 'GET_SHOW_COMPMETODOPORCOMP':
		$rs = $c->get_listaMetodoPorIdComponente($_POST['id_componente']);
		$nr = count($rs);
		?>
		<div class="table-responsive">
		<table class="table table-bordered table-hover">
		  <thead>
			<tr>
                <th><small>Método</small></th>
				<th><small>Tipo ing. valor ref.</small></th>
                <th><small>Descripción</small></th>
                <th><small>Cnt. Valores</small></th>
                <th><small>Estado</small></th>
                <th><small>&nbsp;</small></th>
              </tr>
		  </thead>
		  <tbody>
			<?php
			if ($nr > 0) {
			  foreach ($rs as $row) {

				if ($row['estado'] == "1") {
					$btnVal = '<button class="btn btn-primary btn-xs" onclick="open_valores(\'' . $row['id'] . '\',\'' . $row['nombre_metodo'] . '\');"><i class="glyphicon glyphicon-list-alt"></i></button>';
					$btnEdit = '<button class="btn btn-danger btn-xs" onclick="cambio_estado_comp_metodo(\'' . $row['id'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-remove"></i></button>';
					$styleEst = "bg-green";
				} else {
					$btnVal = '';
					$btnEdit = '<button class="btn btn-success btn-xs" onclick="cambio_estado_comp_metodo(\'' . $row['id'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-ok"></i></button>';
					$styleEst = "bg-red";
				}
				$nomEstado = '<span class="badge ' . $styleEst . '">' . $row['nom_estado'] . '</span>';
				echo "<tr>";
				echo "<td><small>" . $row['nombre_metodo'] . "</small></td>";
				echo "<td><small>" . $row['nombre_tipo_val_ref'] . "</small></td>";
				echo "<td><small>" . nl2br($row['descrip_metodo']) . "</small></td>";
				echo "<td class='text-center'><small>" . $row['cnt_valref'] . "</small></td>";
				echo "<td class='text-center'><small><small>" . $nomEstado . "</small></small></td>";
				echo "<td class='text-center'><small>" . $btnVal . $btnEdit . "</small></td>";
				echo "</tr>";
			  }
			}
			?>
		  </tbody>
		</table>
		</div>
		<?php
	break;
}
?>

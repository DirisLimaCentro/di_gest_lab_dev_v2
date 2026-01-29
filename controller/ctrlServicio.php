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

require_once '../model/Servicio.php';
$se = new Servicio();


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
  case 'GET_SHOW_LISTASERVICIODEPPORIDDEP':
    $rs = $se->get_listaServicioDependenciaPorIdDep($_POST['txtIdDep']);
    echo json_encode($rs);
  break;
  case 'GET_SHOW_LISTASERVICIOPORIDDEP':
    $rs = $se->get_listaServicioPorIdDep($_POST['txtIdDep']);
    echo json_encode($rs);
  break;
  case 'GET_SHOW_SERVICIOPORIDDEP':
  $rs = $se->get_datosServicioPorIdDep($_POST['idDep']);
  $nr = count($rs);
  ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th><small>Servicio</small></th>
          <th><small>Estado</small></th>
          <th class="text-center"><small><i class="fa fa-cogs"></i></small></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($nr > 0) {
          foreach ($rs as $row) {

            if ($row['estado'] == "1") {
              $styleEst = "bg-green";
              $btnEst = '<button type="button" class="btn btn-danger btn-xs" onclick="cambio_serviciodep(\'' . $row['id_serviciodep'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-remove-circle"></i></button>';
            } else {
              $styleEst = "bg-red";
              $btnEst = '<button type="button" class="btn btn-success btn-xs" onclick="cambio_serviciodep(\'' . $row['id_serviciodep'] . '\',\'' . $row['estado'] . '\');"><i class="glyphicon glyphicon-ok"></i></button>';
            }

            $nomEstado = '<span class="badge ' . $styleEst . '">' . $row['nom_estado'] . '</span>';
            echo "<tr>";
            echo "<td><small>" . $row['nom_servicio'] . "</small></td>";
            echo "<td class='text-center'><small>" . $nomEstado . "</small></td>";
            echo "<td class='text-center'><small>" . $btnEst . "</small></td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  break;
  case 'POST_ADD_REGSERVICIOPORDEP':
  if(isset($_POST['txtIdServicioDep'])){
    $arr_serdep[0] = array($_POST['txtIdServicioDep'], $_POST['txtIdEstServicioDep']);
    $paramReg[0]['accion'] = 'E';
  } else {
    $arr_serdep[0] = array($_POST['txtIdDep'], $_POST['txtIdServicio']);
    $paramReg[0]['accion'] = 'C';
  }

  $paramReg[0]['serviciodep'] = to_pg_array($arr_serdep);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser;
  $rs = $se->post_reg_serviciodep($paramReg);
  echo $rs;
  break;
}
?>

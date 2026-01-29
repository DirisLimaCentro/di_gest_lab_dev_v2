<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<style>
#parent {
  height: 400px;
}
</style>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Area.php';
$a = new Area();
require_once '../../model/Grupo.php';
$g = new Grupo();
require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/Producto.php';
$p = new Producto();
require_once '../../model/Cpt.php';
$cpt = new Cpt();
?>
<?php
require_once '../../model/Atencion.php';
$at = new Atencion();
$idAtencion = $_GET['nroSoli'];
$rsA = $at->get_datosAtencion($idAtencion);
?>

<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Registro de análisis clínico</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmPaciente" id="frmPaciente">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="<?php echo $_GET['nroSoli']?>"/>
        <div class="row">
          <div class="col-sm-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Datos de la referencia</strong></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-2">
                    <label for="txtHCPac">Atención</label>
                    <input type="text" name="txtNroAtencion" id="txtNroAtencion" class="form-control input-xs" value="<?php echo $rsA[0]['nro_atencion']." - ".$rsA[0]['sigla_plan']?>" disabled/>
                  </div>
                  <div class="col-sm-2">
                    <label for="txtHCPac">HCL.</label>
                    <input type="text" name="txtHCPac" id="txtHCPac" class="form-control input-xs" value="<?php echo $rsA[0]['nro_hcpac']?>" disabled/>
                  </div>
                  <div class="col-sm-7">
                    <label for="txtNomPac">Paciente</label>
                    <input type="text" name="txtNomPac" id="txtNomPac" class="form-control input-xs" value="<?php echo $rsA[0]['nombre_rspac']?>" disabled/>
                  </div>
                  <!--<div class="col-sm-1 text-center">
                    <label>Detalle</label><br/>
                    <button type="button" class="btn btn-primary btn-xs" onclick="open_fua('<?php echo $_GET['nroSoli']?>');"><i class="fa fa-h-square"></i></button>
                  </div>-->
                  <div class="col-sm-2">
                    <label for="txtHCPac">Sexo</label>
                    <input type="text" name="txtSexoPac" id="txtSexoPac" class="form-control input-xs" value="<?php echo $rsA[0]['nom_sexopac']?>" disabled/>
                  </div>
                  <div class="col-sm-4">
                    <label for="txtHCPac">Edad</label>
                    <input type="text" name="txtDetEdadPac" id="txtDetEdadPac" class="form-control input-xs" value="<?php echo $rsA[0]['edad_anio']." años ". $rsA[0]['edad_mes']. " meses ". $rsA[0]['edad_dia']. " dias."?>" disabled/>
                    <input type="hidden" name="txtEdadAnioPac" id="txtEdadAnioPac" value="<?php echo $rsA[0]['edad_anio'];?>"/>
                    <input type="hidden" name="txtEdadMesPac" id="txtEdadMesPac" value="<?php echo $rsA[0]['edad_mes'];?>"/>
                    <input type="hidden" name="txtEdadDiaPac" id="txtEdadDiaPac" value="<?php echo $rsA[0]['edad_dia'];?>"/>
                  </div>
                </div>
                <?php
                $nomSexo = $rsA[0]['nom_sexopac'];
                $edadAnio = $rsA[0]['edad_anio'];
                $edadMes =  $rsA[0]['edad_mes'];
                $edadDia =  $rsA[0]['edad_dia'];
                ?>
                <h4>Procedimiento de laboratorio solicitado(s)</h4>
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><small>&nbsp</small></th>
                        <th><small>Código</small></th>
                        <th><small>Nombre</small></th>
                        <th><small>Tipo</small></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ip = (int)1;
                      $rsCtp = $at->get_datosProductoPorIdAtencion($idAtencion);
                      foreach ($rsCtp as $rowCpt) {
                        echo "<tr>";
                        echo "<td class=\"text-center\">".$ip ++."</td>";
                        echo "<td class=\"text-center\">".$rowCpt['codref_producto']."</td>";
                        echo "<td>".$rowCpt['nom_producto']."</td>";
                        echo "<td>".$rowCpt['nomtipo_producto']."</td>";
                        echo "</tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- Fin Datos Personales -->
          </div>
          <div class="col-sm-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Detalle de resultados ingresados</strong></h3>
              </div>
              <div class="panel-body">
                <div id="parent">
                  <table id="fixTable" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Análisis Clínico</th>
                        <th>U.M</th>
                        <th>Resultado</th>
                        <th>Valor de referencia</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $countP = 0;
                      $rsP = $p->get_listaProductoPorIdAtencion($idAtencion);
                      foreach ($rsP as $rowP) {
                        $countP++;
                        if($countP%2==0){
                          $trPColor = "success";
                        } else {
                          $trPColor = "";
                        }
                        echo '<tr class="'.$trPColor.'"><td colspan="4"><b>'.$rowP['nom_producto'].'</b></td></tr>';
                        $rsPA = $p->get_listaProductoAnteriorPorIdProducto($rowP['id_producto']);
                        foreach ($rsPA as $rowPA) {
                          $trPAColor = "";
                          $idProdAnte = "";
                          if ($rowPA['id_productoori'] <> ""){
                             $idProdAnte = $rowPA['id_productoori'];
                             $rsDP = $p->get_datosProductoPorId($idProdAnte);
                             echo '<tr class="'.$trPColor.'"><td colspan="4"><b>'.$rsDP[0][2].'</b></td></tr>';
                          }
                          $rsA = $a->get_listaAreaPorIdAtencionAndIdProductoAndIdProdAnterior($idAtencion, $rowP['id_producto'], $idProdAnte);
                          foreach ($rsA as $rowA) {
                            //echo '<tr class="'.$trPColor.'"><td><b><small>'.$rowA['area'].'</small></b></td><td></td><td></td><td></td></tr>';
                            $rsG = $g->get_listaGrupoPorIdAreaAndIdAtencionAndIdProducto($idAtencion, $rowA['id_area'], $rowP['id_producto']);
                            $cantG = Count($rsG);
                            foreach ($rsG as $rowG) {
                              $rsC = $c->get_listaComponenteResulPorIdGrupoAreaAndIdAtencionAndIdProducto($rowG['id_grupoarea'], $idAtencion, $rowP['id_producto']);
                              foreach ($rsC as $rowC) {
                                if ($rowC['tipo_ingresosol'] == "1"){
                                $valMin = "";
                                $valMax = "";
                                $totVal = "";
                                $valRes = $rowC['det_result'];
                                $valColor = "";
                                switch($rowC['idtipcarac_ingsol']){
                                  case "1":
                                  $totVal = nl2br($rowC['valor_ref']);
                                  break;
                                  case "2":
                                  $totVal = nl2br($rowC['valor_ref']);
                                  break;
                                  case "3":
                                  if($rowC['liminf'] <> "") {
                                    $valMin = $rowC['liminf'];
                                    $valMax = $rowC['limsup'];
                                    $totVal = number_format($rowC['liminf']) . " - " . number_format($rowC['limsup']);
                                    $valRes = number_format($rowC['det_result']);
                                    if($rowC['det_result'] < $valMin){
                                      $valColor = "1";
                                    }
                                    if($rowC['det_result'] > $valMax) {
                                      $valColor = "2";
                                    }
                                  } else {
                                    $totVal = nl2br($rowC['valor_ref']);
                                  }
                                  break;
                                  case "4":
                                  if($rowC['liminf'] <> "") {
                                    $valMin = $rowC['liminf'];
                                    $valMax = $rowC['limsup'];
                                    $totVal = number_format($rowC['liminf'], $rowC['dettipcarac_ingsol'], '.', '') . " - " . number_format($rowC['limsup'], $rowC['dettipcarac_ingsol'], '.', '');
                                    $valRes = number_format($rowC['det_result'], $rowC['dettipcarac_ingsol'], '.', '');
                                    if($rowC['det_result'] < $valMin){
                                      $valColor = "text-danger text-bold";
                                    }
                                    if($rowC['det_result'] > $valMax) {
                                      $valColor = "text-warning text-bold";
                                    }
                                  } else {
                                    $totVal = nl2br($rowC['valor_ref']);
                                  }
                                  break;
                                  default:
                                  $totVal = nl2br($rowC['valor_ref']);
                                  break;
                                }
                                echo '<tr class="'.$trPColor.'"><td>'.$rowC['componente'].'</td><td class="text-center"><small>'.$rowC['uni_medida'].'</small></td><td class="text-center '. $valColor.'">'.$valRes.'</td><td><small>'.$totVal.'</small></td></tr>';
							  } elseif ($rowC['tipo_ingresosol'] == "2") {
								echo '<tr class="'.$trPColor.'"><td>'.$rowC['componente'].'</td><td class="text-center"><small>'.$rowC['uni_medida'].'</small></td><td colspan="2">'.nl2br($rowC['det_result']).'</td></tr>';
                              } else {
                                echo '<tr class="'.$trPColor.'"><td>'.$rowC['componente'].'</td><td class="text-center"><small>'.$rowC['uni_medida'].'</small></td><td>'.$rowC['nombreseleccion_resul'].'</td><td><small>'.$rowC['valor_ref'].'</small></td></tr>';
                              }
                              }
                            }
                          }
                        }
                      }
                      ?>

                    </tfoot>
                  </table>
                </div>
              </div><!-- Fin Datos de Parentesco -->
            </div>
          </div>
        </form>
      </div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div id="saveAtencion">
              <div class="btn-group">
                <button class="btn btn-primary btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="reg_valida()"><i class="fa fa-save"></i>  Validar  </button>
                <a href="./main_principallab.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
              </div>
            </div>
            <div id="impriAtencion" style="display: none;">
              <div class="btn-group">
                <button class="btn btn-lg btn-success" id="btn-imrimirall" onclick="print_resul()"><i class="fa fa-file-pdf-o"></i> Imprimir formatos validados</button>
                <a href="./main_principallab.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Salir</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="mostrar_anexos_d" class="modal fade" role="dialog" data-backdrop="static"></div>
<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">

function print_resul(){
  var idAten = $('#txtIdAtencion').val();
  var nomPac = $('#txtNomPac').val();
  $('#mostrar_anexos_d').modal('show');
  $.ajax({
    url: '../../controller/ctrlAtencion.php',
    type: 'POST',
    data: 'accion=GET_SHOW_PDFATENCION&idAten=' + idAten +'&nomPac=' + nomPac,
    success: function(data){
      $('#mostrar_anexos_d').html(data);
    }
  });
}

function open_pdf(idAten, opt) {
  if(opt == "1"){
    var urlwindow = "pdf_laboratorio.php?id_atencion=" + idAten +"&id_area=0";
  } else {
    var urlwindow = "pdf_laboratorioprod.php?id_atencion=" + idAten +"&id_prod=0";
  }
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function reg_valida() {
  bootbox.confirm({
    message: "¿Está seguro de continuar?",
    buttons: {
      confirm: {
        label: 'Si',
        className: 'btn-success'
      },
      cancel: {
        label: 'No',
        className: 'btn-danger'
      }
    },
    callback: function (result) {
      if (result == true) {
        $.ajax({
          type: "POST",
          url: "../../controller/ctrlAtencion.php",
          data: {
            accion: 'POST_ADD_REGVALIDAATENCION', idAten: $('#txtIdAtencion').val(),
          },
          success: function (data) {
            $("#saveAtencion").hide();
            $("#impriAtencion").show();
          }
        });
      } else {
        //
      }
    }
  });
}

$(document).ready(function() {
  $("#fixTable").tableHeadFixer();
});
</script>
<?php require_once '../include/masterfooter.php'; ?>

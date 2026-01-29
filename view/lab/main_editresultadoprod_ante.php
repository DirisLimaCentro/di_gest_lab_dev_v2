<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<style>
#parent {
  height: 450px;
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
      <div class="row">
        <div class="col-sm-5">
          <form name="frmPaciente" id="frmPaciente">
            <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="<?php echo $_GET['nroSoli']?>"/>
            <input type="hidden" name="txtIngResul" id="txtIngResul" value="NO"/>
            <input type="hidden" name="txtShowOptPrint" id="txtShowOptPrint" value=""/>
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
        </form>
      </div>
      <div class="col-sm-7">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Datos de la atención</strong></h3>
          </div>
          <div class="panel-body">
            <form name="frmArea" id="frmArea">
              <div id="parent">
                <table id="fixTable" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Análisis Clínico</th>
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
                      echo '<tr class="'.$trPColor.'"><td colspan="3"><b>'.$rowP['nom_producto'].'</b></td></tr>';
                      $rsPA = $p->get_listaProductoAnteriorPorIdProducto($rowP['id_producto']);
                      foreach ($rsPA as $rowPA) {
                        $trPAColor = "";
                        $idProdAnte = "";
                        if ($rowPA['id_productoori'] <> ""){
                          $idProdAnte = $rowPA['id_productoori'];
                          $rsDP = $p->get_datosProductoPorId($idProdAnte);
                          echo '<tr class="'.$trPColor.'"><td colspan="3"><b>'.$idProdAnte.'-'.$rsDP[0][2].'</b></td></tr>';
                        }
                        $rsA = $a->get_listaAreaPorIdAtencionAndIdProductoAndIdProdAnterior($idAtencion, $rowP['id_producto'], $idProdAnte);
                        foreach ($rsA as $rowA) {
                          //echo '<tr class="'.$trPColor.'"><td><b><small>'.$rowA['area'].'</small></b></td><td></td><td></td></tr>';
                          $rsG = $g->get_listaGrupoPorIdAreaAndIdAtencionAndIdProducto($idAtencion, $rowA['id_area'], $rowP['id_producto']);
                          $cantG = Count($rsG);
                          foreach ($rsG as $rowG) {
								//Jose  :::::  en esta funcion puedo ocultar o mostrar los componentes no ingresados get_listaComponenteResulPorIdGrupoAreaAndIdAtencionAndIdProducto

                            $rsC = $c->get_listaComponenteResulPorIdGrupoAreaAndIdAtencionAndIdProducto($rowG['id_grupoarea'],$idAtencion, $rowP['id_producto']);
                            foreach ($rsC as $rowC) {
                              if ($rowC['tipo_ingresosol'] == "1"){
                                echo '<tr class="'.$trPColor.'"><td style="padding-top: 1px; padding-bottom: 1px;">'.$rowC['componente'].'</td><td style="padding-top: 1px; padding-bottom: 1px;">';
                                $idVal = "";
                                $valMin = "";
                                $valMax = "";
                                $desVal = "";
                                $totVal = "";
                                $valColor = "";
                                $valRes = $rowC['det_result'];
                                $rsVC = $c->get_datosValidaValReferencialComp($rowC['id_componentesol'], $edadAnio, $edadMes, $edadDia, $nomSexo);

                                switch($rowC['idtipcarac_ingsol']){
                                  case "1":
                                  $nameFunValida="";
                                  $nameFunValRef="";
                                  $totVal = nl2br($rowC['valor_ref']);
                                  break;
                                  case "2":
                                  $nameFunValida="keyValidLetter(this.id);";
                                  $nameFunValRef="";
                                  $totVal = nl2br($rowC['valor_ref']);
                                  break;
                                  case "3":
                                  $nameFunValida="keyValidNumber(this.id);";
                                  if(isset($rsVC[0][0])) {
                                    $idVal = $rsVC[0]['idcompvalref'];
                                    $valMin = $rsVC[0]['liminf'];
                                    $valMax = $rsVC[0]['limsup'];
                                    $desVal = $rsVC[0]['descripvalref'];
                                    $totVal = number_format($rsVC[0]['liminf']) . " - " . number_format($rsVC[0]['limsup']) . "<br/>" . $rsVC[0]['descripvalref'];
									if($rowC['det_result'] <> ""){
										$valRes = number_format($rowC['det_result']);
										if($rowC['det_result'] < $valMin){
										  $valColor = "has-error";
										}
										if($rowC['det_result'] > $valMax) {
										  $valColor = "has-warning";
										}
									} else {
										$valRes = "";
									}
                                    $nameFunValRef="keyValidValRef(this.id);";
                                  } else {
                                    $totVal = nl2br($rowC['valor_ref']);
                                    $nameFunValRef="";
                                  }
                                  break;
                                  case "4":
                                  switch($rowC['dettipcarac_ingsol']){
                                    case "1":
                                    $nameFunValida="keyValidNumberDecimalOne(this.id);";
                                    break;
                                    case "2":
                                    $nameFunValida="keyValidNumberDecimalTwo(this.id);";
                                    break;
                                    case "3":
                                    $nameFunValida="keyValidNumberDecimalThree(this.id);";
                                    break;
                                    case "4":
                                    $nameFunValida="keyValidNumberDecimalFour(this.id);";
                                    break;
                                  }
                                  if(isset($rsVC[0][0])) {
                                    $idVal = $rsVC[0]['idcompvalref'];
                                    $valMin = $rsVC[0]['liminf'];
                                    $valMax = $rsVC[0]['limsup'];
                                    $desVal = $rsVC[0]['descripvalref'];
									$totVal = number_format($rsVC[0]['liminf'], $rowC['dettipcarac_ingsol'], '.', '') . " - " . number_format($rsVC[0]['limsup'], $rowC['dettipcarac_ingsol'], '.', '') . "<br/>" . $rsVC[0]['descripvalref'];
									if($rowC['det_result'] <> ""){
										$valRes = number_format($rowC['det_result'], $rowC['dettipcarac_ingsol'], '.', '');
										if($rowC['det_result'] < $valMin){
										  $valColor = "has-error";
										}
										if($rowC['det_result'] > $valMax) {
										  $valColor = "has-warning";
										}
									} else {
										$valRes = "";
									}
                                    $nameFunValRef="keyValidValRef(this.id);";
                                  } else {
                                    $totVal = nl2br($rowC['valor_ref']);
                                    $nameFunValRef="";
                                  }
                                  break;
                                  default:
                                  $nameFunValida="";
                                  $nameFunValRef="";
                                  $totVal = nl2br($rowC['valor_ref']);
                                  break;
                                }
                                ?>
                                <div class="form-group<?php echo ' '.$valColor ?>" style="margin-bottom: 1px;">
                                  <div class="input-group input-group-sm">
                                    <input type="text" class="form-control input-sm" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>" placeholder="" onfocus="this.select()" onkeypress="<?php echo $nameFunValida;?>" onblur="<?php echo $nameFunValRef;?>" value="<?php echo $valRes;?>"/>
                                    <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_idval" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_idval" value="<?php echo $idVal;?>"/>
                                    <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_inf" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_inf" value="<?php echo $valMin;?>"/>
                                    <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_sup" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_sup" value="<?php echo $valMax;?>"/>
									<input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_proori" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_proori" value="<?php echo $idProdAnte;?>"/>
                                    <div class="input-group-addon"><?php echo $rowC['uni_medida']?></div>
                                  </div>
                                </div>
                                <?php
                                echo '</td><td style="padding-top: 1px; padding-bottom: 1px;"><p class="help-block">'.$totVal.'</p></td></tr>';
                              } elseif ($rowC['tipo_ingresosol'] == "2") {
                                echo '<tr class="'.$trPColor.'"><td style="padding-top: 1px; padding-bottom: 1px;">'.$rowC['componente'].'</td><td style="padding-top: 1px; padding-bottom: 1px;" colspan="2">';
                                ?>
                                <div class="form-group" style="margin-bottom: 1px;">
                                  <textarea class="form-control" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>" rows="3"><?php echo $rowC['det_result'];?></textarea>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_idval" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_idval" value="<?php echo $idVal;?>"/>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_inf" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_inf" value="<?php echo $valMin;?>"/>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_sup" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_sup" value="<?php echo $valMax;?>"/>
								  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_proori" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_proori" value="<?php echo $idProdAnte;?>"/>
                                </div>
                                <?php
                              } else {
                                    $idVal = "";
                                    $valMin = "";
                                    $valMax = "";
                                    $desVal = "";
                                    $totVal = "";
								echo '<tr class="'.$trPColor.'"><td style="padding-top: 1px; padding-bottom: 1px;">'.$rowC['componente'].'</td><td style="padding-top: 1px; padding-bottom: 1px;">';
                                ?>
                                <div class="form-group" style="margin-bottom: 1px;">
								  <?php $rsSel = $c->get_listaSeleccionResultadoPorTipo($rowC['idseleccion_ingresul']); ?>
								  <select class="form-control input-sm" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>">
									<option value="" selected>-- Seleccione --</option>
									<?php
									foreach ($rsSel as $rowSel) {
									  echo "<option value='" . $rowSel['id'] . "'";
									  if ($rowSel['id'] == $rowC['idseleccion_resul']) echo " selected";
									  echo ">" . $rowSel['nombre'] . "</option>";
									}
									?>
								  </select>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_idval" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_idval" value="<?php echo $idVal;?>"/>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_inf" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_inf" value="<?php echo $valMin;?>"/>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_sup" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_sup" value="<?php echo $valMax;?>"/>
								  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_proori" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_proori" value="<?php echo $idProdAnte;?>"/>
                                </div>
                                <?php
								$totVal = nl2br($rowC['valor_ref']);
                                echo '</td><td style="padding-top: 1px; padding-bottom: 1px;"><p class="help-block">'.$totVal.'</p></td></tr>';
                              }
                            }

                            //Jose pie
                          }
                        }
                      }
                    }

                    ?>
                  </tfoot>
                </table>
              </div>
            </form>
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
          <button class="btn btn-primary btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="save_atencion('IR')"><i class="fa fa-save"></i>  Guardar resultado </button>
		  <button class="btn btn-success btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="save_atencion('VR')"><i class="fa fa-save"></i>  Guardar y validar resultado </button>
          <a href="./main_principallab.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
        </div>
      </div>
      <div id="impriAtencion" style="display: none;">
        <div class="btn-group">
		  <div id="editarAtencion" style="display: none;">
			<button class="btn btn-lg btn-success" id="btn-edit" onclick="open_edit()"><i class="glyphicon glyphicon-pencil"></i> Editar resultados</button>
		  </div>
          <button class="btn btn-lg btn-primary" id="btn-imrimirall" onclick="print_resul('0')"><i class="fa fa-file-pdf-o"></i> imprimir ficha de resultado</button>
          <a href="./main_principallab.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Salir</a>
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

function print_resul(idareaprod){
  var idAten = $('#txtIdAtencion').val();
  var nomPac = $('#txtNomPac').val();
  $('#mostrar_anexos_d').modal('show');
  $.ajax({
    url: '../../controller/ctrlAtencion.php',
    type: 'POST',
    data: 'accion=GET_SHOW_PDFATENCION&idAten=' + idAten +'&nomPac=' + nomPac +'&id_areaprod=' + idareaprod,
    success: function(data){
      $('#mostrar_anexos_d').html(data);
    }
  });
}

function open_pdf(idAten, opt, idAreaProd) {
  if(opt == "1"){
    var urlwindow = "pdf_laboratorio.php?id_atencion=" + idAten +"&id_area=" + idAreaProd;
  } else {
    var urlwindow = "pdf_laboratorioprod.php?id_atencion=" + idAten +"&id_prod=0";
  }
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function open_fua(id) {
  window.location = '../fua/genera_fuaxls.php?nroAtencion='+id;
}

function open_edit() {
  var id = $('#txtIdAtencion').val();
  window.location = './main_editresultadoprod.php?nroSoli='+id;
}

function load_focus_inicio(){
  var nameInput = '';
  var AnameInput = $('#frmArea').serializeArray();
  nameInput = AnameInput[0]['name'];
  $("#" + nameInput).trigger('focus');
}

function keyValidValRef(id) {
  var valIng = $('#' + id).val();
  if (valIng != ""){
    valIng = $('#' + id).val();
    var valInf = $('#' + id + "_inf").val();
    var valSup = $('#' + id + "_sup").val();
    valIng = Number(valIng);
    valInf = Number(valInf);
    valSup = Number(valSup);
    if(valIng < valInf){//Menor
      $('#' + id).closest(".form-group").removeClass("has-warning");
      $('#' + id).closest(".form-group").addClass("has-error");
    }
    if(valIng > valSup) {//Mayor
      $('#' + id).closest(".form-group").removeClass("has-error");
      $('#' + id).closest(".form-group").addClass("has-warning");
    }
    if(valIng >= valInf && valIng <= valSup){
      $('#' + id).closest(".form-group").removeClass("has-error");
      $('#' + id).closest(".form-group").removeClass("has-warning");
    }
  } else {
    $('#' + id).closest(".form-group").removeClass("has-error");
    $('#' + id).closest(".form-group").removeClass("has-warning");
  }
}


function save_atencion(opt) {
  $('#btn-submit').prop("disabled", true);
  var msg = "";
  var sw = true;

  var AnameInput = $('#frmArea').serializeArray();
  var ing = "";
  len = AnameInput.length;
  for (i=0; i<len; i++) {
    nameInput = AnameInput[i]['name'];
    var arrayCadenas = nameInput.split('_');
    if(arrayCadenas.length == 3){
      if($("#" + nameInput).val() != ""){
        ing = "1";
        break;
      }
    }
  }

  if(ing == ""){
    msg += "Ingrese la información de almenos un exámen<br/>";
    sw = false;
  }

  if (sw == false) {
    bootbox.alert(msg);
    $('#btn-submit').prop("disabled", false);
    return false;
  }

  bootbox.confirm({
    message: "Se registrarán los registros ingresados, ¿Está seguro de continuar?",
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

        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlAtencion.php',
          data: $('#frmArea').serialize()
          + "&txtIdAtencion=" + $('#txtIdAtencion').val() + "&txtNroRefAtencion=" + $('#txtNroRefAtencion').val() + "&txtOpt=ER" + "&opt_save=" + opt
          + "&accion=POST_ADD_REGRESULTADOLAB",
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){

              var AnameInput = $('#frmArea').serializeArray();
              var ing = "";
              len = AnameInput.length;
              for (i=0; i<len; i++) {
                nameInput = AnameInput[i]['name'];
                $("#" + nameInput).prop("disabled", true);
              }

              $("#saveAtencion").hide();
              $("#impriAtencion").show();
			  if(opt == 'VR'){
				  $("#editarAtencion").hide();
			  }
              bootbox.alert("El resultado se guardo correctamente.");
              return false;
            } else {
              $('#btn-submit').prop("disabled", false);
              bootbox.alert(msg);
              return false;
            }
          }
        });
      } else {
        $('#btn-submit').prop("disabled", false);
      }
    }
  });
}

$(document).ready(function() {
  $("#fixTable").tableHeadFixer();
  setTimeout(function(){load_focus_inicio();}, 2);
});

</script>
<?php require_once '../include/masterfooter.php'; ?>

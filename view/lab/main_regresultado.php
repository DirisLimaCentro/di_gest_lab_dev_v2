<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
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
        <input type="hidden" name="txtIngResul" id="txtIngResul" value="NO"/>
        <input type="hidden" name="txtShowOptPrint" id="txtShowOptPrint" value=""/>
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
                        echo "<td></td>";
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
                <h3 class="panel-title"><strong>Datos de la atención</strong></h3>
              </div>
              <div class="panel-body">
                <?php
                $frm = "";
                $rsA = $a->get_listaAreaPorIdAtencion($idAtencion, 0);
                foreach ($rsA as $rowA) {
                  ?>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span id="bgArea<?php echo $rowA['id_area']?>" class="info-box-icon bg-aqua sel-cursor" onclick="show_area('<?php echo $rowA['id_area']?>')">
                        <i class="fa fa-thermometer-half"></i>
                      </span>
                      <div class="info-box-content">
                        <span class="info-box-text"><?php echo $rowA['area']?></span>
                        <span class="info-box-number" id="lblArea<?php echo $rowA['id_area']?>">POR GENERAR</span>
                        <a href="#" class="text-success" style="display: none;" id="print<?php echo $rowA['id_area']?>" onclick="print_resul('<?php echo $rowA['id_area']?>')"><b><i class="fa fa-file-pdf-o"></i> Exportar</b></a>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>
                  <?php
                  $frm.= "#frmArea". $rowA['id_area'] . ",";
                }
                $frm = trim($frm, ',');
                ?>
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
              <button class="btn btn-primary btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="validForm()"><i class="fa fa-save"></i>  Guardar  </button>
              <a href="./main_principallab.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
            </div>
          </div>
          <div id="impriAtencion" style="display: none;">
            <div class="btn-group">
              <button class="btn btn-lg btn-success" id="btn-imrimirall" onclick="print_resul('0')"><i class="fa fa-file-pdf-o"></i> Visualizar formato generado</button>
              <a href="./main_principallab.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Salir</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
//$rsA = $a->get_listaArea();
foreach ($rsA as $rowA) {
  ?>
  <div class="modal fade" id="showArea<?php echo $rowA['id_area']?>" tabindex="-1" role="dialog" aria-labelledby="showArea<?php echo $rowA['id_area']?>Label">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showArea<?php echo $rowA['id_area']?>Label"><?php echo $rowA['area']?></h4>
        </div>
        <div class="modal-body-scroll" style="font-size:12px;">
          <form class="form-horizontal" name="frmArea<?php echo $rowA['id_area']?>" id="frmArea<?php echo $rowA['id_area']?>">
            <?php
            $rsP = $p->get_listaProductoPorIdAreaAndIdAtencion($idAtencion, $rowA['id_area']);
            $cantP = Count($rsP);
            foreach ($rsP as $rowP) {
              ?>
              <div class="panel panel-info">
                <div class="panel-heading" style="padding: 2px 15px;">
                  <h4 class="modal-title"><strong><?php echo $rowP['nom_producto']?></strong></h4>
                </div>
                <div class="panel-body" style="padding: 2px 15px;">
                  <?php
                  $rsG = $g->get_listaGrupoPorIdAreaAndIdAtencionAndIdProducto($idAtencion, $rowA['id_area'], $rowP['id_producto']);
                  $cantG = Count($rsG);
                  foreach ($rsG as $rowG) {
                    if($rowG['visible'] == "1"){
                      echo "<h3 class='modal-title'>".$rowG['grupo']."</h3>";
                    }
                    $rsC = $c->get_listaComponentePorIdGrupoAreaAndIdAtencionAndIdProducto($idAtencion, $rowG['id_grupoarea'], $rowP['id_producto']);
                    foreach ($rsC as $rowC) {
                      if ($rowC['tipo_ingresosol'] == "1"){
                        ?>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label-xs"><?php echo $rowC['componente']?></label>
                          <div class="col-sm-4">
                            <div class="input-group input-group-xs">
                              <?php
                              $idVal = "";
                              $valMin = "";
                              $valMax = "";
                              $desVal = "";
                              $totVal = "";
                              $rsVC = $c->get_datosValidaValReferencialComp($rowC['id_componente'], $edadAnio, $edadMes, $edadDia, $nomSexo);
                              switch($rowC['idtipocaracter_ingresul']){
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
                                  $nameFunValRef="keyValidValRef(this.id);";
                                } else {
                                  $totVal = nl2br($rowC['valor_ref']);
                                  $nameFunValRef="";
                                }
                                break;
                                case "4":
                                switch($rowC['detcaracter_ingresul']){
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
                                  $totVal = number_format($rsVC[0]['liminf'], $rowC['detcaracter_ingresul'], '.', '') . " - " . number_format($rsVC[0]['limsup'], $rowC['detcaracter_ingresul'], '.', '') . "<br/>" . $rsVC[0]['descripvalref'];
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
                              <input type="text" class="form-control input-xs" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>" placeholder="" onfocus="this.select()" onkeypress="<?php echo $nameFunValida;?>" onblur="<?php echo $nameFunValRef;?>"/>
                              <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_idval" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_idval" value="<?php echo $idVal;?>"/>
                              <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_inf" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_inf" value="<?php echo $valMin;?>"/>
                              <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_sup" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>_sup" value="<?php echo $valMax;?>"/>
                              <div class="input-group-addon"><?php echo $rowC['uni_medida']?></div>
                            </div>
                          </div>
                          <div class="col-sm-4"><p class="help-block"><?php echo $totVal?></p></div>
                        </div>
                        <?php
                      } else {
                        if ($cantG <> "1"){
                          ?>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label-xs"><?php echo $rowC['componente']?></label>
                            <div class="col-sm-4">
                              <textarea class="form-control" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id_componentedet']?>" rows="3"></textarea>
                            </div>
                            <div class="col-sm-4"><p class="help-block"><?php echo nl2br($rowC['valor_ref'])?></p></div>
                          </div>
                          <?php
                        } else {
                          ?>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label-xs"><?php echo $rowC['componente']?></label>
                            <div class="col-sm-8">
                              <textarea class="form-control" id="txt_<?php echo $rowC['id_componentedet']?>" name="txt_<?php echo $rowC['id_componentedet']?>" rows="15"></textarea>
                            </div>
                          </div>
                          <?php
                        }
                      }
                    }
                  }
                  ?>
                </div>
              </div>
              <?php
            }
            ?>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button class="btn btn-primary" id="btnAreaCon<?php echo $rowA['id_area']?>" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="save_area('<?php echo $rowA['id_area']?>')"><i class="fa fa-save"></i> Continuar </button>
                <button class="btn btn-default" id="btnAreaCan<?php echo $rowA['id_area']?>" onclick="cancel_area('<?php echo $rowA['id_area']?>')"><i class="fa fa-times"></i> Cancelar</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
  ?>
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

  $(function() {
    jQuery('#txtNroRefAtencion').keypress(function (tecla) {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
      return false;
    });

  });

  function keyValidLetter(id) {
    jQuery('#'+id).keypress(function (tecla) {
      if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
      return false;
    });
  }

  function keyValidNumber(id) {
    jQuery('#'+id).keypress(function (tecla) {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
      return false;
    });
  }

  function keyValidNumberDecimalOne(id) {
    //PARA LLAMARLO EN EL OBJETO ---> onkeypress="solo_JQdecimal(this.id)"
    $('#'+id).on('keypress', function (e) {
      // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
      var field = $(this);
      key = e.keyCode ? e.keyCode : e.which;

      if (key == 8) return true;
      if (key > 47 && key < 58) {
        if (field.val() === "") return true;
        var existePto = (/[.]/).test(field.val());
        if (existePto === false){
          regexp = /.[0-9]{5}$/; //PARTE ENTERA 10
        }
        else {
          regexp = /.[0-9]{1}$/; //PARTE DECIMAL2  {2}
        }
        return !(regexp.test(field.val()));
      }
      if (key == 46) {
        if (field.val() === "") return false;
        regexp = /^[0-9]+$/;
        return regexp.test(field.val());
      }
      return false;
    });
  }

  function keyValidNumberDecimalTwo(id) {
    //PARA LLAMARLO EN EL OBJETO ---> onkeypress="solo_JQdecimal(this.id)"
    $('#'+id).on('keypress', function (e) {
      // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
      var field = $(this);
      key = e.keyCode ? e.keyCode : e.which;

      if (key == 8) return true;
      if (key > 47 && key < 58) {
        if (field.val() === "") return true;
        var existePto = (/[.]/).test(field.val());
        if (existePto === false){
          regexp = /.[0-9]{5}$/; //PARTE ENTERA 10
        }
        else {
          regexp = /.[0-9]{2}$/; //PARTE DECIMAL2  {2}
        }
        return !(regexp.test(field.val()));
      }
      if (key == 46) {
        if (field.val() === "") return false;
        regexp = /^[0-9]+$/;
        return regexp.test(field.val());
      }
      return false;
    });
  }

  function keyValidNumberDecimalThree(id) {
    //PARA LLAMARLO EN EL OBJETO ---> onkeypress="solo_JQdecimal(this.id)"
    $('#'+id).on('keypress', function (e) {
      // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
      var field = $(this);
      key = e.keyCode ? e.keyCode : e.which;

      if (key == 8) return true;
      if (key > 47 && key < 58) {
        if (field.val() === "") return true;
        var existePto = (/[.]/).test(field.val());
        if (existePto === false){
          regexp = /.[0-9]{5}$/; //PARTE ENTERA 10
        }
        else {
          regexp = /.[0-9]{3}$/; //PARTE DECIMAL2  {2}
        }
        return !(regexp.test(field.val()));
      }
      if (key == 46) {
        if (field.val() === "") return false;
        regexp = /^[0-9]+$/;
        return regexp.test(field.val());
      }
      return false;
    });
  }

  function keyValidNumberDecimalFour(id) {
    //PARA LLAMARLO EN EL OBJETO ---> onkeypress="solo_JQdecimal(this.id)"
    $('#'+id).on('keypress', function (e) {
      // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
      var field = $(this);
      key = e.keyCode ? e.keyCode : e.which;

      if (key == 8) return true;
      if (key > 47 && key < 58) {
        if (field.val() === "") return true;
        var existePto = (/[.]/).test(field.val());
        if (existePto === false){
          regexp = /.[0-9]{10}$/; //PARTE ENTERA 10
        }
        else {
          regexp = /.[0-9]{4}$/; //PARTE DECIMAL2  {2}
        }
        return !(regexp.test(field.val()));
      }
      if (key == 46) {
        if (field.val() === "") return false;
        regexp = /^[0-9]+$/;
        return regexp.test(field.val());
      }
      return false;
    });
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
      console.log("Jose");
    } else {
      $('#' + id).closest(".form-group").removeClass("has-error");
      $('#' + id).closest(".form-group").removeClass("has-warning");
      console.log("oscar");
    }
  }

  function campoSiguiente(campo, evento) {
    if (evento.keyCode == 13 || evento.keyCode == 9) {
      if (campo == 'btn-pac-search') {
        buscar_datos_personales();
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    }
  }

  function show_area(area) {
    var ingResul = $("#txtIngResul" ).val();
    if(ingResul == "SI") return false;

    $('#showArea' + area).modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });

    $('#showArea' + area).on('shown.bs.modal', function (e) {
      var nameInput = '';
      var AnameInput = $('#frmArea' + area).serializeArray();
      nameInput = AnameInput[0]['name'];
      $("#" + nameInput).trigger('focus');

    })
  }

  function save_area(area) {
    var AnameInput = $('#frmArea' + area).serializeArray();
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
      bootbox.alert("Ingrese almenos un resultado<br/>");
      return false;
    }

    $("#lblArea" + area).text('GENERADO');
    $("#bgArea" + area).removeClass("bg-aqua").addClass("bg-yellow");
    $('#showArea'+ area).modal('hide');
    var txtShowOptPrint = $('#txtShowOptPrint').val();
    if(txtShowOptPrint==""){
      $('#txtShowOptPrint').val("#print" + area);
    } else {
      $('#txtShowOptPrint').val(txtShowOptPrint + ", #print" + area);
    }

  }

  function cancel_area(area) {
    var AnameInput = $('#frmArea' + area).serializeArray();
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
      $("#lblArea" + area).text('POR GENERAR');
      $("#bgArea" + area).removeClass("bg-yellow").addClass("bg-aqua");
      $('#showArea'+ area).modal('hide');
      return false;
    }

    bootbox.confirm({
      message: "Se borrará los registros ingresados, ¿Está seguro de continuar?",
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
          var AnameInput = $('#frmArea' + area).serializeArray();
          var ing = "";
          len = AnameInput.length;
          for (i=0; i<len; i++) {
            nameInput = AnameInput[i]['name'];
            var arrayCadenas = nameInput.split('_');
            if(arrayCadenas.length == 3){
              $("#" + nameInput).val('');
              $('#' + nameInput).closest(".form-group").removeClass("has-error");
              $('#' + nameInput).closest(".form-group").removeClass("has-warning");
            }
          }

          $("#lblArea" + area).text('POR GENERAR');
          $("#bgArea" + area).removeClass("bg-yellow").addClass("bg-aqua");
          $('#showArea'+ area).modal('hide');
        }
      }
    });
  }

  function validForm() {
    $('#btn-submit').prop("disabled", true);
    var msg = "";
    var sw = true;

    var txtNroRefAtencion = $('#txtNroRefAtencion').val();

    if (txtNroRefAtencion == "") {
      msg += "Ingrese el Nro. de Atención<br/>";
    }

    var generado = $('#txtShowOptPrint').val();
    if(generado == ""){
      msg += "Generar la información de almenos una Área<br/>";
      sw = false;
    }

    if (sw == false) {
      bootbox.alert(msg);
      $('#btn-submit').prop("disabled", false);
      return sw;
    } else {
      save_atencion();
    }
    return false;
  }

  function open_fua(id) {
    window.location = '../fua/genera_fuaxls.php?nroAtencion='+id;
  }

  function save_atencion() {
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

          var selectednumbers = [];
          $('.js-example-basic-multiple :selected').each(function(i, selected) {
            selectednumbers[i] = $(selected).val();
          });

          $.ajax( {
            type: 'POST',
            url: '../../controller/ctrlAtencion.php',
            data: $("<?php echo $frm ?>").serialize()
            + "&txtIdAtencion=" + $('#txtIdAtencion').val() + "&txtNroRefAtencion=" + $('#txtNroRefAtencion').val()
            + "&accion=POST_ADD_REGRESULTADOLAB",
            success: function(data) {
              var tmsg = data.substring(0, 2);
              var lmsg = data.length;
              var msg = data.substring(3, lmsg);
              //console.log(tmsg);
              if(tmsg == "OK"){
                $($('#txtShowOptPrint').val()).show();
                $("#saveAtencion").hide();
                $("#impriAtencion").show();
                $('#txtIdAtencion').val(msg);
                $('.sel-cursor').attr('style','cursor: text;');
                $('#txtIngResul').val('SI');
                bootbox.alert("El registro se guardo correctamente.");
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
    setTimeout(function(){$('#txtNroRefAtencion').trigger('focus');}, 2);
  });

  </script>
  <?php require_once '../include/masterfooter.php'; ?>

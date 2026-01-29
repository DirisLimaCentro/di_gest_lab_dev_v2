<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Pap.php';
$pap = new Pap();

$idSolicitud = $_GET['nroSoli'];
$rsSPAP = $pap->get_datosSolicitud($idSolicitud);
$rsRPAP = $pap->get_datosResultado($idSolicitud);
$rsSPAPRCC = $pap->get_datosCambioCelPorIdRespuesta($rsRPAP[0]['id_papresul']);
/*print_r($rsRPAP);
print_r($rsSPAPRCC);*/
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title text-center"><strong>EDICION DE RESULTADO DE PAP NRO. <?php echo $rsSPAP[0]['nro_reglab'] . "-" . $rsSPAP[0]['anio_reglab'];?></strong></h3>
    </div>
    <form name="frmResultado" id="frmResultado">
      <input type="hidden" name="txtIdSolicitud" id="txtIdSolicitud" value="<?php echo $_GET['nroSoli']?>"/>
      <input type="hidden" name="txtIdResultado" id="txtIdResultado" value="<?php echo $rsRPAP[0]['id_papresul']?>"/>
      <div class="panel-body">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Datos de la referencia</strong></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-2">
                  <label for="txtRegLabComple">N° Registro Laboratorio</label>
                  <input type="text" name="txtRegLabComple" id="txtRegLabComple" placeholder="" value="<?php echo $rsSPAP[0]['nro_reglab'] . "-" . $rsSPAP[0]['anio_reglab'];?>" class="form-control" disabled/>
                </div>
                <div class="col-sm-2">
                  <label for="txtHCPac">Historia Clínica</label>
                  <input type="text" name="txtHCPac" id="txtHCPac" class="form-control" value="<?php echo $rsSPAP[0]['nro_hc'];?>" disabled/>
                </div>
                <div class="col-sm-7">
                  <label for="txtNomPac">Paciente</label>
                  <input type="text" name="txtNomPac" id="txtNomPac" class="form-control" value="<?php echo $rsSPAP[0]['nombre_rs'];?>" disabled/>
                </div>
                <div class="col-sm-1">
                  <label>Ver Ficha</label><br/>
                  <button type="button" class="btn btn-success btn-block" onclick="open_pdfresulsinvalor('<?php echo $_GET['nroSoli']?>');"><i class="glyphicon glyphicon-eye-open"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>1. Calidad de muestra</strong></h3>
          </div>
          <div class="panel-body">
            <div class="row">
          <div class="col-sm-5">
            <div class="form-group">
              <fieldset class="scheduler-border">
                <legend class="scheduler-border" style="margin-bottom: 5px;">SATISFACTORIA</legend>
                <label class="radio-inline">
                  <input type="radio" name="txtSatisfactoria" id="txtSatisfactoria1" class="opt_satisfactoria" value="1"> Con
                </label>
                <label class="radio-inline">
                  <input type="radio" name="txtSatisfactoria" id="txtSatisfactoria2" class="opt_satisfactoria" value="2"> Sin
                </label>
                <label class="no-radio radio-inline">
                  (Células Endocervicales)
                </label>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="txtNegaLesion" id="txtNegaLesion" class="check_negaLesion" value="1"/>
                          NEGATIVO PARA LESIÓN INTRAEPITELIAL Y/O MALIGNIDAD
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
          <div class="col-sm-6">
        <div class="form-group">
          <fieldset class="scheduler-border">
            <legend class="scheduler-border" style="margin-bottom: 5px;">INSATISFACTORIA</legend>
            <label class="radio-inline">
              <input type="radio" name="txtInsatisfactoria" id="txtInsatisfactoria1" class="opt_insatisfactoria" value="1"> Escasas Célular
            </label>
            <label class="radio-inline">
              <input type="radio" name="txtInsatisfactoria" id="txtInsatisfactoria2" class="opt_insatisfactoria" value="2"> > 75% Leucocitos PMN
            </label>
            <label class="radio-inline">
              <input type="radio" name="txtInsatisfactoria" id="txtInsatisfactoria3" class="opt_insatisfactoria" value="3"> > 75% Hematíes
            </label>
            <label class="radio-inline">
              <input type="radio" name="txtInsatisfactoria" id="txtInsatisfactoria4" class="opt_insatisfactoria" value="4"> > Mala fijación
            </label>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  <div class="checkbox">
                    <label></label>
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
          <div class="col-sm-1 text-center">
            <label>Recargar</label><br/>
            <button type="button" class="btn btn-success btn-block" onclick="reload();"><i class="glyphicon glyphicon-refresh"></i></button>
          </div>
          </div>
        </div>
        <div class="row" id="positivo">
          <div class="col-sm-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>2. Anormalidad de células epiteliales escamosas</strong></h3>
              </div>
              <div class="panel-body" style="padding-top: 5px !important; padding-bottom: 5px !important;">
                <div class="form-group">
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa1" class="opt_anorescamosa" value="1"/>
                      ASCUS
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa2" class="opt_anorescamosa" value="2"/>
                      L.I.E. de bajo grado
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa3" class="opt_anorescamosa" value="3"/>
                      ASCH
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa4" class="opt_anorescamosa" value="4"/>
                      L.I.E. de alto grado
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa5" class="opt_anorescamosa" value="5"/>
                      CARCINOMA IN SITU
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa6" class="opt_anorescamosa" value="6"/>
                      CARCINOMA INVASOR
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>3. Anormalidad de células epiteliales Glandulares</strong></h3>
              </div>
              <div class="panel-body" style="padding-top: 5px !important; padding-bottom: 5px !important;">
                <div class="form-group">
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular1" class="opt_anorglandular" value="1"/>
                      Celulas glandulares atipicas
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular2" class="opt_anorglandular" value="2"/>
                      Celulas glandulares atipicas sugestivas de neoplasia
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular3" class="opt_anorglandular" value="3"/>
                      Adenocarcinoma in situ
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular4" class="opt_anorglandular" value="4"/>
                      Adenocarcinoma
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>4. Cambio celulares benignos</strong></h3>
          </div>
          <div class="panel-body" style="padding-top: 5px !important; padding-bottom: 5px !important;">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-4">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel1" class="check_cambiocel" value="1"/>
                      METAPLASIA ESCAMOSA
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel2" class="check_cambiocel" value="2"/>
                      ATROFIA
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel3" class="check_cambiocel" value="3"/>
                      CAMBIO POR DIU
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel4" class="check_cambiocel" value="4"/>
                      TRICHOMONAS VAGINALES
                    </label>
                  </div>
                </div>
                <div class="col-sm-8">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel5" class="check_cambiocel" value="5"/>
                      CÁNDIDA
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel6" class="check_cambiocel" value="6"/>
                      VAGINOSIS
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel7" class="check_cambiocel" value="7"/>
                      HERPES
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel8" class="check_cambiocel" value="8"/>
                      INFLAMACIÓN PMN :
                    </label>
                    (
                    <label class="radio-inline">
                      <input type="radio" name="txtIdDetCambioCel" id="txtIdDetCambioCel1" class="opt_iddetcambiocel" value="1"> L
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="txtIdDetCambioCel" id="txtIdDetCambioCel2" class="opt_iddetcambiocel" value="2"> M
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="txtIdDetCambioCel" id="txtIdDetCambioCel3" class="opt_iddetcambiocel" value="3"> S
                    </label>
                    )
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>5. Datos de resultado</strong></h3>
          </div>
          <div class="panel-body" style="padding-top: 5px !important; padding-bottom: 5px !important;">
            <input type="hidden" name="txtFecResul" id="txtFecResul" value="<?php echo date("d/m/Y");?>" maxlength="10"/>
            <input type="hidden" name="txtNroRegLab" id="txtNroRegLab" value="<?php echo $rsSPAP[0]['nro_reglab'];?>" maxlength="9"/>
            <div class="form-group">
              <label for="txtObsResul"><b>Observaciones para el paciente</b></label>
              <textarea name="txtObsResul" id="txtObsResul" class="form-control" rows="3"><?php echo $rsRPAP[0]['obs_resul'];?></textarea>
            </div>
						  <?php
			  if($labIdRolUser == "1" Or $labIdRolUser == "10"){
			  ?>
            <div class="form-group">
              <label for="txtObsResul"><b>Observaciones internas</b></label>
              <textarea name="txtObsResulInt" id="txtObsResulInt" class="form-control" rows="3"></textarea>
            </div>
						  <?php
			  } else {
			  ?>
				<input type="hidden" name="txtObsResulInt" id="txtObsResulInt" value=""/>
						  <?php
			  }
			  ?>
            <div class="bs-example bs-example-bg-classes" data-example-id="contextual-backgrounds-helpers">
              <p class="bg-warning">Tenga presente que la observación tiene que ser modificado manualmente, se está omitiendo las observaciones por defecto.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div id="saveResultado">
              <div class="btn-group">
			  <?php
			  if($labIdRolUser == "1" Or $labIdRolUser == "10"){
			  ?>
                <button type="button" class="btn btn-success btn-lg" id="btnValidForm" onclick="validForm('ERV')"><i class="fa fa-save"></i> Guardar y validar resultado </button>
			  <?php
			  } else {
			  ?>
                <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="validForm('ER')"><i class="fa fa-save"></i> Guardar resultado </button>
			  <?php
			  }
			  ?>
                <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="fa fa-times"></i> Cancelar</button>
              </div>
            </div>
            <div id="saveExportar" style="display: none;">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="edit_resultado()"><i class="fa fa-save"></i> Editar resultado </button>
                <button type="button" class="btn btn-lg btn-success" id="btn-imrimirall" onclick="open_pdfresulsinvalor('<?php echo $_GET['nroSoli']?>');"><i class="fa fa-file-pdf-o"></i> Imprimir resultado</button>
                <a href="./main_principalresul.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Salir</a>
              </div>
            </div>
            <div id="saveValidado" style="display: none;">
              <div class="btn-group">
                <button type="button" class="btn btn-lg btn-success" id="btn-imrimirall" onclick="open_pdfresulsinvalor('<?php echo $_GET['nroSoli']?>');"><i class="fa fa-file-pdf-o"></i> Imprimir resultado</button>
                <a href="./main_principalresul.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Salir</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">
function reload() {
  location.reload();
}

function back() {
  window.location = './main_principalresul.php';
}

function campoSiguiente(campo, evento) {
  if (evento.keyCode == 13 || evento.keyCode == 9) {
    if (campo == 'btn-pac-search') {
      buscar_datos_personales();
    } else if (campo == 'btn-submit') {
      hide_paciente();
    } else {
      document.getElementById(campo).focus();
      evento.preventDefault();
    }
  }
}

$(function() {

  jQuery('#txtNroRegLab').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
    return false;
  });

  $('[name="txtSatisfactoria"]').change(function()
  {
    if ($(this).is(':checked')) {
      $(".opt_insatisfactoria").prop('disabled', true);
      $(".opt_insatisfactoria").prop('checked', false);
      $(".opt_anorescamosa").prop('checked', false);
      $(".opt_anorescamosa").prop('disabled', false);
      $(".opt_anorglandular").prop('checked', false);
      $(".opt_anorglandular").prop('disabled', false);
      $(".check_cambiocel").prop('disabled', false);
      $("#txtNegaLesion").prop('checked', false);
      $("#txtNegaLesion").prop('disabled', false);
    };
  });

  $('[name="txtInsatisfactoria"]').change(function()
  {
    if ($(this).is(':checked')) {
      $(".opt_satisfactoria").prop('disabled', true);
      $(".opt_satisfactoria").prop('checked', false);
      //$("#txtObsResul").val('Control de PAP a los 2 meses.');
      //Nuevo
      $(".opt_anorescamosa").prop('checked', false);
      $(".opt_anorescamosa").prop('disabled', true);
      $(".opt_anorglandular").prop('checked', false);
      $(".opt_anorglandular").prop('disabled', true);
      $(".check_cambiocel").prop('checked', false);
      $(".check_cambiocel").prop('disabled', true);
      $(".opt_iddetcambiocel").prop('checked', false);
      $(".opt_iddetcambiocel").prop('disabled', true);
      $("#txtNegaLesion").prop('checked', false);
      $("#txtNegaLesion").prop('disabled', true);
    };
  });

  $('[name="txtNegaLesion"]').change(function()
  {
    //$('#txtObsResul').val('');
    if ($(this).is(':checked')) {
      $(".opt_anorescamosa").prop('checked', false);
      $(".opt_anorescamosa").prop('disabled', true);
      $(".opt_anorglandular").prop('checked', false);
      $(".opt_anorglandular").prop('disabled', true);
      //Nuevo
      $(".opt_insatisfactoria").prop('disabled', true);
      $("#positivo").hide();
    } else {
      $(".opt_anorescamosa").prop('checked', false);
      $(".opt_anorescamosa").prop('disabled', false);
      $(".opt_anorglandular").prop('checked', false);
      $(".opt_anorglandular").prop('disabled', false);
      $(".opt_insatisfactoria").prop('disabled', true);
      $("#positivo").show();
    };
  });

  $('[name="txtAnorEscamosa"]').change(function()
  {
    if ($(this).is(':checked')) {
      $(".opt_anorglandular").prop('checked', false);
      $(".opt_anorglandular").prop('disabled', true);
      /*if($(this).val() == "1"){
        $("#txtObsResul").val('Control de PAP a los 6 y 12 meses.');
      }
      if($(this).val() == "2"){
        $("#txtObsResul").val('Control de PAP a los 6 meses.');
      }
      if(($(this).val() == "3") || ($(this).val() == "4") || ($(this).val() == "5")){
        $("#txtObsResul").val('Referencia a Ginecología');
      }*/
    };
  });

  $('[name="txtAnorGlandular"]').change(function()
  {
    if ($(this).is(':checked')) {
      $(".opt_anorescamosa").prop('checked', false);
      $(".opt_anorescamosa").prop('disabled', true);
      /*if($(this).val() == "1"){
        $("#txtObsResul").val('Control de PAP a los 6 meses.');
      }
      if(($(this).val() == "2") || ($(this).val() == "3") || ($(this).val() == "4")){
        $("#txtObsResul").val('Referencia a Ginecología');
      }*/
    };
  });

  $('[name="txtCambioCel"]').change(function()
  {
    if ($(this).is(':checked')) {
      if($(this).val() == "8"){
        $(".opt_iddetcambiocel").prop('disabled', false);
      } else {
        if ($("#txtCambioCel8").is(':checked')) {
          $(".opt_iddetcambiocel").prop('disabled', false);
        } else {
          $(".opt_iddetcambiocel").prop('disabled', true);
          $(".opt_iddetcambiocel").prop('checked', false);
        }
      }
    } else {
      if ($("#txtCambioCel8").is(':checked')) {
        $(".opt_iddetcambiocel").prop('disabled', false);
      } else {
        $(".opt_iddetcambiocel").prop('disabled', true);
        $(".opt_iddetcambiocel").prop('checked', false);
      }
    }
  });

});

function open_pdfsinvalor(idSoli) {

  var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function open_pdfresulsinvalor(idSoli) {

  var urlwindow = "pdf_resulsinvalor.php?id_solicitud=" + idSoli;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function edit_resultado() {
  window.location = './main_editresultado.php?nroSoli='+document.frmResultado.txtIdSolicitud.value;
}

function validForm(opt) {
  $('#btnValidForm').prop("disabled", true);
  var msg = "";
  var sw = true;

  if ($('input.opt_satisfactoria').is(':checked')) {
    if ($('input.check_negaLesion').is(':checked')) {
    } else {
      if ($('input.opt_anorescamosa').is(':checked')) {
      } else {
        if ($('input.opt_anorglandular').is(':checked')) {
        } else {
          msg+= "Seleccione una anormalidad (ESCAMOSAS ó GLANDURALES)<br/>";
          sw = false;
        }
      }
    }
  } else {
    if ($('input.opt_insatisfactoria').is(':checked')) {
    } else {
      msg+= "Seleccione un tipo de calidad de muestra (SATISFACTORIA ó INSATISFACTORIA)<br/>";
      sw = false;
    }
  }

  var fecresul = $('#txtFecResul').val();
  var nroreg = $('#txtNroRegLab').val();
  if(fecresul == ""){
    msg+= "Ingrese fecha del entrega de resultados<br/>";
    sw = false;
  }
  if(nroreg == ""){
    msg+= "Ingrese número de registro del resultados<br/>";
    sw = false;
  }

  if (sw == false) {
    bootbox.alert(msg);
    $('#btnValidForm').prop("disabled", false);
    return sw;
  } else {
    save_resultado(opt);
  }
  return false;
}

function save_resultado(opt) {
  bootbox.confirm({
    message: "Se registrará el resultado ingresado. <br/> ¿Está seguro de continuar?",
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
        if ($('input.check_negaLesion').is(':checked')) {
          var negaLesion = '1';
        } else {
          var negaLesion = '0';
        }
        if ($('input.check_cambiocel').is(':checked')) {
          var cambiocel = [];
          $.each($('.check_cambiocel:checked'), function() {
            cambiocel.push($(this).val());
          });
        } else {
          var cambiocel = '';
        }

        var myRand = parseInt(Math.random() * 999999999999999);
        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlPAP.php',
          data: {
            accion: 'POST_ADD_REGRESULTADO', txtOpt: opt, txtIdSolicitud: document.frmResultado.txtIdSolicitud.value, txtIdResultado: document.frmResultado.txtIdResultado.value,
            txtSatisfactoria: document.frmResultado.txtSatisfactoria.value, txtInsatisfactoria: document.frmResultado.txtInsatisfactoria.value, txtNegaLesion: negaLesion, txtAnorEscamosa: document.frmResultado.txtAnorEscamosa.value, txtAnorGlandular: document.frmResultado.txtAnorGlandular.value, txtCambioCel: cambiocel,
            txtIdDetCambioCel: document.frmResultado.txtIdDetCambioCel.value, txtFecResul: document.frmResultado.txtFecResul.value, txtNroRegLab: document.frmResultado.txtNroRegLab.value, txtObsResul: document.frmResultado.txtObsResul.value, txtObsResulInt: document.frmResultado.txtObsResulInt.value,
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            if(tmsg == "OK"){
              $("#saveResultado").hide();
			  if(opt == "ER"){
				$("#saveExportar").show();
			  } else {
				$("#saveValidado").show();
			  }
              bootbox.alert("El registro se guardo correctamente.");
              return false;
            } else {
              bootbox.alert(msg);
              $('#btnValidForm').prop("disabled", false);
              return false;
            }
          }
        });
      } else {
        $('#btnValidForm').prop("disabled", false);
      }
    }
  });
}

$(document).ready(function() {

  //$('#txtObsResul').val('');
  $('#txtFecResul').inputmask();

  $("#txtFecResul").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });

  <?php
  if ($rsRPAP[0]['id_tipinsatisfactoria'] <> "") {
    ?>
    $("#txtInsatisfactoria" + "<?php echo $rsRPAP[0]['id_tipinsatisfactoria']?>").prop('checked', true);
    <?php
  }else{
    ?>
    $("#txtSatisfactoria" + "<?php echo $rsRPAP[0]['id_tipsatisfactoria']?>").prop('checked', true);
    <?php
    if ($rsRPAP[0]['negalesion'] <> "0") {
      ?>
      $("#txtNegaLesion").prop('checked', true);
      $(".opt_anorescamosa").prop('disabled', true);
      $(".opt_anorglandular").prop('disabled', true);
      $("#positivo").hide();
      <?php
    } else {
      ?>
      $("#txtAnorEscamosa" + "<?php echo $rsRPAP[0]['id_anorescamosa']?>").prop('checked', true);
      $("#txtAnorGlandular" + "<?php echo $rsRPAP[0]['id_anorglandular']?>").prop('checked', true);
      $("#positivo").show();
      <?php
    }
    if (count($rsSPAPRCC) <> "0"){
      foreach ($rsSPAPRCC as $rowCC) {
        ?>
        $("#txtCambioCel" + "<?php echo $rowCC['id_tipcambiocel']?>").prop('checked', true);
        <?php
        if ($rowCC['id_tipcambiocel'] == "8"){
          ?>
            $("#txtIdDetCambioCel" + "<?php echo $rowCC['det_tipcambiocel']?>").prop('checked', true);
            <?php
        }
      }
    }
  }
  if($rsSPAP[0]['id_estadoresul'] <> "2"){
    ?>
    bootbox.alert({
      message: "La muestra ya fue validada",
      callback: function () {
        window.location = './main_principalresul.php';
      }
    });

    <?php
  }
  ?>

});

</script>
<?php require_once '../include/masterfooter.php'; ?>

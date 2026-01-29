<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Pap.php';
$pap = new Pap();

$idSolicitud = $_GET['nroSoli'];
$rsSPAP = $pap->get_datosSolicitud($idSolicitud);
$rsEnvPAP = $pap->get_datoEstadoEnvioDetPorIdSoli($idSolicitud);
//print_r($rsEnvPAP);
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title text-center"><strong>REGISTRO DE RESULTADO DE PAP NRO. <?php echo $rsSPAP[0]['nro_reglab'] . "-" . $rsSPAP[0]['anio_reglab'];?></strong></h3>
    </div>
    <form name="frmResultado" id="frmResultado">
      <input type="hidden" name="txtIdSolicitud" id="txtIdSolicitud" value="<?php echo $_GET['nroSoli']?>"/>
      <input type="hidden" name="txtIdSolicitudNext" id="txtIdSolicitudNext" value=""/>
      <input type="hidden" name="txtIdResultado" id="txtIdResultado" value="0"/>
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
                  <button type="button" class="btn btn-info btn-block" onclick="open_pdfsinvalor('<?php echo $_GET['nroSoli']?>');"><i class="glyphicon glyphicon-eye-open"></i></button>
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
              <div class="col-sm-6">
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
                              <input type="checkbox" name="txtNegaLesion" id="txtNegaLesion" class="check_negaLesion" value="1" disabled>
                              NEGATIVO PARA LESIÓN INTRAEPITELIAL Y/O MALIGNIDAD
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="col-sm-5">
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
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa1" class="opt_anorescamosa" value="1" disabled/>
                      ASCUS
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa2" class="opt_anorescamosa" value="2" disabled/>
                      L.I.E. de bajo grado
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa3" class="opt_anorescamosa" value="3" disabled/>
                      ASCH
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa4" class="opt_anorescamosa" value="4" disabled/>
                      L.I.E. de alto grado
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa5" class="opt_anorescamosa" value="5" disabled/>
                      CARCINOMA IN SITU
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa6" class="opt_anorescamosa" value="6" disabled/>
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
                      <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular1" class="opt_anorglandular" value="1" disabled/>
                      Celulas glandulares atipicas
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular2" class="opt_anorglandular" value="2" disabled/>
                      Celulas glandulares atipicas sugestivas de neoplasia
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular3" class="opt_anorglandular" value="3" disabled/>
                      Adenocarcinoma in situ
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular4" class="opt_anorglandular" value="4" disabled/>
                      Adenocarcinoma
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-info" id="cambio">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>4. Cambio celulares benignos</strong></h3>
          </div>
          <div class="panel-body" style="padding-top: 5px !important; padding-bottom: 5px !important;">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-4">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel1" class="check_cambiocel" value="1" disabled/>
                      METAPLASIA ESCAMOSA
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel2" class="check_cambiocel" value="2" disabled/>
                      ATROFIA
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel3" class="check_cambiocel" value="3" disabled/>
                      CAMBIO POR DIU
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel4" class="check_cambiocel" value="4" disabled/>
                      TRICHOMONAS VAGINALES
                    </label>
                  </div>
                </div>
                <div class="col-sm-8">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel5" class="check_cambiocel" value="5" disabled/>
                      CÁNDIDA
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel6" class="check_cambiocel" value="6" disabled/>
                      VAGINOSIS
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel7" class="check_cambiocel" value="7" disabled/>
                      HERPES
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txtCambioCel" id="txtCambioCel8" class="check_cambiocel" value="8" disabled/>
                      INFLAMACIÓN PMN :
                    </label>
                    (
                    <label class="radio-inline">
                      <input type="radio" name="txtIdDetCambioCel" id="txtIdDetCambioCel1" class="opt_iddetcambiocel" value="1" disabled> L
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="txtIdDetCambioCel" id="txtIdDetCambioCel2" class="opt_iddetcambiocel" value="2" disabled> M
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="txtIdDetCambioCel" id="txtIdDetCambioCel3" class="opt_iddetcambiocel" value="3" disabled> S
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
            <h3 class="panel-title"><strong>5. Observaciones para el paciente</strong></h3>
          </div>
          <div class="panel-body" style="padding-top: 5px !important; padding-bottom: 5px !important;">
            <input type="hidden" name="txtFecResul" id="txtFecResul" value="<?php echo date("d/m/Y");?>" maxlength="10"/>
            <input type="hidden" name="txtNroRegLab" id="txtNroRegLab" value="<?php echo $rsSPAP[0]['nro_reglab'];?>" maxlength="9"/>
            <div class="form-group">
              <textarea name="txtObsResul" id="txtObsResul" class="form-control" rows="3"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div id="saveResultado">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Guardar resultado </button>
                <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="fa fa-times"></i> Cancelar</button>
              </div>
            </div>
            <div id="saveExportar" style="display: none;">
              <div class="btn-group">
                <button type="button" class="btn btn-lg btn-success" id="btn-imrimirall" onclick="open_pdfresulsinvalor('<?php echo $_GET['nroSoli']?>');"><i class="fa fa-file-pdf-o"></i> Imprimir resultado</button>
                <button type="button" class="btn btn-primary btn-lg" id="btnNextNro" onclick="reg_resultado()"> Siguiente Lámina: <span id="lblNextNro"></span> >></button>
                <a href="./main_principalresul.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Salir</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
	<div class="modal fade in" id="modal-save-atencion">
		<div class="modal-dialog modal-warning">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
					<h4 class="modal-title"><i class='fa fa-exclamation-circle' style='font-size: 20px;'></i> Aviso</h4>
				</div>
			<div class="modal-body">
				<span>Número de registro: <b><?php echo $rsSPAP[0]['nro_reglab'] . "-" . $rsSPAP[0]['anio_reglab'];?></b>, está rechazada...</span>
			</div>
			<div class="modal-footer">
				<input type="hidden" id="opt_accion_save" value=""/>
				<button type="button" class="btn btn-danger" id="btn-save-atencion-si" onclick="reg_resultado()">Siguiente número >></button>
			</div>
			</div>
		</div>
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

  $('[name="txtSatisfactoria"]').change(function(){
    if ($(this).is(':checked')) {
      $(".opt_insatisfactoria").prop('disabled', true);
      $(".opt_anorescamosa").prop('checked', false);
      $(".opt_anorescamosa").prop('disabled', false);
      $(".opt_anorglandular").prop('checked', false);
      $(".opt_anorglandular").prop('disabled', false);
      $(".check_cambiocel").prop('disabled', false);
      $("#txtNegaLesion").prop('checked', false);
      $("#txtNegaLesion").prop('disabled', false);
    };
  });

  $('[name="txtInsatisfactoria"]').change(function(){
    if ($(this).is(':checked')) {
		$(".opt_satisfactoria").prop('disabled', true);
		$("#txtObsResul").val('Control de PAP a los 2 meses.');
		$("#positivo").hide();
		$("#cambio").hide();
    };
  });

  $('[name="txtNegaLesion"]').change(function()
  {
    $('#txtObsResul').val('');
    if ($(this).is(':checked')) {
      $(".opt_anorescamosa").prop('checked', false);
      $(".opt_anorescamosa").prop('disabled', true);
      $(".opt_anorglandular").prop('checked', false);
      $(".opt_anorglandular").prop('disabled', true);
      $("#positivo").hide();
    } else {
      $(".opt_anorescamosa").prop('checked', false);
      $(".opt_anorescamosa").prop('disabled', false);
      $(".opt_anorglandular").prop('checked', false);
      $(".opt_anorglandular").prop('disabled', false);
      $("#positivo").show();
    };
  });

  $('[name="txtAnorEscamosa"]').change(function()
  {
    if ($(this).is(':checked')) {
      $(".opt_anorglandular").prop('disabled', true);
      if($(this).val() == "1"){
        $("#txtObsResul").val('Control de PAP a los 6 y 12 meses.');
      }
      if($(this).val() == "2"){
        $("#txtObsResul").val('Control de PAP a los 6 meses.');
      }
      if(($(this).val() == "3") || ($(this).val() == "4") || ($(this).val() == "5")){
        $("#txtObsResul").val('Referencia a Ginecología');
      }
    };
  });

  $('[name="txtAnorGlandular"]').change(function()
  {
    if ($(this).is(':checked')) {
      $(".opt_anorescamosa").prop('disabled', true);
      if($(this).val() == "1"){
        $("#txtObsResul").val('Control de PAP a los 6 meses.');
      }
      if(($(this).val() == "2") || ($(this).val() == "3") || ($(this).val() == "4")){
        $("#txtObsResul").val('Referencia a Ginecología');
      }
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


function validForm() {
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
    save_resultado();
  }
  return false;
}

function save_resultado() {
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
            accion: 'POST_ADD_REGRESULTADO', txtIdSolicitud: document.frmResultado.txtIdSolicitud.value, txtIdResultado: document.frmResultado.txtIdResultado.value,
            txtSatisfactoria: document.frmResultado.txtSatisfactoria.value, txtInsatisfactoria: document.frmResultado.txtInsatisfactoria.value, txtNegaLesion: negaLesion, txtAnorEscamosa: document.frmResultado.txtAnorEscamosa.value, txtAnorGlandular: document.frmResultado.txtAnorGlandular.value, txtCambioCel: cambiocel,
            txtIdDetCambioCel: document.frmResultado.txtIdDetCambioCel.value, txtFecResul: document.frmResultado.txtFecResul.value, txtNroRegLab: document.frmResultado.txtNroRegLab.value, txtObsResul: document.frmResultado.txtObsResul.value,
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            if(tmsg == "OK"){
              $("#saveResultado").hide();
              $("#saveExportar").show();
              //bootbox.alert("El registro se guardo correctamente.");
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

function next_nrolamina(){
  nroRegLab = "<?php echo (int)$rsSPAP[0]['nro_reglab'] + 1?>";
  anioRegLab = "<?php echo (int)$rsSPAP[0]['anio_reglab']?>";

  $.ajax({
    url: "../../controller/ctrlPAP.php",
    type: "POST",
    dataType: 'json',
    data: {
      accion: 'GET_SHOW_EXISTENROLABSINRESULTADO', nroRegLab: nroRegLab, anioRegLab: anioRegLab
    },
    beforeSend: function (objeto) {
    },
    success: function (registro) {
      var datos = eval(registro);
      if(datos[0] != ""){
        $("#lblNextNro").text(datos[1] + "-" + datos[2]);
        $('#btnNextNro').prop("disabled", false);
        $("#txtIdSolicitudNext").val(datos[0]);
      } else {
        $('#btnNextNro').prop("disabled", true);
      }
    }
  });
}

function reg_resultado() {
  window.location = './main_regresultado.php?nroSoli=' + $("#txtIdSolicitudNext").val();
}

$(document).ready(function() {

  $('#txtObsResul').val('');
  $('#txtFecResul').inputmask();

  $("#txtFecResul").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });

  $("#txtSatisfactoria1").focus();
  <?php
  if($rsSPAP[0]['id_estadoresul'] <> "1"){
    ?>
    bootbox.alert({
      message: "La muestra ya fue procesada",
      callback: function () {
        window.location = './main_principalresul.php';
      }
    });

    <?php
  }
  if($rsEnvPAP[0]['id_estado_detenv'] == "4"){
  ?>
  
  	$('#modal-save-atencion').modal({
		show: true,
		backdrop: 'static',
		focus: true,
	});
    <?php
  }
  ?>
  next_nrolamina();
});

</script>
<?php require_once '../include/masterfooter.php'; ?>

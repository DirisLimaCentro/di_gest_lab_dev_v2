<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Bacteriologia.php';
$ba = new Bacteriologia();
$idAtencion = $_GET['nroSoli'];
$rsR1 = $ba->get_datosResultado($idAtencion,1);
//print_r($rsR1);
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Registro de resultado de Solicitud de investigación bacteriológica</strong></h3>
    </div>
    <form name="frmRespuesta" id="frmRespuesta">
      <input type="hidden" name="txtIdSolicitud" id="txtIdSolicitud" value="<?php echo $_GET['nroSoli']?>"/>
	  <input type="hidden" name="txtIdResul" id="txtIdResul" value="<?php if(isset($rsR1[0]['id'])) {echo $rsR1[0]['id'];} else {echo 0;}?>"/>
      <input type="hidden" name="txtEstResul" id="txtEstResul" value=""/>
	  <input type="hidden" name="txtFecBacilo" id="txtFecBacilo" maxlength="10" value="<?php echo date("d/m/Y");?>"/>
      <div class="panel-body">
	  <div class="row">
	  <div class="col-sm-3">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>1. Baciloscopia</strong></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
                  <label for="txtNroRegBacilo"><b>N° Registro Lab.:</b></label>
                  <input type="text" name="txtNroRegBacilo" id="txtNroRegBacilo" placeholder="AUTOMATICO" class="form-control input-sm" maxlength="9" onkeydown="campoSiguiente('txtAspectoBacilo', event);" value="" disabled=""/>
			</div>
			<div class="form-group">
				<label for="txtIdCaliMuestra"><b>Calidad de muestra:</b></label><br/>
				<label class="radio-inline">
					<input type="radio" name="txtIdCaliMuestra" id="txtIdCaliMuestra1" class="txtIdCaliMuestra" value="1"> Adecuada
				</label>
				<label class="radio-inline">
					<input type="radio" name="txtIdCaliMuestra" id="txtIdCaliMuestra2" class="txtIdCaliMuestra" value="2"> Inadecuada
				</label>
			</div>
            <div class="form-group">
                  <label for="txtAspectoBacilo"><b>Aspecto macroscopico:</b></label>
                <?php $rsAM = $t->get_listaBACTipoMuestra(); ?>
                <select name="txtAspectoBacilo" id="txtAspectoBacilo" style="width:100%;" class="form-control input-sm"  onkeydown="campoSiguiente('txtIdResultado', event);">
                  <option value="" selected="">-- Seleccione --</option>
                  <?php
                  foreach ($rsAM as $rowAM) {
                    echo "<option value='" . $rowAM['id'] . "'>" . $rowAM['tipo'] . "</option>";
                  }
                  ?>
                </select>
            </div>
             <div class="form-group">
                <label for="txtNegaBacilo"><b>Resultado:</b></label>
				<select class="form-control input-sm" name="txtIdResultado" id="txtIdResultado" onkeydown="campoSiguiente('txtNroBaarBacilo', event);">
					<option value="" selected>Seleccione</option>
					<option value="1">NEGATIVO (-)</option>
					<option value="2">POSITIVO (+)</option>
					<option value="3">POSITIVO (++)</option>
					<option value="4">POSITIVO (+++)</option>
				</select>
            </div>
            <div class="form-group">
                  <label for="txtNroBaarBacilo"><b>N° BAAR:</b></label>
                  <input type="text" name="txtNroBaarBacilo" id="txtNroBaarBacilo" placeholder="" class="form-control input-sm" maxlength="50" onkeydown="campoSiguiente('txtPosiBacilo', event);"/>
            </div>
           </div>
        </div>
        <!--<div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>2. Cultivo</strong></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-2">
                  <label for="txtFecCultivo">Fecha</label>
                  <div class="input-group input-group-xs date">
                    <div class="input-group-addon">
                      <i class="glyphicon glyphicon-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right input-xs" name="txtFecCultivo" id="txtFecCultivo" autocomplete="OFF" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" onkeydown="campoSiguiente('txtNroRegCultivo', event);"/>
                  </div>
                </div>
                <div class="col-sm-2">
                  <label for="txtNroRegCultivo">N° Registro Lab.</label>
                  <input type="text" name="txtNroRegCultivo" id="txtNroRegCultivo" placeholder="" required="" class="form-control input-xs" maxlength="8" onkeydown="campoSiguiente('txtAspectoCultivo', event);"/>
                </div>
                <div class="col-sm-2">
                  <label for="txtAspectoCultivo">Aspecto macroscopico</label>
                  <input type="text" name="txtAspectoCultivo" id="txtAspectoCultivo" placeholder="" required="" class="form-control input-xs" maxlength="8" onkeydown="campoSiguiente('txtNegaCultivo', event);"/>
                </div>
                <div class="col-sm-2">
                  <label for="txtNegaCultivo">Negativo</label>
                  <input type="text" name="txtNegaCultivo" id="txtNegaCultivo" placeholder="" required="" class="form-control input-xs" maxlength="8" onkeydown="campoSiguiente('txtNroBaarCultivo', event);"/>
                  <span class="help-block">Anotar (-)</span>
                </div>
                <div class="col-sm-2">
                  <label for="txtNroBaarCultivo">N° BAAR/Colonias</label>
                  <input type="text" name="txtNroBaarCultivo" id="txtNroBaarCultivo" placeholder="" required="" class="form-control input-xs" maxlength="8" onkeydown="campoSiguiente('txtPosiCultivo', event);"/>
                </div>
                <div class="col-sm-2">
                  <label for="txtPosiCultivo">Positivo </label>
                  <input type="text" name="txtPosiCultivo" id="txtPosiCultivo" placeholder="" required="" class="form-control input-xs" maxlength="8" onkeydown="campoSiguiente('txtFecEntrega', event);"/>
                  <span class="help-block">Anotar (+, ++, +++)</span>
                </div>
              </div>
            </div>
          </div>
        </div>-->
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>2. Observaciones</strong></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <textarea name="txtObsResul" id="txtObsResul" class="form-control" rows="3"></textarea>
            </div>
          </div>
        </div>
		</div>
		<div class="col-sm-9">
			<div class="embed-responsive embed-responsive-16by9">
			  <iframe class="embed-responsive-item" src="pdf_solisinvalor.php?id_solicitud=<?php echo $idAtencion;?>" allowfullscreen></iframe>
			</div>
		</div>
		</div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <div id="saveResultado">
                <div class="btn-group">
                  <button type="button" class="btn btn-warning btn-lg" id="btnValidFormTemp" onclick="validForm(2)"><i class="fa fa-save"></i> Guardar Temporal </button>
                  <button type="button" class="btn btn-success btn-lg" id="btnValidForm" onclick="validForm(3)"><i class="fa fa-save"></i> Finalizar resultado </button>
                  <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="fa fa-times"></i> Cancelar</button>
                </div>
              </div>
              <div id="saveExportar" style="display: none;">
                <div class="btn-group">
                  <button type="button" class="btn btn-lg btn-success" id="btn-imrimirall" onclick="open_pdfsolisinvalor();"><i class="fa fa-file-pdf-o"></i> Imprimir resultado</button>
                  <a href="./main_principalresul.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Salir</a>
                </div>
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
function validForm(id_estadovalid) {
  //$('#btnValidFormTemp').prop("disabled", true);
  var msg = "";
  var sw = true;

  var id_calidadmuestra = document.frmRespuesta.txtIdCaliMuestra.value;
  var desc_aspecto = $('#txtAspectoBacilo').val();
  var id_resultado = $('#txtIdResultado').val();
  var nro_colonia = $('#txtNroBaarBacilo').val();
  
  if(id_calidadmuestra  == ""){
	msg += "Seleccione calidad de muestra.<br/>";
    sw = false;
  }
  
  if (id_resultado == ""){
	msg += "Seleccion un resultado del examen de Baciloscopia.<br/>";
    sw = false;
  } else {
	  if ((id_resultado == "1") && (nro_colonia == "")){
		msg += "Ingresar Nro. BAAR del resultado de la Baciloscopia.<br/>";
		sw = false;
	  }	  
  }
  
  document.frmRespuesta.txtEstResul.value = id_estadovalid;
  if (sw == false) {
    bootbox.alert(msg);
    //$('#btnValidFormTemp').prop("disabled", false);
    return sw;
  }
  
  if(id_estadovalid == "2"){
	  msgv="El resultado se registrará de manera temporal. <br/> ¿Está seguro de continuar?";
  } else {
	  msgv="El resultado será finalizado y enviado al servicio solicitante. <br/> ¿Está seguro de continuar?";
  }
  bootbox.confirm({
    message: msgv,
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
        var myRand = parseInt(Math.random() * 999999999999999);
        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlBacteriologia.php',
          data: {
            accion: 'POST_ADD_REGRESPUESTA', id: document.frmRespuesta.txtIdResul.value, id_atencion: document.frmRespuesta.txtIdSolicitud.value, id_estadovalid: document.frmRespuesta.txtEstResul.value, id_tipprocedimiento: "1",
			id_calidadmuestra: id_calidadmuestra, desc_aspecto: desc_aspecto, id_resultado: id_resultado, nro_colonia: nro_colonia, desc_observacion: document.frmRespuesta.txtObsResul.value,
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
			  if(id_estadovalid == "2"){
				location.reload();
			  } else {
				  window.location = './main_principalresul.php';
			  }

            } else {
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

function open_pdfsolisinvalor() {
  var idSoli = $("#txtIdSolicitud").val();
  var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
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

  jQuery('#txtNroRegBacilo').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
    return false;
  });

  jQuery('#txtNroRegCultivo').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
    return false;
  });

});

$(document).ready(function() {
	<?php 
	if(count($rsR1)>0){
		?>
		$("#txtNroRegBacilo").val("<?php echo $rsR1[0]['nro_reglab'] . '-' . $rsR1[0]['anio_reglab'];?>");
		$("#txtIdCaliMuestra<?php echo $rsR1[0]['id_calidadmuestra']?>").prop('checked', true);
		$("#txtAspectoBacilo").val("<?php echo $rsR1[0]['id_aspecto_macroscopico']?>");
		$("#txtIdResultado").val("<?php echo $rsR1[0]['id_resultado']?>");
		$("#txtNroBaarBacilo").val("<?php echo $rsR1[0]['nro_colonia']?>");
		$("#txtObsResul").val("<?php echo $rsR1[0]['desc_observacion']?>");

		<?php 
	}
	?>
});
</script>
<?php require_once '../include/masterfooter.php'; ?>

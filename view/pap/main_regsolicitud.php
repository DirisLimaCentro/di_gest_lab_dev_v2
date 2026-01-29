<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Ubigeo.php';
$ub = new Ubigeo();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>REGISTRO DE ATENCIÓN DE TOMA DE PAP</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmSolicitud" id="frmSolicitud">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="0"/>
        <input type="hidden" name="txtIdPac" id="txtIdPac" value="0"/>
        <input type="hidden" name="txtIdSoli" id="txtIdSoli" value="0"/>
        <div class="row">
			<?php require_once 'main_regsolicitud_paciente.php'; ?>
			<?php require_once 'main_regsolicitud_tamizaje_actu.php'; ?>
        </div>
		<?php require_once 'main_regsolicitud_tamizaje_ante.php'; ?>
        <div class="row">
			<?php require_once 'main_regsolicitud_anticonceptivo.php'; ?>
			<?php require_once 'main_regsolicitud_sintoma.php'; ?>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Examen cervicouterino (Espéculo)</strong></h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-3">
                <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="check_exacervico" name="txtExaCervico" id="txtExaCervico1" value="1" disabled/>
                      CONGESTIÓN (Amarrillo)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="check_exacervico" name="txtExaCervico" id="txtExaCervico2" value="2" disabled/>
                      ECTROPIÓN (Azul)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="check_exacervico" name="txtExaCervico" id="txtExaCervico3" value="3" disabled/>
                      ULCERACIÓN (Rojo)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="check_exacervico" name="txtExaCervico" id="txtExaCervico4" value="4" disabled/>
                      PÓLIPOS (Anaranjado)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="check_exacervico" name="txtExaCervico" id="txtExaCervico5" value="5" disabled/>
                      TUMORACIÓN (Verde)
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-sm-9">
                <div id="paint-app"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Observaciones de la atención</strong></h3>
          </div>
          <div class="panel-body" style="padding-top: 5px !important; padding-bottom: 5px !important;">
            <div class="form-group">
              <textarea name="txtObsSoli" id="txtObsSoli" class="form-control" rows="3" disabled></textarea>
            </div>
          </div>
        </div>
		<?php require_once 'main_regsolicitud_procedimiento.php'; ?>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div id="saveSolicitud">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="validForm()" disabled><i class="fa fa-save"></i> Guardar Atención </button>
                  <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="fa fa-times"></i> Cancelar</button>
                </div>
              </div>
              <div id="saveExportar" style="display: none;">
                <div class="btn-group">
                  <button type="button" class="btn btn-lg btn-success" id="btn-imrimirall" onclick="open_pdfsinvalor();"><i class="fa fa-file-pdf-o"></i> Imprimir Ficha</button>
                  <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="fa fa-times"></i> Salir</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require_once 'main_regsolicitud_apoderado.php'; ?>
<div id="mostrar_datospac" class="modal fade" role="dialog" data-backdrop="static"></div>
<?php require_once '../include/footer.php'; ?>
<script type="text/javascript" src="main_principalsoli.js"></script>
<script type="text/javascript" src="../../assets/js/canvasregpap.js"></script>
<script Language="JavaScript">
var dd = ['88141','Z01.4','24878','23904','29448','25122','25391'];

function delete_diag(nro){
  //alert(nro);
  var jo = '1';
  for (x=0;x<dd.length;x++){
      if(dd[x] == nro){
          dd.splice(x,1);
          jo = '2';
          break;
        }
  }
  if(jo == '1') dd.push(nro);

  nro = nro.replace(".", "");
  var iddiag = $("#lbl"+nro).val();
  if(iddiag == '2'){
    $("#btnDelet" + nro).html('<i class="fa fa-remove"></i> Quitar').removeClass("btn-default").addClass("btn-success");
    $("#lbl" + nro).val('1');
  } else {
    $("#btnDelet" + nro).html('<i class="glyphicon glyphicon-ok"></i> Agregar').removeClass("btn-success").addClass("btn-default");
    $("#lbl" + nro).val('2');
  }
  //alert(dd);
}

function saveViaAJAX(idaten)
{
  var testCanvas = document.getElementById("testCanvas");
  var canvasData = testCanvas.toDataURL("image/png");
  var postData = idaten + "=" + canvasData;
  //var postData = "canvasData="+canvasData;
  //var postData = 'txtIdAtencion,'+ $('#txtIdAtencion').val() + '&canvasData='+canvasData;
  //var debugConsole= document.getElementById("debugConsole");
  //debugConsole.value=canvasData;

  //alert("canvasData ="+canvasData );
  var ajax = new XMLHttpRequest();
  ajax.open("POST",'examen/testSave.php',true);
  ajax.setRequestHeader('Content-Type', 'canvas/upload');
  //ajax.setRequestHeader('Content-TypeLength', postData.length);

  ajax.onreadystatechange=function()
  {
    if (ajax.readyState == 4)
    {
      $("#saveSolicitud").hide();
      $("#saveExportar").show();
      //bootbox.alert("El registro se guardo correctamente.");
      open_datoslamina();
    }
  }

  ajax.send(postData);
}

function open_datoslamina(){
  var id = $("#txtIdAtencion").val();
  $('#mostrar_datospac').modal('show');
  $.ajax({
    url: '../../controller/ctrlPAP.php',
    type: 'POST',
    data: 'accion=GET_SHOW_DATOSATENCION&opt=F&idSoli=' + id,
    success: function(data){
      $('#mostrar_datospac').html(data);
    }
  });
}

	$('[name="txtTipPac"]').change(function(){
		$('.tooltip').not(this).hide();
	});

$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip('show');

	$('#txtFecNacPac').inputmask();
	$('#txtFecNacPac').datetimepicker({
	locale: 'es',
	format: 'L'
	});

	$('#txtIdPaisNacPac').select2();
	$('#txtIdEtniaPac').select2();
	$('#txtIdDepPac').select2();
	$('#txtUBIGEOPac').select2();

	$('#txtIdParenSoli').select2();
	$('#txt_id_cie').select2();
  

	$('#txtNroFUA').inputmask("036-99-99999999");
	$('#txtTallaPac').inputmask("9.99");

	//setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);

	$("#txtFecNacPac").focusout(function () {
	fecha_fin = '<?php echo date("d/m/Y")?>';//$("#txtFecNacPac").val();
	fecha_ini = $(this).val();
	if(fecha_ini != ""){
	  $.post("../../controller/ctrlTipo.php", { fecha_ini: fecha_ini, fecha_fin: fecha_fin, accion: "GET_FUNC_CALCULAEDAD" }, function(data){
		var datos = eval(data);
		$("#txtEdadPac").val(datos[0]);
	  });
	} else {
	  //setTimeout(function(){$('#txtFecNacPac').trigger('focus');}, 2);
	}
	});
  
  $("#txtPesoPac").focusout(function () {
    talla = $('#txtTallaPac').val();
    peso = $(this).val();
	if(talla == "" && peso == "") return false;
	if(talla == "") return false;
	if(peso == "") return false;
	talla = parseFloat(talla);
	peso = parseFloat(peso);
	imc = peso/(talla * talla);
	$('#txtIMCPac').val(imc.toFixed(2));
  });

  $("#txtTallaPac").focusout(function () {
    talla = $(this).val();
    peso = $('#txtPesoPac').val();
	if(talla == "" && peso == "") return false;
	if(talla == "") return false;
	if(peso == "") return false;
	talla = parseFloat(talla);
	peso = parseFloat(peso);
	imc = peso/(talla * talla);
	$('#txtIMCPac').val(imc.toFixed(2));
  });
  
	$('[name="txtTipPac"]').change(function(){
		$('#txt_id_cie, #btn_adddiag, #btnValidForm').prop("disabled", false);
		$("button[id*='btnDelet']").prop("disabled", false);
	});
  
});

</script>
<?php require_once '../include/masterfooter.php'; ?>

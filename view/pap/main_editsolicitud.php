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
require_once '../../model/Pap.php';
$pap = new Pap();
$idAtencion = $_GET['nroSoli'];
$rsA = $pap->get_datosSolicitud($idAtencion);
//print_r($rsA);
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title text-center"><strong>EDICIÓN DE TOMA DE PAP (<?php echo $rsA[0]['nro_ordenatencion'] . "-" . $rsA[0]['anio_ordensoli']?>)</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmSolicitud" id="frmSolicitud">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="<?php echo $idAtencion;?>"/>
        <input type="hidden" name="txtIdPac" id="txtIdPac" value="<?php echo $rsA[0]['id_persona'];?>"/>
        <input type="hidden" name="txtIdSoli" id="txtIdSoli" value="<?php echo $rsA[0]['id_apoderado'] <> ""? $rsA[0]['id_apoderado'] : 0?>"/>
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
            <h3 class="panel-title"><strong>Examen cervico uterino (Espéculo)</strong></h3>
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
              <textarea name="txtObsSoli" id="txtObsSoli" class="form-control" rows="3" disabled><?php echo $rsA[0]['descrip_obssoli']?></textarea>
            </div>
          </div>
        </div>
		<?php require_once 'main_regsolicitud_procedimiento.php'; ?>
        
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div id="saveSolicitud">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Guardar Atención </button>
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
<script type="text/javascript" src="../../assets/js/canvaseditpap.js"></script>
<script Language="JavaScript">
var aa = ['24878','23904','29448','25122','25391'];
for (var i=0; i < aa.length; i++){
	//msgForNormal = msgForNormal + dato[i] + ' - '; 
    $("#lbl" + aa[i]).val('2');
    $("#btnDelet" + aa[i]).html('<i class="glyphicon glyphicon-ok"></i> Agregar').removeClass("btn-success").addClass("btn-default");
};

var dd = [];

<?php $rsPAPD = $pap->get_datosInsumosPorIdSolicitud($idAtencion);
if (count($rsPAPD) <> 0){
  foreach ($rsPAPD as $rowD) {
    $diag = str_replace(".", "", $rowD['id_diagnostico']);
    ?>

    dd.push("<?php echo $rowD['id_diagnostico']?>");

    $("#lbl<?php echo $diag?>").val('1')
    $("#btnDelet<?php echo $diag?>").html('<i class="fa fa-remove"></i> Quitar').removeClass( "btn-default" ).addClass( "btn-success" );
    <?php
  }
}?>

//alert(dd);

<?php $rsPAPD = $pap->get_datosDiagnosticoPorIdSolicitud($idAtencion);
if (count($rsPAPD) <> 0){
  foreach ($rsPAPD as $rowD) {
    ?>
	var data = [
		/*00*/ id_items_diagnostico,
		/*01*/ "<?php echo $rowD['id_diagnostico']?>",
		/*02*/ "<?php echo $rowD['nom_cie']?>"
	];
	items_arr_diagnostico.push(data);
	id_items_diagnostico++;
	renderItemsDetalleDiagnosticos();
    <?php
  }
}?>

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

function buscar_datos_personalesedit(){
  $.ajax({
    url: "../../controller/ctrlPersona.php",
    type: "POST",
    dataType: 'json',
    data: {
      accion: 'GET_SHOW_PERSONULTIMAATENCIONPORIDDEP', txtTipoBus: '1', txtIdTipDoc: $("#txtIdPac").val(), txtNroDoc: ''
    },
    beforeSend: function (objeto) {
      bootbox.dialog({
        message: '<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i> Por favor espere...</p>',
        closeButton: false
      });
    },
    success: function (registro) {
      bootbox.hideAll();
      var datos = eval(registro);
      $("#txtNomPac").val(datos[4]);
      $("#txtPriApePac").val(datos[5]);
      $("#txtSegApePac").val(datos[6]);
      $("#txtIdSexoPac").val(datos[7]);
      $("#txtFecNacPac").val(datos[9]);
      $("#txtEdadPac").val(datos[20]);
      $("#txtNroHCPac").val(datos[10]);
      $("#txtIdPaisNacPac").val(datos[21]).trigger("change");
      $("#txtIdEtniaPac").val(datos[22]).trigger("change");
    }
  });
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

$(document).ready(function() {
	buscar_datos_personalesedit();
	$("#txtIdTipDocPac").val("<?php echo $rsA[0]['id_tipodoc']?>");
	$("#txtNroDocPac").val("<?php echo $rsA[0]['nrodoc']?>");
	$('#txtNroHCPac').prop("disabled", false);
	enabled_datos_direccion();
	enabled_datos_atencion();
	enabled_datos_tamizaje();
	enabled_datos_anticonceptivo();
	enabled_datos_sintoma();
	enabled_datos_examen();

	<?php if($rsA[0]['check_tipopac'] == "t"){ ?>
		$("#txtTipPac1").prop('checked', true);
		$("#txtNroFUA").val("<?php echo $rsA[0]['nro_fua'];?>");
		$("#datos-sis").show();
	<?php } else { ?>
		$('#txtIdTipPacParti').prop("disabled", false);
		$('#txtIdTipPacParti').val("<?php echo $rsA[0]['id_tipoatencionparti'];?>");
		$("#txtTipPac2").prop('checked', true);
	<?php } ?>
  
	$("#txtIdDepPac").append('<option value="<?php echo $rsA[0]['id_departamento'];?>" selected><?php echo $rsA[0]['departamento'];?></option>'); 
	$("#txtUBIGEOPac").append('<option value="<?php echo $rsA[0]['id_distrito'];?>" selected><?php echo $rsA[0]['provincia'];?>-<?php echo $rsA[0]['distrito'];?></option>'); 
	$('#txtDirPac').val("<?php echo $rsA[0]['descrip_dir'];?>");
	$('#txtDirRefPac').val("<?php echo $rsA[0]['descrip_ref'];?>");
	$('#txtNroTelFijoPac').val("<?php echo $rsA[0]['telf_fijo'];?>");
	$('#txtNroTelMovilPac').val("<?php echo $rsA[0]['telf_movil'];?>");
	$('#txtEmailPac').val("<?php echo $rsA[0]['email'];?>");

	<?php if($rsA[0]['id_apoderado'] <> ""){ ?>
		$('#txtIdTipDocSoliT').val("<?php echo $rsA[0]['id_tipodocapo'];?>");
		$('#txtNroDocSoliT').val("<?php echo $rsA[0]['nrodocapo'];?>");
		$('#txtNomCompleSoli').val("<?php echo $rsA[0]['nombre_apo'];?>");
		
		$("#txtIdParenSoli").append('<option value="<?php echo $rsA[0]['id_parentesco'];?>" selected><?php echo $rsA[0]['parentesco'];?></option>'); 
		
		$("#datos-soli").show();
		buscar_datos_personales_soli('3');
		$("#lbl-parentesco").text('Parentesco: <?php echo $rsA[0]['parentesco']?>');
	<?php } ?>
	$('#txtIdTipDocSoliT').prop("disabled", false);
	$('#txtNroDocSoliT').prop("disabled", false);
	$('#btnSoliTSearch').prop("disabled", false);

	/*//////////// TOMA ACTUAL  ////////*/
	$('#txtIdCondiDepen').val("<?php echo $rsA[0]['id_condidependencia'];?>");
	$('#txtIdCondiServ').val("<?php echo $rsA[0]['id_condiservicio'];?>");
	$('#txtIRS').val("<?php echo $rsA[0]['edad_iris'];?>");


	<?php if($rsA[0]['check_fur'] == "t"){ ?>
		$("#txtFUR1").prop('checked', true);
	<?php } else {?>
		$("#txtFUR2").prop('checked', true);
		$("#txtFechaFUR").inputmask('remove');
	<?php } ?>
	$('#txtFechaFUR').val("<?php echo $rsA[0]['fec_fur'];?>");
	$("#txtFechaFUR").prop('disabled', false);
	
	$('#txtGest').val("<?php echo $rsA[0]['nro_gest'];?>");
	$('#txtPARA1').val("<?php echo $rsA[0]['nro_parapri'];?>");
	$('#txtPARA2').val("<?php echo $rsA[0]['nro_parase'];?>");
	$('#txtPARA3').val("<?php echo $rsA[0]['nro_parater'];?>");
	$('#txtPARA4').val("<?php echo $rsA[0]['nro_paracua'];?>");

	<?php if($rsA[0]['check_gestante'] == "t"){ ?>
		$("#txtIdGestante1").prop('checked', true);
		$('#txtFechaParto').val("<?php echo $rsA[0]['fec_partogestante'];?>");
		$("#txtFechaParto").prop('disabled', false);
	<?php } else {?>
		$("#txtIdGestante2").prop('checked', true);
	<?php } ?>

	$('#txtPesoPac').val("<?php echo ($rsA[0]['peso_pac'] == "")? "": number_format($rsA[0]['peso_pac'], 2, '.', '');?>");
	$('#txtTallaPac').val("<?php echo ($rsA[0]['talla_pac'] == "")? "": number_format($rsA[0]['talla_pac'], 2, '.', '');?>");
	$('#txtIMCPac').val("<?php echo ($rsA[0]['imc_pac'] == "")? "": number_format($rsA[0]['imc_pac'], 2, '.', '');?>");
	$('#txtPAPac').val("<?php echo $rsA[0]['pa_pac'];?>");
	
	/*//////////// TAMIZAJE ANTERIOR  ////////*/
	$("#txtPAPANte").val('<?php echo $rsA[0]['id_tamizajeante']?>');

	<?php if($rsA[0]['id_resultamiante'] <> ""){ ?>
		$(".opt_resulante").prop('disabled', false);
		$("#txtResultadoAnte<?php echo $rsA[0]['id_resultamiante']?>").prop('checked', true);
		$("#txAnioResulAnte").prop('disabled', false);
		$("#txAnioResulAnte").val('<?php echo $rsA[0]['anio_tamizajeante']?>');
		$(".opt_resulanteexa").prop('disabled', false);
		<?php 
			if($rsA[0]['id_resultamiante'] == "1"){ ?>
			$("#show-resultadoanteexa").show();
		<?php 
				$rsSPAPS = $pap->get_datosProcedimientoAnteriorPorIdSolicitud($idAtencion);
				if (count($rsSPAPS) <> 0){
					foreach ($rsSPAPS as $rowA) {
						?>
						$("#txtResultadoAnteExa<?php echo $rowA['id_papprocedimiento']?>").prop('checked', true);
						<?php
					}
				}
			}
		}?>

	<?php if($rsA[0]['id_anorescamosaante'] <> ""){ ?>
		$("#txtAnorEscamosa<?php echo $rsA[0]['id_anorescamosaante']?>").prop('checked', true);
		$(".opt_anorescamosa").prop('disabled', false);
	<?php }?>

	<?php if($rsA[0]['id_anorglandularante'] <> ""){ ?>
		$("#txtAnorGlandular<?php echo $rsA[0]['id_anorglandularante']?>").prop('checked', true);
		$(".opt_anorglandular").prop('disabled', false);
	<?php }?>

	/*//////////// ANTICONCEPTIVO  ////////*/
	
	<?php 
	$rsSPAPA = $pap->get_datosAnticonceptivoPorIdSolicitud($idAtencion);
	if (count($rsSPAPA) <> 0){
		foreach ($rsSPAPA as $rowA) {
	?>
			$("#txtAnticonceptivo<?php echo $rowA['id_tipanticonceptivo']?>").prop('checked', true);
	<?php if($rowA['det_tipanticonceptivo'] <> ""){	?>
			$("#txtDetAnticonceptivo").val('<?php echo $rowA['det_tipanticonceptivo']?>');
			$("#txtDetAnticonceptivo").prop('disabled', false);
	<?php
			}
		}
	}
	?>
	/*//////////// SINTOMAS  ////////*/
	<?php 
	$rsSPAPS = $pap->get_datosSintomaPorIdSolicitud($idAtencion);
	if (count($rsSPAPS) <> 0){
		foreach ($rsSPAPS as $rowA) { ?>
			$("#txtSintoma<?php echo $rowA['id_tipsintoma']?>").prop('checked', true);
	<?php if($rowA['det_tipsintoma'] <> ""){ ?>
			$("#txtDetSintoma").val('<?php echo $rowA['det_tipsintoma']?>');
			$("#txtDetSintoma").prop('disabled', false);
	<?php 
		}
	  }
	}
	?>
	/*//////////// EXAMEN  ////////*/
	<?php 
	$rsSPAPE = $pap->get_datosExaCervicoPorIdSolicitud($idAtencion);
	if (count($rsSPAPE) <> 0){
	  foreach ($rsSPAPE as $rowE) { ?>
		$("#txtExaCervico<?php echo $rowE['id_tipexacervico']?>").prop('checked', true);
		<?php
	  }
	}
	?>


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
  

	// initialize the app
	var myElem = document.getElementById('paint-app');
	var appDiv = document.querySelector('#paint-app');
	createPaint(appDiv, "<?php echo $idAtencion;?>");
	
	setTimeout(function(){delet_padding();}, 1000);
  
	$('#txt_id_cie, #btn_adddiag, #btnValidForm').prop("disabled", false);
	$("button[id*='btnDelet']").prop("disabled", false);
});

</script>
<?php require_once '../include/masterfooter.php'; ?>

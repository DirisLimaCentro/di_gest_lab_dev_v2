var d = new Date();
var fec_actual =d.getDate() + "/" + "0" +(d.getMonth()+1) + "/" + d.getFullYear();

function buscar_datos_personalesedit(id_pac){
  $.ajax({
    url: "../../controller/ctrlPersona.php",
    type: "POST",
    dataType: 'json',
    data: {
      accion: 'GET_SHOW_PERSONULTIMAATENCIONPORIDDEP', txtTipoBus: '1', txtIdTipDoc: id_pac, txtNroDoc: ''
    },
    success: function (registro) {
      bootbox.hideAll();
      var datos = eval(registro);
	  $("#txtIdPac").val(datos[0]);
	  $("#txtIdTipDocPac").val(datos[1]);
	  $("#txtNroDocPac").val(datos[3]);
      $("#txtNomPac").val(datos[4]);
      $("#txtPriApePac").val(datos[5]);
      $("#txtSegApePac").val(datos[6]);
      $("#txtIdSexoPac").val(datos[7]);
      $("#txtFecNacPac").val(datos[9]);
      $("#txtEdadPac").val(datos[20]);
      $("#txtNroHCPac").val(datos[10]);
      $("#txtIdPaisNacPac").val(datos[21]).trigger("change");
      $("#txtIdEtniaPac").val(datos[22]).trigger("change");
	  setTimeout(function(){delet_padding();}, 1000);
	  enabled_datos_direccion();
    }
  });
}

function buscar_datos_menoredit(id_menor){
  $.ajax({
    url: "../../controller/ctrlPersona.php",
    type: "POST",
    dataType: 'json',
    data: {
      accion: 'GET_SHOW_PERSONULTIMAATENCIONPORIDDEP', txtTipoBus: '1', txtIdTipDoc: id_menor, txtNroDoc: ''
    },
    success: function (registro) {
      bootbox.hideAll();
      var datos = eval(registro);
	  $("#txtIdNino").val(datos[0]);
	  $("#txtIdTipDocNi").val(datos[1]);
	  $("#txtNroDocNi").val(datos[3]);
      $("#txtNomNi").val(datos[4]);
      $("#txtPriApeNi").val(datos[5]);
      $("#txtSegApeNi").val(datos[6]);
      $("#txtIdSexoNi").val(datos[7]);
      $("#txtFecNacNi").val(datos[9]);
	  setTimeout(function(){delet_padding();}, 1000);
	  enabled_datos_menoredit(datos[1]);
    }
  });
}

function restaFechas(f1,f2) {
	var aFecha1 = f1.split('/'); 
	var aFecha2 = f2.split('/'); 
	var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); 
	var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); 
	var dif = fFecha2 - fFecha1;
	var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
	return dias;
}

var dato = eval(atencion);
console.log(dato);
$(document).ready(function() {
	$('#txtIdAtencion').val(dato[0]['id']);
	if(dato[0]['chk_tipopaciente'] == "t"){e_tipopaciente = "1"} else {e_tipopaciente = "0"};
	document.frmSolicitud.txtTipPac.value = e_tipopaciente;
	$('.opt_txtTipPac').prop("disabled", true);
	$('#txtIdTipPacParti').val(dato[0]['id_tipopacienteprivado']);

	buscar_datos_personalesedit(dato[0]['id_persona']);
	$("#txtIdDepPac").append('<option value="' + dato[0]['id_departamento'] + '" selected>'+ dato[0]['departamento'] + '</option>'); 
	$('#txtDirPac').val(dato[0]['descrip_dir']);
	$('#txtDirRefPac').val(dato[0]['descrip_ref']);
	$('#txtNroTelFijoPac').val(dato[0]['telf_fijo']);
	$('#txtNroTelMovilPac').val(dato[0]['telf_movil']);
	$('#txtEmailPac').val(dato[0]['email']);
	$("#txtUBIGEOPac").append('<option value="' + dato[0]['id_distrito'] + '" selected>' + dato[0]['provincia'] + '-' + dato[0]['distrito'] + '</option>').trigger("change");  //Pendiente
	
	//Datos de atención
	$('.opt_estadopac').prop("disabled", true);
	if(dato[0]['chk_tiposeguimiento'] == "t"){e_tiposeguimiento = "1"} else {e_tiposeguimiento = "0"};
	document.frmSolicitud.txtEstadoPac.value = e_tiposeguimiento;
	$('#txt_fur').val(dato[0]['fur_pac']);
	$('#txt_fpp').val(dato[0]['fpp_pac']);
	$('#txtFechaCPN').val(dato[0]['fec_cpn']);
	$('#txtEGCPN').val(dato[0]['eg_cpn']).trigger("change");
	$('#txtIPRESDiag').val(dato[0]['id_ipressdiag']);
	$('#txtDetIPRESDiag').val(dato[0]['det_ipressdiag']);
	enabled_datos_atencion();
	
	enabled_datos_sifilis();
	document.frmSolicitud.txtDiagnostico.value = dato[0]['id_momentodiag'];
	enabled_datos_momento_diagnostico();
	$('#txt_aniodx').val(dato[0]['anio_diagprevio']);
	if(dato[0]['chk_diagpreviotratamiento'] == "t"){e_diagpreviotratamiento = "1"} else if(dato[0]['chk_diagpreviotratamiento'] == "f") {e_diagpreviotratamiento = "0"} else {e_diagpreviotratamiento = ""};
	document.frmSolicitud.txt_tratamientodx.value = e_diagpreviotratamiento;
	$('#txtEGAPNDiag').val(dato[0]['eg_apnmomentodiag']).trigger("change");
	$('#txtObsMadre').val(dato[0]['obs_madre']);
	if(dato[0]['id_tipoculminaembarazo'] == null){e_tipoculminaembarazo = ""} else {e_tipoculminaembarazo = dato[0]['id_tipoculminaembarazo']};
	document.frmSolicitud.txtCulmiEmbarazo.value = e_tipoculminaembarazo;
	if(e_tipoculminaembarazo == "1"){
		$('#txtTipoPartoParto').val(dato[0]['id_tipoparto']);
		enabled_datos_culminacion_embarazo();
	} else if(e_tipoculminaembarazo == "2"){
		$('#txtTipoPartoOtro').val(dato[0]['id_tipoparto']);
		$('#txtFechaOtro').val(dato[0]['fec_partootro']);
		enabled_datos_culminacion_embarazo();
	}
	
	//Datos de detalle de atencion
	//alert(dato[0]['id_tipoculminaembarazo']);
	$('#txtFechaPruRapLab').val(dato[0]['fec_pruebarapida']);
	$('#txtFechaDLS1').val(dato[0]['fec_dils1']);
	$('#txtNroDLS1').val("1/"+dato[0]['nro_dils1']);
	if(dato[0]['fec_chkdils1'] !== null){
		$("#txtAsisFechaDLS1").prop('checked', true);
		$("#txtFechaDLS1").prop('disabled', true);
		$("#txtNroDLS1").prop('disabled', false);
		$('#txtFechaDLS1').closest(".form-group").addClass("has-success");
	}
	$('#txtFechaDLS2').val(dato[0]['fec_dils2']);
	$('#txtNroDLS2').val("1/"+dato[0]['nro_dils2']);
	if(dato[0]['fec_chkdils2'] !== null){
		$("#txtAsisFechaDLS2").prop('checked', true);
		$("#txtAsisFechaDLS2").prop('disabled', false);
		$("#txtNroDLS2").prop('disabled', false);
		$("#txtFechaDLS2").prop('disabled', true);
		$('#txtFechaDLS2').closest(".form-group").addClass("has-success");
	} else {
		if (dato[0]['fec_dils2'] !== null) {
			$("#txtFechaDLS2").prop('disabled', false);
			$("#txtAsisFechaDLS2").prop('disabled', false);
			dias = restaFechas(fec_actual,dato[0]['fec_dils2']);
			dias = parseInt(dias);
			if(dias < 0){
				$('#txtFechaDLS2').closest(".form-group").addClass("has-error");
			}
		}
	}
	$('#txtFechaDLS3').val(dato[0]['fec_dils3']);
	$('#txtNroDLS3').val("1/"+dato[0]['nro_dils3']);
	if(dato[0]['fec_chkdils3'] !== null){
		$("#txtAsisFechaDLS3").prop('checked', true);
		$("#txtAsisFechaDLS3").prop('disabled', false);
		$("#txtNroDLS3").prop('disabled', false);
		$("#txtFechaDLS3").prop('disabled', true);
		$('#txtFechaDLS3').closest(".form-group").addClass("has-success");
	} else {
		if (dato[0]['fec_dils3'] !== null) {
			$("#txtFechaDLS3").prop('disabled', false);
			$("#txtAsisFechaDLS3").prop('disabled', false);
			dias = restaFechas(fec_actual,dato[0]['fec_dils3']);
			dias = parseInt(dias);
			if(dias < 0){
				$('#txtFechaDLS3').closest(".form-group").addClass("has-error");
			}
		}
	}
	
	if(dato[0]['chk_pacalergica'] == "t"){e_pacalergica = "1"} else {e_pacalergica = "0"};
	document.frmSolicitud.txt_alergicopene.value = e_pacalergica;
	enabled_datos_alegicapenecilina();
	if(e_pacalergica == "0"){//Si no es alergica
		$('#txtFechaDosisPac1').val(dato[0]['fec_pacnoalerdosis1']);
		if(dato[0]['fec_chkpacnoalerdosis1'] !== null){
			$("#txtAsisDosisPac1").prop('checked', true);
			$("#txtFechaDosisPac1").prop('disabled', true);
			$('#txtFechaDosisPac1').closest(".form-group").addClass("has-success");
		}
		$('#txtFechaDosisPac2').val(dato[0]['fec_pacnoalerdosis2']);
		if(dato[0]['fec_chkpacnoalerdosis2'] !== null){
			$("#txtAsisDosisPac2").prop('checked', true);
			$("#txtAsisDosisPac2").prop('disabled', false);
			$("#txtFechaDosisPac2").prop('disabled', true);
			$('#txtFechaDosisPac2').closest(".form-group").addClass("has-success");
		} else {
			if (dato[0]['fec_pacnoalerdosis2'] !== null) {
				$("#txtFechaDosisPac2").prop('disabled', false);
				$("#txtAsisDosisPac2").prop('disabled', false);
				dias = restaFechas(fec_actual,dato[0]['fec_pacnoalerdosis2']);
				dias = parseInt(dias);
				if(dias < 0){
					$('#txtFechaDosisPac2').closest(".form-group").addClass("has-error");
				}
			}
		}
		$('#txtFechaDosisPac3').val(dato[0]['fec_pacnoalerdosis3']);
		if(dato[0]['fec_chkpacnoalerdosis3'] !== null){
			$("#txtAsisDosisPac3").prop('checked', true);
			$("#txtAsisDosisPac3").prop('disabled', false);
			$("#txtFechaDosisPac3").prop('disabled', true);
			$('#txtFechaDosisPac3').closest(".form-group").addClass("has-success");
		} else {
			if (dato[0]['fec_pacnoalerdosis3'] !== null) {
				$("#txtFechaDosisPac3").prop('disabled', false);
				$("#txtAsisDosisPac3").prop('disabled', false);
				dias = restaFechas(fec_actual,dato[0]['fec_pacnoalerdosis3']);
				dias = parseInt(dias);
				if(dias < 0){
					$('#txtFechaDosisPac3').closest(".form-group").addClass("has-error");
				}
			}
		}
	} else {//Si es alergica
	
		$('#txtFechaPruSensi').val(dato[0]['fec_pacalerprusensi']);
		$('#txtFechaDesensi').val(dato[0]['fec_pacalerprudesensi']);
		if(dato[0]['chk_pacalerprudesensirefe'] == "t"){e_pacalerprudesensirefe = "1"} else {e_pacalerprudesensirefe = "0"};
		document.frmSolicitud.txtPruebaSenciRefe.value = e_pacalerprudesensirefe;
		if(dato[0]['chk_pacalertratamientofinal'] == "t"){e_pacalertratamientofinal = "1"} else {e_pacalertratamientofinal = "0"};
		document.frmSolicitud.txt_alergicopenetrata.value = e_pacalertratamientofinal;
		enabled_datos_tratamientofinalalegicapenecilina();
		$('#txt_fec_1radosis_hosp').val(dato[0]['fec_pacaler1radosis_hosp']);
		if(dato[0]['fec_chkpacaler1radosis_hosp'] !== null){
			$("#txt_asis_dosistratapene_hosp1").prop('checked', true);
			$("#txt_fec_1radosis_hosp").prop('disabled', true);
			$('#txt_asis_dosistratapene_hosp1').closest(".form-group").addClass("has-success");
		}
		$('#txt_fec_2dadosis_hosp').val(dato[0]['fec_pacaler2dadosis_hosp']);
		if(dato[0]['fec_chkpacaler2dadosis_hosp'] !== null){
			$("#txt_asis_dosistratapene_hosp2").prop('checked', true);
			$("#txt_asis_dosistratapene_hosp2").prop('disabled', false);
			$("#txt_fec_2dadosis_hosp").prop('disabled', true);
			$('#txt_fec_2dadosis_hosp').closest(".form-group").addClass("has-success");
		} else {
			if (dato[0]['fec_pacaler2dadosis_hosp'] !== null) {
				$("#txt_fec_2dadosis_hosp").prop('disabled', false);
				$("#txt_asis_dosistratapene_hosp2").prop('disabled', false);
				dias = restaFechas(fec_actual,dato[0]['fec_pacaler2dadosis_hosp']);
				dias = parseInt(dias);
				if(dias < 0){
					$('#txt_fec_2dadosis_hosp').closest(".form-group").addClass("has-error");
				}
			}
		}
		$('#txt_fec_3radosis_hosp').val(dato[0]['fec_pacaler3radosis_hosp']);
		if(dato[0]['fec_chkpacaler3radosis_hosp'] !== null){
			$("#txt_asis_dosistratapene_hosp3").prop('checked', true);
			$("#txt_asis_dosistratapene_hosp3").prop('disabled', false);
			$("#txt_fec_3radosis_hosp").prop('disabled', true);
			$('#txt_fec_3radosis_hosp').closest(".form-group").addClass("has-success");
		} else {
			if (dato[0]['fec_pacaler3radosis_hosp'] !== null) {
				$("#txt_fec_3radosis_hosp").prop('disabled', false);
				$("#txt_asis_dosistratapene_hosp3").prop('disabled', false);
				dias = restaFechas(fec_actual,dato[0]['fec_pacaler3radosis_hosp']);
				dias = parseInt(dias);
				if(dias < 0){
					$('#txt_fec_3radosis_hosp').closest(".form-group").addClass("has-error");
				}
			}
		}
		$('#txtDetOtroTrata').val(dato[0]['det_pacalerotrotratamiento']);
		$('#txt_fec_iniotradosis_hosp').val(dato[0]['fec_inipacalerotrotratamiento']);
		$('#txt_total_otrodosis_hosp').val(dato[0]['total_dosispacalerotrotratamiento']);
	}
	
	$('#txt_nro_contacto_1').val(dato[0]['nro_contactosi']);
	if(dato[0]['chk_nro_contactosi'] == "t"){ 
		$("#check_nro_contacto_1").prop('checked', true);
		$("#txt_nro_contacto_1").prop('disabled', false);
	}
	$('#txt_nro_contacto_2').val(dato[0]['nro_contactono']);
	if(dato[0]['chk_nro_contactono'] == "t"){ 
		$("#check_nro_contacto_2").prop('checked', true);
		$("#txt_nro_contacto_2").prop('disabled', false);
	}
	$('#txt_nro_contacto_0').val(dato[0]['nro_contactodesco']);
	if(dato[0]['chk_nro_contactodesco'] == "t"){ 
		$("#check_nro_contacto_0").prop('checked', true);
		$("#txt_nro_contacto_0").prop('disabled', false);
	}
	
	if(e_tipoculminaembarazo == "1"){
		buscar_datos_menoredit(dato[0]['id_menor']);
		$('#txtIdDepNacNi').val(dato[0]['id_eessnacmenor']).trigger("change");
		$('#txtNroHCNi').val(dato[0]['nro_hcmenor']);
		$('#txtIdTipPacPartiNi').val(dato[0]['id_financiadormenor']);
		$('#txtPesoNi').val(dato[0]['peso_nacmenor']);
		$('#txtEGNi').val(dato[0]['eg_nacmenor']).trigger("change");
		$('#txtAPGARNi').val(dato[0]['apgar_nacmenor']);		
		
		$('#txtFechaDLSNi1').val(dato[0]['fec_menordils1']);
		$('#txtNroDLSNi1').val("1/"+dato[0]['nro_menordils1']);
		if(dato[0]['fec_chkmenordils1'] !== null){
			$("#txtAsisFechaDLSNi1").prop('checked', true);
			$("#txtFechaDLSNi1").prop('disabled', true);
			$("#txtNroDLSNi1").prop('disabled', false);
			$('#txtFechaDLSNi1').closest(".form-group").addClass("has-success");
		}
		$('#txtFechaDLSNi2').val(dato[0]['fec_menordils2']);
		$('#txtNroDLSNi2').val("1/"+dato[0]['nro_menordils2']);
		if(dato[0]['fec_chkmenordils2'] !== null){
			$("#txtAsisFechaDLSNi2").prop('checked', true);
			$("#txtAsisFechaDLSNi2").prop('disabled', false);
			$("#txtNroDLSNi2").prop('disabled', false);
			$("#txtFechaDLSNi2").prop('disabled', true);
			$('#txtFechaDLSNi2').closest(".form-group").addClass("has-success");
			
		} else {
			if (dato[0]['fec_menordils2'] !== null) {
				$("#txtFechaDLSNi2").prop('disabled', false);
				$("#txtAsisFechaDLSNi2").prop('disabled', false);
				dias = restaFechas(fec_actual,dato[0]['fec_menordils2']);
				dias = parseInt(dias);
				if(dias < 0){
					$('#txtFechaDLSNi2').closest(".form-group").addClass("has-error");
				}
			}
		}
		
		if(dato[0]['chk_puncionlumbarmenor'] == "t"){e_puncionlumbarmenor = "1"} else if(dato[0]['chk_puncionlumbarmenor'] == "f") {e_puncionlumbarmenor = "0"} else {e_puncionlumbarmenor = ""};
		document.frmSolicitud.txt_puncionlumbar.value = e_puncionlumbarmenor;
		if(e_puncionlumbarmenor == "1"){
			$("#txtFechaPuncionNi").prop('disabled', false);
			$("#txtResulPuncionNi").prop('disabled', false);			
			$('#txtFechaPuncionNi').val(dato[0]['fec_puncionlumbarmenor']);
			$('#txtResulPuncionNi').val(dato[0]['nro_puncionlumbarmenor']);
		}
		if(dato[0]['id_estadofinalmenor'] == null){e_estadofinalmenor = ""} else {e_estadofinalmenor = dato[0]['id_estadofinalmenor']};
		document.frmSolicitud.txtEstFinalNino.value = e_estadofinalmenor;
		if(e_estadofinalmenor != ""){
			if(e_estadofinalmenor == "3"){
				$('#txtFechaNiFalle').val(dato[0]['fec_fallecimientomenor']);
			} else {
				if(dato[0]['chk_tratamientofinalmenor'] == null){e_tratamientofinalmenor = ""} else if(dato[0]['chk_tratamientofinalmenor'] == "t"){e_tratamientofinalmenor = "1"} else {e_tratamientofinalmenor = "0"};
				document.frmSolicitud.txtTrataNino.value = e_tratamientofinalmenor;
				if(e_tratamientofinalmenor != ""){
					
					$('#txt_idtratamientoninosifilis').val(dato[0]['id_tratamientofinalmenor']);
					$('#txt_fechainitratamientoninosifilis').val(dato[0]['fec_initratamientofinalmenor']);
					$('#txt_diastratamientoninosifilis').val(dato[0]['nro_diatratamientofinalmenor']);
					$('#datos-nino-sifilis').show();
				}				
			}
		}
		$('#txtObsNino').val(dato[0]['obs_menor']);
	}

});
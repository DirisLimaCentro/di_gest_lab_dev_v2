$(function() {
	
	$('[name="txt_tipoCulmiEmbarazoNino"]').change(function(){
		if ($(this).is(':checked')) {
		  if($(this).val() == "1"){
				$('#div_culminaembarazo_parto').show();
				$('#div_culminaembarazo_otro').hide();
		  } else {
			  $('#div_culminaembarazo_parto').hide();
			  $('#div_culminaembarazo_otro').show();
		  }
		  $('#div_culminaembarazo_parto_cesarea').hide();
		  $('#div_datos_menor_1').hide();
		  $('#div_laboratorio_menor_1').hide();
		}
	});
	
	$('[name="txt_tipoCulmiEmbarazoNino2"]').change(function(){
		if ($(this).is(':checked')) {
		  if($(this).val() == "1"){
				$('#div_culminaembarazo_parto2').show();
				$('#div_culminaembarazo_otro2').hide();
		  } else {
			  $('#div_culminaembarazo_parto2').hide();
				$('#div_culminaembarazo_otro2').show();
		  }
		  $('#div_culminaembarazo_parto_cesarea2').hide();
		  $('#div_datos_menor_2').hide();
		  $('#div_laboratorio_menor_2').hide();
		}
	});
	
	$('[name="txt_tipoCulmiEmbarazoNino3"]').change(function(){
		if ($(this).is(':checked')) {
		  if($(this).val() == "1"){
				$('#div_culminaembarazo_parto3').show();
				$('#div_culminaembarazo_otro3').hide();
		  } else {
			  $('#div_culminaembarazo_parto3').hide();
				$('#div_culminaembarazo_otro3').show();
		  }
		  $('#div_culminaembarazo_parto_cesarea3').hide();
		  $('#div_datos_menor_3').hide();
		  $('#div_laboratorio_menor_3').hide();
		}
	});
	
});

function enabled_datos_menor(nro) {
	tipoparto = $('#txt_culmi_embarazoparto' + nro).val();
	if(tipoparto == "1"){
		$('#div_datos_menor' + nro).show();
		$('#div_laboratorio_menor' + nro).show();
	  
		$('#txtIdTipDocNi' + nro).prop("disabled", false);
		$('#txtNroDocNi' + nro).prop("disabled", false);
		$('#btnNiSearch' + nro).prop("disabled", false);
		  
		$('#txtIdDepNacNi' + nro).prop("disabled", false);
		$('#txtIdTipPacPartiNi' + nro).prop("disabled", false);
		$('#txtNroHCNi' + nro).prop("disabled", false);
		$('#txtPesoNi' + nro).prop("disabled", false);
		$('#txtEGNi' + nro).prop("disabled", false);
		$('#txtAPGARNi' + nro).prop("disabled", false);
		$('#txtFechaDLSNi' + nro + '1').prop("disabled", false);
		$('#txtAsisFechaDLSNi' + nro + '1').prop("disabled", false);
		$('.opt_puncionlumbar' + nro).prop("disabled", false);
		$('.opt_estafinalnino' + nro).prop("disabled", false);
		$('#txtObsNino' + nro).prop("disabled", false);
		//setTimeout(function(){$('#txtNroDocNi').trigger('focus');}, 2);
		$('#div_culminaembarazo_parto_cesarea' + nro).hide();

  } else {
		$('#div_datos_menor' + nro).hide();
		$('#div_laboratorio_menor' + nro).hide();
		$('#div_culminaembarazo_parto_cesarea' + nro).show();
  }
}

function maxlength_doc_bus_ni() {
  
  id_aten = $("#txtIdAtencion").val();
  id_ni = $("#txtIdNino").val();
  if (id_aten == "0"){
	  $("#txtIdNino").val('0');

	  $("#txtNomNi").val('');
	  $("#txtPriApeNi").val('');
	  $("#txtSegApeNi").val('');
	  $("#txtIdSexoNi").val('');
	  $("#txtFecNacNi").val('');

	  $("#txtIdDepNacNi").val('').trigger("change");

	  $("#txtPesoNi").val('');
	  $("#txtEGNi").val('');
	  $("#txtAPGARNi").val('');

	  if ($("#txtIdTipDocNi").val() == "7") {
		$("#txtNroDocNi").val('SD0000000000000');
		$("#txtNroDocNi").prop("disabled", true);
		$("#btnNiSearch").prop("disabled", true);
		$("#txtNroHCNi").prop("disabled", false);
		$("#txtNomNi").prop("readonly", false);
		$("#txtPriApeNi").prop("readonly", false);
		$("#txtSegApeNi").prop("readonly", false);
		$("#txtIdSexoNi").prop("disabled", false);
		$("#txtFecNacNi").prop("disabled", false);
		$("#txtNroHCNi").val('');

		setTimeout(function(){$('#txtPriApeNi').trigger('focus');}, 2);
	  } else {
		$("#txtNroDocNi").val('');
		$("#txtNroDocNi").prop("disabled", false);
		$("#btnNiSearch").prop("disabled", false);
		$("#txtNomNi").prop("readonly", true);
		$("#txtPriApeNi").prop("readonly", true);
		$("#txtSegApeNi").prop("readonly", true);
		$("#txtIdSexoNi").prop("disabled", true);
		$("#txtFecNacNi").prop("disabled", true);

		if ($("#txtIdTipDocNi").val() == "1"){
		  $("#txtNroDocNi").attr('maxlength', '8');
		} else {
		  $("#txtNroDocNi").attr('maxlength', '15');
		}
		setTimeout(function(){$('#txtNroDocNi').trigger('focus');}, 2);
	  }
  } else {
		if (id_ni == "0"){
			$("#txtIdNino").val('0');

			$("#txtNomNi").val('');
			$("#txtPriApeNi").val('');
			$("#txtSegApeNi").val('');
			$("#txtIdSexoNi").val('');
			$("#txtFecNacNi").val('');

			$("#txtIdDepNacNi").val('').trigger("change");

			$("#txtPesoNi").val('');
			$("#txtEGNi").val('');
			$("#txtAPGARNi").val('');

			if ($("#txtIdTipDocNi").val() == "7") {
				$("#txtNroDocNi").val('SD0000000000000');
				$("#txtNroDocNi").prop("disabled", true);
				$("#btnNiSearch").prop("disabled", true);
				$("#txtNroHCNi").prop("disabled", false);
				$("#txtNomNi").prop("readonly", false);
				$("#txtPriApeNi").prop("readonly", false);
				$("#txtSegApeNi").prop("readonly", false);
				$("#txtIdSexoNi").prop("disabled", false);
				$("#txtFecNacNi").prop("disabled", false);
				$("#txtNroHCNi").val('');

				setTimeout(function(){$('#txtPriApeNi').trigger('focus');}, 2);
			} else {
				$("#txtNroDocNi").val('');
				$("#txtNroDocNi").prop("disabled", false);
				$("#btnNiSearch").prop("disabled", false);
				$("#txtNomNi").prop("readonly", true);
				$("#txtPriApeNi").prop("readonly", true);
				$("#txtSegApeNi").prop("readonly", true);
				$("#txtIdSexoNi").prop("disabled", true);
				$("#txtFecNacNi").prop("disabled", true);

				if ($("#txtIdTipDocNi").val() == "1"){
					$("#txtNroDocNi").attr('maxlength', '8');
				} else {
					$("#txtNroDocNi").attr('maxlength', '15');
				}
				setTimeout(function(){$('#txtNroDocNi').trigger('focus');}, 2);
			}
	  } else {
		  if ($("#txtIdTipDocNi").val() == "7") {
			$("#txtNroDocNi").val('SD0000000000000');
			$("#txtNroDocNi").prop("disabled", true);
			$("#btnNiSearch").prop("disabled", true);
		  } else {
			$("#txtNroDocNi").val('');
			$("#txtNroDocNi").prop("disabled", false);
			$("#btnNiSearch").prop("disabled", false);
			setTimeout(function(){$('#txtNroDocNi').trigger('focus');}, 2);
		  }
	  }
  }
}

function maxlength_doc_bus_ni_2() {
  
  id_aten = $("#txtIdAtencion").val();
  id_ni = $("#txtIdNino2").val();
  if (id_aten == "0"){
	  $("#txtIdNino2").val('0');

	  $("#txtNomNi2").val('');
	  $("#txtPriApeNi2").val('');
	  $("#txtSegApeNi2").val('');
	  $("#txtIdSexoNi2").val('');
	  $("#txtFecNacNi2").val('');

	  $("#txtIdDepNacNi2").val('').trigger("change");

	  $("#txtPesoNi2").val('');
	  $("#txtEGNi2").val('');
	  $("#txtAPGARNi2").val('');

	  if ($("#txtIdTipDocNi2").val() == "7") {
		$("#txtNroDocNi2").val('SD0000000000000');
		$("#txtNroDocNi2").prop("disabled", true);
		$("#btnNiSearch2").prop("disabled", true);
		$("#txtNroHCNi2").prop("disabled", false);
		$("#txtNomNi2").prop("readonly", false);
		$("#txtPriApeNi2").prop("readonly", false);
		$("#txtSegApeNi2").prop("readonly", false);
		$("#txtIdSexoNi2").prop("disabled", false);
		$("#txtFecNacNi2").prop("disabled", false);
		$("#txtNroHCNi2").val('');

		setTimeout(function(){$('#txtPriApeNi2').trigger('focus');}, 2);
	  } else {
		$("#txtNroDocNi2").val('');
		$("#txtNroDocNi2").prop("disabled", false);
		$("#btnNiSearch2").prop("disabled", false);
		$("#txtNomNi2").prop("readonly", true);
		$("#txtPriApeNi2").prop("readonly", true);
		$("#txtSegApeNi2").prop("readonly", true);
		$("#txtIdSexoNi2").prop("disabled", true);
		$("#txtFecNacNi2").prop("disabled", true);

		if ($("#txtIdTipDocNi2").val() == "1"){
		  $("#txtNroDocNi2").attr('maxlength', '8');
		} else {
		  $("#txtNroDocNi2").attr('maxlength', '15');
		}
		setTimeout(function(){$('#txtNroDocNi2').trigger('focus');}, 2);
	  }
  } else {
		if (id_ni == "0"){
			$("#txtIdNino2").val('0');

			$("#txtNomNi2").val('');
			$("#txtPriApeNi2").val('');
			$("#txtSegApeNi2").val('');
			$("#txtIdSexoNi2").val('');
			$("#txtFecNacNi2").val('');

			$("#txtIdDepNacNi2").val('').trigger("change");

			$("#txtPesoNi2").val('');
			$("#txtEGNi2").val('');
			$("#txtAPGARNi2").val('');

			if ($("#txtIdTipDocNi2").val() == "7") {
				$("#txtNroDocNi2").val('SD0000000000000');
				$("#txtNroDocNi2").prop("disabled", true);
				$("#btnNiSearch2").prop("disabled", true);
				$("#txtNroHCNi2").prop("disabled", false);
				$("#txtNomNi2").prop("readonly", false);
				$("#txtPriApeNi2").prop("readonly", false);
				$("#txtSegApeNi2").prop("readonly", false);
				$("#txtIdSexoNi2").prop("disabled", false);
				$("#txtFecNacNi2").prop("disabled", false);
				$("#txtNroHCNi2").val('');

				setTimeout(function(){$('#txtPriApeNi2').trigger('focus');}, 2);
			} else {
				$("#txtNroDocNi2").val('');
				$("#txtNroDocNi2").prop("disabled", false);
				$("#btnNiSearch2").prop("disabled", false);
				$("#txtNomNi2").prop("readonly", true);
				$("#txtPriApeNi2").prop("readonly", true);
				$("#txtSegApeNi2").prop("readonly", true);
				$("#txtIdSexoNi2").prop("disabled", true);
				$("#txtFecNacNi2").prop("disabled", true);

				if ($("#txtIdTipDocNi2").val() == "1"){
					$("#txtNroDocNi2").attr('maxlength', '8');
				} else {
					$("#txtNroDocNi2").attr('maxlength', '15');
				}
				setTimeout(function(){$('#txtNroDocNi2').trigger('focus');}, 2);
			}
	  } else {
		  if ($("#txtIdTipDocNi2").val() == "7") {
			$("#txtNroDocNi2").val('SD0000000000000');
			$("#txtNroDocNi2").prop("disabled", true);
			$("#btnNiSearch2").prop("disabled", true);
		  } else {
			$("#txtNroDocNi2").val('');
			$("#txtNroDocNi2").prop("disabled", false);
			$("#btnNiSearch2").prop("disabled", false);
			setTimeout(function(){$('#txtNroDocNi2').trigger('focus');}, 2);
		  }
	  }
  }
}

function maxlength_doc_bus_ni_3() {
  
  id_aten = $("#txtIdAtencion").val();
  id_ni = $("#txtIdNino3").val();
  if (id_aten == "0"){
	  $("#txtIdNino3").val('0');

	  $("#txtNomNi3").val('');
	  $("#txtPriApeNi3").val('');
	  $("#txtSegApeNi3").val('');
	  $("#txtIdSexoNi3").val('');
	  $("#txtFecNacNi3").val('');

	  $("#txtIdDepNacNi3").val('').trigger("change");

	  $("#txtPesoNi3").val('');
	  $("#txtEGNi3").val('');
	  $("#txtAPGARNi3").val('');

	  if ($("#txtIdTipDocNi3").val() == "7") {
		$("#txtNroDocNi3").val('SD0000000000000');
		$("#txtNroDocNi3").prop("disabled", true);
		$("#btnNiSearch3").prop("disabled", true);
		$("#txtNroHCNi3").prop("disabled", false);
		$("#txtNomNi3").prop("readonly", false);
		$("#txtPriApeNi3").prop("readonly", false);
		$("#txtSegApeNi3").prop("readonly", false);
		$("#txtIdSexoNi3").prop("disabled", false);
		$("#txtFecNacNi3").prop("disabled", false);
		$("#txtNroHCNi3").val('');

		setTimeout(function(){$('#txtPriApeNi3').trigger('focus');}, 2);
	  } else {
		$("#txtNroDocNi3").val('');
		$("#txtNroDocNi3").prop("disabled", false);
		$("#btnNiSearch3").prop("disabled", false);
		$("#txtNomNi3").prop("readonly", true);
		$("#txtPriApeNi3").prop("readonly", true);
		$("#txtSegApeNi3").prop("readonly", true);
		$("#txtIdSexoNi3").prop("disabled", true);
		$("#txtFecNacNi3").prop("disabled", true);

		if ($("#txtIdTipDocNi3").val() == "1"){
		  $("#txtNroDocNi3").attr('maxlength', '8');
		} else {
		  $("#txtNroDocNi3").attr('maxlength', '15');
		}
		setTimeout(function(){$('#txtNroDocNi3').trigger('focus');}, 2);
	  }
  } else {
		if (id_ni == "0"){
			$("#txtIdNino3").val('0');

			$("#txtNomNi3").val('');
			$("#txtPriApeNi3").val('');
			$("#txtSegApeNi3").val('');
			$("#txtIdSexoNi3").val('');
			$("#txtFecNacNi3").val('');

			$("#txtIdDepNacNi3").val('').trigger("change");

			$("#txtPesoNi3").val('');
			$("#txtEGNi3").val('');
			$("#txtAPGARNi3").val('');

			if ($("#txtIdTipDocNi3").val() == "7") {
				$("#txtNroDocNi3").val('SD0000000000000');
				$("#txtNroDocNi3").prop("disabled", true);
				$("#btnNiSearch3").prop("disabled", true);
				$("#txtNroHCNi3").prop("disabled", false);
				$("#txtNomNi3").prop("readonly", false);
				$("#txtPriApeNi3").prop("readonly", false);
				$("#txtSegApeNi3").prop("readonly", false);
				$("#txtIdSexoNi3").prop("disabled", false);
				$("#txtFecNacNi3").prop("disabled", false);
				$("#txtNroHCNi3").val('');

				setTimeout(function(){$('#txtPriApeNi3').trigger('focus');}, 2);
			} else {
				$("#txtNroDocNi3").val('');
				$("#txtNroDocNi3").prop("disabled", false);
				$("#btnNiSearch3").prop("disabled", false);
				$("#txtNomNi3").prop("readonly", true);
				$("#txtPriApeNi3").prop("readonly", true);
				$("#txtSegApeNi3").prop("readonly", true);
				$("#txtIdSexoNi3").prop("disabled", true);
				$("#txtFecNacNi3").prop("disabled", true);

				if ($("#txtIdTipDocNi3").val() == "1"){
					$("#txtNroDocNi3").attr('maxlength', '8');
				} else {
					$("#txtNroDocNi3").attr('maxlength', '15');
				}
				setTimeout(function(){$('#txtNroDocNi3').trigger('focus');}, 2);
			}
	  } else {
		  if ($("#txtIdTipDocNi3").val() == "7") {
			$("#txtNroDocNi3").val('SD0000000000000');
			$("#txtNroDocNi3").prop("disabled", true);
			$("#btnNiSearch3").prop("disabled", true);
		  } else {
			$("#txtNroDocNi3").val('');
			$("#txtNroDocNi3").prop("disabled", false);
			$("#btnNiSearch3").prop("disabled", false);
			setTimeout(function(){$('#txtNroDocNi3').trigger('focus');}, 2);
		  }
	  }
  }
}

function buscar_datos_personales_ni(nro){
	var msg = "";
	var sw = true;
	var txtIdTipDoc = "";
	var txtNroDoc = "";
	var txtNroDocLn = "";

	$('#txtIdNi' + nro).val('0');
	txtIdTipDoc = $('#txtIdTipDocNi' + nro).val();
	txtNroDoc = $('#txtNroDocNi' + nro).val();
	txtNroDocLn = txtNroDoc.length;

	if (txtIdTipDoc == "1") {
		if (txtNroDocLn != 8) {
			msg += "Ingrese el Nro. de documento correctamente (8 digitos)<br/>"; sw = false;
		}

		if(validateNumber(txtNroDoc) == "0"){
			msg += "Ingrese el Nro. de documento correctamente (Digitar valores numéricos)<br/>"; sw = false;
		}
	} else if(txtIdTipDoc == "2" || txtIdTipDoc == "4"){
		if (txtNroDocLn <= 5) {
			msg += "Ingrese el Nro. de documento correctamente<br/>"; sw = false;
		}
	} else {
		if (txtNroDocLn <= 8) {
			msg += "Ingrese el Nro. de documento correctamente<br/>"; sw = false;
		}
	}

	if (sw == false) {
		bootbox.alert(msg);
		$('#btnNiSearch' + nro).prop("disabled", false);	return false;
	}

	$('#btnNiSearch' + nro).prop("disabled", true);
  $.ajax({
    url: "../../controller/ctrlPersona.php",
    type: "POST",
    dataType: 'json',
    data: {
      accion: 'GET_SHOW_PERSONULTIMAATENCIONPORIDDEP', txtIdTipDoc: txtIdTipDoc, txtNroDoc: txtNroDoc
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
		$("#txtIdNi" + nro).val(datos[0]);
		if(datos[0] == "E"){
			$("#txtIdNi" + nro).val('0');
			bootbox.alert({
				message: "No se encontró el DNI en consulta RENIEC, verifíque por favor.",
				callback: function () {
					setTimeout(function(){$('#txtNroDocNi' + nro).trigger('focus');}, 2);
				}
			});
		} else if(datos[0] == "C"){
			$('#txtIdSexoNi' + nro).prop("disabled", false);
			$('#txtNomNi' + nro).prop("readonly", false);
			$('#txtPriApeNi' + nro).prop("readonly", false);
			$('#txtSegApeNi' + nro).prop("readonly", false);
			$('#txtFecNacNi' + nro).prop("disabled", false);
			$("#txtIdNi" + nro).val('0');
			bootbox.alert({
				message: "El servicio de consulta RENIEC no está disponible, por favor ingrese los datos manualmente...",
				callback: function () {
					setTimeout(function(){$('#txtNroHCNi' + nro).trigger('focus');}, 2);
				}
			});
		} else if((datos[4] == null) || (datos[4] == "")){
			$('#txtIdSexoNi' + nro).prop("disabled", false);
			$('#txtNomNi' + nro).prop("readonly", false);
			$('#txtPriApeNi' + nro).prop("readonly", false);
			$('#txtSegApeNi' + nro).prop("readonly", false);
			$('#txtFecNacNi' + nro).prop("disabled", false);
			$("#txtNroHCNi" + nro).trigger('focus');
		} else {
			$("#txtNomNi" + nro).val(datos[4]);
			$("#txtPriApeNi" + nro).val(datos[5]);
			$("#txtSegApeNi" + nro).val(datos[6]);
			$("#txtIdSexoNi" + nro).val(datos[7]);
			$("#txtFecNacNi" + nro).val(datos[9]);
			$("#txtNroHCNi" + nro).val(datos[10]);
			$('#txtNomNi' + nro).prop("readonly", true);
			$('#txtPriApeNi' + nro).prop("readonly", true);
			$('#txtSegApeNi' + nro).prop("readonly", true);
			$('#txtIdSexoNi' + nro).prop("disabled", true);
			$('#txtFecNacNi' + nro).prop("disabled", true);
			if(datos[9] == ""){
				$('#txtFecNacNi' + nro).prop("disabled", false);
			}
			if(datos[10] == ""){
				$('#txtNroHCPac' + nro).prop("readonly", false);
				$("#txtNroHCPac" + nro).trigger('focus');
			}
		}
		$('#btnNiSearch' + nro).prop("disabled", false);
    }
  });
}

function enabled_datos_menoredit(e_tipodocmenor) {
	$('#div-datos-menor').show();
	$('#txtIdTipDocNi').prop("disabled", false);
	$('#txtNroDocNi').prop("disabled", true);
	$('#btnNiSearch').prop("disabled", true);
	if (e_tipodocmenor == "7"){
		$("#txtNomNi").prop("readonly", false);
		$("#txtPriApeNi").prop("readonly", false);
		$("#txtSegApeNi").prop("readonly", false);
		$("#txtIdSexoNi").prop("disabled", false);
		$("#txtFecNacNi").prop("disabled", false);
	} else {
		$("#txtNomNi").prop("readonly", true);
		$("#txtPriApeNi").prop("readonly", true);
		$("#txtSegApeNi").prop("readonly", true);
		$("#txtIdSexoNi").prop("disabled", true);
		$("#txtFecNacNi").prop("disabled", true);		
	}
	  
	  $('#txtIdDepNacNi').prop("disabled", false);
	  $('#txtIdTipPacPartiNi').prop("disabled", false);
	  $('#txtNroHCNi').prop("disabled", false);
	  $('#txtPesoNi').prop("disabled", false);
	  $('#txtEGNi').prop("disabled", false);
	  $('#txtAPGARNi').prop("disabled", false);
	  $('#txtFechaDLSNi1').prop("disabled", false);
	  $('#txtAsisFechaDLSNi1').prop("disabled", false);
	  $('.opt_puncionlumbar').prop("disabled", false);
	  $('.opt_estafinalnino').prop("disabled", false);
	  $('#txtObsNino').prop("disabled", false);
}
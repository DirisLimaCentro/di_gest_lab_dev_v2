function enabled_datos_documento() {
  $('#txtIdTipDocPac').prop("disabled", false);
  $('#txtNroDocPac').prop("disabled", false);
  //$('#btnPacSearch').prop("disabled", false);
  //$("#txtIdPaisNacPac").val('').trigger("change");
}

function enabled_datos_sifilis() {
	$('#div-datos-atencion').show();

	$('#txtFechaPruRapLab').prop("disabled", false);
	$('#txt_fectpha').prop("disabled", false);
	$('#txtFechaDLS1').prop("disabled", false);
	$('#txtAsisFechaDLS1').prop("disabled", false);
	$('.opt_alergicopene').prop("disabled", false);
	$('#txtFechaDosisPac1').prop("disabled", false);
	$('#txtAsisDosisPac1').prop("disabled", false);
	$('#txt_nro_contacto_si').prop("disabled", false);
	$('#txt_nro_contacto_no').prop("disabled", false);
	$('#txt_nro_contacto_des').prop("disabled", false);
	$('#txtObsMadre').prop("disabled", false);

	espuerpera = document.frmSolicitud.txtEstadoPac.value;
	if(espuerpera == "1"){
		$('#txt_tipoCulmiEmbarazo1').prop("disabled", false);
		$('#txt_tipoCulmiEmbarazo2').prop("disabled", false);
	} else {
		$('#txt_tipoCulmiEmbarazo1').prop("disabled", false);
		$('#txt_tipoCulmiEmbarazo2').prop("disabled", true);	  
	}
}

function enabled_datos_alegicapenecilina() {
	pacalergica = document.frmSolicitud.txt_alergicopene.value;
	if(pacalergica == "1"){//Si es alegica
		$('#datos-si-alergica').show();
		$('#datos-no-alergica').hide();
		$('#txtFechaPruSensi').prop("disabled", false);
		$('#txtFechaDesensi').prop("disabled", false);
		$('.opt_pruebarefere').prop("disabled", false);
	} else {
		$('#datos-no-alergica').show();
		$('#datos-si-alergica').hide();
		$('#txtFechaPruSensi').prop("disabled", true);
		$('#txtFechaDesensi').prop("disabled", true);
		$('.opt_pruebarefere').prop("disabled", true);
	}
}

function enabled_datos_tratamientofinalalegicapenecilina() {
	pacalergica = document.frmSolicitud.txt_alergicopenetrata.value;
	if(pacalergica == "1"){
		$('#datos-alergia-sifilis-tratamientopenecilina').show();
		$('#datos-alergia-sifilis-tratamientootro').hide();
		setTimeout(function(){$('#txt_fec_1radosis_hosp').trigger('focus');}, 2);
	} else {
		$('#datos-alergia-sifilis-tratamientopenecilina').hide();
		$('#datos-alergia-sifilis-tratamientootro').show();
		setTimeout(function(){$('#txtDetOtroTrata').trigger('focus');}, 2);			
	}
}
		

$(function() {
	
    $('[name="txtEstadoPac"]').change(function(){
      if ($(this).is(':checked')) {
        if($(this).val() == "1"){
          $('#datos-puerpera').hide();
          $('#datos-gestante').show();
		  $('#txt_fpp').prop("disabled", false);
        } else {
          $('#datos-puerpera').show();
          $('#datos-gestante').hide();
		  $('#txt_fpp').prop("disabled", true);
        }
        $("#txt_fur").val('');
        $("#txt_fpp").val('');
        $("#txtFechaCPN").val('');
        $("#txtEGCPN").val('');
		$('#txt_fur').prop("disabled", false);
        $('#txtFechaCPN').prop("disabled", false);
        $('#txtEGCPN').prop("disabled", false);
		$('#txtIPRESDiag').prop("disabled", false);
		$('#txtDetIPRESDiag').prop("disabled", false);
		$('.opt_diagnostico').prop("disabled", false);
		$('.chk_fur').prop("disabled", false);
		$(".chk_fur").prop('checked', false);
		$('.chk_fechacpn').prop("disabled", false);
		$(".chk_fechacpn").prop('checked', false);
		
		enabled_datos_sifilis();
		
		setTimeout(function(){$('#txt_fur').trigger('focus');}, 3);
      }
    });
		
    $('[name="txtDiagnostico"]').change(function(){
      if ($(this).is(':checked')) {
		if($(this).val() == "1"){
		  $('#txt_aniodx').prop("disabled", false);
		  $('.opt_tratamientodx').prop("disabled", false);
		  $('#txtEGAPNDiag').prop("disabled", true);
		  setTimeout(function(){$('#txt_aniodx').trigger('focus');}, 2);
        } else if($(this).val() == "2"){
			$('#txt_aniodx').prop("disabled", true);
			$('.opt_tratamientodx').prop("disabled", true);
			$('#txtEGAPNDiag').prop("disabled", false);
        } else {
			$('#txt_aniodx').prop("disabled", true);
			$('#txtEGAPNDiag').prop("disabled", true);
        }
		$(".opt_tratamientodx").prop('checked', false);
		$("#txt_aniodx").val('');
        $("#txtEGAPNDiag").val('');
      }
    });
	
	
    $('[name="txt_alergicopene"]').change(function(){
      if ($(this).is(':checked')) {
        if($(this).val() == "1"){
			$('#datos-si-alergica').show();
			$('#datos-no-alergica').hide();
			$('#txtFechaPruSensi').prop("disabled", false);
			$('#txtFechaDesensi').prop("disabled", false);
			$(".opt_pruebarefere").prop('disabled', false);
        } else {
          $('#datos-no-alergica').show();
          $('#datos-si-alergica').hide();
			$('#txtFechaPruSensi').prop("disabled", true);
			$('#txtFechaDesensi').prop("disabled", true);
			$(".opt_pruebarefere").prop('disabled', true);		  
        }
      }
    });

  $('[name="txt_alergicopenetrata"]').change(function(){
    if ($(this).is(':checked')) {
        if($(this).val() == "1"){
			$('#datos-alergia-sifilis-tratamientopenecilina').show();
			$('#datos-alergia-sifilis-tratamientootro').hide();
			setTimeout(function(){$('#txt_fec_1radosis_hosp').trigger('focus');}, 2);
        } else {
			$('#datos-alergia-sifilis-tratamientopenecilina').hide();
			$('#datos-alergia-sifilis-tratamientootro').show();
			setTimeout(function(){$('#txtDetOtroTrata').trigger('focus');}, 2);			
		}
    }
  });

  $('#txtAsisFechaDLS1').change(function() {
    if ($(this).is(':checked')) {
		if($('#txtFechaDLS1').val() == ""){
			$("#txtAsisFechaDLS1").prop('checked', false);
			setTimeout(function(){$('#txtFechaDLS1').trigger('focus');}, 2);
		} else {
			$("#txtNroDLS1").prop('disabled', false);
			$("#txtFechaDLS1").prop('disabled', true);
			nfec = calcular_fecha($('#txtFechaDLS1').val(),90);
			$('#txtFechaDLS2').val(nfec);
			$("#txtFechaDLS2").prop('disabled', false);
			$("#txtAsisFechaDLS2").prop('disabled', false);
			setTimeout(function(){$('#txtNroDLS1').trigger('focus');}, 3);
		}
    } else {
		$("#txtFechaDLS1").prop('disabled', false);
		setTimeout(function(){$('#txtFechaDLS1').trigger('focus');}, 2);
	}
  });
  
  $('#txtAsisFechaDLS2').change(function() {
    if ($(this).is(':checked')) {
		if($('#txtFechaDLS2').val() == ""){
			$("#txtAsisFechaDLS2").prop('checked', false);
			setTimeout(function(){$('#txtFechaDLS2').trigger('focus');}, 2);
		} else {
			$("#txtNroDLS2").prop('disabled', false);
			$("#txtFechaDLS2").prop('disabled', true);
			nfec = calcular_fecha($('#txtFechaDLS2').val(),90);
			$('#txtFechaDLS3').val(nfec);
			$("#txtFechaDLS3").prop('disabled', false);
			$("#txtAsisFechaDLS3").prop('disabled', false);
			setTimeout(function(){$('#txtNroDLS2').trigger('focus');}, 3);
		}
    } else {
		$("#txtFechaDLS2").prop('disabled', false);
		setTimeout(function(){$('#txtFechaDLS2').trigger('focus');}, 2);
	}
  });
    
  $('#txtAsisFechaDLS3').change(function() {
    if ($(this).is(':checked')) {
		if($('#txtFechaDLS3').val() == ""){
			$("#txtAsisFechaDLS3").prop('checked', false);
			setTimeout(function(){$('#txtFechaDLS3').trigger('focus');}, 2);
		} else {
			$("#txtNroDLS3").prop('disabled', false);
			$("#txtFechaDLS3").prop('disabled', true);
			setTimeout(function(){$('#txtNroDLS3').trigger('focus');}, 3);
		}
    } else {
		$("#txtFechaDLS3").prop('disabled', false);
		setTimeout(function(){$('#txtFechaDLS3').trigger('focus');}, 2);
	}
  });  

  $('#txtAsisDosisPac1').change(function() {
    if ($(this).is(':checked')) {
		if($('#txtFechaDosisPac1').val() == ""){
			$("#txtAsisDosisPac1").prop('checked', false);
			setTimeout(function(){$('#txtFechaDosisPac1').trigger('focus');}, 2);
		} else {
			$("#txtFechaDosisPac1").prop('disabled', true);
			nfec = calcular_fecha($('#txtFechaDosisPac1').val(),7);
			$('#txtFechaDosisPac2').val(nfec);
			$("#txtFechaDosisPac2").prop('disabled', false);
			$("#txtAsisDosisPac2").prop('disabled', false);
		}
    } else {
		$("#txtFechaDosisPac1").prop('disabled', false);
		setTimeout(function(){$('#txtFechaDosisPac1').trigger('focus');}, 2);
	}
  });

  $('#txtAsisDosisPac2').change(function() {
    if ($(this).is(':checked')) {
		if($('#txtFechaDosisPac2').val() == ""){
			$("#txtAsisDosisPac2").prop('checked', false);
			setTimeout(function(){$('#txtFechaDosisPac2').trigger('focus');}, 2);
		} else {
			$("#txtFechaDosisPac2").prop('disabled', true);
			nfec = calcular_fecha($('#txtFechaDosisPac2').val(),7);
			$('#txtFechaDosisPac3').val(nfec);
			$("#txtFechaDosisPac3").prop('disabled', false);
			$("#txtAsisDosisPac3").prop('disabled', false);
		}
    } else {
		$("#txtFechaDosisPac2").prop('disabled', false);
		setTimeout(function(){$('#txtFechaDosisPac2').trigger('focus');}, 2);
	}
  });

  $('#txtAsisDosisPac3').change(function() {
    if ($(this).is(':checked')) {
		if($('#txtFechaDosisPac3').val() == ""){
			$("#txtAsisDosisPac3").prop('checked', false);
			setTimeout(function(){$('#txtFechaDosisPac3').trigger('focus');}, 2);
		} else {
			$("#txtFechaDosisPac3").prop('disabled', true);
		}
    } else {
		$("#txtFechaDosisPac3").prop('disabled', false);
		setTimeout(function(){$('#txtFechaDosisPac3').trigger('focus');}, 2);
	}
  });
 
  $('#txt_asis_dosistratapene_hosp1').change(function() {
    if ($(this).is(':checked')) {
		if($('#txt_fec_1radosis_hosp').val() == ""){
			$("#txt_asis_dosistratapene_hosp1").prop('checked', false);
			setTimeout(function(){$('#txt_fec_1radosis_hosp').trigger('focus');}, 2);
		} else {
			$("#txt_fec_1radosis_hosp").prop('disabled', true);
		}
    } else {
		$("#txt_fec_1radosis_hosp").prop('disabled', false);
		setTimeout(function(){$('#txt_fec_1radosis_hosp').trigger('focus');}, 2);
	}
  });
 
  $('#txt_asis_dosistratapene_hosp2').change(function() {
    if ($(this).is(':checked')) {
		if($('#txt_fec_2dadosis_hosp').val() == ""){
			$("#txt_asis_dosistratapene_hosp2").prop('checked', false);
			setTimeout(function(){$('#txt_fec_2dadosis_hosp').trigger('focus');}, 2);
		} else {
			$("#txt_fec_2dadosis_hosp").prop('disabled', true);
		}
    } else {
		$("#txt_fec_2dadosis_hosp").prop('disabled', false);
		setTimeout(function(){$('#txt_fec_2dadosis_hosp').trigger('focus');}, 2);
	}
  });
 
  $('#txt_asis_dosistratapene_hosp3').change(function() {
    if ($(this).is(':checked')) {
		if($('#txt_fec_3radosis_hosp').val() == ""){
			$("#txt_asis_dosistratapene_hosp3").prop('checked', false);
			setTimeout(function(){$('#txt_fec_3radosis_hosp').trigger('focus');}, 2);
		} else {
			$("#txt_fec_3radosis_hosp").prop('disabled', true);
		}
    } else {
		$("#txt_fec_3radosis_hosp").prop('disabled', false);
		setTimeout(function(){$('#txt_fec_3radosis_hosp').trigger('focus');}, 2);
	}
  });

	$('[name="txt_trataadecuado"]').change(function(){
		if ($(this).is(':checked')) {
			if($(this).val() == "2"){
				$("#div_trataadeciadono").show();
			} else {
				$("#div_trataadeciadono").hide();
			}
		}
	});
  

  $('[name="check_nro_contacto_1"]').change(function(){
    if ($(this).is(':checked')) {
		$("#txt_nro_contacto_1").prop('disabled', false);
		setTimeout(function(){$('#txt_nro_contacto_1').trigger('focus');}, 2);
    } else {
		$("#txt_nro_contacto_1").prop('disabled', true);
	}
  });

  $('[name="check_nro_contacto_2"]').change(function(){
    if ($(this).is(':checked')) {
		$("#txt_nro_contacto_2").prop('disabled', false);
		setTimeout(function(){$('#txt_nro_contacto_2').trigger('focus');}, 2);
    } else {
		$("#txt_nro_contacto_2").prop('disabled', true);
	}
  });
  
  $('[name="check_nro_contacto_0"]').change(function(){
    if ($(this).is(':checked')) {
		$("#txt_nro_contacto_0").prop('disabled', false);
		setTimeout(function(){$('#txt_nro_contacto_0').trigger('focus');}, 2);
    } else {
		$("#txt_nro_contacto_0").prop('disabled', true);
	}
  });

	$('#txtAsisFechaDLSNi1').change(function() {
	if ($(this).is(':checked')) {
		if($('#txtFechaDLSNi1').val() == ""){
			$("#txtAsisFechaDLSNi1").prop('checked', false);
			setTimeout(function(){$('#txtFechaDLSNi1').trigger('focus');}, 2);
		} else {
			$("#txtFechaDLSNi1").prop('disabled', true);
			$("#txtFechaDLSNi2").prop('disabled', false);
			$("#txtAsisFechaDLSNi2").prop('disabled', false);
			$("#txtNroDLSNi1").prop('disabled', false);
			setTimeout(function(){$('#txtNroDLSNi1').trigger('focus');}, 2);
		}
	} else {
		$("#txtFechaDLSNi1").prop('disabled', false);
		setTimeout(function(){$('#txtFechaDLSNi1').trigger('focus');}, 2);
	}
	});

	$('#txtAsisFechaDLSNi21').change(function() {
	if ($(this).is(':checked')) {
		if($('#txtFechaDLSNi21').val() == ""){
			$("#txtAsisFechaDLSNi21").prop('checked', false);
			setTimeout(function(){$('#txtFechaDLSNi21').trigger('focus');}, 2);
		} else {
			$("#txtFechaDLSNi21").prop('disabled', true);
			$("#txtFechaDLSNi22").prop('disabled', false);
			$("#txtAsisFechaDLSNi22").prop('disabled', false);
			$("#txtNroDLSNi21").prop('disabled', false);
			setTimeout(function(){$('#txtNroDLSNi21').trigger('focus');}, 2);
		}
	} else {
		$("#txtFechaDLSNi21").prop('disabled', false);
		setTimeout(function(){$('#txtFechaDLSNi21').trigger('focus');}, 2);
	}
	});

	$('#txtAsisFechaDLSNi31').change(function() {
	if ($(this).is(':checked')) {
		if($('#txtFechaDLSNi31').val() == ""){
			$("#txtAsisFechaDLSNi31").prop('checked', false);
			setTimeout(function(){$('#txtFechaDLSNi31').trigger('focus');}, 2);
		} else {
			$("#txtFechaDLSNi31").prop('disabled', true);
			$("#txtFechaDLSNi32").prop('disabled', false);
			$("#txtAsisFechaDLSNi32").prop('disabled', false);
			$("#txtNroDLSNi31").prop('disabled', false);
			setTimeout(function(){$('#txtNroDLSNi31').trigger('focus');}, 2);
		}
	} else {
		$("#txtFechaDLSNi31").prop('disabled', false);
		setTimeout(function(){$('#txtFechaDLSNi31').trigger('focus');}, 2);
	}
	});

	$('#txtAsisFechaDLSNi2').change(function() {
		if ($(this).is(':checked')) {
			if($('#txtFechaDLSNi2').val() == ""){
				$("#txtAsisFechaDLSNi2").prop('checked', false);
				setTimeout(function(){$('#txtFechaDLSNi2').trigger('focus');}, 2);
			} else {
				$("#txtFechaDLSNi2").prop('disabled', true);
				$("#txtNroDLSNi2").prop('disabled', false);
				setTimeout(function(){$('#txtNroDLSNi2').trigger('focus');}, 2);
			}
		} else {
			$("#txtFechaDLSNi2").prop('disabled', false);
			setTimeout(function(){$('#txtFechaDLSNi2').trigger('focus');}, 2);
		}
	});

	$('#txtAsisFechaDLSNi22').change(function() {
		if ($(this).is(':checked')) {
			if($('#txtFechaDLSNi22').val() == ""){
				$("#txtAsisFechaDLSNi22").prop('checked', false);
				setTimeout(function(){$('#txtFechaDLSNi22').trigger('focus');}, 2);
			} else {
				$("#txtFechaDLSNi22").prop('disabled', true);
				$("#txtNroDLSNi22").prop('disabled', false);
				setTimeout(function(){$('#txtNroDLSNi22').trigger('focus');}, 2);
			}
		} else {
			$("#txtFechaDLSNi22").prop('disabled', false);
			setTimeout(function(){$('#txtFechaDLSNi22').trigger('focus');}, 2);
		}
	});

	$('#txtAsisFechaDLSNi32').change(function() {
		if ($(this).is(':checked')) {
			if($('#txtFechaDLSNi32').val() == ""){
				$("#txtAsisFechaDLSNi32").prop('checked', false);
				setTimeout(function(){$('#txtFechaDLSNi32').trigger('focus');}, 2);
			} else {
				$("#txtFechaDLSNi32").prop('disabled', true);
				$("#txtNroDLSNi32").prop('disabled', false);
				setTimeout(function(){$('#txtNroDLSNi32').trigger('focus');}, 2);
			}
		} else {
			$("#txtFechaDLSNi32").prop('disabled', false);
			setTimeout(function(){$('#txtFechaDLSNi32').trigger('focus');}, 2);
		}
	});
	  
	$('[name="txt_puncionlumbar"]').change(function(){
		if ($(this).is(':checked')) {
		  if($(this).val() == "1"){
			$('#txtFechaPuncionNi').prop("disabled", false);
			$('#txtResulPuncionNi').prop("disabled", false);
			setTimeout(function(){$('#txtFechaPuncionNi').trigger('focus');}, 2);
		  } else {
			$('#txtFechaPuncionNi').prop("disabled", true);
			$('#txtResulPuncionNi').prop("disabled", true);
		  }
		  $("#txtFechaPuncionNi").val('');
		  $("#txtResulPuncionNi").val('');
		}
	});
	  
	$('[name="txt_puncionlumbar2"]').change(function(){
		if ($(this).is(':checked')) {
		  if($(this).val() == "1"){
			$('#txtFechaPuncionNi2').prop("disabled", false);
			$('#txtResulPuncionNi2').prop("disabled", false);
			setTimeout(function(){$('#txtFechaPuncionNi2').trigger('focus');}, 2);
		  } else {
			$('#txtFechaPuncionNi2').prop("disabled", true);
			$('#txtResulPuncionNi2').prop("disabled", true);
		  }
		  $("#txtFechaPuncionNi2").val('');
		  $("#txtResulPuncionNi2").val('');
		}
	});
	  
	$('[name="txt_puncionlumbar3"]').change(function(){
		if ($(this).is(':checked')) {
		  if($(this).val() == "1"){
			$('#txtFechaPuncionNi3').prop("disabled", false);
			$('#txtResulPuncionNi3').prop("disabled", false);
			setTimeout(function(){$('#txtFechaPuncionNi3').trigger('focus');}, 2);
		  } else {
			$('#txtFechaPuncionNi3').prop("disabled", true);
			$('#txtResulPuncionNi3').prop("disabled", true);
		  }
		  $("#txtFechaPuncionNi3").val('');
		  $("#txtResulPuncionNi3").val('');
		}
	});
	
	$('[name="txt_tratamientomenor"]').change(function(){
		if ($(this).is(':checked')) {
			if($(this).val() == "1"){
				$('#div_tratamientomenor').show();
			} else {
				$('#div_tratamientomenor').hide();
			}
		}
	});
	
	$('[name="txt_tratamientomenor2"]').change(function(){
		if ($(this).is(':checked')) {
			if($(this).val() == "1"){
				$('#div_tratamientomenor2').show();
			} else {
				$('#div_tratamientomenor2').hide();
			}
		}
	});
	
	$('[name="txt_tratamientomenor3"]').change(function(){
		if ($(this).is(':checked')) {
			if($(this).val() == "1"){
				$('#div_tratamientomenor3').show();
			} else {
				$('#div_tratamientomenor3').hide();
			}
		}
	});

	$('[name="txtEstFinalNino"]').change(function(){
		if ($(this).is(':checked')) {
			if($(this).val() == "3"){
				$('#datos-nino-fallecido').show();
				setTimeout(function(){$('#txtFechaNiFalle').trigger('focus');}, 2);
			} else {
				$('#datos-nino-fallecido').hide();
			}
		}
	});

	$('[name="txtEstFinalNino2"]').change(function(){
		if ($(this).is(':checked')) {
			if($(this).val() == "3"){
				$('#datos-nino-fallecido-2').show();
				setTimeout(function(){$('#txtFechaNiFalle2').trigger('focus');}, 2);
			} else {
				$('#datos-nino-fallecido-2').hide();
			}
		}
	});
	
	$('[name="txtEstFinalNino3"]').change(function(){
		if ($(this).is(':checked')) {
			if($(this).val() == "3"){
				$('#datos-nino-fallecido-3').show();
				setTimeout(function(){$('#txtFechaNiFalle3').trigger('focus');}, 2);
			} else {
				$('#datos-nino-fallecido-3').hide();
			}
		}
	});	
});

function save_atencion() {
  //$('#btnValidForm').prop("disabled", true);
	var msg = "";
	var sw = true;

	var id_paciente = $('#txtIdPac').val();
	var id_tipopaciente = document.frmSolicitud.txtTipPac.value;
	var id_tipopacienteprivado = $('#txtIdTipPacParti').val();
	var id_tipodocpac = $('#txtIdTipDocPac').val();
	var nro_docpac = $('#txtNroDocPac').val();
    var nom_pac = $('#txtNomPac').val();
    var primer_apepac = $('#txtPriApePac').val();
    var segundo_apepac = $('#txtSegApePac').val();
    var id_sexopac = $('#txtIdSexoPac').val();
    var fec_nacpac = $('#txtFecNacPac').val();

	if(id_paciente == "0"){
		if(id_sexopac == ""){
		  msg+= "Seleccione el sexo del Paciente<br/>"; sw = false;
		}
		if(fec_nacpac == ""){
		  msg+= "Ingrese fecha de nacimiento del Paciente<br/>"; sw = false;
		}
		if(nom_pac == ""){
		  msg+= "Ingrese nombre del Paciente<br/>"; sw = false;
		}
		if(primer_apepac == ""){
		  if(segundo_apepac == ""){
			msg+= "Ingrese el apellido paterno o materno del Paciente<br/>"; sw = false;
		  }
		}
	} else {
		if(fec_nacpac == ""){
		  msg+= "Ingrese fecha de nacimiento del Paciente<br/>"; sw = false;
		}
	}

	var nro_hcpac = $('#txtNroHCPac').val();
	var id_paisnacpac = $('#txtIdPaisNacPac').val();
	var id_etniapac = $('#txtIdEtniaPac').val();
	var id_ubigeopac = $('#txtUBIGEOPac').val();
	var direccion_pac = $('#txtDirPac').val();
	var ref_dirpac = $('#txtDirRefPac').val();
	var nro_telfipac = $('#txtNroTelFijoPac').val();
	var nro_telmopac = $('#txtNroTelMovilPac').val();
	var email_pac = $('#txtEmailPac').val();

	if(id_paisnacpac == ""){
		msg+= "Seleccione país de nacimiento del Paciente<br/>"; sw = false;
	}
	if(id_etniapac == ""){
		msg+= "Seleccione Etnia del Paciente<br/>"; sw = false;
	}
	if(nro_hcpac == ""){
		msg+= "Ingrese historia clínica del Paciente<br/>";	sw = false;
	}
	if(nro_telfipac != ""){
		var nro_telfipac = nro_telfipac.length;
		if(nro_telfipac < 7){
			msg+= "Ingrese correctamente el número de teléfono fijo de la Paciente<br/>"; sw = false;
		}
	}
	if(nro_telmopac != ""){
		var nro_telmopac = nro_telmopac.length;
		if(nro_telmopac < 9){
			msg+= "Ingrese correctamente el número de teléfono móvil de la Paciente<br/>"; sw = false;
		}
	}
	if(id_ubigeopac == ""){
		msg+= "Seleccione el Distrio de la dirección de la Paciente<br/>"; sw = false;
	}
	if(email_pac != ""){
		if(validateEmail(email_pac) === false){
			msg+= "Ingrese correctamente el email del Paciente<br/>"; sw = false;
		};
	}

	//Datos de atención
	var id_tiposeguimiento = document.frmSolicitud.txtEstadoPac.value;
	var fur_pac = document.frmSolicitud.txt_fur.value;
	var chk_fur = "";
	if ($("#chk_fur").is(':checked')) chk_fur = "1";
	var fpp_pac = document.frmSolicitud.txt_fpp.value;
	var fec_cpn = document.frmSolicitud.txtFechaCPN.value;
	var chk_fechacpn = "";
	if ($("#chk_fechacpn").is(':checked')) chk_fechacpn = "1";	
	var eg_cpn = document.frmSolicitud.txtEGCPN.value;
	var id_ipressdiag = document.frmSolicitud.txtIPRESDiag.value;
	var det_ipressdiag = document.frmSolicitud.txtDetIPRESDiag.value;
	var chk_gestmultiple = document.frmSolicitud.txt_gestmultiple.value;

	if(id_tiposeguimiento == ""){
		msg+= "Seleccione tipo de seguimiento <b>GESTANTE o PUÉRPERA</b><br/>"; sw = false;
	}
	if(id_tiposeguimiento == "1"){
		if(fpp_pac == ""){
		  msg+= "Ingrese <b>FPP</b><br/>"; sw = false;
		}
	}
	
	if(chk_fur == "1"){
		if(fur_pac == ""){
		  msg+= "Ingrese <b>FUR</b><br/>"; sw = false;
		}
	}
	
	if(chk_fechacpn == "1"){
		if(fec_cpn == ""){
		  msg+= "Ingrese <b>FECHA DE CPN</b><br/>"; sw = false;
		}
	}

    if(eg_cpn == ""){
      msg+= "Seleccione <b>EDAD GESTACIONAL</b><br/>"; sw = false;
    }
	
    if(id_ipressdiag == ""){
      msg+= "Seleccione <b>IPRESS DONDE FUE DIÁGNOSTICADA</b><br/>"; sw = false;
    }
    if(chk_gestmultiple == ""){
		msg+= "Seleccione <b>SI LA PACIENTE TIENE MULTIPLE GENTACIÓN</b><br/>"; sw = false;
	}
	

	//Datos momento del diagnostico
	var id_momentodiag = document.frmSolicitud.txtDiagnostico.value;
	var anio_diagprevio = document.frmSolicitud.txt_aniodx.value;
	var chk_diagpreviotratamiento = document.frmSolicitud.txt_tratamientodx.value;
	var eg_apnmomentodiag = document.frmSolicitud.txtEGAPNDiag.value;

	//Datos Laboratorio
	var fec_pruebarapida = document.frmSolicitud.txtFechaPruRapLab.value;
	var fec_tpha = document.frmSolicitud.txt_fectpha.value;
	var fec_dils1 = document.frmSolicitud.txtFechaDLS1.value;
	var nro_dils1 = document.frmSolicitud.txtNroDLS1.value;
	var chk_dils1 = "";
	if($("#txtAsisFechaDLS1").is(':checked')) chk_dils1 = "1";
	var fec_dils2 = document.frmSolicitud.txtFechaDLS2.value;
	var nro_dils2 = document.frmSolicitud.txtNroDLS2.value;
	var chk_dils2 = "";
	if($("#txtAsisFechaDLS2").is(':checked')) chk_dils2 = "2";
	var fec_dils3 = document.frmSolicitud.txtFechaDLS3.value;
	var nro_dils3 = document.frmSolicitud.txtNroDLS3.value;
	var chk_dils3 = "";
	if($("#txtAsisFechaDLS3").is(':checked')) chk_dils3 = "3";

	if(fec_pruebarapida == ""){
		msg+= "Ingrese <b>FECHA DE PRUEBA PÁPIDA</b><br/>";	sw = false;
	}

	//Datos de Manejo de SIFILIS
	var chk_pacalergica = document.frmSolicitud.txt_alergicopene.value;

	var fec_pacnoalerdosis1 = document.frmSolicitud.txtFechaDosisPac1.value;
	var chk_pacnoalerdosis1 = "";
	if($("#txtAsisDosisPac1").is(':checked')) chk_pacnoalerdosis1 = "1";
	var fec_pacnoalerdosis2 = document.frmSolicitud.txtFechaDosisPac2.value;
	var chk_pacnoalerdosis2 = "";
	if($("#txtAsisDosisPac2").is(':checked')) chk_pacnoalerdosis2 = "2";
	var fec_pacnoalerdosis3 = document.frmSolicitud.txtFechaDosisPac3.value;
	var chk_pacnoalerdosis3 = "";
	if($("#txtAsisDosisPac3").is(':checked')) chk_pacnoalerdosis3 = "3";

	var fec_pacalerprusensi = document.frmSolicitud.txtFechaPruSensi.value;
	var fec_pacalerprudesensi = document.frmSolicitud.txtFechaDesensi.value;
	var chk_pacalerprudesensirefe = document.frmSolicitud.txtPruebaSenciRefe.value;

	var chk_pacalertratamientofinal = document.frmSolicitud.txt_alergicopenetrata.value;
	var fec_pacaler1radosis_hosp = document.frmSolicitud.txt_fec_1radosis_hosp.value;
	var chk_pacaler1radosis_hosp = "";
	if($("#txt_asis_dosistratapene_hosp1").is(':checked')) chk_pacaler1radosis_hosp = "1";
	var fec_pacaler2dadosis_hosp = document.frmSolicitud.txt_fec_2dadosis_hosp.value;
	var chk_pacaler2dadosis_hosp = "";
	if($("#txt_asis_dosistratapene_hosp2").is(':checked')) chk_pacaler2dadosis_hosp = "2";
	var fec_pacaler3radosis_hosp = document.frmSolicitud.txt_fec_3radosis_hosp.value;
	var chk_pacaler3radosis_hosp = "";
	if($("#txt_asis_dosistratapene_hosp3").is(':checked')) chk_pacaler3radosis_hosp = "3";

	var det_pacalerotrotratamiento = document.frmSolicitud.txtDetOtroTrata.value;
	var fec_inipacalerotrotratamiento = document.frmSolicitud.txt_fec_iniotradosis_hosp.value;
	var total_dosispacalerotrotratamiento = document.frmSolicitud.txt_total_otrodosis_hosp.value;

	//Datos tratamiento adecuado
	var id_trataadecuado = document.frmSolicitud.txt_trataadecuado.value;
	var id_notrataadecuado = "";
	if(id_trataadecuado == "2"){
		id_notrataadecuado = document.frmSolicitud.txt_notrataadecuado.value;
		if(id_notrataadecuado == ""){
			msg+= "Seleccione <b>MOTIVO DEL PORQUE NO SE DÍO TRATAMIENTO ADECUADO</b><br/>";	sw = false;
		}
	}
	
	//Datos Contacto
	var nro_contactosi = document.frmSolicitud.txt_nro_contacto_1.value;
	var chk_nro_contactosi = "0";
	if($("#check_nro_contacto_1").is(':checked')) chk_nro_contactosi = "1";
	var nro_contactono = document.frmSolicitud.txt_nro_contacto_2.value;
	var chk_nro_contactono = "0";
	if($("#check_nro_contacto_2").is(':checked')) chk_nro_contactono = "1";
	var nro_contactodesco = document.frmSolicitud.txt_nro_contacto_0.value;
	var chk_nro_contactodesco = "0";
	if($("#check_nro_contacto_0").is(':checked')) chk_nro_contactodesco = "1";
  
	//Datos clasificacion gestante
	var id_clasigestante = document.frmSolicitud.txt_clasigestante.value;
  
	//Datos observacion de madre y culminacion de embarazo
	var obs_madre = document.frmSolicitud.txtObsMadre.value;
	
	var id_tipoculminaembarazo = document.frmSolicitud.txt_tipoCulmiEmbarazo.value;
	var fec_aborto = "";
	var peso_aborto = "";
	var chk_fecaborto = 0;
	var chk_pesoaborto = 0;
	if(id_tipoculminaembarazo == "2"){
		fec_aborto = document.frmSolicitud.txt_fecaborto.value;
		peso_aborto = document.frmSolicitud.txt_pesoaborto.value;
		if($("#chk_fecaborto").is(':checked')) chk_fecaborto = "1";
		if($("#chk_pesoaborto").is(':checked')) chk_pesoaborto = "1";
	}
	
	//Datos del menor 1
	id_tipoculminaembarazonino = document.frmSolicitud.txt_tipoCulmiEmbarazoNino.value;
	id_culminaembarazonino = document.frmSolicitud.txt_culmi_embarazoparto.value;
	id_tiparto = document.frmSolicitud.opt_tiparto.value;
	var fec_obito = "";
	var peso_obito = "";
	var chk_fecobito = 0;
	var chk_pesoobito = 0;
	if(id_tipoculminaembarazo == "2"){
		fec_obito = document.frmSolicitud.txtFechaOtro.value;
		peso_obito = document.frmSolicitud.txt_pesootro.value;
		if($("#chk_fecotro").is(':checked')) chk_fecobito = "1";
		if($("#chk_pesootro").is(':checked')) chk_pesoobito = "1";
	}
	
	var id_menor = $('#txtIdNino').val();
	var id_tipodocmenor = $('#txtIdTipDocNi').val();
	var nro_docmenor = $('#txtNroDocNi').val();
	var nom_menor = $('#txtNomNi').val();
	var primer_apemenor = $('#txtPriApeNi').val();
	var segundo_apemenor = $('#txtSegApeNi').val();
	var id_sexomenor = $('#txtIdSexoNi').val();
	var fec_nacmenor = $('#txtFecNacNi').val();
		
	if(id_tipoculminaembarazo == "1"){
	  //Datos del menor
		if(id_menor == "0"){
			if(id_sexomenor == ""){
				msg+= "Seleccione el <b>SEXO</b> del menor<br/>"; sw = false;
			}

			if(fec_nacmenor == ""){
				msg+= "Ingrese <b>FECHA DE NACIMIENTO</b> del menor<br/>"; sw = false;
			}

			if(nom_menor == ""){
				msg+= "Ingrese nombre del menor<br/>"; sw = false;
			}

			if(primer_apemenor == ""){
				if(segundo_apemenor == ""){
					msg+= "Ingrese el <b>APELLIDO PATERNO O MATERNO</b> del menor<br/>";
					sw = false;
				}
			}
		} else {
			if(fec_nacmenor == ""){
				msg+= "Ingrese <b>FECHA DE NACIMIENTO</b> del menor<br/>";
				sw = false;
			}
		}
	}
  
	var nro_hcmenor = $('#txtNroHCNi').val();
	var id_paisnacmenor = "PER"; var id_etniamenor = "58";
	var id_eessnacmenor = document.frmSolicitud.txtIdDepNacNi.value;
	var id_financiadormenor = document.frmSolicitud.txtIdDepNacNi.value;
	var peso_nacmenor = document.frmSolicitud.txtPesoNi.value;
	var eg_nacmenor = document.frmSolicitud.txtEGNi.value;
	var apgar_nacmenor = document.frmSolicitud.txtAPGARNi.value;
	
	//Datos laboratorio
	var fec_menordils1 = document.frmSolicitud.txtFechaDLSNi1.value;
	var nro_menordils1 = document.frmSolicitud.txtNroDLSNi1.value;
	var chk_menordils1 = "";
	if($("#txtAsisFechaDLSNi1").is(':checked')) chk_menordils1 = "1";
	var fec_menordils2 = document.frmSolicitud.txtFechaDLSNi2.value;
	var nro_menordils2 = document.frmSolicitud.txtNroDLSNi2.value;
	var chk_menordils2 = "";
	if($("#txtAsisFechaDLSNi2").is(':checked')) chk_menordils2 = "2";
	
	var chk_puncionlumbarmenor = document.frmSolicitud.txt_puncionlumbar.value;
	var fec_puncionlumbarmenor = "";
	var nro_puncionlumbarmenor = "";
	if(chk_puncionlumbarmenor == "1"){
		fec_puncionlumbarmenor = document.frmSolicitud.txtFechaPuncionNi.value;
		nro_puncionlumbarmenor = document.frmSolicitud.txtResulPuncionNi.value;
	}
	
	//Datos tratamiento del menor
	id_tratamientomenor = document.frmSolicitud.txt_tratamientomenor.value;
	id_tratamientomenorsi = "";
	fec_initratamientomenorsi = "";
	if(id_tratamientomenor == ""){
		id_tratamientomenorsi = document.frmSolicitud.txt_idtratamientomenorsi.value;
		fec_initratamientomenorsi = document.frmSolicitud.txt_fechainitratamientomenorsi.value;
	}
	var chk_criteriomenor = new Array();
    $("input[name='chk_criteriomenor']:checked").each(function() {
        chk_criteriomenor.push($(this).val());
    });
     //alert("My favourite programming languages are: " + chk_criteriomenor);
	
	//Datos estado final del niño
	var id_estadofinalmenor = document.frmSolicitud.txtEstFinalNino.value;
	var fec_fallecimientomenor = document.frmSolicitud.txtFechaNiFalle.value;
	var obs_menor = document.frmSolicitud.txtObsNino.value;

	if (sw == false) {
    bootbox.alert(msg);
    $('#btnValidForm').prop("disabled", false);
    return false;
  }
	return false;
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
        var myRand = parseInt(Math.random() * 999999999999999);
        if ($('input.check_lab').is(':checked')) {
          var asislab = [];
          $.each($('.check_lab:checked'), function() {
            asislab.push($(this).val());
          });
        } else {
          var asislab = '';
        }

        if ($('input.check_dosispac').is(':checked')) {
          var asistrata = [];
          $.each($('.check_dosispac:checked'), function() {
            asistrata.push($(this).val());
          });
        } else {
          var asistrata = '';
        }

        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlITS.php',
          data: {
            accion: 'POST_ADD_REGSOLICITUD',
            id: document.frmSolicitud.txtIdAtencion.value, id_tipopaciente: id_tipopaciente, id_tipopacienteprivado: id_tipopacienteprivado,
			//Datos paciente
            id_paciente: id_paciente, id_tipodocpac: id_tipodocpac, nro_docpac: nro_docpac, nom_pac: document.frmSolicitud.txtNomPac.value, primer_apepac: document.frmSolicitud.txtPriApePac.value, segundo_apepac: document.frmSolicitud.txtSegApePac.value, id_sexopac: id_sexopac, fec_nacpac: document.frmSolicitud.txtFecNacPac.value, id_paisnacpac: id_paisnacpac, id_etniapac: id_etniapac, id_ubigeopac: id_ubigeopac, direccion_pac: document.frmSolicitud.txtDirPac.value, ref_dirpac: document.frmSolicitud.txtDirRefPac.value, nro_telfipac: document.frmSolicitud.txtNroTelFijoPac.value, nro_telmopac: document.frmSolicitud.txtNroTelMovilPac.value, email_pac: document.frmSolicitud.txtEmailPac.value, nro_hcpac: document.frmSolicitud.txtNroHCPac.value,
			//Datos atención
            id_tiposeguimiento: id_tiposeguimiento, fur_pac: document.frmSolicitud.txt_fur.value, chk_fur: chk_fur, fpp_pac: document.frmSolicitud.txt_fpp.value, fec_cpn: document.frmSolicitud.txtFechaCPN.value, chk_fechacpn: chk_fechacpn, eg_cpn: eg_cpn, id_ipressdiag: id_ipressdiag, det_ipressdiag: document.frmSolicitud.txtDetIPRESDiag.value, chk_gestmultiple: document.frmSolicitud.txt_gestmultiple.value,
			//Datos momento del diágnostico
            id_momentodiag: id_momentodiag, anio_diagprevio: anio_diagprevio, chk_diagpreviotratamiento: chk_diagpreviotratamiento, eg_apnmomentodiag: eg_apnmomentodiag,
			//Datos Laboratorio
            fec_pruebarapida: fec_pruebarapida, fec_tpha: fec_tpha, fec_dils1: fec_dils1, nro_dils1: nro_dils1, chk_dils1: chk_dils1, fec_dils2: fec_dils2, nro_dils2: nro_dils2, chk_dils2: chk_dils2, fec_dils3: fec_dils3, nro_dils3: nro_dils3, chk_dils3: chk_dils3,
			//Datos de Manejo de SIFILIS
            chk_pacalergica: chk_pacalergica, fec_pacnoalerdosis1: fec_pacnoalerdosis1, chk_pacnoalerdosis1: chk_pacnoalerdosis1, fec_pacnoalerdosis2: fec_pacnoalerdosis2, chk_pacnoalerdosis2: chk_pacnoalerdosis2, fec_pacnoalerdosis3: fec_pacnoalerdosis3, chk_pacnoalerdosis3: chk_pacnoalerdosis3, fec_pacalerprusensi: fec_pacalerprusensi, fec_pacalerprudesensi: fec_pacalerprudesensi, chk_pacalerprudesensirefe: chk_pacalerprudesensirefe, chk_pacalertratamientofinal: chk_pacalertratamientofinal, fec_pacaler1radosis_hosp: fec_pacaler1radosis_hosp, chk_pacaler1radosis_hosp: chk_pacaler1radosis_hosp, fec_pacaler2dadosis_hosp: fec_pacaler2dadosis_hosp, chk_pacaler2dadosis_hosp: chk_pacaler2dadosis_hosp, fec_pacaler3radosis_hosp: fec_pacaler3radosis_hosp, chk_pacaler3radosis_hosp: chk_pacaler3radosis_hosp, det_pacalerotrotratamiento: det_pacalerotrotratamiento, fec_inipacalerotrotratamiento: fec_inipacalerotrotratamiento, total_dosispacalerotrotratamiento: total_dosispacalerotrotratamiento,
			//Datos de tratamiento adecuado
			id_trataadecuado: id_trataadecuado, id_notrataadecuado: id_notrataadecuado,
			//Datos contacto
			nro_contactosi: nro_contactosi, chk_nro_contactosi: chk_nro_contactosi, nro_contactono: nro_contactono, chk_nro_contactono: chk_nro_contactono, nro_contactodesco:nro_contactodesco, chk_nro_contactodesco:chk_nro_contactodesco,
			//Datos clasificacion gestante
			id_clasigestante: id_clasigestante,
			//Datos observacion de madre y culminacion de embarazo
			obs_madre: document.frmSolicitud.txtObsMadre.value, id_tipoculminaembarazo: id_tipoculminaembarazo, fec_aborto: fec_aborto, peso_aborto: peso_aborto, chk_fecaborto: chk_fecaborto, chk_pesoaborto: chk_pesoaborto,
			//Datos del menor 1
			id_tipoculminaembarazonino: id_tipoculminaembarazonino, id_culminaembarazonino: id_culminaembarazonino, id_tiparto: id_tiparto, fec_obito: fec_obito, peso_obito: peso_obito, chk_fecobito: chk_fecobito, chk_pesoobito: chk_pesoobito,
            id_menor: id_menor, id_tipodocmenor: id_tipodocmenor, nro_docmenor: nro_docmenor, nom_menor: document.frmSolicitud.txtNomNi.value, primer_apemenor: document.frmSolicitud.txtPriApeNi.value, segundo_apemenor: document.frmSolicitud.txtSegApeNi.value, id_sexomenor: id_sexomenor, fec_nacmenor: document.frmSolicitud.txtFecNacNi.value, id_paisnacmenor: id_paisnacmenor, id_etniamenor: id_etniamenor, id_eessnacmenor: id_eessnacmenor, nro_hcmenor: nro_hcmenor, id_financiadormenor: id_financiadormenor, peso_nacmenor: peso_nacmenor, eg_nacmenor: eg_nacmenor, apgar_nacmenor: apgar_nacmenor,
			//Datos Laboratorio menor
			fec_menordils1:fec_menordils1, nro_menordils1: nro_menordils1, chk_menordils1: chk_menordils1, fec_menordils2: fec_menordils2, nro_menordils2: nro_menordils2, chk_menordils2: chk_menordils2, chk_puncionlumbarmenor: chk_puncionlumbarmenor, fec_puncionlumbarmenor: fec_puncionlumbarmenor, nro_puncionlumbarmenor: nro_puncionlumbarmenor,
			//Datos tratamiento del menor
			
			//Estado final del menor
			id_estadofinalmenor: id_estadofinalmenor, chk_tratamientofinalmenor: chk_tratamientofinalmenor, id_tratamientofinalmenor: id_tratamientofinalmenor, fec_initratamientofinalmenor: fec_initratamientofinalmenor, nro_diatratamientofinalmenor:nro_diatratamientofinalmenor, fec_fallecimientomenor:fec_fallecimientomenor,
            obs_menor: document.frmSolicitud.txtObsNino.value,
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $('#txtIdAtencion').val(msg);
			  window.location = './reg_sifilis.php?id=' + msg;
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

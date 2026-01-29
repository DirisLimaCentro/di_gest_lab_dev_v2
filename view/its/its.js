var datoref = 1;
var adatoref = [];

$(function() {

    jQuery('#txtNroDocPac').keypress(function (tecla) {
      var idTipDocPer = $("#txtIdTipDocPac").val();
      if (idTipDocPer == "1") {
        if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
        return false;
      } else {
        if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode != 0))//(Numeros y letras)(0=borrar)
        return false;
      }
    });

    jQuery('#txtPriApePac').keypress(function (tecla) {
      if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
      return false;
    });
    jQuery('#txtSegApePac').keypress(function (tecla) {
      if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
      return false;
    });
    jQuery('#txtNomPac').keypress(function (tecla) {
      if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
      return false;
    });

    jQuery('#txtNroTelMovilPac').keypress(function (tecla) {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
      return false;
    });

    jQuery('#txtNroTelfMovilPac').keypress(function (tecla) {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
      return false;
    });
	
	$('[name="txtTipPac"]').change(function(){
		maxlength_doc_bus();
		if($(this).val() == "1"){
		  $("#txtIdTipPacParti").val('');
		  $('#txtIdTipPacParti').prop("disabled", true);
		  setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
		} else {
		  $("#txtIdTipPacParti").val('');
		  $('#txtIdTipPacParti').prop("disabled", false);
		  setTimeout(function(){$('#txtIdTipPacParti').trigger('focus');}, 2);
		}
	});

    $('[name="chk_fur"]').change(function(){
		if ($(this).is(':checked')) {
			$('#txt_fur').prop("disabled", true);
		} else {
			$('#txt_fur').prop("disabled", false);
		}
		$("#txt_fur").val('');
    });

    $('[name="chk_fechacpn"]').change(function(){
		if ($(this).is(':checked')) {
			$('#txtFechaCPN').prop("disabled", true);
		} else {
			$('#txtFechaCPN').prop("disabled", false);
		}
		$("#txtFechaCPN").val('');
    });

	$('[name="txt_tipoCulmiEmbarazo"]').change(function(){
		if ($(this).is(':checked')) {
			//var gestmultiple = document.frmSolicitud.txt_gestmultiple.value;
			
			  if($(this).val() == "2"){
					$('#div_aborto').show();
					$('#div-datos-menor').hide();
			  } else {
					$('#div_aborto').hide();
					$('#div-datos-menor').show();
			  }
		}
	});
	
    $('[name="chk_fecaborto"]').change(function(){
      if ($(this).is(':checked')) {
		  $('#txt_fecaborto').prop("disabled", true);
      } else {
		  $('#txt_fecaborto').prop("disabled", false);
        }
		$("#txt_fecaborto").val('');
    });
	
    $('[name="chk_pesoaborto"]').change(function(){
      if ($(this).is(':checked')) {
		  $('#txt_pesoaborto').prop("disabled", true);
      } else {
		  $('#txt_pesoaborto').prop("disabled", false);
        }
		$("#txt_pesoaborto").val('');
    });
	
	$('[name="txt_tipomomentodiagvih"]').change(function(){
		if ($(this).is(':checked')) {
		  if($(this).val() == "1"){
				$('#div_diag_previoges').show();
				$('#div_diag_tarvsineg').show();
				$('#div_diag_tarvconeg').hide();
				$('#div_diag_tarvconegconev').hide();
				$('#div_diag_abandonotarv').show();
				$('#div_escenario1').hide();
				$('#div_escenario2').show();
				$('#div_escenario3').hide();
		  } else {
				$('#div_diag_previoges').hide();
				$('#div_diag_tarvsineg').hide();
				$('#div_diag_tarvconeg').hide();
				$('#div_diag_tarvconegconev').hide();
				$('#div_diag_abandonotarv').hide();
				$('#div_escenario1').hide();
				$('#div_escenario2').hide();
				$('#div_escenario3').hide();
		  }
		  //$(".chk_fecotro").prop('checked', false);
		}
	});
	
	$('[name="txt_momentodiagvih"]').change(function(){
		if ($(this).is(':checked')) {
		  if($(this).val() == "1"){
				$('#div_diag_tarvsineg').hide();
				$('#div_diag_tarvconeg').show();
				$('#div_diag_tarvconegconev').hide();
				$('#div_diag_abandonotarv').show();
				$('#div_escenario1').show();
				$('#div_escenario2').hide();
				$('#div_escenario3').hide();
		  } else if($(this).val() == "2") {
				$('#div_diag_tarvsineg').hide();
				$('#div_diag_tarvconeg').hide();
				$('#div_diag_tarvconegconev').show();
				$('#div_diag_abandonotarv').show();
				$('#div_escenario1').hide();
				$('#div_escenario2').show();
				$('#div_escenario3').show();
		  } else if($(this).val() == "3") {
				$('#div_diag_tarvsineg').hide();
				$('#div_diag_tarvconeg').hide();
				$('#div_diag_tarvconegconev').show();
				$('#div_diag_abandonotarv').show();
				$('#div_escenario1').hide();
				$('#div_escenario2').show();
				$('#div_escenario3').show();
		  } else if($(this).val() == "4") {
				$('#div_diag_tarvsineg').hide();
				$('#div_diag_tarvconeg').hide();
				$('#div_diag_tarvconegconev').show();
				$('#div_diag_abandonotarv').show();
				$('#div_escenario1').hide();
				$('#div_escenario2').show();
				$('#div_escenario3').show();
		  } else if($(this).val() == "5") { //5
				$('#div_diag_tarvsineg').hide();
				$('#div_diag_tarvconeg').hide();
				$('#div_diag_tarvconegconev').show();
				$('#div_diag_abandonotarv').show();
				$('#div_escenario1').show();
				$('#div_escenario2').show();
				$('#div_escenario3').hide();
		  }
		  //$(".chk_fecotro").prop('checked', false);
		}
	});


});

function back() {
	window.location = './main_sifilis.php';
}

function enabled_datos_atencion() {
	var estadopac = document.frmSolicitud.txtEstadoPac.value;
	if(estadopac == "1"){
		$('#datos-puerpera').hide();
		$('#datos-gestante').show();
		$('#txt_fpp').prop("disabled", false);
	} else {
		$('#datos-puerpera').show();
		$('#datos-gestante').hide();
		$('#txt_fpp').prop("disabled", true);
	}
	$('#txt_fur').prop("disabled", false);
	$('#txtFechaCPN').prop("disabled", false);
	$('#txtEGCPN').prop("disabled", false);
	$('#txtIPRESDiag').prop("disabled", false);
	$('#txtDetIPRESDiag').prop("disabled", false);
	$('.opt_diagnostico').prop("disabled", false);
}

function enabled_datos_momento_diagnostico() {
	var monentodiag = document.frmSolicitud.txtDiagnostico.value;
	if(monentodiag == "1"){
	  $('#txt_aniodx').prop("disabled", false);
	  $('.opt_tratamientodx').prop("disabled", false);
	  $('#txtEGAPNDiag').prop("disabled", true);
	} else if(monentodiag == "2"){
		$('#txt_aniodx').prop("disabled", true);
		$('.opt_tratamientodx').prop("disabled", true);
		$('#txtEGAPNDiag').prop("disabled", false);
	} else {
		$('#txt_aniodx').prop("disabled", true);
		$('#txtEGAPNDiag').prop("disabled", true);
	}
}



function campoSiguiente(campo, evento) {
  if (evento.keyCode == 13 || evento.keyCode == 9) {
    if (campo == 'btnPacSearch') {
      buscar_datos_personales();
    } else if (campo == 'txtPriApePac') {
      if ($('#txtPriApePac').val() != ""){
        if($('#txtIdEtniaPac').val() != ""){
          $('#txtUBIGEOPac').select2('open');
        } else {
          $('#txtIdEtniaPac').select2('open');
        }
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    } else if (campo == 'txtIdPaisNacPac'){
      if($('#txtIdPaisNacPac').val() != ""){
        $('#txtUBIGEOPac').select2('open');
      } else {
        $('#txtIdPaisNacPac').select2('open');
      }
    } else if (campo == 'txtIdEtniaPac'){
      $('#txtIdEtniaPac').select2('open');
    } else if (campo == 'txtIdDepPac'){
      $('#txtIdDepPac').select2('open');
    } else if (campo == 'txtUBIGEOPac'){
      $('#txtUBIGEOPac').select2('open');
    } else {
      document.getElementById(campo).focus();
      evento.preventDefault();
    }
  }
}

function maxlength_doc_bus() {

  $("#txtIdPac").val('0');

  $("#txtNomPac").val('');
  $("#txtPriApePac").val('');
  $("#txtSegApePac").val('');
  $("#txtIdSexoPac").val('');
  $("#txtFecNacPac").val('');
  $("#txtEdadPac").val('');
  $("#txtNroTelFijoPac").val('');
  $("#txtNroTelMovilPac").val('');
  $("#txtEmailPac").val('');
  $("#txtNroHCPac").val('');

  $("#txtIdPaisNacPac").val('').trigger("change");
  $("#txtIdEtniaPac").val('').trigger("change");
  $("#txtUBIGEOPac").val('').trigger("change");
  $("#txtDirPac").val('');
  $("#txtDirRefPac").val('');

  if ($("#txtIdTipDocPac").val() == "7") {
    $("#txtNroDocPac").val('SD0000000000000');
    $("#txtNroDocPac").prop("disabled", true);
    $("#btnPacSearch").prop("disabled", true);
    $("#txtNomPac").prop("readonly", false);
    $("#txtPriApePac").prop("readonly", false);
    $("#txtSegApePac").prop("readonly", false);
    $("#txtIdSexoPac").prop("disabled", true);
    $("#txtIdSexoPac").val('2');
    $("#txtFecNacPac").prop("disabled", false);
    $("#txtIdPaisNacPac").prop("disabled", false);
    $("#txtIdEtniaPac").prop("disabled", false);

    $('#txtIdTipDocSoliT').prop("disabled", false);
    $('#txtNroDocSoliT').prop("disabled", false);
    $('#btnSoliTSearch').prop("disabled", false);

    setTimeout(function(){$('#txtNroHCPac').trigger('focus');}, 2);
  } else {
    $("#txtNroDocPac").val('');
    $("#txtNroDocPac").prop("disabled", false);
    $("#btnPacSearch").prop("disabled", false);
    $("#txtNomPac").prop("readonly", true);
    $("#txtPriApePac").prop("readonly", true);
    $("#txtSegApePac").prop("readonly", true);
    $("#txtIdSexoPac").prop("disabled", true);
    $("#txtFecNacPac").prop("disabled", true);
    $("#txtIdPaisNacPac").prop("disabled", true);
    $("#txtIdEtniaPac").prop("disabled", true);

    $('#txtIdTipDocSoliT').prop("disabled", true);
    $('#txtNroDocSoliT').prop("disabled", true);
    $('#btnSoliTSearch').prop("disabled", true);

    if ($("#txtIdTipDocPac").val() == "1"){
      $("#txtNroDocPac").attr('maxlength', '8');
    } else {
      $("#txtNroDocPac").attr('maxlength', '15');
    }
    setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
  }
}

function enabled_datos_direccion() {
  $('#txtIdDepPac').prop("disabled", false);
  $('#txtUBIGEOPac').prop("disabled", false);
  $('#txtDirPac').prop("readonly", false);
  $('#txtDirRefPac').prop("readonly", false);
  $('#txtNroTelFijoPac').prop("disabled", false);
  $('#txtNroTelMovilPac').prop("disabled", false);
  $('#txtEmailPac').prop("disabled", false);
}

function disabled_datos_direccion() {
  $('#txtIdDepPac').prop("disabled", true);
  $('#txtUBIGEOPac').prop("disabled", true);
  $('#txtDirPac').prop("readonly", true);
  $('#txtDirRefPac').prop("readonly", true);
  $('#txtNroTelFijoPac').prop("disabled", true);
  $('#txtNroTelMovilPac').prop("disabled", true);
  $('#txtEmailPac').prop("disabled", true);
}

function buscar_datos_personales(){
  $('#txtIdPac').val('0');
  var msg = "";
  var sw = true;
  var txtIdTipDoc = $('#txtIdTipDocPac').val();
  var txtNroDoc = $('#txtNroDocPac').val();
  var txtNroDocLn = txtNroDoc.length;

  if (txtIdTipDoc == "1") {
    if (txtNroDocLn != 8) {
      msg += "Ingrese el Nro. de documento correctamente (8 digitos)<br/>";
      sw = false;
    }

    if(validateNumber(txtNroDoc) == "0"){
      msg += "Ingrese el Nro. de documento correctamente (Digitar valores numéricos)<br/>";
      sw = false;
    }
  } else if(txtIdTipDoc == "2" || txtIdTipDoc == "4"){
    if (txtNroDocLn <= 5) {
      msg += "Ingrese el Nro. de documento correctamente<br/>";
      sw = false;
    }
  } else {
    if (txtNroDocLn <= 8) {
      msg += "Ingrese el Nro. de documento correctamente<br/>";
      sw = false;
    }
  }

  if (sw == false) {
    bootbox.alert(msg);
    $('#btn-pac-search').prop("disabled", false);
    return false;
  }

  $('#btn-pac-search').prop("disabled", true);
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
      $("#txtIdPac").val(datos[0]);
	  $('#txtNroHCPac').prop("disabled", false);
	  enabled_datos_direccion();
      if(datos[0] == "E"){
        $("#txtIdPac").val('0');
        bootbox.alert({
          message: "No se encontró el DNI en consulta RENIEC, verifíque por favor.",
          callback: function () {
			setTimeout(function(){delet_padding();}, 1000);
            setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
          }
        });
      }  else if (datos[0] == "NE"){
		$("#txtIdPac").val('0');
        $('#txtNomPac').prop("readonly", false);
        $('#txtPriApePac').prop("readonly", false);
        $('#txtSegApePac').prop("readonly", false);
        $('#txtFecNacPac').prop("disabled", false);
        $('#txtIdPaisNacPac').prop("disabled", false);
        $('#txtIdEtniaPac').prop("disabled", false);
        $("#txtIdPaisNacPac").val('').trigger("change");
        $("#txtIdEtniaPac").val('').trigger("change");
        bootbox.alert({
          message: "<b class='text-danger'>No se encontró registrada a la paciente</b>, por favor ingrese sus datos manualmente.",
          callback: function () {
			setTimeout(function(){delet_padding();}, 1000);
            setTimeout(function(){$('#txtNroHCPac').trigger('focus');}, 2);
          }
        });
		$('.opt_estadopac').prop("disabled", false);
      } else if(datos[0] == "C"){ //Consulta reniec no disponible
        $('#txtNomPac').prop("readonly", false);
        $('#txtPriApePac').prop("readonly", false);
        $('#txtSegApePac').prop("readonly", false);
        $('#txtFecNacPac').prop("disabled", false);
        $('#txtIdPaisNacPac').prop("disabled", false);
        $('#txtIdEtniaPac').prop("disabled", false);
        $("#txtIdPaisNacPac").val('').trigger("change");
        $("#txtIdEtniaPac").val('').trigger("change");
        $("#txtIdPac").val('0');
        bootbox.alert({
          message: "El servicio de consulta RENIEC no está disponible, por favor ingrese los datos manualmente...",
          callback: function () {
			setTimeout(function(){delet_padding();}, 1000);
            setTimeout(function(){$('#txtNroHCPac').trigger('focus');}, 2);
          }
        });
		$('.opt_estadopac').prop("disabled", false);
      } else if((datos[4] == null) || (datos[4] == "")){ //No tiene nombres
        $('#txtNomPac').prop("readonly", false);
        $('#txtPriApePac').prop("readonly", false);
        $('#txtSegApePac').prop("readonly", false);
        $('#txtFecNacPac').prop("disabled", false);
        $('#txtIdPaisNacPac').prop("disabled", false);
        $('#txtIdEtniaPac').prop("disabled", false);
        //$("#txtIdPaisNacPac").val('').trigger("change");
        //$("#txtIdEtniaPac").val('').trigger("change");
		$('.opt_estadopac').prop("disabled", false);
        $("#txtNroHCPac").trigger('focus');
      } else { // tiene los datos completos
        if(datos[7] == "1"){//Datos completos pero es Sexo Masculino
          $("#txtIdPac").val('0');
          bootbox.alert({
            message: "El paciente debe ser de sexo <b>FEMENINO</b>",
            callback: function () {
				setTimeout(function(){delet_padding();}, 1000);
				setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
            }
          });
        } else { //Datos completos Sexo Femenino
		  $('.opt_estadopac').prop("disabled", false);
          $("#txtNomPac").val(datos[4]);
          $("#txtPriApePac").val(datos[5]);
          $("#txtSegApePac").val(datos[6]);
          $("#txtIdSexoPac").val(datos[7]);
          $("#txtFecNacPac").val(datos[9]);
          $("#txtEdadPac").val(datos[20]);
          $("#txtNroTelFijoPac").val(datos[11]);
          $("#txtNroTelMovilPac").val(datos[12]);
          $("#txtEmailPac").val(datos[13]);
          $("#txtUBIGEOPac").val(datos[14]).trigger("change");
          $("#txtNroHCPac").val(datos[10]);
          $("#txtIdPaisNacPac").val(datos[21]).trigger("change");
          $("#txtDirPac").val(datos[18]);
          $("#txtDirRefPac").val(datos[19]);
          $('#txtNomPac').prop("readonly", true);
          $('#txtPriApePac').prop("readonly", true);
          $('#txtSegApePac').prop("readonly", true);
          $('#txtIdSexoPac').prop("disabled", true);
          $('#txtFecNacPac').prop("disabled", true);
          if(datos[9] == ""){
            $('#txtFecNacPac').prop("disabled", false);
          }
          if(datos[10] == ""){//HC
            if(datos[22] != ""){
              $("#txtIdEtniaPac").val(datos[22]).trigger("change");
            } else {
              $('#txtIdEtniaPac').prop("disabled", false);
            }
            $('#txtNroHCPac').prop("readonly", false);
            $("#txtNroHCPac").trigger('focus');
          } else {
            if(datos[22] != ""){
              $("#txtIdEtniaPac").val(datos[22]).trigger("change");
            } else {
              $('#txtIdEtniaPac').prop("disabled", false);
              if(datos[14] != ""){
                $("#txtDirPac").trigger('focus');
              } else {
                $('#txtUBIGEOPac').select2('open');
              }
            }
          }
        }
      }
    }
  });
  setTimeout(function(){delet_padding();}, 1000);
}

function add_referencia(){
  var fec = $("#txtfechaRef").val();
  var nro = $("#txtNroRef").val();
  var dep = $("#txtIdDepRef").val();
  var diag = $("#txtDetDiagRef").val();

  adatoref.push([
    datoref,
    $("#txtfechaRef").val(),
    $("#txtNroRef").val(),
    $("#txtIdDepRef option:selected").html(),
    $("#txtDetDiagRef").val()
  ]);
  datoref ++;
  newOption="";
  adatoref.forEach(function (oo) {
    newOption += "<tr><td><small>" + oo[1] + "</small></td><td><small>" + oo[2] + "</small></td><td><small>" + oo[3] + "</small></td><td><small>" + oo[4] + "</small></td><td><button type=\"button\"  class=\"btn btn-primary\" onclick=\"del_referencia('"+ oo[0] +"')\">Eliminar</button></td></tr>";
  });
  $("#det-referencia").html(newOption);

  $("#txtfechaRef").val('');
  $("#txtNroRef").val('');
  $("#txtIdDepRef").val('');
  $("#txtDetDiagRef").val('');
}

function del_referencia(id){
  for (var x=0;x<adatoref.length;x++){
      if(adatoref[x][0] == id){
          adatoref.splice(x,1);
          break;
        }
  }

  newOption="";
  adatoref.forEach(function (oo) {
    newOption += "<tr><td><small>" + oo[1] + "</small></td><td><small>" + oo[2] + "</small></td><td><small>" + oo[3] + "</small></td><td><small>" + oo[4] + "</small></td><td><button type=\"button\"  class=\"btn btn-primary\" onclick=\"del_referencia('"+ oo[0] +"')\">Eliminar</button></td></tr>";
  });
  $("#det-referencia").html(newOption);
}

function delet_padding() {
  document.getElementsByTagName("body")[0].style.removeProperty("padding-right");
}
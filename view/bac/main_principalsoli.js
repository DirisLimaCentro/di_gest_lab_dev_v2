var date = new Date();
var day = date.getDate()
var month = date.getMonth() + 1
var year = date.getFullYear()
if(month < 10){
	var fec_actu = day + "/0" + month + "/" + year;
} else {
	var fec_actu = day + "/" + month + "/" + year;
}

function back() {
  window.location = './main_principalsoli.php';
}

function edit_solicitud(id) {
    window.location = './main_editsolicitud.php?nroSoli='+id;
}

function campoSiguiente(campo, evento) {
  if (evento.keyCode == 13 || evento.keyCode == 9) {
    if (campo == 'btnPacSearch') {
      valid_atencion_anterior();
    } else if (campo == 'txtPriApePac') {
      if ($('#txtPriApePac').val() != ""){//Este if cambia es para ver si es sis tiene que ir a nro FUA
		  if (document.frmSolicitud.txtTipPac.value != "1"){
			if($('#txtIdEtniaPac').val() != ""){
			  $('#txtUBIGEOPac').select2('open');
			} else {
			  $('#txtIdEtniaPac').select2('open');
			}
		  } else {
			  setTimeout(function(){$('#txtDirPac').trigger('focus');}, 2);
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
    } else if (campo == 'btnSoliTSearch') {
          buscar_datos_personales_soli('1');
    } else if (campo == 'btnSoliSearch') {
          buscar_datos_personales_soli('2');
    } else if (campo == 'btnValidFormSoli') {
          validFormSoli('1');
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

function maxlength_doc_bus_soli_t() {

  $("#txtIdSoli").val('0');

  $("#txtNomCompleSoli").val('');
  $("#lbl-parentesco").text('');

  $("#txtNomSoli").val('');
  $("#txtPriApeSoli").val('');
  $("#txtSegApeSoli").val('');
  $("#txtIdSexoSoli").val('');
  $("#txtFecNacSoli").val('');
  $("#txtNroTelFijoSoli").val('');
  $("#txtNroTelMovilSoli").val('');
  $("#txtEmailSoli").val('');

  $("#txtIdPaisNacSoli").val('').trigger("change");
  $("#txtIdEtniaSoli").val('').trigger("change");
  $("#txtIdParenSoli").prop("disabled", false);

  if ($("#txtIdTipDocSoliT").val() == "7") {
    $("#txtNroDocSoliT").val('SD00000000000000');
    $("#txtNroDocSoliT").prop("disabled", true);
    $("#btnSoliTSearch").prop("disabled", true);

    $("#txtNroDocSoli").val('SD00000000000000');
    $("#txtNroDocSoli").prop("disabled", true);
    //$("#btnSoliSearch").prop("disabled", true);

    $("#txtNomSoli").prop("readonly", false);
    $("#txtPriApeSoli").prop("readonly", false);
    $("#txtSegApeSoli").prop("readonly", false);
    $("#txtIdSexoSoli").prop("disabled", false);
    $("#txtFecNacSoli").prop("disabled", false);
    $("#txtIdPaisNacSoli").prop("disabled", false);
    $("#txtIdEtniaSoli").prop("disabled", false);

    $('#showSoliModal').modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });

    $('#showSoliModal').on('shown.bs.modal', function (e) {
      $('#txtIdParenSoli').select2();
      $('#txtIdPaisNacSoli').select2();
      $('#txtIdEtniaSoli').select2();
      $("#txtPriApeSoli").trigger('focus');
    });
  } else {
    $("#txtNroDocSoliT").val('');
    $("#txtNroDocSoliT").prop("disabled", false);
    $("#btnSoliTSearch").prop("disabled", false);

    $("#txtNroDocSoli").val('');
    $("#txtNroDocSoli").prop("disabled", true);
    //$("#btnPacSearch").prop("disabled", false);

    $("#txtNomSoli").prop("readonly", true);
    $("#txtPriApeSoli").prop("readonly", true);
    $("#txtSegApeSoli").prop("readonly", true);
    $("#txtIdSexoSoli").prop("disabled", true);
    $("#txtFecNacSoli").prop("disabled", true);
    $("#txtIdPaisNacSoli").prop("disabled", true);
    $("#txtIdEtniaSoli").prop("disabled", true);

    if ($("#txtIdTipDocSoliT").val() == "1"){
      $("#txtNroDocSoliT").attr('maxlength', '8');
    } else {
      $("#txtNroDocSoliT").attr('maxlength', '12');
    }
    setTimeout(function(){$('#txtNroDocSoliT').trigger('focus');}, 2);
  }
}

function select_examen() {
	$("#txtIdTipoPruRapida").val('').trigger("change");
	$("#txtIdMetodoPruConvencional").val('').trigger("change");
	var id_tipoexamen = $("#txtIdTipExamen").val();
	
	if(id_tipoexamen == "2"){
		$("#show-hide-pru-rapida").show();
		$("#show-hide-pru-convencional").hide();
	} else if(id_tipoexamen == "3") {
		$("#show-hide-pru-convencional").show();
		$("#show-hide-pru-rapida").hide();
	} else {
		$("#show-hide-pru-convencional").hide();
		$("#show-hide-pru-rapida").hide();		
	}
}

function enabled_datos_documento() {
  $('#txtIdTipDocPac').prop("disabled", false);
  $('#txtNroDocPac').prop("disabled", false);
  $('#btnPacSearch').prop("disabled", false);
  $("#txtIdPaisNacPac").val('').trigger("change");
}

function disabled_datos_documento() {
  $('#txtIdTipDocPac').prop("disabled", true);
  $('#txtNroDocPac').prop("disabled", true);
  $('#btnPacSearch').prop("disabled", true);
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

function enabled_datos_atencion() {
  $('#txtIdServicio').prop("disabled", false);
  $('#txtNroCama').prop("disabled", false);
  $('#txtIdTipMuestra').prop("disabled", false);
  $('.txtIdAntecedente').prop("disabled", false);
  //$('.txtIdDetAntecedente').prop("disabled", false);
  $('.txtIdDiagnostico').prop("disabled", false);
  //$('#txtDetDiagnostico').prop("disabled", false);
  
  $('#txtMesTratamiento').prop("disabled", false);
  $('.txtIdTratamiento').prop("disabled", false);
  //$('#txtDetTratamiento').prop("disabled", false);
  
  $('#txtNroMuestra').prop("disabled", false);
  $('#txtDetCultivo').prop("disabled", false);
  $('#txtIdTipExamen').prop("disabled", false);
  $('#txtIdTipoPruRapida').prop("disabled", false);
  $('#txtIdMetodoPruConvencional').prop("disabled", false);
  $('#txtIdPerfilMetodoConvencional').prop("disabled", false);
  $('#txtIdPerfilMetodoConvencional').prop("disabled", false);

  $('#txtDetFactores').prop("disabled", false);
  $('.txtIdCaliMuestra').prop("disabled", false);
  $('#txtObsSoli').prop("disabled", false);
  
  $('#btnValidForm').prop("disabled", false);
}

function show_datos_soli() {
  if($('#show-datos-soli').text() == "Mostrar"){
    $('#datos-soli').show();
    $('#show-datos-soli').text("Ocultar");
    $('#txtNroDocSoliT').trigger('focus');
  } else {
    $('#datos-soli').hide();
    $('#show-datos-soli').text("Mostrar");
  }
}

function delete_apo() {
    $("#lbl-parentesco").text('');
    $('#txtNroDocSoliT').trigger('focus');
    $('#txtIdTipDocSoliT').val('1');
    $('#txtNroDocSoliT').val('');
    $('#txtNomCompleSoli').val('');

    $('#txtIdTipDocSoli').val('1');
    $('#txtNroDocSoli').val('');
    $("#txtNomSoli").val('');
    $("#txtPriApeSoli").val('');
    $("#txtSegApeSoli").val('');
    $("#txtIdSexoSoli").val('');
    $("#txtFecNacSoli").val('');
    $("#txtNroTelFijoSoli").val('');
    $("#txtNroTelMovilSoli").val('');
    $("#txtEmailSoli").val('');
    $("#txtIdParenSoli").val('').trigger("change");
    $("#txtIdPaisNacSoli").val('').trigger("change");
    $("#txtIdEtniaSoli").val('').trigger("change");

    $("#txtIdSoli").val('0');
}

function validFormSoli(opt){
  if(opt == "2"){
    $("#txtIdSoli").val('0');
    $("#txtIdTipDocSoliT").val('1');
    $("#txtNroDocSoliT").val('');
    $("#txtNomCompleSoli").val('');
    $("#lbl-parentesco").text('');
    $("#txtNroDocSoliT").prop("disabled", false);
    $("#btnSoliTSearch").prop("disabled", false);

    $("#txtNomSoli").val('');
    $("#txtPriApeSoli").val('');
    $("#txtSegApeSoli").val('');
    $("#txtIdSexoSoli").val('');
    $("#txtFecNacSoli").val('');
    $("#txtNroTelFijoSoli").val('');
    $("#txtNroTelMovilSoli").val('');
    $("#txtEmailSoli").val('');

    $("#txtIdParenSoli").val('').trigger("change");
    $("#txtIdPaisNacSoli").val('').trigger("change");
    $("#txtIdEtniaSoli").val('').trigger("change");

    $("#txtNroDocSoliT").trigger('focus');
  } else {
    $('#btnValidFormSoli').prop("disabled", true);

    var msg = "";
    var sw = true;
    var idpac = $('#txtIdSoli').val();
    var idparensoli = $("#txtIdParenSoli").val();
    var idetniasoli = $("#txtIdEtniaSoli").val();

    var telfipac = $('#txtNroTelFijoSoli').val();
    var telmopac = $('#txtNroTelMovilSoli').val();
    var emailpac = $('#txtEmailSoli').val();

    if(idpac == "0"){
      var sexopac = $('#txtIdSexoSoli').val();
      var fecnacpac = $('#txtFecNacSoli').val();
      var nompac = $('#txtNomSoli').val();
      var priapepac = $('#txtPriApeSoli').val();
      var seapepac = $('#txtSegApeSoli').val();

      if(sexopac == ""){
        msg+= "Seleccione el sexo del Apoderado<br/>";
        sw = false;
      }

      if(fecnacpac == ""){
        msg+= "Ingrese fecha de nacimiento del Apoderado<br/>";
        sw = false;
      }

      if(nompac == ""){
        msg+= "Ingrese nombre del Apoderado<br/>";
        sw = false;
      }

      if(priapepac == ""){
        if(seapepac == ""){
          msg+= "Ingrese el apellido paterno o materno del Apoderado<br/>";
          sw = false;
        }
      }
    } else {
      var fecnacpac = $('#txtFecNacPac').val();
      if(fecnacpac == ""){
        msg+= "Ingrese fecha de nacimiento del Apoderado<br/>";
        sw = false;
      }
    }

    if(idparensoli == ""){
      msg+= "Seleccione Parentesco del Apoderado<br/>";
      sw = false;
    }

    if(idetniasoli == ""){
      msg+= "Seleccione Etnia del Apoderado<br/>";
      sw = false;
    }

    if(telfipac != ""){
      var ltelfipac = telfipac.length;
      if(ltelfipac < 7){
        msg+= "Ingrese correctamente el número de teléfono fijo del Paciente<br/>";
        sw = false;
      }
    }

    if(telmopac != ""){
      var ltelmopac = telmopac.length;
      if(ltelmopac < 9){
        msg+= "Ingrese correctamente el número de teléfono móvil del Paciente<br/>";
        sw = false;
      }
    }

    if(emailpac != ""){
      if(validateEmail(emailpac) === false){
        msg+= "Ingrese correctamente el email del Paciente<br/>";
        sw = false;
      };
    }

    if (sw == false) {
      bootbox.alert(msg);
      $('#btnValidFormSoli').prop("disabled", false);
      return false;
    }

    $("#txtNomCompleSoli").val($("#txtPriApeSoli").val() + " " + $("#txtSegApeSoli").val() + " " + $("#txtNomSoli").val());
    $("#lbl-parentesco").text('Parentesco: ' + $("#txtIdParenSoli option:selected").text());
  }
  $("#showSoliModal").modal('hide');
}

function open_pdfsinvalor() {
  var idSoli = $('#txtIdAtencion').val();
  var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function open_pdfatenciones(id_per) {
	if(id_per) {id_per = id_per} else {id_per = $('#txtIdPac').val()}
	var urlwindow = "pdf_solisinvalor.php?id_solicitud=&id_persona=" + id_per + "&id_tipo=1";
	day = new Date();
	id = day.getTime();
	Xpos = (screen.width / 2) - 390;
	Ypos = (screen.height / 2) - 300;
	eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function get_listaProvinciaAndDistrito(opt, id) {
  if(opt == ""){
    var txtIdDepPac = $('#txtIdDepPac').val();
  }else {
    var txtIdDepPac = opt;
  }

  if (txtIdDepPac == ""){
    $('#txtUBIGEOPac').html("<option value=''>--Seleccionar-</option>");
    return false;
  }
  $.ajax({
    url: "../../controller/ctrlUbigeo.php",
    type: "POST",
    dataType: "json",
    data: {
      accion: 'GET_SHOW_LISTAPROVINCIAANDDISTRITO', idDepPac: txtIdDepPac
    },
    success: function (result) {
      var newOption = "";
      newOption = "<option value=''>--Seleccionar-</option>";
      $(result).each(function (ii, oo) {
        newOption += "<option value='" + oo.id_ubigeo + "'"
        if(oo.id_ubigeo == id){
          newOption += " selected";
        }
        newOption += ">" + oo.provincia + " - " + oo.distrito + "</option>";
      });
      $('#txtUBIGEOPac').html(newOption);
      $("#txtUBIGEOPac").val(id).trigger("change");
    }
  });
}


function valid_atencion_anterior(){
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

  $('#div_btn_atencion').hide();
  $('#btn-pac-search').prop("disabled", true);
  $.ajax({
    url: "../../controller/ctrlPAP.php",
    type: "GET",
    dataType: 'json',
    data: {
      accion: 'GET_SHOW_VALIDANTERIORATENION', id_tipdoc: txtIdTipDoc, nro_doc: txtNroDoc
    },
    success: function (registro) {
      var datos = eval(registro);
	  if(datos[0] == 1){
		bootbox.confirm({
			message: "<b>La paciente tiene una atención antes de los 6 meses!!</b><br/><button type='button' class='btn btn-info' onclick='open_pdfatenciones(" + datos[1] + ")'><i class='glyphicon glyphicon-eye-open'></i> Ver atenciones </button><br/>¿Desea continuar con el registro de la toma de PAP?",
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
				$('#div_btn_atencion').show();
				buscar_datos_personales();
			  } else {
				  setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
			  }
			}
		});
	  } else if(datos[0] == 2){
			$('#div_btn_atencion').show();
			buscar_datos_personales();
	  } else {
			buscar_datos_personales();
	  }
    }
  });
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
      } else if((datos[4] == null) || (datos[4] == "")){ //No tiene nombres
        $('#txtNomPac').prop("readonly", false);
        $('#txtPriApePac').prop("readonly", false);
        $('#txtSegApePac').prop("readonly", false);
        $('#txtFecNacPac').prop("disabled", false);
        $('#txtIdPaisNacPac').prop("disabled", false);
        $('#txtIdEtniaPac').prop("disabled", false);
        //$("#txtIdPaisNacPac").val('').trigger("change");
        //$("#txtIdEtniaPac").val('').trigger("change");
        $("#txtNroHCPac").trigger('focus');
      } else { // tiene los datos completos
          $("#txtNomPac").val(datos[4]);
          $("#txtPriApePac").val(datos[5]);
          $("#txtSegApePac").val(datos[6]);
          $("#txtIdSexoPac").val(datos[7]);
          $("#txtFecNacPac").val(datos[9]);
          $("#txtEdadPac").val(datos[20]);
          $("#txtNroTelFijoPac").val(datos[11]);
          $("#txtNroTelMovilPac").val(datos[12]);
          $("#txtEmailPac").val(datos[13]);
		  if(datos[14] == ""){
			var iddepar = "14";
			$("#txtIdDepPac").val(iddepar).trigger("change");
		  } else {
			var iddepar = datos[14].substring(0,2);
			$("#txtIdDepPac").val(iddepar).trigger("change");
			get_listaProvinciaAndDistrito(datos[14].substring(0,2), datos[14]);
		  }
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
                $('#txtIdDepPac').select2('open');
              }
            }
          }
      }

      $('#txtIdTipDocSoliT').prop("disabled", false);
      $('#txtNroDocSoliT').prop("disabled", false);
      $('#btnSoliTSearch').prop("disabled", false);
    }
  });
  setTimeout(function(){delet_padding();}, 1000);
}

function buscar_datos_personales_soli(opt){
  $('#txtIdSoli').val('0');
  var msg = "";
  var sw = true;
  if(opt == "1"){
    var txtIdTipDoc = $('#txtIdTipDocSoliT').val();
    var txtNroDoc = $('#txtNroDocSoliT').val();
  } else {
    var txtIdTipDoc = $('#txtIdTipDocSoli').val();
    var txtNroDoc = $('#txtNroDocSoli').val();
  }
  var txtNroDocLn = txtNroDoc.length;

  $("#txtNomSoli").val('');
  $("#txtPriApeSoli").val('');
  $("#txtSegApeSoli").val('');
  $("#txtIdSexoSoli").val('');
  $("#txtFecNacSoli").val('');
  $("#txtNroTelFijoSoli").val('');
  $("#txtNroTelMovilSoli").val('');
  $("#txtEmailSoli").val('');

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
    if (txtNroDocLn <= 9) {
      msg += "Ingrese el Nro. de documento correctamente<br/>";
      sw = false;
    }
  }

  if (sw == false) {
    bootbox.alert(msg);
    $('#btn-pac-search').prop("disabled", false);
    return false;
  }

  //$('#btnSoliSearch').prop("disabled", true);
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
      $("#txtIdSoli").val(datos[0]);
      if((datos[4] == null) || (datos[4] == "")){
        $('#txtIdSexoSoli').prop("disabled", false);
        $('#txtNomSoli').prop("readonly", false);
        $('#txtPriApeSoli').prop("readonly", false);
        $('#txtSegApeSoli').prop("readonly", false);
        $('#txtFecNacSoli').prop("disabled", false);
        $('#txtIdParenSoli').prop("disabled", false);
        $('#txtIdPaisNacSoli').prop("disabled", false);
        $('#txtIdEtniaSoli').prop("disabled", false);
        $("#txtIdSexoSoli").trigger('focus');
      } else {
        $("#txtIdTipDocSoli").val(datos[1]);
        $("#txtNroDocSoli").val(datos[3]);
        $("#txtNomSoli").val(datos[4]);
        $("#txtPriApeSoli").val(datos[5]);
        $("#txtSegApeSoli").val(datos[6]);
        $("#txtIdSexoSoli").val(datos[7]);
        $("#txtFecNacSoli").val(datos[9]);
        $("#txtIdPaisNacSoli").val(datos[21]).trigger("change");
        $("#txtNroTelFijoSoli").val(datos[11]);
        $("#txtNroTelMovilSoli").val(datos[12]);
        $("#txtEmailSoli").val(datos[13]);
        $('#txtNomSoli').prop("readonly", true);
        $('#txtPriApeSoli').prop("readonly", true);
        $('#txtSegApeSoli').prop("readonly", true);
        $('#txtIdSexoSoli').prop("disabled", true);
        $('#txtFecNacSoli').prop("disabled", true);
        $('#txtIdParenSoli').prop("disabled", false);
        if(datos[9] == ""){
          $('#txtFecNacSoli').prop("disabled", false);
        }
        if(datos[22] != ""){
          $("#txtIdEtniaSoli").val(datos[22]).trigger("change");
          $('#txtIdEtniaSoli').prop("disabled", true);
        } else {
          $('#txtIdEtniaSoli').prop("disabled", false);
        }
      }

      if(opt == "1"){
        $('#showSoliModal').modal({
          show: true,
          backdrop: 'static',
          focus: true,
        });

        $('#showSoliModal').on('shown.bs.modal', function (e) {
          /*$('#txtIdEtniaSoli').select2({
          dropdownParent: $('#showSoliModal')
        });*/
		$('#txtIdPaisNacSoli').select2();
        $('#txtIdEtniaSoli').select2();
		$('#txtIdParenSoli').select2();
        $('#txtIdParenSoli').select2('open');
      })
    } else {
      $("#txtNroTelFijoSoli").trigger('focus');
    }

  }
});
}

function delet_padding() {
  document.getElementsByTagName("body")[0].style.removeProperty("padding-right");
}

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

	jQuery('#txtNroDocSoli').keypress(function (tecla) {
	var idTipDocPer = $("#txtIdTipDocSoli").val();
	if (idTipDocPer == "1") {
	  if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
	  return false;
	} else {
	  if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode != 0))//(Numeros y letras)(0=borrar)
	  return false;
	}
	});

	jQuery('#txtPriApeSoli').keypress(function (tecla) {
		if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
		return false;
	});
	jQuery('#txtSegApeSoli').keypress(function (tecla) {
		if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
		return false;
	});
	jQuery('#txtNomSoli').keypress(function (tecla) {
		if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
		return false;
	});

	jQuery('#txtNroTelFijoSoli').keypress(function (tecla) {
		if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
		return false;
	});

	jQuery('#txtNroTelMovilSoli').keypress(function (tecla) {
		if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
		return false;
	});
	
	jQuery('#txtNroCama').keypress(function (tecla) {
		if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
		return false;
	});
	jQuery('#txtNroMuestra').keypress(function (tecla) {
		if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
		return false;
	});

	$('[name="txtTipPac"]').change(function(){
		enabled_datos_documento();
		maxlength_doc_bus();
		$('#txtNroHCPac').prop("disabled", false);
		enabled_datos_direccion();
		enabled_datos_atencion();

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

	$('[name="txtIdAntecedente"]').change(function(){
		if ($(this).is(':checked')) {
			$(".txtIdDetAntecedente").prop('checked', false);
			if($(this).val() == "1"){
				$('.txtIdDetAntecedente').prop("disabled", true);
			} else {
				$(".txtIdDetAntecedente").prop('disabled', false);
			}
		};
	});
	
	$('[name="txtIdDiagnostico"]').change(function(){
		if ($("#txtIdDiagnostico99").is(':checked')) {
			$('#txtDetDiagnostico').prop("disabled", false);
			setTimeout(function(){$('#txtDetDiagnostico').trigger('focus');}, 2);
		} else {
			$("#txtDetDiagnostico").prop('disabled', true);
		}
	});
	
	$('[name="txtIdTratamiento"]').change(function(){
		if ($(this).is(':checked')) {
			$("#txtDetTratamiento").val('');
			if($(this).val() == "99"){
				$('#txtDetTratamiento').prop("disabled", false);
				setTimeout(function(){$('#txtDetTratamiento').trigger('focus');}, 2);
			} else {
				$("#txtDetTratamiento").prop('disabled', true);
			}
		};
	});

	$('#txtIdEtniaPac').on("change", function (e) {
	if($(this).val() != ""){
	if($('#txtNroHCPac').val() != ""){
		if($('#txtUBIGEOPac').val() != ""){
		  $('#txtDirPac').trigger('focus');
		} else {
		  //$('#txtUBIGEOPac').select2('open');
		}
	} else {
		$('#txtNroHCPac').trigger('focus');
	}
	}
	});

	$('#txtUBIGEOPac').on("change", function (e) {
	if($(this).val() != ""){
	setTimeout(function(){$('#txtDirPac').trigger('focus');}, 2);
	}
	});
  
});

function validForm() {
  //$('#btnValidForm').prop("disabled", true);
  var msg = "";
  var sw = true;

  var idpac = $('#txtIdPac').val();
  var tippac = document.frmSolicitud.txtTipPac.value;
  var tipoparti = $('#txtIdTipPacParti').val();
  var docpac = $('#txtNroDocPac').val();

  if(tippac == ""){
    msg+= "Seleccione tipo del Paciente (SIS/PARTICULAR)<br/>";
    sw = false;
  }

  if(tippac == "0"){
    if(tipoparti == ""){
      msg+= "Seleccione tipo (PAGANTE/PROGAMA) paciente particular<br/>";
      sw = false;
    }
  }

  if(tippac == ""){
    msg+= "Ingrese Nro. de documento del Paciente<br/>";
    sw = false;
  }

  if(idpac == "0"){
    var sexopac = $('#txtIdSexoPac').val();
    var fecnacpac = $('#txtFecNacPac').val();
    var nompac = $('#txtNomPac').val();
    var priapepac = $('#txtPriApePac').val();
    var seapepac = $('#txtSegApePac').val();

    if(sexopac == ""){
      msg+= "Seleccione el sexo del Paciente<br/>";
      sw = false;
    }

    if(fecnacpac == ""){
      msg+= "Ingrese fecha de nacimiento del Paciente<br/>";
      sw = false;
    }

    if(nompac == ""){
      msg+= "Ingrese nombre del Paciente<br/>";
      sw = false;
    }

    if(priapepac == ""){
      if(seapepac == ""){
        msg+= "Ingrese el apellido paterno o materno del Paciente<br/>";
        sw = false;
      }
    }
  } else {
    var fecnacpac = $('#txtFecNacPac').val();
    if(fecnacpac == ""){
      msg+= "Ingrese fecha de nacimiento del Paciente<br/>";
      sw = false;
    }
  }

  var nrohcpac = $('#txtNroHCPac').val();
  var paispac = $('#txtIdPaisNacPac').val();
  var etniapac = $('#txtIdEtniaPac').val();
  var ubigeopac = $('#txtUBIGEOPac').val();
  var dirpac = $('#txtDirPac').val();
  var refdirpac = $('#txtDirRefPac').val();
  var telfipac = $('#txtNroTelFijoPac').val();
  var telmopac = $('#txtNroTelMovilPac').val();
  var emailpac = $('#txtEmailPac').val();

  if(paispac == ""){
    msg+= "Seleccione país de nacimiento del Paciente<br/>";
    sw = false;
  }

  if(etniapac == ""){
    msg+= "Seleccione Etnia del Paciente<br/>";
    sw = false;
  }

  if(nrohcpac == ""){
    msg+= "Ingrese historia clínica del Paciente<br/>";
    sw = false;
  }

  if(telfipac != ""){
    var ltelfipac = telfipac.length;
    if(ltelfipac < 7){
      msg+= "Ingrese correctamente el número de teléfono fijo de la Paciente<br/>";
      sw = false;
    }
  }

  if(telmopac != ""){
    var ltelmopac = telmopac.length;
    if(ltelmopac < 9){
      msg+= "Ingrese correctamente el número de teléfono móvil de la Paciente<br/>";
      sw = false;
    }
  }

  if(ubigeopac == ""){
    msg+= "Seleccione el Distrio de la dirección de la Paciente<br/>";
    sw = false;
  }

  if(emailpac != ""){
    if(validateEmail(emailpac) === false){
      msg+= "Ingrese correctamente el email del Paciente<br/>";
      sw = false;
    };
  }
  var id_dependencia = $('#txtIdEESS').val();
  var id_servicio = $('#txtIdServicio').val();
  var nro_cama = $('#txtNroCama').val();
  
  var id_tipomuestra = $('#txtIdTipMuestra').val();
  var id_antecedente = document.frmSolicitud.txtIdAntecedente.value;
  var id_detantecedente = document.frmSolicitud.txtIdDetAntecedente.value;
  var id_diagnostico = document.frmSolicitud.txtIdDiagnostico.value;
  var det_diagnostico = $('#txtDetDiagnostico').val();
  
  var nro_mestratamiento = $('#txtMesTratamiento').val();
  var id_esquematratamiento = document.frmSolicitud.txtIdTratamiento.value;
  var det_esquematratamiento = $('#txtDetTratamiento').val();
  
  var nro_muestra = $('#txtNroMuestra').val();
  var id_examen = $('#txtIdTipExamen').val();
  var id_pruebarapida = $('#txtIdTipoPruRapida').val();
  var id_pruebaconvencional = $('#txtIdMetodoPruConvencional').val();
  
  var fecha_atencion = $('#txtFecObtencion').val();
  var id_calidadmuestra = document.frmSolicitud.txtIdCaliMuestra.value;
  
	if(id_dependencia == ""){
      msg+= "Seleccione dependencia<br/>";
      sw = false;
    }
  
    if(fecha_atencion == ""){
      msg+= "Ingrese fecha de atención<br/>";
      sw = false;
    } else {
		f1 = fecha_atencion.split("/");
		f2 = fec_actu.split("/");
		var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
		var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014
		if (f1 > f2) {
			msg+= "La Fecha de atención debe ser menor o igual a la fecha actual.<br/>";
			sw = false;
		}
	}
	
	if(id_tipomuestra == ""){
      msg+= "Seleccione tipo de muestra<br/>";
      sw = false;
    }

	if ($('input.txtIdAntecedente').is(':checked')) {
	  if ($('#txtIdAntecedente2').is(':checked')) {
		if ($('input.txtIdDetAntecedente').is(':checked')) {
		} else {
			msg+= "Seleccione un motivo antes tratado<br/>";
			sw = false;			
		}
	  }
	} else {
		msg+= "Seleccione un antecedente de tratamiento<br/>";
		sw = false;
	}
	
	if ($('input.txtIdDiagnostico').is(':checked')) {
		$.each($('.txtIdDiagnostico:checked'), function() {
		  if($(this).val() == "99"){ //Cuando selecciona Otro
			if(det_diagnostico == ""){
				msg+= "Ingrese otro diagnóstico<br/>";
				sw = false;
			}
		  };
		});
	} else {
		msg+= "Seleccione un diagnóstico<br/>";
		sw = false;
	}
	
	if(nro_mestratamiento == ""){
      msg+= "Seleccione mes de tratamiento<br/>";
      sw = false;
    }

	if ($('input.txtIdTratamiento').is(':checked')) {
		$.each($('.txtIdTratamiento:checked'), function() {
		  if($(this).val() == "99"){ //Cuando selecciona Otro
			if(det_esquematratamiento == ""){
				msg+= "Ingrese otro esquema<br/>";
				sw = false;
			}
		  };
		});
	} else {
		msg+= "Seleccione un esquema<br/>";
		sw = false;
	}
	
	/*if(nro_muestra == ""){
      msg+= "Ingrese número de muestra<br/>";
      sw = false;
    }*/
	
	if(id_examen == ""){
      msg+= "Seleccione examen a solicitar<br/>";
      sw = false;
    }
	
	if ($('input.txtIdCaliMuestra').is(':checked')) {
	} else {
		msg+= "Seleccione calidad de la muestra<br/>";
		sw = false;
	}

	if (sw == false) {
	  bootbox.alert(msg);
	  $('#btnValidForm').prop("disabled", false);
	  return false;
	}

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

        if ($('input.txtIdDiagnostico').is(':checked')) {
          var diagnostico = [];
          $.each($('.txtIdDiagnostico:checked'), function() {
            diagnostico.push($(this).val());
          });
        } else {
          var diagnostico = '';
        }
		
        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlBacteriologia.php',
          data: {
            accion: 'POST_ADD_REGSOLICITUD',
            txtTipPac: document.frmSolicitud.txtTipPac.value, txtIdTipPacParti: $("#txtIdTipPacParti").val(), 
            txtIdPac: document.frmSolicitud.txtIdPac.value, txtIdTipDocPac: document.frmSolicitud.txtIdTipDocPac.value, txtNroDocPac: document.frmSolicitud.txtNroDocPac.value, txtNroHCPac: document.frmSolicitud.txtNroHCPac.value, txtNomPac: document.frmSolicitud.txtNomPac.value, txtPriApePac: document.frmSolicitud.txtPriApePac.value, txtSegApePac: document.frmSolicitud.txtSegApePac.value, txtIdSexoPac: document.frmSolicitud.txtIdSexoPac.value, txtFecNacPac: document.frmSolicitud.txtFecNacPac.value, txtIdPaisNacPac: document.frmSolicitud.txtIdPaisNacPac.value, txtIdEtniaPac: document.frmSolicitud.txtIdEtniaPac.value, txtUBIGEOPac: document.frmSolicitud.txtUBIGEOPac.value, txtDirPac: document.frmSolicitud.txtDirPac.value, txtDirRefPac: document.frmSolicitud.txtDirRefPac.value, txtNroTelFijoPac: document.frmSolicitud.txtNroTelFijoPac.value, txtNroTelMovilPac: document.frmSolicitud.txtNroTelMovilPac.value, txtEmailPac: document.frmSolicitud.txtEmailPac.value,
            txtIdSoli: document.frmSolicitud.txtIdSoli.value, txtIdTipDocSoli: document.frmSolicitante.txtIdTipDocSoli.value, txtNroDocSoli: document.frmSolicitante.txtNroDocSoli.value, txtNomSoli: document.frmSolicitante.txtNomSoli.value, txtPriApeSoli: document.frmSolicitante.txtPriApeSoli.value, txtSegApeSoli: document.frmSolicitante.txtSegApeSoli.value, txtIdSexoSoli: document.frmSolicitante.txtIdSexoSoli.value, txtFecNacSoli: document.frmSolicitante.txtFecNacSoli.value, txtIdParenSoli: document.frmSolicitante.txtIdParenSoli.value, txtIdPaisNacSoli: document.frmSolicitante.txtIdPaisNacSoli.value, txtIdEtniaSoli: document.frmSolicitante.txtIdEtniaSoli.value, txtNroTelFijoSoli: document.frmSolicitante.txtNroTelFijoSoli.value, txtNroTelMovilSoli: document.frmSolicitante.txtNroTelMovilSoli.value, txtEmailSoli: document.frmSolicitante.txtEmailSoli.value,
            id_atencion: document.frmSolicitud.txtIdAtencion.value, id_dependencia: id_dependencia, id_servicio: id_servicio, nro_cama: nro_cama,
			id_tipomuestra: id_tipomuestra, id_antecedente: id_antecedente,id_detantecedente: id_detantecedente, id_diagnostico: diagnostico, det_diagnostico: det_diagnostico,
			nro_mestratamiento: nro_mestratamiento, id_esquematratamiento: id_esquematratamiento, det_esquematratamiento: det_esquematratamiento,
			nro_muestra: nro_muestra, id_examen: id_examen, id_pruebarapida: id_pruebarapida, id_pruebaconvencional: id_pruebaconvencional, 
			desc_factor: document.frmSolicitud.txtDetFactores.value, fecha_atencion: fecha_atencion, id_calidadmuestra: id_calidadmuestra, desc_observacion: document.frmSolicitud.txtObsSoli.value,
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $('#txtIdAtencion').val(msg);
			  window.location = './main_principalsoli.php';
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
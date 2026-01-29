var items_arr_diagnostico = [];
var id_items_diagnostico = 1;

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
      valid_atencion_anterior('regpap');
    } else if (campo == 'txtPriApePac') {
      if ($('#txtPriApePac').val() != ""){//Este if cambia es para ver si es sis tiene que ir a nro FUA
		  if (document.frmSolicitud.txtTipPac.value != "1"){
			if($('#txtIdEtniaPac').val() != ""){
			  $('#txtUBIGEOPac').select2('open');
			} else {
			  $('#txtIdEtniaPac').select2('open');
			}
		  } else {
			  setTimeout(function(){$('#txtNroFUA').trigger('focus');}, 2);
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
          buscar_datos_personales_soli('1','regpap');
    } else if (campo == 'btnSoliSearch') {
          buscar_datos_personales_soli('2','regpap');
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
  //$("#txtIdSexoPac").val('');
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
    //$("#txtIdSexoPac").prop("disabled", true);
    //$("#txtIdSexoPac").val('2');
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
    //$("#txtIdSexoPac").prop("disabled", true);
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
  $('#txtIdCondiDepen').prop("disabled", false);
  $('#txtIdCondiServ').prop("disabled", false);
  $('#txtIRS').prop("disabled", false);
  $('.check_fur').prop("disabled", false);
  $('.check_gestante').prop("disabled", false);
  $('#txtGest').prop("disabled", false);
  $('#txtPARA1').prop("disabled", false);
  $('#txtPARA2').prop("disabled", false);
  $('#txtPARA3').prop("disabled", false);
  $('#txtPARA4').prop("disabled", false);

  $('#txtPesoPac').prop("disabled", false);
  $('#txtTallaPac').prop("disabled", false);
  $('#txtPAPac').prop("disabled", false);
  $('#txtObsSoli').prop("disabled", false);
}

function enabled_datos_tamizaje() {
  $('#txtPAPANte').prop("disabled", false);
}

function enabled_datos_anticonceptivo() {
  $('.check_anticonceptivo').prop("disabled", false);
}

function enabled_datos_sintoma() {
  $('.check_sintoma').prop("disabled", false);
}

function enabled_datos_examen() {
  $('.check_exacervico').prop("disabled", false);
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
        newOption += "<option value='" + oo.id_ubigeo.trim() + "'"
        if(oo.id_ubigeo == id){
          newOption += " selected";
        }
        newOption += ">" + oo.provincia + " - " + oo.distrito + "</option>";
      });
      $('#txtUBIGEOPac').html(newOption);
      $("#txtUBIGEOPac").val('').trigger("change");
    }
  });
}

function valid_atencion_anterior(opcion){
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
    if (txtNroDocLn <= 6) {
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
				buscar_datos_personales(opcion);
			  } else {
				  setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
			  }
			}
		});
	  } else if(datos[0] == 2){
			$('#div_btn_atencion').show();
			buscar_datos_personales(opcion);
	  } else {
			buscar_datos_personales(opcion);
	  }
    }
  });
}

function buscar_datos_personales(origen){
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
    if (txtNroDocLn <= 6) {
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
      accion: 'GET_SHOW_PERSONULTIMAATENCIONPORIDDEP', txtIdTipDoc: txtIdTipDoc, txtNroDoc: txtNroDoc, interfaz: origen
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
          $("#txtNomPac").val(datos[4]);
          $("#txtPriApePac").val(datos[5]);
          $("#txtSegApePac").val(datos[6]);
          $("#txtIdSexoPac").val('2');
          $("#txtFecNacPac").val(datos[9]);
          $("#txtEdadPac").val(datos[20]);
          $("#txtNroTelFijoPac").val(datos[11]);
          $("#txtNroTelMovilPac").val(datos[12]);
          $("#txtEmailPac").val(datos[13]);
		  var ubigeopac = datos[14].trim();
		  var departamentopac = ubigeopac.substr(-20,2);
		  if (departamentopac != "14"){
			$("#txtUBIGEOPac").val("").trigger("change");
		  } else {
			$("#txtUBIGEOPac").val(ubigeopac).trigger("change");  
		  }
          $("#txtNroHCPac").val(datos[10]);
          $("#txtIdPaisNacPac").val(datos[21]).trigger("change");
          $("#txtDirPac").val(datos[18]);
          $("#txtDirRefPac").val(datos[19]);
          $('#txtNomPac').prop("readonly", true);
          $('#txtPriApePac').prop("readonly", true);
          $('#txtSegApePac').prop("readonly", true);
          $('#txtIdSexoPac').prop("disabled", false);
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

      $('#txtIdTipDocSoliT').prop("disabled", false);
      $('#txtNroDocSoliT').prop("disabled", false);
      $('#btnSoliTSearch').prop("disabled", false);
    }
  });
  setTimeout(function(){delet_padding();}, 1000);
}

function buscar_datos_personales_soli(opt, origen){
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
      accion: 'GET_SHOW_PERSONULTIMAATENCIONPORIDDEP', txtIdTipDoc: txtIdTipDoc, txtNroDoc: txtNroDoc, interfaz: origen
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
        $('#txtIdEtniaSoli').select2();
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

function clearDataDiagnosticos() {
    $("#txt_id_cie").val("").prop("disabled", false).trigger("change");
}

function renderItemsDetalleDiagnosticos() {
    if (items_arr_diagnostico.length > 0) {
        var htmlRows = "";
        for (var i = 0; i < items_arr_diagnostico.length; i++) {
            var del = "<button type='button' class='btn btn-success btn-xs' onclick='event.preventDefault();deleteItemDiagnosticos(" + items_arr_diagnostico[i][0] + ")'><i class='fa fa-remove'></i> Quitar</button>";

            htmlRows +=
                "<tr>" +
                "<td class='text-center'>" + del + "</td>" +
                "<td>" + items_arr_diagnostico[i][1] + "</td>" +
                "<td>" + items_arr_diagnostico[i][2] + "</td>" +
                "</tr>";
        }
        $("#tbl_items_diagnosticos").html(htmlRows);

    } else {
        $("#tbl_items_diagnosticos").html("");
    }
}

function addItemDetalleDiagnostico(e) {
    if (e) e.preventDefault();
    var cie10 = $("#txt_id_cie").val();
    var cie_text = $("#txt_id_cie option:selected").text();

    var msg = "";
    if (!cie10) msg = "Seleccione Diagnóstico";

    if (msg) return bootbox.alert(msg);
    for (var i = 0; i < items_arr_diagnostico.length; i++) {
        if (cie10 == items_arr_diagnostico[i][1]) {
            msg = "Diagnóstico ya está agregado";
            break;
        }
    }
	if (msg) return bootbox.alert(msg);

	var data = [
		/*00*/ id_items_diagnostico,
		/*01*/ cie10,
		/*02*/ cie_text
	];
	items_arr_diagnostico.push(data);
	id_items_diagnostico++;
	renderItemsDetalleDiagnosticos();
	clearDataDiagnosticos();
}

function deleteItemDiagnosticos(id_item){
    var index = null;
    for(var i=0;i<items_arr_diagnostico.length;i++){
        if(id_item == items_arr_diagnostico[i][0]){
            index = i;
            break;
        }
    }
    items_arr_diagnostico.splice(index,1);
    renderItemsDetalleDiagnosticos();
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

	jQuery('#txtPesoPac').keypress(function (tecla) {
	if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0) && (tecla.charCode != 46))//(Solo Numeros)(0=borrar) (punto)
	return false;
	});

	jQuery('#txtTallaPac').keypress(function (tecla) {
	if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0) && (tecla.charCode != 46))//(Solo Numeros)(0=borrar) (punto)
	return false;
	});

	jQuery('#txtPAPac').keypress(function (tecla) {
	if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0) && (tecla.charCode != 47))//(Solo Numeros)(0=borrar) (slash)
	return false;
	});

	jQuery('#txtNroRefDepPac').keypress(function (tecla) {
	if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
	return false;
	});

	jQuery('#txAnioResulAnte').keypress(function (tecla) {
	if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
	return false;
	});

	$('[name="txtTipPac"]').change(function(){
		enabled_datos_documento();
		maxlength_doc_bus();
		$('#txtNroHCPac').prop("disabled", false);
		enabled_datos_direccion();
		enabled_datos_atencion();
		enabled_datos_tamizaje();
		enabled_datos_anticonceptivo();
		enabled_datos_sintoma();
		enabled_datos_examen();

		if($(this).val() == "1"){
		  $("#datos-sis").show();
		  $("#txtNroFUA").val('');
		  $("#txtCodPrestacional").val('024');
		  $("#txtIdTipPacParti").val('');
		  $('#txtIdTipPacParti').prop("disabled", true);
		  setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
		} else {
		  $("#datos-sis").hide();
		  $("#txtNroFUA").val('');
		  $("#txtCodPrestacional").val('');
		  $("#txtIdTipPacParti").val('');
		  $('#txtIdTipPacParti').prop("disabled", false);
		  setTimeout(function(){$('#txtIdTipPacParti').trigger('focus');}, 2);
		}
	});

	$('[name="txtAnticonceptivo"]').change(function()
	{
	if ($(this).is(':checked')) {
	  if ($('#txtAnticonceptivo6').is(':checked')) {
		$("#txtDetAnticonceptivo").prop('disabled', false);
		setTimeout(function(){$('#txtDetAnticonceptivo').trigger('focus');}, 2);
	  } else {
		$("#txtDetAnticonceptivo").val('');
		$("#txtDetAnticonceptivo").prop('disabled', true);
	  }
	} else {
	  if ($('#txtAnticonceptivo6').is(':checked')) {
		$("#txtDetAnticonceptivo").prop('disabled', false);
		setTimeout(function(){$('#txtDetAnticonceptivo').trigger('focus');}, 2);
	  } else {
		$("#txtDetAnticonceptivo").val('');
		$("#txtDetAnticonceptivo").prop('disabled', true);
	  }
	};
	});

	$('[name="txtPAPANte"]').change(function(){
		$(".opt_resulanteexa").prop('disabled', true);
		$(".opt_resulanteexa").prop('checked', false);
		if(($(this).val() == "") || ($(this).val() == "0")){
			$(".opt_resulante").prop('checked', false);
			$(".opt_resulante").prop('disabled', true);
			$("#txAnioResulAnte").val('');
			$("#txAnioResulAnte").prop('disabled', true);
		} else {
			$(".opt_resulante").prop('checked', false);
			$(".opt_resulante").prop('disabled', false);
			$("#txAnioResulAnte").val('');
			$("#txAnioResulAnte").prop('disabled', false);
		}
	});

	$('[name="txtResultadoAnte"]').change(function(){
		if ($(this).is(':checked')) {
			if($(this).val() == "1"){//Positivo
				$(".opt_detresulante").prop('checked', false);
				$(".opt_detresulante").prop('disabled', false);
				$(".opt_resulanteexa").prop('disabled', false);
				$(".opt_resulanteexa").prop('checked', false);
				$("#show-resultadoanteexa").show();

				if(($("#txtPAPANte").val() == "1") || ($("#txtPAPANte").val() == "3")){
					$(".opt_anorescamosa").prop('checked', false);
					$(".opt_anorescamosa").prop('disabled', false);
					$(".opt_anorglandular").prop('checked', false);
					$(".opt_anorglandular").prop('disabled', false);
				} else {
					$(".opt_anorescamosa").prop('checked', false);
					$(".opt_anorescamosa").prop('disabled', true);
					$(".opt_anorglandular").prop('checked', false);
					$(".opt_anorglandular").prop('disabled', true);
				}

				//setTimeout(function(){$('#txAnioResulAnte').trigger('focus');}, 2);
			}
			if($(this).val() == "2"){//Negativo
				$(".opt_detresulante").prop('checked', false);
				$(".opt_detresulante").prop('disabled', true);

				$(".opt_resulanteexa").prop('disabled', true);
				$(".opt_resulanteexa").prop('checked', false);

				$(".opt_anorescamosa").prop('checked', false);
				$(".opt_anorescamosa").prop('disabled', true);
				$(".opt_anorglandular").prop('checked', false);
				$(".opt_anorglandular").prop('disabled', true);
				$("#show-resultadoanteexa").hide();

				setTimeout(function(){$('#txAnioResulAnte').trigger('focus');}, 2);
			}
		}
	});

	$('[name="txtAnorEscamosa"]').change(function()
	{
	if ($(this).is(':checked')) {
	  $(".opt_anorglandular").prop('disabled', true);
	};
	});

	$('[name="txtAnorGlandular"]').change(function()
	{
	if ($(this).is(':checked')) {
	  $(".opt_anorescamosa").prop('disabled', true);
	};
	});


	$('[name="txtSintoma"]').change(function()
	{
	if ($(this).is(':checked')) {
	  if ($('#txtSintoma6').is(':checked')) {
		$("#txtDetSintoma").prop('disabled', false);
		setTimeout(function(){$('#txtDetSintoma').trigger('focus');}, 2);
	  } else {
		$("#txtDetSintoma").val('');
		$("#txtDetSintoma").prop('disabled', true);
	  }
	} else {
	  if ($('#txtSintoma').is(':checked')) {
		$("#txtDetSintoma").prop('disabled', false);
		setTimeout(function(){$('#txtDetSintoma').trigger('focus');}, 2);
	  } else {
		$("#txtDetSintoma").val('');
		$("#txtDetSintoma").prop('disabled', true);
	  }
	};
	});

	$('[name="txtFUR"]').change(function()
	{
	if ($(this).is(':checked')) {
	  $("#txtFechaFUR").prop('disabled', false);
	  var mask = "dd/mm/yyyy";
	  if($(this).val() == "1"){
		$("#txtFechaFUR").inputmask();
		$('#txtFechaFUR').datetimepicker({
		  locale: 'es',
		  format: 'L'
		});
		$("#txtFechaFUR").attr('maxlength', '10');
	  } else {
		$("#txtFechaFUR").inputmask('remove');
		$("#txtFechaFUR").datetimepicker('destroy');
		$("#txtFechaFUR").attr('maxlength', '15');
		$("#txtFechaFUR").val('');
	  }
	  setTimeout(function(){$('#txtFechaFUR').trigger('focus');}, 2);
	};
	});

	$('[name="txtIdGestante"]').change(function()
	{
	if ($(this).is(':checked')) {
	  var mask = "dd/mm/yyyy";
	  if($(this).val() == "1"){
		$("#txtFechaParto").prop('disabled', false);
		$("#txtFechaParto").inputmask();
		$('#txtFechaParto').datetimepicker({
		  locale: 'es',
		  format: 'L'
		});
		setTimeout(function(){$('#txtFechaParto').trigger('focus');}, 2);
	  } else {
		$("#txtFechaParto").prop('disabled', true);
		$("#txtFechaParto").inputmask('remove');
		$("#txtFechaParto").datetimepicker('destroy');
		$("#txtFechaParto").val('');
		setTimeout(function(){$('#txtPesoPac').trigger('focus');}, 2);
	  }
	};
	});


	$('#txtIdEtniaPac').on("change", function (e) {
	if($(this).val() != ""){
	if($('#txtNroHCPac').val() != ""){  
		if($('#txtUBIGEOPac').val() != ""){
		  $('#txtDirPac').trigger('focus');
		} else {
		  $('#txtUBIGEOPac').select2('open');
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
  ubigeopac = ubigeopac.trim();
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

  var condieess = $('#txtIdCondiDepen').val();
  var condiserv = $('#txtIdCondiServ').val();
  var irs = document.frmSolicitud.txtIRS.value;
  var fur = document.frmSolicitud.txtFUR.value;
  var fecfur = document.frmSolicitud.txtFechaFUR.value;
  var gestante = document.frmSolicitud.txtIdGestante.value;
  var fecparto = $('#txtFechaParto').val();
  var papante = $('#txtPAPANte').val();
  var edadpac = $('#txtEdadPac').val();

  if(condieess == ""){
    msg+= "Seleccione condición del paciente en el EESS<br/>";
    sw = false;
  }

  if(condiserv == ""){
    msg+= "Seleccione condición del paciente en el servicio<br/>";
    sw = false;
  }

  if(fur == ""){
    msg+= "Seleccione si la paciente tiene o no FUR<br/>";
    sw = false;
  }

  if(fur == "1"){
    if(fecfur == ""){
      msg+= "Ingrese fecha de FUR<br/>";
      sw = false;
    } else {
		f1 = fecfur.split("/");
		f2 = fec_actu.split("/");
		var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
		var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014
		if (f1 > f2) {
			msg+= "La Fecha de FUR debe ser menor o igual a la fecha actual.<br/>";
			sw = false;
		}
	}
  }

  if(irs != ""){
    if(parseFloat(edadpac) < parseFloat(irs)){
      msg+= "La edad IRS debe ser menor o igual a edad del paciente<br/>";
      sw = false;
    }
  }

  if(gestante == ""){
    msg+= "Seleccione si la paciente es gestante<br/>";
    sw = false;
  }

  if(gestante == "1"){
    if(fecparto == ""){
      msg+= "Ingrese fecha posible de parto<br/>";
      sw = false;
    }
  }

  if ($('#txtAnticonceptivo6').is(':checked')) {
    if(fecfur == ""){
      msg+= "Ingrese detalle de otro Método Anticonceptivo<br/>";
      sw = false;
    }
  }

	if(papante != "") {
		if(papante == "1" || papante == "2"){

		  if ($('input.opt_resulante').is(':checked')) { //Positivo o Negativo
			$.each($('.opt_resulante:checked'), function() {
			  if($(this).val() == "1"){ //Cuando selecciona positivo
				if ($('input.opt_anorescamosa').is(':checked')) {
				} else {
				  if ($('input.opt_anorglandular').is(':checked')) {
				  } else {
					msg+= "Seleccione el detalle del resultado final del examen Anterior<br/>";
					sw = false;
				  }
				}

			  };
			});
		  } else {
			msg+= "Seleccione si el resultado del examen de PAP o Biopsia fue positivo o negativo<br/>";
			sw = false;
		  }
		  var nroregresul = $('#txAnioResulAnte').val();
		  if(nroregresul == ""){
			msg+= "Ingrese año de tamizaje anterior<br/>";
			sw = false;
		  }
		} else if (papante == "0") {

		} else {
		  var nroregresul = $('#txAnioResulAnte').val();
		  if(nroregresul == ""){
			msg+= "Ingrese año de tamizaje anterior<br/>";
			sw = false;
		  }
		}
	} else {
		msg+= "Seleccione el tipo de tamizaje anterior del paciente<br/>";
		sw = false;
	}
	
  if(nroregresul != ""){
    if(parseFloat(nroregresul) > parseFloat(year)){
      msg+= "El año del tamizaje anterior no debe ser mayor al año actual<br/>";
      sw = false;
    }
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
        if ($('input.check_anticonceptivo').is(':checked')) {
          var anticonceptivo = [];
          $.each($('.check_anticonceptivo:checked'), function() {
            anticonceptivo.push($(this).val());
          });
        } else {
          var anticonceptivo = '';
        }

        if ($('input.check_sintoma').is(':checked')) {
          var sintoma = [];
          $.each($('.check_sintoma:checked'), function() {
            sintoma.push($(this).val());
          });
        } else {
          var sintoma = '';
        }
        if ($('input.check_exacervico').is(':checked')) {
          var exacervico = [];
          $.each($('.check_exacervico:checked'), function() {
            exacervico.push($(this).val());
          });
        } else {
          var exacervico = '';
        }
        if ($('input.opt_resulanteexa').is(':checked')) {
          var resulanteexa = [];
          $.each($('.opt_resulanteexa:checked'), function() {
            resulanteexa.push($(this).val());
          });
        } else {
          var resulanteexa = '';
        }

        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlPAP.php',
          data: {
            accion: 'POST_ADD_REGSOLICITUD',
            txtTipPac: document.frmSolicitud.txtTipPac.value, txtIdTipPacParti: $("#txtIdTipPacParti").val(), txtNroFUA: document.frmSolicitud.txtNroFUA.value, txtCodPrestacional: document.frmSolicitud.txtCodPrestacional.value,
            txtIdPac: document.frmSolicitud.txtIdPac.value, txtIdTipDocPac: document.frmSolicitud.txtIdTipDocPac.value, txtNroDocPac: document.frmSolicitud.txtNroDocPac.value, txtNroHCPac: document.frmSolicitud.txtNroHCPac.value, txtNomPac: document.frmSolicitud.txtNomPac.value, txtPriApePac: document.frmSolicitud.txtPriApePac.value, txtSegApePac: document.frmSolicitud.txtSegApePac.value, txtIdSexoPac: document.frmSolicitud.txtIdSexoPac.value, txtFecNacPac: document.frmSolicitud.txtFecNacPac.value, txtIdPaisNacPac: document.frmSolicitud.txtIdPaisNacPac.value, txtIdEtniaPac: document.frmSolicitud.txtIdEtniaPac.value, txtUBIGEOPac: document.frmSolicitud.txtUBIGEOPac.value, txtDirPac: document.frmSolicitud.txtDirPac.value, txtDirRefPac: document.frmSolicitud.txtDirRefPac.value, txtNroTelFijoPac: document.frmSolicitud.txtNroTelFijoPac.value, txtNroTelMovilPac: document.frmSolicitud.txtNroTelMovilPac.value, txtEmailPac: document.frmSolicitud.txtEmailPac.value,
            txtIdSoli: document.frmSolicitud.txtIdSoli.value, txtIdTipDocSoli: document.frmSolicitante.txtIdTipDocSoli.value, txtNroDocSoli: document.frmSolicitante.txtNroDocSoli.value, txtNomSoli: document.frmSolicitante.txtNomSoli.value, txtPriApeSoli: document.frmSolicitante.txtPriApeSoli.value, txtSegApeSoli: document.frmSolicitante.txtSegApeSoli.value, txtIdSexoSoli: document.frmSolicitante.txtIdSexoSoli.value, txtFecNacSoli: document.frmSolicitante.txtFecNacSoli.value, txtIdParenSoli: document.frmSolicitante.txtIdParenSoli.value, txtIdPaisNacSoli: document.frmSolicitante.txtIdPaisNacSoli.value, txtIdEtniaSoli: document.frmSolicitante.txtIdEtniaSoli.value, txtNroTelFijoSoli: document.frmSolicitante.txtNroTelFijoSoli.value, txtNroTelMovilSoli: document.frmSolicitante.txtNroTelMovilSoli.value, txtEmailSoli: document.frmSolicitante.txtEmailSoli.value,
            txtIdAtencion: document.frmSolicitud.txtIdAtencion.value, txtIdCondiDepen: document.frmSolicitud.txtIdCondiDepen.value, txtIdCondiServ: document.frmSolicitud.txtIdCondiServ.value, txtFUR: document.frmSolicitud.txtFUR.value, txtFechaFUR: document.frmSolicitud.txtFechaFUR.value, txtIdGestante: document.frmSolicitud.txtIdGestante.value, txtFechaParto: document.frmSolicitud.txtFechaParto.value, txtGest: document.frmSolicitud.txtGest.value, txtPARA1: document.frmSolicitud.txtPARA1.value, txtPARA2: document.frmSolicitud.txtPARA2.value, txtPARA3: document.frmSolicitud.txtPARA3.value, txtPARA4: document.frmSolicitud.txtPARA4.value, txtPesoPac: document.frmSolicitud.txtPesoPac.value, txtTallaPac: document.frmSolicitud.txtTallaPac.value, txtPAPac: document.frmSolicitud.txtPAPac.value, txtIMCPac: document.frmSolicitud.txtIMCPac.value,
            txtPAPANte: document.frmSolicitud.txtPAPANte.value, txtResultadoAnte: document.frmSolicitud.txtResultadoAnte.value, txtResultadoAnteExa: resulanteexa, txAnioResulAnte: document.frmSolicitud.txAnioResulAnte.value, txtAnorEscamosa: document.frmSolicitud.txtAnorEscamosa.value, txtAnorGlandular: document.frmSolicitud.txtAnorGlandular.value,
            txtAnticonceptivo: anticonceptivo, txtDetAnticonceptivo: document.frmSolicitud.txtDetAnticonceptivo.value, txtSintoma: sintoma, txtDetSintoma: document.frmSolicitud.txtDetSintoma.value,
            txtIRS: document.frmSolicitud.txtIRS.value, txtObsSoli: document.frmSolicitud.txtObsSoli.value,
            txtExaCervico: exacervico,
            txtIdDiagnostico: dd, diagnosticos: JSON.stringify(items_arr_diagnostico),
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $('#txtIdAtencion').val(msg);
              saveViaAJAX(msg);
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
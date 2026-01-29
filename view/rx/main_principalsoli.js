
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
  $('.opt_tbc').prop("disabled", false);
  $('#txtIdDepRef').prop("disabled", false);
  $('#txtIdTipExa').prop("disabled", false);
  $('#txtObsSoli').prop("disabled", false);

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
            setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
          }
        });
      } else if(datos[0] == "C"){
        $('#txtIdSexoPac').prop("disabled", false);
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
            setTimeout(function(){$('#txtNroHCPac').trigger('focus');}, 2);
          }
        });
      } else if((datos[4] == null) || (datos[4] == "")){
        $('#txtIdSexoPac').prop("disabled", false);
        $('#txtNomPac').prop("readonly", false);
        $('#txtPriApePac').prop("readonly", false);
        $('#txtSegApePac').prop("readonly", false);
        $('#txtFecNacPac').prop("disabled", false);
        $('#txtIdPaisNacPac').prop("disabled", false);
        $('#txtIdEtniaPac').prop("disabled", false);
        //$("#txtIdPaisNacPac").val('').trigger("change");
        //$("#txtIdEtniaPac").val('').trigger("change");
        $("#txtNroHCPac").trigger('focus');
      } else {
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
          if(datos[10] == ""){
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

      $('#txtIdTipDocSoliT').prop("disabled", false);
      $('#txtNroDocSoliT').prop("disabled", false);
      $('#btnSoliTSearch').prop("disabled", false);
    }
  });
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
        $('#txtIdEtniaSoli').select2();
        $('#txtIdParenSoli').select2('open');
      })
    } else {
      $("#txtNroTelFijoSoli").trigger('focus');
    }

  }
});
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

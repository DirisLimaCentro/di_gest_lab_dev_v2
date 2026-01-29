function back() {
  window.location = '../pages/';
}

function delet_padding() {
  document.getElementsByTagName("body")[0].style.removeProperty("padding-right");
}

function exportar_busqueda() {
	window.location = './xls_repprofesional.php';
}

function get_listaServicio(name,nameresul) {
    var txtIdDep = $('#'+name).val();
    if (txtIdDep == ""){
      $("#"+nameresul).val('').trigger("change");
      $('#'+nameresul).prop("disabled", true);
      return false;
    }
    $.ajax({
      url: "../../controller/ctrlServicio.php",
      type: "POST",
      dataType: "json",
      data: {
        accion: 'GET_SHOW_LISTASERVICIODEPPORIDDEP', txtIdDep: txtIdDep
      },
      success: function (result) {
        $('#'+nameresul).prop("disabled", false);
        var newOption = "";
        newOption = "<option value=''>--Seleccionar-</option>";
        $(result).each(function (ii, oo) {
          newOption += "<option value='" + oo.id_serviciodep + "'>" + oo.nom_servicio + "</option>";
        });
        $('#'+nameresul).html(newOption);
        $("#"+nameresul).select2({max_selected_options: 4});
      }
    });
}

function open_firma(idprofe) {
    document.frmUsuario.txtIdProfesional.value = idprofe;
    $('#imgFirma1').val('');
    $('#showFirmaModal').modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });
}

function reg_registro(action,data) {
	if(action == "ins"){
		document.frmUsuario.txtIdProfesional.value = '0';
		document.frmUsuario.txtIdPer.value = '';
		$("#txtIdTipDoc").val('1').trigger("change");
		document.frmUsuario.txtNroDoc.value = '';
		document.frmUsuario.txtIdSexoPac.value = '';
		document.frmUsuario.txtFecNacPac.value = '';
		document.frmUsuario.txtNomPac.value = '';
		document.frmUsuario.txtPriApePac.value = '';
		document.frmUsuario.txtSegApePac.value = '';
		document.frmUsuario.txtNroTelFijoPac.value = '';
		document.frmUsuario.txtNroTelMovilPac.value = '';
		document.frmUsuario.txtEmailPac.value = '';

		document.frmUsuario.txtIdProfesion.value = '';
		document.frmUsuario.txtNroCole.value = '';
		document.frmUsuario.txtNroRne.value = '';
		$('#txtIdTipDoc').prop("disabled", false);
		$('#txtNroDoc').prop("disabled", false);
		$('#btn-pac-search').prop("disabled", false);
		$('#imgFirma').prop("disabled", false);
	} else {
		document.frmUsuario.txtIdProfesional.value = data.id_profesional;
		document.frmUsuario.txtIdPer.value = data.id_paciente;
		$("#txtIdTipDoc").val(data.id_tipodocpac).trigger("change");
		document.frmUsuario.txtNroDoc.value = data.nro_docpac;
		document.frmUsuario.txtIdSexoPac.value = '';
		document.frmUsuario.txtFecNacPac.value = '';
		document.frmUsuario.txtNomPac.value = data.nombre_rspro;
		document.frmUsuario.txtPriApePac.value = '';
		document.frmUsuario.txtSegApePac.value = '';
		document.frmUsuario.txtNroTelFijoPac.value = '';
		document.frmUsuario.txtNroTelMovilPac.value = '';
		document.frmUsuario.txtEmailPac.value = '';
		
		$("#txtIdProfesion").val(data.id_profesion).trigger("change");
		document.frmUsuario.txtNroCole.value = data.nro_colegiatura;
		document.frmUsuario.txtNroRne.value = data.nro_rne;
		document.frmUsuario.txt_id_condicion_laboral.value = data.id_condicion_laboral;
		$('#txtIdTipDoc').prop("disabled", true);
		$('#txtNroDoc').prop("disabled", true);
		$('#btn-pac-search').prop("disabled", true);
		$('#imgFirma').prop("disabled", true);
		
		buscar_datos_personales();
	}
	  
	$('#showUsuarioModal').modal({
	  show: true,
	  backdrop: 'static',
	  focus: true,
	});
	$('#showUsuarioModal').on('shown.bs.modal', function (e) {

	  $("#txtNroDoc").trigger('focus');
	})
}

function reg_servicio(action, id_prof, idusu,nomusu) {
	if(action == "ins"){
		document.frmServicio.txtIdProfesionalServicio.value = '0';
		document.frmServicio.ser_txtIdProfesional.value = id_prof;
		$("#ser_txtIdDep").val('').trigger("change");
		$("#ser_txtIdServicioDep").val('').trigger("change");
		document.frmServicio.ser_txtIdCargo.value = '';
		$('#ser_txtIdDep').prop("disabled", false);
		$('#ser_txtIdServicioDep').prop("disabled", false);
		
		document.frmServicio.ser_txtIdUsuario.value = idusu;
		document.frmServicio.txtNomUsuario.value = nomusu;
		document.frmServicio.txtIdRol.value = '';
		if (idusu == ""){
			$('#txtIdRol').prop("disabled", true);
			$('#alert-no-user').show();
		} else {
			$('#txtIdRol').prop("disabled", false);
			$('#alert-no-user').hide();
		}
		
	} else {
		var data = JSON.parse($("#pr_"+id_prof).text());
		document.frmServicio.txtIdProfesionalServicio.value = data.id;
		document.frmServicio.ser_txtIdProfesional.value = data.id_profesional;
		$("#ser_txtIdDep").append('<option value="' + data.id_dependencia + '" selected>' + data.nom_depen + '</option>').trigger("change");
		document.frmServicio.ser_txtIdCargo.value = data.id_cargo;
		document.frmServicio.ser_txtIdUsuario.value = data.id_usuario;
		document.frmServicio.txtNomUsuario.value = data.nom_usuario;
		document.frmServicio.txtIdRol.value = data.id_rol;
		$('#ser_txtIdDep').prop("disabled", true);
		setTimeout(function(){$("#ser_txtIdServicioDep").append('<option value="' + data.id_servicio + '" selected>' + data.nom_servicio + '</option>').trigger("change"); $('#ser_txtIdServicioDep').prop("disabled", true);}, 1000);
	}
	$('#modalServicio').modal({
		show: true,
		backdrop: 'static',
		focus: true,
	});
}

function maxlength_doc_bus() {
    if ($("#txtIdTipDoc").val() == "1") {
      $("#txtNroDoc").attr('maxlength', '8');
    } else {
      $("#txtNroDoc").attr('maxlength', '12');
    }
    $("#txtNroDoc").val('');
    $("#txtNroDoc").focus();
    $('#txtNroDoc').trigger('focus');
    setTimeout(function(){$('#txtNroDoc').trigger('focus');}, 2);
  }

  function campoSiguiente(campo, evento) {
    if (evento.keyCode == 13 || evento.keyCode == 9) {
      if (campo == 'btn-pac-search') {
        validate_exis_profesional();
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    }
}

function validate_exis_profesional(){
    $('#txtIdPer').val('0');
    var msg = "";
    var sw = true;
    var txtIdTipDoc = $('#txtIdTipDoc').val();
    var txtNroDoc = $('#txtNroDoc').val();
    var txtNroDocLn = txtNroDoc.length;
    if (txtIdTipDoc == "1") {
      if (txtNroDocLn != 8) {
        msg += "Ingrese el Nro. de documento correctamente<br/>";
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
      return sw;
    }

    $('#btn-pac-search').prop("disabled", true);
    $.ajax({
      url: "../../controller/ctrlProfesional.php",
      type: "POST",
      dataType: 'json',
      data: {
        accion: 'GET_SHOW_EXISPROFESIONAL', txtIdTipDoc: txtIdTipDoc, txtNroDoc: txtNroDoc
      },
      success: function (reg) {
        if(reg == "0"){
          buscar_datos_personales();
        } else {
          $('#txtNomPac').prop("readonly", true);
          $('#txtPriApePac').prop("readonly", true);
          $('#txtSegApePac').prop("readonly", true);
          $('#txtIdSexoPac').prop("disabled", true);
          $('#txtFecNacPac').prop("disabled", true);

          bootbox.alert("El Nro. de Documento ingresado ya se encuenta registrado.");
          $('#btn-pac-search').prop("disabled", false);
        }
      }
    });
}

function buscar_datos_personales(){
    txtIdTipDoc = $('#txtIdTipDoc').val();
    txtNroDoc = $('#txtNroDoc').val();

    $("#txtNomPac").val('');
    $("#txtPriApePac").val('');
    $("#txtSegApePac").val('');
    $("#txtIdSexoPac").val('');
    $("#txtFecNacPac").val('');
    $("#txtNroTelfFijoPac").val('');
    $("#txtNroTelfMovilPac").val('');
    $("#txtEmailPac").val('');
	
	$("#txtIdPer").val('0');
	$("#txtValidReniec").val('0');

    $('#btn-pac-search').prop("disabled", true);
    $.ajax({
      url: "../../controller/ctrlPersona.php",
      type: "POST",
      dataType: 'json',
      data: {
        accion: 'GET_SHOW_PERSONULTIMAATENCIONPORIDDEP', txtIdTipDoc: txtIdTipDoc, txtNroDoc: txtNroDoc, interfaz: 'profesional'
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
		if (datos[0] == "C"){
			$("#txtIdPer").val('0');
			showMessage(datos[1], "error");	
		} else {
			$("#txtIdPer").val(datos[0]);  
		}
		if (datos[23] == ""){
			$("#txtValidReniec").val('0');
		} else {
			$("#txtValidReniec").val('1');  
		}
        if((datos[4] == null) || (datos[4] == "")){
          $('#txtIdSexoPac').prop("disabled", false);
          $('#txtNomPac').prop("readonly", false);
          $('#txtPriApePac').prop("readonly", false);
          $('#txtSegApePac').prop("readonly", false);
          $('#txtFecNacPac').prop("disabled", false);
          $("#txtIdSexoPac").trigger('focus');
        } else {
          $("#txtNomPac").val(datos[4]);
          $("#txtPriApePac").val(datos[5]);
          $("#txtSegApePac").val(datos[6]);
          $("#txtIdSexoPac").val(datos[7]);
          $("#txtFecNacPac").val(datos[9]);
          $("#txtNroTelFijoPac").val(datos[11]);
          $("#txtNroTelMovilPac").val(datos[12]);
          $("#txtEmailPac").val(datos[13]);
          $('#txtNomPac').prop("readonly", true);
          $('#txtPriApePac').prop("readonly", true);
          $('#txtSegApePac').prop("readonly", true);
          $('#txtIdSexoPac').prop("disabled", true);
          $('#txtFecNacPac').prop("disabled", true);
          if(datos[9] == ""){
            $('#txtFecNacPac').prop("disabled", false);
          }
          $("#txtNroTelFijoPac").trigger('focus');
        }
        $('#btn-pac-search').prop("disabled", false);
      }
    });
}

function validForm() {
    $('#btnValidForm').prop("disabled", true);
    var msg = "";
    var sw = true;

    var idDep = $('#txtIdDep').val();
    var idProfesion = $("#txtIdProfesion").val();
    var nroCole = $("#txtNroCole").val();
    var nroRne = $("#txtNroRne").val();
    var img = $("#imgFirma").val();

    var sexopac = $('#txtIdSexoPac').val();
    var fecnacpac = $('#txtFecNacPac').val();
    var nompac = $('#txtNomPac').val();
    var priapepac = $('#txtPriApePac').val();
    var seapepac = $('#txtSegApePac').val();
    var telfipac = $('#txtNroTelFijoPac').val();
    var telmopac = $('#txtNroTelMovilPac').val();
    var emailpac = $('#txtEmailPac').val();
	if(idProfesion == "0"){
		if(sexopac == ""){
		  msg+= "Seleccione el sexo del Paciente<br/>";
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

    if(idProfesion == ""){
      msg += "Seleccione la profesión<br/>";
      sw = false;
    }
    if(nroCole == ""){
      msg += "Ingrese Nro. de Colegiatura del profesional<br/>";
      sw = false;
    }

  if (sw == false) {
    bootbox.alert(msg);
    $('#btnValidForm').prop("disabled", false);
    return sw;
  } else {
    save_form();
  }
  return false;
}

function save_form() {
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
        var file_data = $('#imgFirma').prop('files')[0];
        var form_data = new FormData();
        form_data.append('accion', 'POST_ADD_REGPROFESIONAL');
        form_data.append('txtIdProfesional', document.frmUsuario.txtIdProfesional.value);
        form_data.append('txtIdPer', document.frmUsuario.txtIdPer.value);
	form_data.append('txtValidReniec', document.frmUsuario.txtValidReniec.value);
        form_data.append('txtIdTipDoc', document.frmUsuario.txtIdTipDoc.value);
        form_data.append('txtNroDoc', document.frmUsuario.txtNroDoc.value);
        form_data.append('txtIdSexoPac', document.frmUsuario.txtIdSexoPac.value);
        form_data.append('txtFecNacPac', document.frmUsuario.txtFecNacPac.value);
        form_data.append('txtNomPac', document.frmUsuario.txtNomPac.value);
        form_data.append('txtPriApePac', document.frmUsuario.txtPriApePac.value);
        form_data.append('txtSegApePac', document.frmUsuario.txtSegApePac.value);
        form_data.append('txtNroTelFijoPac', document.frmUsuario.txtNroTelFijoPac.value);
        form_data.append('txtNroTelMovilPac', document.frmUsuario.txtNroTelMovilPac.value);
        form_data.append('txtEmailPac', document.frmUsuario.txtEmailPac.value);

        form_data.append('txtIdProfesion', document.frmUsuario.txtIdProfesion.value);
        form_data.append('txtNroCole', document.frmUsuario.txtNroCole.value);
        form_data.append('txtNroRne', document.frmUsuario.txtNroRne.value);
		form_data.append('id_condicional_laboral', document.frmUsuario.txt_id_condicion_laboral.value);

        form_data.append('file', file_data);
        form_data.append('rand', myRand);
        $.ajax( {
          url: '../../controller/ctrlProfesional.php',
          dataType: 'text', // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'POST',
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $("#showUsuarioModal").modal('hide');
              $("#tblSolicitud").dataTable().fnDraw();
            } else {
              bootbox.alert(msg);
              return false;
            }
            $('#btnValidForm').prop("disabled", false);
          }
        });
      } else {
        $('#btnValidForm').prop("disabled", false);
      }
    }
  });
}

function save_formfirma() {
  bootbox.confirm({
    message: "Si ya existe una firma, este será reemplazada, ¿Está seguro de continuar?",
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
        var file_data = $('#imgFirma1').prop('files')[0];
        var form_data = new FormData();
        form_data.append('accion', 'POST_UPD_FIRMAPROFESIONAL');
        form_data.append('txtIdProfesional', document.frmUsuario.txtIdProfesional.value);
        form_data.append('file', file_data);
        form_data.append('rand', myRand);
        $.ajax( {
          url: '../../controller/ctrlProfesional.php',
          dataType: 'text', // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'POST',
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $("#showFirmaModal").modal('hide');
              $("#tblSolicitud").dataTable().fnDraw();
            } else {
				bootbox.alert(msg);
				setTimeout(function(){delet_padding();}, 1000);
			}
            $('#btnValidFormFirma').prop("disabled", false);
          }
        });
      } else {
        $('#btnValidFormFirma').prop("disabled", false);
      }
    }
  });
}

function saveServicio(action) {
  $('#btnSaveServicio').prop("disabled", true);
  var msg = "";
  var sw = true;

	var id_profesionalservicio = $('#txtIdProfesionalServicio').val();
    var ser_txtIdProfesional = $('#ser_txtIdProfesional').val();
    var ser_txtIdDep = $('#ser_txtIdDep').val();
    var ser_txtIdServicioDep = $('#ser_txtIdServicioDep').val();
    var ser_txtIdCargo = $('#ser_txtIdCargo').val();
    var ser_txtIdUsuario = $('#ser_txtIdUsuario').val();
    var txtIdRol = $('#txtIdRol').val();
	
    if(ser_txtIdProfesional == ""){
      msg+= "Ingrese Profesional<br/>";
      sw = false;
    }
    if(ser_txtIdDep == ""){
      msg+= "Seleccione la Dependencia<br/>";
      sw = false;
    }
    if(ser_txtIdServicioDep == ""){
      msg+= "Seleccione la Servicio<br/>";
      sw = false;
    }
    if(ser_txtIdCargo == ""){
      msg+= "Seleccione la Cargo<br/>";
      sw = false;
    }
	
    /*if(ser_txtIdUsuario == ""){
      msg+= "ID usuario requerido<br/>";
      sw = false;
    }*/
	if(ser_txtIdUsuario != ""){
		if(txtIdRol == ""){
		  msg+= "Seleccione el ROL<br/>";
		  sw = false;
		}
	}
	
    if(sw == false){
		$('#btnSaveServicio').prop("disabled", false);
		showMessage(msg, "error");
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
        $.ajax({
          url: "../../controller/ctrlProfesional.php",
          ///dataType: "json",
          type: "post",
          data: {
            accion: 'POST_ADD_REGSERVICIOPROFESIONAL',
			id_profesionalservicio: id_profesionalservicio,
            txtIdProfesional: ser_txtIdProfesional,
            txtIdDep: ser_txtIdDep,
            txtIdServicioDep: ser_txtIdServicioDep,
            txtIdCargo : ser_txtIdCargo,
            txtIdUsuario : ser_txtIdUsuario || '',
            txtIdRol : txtIdRol || ''
          },
          processData: true,
          success: function (data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            if(tmsg == "OK"){
				formatChild1_actu(ser_txtIdProfesional);
				$("#modalServicio").modal("hide");
            } else {
				bootbox.alert(msg);	
			}
            $('#btnSaveServicio').prop("disabled", false);
          },
          timeout: 12000, // sets timeout to 12 seconds
          error: function (request, status, err) {
            if (status == "timeout") {
              bootbox.alert("Su petición demoro mas de lo permitido", "error");
            } else {
              bootbox.alert("ocurrio un error en su petición.", "error");
            }
            $('#btnSaveServicio').prop("disabled", false);
          }
        });

      } else {
        $('#btnSaveServicio').prop("disabled", false);
      }
    }
  });
}

function cambiarEstadoServicio(id,idprof) {
  bootbox.confirm({
    message: "Se cambiará el estado, ¿Está seguro de continuar?",
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
        $.ajax({
          url: "../../controller/ctrlProfesional.php",
          //dataType: "json",
          type: "post",
          data: {
            accion: 'POST_DEL_REGSERVICIOPROFESIONAL',
            txtId: id,
            txtIdProfesional: idprof
          },
          processData: true,
          success: function (data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            if(tmsg == "OK"){
              formatChild1_actu(idprof);
              $("#modalServicio").modal("hide");
            }
            bootbox.alert(msg);
            $('#btnSaveServicio').prop("disabled", false);
          },
          timeout: 12000, // sets timeout to 12 seconds
          error: function (request, status, err) {
            if (status == "timeout") {
              bootbox.alert("Su petición demoro mas de lo permitido", "error");
            } else {
              bootbox.alert("ocurrio un error en su petición.", "error");
            }
            $('#btnSaveServicio').prop("disabled", false);
          }
        });

      } else {
        $('#btnSaveServicio').prop("disabled", false);
      }
    }
  });
}

function expor_usuarios() {
	var combo = document.getElementById("txtBusIdDep");
	var nom_establecimiento = combo.options[combo.selectedIndex].text;
	window.location = './xls_repprofesionalservicio.php?id_establecimiento=' + $("#txtBusIdDep").val() + '&nom_establecimiento=' + nom_establecimiento;
}

$(function() {

  jQuery('#txtNroDoc').keypress(function (tecla) {
    var idTipDocPer = $("#txtIdTipDoc").val();
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

  jQuery('#txtNroTelFijoPac').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
    return false;
  });

  jQuery('#txtNroTelMovilPac').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
    return false;
  });

  $('[name="chk_usuario"]').change(function(){
      if ($('#chk_usuario').is(':checked')) {
        $("#txtIdRol").prop("disabled",false).val("");
      } else {
        $("#txtIdRol").prop("disabled",true).val("");
      }
    });

});

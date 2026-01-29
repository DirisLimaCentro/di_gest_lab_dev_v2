
  function open_pdfsinvalor(idSoli) {
    var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function buscar_datos() {
	var idEstadoEnv = $("#txt_id_estadoenvminsa").val();
    var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();

    $('#titleModalAlert').text('Mensaje de Alerta ...');
	if (fecFin == "") {
		$('#infoModalAlert').text('Ingrese almenos un parametro de ingreso: Nombre o Raz\xf3n Social o Rango de Fechas.');
		$('#alertModal').modal("show");
		return false;
	}

    if (fecIni != "") {
      if (fecFin == "") {
        $('#infoModalAlert').text('Ingrese Fecha Final.');
        $('#alertModal').modal("show");
        return false;
      }
    }

    if (fecIni != "") {
      if (validarFormatoFecha(fecIni) == false) {
        $('#infoModalAlert').text('Ingrese Fecha de Inicio Correctamente.');
        $('#alertModal').modal("show");
        return false;
      }
    }

    if (fecFin != "") {
      if (validarFormatoFecha(fecFin) == false) {
        $('#infoModalAlert').text('Ingrese Fecha Final Correctamente.');
        $('#alertModal').modal("show");
        return false;
      }
    }

    f1 = fecIni.split("/");
    f2 = fecFin.split("/");

    var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
    var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

    if (f1 > f2) {
      $('#infoModalAlert').text('La Fecha de Incio debe ser menor o igual a la fecha Final.');
      $('#alertModal').modal("show");
      return false;
    }

    $("#tblSolicitud").dataTable().fnDraw()
  }

  function exporbuscar_datos() {
	var idEstadoEnv = $("#txt_id_estadoenvminsa").val();
    var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();

    $('#titleModalAlert').text('Mensaje de Alerta ...');
	if (fecFin == "") {
		$('#infoModalAlert').text('Ingrese almenos un parametro de ingreso: Nombre o Raz\xf3n Social o Rango de Fechas.');
		$('#alertModal').modal("show");
		return false;
	}

    if (fecIni != "") {
      if (fecFin == "") {
        $('#infoModalAlert').text('Ingrese Fecha Final.');
        $('#alertModal').modal("show");
        return false;
      }
    }

    if (fecIni != "") {
      if (validarFormatoFecha(fecIni) == false) {
        $('#infoModalAlert').text('Ingrese Fecha de Inicio Correctamente.');
        $('#alertModal').modal("show");
        return false;
      }
    }
    if (fecFin != "") {
      if (validarFormatoFecha(fecFin) == false) {
        $('#infoModalAlert').text('Ingrese Fecha Final Correctamente.');
        $('#alertModal').modal("show");
        return false;
      }
    }

    f1 = fecIni.split("/");
    f2 = fecFin.split("/");

    var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
    var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

    if (f1 > f2) {
      $('#infoModalAlert').text('La Fecha de Incio debe ser menor o igual a la fecha Final.');
      $('#alertModal').modal("show");
      return false;
    }

    var urlwindow = "pdf_principalsoli.php?idTipDoc=" + idTipDoc + "&nroDoc=" + nroDoc + "&nomRS="+ nomRS + "&fecIni="+ fecIni + "&fecFin=" + fecFin;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function campoSiguiente(campo, evento) {
    if (evento.keyCode == 13 || evento.keyCode == 9) {
      if (campo == 'btnBus') {
        buscar_datos();
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    }
  }
  
  
  /*********************************************************************************************************************/
  ////////////////////////////////////////////////// HIS - MINSA ////////////////////////////////////////////////////////
  /*********************************************************************************************************************/
  
    function procesar_atenciones() {
    bootbox.confirm({
      message: "Los registros serán enviados al HIS-MINSA, ¿Está seguro de continuar?",
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
          var form_data = new FormData();
          form_data.append('accion', 'POST_ADD_REGHISMINSA');
          //form_data.append('txtIdPer', document.frmUsuario.txtIdPer.value);
          form_data.append('rand', myRand);
          $.ajax( {
            url: '../../controller/ctrlPAP.php',
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
                $("#tblAtencion").dataTable().fnDraw();
                /*if($("#").val() == "0"){
                  bootbox.alert("Registro ingresado correctamente.");
                } else {
                  bootbox.alert("Registro actualizado correctamente.");
                }*/
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
<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
?>
<style>

div.dt-buttons {
  float: left;
}
div.dataTables_length {
  float: right;
  text-align: right;
}
div.dataTables_info {
  float: left;
}
div.dataTables_paginate paging_simple_numbers {
  float: right;
  text-align: right;
}

@media screen and (max-width: 450px) {
  div.dt-buttons {
    float: none;
    text-align: center;
  }
  div.dataTables_length {
    float: none;
  }
  div.dataTables_info {
    float: none;
  }
  div.dataTables_paginate paging_simple_numbers {
    float: none;
  }
}

</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>BÚSQUEDA Y REGISTRO DE ATENCIÓN DE TOMA DE PAP</strong></h3>
    </div>
    <div class="panel-body">
      <fieldset class="scheduler-border">
	  <legend class="scheduler-border" style="margin-bottom: 5px;">BUSCAR ATENCIÓN:
		  <div class="btn-group">
			<button type="button" class="btn btn-primary" id="tipo_repor1" onclick="selec_tip_repor('1')">Todas</button>
			<button type="button" class="btn btn-default" id="tipo_repor2" onclick="selec_tip_repor('2')">Con resultado sin entregar a paciente</button>
	  </div>
		</legend>
      <form class="form-horizontal" name="frmRepPrin" id="frmRepPrin" onsubmit="return false;">
        <input type="hidden" name="txtIdPap" id="txtIdPap" value=""/>
        <input type="hidden" name="txtTipAcc" id="txtTipAcc" value=""/>

        <div class="form-group">
          <div class="col-sm-4 col-md-3">
            <div class="row">
              <div class="col-sm-12">
                <label for="txtIdTipDoc"><small>Documento de identidad</small></label>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="input-group input-group-sm">
                  <div class="input-group-addon" style="padding: 0!important;">
                    <?php $rsT = $t->get_ListaTipoDocPerNatu(); ?>
                    <select name="txtvIdTipDoc" style="width:100%;" id="txtBusIdTipDoc" onchange="maxlength_doc_bus()">
                      <?php
                      foreach ($rsT as $row) {
                        echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <input type="text" name="txtBusNroDoc" placeholder="Número de documento" required="" id="txtBusNroDoc" class="form-control input-sm" maxlength="8" onkeydown="campoSiguiente('btnBus', event);"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4 col-md-3">
            <label for="txtBusNomRS"><small>Nombres o Apellidos del paciente:</small></label>
            <input class="form-control input-sm text-uppercase" type="text" name="txtBusNomRS" id="txtBusNomRS" autocomplete="OFF" maxlength="50" required="" tabindex="0" onkeydown="campoSiguiente('btnBus', event);"/>
          </div>
          <div class="col-sm-3 col-md-2">
            <label for="txtBusAnioAsis"><small>Fecha Inicio:</small></label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="glyphicon glyphicon-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right input-sm" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y"); ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtBusFecFin', event);"/>
            </div>
          </div>
          <div class="col-sm-3 col-md-2">
            <label for="txtBusAnioAsis"><small>Fecha Final:</small></label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="glyphicon glyphicon-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right input-sm" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('btnBus', event);"/>
            </div>
          </div>
          <div class="col-sm-2 col-md-1">
            <label for="txtBusAnioAsis"><small>Positivo:</small></label>
			  <div class="checkbox">
				<label>
				  <input type="checkbox" id="checkbox1"/>
				</label>
			  </div>
          </div>
          <div class="col-sm-2 col-md-1">
            <br/>
            <button class="btn btn-success btn-sm" type="button" id="btnBus" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
          </div>
		  <div class="col-sm-4">
				<label for="txtBusIdDep">Dependencia:</label>
				<?php $rsD = $d->get_listaDepenInstitucion(); ?>
				<select name="txtBusIdDep" id="txtBusIdDep" style="width:100%;" <?php if(($_SESSION['labIdRolUser'] == "1") Or ($_SESSION['labIdRolUser'] == "6")){ echo "";} else { echo " disabled";}?>>
				  <option value="" selected="">-- Todos --</option>
				  <?php
				  foreach ($rsD as $row) {
					echo "<option value='" . $row['id_dependencia'] . "'";
					if(($_SESSION['labIdRolUser'] == "1") Or ($_SESSION['labIdRolUser'] == "6")){ echo "";} else { if($_SESSION['labIdDepUser'] == $row['id_dependencia']){ echo " selected";}}
					echo ">" . $row['codref_depen'] . ": " . $row['nom_depen'] . "</option>";
				  }
				  ?>
				</select>
		  </div>
        </div>
      </form>
    </fieldset>
      <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <a style="color: #449d44;"><i class="glyphicon glyphicon-pencil"></i></a>=Editar Atención | <a style="color: #F44336;"><i class="glyphicon glyphicon-trash"></i></a>=Anular Atención |  <a style="color: #449d44;"><i class="glyphicon glyphicon-th-list"></i></a>=Ver datos de Lámina EESS | <a style="color: #00c0ef;"><i class="glyphicon glyphicon-eye-open"></i></a>=Ver ficha de atención o resultado | <a style="color: #449d44;"><i class="glyphicon glyphicon-user"></i></a>=Entregar resultado a Paciente</p>
      <!--<p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <a style="color: #00c0ef;"><i class="glyphicon glyphicon-eye-open"></i></a>=Ver ficha de atención o resultado | <a style="color: #449d44;"><i class="glyphicon glyphicon-th-list"></i></a>=Ver datos de Lámina EESS</p>-->
      <br/>
      <table id="tblSolicitud" class="display" cellspacing="0" width="100%">
        <thead class="bg-aqua">
          <tr>
            <th>N° Lámina<br/> EESS</th>
            <th style="width: 30px;">Abrev. Paciente</th>
            <th>Nombre del Paciente</th>
            <th style="width: 80px;">Documento<br/>de Identidad</th>
            <th>HC</th>
            <th>Profesional de Salud</th>
            <th style="width: 60px;">Fecha<br/>Registro</th>
            <th>Estado</th>
            <th>Estado<br/>Resultado</th>
            <th style="width: 60px;">Fecha<br/>Resultado</th>
            <th>N° Lamina<br/>Laboratorio</th>
            <th style="width: 55px;"><i class="fa fa-cogs"></i></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <button class="btn btn-default btn-sm" id="btnBack" type="button" onclick="back();" tabindex="1"><i class="glyphicon glyphicon-log-out"></i> Ir al Men&uacute;</button>
    </div>
  </div>
  <div class="modal fade" id="showComenModal" role="dialog" aria-labelledby="showComenModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showComenModalLabel"></h4>
        </div>
        <div class="modal-body">
          <form name="frmComentario" id="frmComentario">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  <label for="txtDetObsLabEnv">Motivo:</label>
                  <textarea class="form-control" name="txtDetComen" id="txtDetComen" rows="3"></textarea>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-primary btn-continuar" id="btnFrmSaveComen" onclick="save_formaccion()"><i class="fa fa-save"></i> Continuar </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="showTipNotifModal" role="dialog" aria-labelledby="showTipNotifModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showTipNotifModalLabel"></h4>
        </div>
        <div class="modal-body">
          <form name="frmNotificacion" id="frmNotificacion">
            <div class="form-group">
              <?php $rsT = $t->get_listaTipoNotificacion(); ?>
              <label for="txtIdTipNotif">Tipo entrega a Paciente:</label>
              <select name="txtIdTipNotif" id="txtIdTipNotif" class="form-control">
                <option value="">-- Seleccione --</option>
                <?php
                foreach ($rsT as $row) {
                  echo "<option value='" . $row['id_tiponotif'] . "'>" . $row['nom_tiponotif'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  <label for="txtDetNotif">Comentario:</label>
                  <textarea class="form-control" name="txtDetNotif" id="txtDetNotif" rows="3"></textarea>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-primary btn-continuar" id="btnFrmSaveNotif" onclick="save_formaccion()"><i class="fa fa-save"></i> Continuar </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="mostrar_datospac" class="modal fade" role="dialog" data-backdrop="static"></div>
  <div id="mostrar_opcprintresul" class="modal fade" role="dialog" data-backdrop="static"></div>
  <?php require_once '../include/footer.php'; ?>
  <script Language="JavaScript">
	var tipo_repor = '1';
	var tipo_resul = '';

	function selec_tip_repor(opt) {
		tipo_repor = opt;
		if(opt == "1"){ $("#tipo_repor1").removeClass("btn-default").addClass("btn-primary"); $("#tipo_repor2").removeClass("btn-primary").addClass("btn-default")};
		if(opt == "2"){ $("#tipo_repor2").removeClass("btn-default").addClass("btn-primary"); $("#tipo_repor1").removeClass("btn-primary").addClass("btn-default")};
		buscar_datos();
	}
	
	function maxlength_doc_bus() {
		if ($("#txtBusIdTipDoc").val() == "1"){
			$("#txtBusNroDoc").attr('maxlength', '8');
		} else {
			$("#txtBusNroDoc").attr('maxlength', '15');
		}
		$('#txtBusNroDoc').val('');
		setTimeout(function(){$('#txtBusNroDoc').trigger('focus');}, 2);
	}
	
	function open_datoslamina(id){
	  $('#mostrar_datospac').modal('show');
	  $.ajax({
		url: '../../controller/ctrlPAP.php',
		type: 'POST',
		data: 'accion=GET_SHOW_DATOSATENCION&idSoli=' + id,
		success: function(data){
		  $('#mostrar_datospac').html(data);
		}
	  });
	}

  function open_opcionimpresionresul(id){
	  $('#mostrar_opcprintresul').modal('show');
	  $.ajax({
		url: '../../controller/ctrlPAP.php',
		type: 'POST',
		data: 'accion=GET_SHOW_OPTIMPRESIONRESUL&idSoli=' + id,
		success: function(data){
		  $('#mostrar_opcprintresul').html(data);
		}
	  });
	}

  function open_pdfsinvalor(idSoli) {

    var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function open_pdfresultot(idSoli, tipo) {
    if(tipo=="E"){
      var urlwindow = "pdf_resulttot.php?id_envio=" + idSoli;
    } else {
      var urlwindow = "pdf_resulttot.php?id_solicitud=" + idSoli;
    }
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function buscar_datos() {
    var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();
    var nomRS = $("#txtBusNomRS").val();
    nomRS = nomRS.replace("%", "");

    $('#titleModalAlert').text('Mensaje de Alerta ...');
    if (nomRS == "") {
      if (fecFin == "") {
        $('#infoModalAlert').text('Ingrese almenos un parametro de ingreso: Nombre o Raz\xf3n Social o Rango de Fechas.');
        $('#alertModal').modal("show");
        return false;
      }
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
    var idTipDoc = $("#txtBusIdTipDoc").val();
    var nroDoc = $("#txtBusNroDoc").val();
    var nomRS = $("#txtBusNomRS").val();
    var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();
    var nomRS = $("#txtBusNomRS").val();
    nomRS = nomRS.replace("%", "");

    $('#titleModalAlert').text('Mensaje de Alerta ...');
    if (nomRS == "") {
      if (fecFin == "") {
        $('#infoModalAlert').text('Ingrese almenos un parametro de ingreso: Nombre o Raz\xf3n Social o Rango de Fechas.');
        $('#alertModal').modal("show");
        return false;
      }
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
	
	var chk_positivo = 0;
	if($('#checkbox1').prop('checked')) {
		chk_positivo = 1;
	}
	
	<?php if(($_SESSION['labIdRolUser'] == "1") Or ($_SESSION['labIdRolUser'] == "6")){?> 
		var urlwindow = "pdf_principalsoli_sede.php?idTipDoc=" + idTipDoc + "&nroDoc=" + nroDoc + "&nomRS="+ nomRS + "&fecIni="+ fecIni + "&fecFin=" + fecFin + "&chk_positivo=" + chk_positivo + "&id_dependencia=" + $("#txtBusIdDep").val() + "&tipo_repor="+ tipo_repor;
	<?php } else {?> 
		var urlwindow = "pdf_principalsoli.php?idTipDoc=" + idTipDoc + "&nroDoc=" + nroDoc + "&nomRS="+ nomRS + "&fecIni="+ fecIni + "&fecFin=" + fecFin + "&chk_positivo=" + chk_positivo + "&tipo_repor="+ tipo_repor;
	<?php }?>
    
	
	
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

  function acc_registro(idpap, nroreg, opt){
    document.frmRepPrin.txtIdPap.value = idpap;
    document.frmRepPrin.txtTipAcc.value = opt; //A anular; E Entregado a paciente

    if(opt == 'A'){
      $("#showComenModalLabel").text("Anular toma PAP Nro: " + nroreg);
      $("#showComenModal").modal({
        show: true,
        backdrop: 'static',
        focus: true,
      });
      $('#showComenModal').on('shown.bs.modal', function (e) {
        document.frmComentario.txtDetComen.value = '';
        $('#txtDetComen').trigger('focus');
      })
    } else {

      $("#showTipNotifModalLabel").text("Entregar resultado Nro: " + nroreg + " a paciente");
      $("#showTipNotifModal").modal({
        show: true,
        backdrop: 'static',
        focus: true,
      });
      $('#showTipNotifModal').on('shown.bs.modal', function (e) {
        document.frmNotificacion.txtIdTipNotif.value = '';
        document.frmNotificacion.txtDetNotif.value = '';
        $('#txtIdTipNotif').trigger('focus');
      })
    }
  }

  function save_formaccion(){
    $('#btnFrmSave').prop("disabled", true);
    var isValid = true;
    var msgobs = '';
    var txtIdPap = document.frmRepPrin.txtIdPap.value;
    var txtTipAcc = document.frmRepPrin.txtTipAcc.value;

    if(txtTipAcc == "A"){
      var txtIdTipNotif = '';
      var txtDetComen = document.frmComentario.txtDetComen.value;

      if(txtDetComen.length <= 2){
        msgobs+='Ingrese Motivo...';
        isValid = false;
      }
      msgconfir = 'Se anulará la muestra. ¿Está seguro de continuar?';
    } else {
      var txtIdTipNotif = document.frmNotificacion.txtIdTipNotif.value;
      var txtDetComen = document.frmNotificacion.txtDetNotif.value;

      if(txtIdTipNotif == ""){
        msgobs+='Seleccione Tipo de entrega a Paciente<br/>';
        isValid = false;
      }
      if(txtDetComen.length <= 2){
        msgobs+='Ingrese Comentario';
        isValid = false;
      }
      msgconfir = 'Se cambiará el estado a <b>ENTREGADO A PACIENTE</b>. ¿Está seguro de continuar?';
    }

    if (isValid == false){
      bootbox.alert(msgobs);
      return false;
    }

    if(txtTipAcc == "A"){
      $('#btnFrmSaveComen').prop("disabled", false);
    } else {
      $('#btnFrmSaveNotif').prop("disabled", false);
    }

    bootbox.confirm({
      message: msgconfir,
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
            url: "../../controller/ctrlPAP.php",
            type: "POST",
            data: {
              accion: 'POST_ADD_REGANULAENTREGAPAP', txtIdPap: document.frmRepPrin.txtIdPap.value, txtTipAcc: document.frmRepPrin.txtTipAcc.value, txtIdTipNotif: txtIdTipNotif, txtDetComen: txtDetComen,
            },
            success: function (data) {
              var tmsg = data.substring(0, 2);
              var lmsg = data.length;
              var msg = data.substring(3, lmsg);
              //console.log(tmsg);
              if(tmsg == "OK"){
                $("#tblSolicitud").dataTable().fnDraw();

                if(txtTipAcc == "A"){
                  $('#showComenModal').modal("hide");
                  $('#btnFrmSaveComen').prop("disabled", false);
                } else {
                  $('#showTipNotifModal').modal("hide");
                  $('#btnFrmSaveNotif').prop("disabled", false);
                }

              } else {
                bootbox.alert(msg);
                return false;
              }
            }
          });
        } else {
          $('#btnFrmSave').prop("disabled", false);
        }
      }
    });
  }

  function back() {
    window.location = '../pages/';
  }
  function reg_solicitud() {
    window.location = './main_regsolicitud.php';
  }
  function edit_solicitud(id) {
    window.location = './main_editsolicitud.php?nroSoli='+id;
  }

    function save_form() {
    bootbox.confirm({
      message: "El registro sera anulado, ¿Está seguro de continuar?",
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
          form_data.append('accion', 'POST_ADD_REGUSUARIO');
          form_data.append('txtIdPer', document.frmUsuario.txtIdPer.value);
          form_data.append('rand', myRand);
          $.ajax( {
            url: '../../controller/ctrlUsuario.php',
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
                $("#tblAtencion").dataTable().fnDraw();
                if($("#").val() == "0"){
                  bootbox.alert("Registro ingresado correctamente.");
                } else {
                  bootbox.alert("Registro actualizado correctamente.");
                }
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

  $(function() {
    jQuery('#txtBusNroDoc').keypress(function (tecla) {
      var idTipDocPer = $("#txtBusIdTipDoc").val();
      if (idTipDocPer == "1") {
        if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
        return false;
      } else {
        if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode != 0))//(Numeros y letras)(0=borrar)
        return false;
      }
    });
  });

  $(document).ready(function () {
    $("#txtBusIdTipDoc").select2();
	$("#txtBusIdDep").select2();

    $('#txtBusFecIni').datetimepicker({
      locale: 'es',
      format: 'L'
    });

    $('#txtBusFecFin').datetimepicker({
      locale: 'es',
      format: 'L'
    });

    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
	
	$('#checkbox1').click(function() {
		if (!$(this).is(':checked')) {
			tipo_resul = '';
		} else {
			tipo_resul = '1';
		}
		buscar_datos();
	});

    var dTable = $('#tblSolicitud').DataTable({
      /* Results in:
      <div class="wrapper">
      {Button} B tmb cambiar estilo
      {processing} r
      {length} l tmb cambiar estilo
      {table} t
      {information} i
      {pagination} p
      </div>
      */
      dom: 'Bltip',
      "buttons": [
	  <?php 
	  if($labIdRolUser <> "6"){
	  ?>
        {
          text: '<i class="glyphicon glyphicon-plus"></i> Registrar Atención',
          className: "btn btn-success btn-lg",
          action: function ( e, dt, node, config ) {
            reg_solicitud();
          }
        },
	  <?php 
	  }
	  ?>
        {
          text: '<i class="glyphicon glyphicon-open"></i> Exportar resultado de busqueda',
          className: "btn btn-warning btn-lg",
          action: function ( e, dt, node, config ) {
            exporbuscar_datos();
          }
        }
      ],
	  "lengthMenu": [[50, 100 ,250], [50, 100 ,250, "All"]],
      "bLengthChange": true, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
      "sAjaxSource": "tbl_principalsoli.php", // Load Data
      "language": {
        "url": "../../assets/plugins/datatables/Spanish.json",
        "lengthMenu": '_MENU_ entries per page',
        "search": '<i class="fa fa-search"></i>',
        "paginate": {
          "previous": '<i class="fa fa-angle-left"></i>',
          "next": '<i class="fa fa-angle-right"></i>'
        }
      },
      "sServerMethod": "POST",
      "fnServerParams": function (aoData)
      {
		aoData.push({"name": "tipo_repor", "value": tipo_repor});
		aoData.push({"name": "tipo_resul", "value": tipo_resul});
        aoData.push({"name": "idTipDoc", "value": $("#txtBusIdTipDoc").val()});
        aoData.push({"name": "nroDoc", "value": $("#txtBusNroDoc").val()});
        aoData.push({"name": "nomRS", "value": $("#txtBusNomRS").val()});
        aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
        aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
		aoData.push({"name": "id_dependencia", "value": $("#txtBusIdDep").val()});
      },
      "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
        if ( aData[8] == "POR SUBSANAR" ){
          $('td', nRow).addClass('warning');
        } else if ( aData[8] != "PENDIENTE" ){
          $('td', nRow).addClass('success');
        }
		if ( aData[7] == "ANULADO" ){
          $('td', nRow).addClass('active');
        }
        if (aData[8] == "POSITIVO" ){
          $('td', nRow).addClass('text-danger');
        }
      },
      "columnDefs": [
        {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center font-weit"},
        {"orderable": false, "targets": 1, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 2, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 5, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center font-weit"},
        {"orderable": false, "targets": 8, "searchable": false, "class": "small text-center font-weit"},
        {"orderable": false, "targets": 9, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 10, "searchable": false, "class": "small text-center font-weit"},
        {"orderable": false, "targets": 11, "searchable": false, "class": "text-center"}
      ],
      "order": [[ 0, "desc" ]]
    });

    $('#tblSolicitud').removeClass('display').addClass('table table-hover table-bordered');
  });

</script>
<?php require_once '../include/masterfooter.php'; ?>

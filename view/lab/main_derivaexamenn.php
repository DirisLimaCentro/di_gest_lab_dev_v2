<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Producto.php';
$pr = new Producto();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
?>
<style>
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

.label-primary {
    background-color: #1D71B8 !important;
}
.label-info {
    background-color: #00c0ef !important;
}
.label-success {
    background-color: #5cb85c !important;
}
.label-warning {
    background-color: #f0ad4e !important;
}
.label-danger {
    background-color: #d9534f !important;
}

/* Ajuste Select2 para que el texto quede centrado verticalmente */
.select2-container .select2-selection--single {
    height: 30px !important;
    border: 1px solid #ccc !important;
    border-radius: 0 !important;
}

.select2-selection__rendered {
    line-height: 25px !important;  /* <-- esto centra verticalmente */
    font-size: 12px;
    padding-left: 5px !important;
    padding-right: 20px !important;
}

/* Ajuste de la flecha */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 30px !important;
    top: 0 !important;
}

</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>BANDEJA DE SOLICITUDES DE EXAMENES PARA SER PROCESADOS</strong></h3>
    </div>
    <div class="panel-body">
		<div class="nav-tabs-custom">
		  <ul class="nav nav-tabs">
			<li class="active"><a href="#tab-pendientes" data-toggle="tab"><i class="fa fa-list text-info"></i> Registradas</a></li>
			<li><a href="#tab-enviadas" data-toggle="tab"><i class="fa fa-envelope text-primary"></i> Enviadas <!--<span class="badge label-info" id="count-enviadas">12</span>--></a></li>
			<li><a href="#tab-atendidas" data-toggle="tab"><i class="fa fa-check text-success"></i> Atendidas <!--<span class="badge label-success" id="count-atendidas">5</span>--></a></li>
			<li><a href="#tab-observadas" data-toggle="tab"><i class="fa fa-ban text-danger"></i> Observadas <!--<span class="badge label-danger" id="count-observadas">1</span>--></a></li>
		  </ul>
		  <div class="tab-content">
			<div class="tab-pane active" id="tab-pendientes">
        <form name="frmBus" id="frmBus" class="form-horizontal">
          <input type="hidden" name="txtIdSolicitud" id="txtIdSolicitud" value=""/>
          <input type="hidden" name="txt_accion" id="txt_accion" value=""/>
          <div class="form-group">
            <div class="col-sm-3">
              <label for="txt_bus_id_dependencia_pen">Laboratorio destino:</label>
              <?php $rsD = $d->get_listaDepenInstitucion(); ?>
              <select name="txt_bus_id_dependencia_pen" id="txt_bus_id_dependencia_pen" class="form-control" style="width: 100%" disabled="">
                <option value="0" selected>-- SELECCIONE --</option>
                <?php
                foreach ($rsD as $row) {
                  echo "<option value='" . $row['id_dependencia'] . "'";
                  if($row['id_dependencia'] == "67"){ echo " selected";}
                  echo ">" . $row['nom_depen'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-sm-3">
              <label for="txt_bus_id_producto_pen"><small>Examen:</small></label>
              <?php $rsP = $pr->get_listaProductoLaboratorio(); ?>
              <select name="txt_bus_id_producto_pen" id="txt_bus_id_producto_pen" class="form-control" style="width: 100%" disabled="">
                <option value="0" selected>-- SELECCIONE --</option>
                <?php
                foreach ($rsP as $row) {
                  echo "<option value='" . $row['id_producto'] . "'"; 
                  if($row['id_producto'] == "60"){ echo " selected";}
                  echo">" . $row['nom_producto'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-sm-2">
              <label for="txtBusFecIni_pen">Fecha toma muestra ini:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </div>
                <?php
                  $fecha = date('Y-m-d');
                  $nuevaFecha = date("Y-m-d",strtotime ( '-4 day' , strtotime ( $fecha ) ) );
                  $fechaIni = date("d/m/Y", strtotime($nuevaFecha));
                ?>
                <input type="text" class="form-control pull-right input-sm" name="txtBusFecIni_pen" id="txtBusFecIni_pen" autocomplete="OFF" maxlength="10" value="<?php echo $fechaIni; ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtBusFecFin', event);"/>
              </div>
            </div>
            <div class="col-sm-2">
              <label for="txtBusFecFin_pen">Fecha toma muestra fin:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right input-sm" name="txtBusFecFin_pen" id="txtBusFecFin_pen" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask data-mask onkeydown="campoSiguiente('btnBus', event);"/>
              </div>
            </div>
            <div class="col-sm-2">
              <label>&nbsp;</label>
              <button type="button" class="btn btn-info btn-sm btn-block" id="btn_bus_pendiente" onclick="nueva_busqueda();">Buscar</button>
            </div>
          </div>
        </form>
        <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <input type="checkbox" checked>=Incluir en el envío | <input type="checkbox">=No incluir en el envío</p>
        <form class="" id="frm-example" method="POST">
            <table id="example" class="table table-hover table-bordered" cellspacing="0" width="100%">
              <thead class="bg-aqua">
                <tr>
                  <th></th>
                  <th>N°</br>ATENCION</th>
                  <th>NOMBRE DEL PACIENTE</th>
                  <th>N° DOC.</th>
                  <th>HC</th>
                  <th>FECHA</br>TOMA MUESTRA</th>
                  <th>DIAS</th>
                  <th>NOMBRE DEL EXAMEN</th>
                  <!--<th><i class="fa fa-cogs"></i></th>-->
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <th></th>
                  <th>N°</br>ATENCION</th>
                  <th>NOMBRE DEL PACIENTE</th>
                  <th>N° DOC.</th>
                  <th>HC</th>
                  <th>FECHA</br>TOMA MUESTRA</th>
                  <th>DIAS</th>
                  <th>NOMBRE DEL EXAMEN</th>
                  <!--<th><i class="fa fa-cogs"></i></th>-->
                </tr>
              </tfoot>
            </table>
            <pre id="example-console-rows" style="display: none;"></pre>
        </form>
			</div>

			<div class="tab-pane" id="tab-enviadas">
        <form name="frmBusEnviadas" id="frmBusEnviadas" class="form-horizontal" autocomplete="off">
          <div class="form-group">
            <div class="col-sm-3">
              <label for="txt_bus_id_producto_env"><small>Examen:</small></label>
              <?php $rsP = $pr->get_listaProductoLaboratorio(); ?>
              <select name="txt_bus_id_producto_env" id="txt_bus_id_producto_env" class="form-control" style="width: 100%" disabled="">
                <option value="0" selected>-- SELECCIONE --</option>
                <?php
                foreach ($rsP as $row) {
                  echo "<option value='" . $row['id_producto'] . "'"; 
                  if($row['id_producto'] == "60"){ echo " selected";}
                  echo">" . $row['nom_producto'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-sm-3">
              <label for="txt_bus_id_dependencia_env"><small>Dependencia origen:</small></label>
              <?php $rsD = $d->get_listaDepenInstitucion(); ?>
              <select name="txt_bus_id_dependencia_env" id="txt_bus_id_dependencia_env" class="form-control" style="width: 100%">
                <option value="0" selected>-- TODOS --</option>
                <?php
                foreach ($rsD as $row) {
                  echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-sm-3">
              <label for="txt_bus_datos_pac_env"><small>Por Nro. Atención/Nombres/Nro. de Documento:</small></label>
              <input type="text" name="txt_bus_datos_pac_env" id="txt_bus_datos_pac_env" class="form-control form-control-sm" value="" />
              <p class="help-block">Digite mínimo dos caracteres.</p>
            </div>
            <div class="col-sm-2">
              <label>&nbsp;</label>
              <button type="button" class="btn btn-primary btn-sm btn-block" id="btn_bus_enviadas_reset">Restablecer filtros</button>
            </div>
          </div>
        </form>
        <p></p>
        <table id="tbl_enviadas" class="table table-hover table-bordered" cellspacing="0" width="100%">
          <thead class="bg-primary">
            <tr>
              <th><i class="fa fa-cogs"></i></th>
              <th>FECHA<br/>ENVÍO</th>
              <th>NOMBRE DEL PACIENTE</th>
              <th>EXAMEN SOLICITADO</th>
              <th>ESTABLECIMIENTO DESTINO</th>
              <th>ESTADO RESULTADO</th>
              <th>CNT.<br/>DÍAS</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
			</div>

			<div class="tab-pane" id="tab-atendidas">
        <form name="frmBusAtendidas" id="frmBusAtendidas" class="form-horizontal" autocomplete="off">
          <div class="form-group">
            <div class="col-sm-3">
              <label for="txt_bus_id_producto_ate"><small>Examen:</small></label>
              <?php $rsP = $pr->get_listaProductoLaboratorio(); ?>
              <select name="txt_bus_id_producto_ate" id="txt_bus_id_producto_ate" class="form-control" style="width: 100%" disabled="">
                <option value="0" selected>-- SELECCIONE --</option>
                <?php
                foreach ($rsP as $row) {
                  echo "<option value='" . $row['id_producto'] . "'"; 
                  if($row['id_producto'] == "60"){ echo " selected";}
                  echo">" . $row['nom_producto'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-sm-3">
              <label for="txt_bus_id_dependencia_ate"><small>Dependencia destino:</small></label>
              <?php $rsD = $d->get_listaDepenInstitucion(); ?>
              <select name="txt_bus_id_dependencia_ate" id="txt_bus_id_dependencia_ate" class="form-control" style="width: 100%">
                <option value="0" selected>-- TODOS --</option>
                <?php
                foreach ($rsD as $row) {
                  echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-sm-3">
              <label for="txt_bus_datos_pac_ate"><small>Por Nro. Atención/Nombres/Nro. de Documento:</small></label>
              <input type="text" name="txt_bus_datos_pac_ate" id="txt_bus_datos_pac_ate" class="form-control form-control-sm" value="" />
              <p class="help-block">Digite mínimo dos caracteres.</p>
            </div>
            <div class="col-sm-2">
              <label>&nbsp;</label>
              <button type="button" class="btn btn-success btn-sm btn-block" id="btn_bus_atendidas_reset">Restablecer filtros</button>
            </div>
          </div>
        </form>
        <p></p>
        <table id="tbl_atendidas" class="table table-hover table-bordered" cellspacing="0" width="100%">
          <thead class="bg-green">
            <tr>
              <th><i class="fa fa-cogs"></i></th>
              <th>FECHA<br/>ENVÍO</th>
              <th>NOMBRE DEL PACIENTE</th>
              <th>EXAMEN SOLICITADO</th>
              <th>ESTABLECIMIENTO DESTINO</th>
              <th>FECHA<br/>RESULTADO</th>
              <th>ESTADO ATENCIÓN</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
			</div>

			<div class="tab-pane" id="tab-observadas">
        <form name="frmBusObservadas" id="frmBusObservadas" class="form-horizontal" autocomplete="off">
          <div class="form-group">
            <div class="col-sm-3">
              <label for="txt_bus_id_producto_obs"><small>Examen:</small></label>
              <?php $rsP = $pr->get_listaProductoLaboratorio(); ?>
              <select name="txt_bus_id_producto_obs" id="txt_bus_id_producto_obs" class="form-control" style="width: 100%" disabled="">
                <option value="0" selected>-- SELECCIONE --</option>
                <?php
                foreach ($rsP as $row) {
                  echo "<option value='" . $row['id_producto'] . "'"; 
                  if($row['id_producto'] == "60"){ echo " selected";}
                  echo">" . $row['nom_producto'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-sm-3">
              <label for="txt_bus_id_dependencia_obs"><small>Dependencia origen:</small></label>
              <?php $rsD = $d->get_listaDepenInstitucion(); ?>
              <select name="txt_bus_id_dependencia_obs" id="txt_bus_id_dependencia_obs" class="form-control" style="width: 100%">
                <option value="0" selected>-- TODOS --</option>
                <?php
                foreach ($rsD as $row) {
                  echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-sm-3">
              <label for="txt_bus_datos_pac_obs"><small>Por Nro. Atención/Nombres/Nro. de Documento:</small></label>
              <input type="text" name="txt_bus_datos_pac_obs" id="txt_bus_datos_pac_obs" class="form-control form-control-sm" value="" />
              <p class="help-block">Digite mínimo dos caracteres.</p>
            </div>
            <div class="col-sm-2">
              <label>&nbsp;</label>
              <button type="button" class="btn btn-danger btn-sm btn-block" id="btn_bus_observadas_reset">Restablecer filtros</button>
            </div>
          </div>
        </form>
        <p></p>
        <table id="tbl_observadas" class="table table-hover table-bordered" cellspacing="0" width="100%">
			    <thead class="bg-red">
            <tr>
              <th>FECHA<br/>ENVÍO</th>
              <th>NOMBRE DEL PACIENTE</th>
              <th>EXAMEN SOLICITADO</th>
              <th>ESTABLECIMIENTO DESTINO</th>
              <th>FECHA<br/>RECEPCIÓN</th>
              <th>MOTIVO<br/>OBSERVACIÓN</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
			</div>
		</div>
	</div>
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

<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">

  let resetInEnviadas = false;

  $("#txt_bus_id_dependencia_env").on("change", function () {
    if (resetInEnviadas) return;
    nueva_busqueda_enviada();
  });
  $("#btn_bus_enviadas_reset").on("click", function () {
      resetInEnviadas = true;
      $("#txt_bus_id_dependencia_env").val("0").change();
      $("#txt_bus_datos_pac_env").val("");
      setTimeout(() => {
          nueva_busqueda_enviada();
          resetInEnviadas = false;
    }, 100);
  });
  document.getElementById("txt_bus_datos_pac_env").addEventListener("keyup", function () {
    let valor = this.value.trim();
    if (valor.length >= 2) {
        this.classList.remove("is-invalid");
    } else {
        this.classList.add("is-invalid");
    }
    if (valor.length >= 3) {
        nueva_busqueda_enviada();
    } else if  (valor.length == 0) {
        nueva_busqueda_enviada();
    }
  });
  function nueva_busqueda_enviada(){
    $("#tbl_enviadas").dataTable().fnDraw();
  }

  function imprime_resultado(idaten, iddep, idprod) {
    if(iddep != "735b90b4568125ed6c3f678819b6e058") {
      var urlwindow = "pdf_laboratorioprodn.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
    } else {
      var urlwindow = "pdf_laboratorio_labref.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
    }
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

function back() {
  window.location = './main_derivaexamen.php';
}

function acc_registro(idpap, nroreg, opt){
	//Acciones: A: Anular, NA: Paciente No Asistió
	document.frmBus.txtIdSolicitud.value = idpap;
	document.frmBus.txt_accion.value = opt; //A anular; E Entregado a paciente
  
	if(opt == 'PNA'){
		save_accion_directo(idpap, 'PNA');
	} else if(opt == 'PA'){
		save_accion_directo(idpap, 'PA');
	} else {
		if(opt == 'A'){
		  $("#showComenModalLabel").text("Anular atención Nro: " + nroreg);
		} else {
		  $("#showComenModalLabel").text("Entregar resultado, atención: " + nroreg + " a paciente");
		}
		$("#showComenModal").modal({
			show: true,
			backdrop: 'static',
			focus: true,
		});
		$('#showComenModal').on('shown.bs.modal', function (e) {
			document.frmComentario.txtDetComen.value = '';
			$('#txtDetComen').trigger('focus');
		})
	}
}

function open_pdfsinvalor(idSoli) {

  var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function nueva_busqueda(){
	$("#example").dataTable().fnDraw();
}

function save_formaccion(){
  $('#btnFrmSaveComen').prop("disabled", true);
  var isValid = true;
  var msgobs = '';
  var txtTipAccSP = '';
  var id_atencion = document.frmBus.txtIdSolicitud.value;
  var txtTipAcc = document.frmBus.txt_accion.value;
  var txtDetComen = document.frmComentario.txtDetComen.value;

  if(txtTipAcc == "A"){
  if(txtDetComen.length <= 2){
    msgobs+='Ingrese Motivo...';
    isValid = false;
  }
  msgconfir = 'Se anulará la atención. ¿Está seguro de continuar?';
  txtTipAccSP = 'A';
  } else if(txtTipAcc == "AoS"){
  if(txtDetComen.length <= 2){
    msgobs+='Ingrese Motivo...';
    isValid = false;
  }
  msgconfir = 'Se anulará la atención en ambos sistemas. ¿Está seguro de continuar?';
  txtTipAccSP = 'A';
  } else {
  /*if(txtDetComen.length <= 2){
    msgobs+='Ingrese Comentario';
    isValid = false;
  }*/
  msgconfir = 'Se cambiará el estado a <b>ENTREGADO A PACIENTE</b>. ¿Está seguro de continuar?';
  txtTipAccSP = txtTipAcc;
  }

  if (isValid == false){
  bootbox.alert(msgobs);
  $('#btnFrmSaveComen').prop("disabled", false);
  return false;
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
          url: "../../controller/ctrlAtencion.php",
          type: "POST",
          data: {
            accion: 'POST_ADD_REG_ACCION_COMPLEMENTARIA', id_atencion: id_atencion, accion_sp: txtTipAccSP, detalle: document.frmComentario.txtDetComen.value,
          },
          success: function (data) {
            if(data == ""){
              $("#example").dataTable().fnDraw();
              $("#tbl_enviadas").dataTable().fnDraw();
              $("#tbl_atendidas").dataTable().fnDraw();
              $("#tbl_observadas").dataTable().fnDraw();
              $('#showComenModal').modal('hide');
              showMessage("Registro actualizado correctamente", "success");
            } else {
              bootbox.alert(msg);
              return false;
            }
          $('#btnFrmSaveComen').prop("disabled", false);
          }
        });
      } else {
        $('#btnFrmSaveComen').prop("disabled", false);
      }
    }
  });
}

function validForm() {
  //$('#btnValidForm').prop("disabled", true);
  var msg = "";
  var sw = true;

  var table = $('#example').DataTable();;
  var rows_selected = table.column(0).checkboxes.selected();

  // Output form data to a console
  $('#example-console-rows').text(rows_selected.join(","));

  var idpac = $('#txtIdPac').val();

  if(rows_selected.join(",") == ""){
    msg+= "Seleccione al menos una atención<br/>";
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
    message: "Se enviaran las atenciones seleccionadas, ¿Está seguro de continuar?",
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

        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlLab.php',
          data: {
            accion: 'POST_ADD_REGENVIO',
            id_destino: $('#txt_bus_id_dependencia_pen').val(),
            id_producto: $('#txt_bus_id_producto_pen').val(),
            id_producto_atencion: $('#example-console-rows').text(),
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $("#example").dataTable().fnDraw();
              $("#tbl_enviadas").dataTable().fnDraw();
              $("#tbl_atendidas").dataTable().fnDraw();
              $("#tbl_observadas").dataTable().fnDraw();
            } else {
              bootbox.alert(msg);
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

$(document).ready(function () {
	$("#txt_bus_id_dependencia_pen, #txt_bus_id_producto_pen, #txt_bus_id_producto_env, #txt_bus_id_dependencia_env, #txt_bus_id_producto_ate, #txt_bus_id_dependencia_ate, #txt_bus_id_producto_obs, #txt_bus_id_dependencia_obs").select2();

 	let fechaInput = $("#txtBusFecIni_pen").val(); // Suponiendo que contiene "dd/mm/yyyy"
	let partes = fechaInput.split("/");
	let oldDate = new Date(partes[2], partes[1] - 1, partes[0]);
	$("#txtBusFecIni_pen").datepicker({
	format: 'dd/mm/yyyy',
	autoclose: true,
	todayHighlight: true,//Resalta la fecha actual
  endDate: new Date()        // ⬅️ no permitir fecha > hoy
	}).on('changeDate', function (e) {//esto lo hago para que no se borre cuando doy clic en la misma fecha seleccionada
		if (e.date === undefined){ return $(this).datepicker("update", oldDate)};
		oldDate = e.date;
	});
	
	let fechaInputF = $("#txtBusFecFin_pen").val(); // Suponiendo que contiene "dd/mm/yyyy"
	let partesF = fechaInputF.split("/");
	let oldDateF = new Date(partesF[2], partesF[1] - 1, partesF[0]);
	$("#txtBusFecFin_pen").datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true,
		todayHighlight: true,
    endDate: new Date()        // ⬅️ no permitir fecha > hoy
	}).on('changeDate', function (e) {
		if (e.date === undefined){ return $(this).datepicker("update", oldDateF)};
		oldDateF = e.date;
	});


  var table = $('#example').DataTable({
    dom: 'lBtip',
    "buttons": [
      {
        text: '<i class="fa fa-mail-forward"></i> Enviar a destino',
        className: "btn btn-info btn-lg",
        action: function ( e, dt, node, config ) {
			    validForm();
        }
     }
    ],
    "lengthMenu": [[50, 100 ,250], [50, 100 ,250, "All"]],
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
      "sAjaxSource": "tbl_derivaexamen_pen.php", // Load Data
	  "sServerMethod": "POST",
      "fnServerParams": function (aoData)
      {
        aoData.push({"name": "id_producto", "value": $("#txt_bus_id_producto_pen").val()});
        aoData.push({"name": "fecha_ini", "value": $("#txtBusFecIni_pen").val()});
        aoData.push({"name": "fecha_fin", "value": $("#txtBusFecFin_pen").val()});
      },
    "language": {
      "url": "../../assets/plugins/datatables/Spanish.json",
      "lengthMenu": '_MENU_ entries per page',
      "search": '<i class="fa fa-search"></i>',
      "paginate": {
        "previous": '<i class="fa fa-angle-left"></i>',
        "next": '<i class="fa fa-angle-right"></i>'
      }
    },
    initComplete: function () {
      table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
          that
          .search( this.value )
          .draw();
        } );
      } );
    },
    'columnDefs': [
      {'targets': 0, 'checkboxes': {'selectRow': true}, "class": "text-center"},
      {"orderable": false, "targets": 1, "searchable": true, "class": "small text-center"},
      {"orderable": false, "targets": 2, "searchable": true, "class": "small font-weit"},
      {"orderable": false, "targets": 3, "searchable": true, "class": "small"},
      {"orderable": false, "targets": 4, "searchable": true, "class": "small text-center"},
      {"orderable": false, "targets": 5, "searchable": true, "class": "small text-center"},
      {"orderable": false, "targets": 6, "searchable": true, "class": "small text-center"},
      {"orderable": false, "targets": 7, "searchable": true, "class": "small"},
    ],
    'select': {
      'style': 'multi',
    },
    'order': [1, 'asc']
  });

var dTableP = $('#tbl_enviadas').DataTable({
    autoWidth: false,
    bLengthChange: false,
    bProcessing: true,
    bServerSide: true,
    responsive: true,
    bInfo: true,
    bFilter: false,
    sAjaxSource: "tbl_derivaexamen_env.php",
    sServerMethod: "POST",
    fnServerParams: function (aoData) {
        aoData.push({name: "id_producto", value: $("#txt_bus_id_producto_env").val()});
        aoData.push({name: "id_dependencia_destino", value: $("#txt_bus_id_dependencia_env").val()});
        aoData.push({name: "datos_pac", value: $("#txt_bus_datos_pac_env").val()});
    },
    language: {
        url: "../../assets/plugins/datatables/Spanish.json"
    },
    columnDefs: [
        { targets: 0, className: "text-center text-bold" }, // 
        { targets: 1, className: "small" },             // 
        { targets: 2, className: "small" }, // 
        { targets: 3, className: "small" }, // 
        { targets: 4, className: "small" }, // 
        { targets: 5, className: "text-center small" }, // 
        { targets: 6, className: "text-center" }
    ],
    createdRow: function (row, data) {
        if (data.id_estado_atencion === "5") {
            $(row).addClass("success");
        }
    },
    columns: [
      {
        render: (data, type, row, meta) => {
          return `<div class="">        
          <div class='text-center'>${row.btn_anular}</div>
        </div>`; },
      },
      { data: "fecha_envio" },
      { data: "paciente" },
      { data: "producto" },
      { data: "dependencia_destino" },
      { data: "estado_resul" },
      { data: "cnt_dia" }
    ]
});

var dTableP = $('#tbl_atendidas').DataTable({
    autoWidth: false,
    bLengthChange: false,
    bProcessing: true,
    bServerSide: true,
    responsive: true,
    bInfo: true,
    bFilter: false,
    sAjaxSource: "tbl_derivaexamen_ate.php",
    sServerMethod: "POST",
    fnServerParams: function (aoData) {
        aoData.push({name: "id_producto", value: $("#txt_bus_id_producto_ate").val()});
        aoData.push({name: "id_dependencia_destino", value: $("#txt_bus_id_dependencia_ate").val()});
        aoData.push({name: "datos_pac", value: $("#txt_bus_datos_pac_ate").val()});
    },
    language: {
        url: "../../assets/plugins/datatables/Spanish.json"
    },
    columnDefs: [
        { targets: 0, className: "text-center" }, // opciones
        { targets: 1, className: "text-center text-bold" },  // fecha envío
        { targets: 2, className: "small" }, // Paciente
        { targets: 3, className: "small" }, // Examen
        { targets: 4, className: "small" }, // establecimiento destino
        { targets: 5, className: "text-center small" }, // fecha resultado
        { targets: 6, className: "text-center small" } // estado
    ],
    createdRow: function (row, data) {
        if (data.id_estado_atencion === "5") {
            $(row).addClass("success");
        }
    },
    columns: [
      {
        render: (data, type, row, meta) => {
          return `<div class="">        
          <div class='text-center'>${row.btn_resultado}</div>
        </div>`; },
      },
      { data: "fecha_envio" },
      { data: "paciente" },
      { data: "producto" },
      { data: "dependencia_destino" },
      { data: "fecha_valida_resultado" },
      { data: "estado_atencion" }
    ]
});

var dTableP = $('#tbl_observadas').DataTable({
    autoWidth: false,
    bLengthChange: false,
    bProcessing: true,
    bServerSide: true,
    responsive: true,
    bInfo: true,
    bFilter: false,
    sAjaxSource: "tbl_derivaexamen_obs.php",
    sServerMethod: "POST",
    fnServerParams: function (aoData) {
        aoData.push({name: "id_producto", value: $("#txt_bus_id_producto_obs").val()});
        aoData.push({name: "id_dependencia_destino", value: $("#txt_bus_id_dependencia_obs").val()});
        aoData.push({name: "datos_pac", value: $("#txt_bus_datos_pac_obs").val()});
    },
    language: {
        url: "../../assets/plugins/datatables/Spanish.json"
    },
    columnDefs: [
        { targets: 0, className: "text-center small text-bold" }, // nro_atencion
        { targets: 1, className: "small" },             // paciente
        { targets: 2, className: "small" }, // dependencia
        { targets: 3, className: "small" }, // fecha toma
        { targets: 4, className: "text-center small" }, // fecha envío
        { targets: 5, className: "small" }
    ],
    columns: [
     { data: "fecha_envio" },
      { data: "paciente" },
      { data: "producto" },
      { data: "dependencia_destino" },
      { data: "fecha_recibe_destino" },
      {
        render: (data, type, row, meta) => {
          const det_rechazo = row.detalle_motivo_rechazo ? `<div class='text-left'>${row.detalle_motivo_rechazo}</div>` : ``;
          return `<div class="">        
          <div class='text-left text-bold'>${row.motivo_rechazo}</div> ${det_rechazo}
        </div>`; },
      }
    ]
});

});
</script>
<?php require_once '../include/masterfooter.php'; ?>

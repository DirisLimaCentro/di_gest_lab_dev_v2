<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';
require_once '../../model/UnidadMedida.php';
$um = new UnidadMedida();
require_once '../../model/Producto.php';
$pr = new Producto();
require_once '../../model/Dependencia.php';
$d = new Dependencia();

$a_date = date("Y-m-d");
$fecIni = date("01/m/Y", strtotime($a_date));
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>REPORTE DE ATENCIONES</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-4 col-lg-3">
          <div class="box box-success">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center">Pacientes atendidos en admisión</h3>
              <div id="cntSIS"></div>
			  <button type="button" class="btn btn-warning btn-block" id="btnExportCnt" onclick="expor_cantidad()"><i class="glyphicon glyphicon-open"></i> Exportar cantidades </button>
			  <button type="button" class="btn btn-success btn-block" id="btnExportCnt" onclick="expor_cantidad_serv()"><i class="glyphicon glyphicon-open"></i> Exportar cantidades por servicio </button>
            </div>
          </div>
        </div>
        <div class="col-sm-8 col-lg-9">
          <div class="box box-primary">
            <div class="box-body box-profile">
				<form name="frmBus" id="frmBus" class="form-horizontal">
					<div class="form-group">
					  <div class="col-sm-2 col-md-2">
						<label for="txtBusAnioAsis"><small>Fecha Inicio:</small></label>
						<div class="input-group date">
						  <div class="input-group-addon">
							<i class="glyphicon glyphicon-calendar"></i>
						  </div>
						  <input type="text" class="form-control pull-right input-sm" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo $fecIni ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguientePersona('txtBusFecFin', event);"/>
						</div>
					  </div>
					  <div class="col-sm-2 col-md-2">
						<label for="txtBusAnioAsis"><small>Fecha Final:</small></label>
						<div class="input-group date">
						  <div class="input-group-addon">
							<i class="glyphicon glyphicon-calendar"></i>
						  </div>
						  <input type="text" class="form-control pull-right input-sm" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
						</div>
					  </div>
					  <div class="col-sm-4 col-md-4">
						<br/>
						<label class="radio-inline">
						  <input type="radio" name="opt_gestante" id="opt_gestante99" value="99" checked> Todos
						</label>
						<label class="radio-inline">
						  <input type="radio" name="opt_gestante" id="opt_gestante1" value="1"> Gestante
						</label>
						<label class="radio-inline">
						  <input type="radio" name="opt_gestante" id="opt_gestante0" value="0"> No gestante
						</label>
					  </div>
					  <div class="col-sm-4 col-md-3">
						  <div class="row">
							<div class="col-sm-12">
							  <label for="txt_condicion_eg">Edad gestacional:</label>
							</div>
						  </div>
						  <div class="row">
							<div class="col-xs-4" style="padding-right: 0!important;">
							  <select class="form-control input-sm" name="txt_condicion_eg" id="txt_condicion_eg" disabled>
								<option value="">Todas las EG</option>
								<option value="<">EG menor a </option>
								<option value="=">EG igual a </option>
								<option value=">">EG mayor a</option>
							  </select>
							</div>
							<div class="col-xs-8" style="padding-left: 0!important;">
								<input type="text" class="form-control input-sm" id="txt_nro_eg" disabled>
							</div>
						  </div>
					   </div>
					   <div class="row"></div>
					   <div class="col-sm-4 col-md-4">
						<label for="txt_bus_id_producto"><small>Examen o Perfil solicitado:</small></label>
						<?php $rsP = $pr->get_listaProductoLaboratorio(); ?>
						<select name="txt_bus_id_producto" id="txt_bus_id_producto" class="form-control select" multiple data-mdb-clear-button="true">
						  <?php
						  foreach ($rsP as $row) {
							echo "<option value='" . $row['id_producto'] . "'>" . $row['nom_producto'] . "</option>";
						  }
						  ?>
						</select>
					  </div>
					  <div class="col-sm-3 col-md-3">
						<div class="row">
							<div class="col-sm-12">
							  <small><label class="checkbox-inline"><input type="checkbox" name="chk_condicion_edad" id="chk_condicion_edad" value="1"> Por edades?</label></small>
							</div>
						  </div>
						  <div class="row">
							<div class="col-xs-6" style="padding-right: 0!important;">
								<input type="text" class="form-control input-sm" id="txt_edad_desde" placeholder="Desde" value="" disabled>
							</div>
							<div class="col-xs-6" style="padding-left: 0!important;">
								<input type="text" class="form-control input-sm" id="txt_edad_hasta" placeholder="Hasta" value="" disabled>
							</div>
						  </div>
					  </div>
					  <div class="col-sm-2 col-md-1">
						<br/>
						<label class="checkbox-inline"><input type="checkbox" id="chk_condicion_urgente" value="1"/> Urgentes</label>
					  </div>
					  <div class="col-sm-1 col-md-1">
						<br/>
						<button class="btn btn-success btn-sm" type="button" id="btnCon" onclick="buscar_datos();" tabindex="0" style="width: 100%"><i class="glyphicon glyphicon-search"></i> Buscar</button>
					  </div>
					  <div class="col-sm-2 col-md-2">
						<ul class="nav nav-pills input-sm" role="tablist"> 
							<li role="presentation" class="dropdown" style="background-color: #eee;"> 
								<a href="#" class="dropdown-toggle" id="drop4" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Exportar en... <span class="caret"></span> </a>
								<ul class="dropdown-menu" id="menu1" aria-labelledby="drop4"> 
									<li><a href="#" onclick="exporbuscar_datos('H');">Horizontal PDF</a></li>
									<li><a href="#" onclick="exporbuscar_datos('V');">Vertical PDF</a></li>
									<li><a href="#" onclick="exporbuscar_datos('E');">En Excel (Sin examenes)</a></li>
								</ul> 
							</li>
						</ul>
					  </div>
					</div>
					<div class="form-group">
					  <div class="col-sm-3 col-md-3">
						<div class="row">
							<div class="col-sm-12">
							  <small><label class="checkbox-inline"><input type="checkbox" name="chk_id_dep_procedencia" id="chk_id_dep_procedencia" value="1"> EESS procedencia?</label></small>
							</div>
						  </div>
						  <div class="row">
							<div class="col-xs-12">
								<?php $rsD = $d->get_listaDepenInstitucion(); ?>
								<select name="txtBusIdDepRef" id="txtBusIdDepRef" style="width:100%;" class="form-control input-sm" disabled>
								  <option value="" selected>-- Todos --</option>
								  <?php
								  foreach ($rsD as $row) {
									echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
								  }
								  ?>
								</select>
							</div>
						  </div>
					  </div>
					</div>
				</form>
				<table id="tblAtencion" class="display" cellspacing="0" width="100%">
				  <thead class="bg-aqua">
					<tr>
					  <th>#<br/>ATENCION</th>
					  <th>DOC.<br/>IDENTIDAD</th>
					  <th>PACIENTE</th>
					  <th>FECHA<br/>ATENCION</th>
					  <th>PLAN<br/>TARIFARIO</th>
					  <th>ESTADO<br/>RESULTADO</th>
					  <th><i class="fa fa-cogs"></i></th>
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
    <div class="modal-footer">
      <button type="button" class="btn btn-info pull-right" id="btnBackForm" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Ir al Menú</button>
    </div>
  </div>
</div>
<?php require_once '../include/footer.php'; ?>
<script src="../../assets/plugins/multiselect/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="../../assets/plugins/multiselect/bootstrap-multiselect.css" type="text/css"/>
<script Language="JavaScript">

function buscar_datos() {
  var fecIni = $("#txtBusFecIni").val();
  var fecFin = $("#txtBusFecFin").val();

  var msg = "";
  var sw = true;

  if (fecIni != "") {
    if (fecFin == "") {
      msg+= "Ingrese Fecha Final<br/>";
      sw = false;
    }
  }

  if (fecIni != "") {
    if (validarFormatoFecha(fecIni) == false) {
      msg+= "Ingrese Fecha de Inicio Correctamente<br/>";
      sw = false;
    }
  }
  if (fecFin != "") {
    if (validarFormatoFecha(fecFin) == false) {
      msg+= "Ingrese Fecha Final Correctamente<br/>";
      sw = false;
    }
  }

  f1 = fecIni.split("/");
  f2 = fecFin.split("/");

  var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
  var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

  if (f1 > f2) {
    msg+= "La Fecha de Incio debe ser menor o igual a la fecha Final<br/>";
    sw = false;
  }

  if (sw == false) {
    bootbox.alert(msg);
    return false;
  }

  buscar_datossis();
  $("#tblAtencion").dataTable().fnDraw();
}

function exporbuscar_datos(opt) {
    var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();
	var chk_gestante = $("input[type=radio][name=opt_gestante]:checked").val();
	var condicion_eg = $("#txt_condicion_eg").val();
	var nro_eg = $("#txt_nro_eg").val();
	if($("#txt_bus_id_producto").val() !== null){
		var id_producto = $("#txt_bus_id_producto").val().join();
	} else {
		var id_producto = "";
	}
	if(document.getElementById("chk_condicion_edad").checked==true){
		var condicion_edad="1";
	}else{
		var condicion_edad='';
	}
	var edad_desde = $("#txt_edad_desde").val();
	var edad_hasta = $("#txt_edad_hasta").val();
	if(document.getElementById("chk_condicion_urgente").checked==true){
		var condicion_urgente="1";
	}else{
		var condicion_urgente='';
	}
	if(document.getElementById("chk_id_dep_procedencia").checked==true){
		var condicion_dep_procedencia="1";
	}else{
		var condicion_dep_procedencia='';
	}
	var id_dep_procedencia = $("#txtBusIdDepRef").val();

    $('#titleModalAlert').text('Mensaje de Alerta ...');

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
	
	if (opt == "E"){
		window.location = "./xls_repatencion.php?fecIni="+ fecIni + "&fecFin=" + fecFin + "&chk_gestante=" + chk_gestante + "&condicion_eg=" + condicion_eg + "&nro_eg=" + nro_eg + "&id_producto=" + id_producto + "&condicion_edad=" + condicion_edad + "&edad_desde=" + edad_desde + "&edad_hasta=" + edad_hasta + "&condicion_urgente=" + condicion_urgente + "&condicion_dep_procedencia=" + condicion_dep_procedencia + "&id_dep_procedencia=" + id_dep_procedencia + "&opt=" + opt;
	} else {
		var urlwindow = "pdf_repatencion.php?fecIni="+ fecIni + "&fecFin=" + fecFin + "&chk_gestante=" + chk_gestante + "&condicion_eg=" + condicion_eg + "&nro_eg=" + nro_eg + "&id_producto=" + id_producto + "&condicion_edad=" + condicion_edad + "&edad_desde=" + edad_desde + "&edad_hasta=" + edad_hasta + "&condicion_urgente=" + condicion_urgente + "&condicion_dep_procedencia=" + condicion_dep_procedencia + "&id_dep_procedencia=" + id_dep_procedencia + "&opt=" + opt;
		day = new Date();
		id = day.getTime();
		Xpos = (screen.width / 2) - 390;
		Ypos = (screen.height / 2) - 300;
		eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
	}
}

function buscar_datossis(){
  $.ajax({
    url: "../../controller/ctrlAtencion.php",
    type: "POST",
    data: {
      accion: 'GET_CNTATENCIONESPORFECHA', fecIni: $("#txtBusFecIni").val(), fecFin: $("#txtBusFecFin").val()
    },
    success: function (registro) {
      $("#cntSIS").html(registro);
    }
  });
}

function expor_cantidad(id) {
	//btnExportCnt
	var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();

    $('#titleModalAlert').text('Mensaje de Alerta ...');

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
	
  window.location = './xls_cnt_atencion.php?fecIni='+$("#txtBusFecIni").val()+'&fecFin='+$("#txtBusFecFin").val();
}

function expor_cantidad_serv() {
	//btnExportCnt
	var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();

    $('#titleModalAlert').text('Mensaje de Alerta ...');

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
	
  window.location = './xls_cnt_atencion_por_servicio.php?fecIni='+$("#txtBusFecIni").val()+'&fecFin='+$("#txtBusFecFin").val();
}

function back() {
  window.location = '../pages/';
}

$(function() {

	$('[name="opt_gestante"]').change(function(){
		if ($(this).is(':checked')) {
		  if($(this).val() == "1"){
			$("#txt_condicion_eg").prop('disabled', false);
			$("#txt_nro_eg").prop('disabled', false);
			$("#txt_condicion_eg").val('');
			$("#txt_nro_eg").val('');
		  } else {
			$("#txt_condicion_eg").prop('disabled', true);
			$("#txt_nro_eg").prop('disabled', true);
			$("#txt_condicion_eg").val('');
			$("#txt_nro_eg").val('');
		  }
		};
	});

	$('[name="chk_condicion_edad"]').change(function(){
		if ($(this).is(':checked')) {
			$("#txt_edad_desde").prop('disabled', false);
			$("#txt_edad_desde").val('');
			$("#txt_edad_hasta").prop('disabled', false);
			$("#txt_edad_hasta").val('');
			setTimeout(function(){$('#txt_edad_desde').trigger('focus');}, 2);
		} else {
			$("#txt_edad_desde").prop('disabled', true);
			$("#txt_edad_desde").val('');
			$("#txt_edad_hasta").prop('disabled', true);
			$("#txt_edad_hasta").val('');			
		}
	});

	$('[name="chk_id_dep_procedencia"]').change(function(){
		if ($(this).is(':checked')) {
			$("#txtBusIdDepRef").prop('disabled', false);
			$("#txtBusIdDepRef").val('').trigger("change");
		} else {
			$("#txtBusIdDepRef").prop('disabled', true);
			$("#txtBusIdDepRef").val('').trigger("change");
		}
	});
});

$(document).ready(function () {
	$("#txtBusIdDepRef").select2();
	
	buscar_datossis();
	$("#txtBusFecIni").datepicker({
	format: 'dd/mm/yyyy',
	autoclose: true,
	});
	$("#txtBusFecFin").datepicker({
	format: 'dd/mm/yyyy',
	autoclose: true,
	});

	var dTable = $('#tblAtencion').DataTable({
	"bLengthChange": true, //Paginado 10,20,50 o 100
	"bProcessing": true,
	"bServerSide": true,
	"bJQueryUI": false,
	"responsive": true,
	"bInfo": true,
	"bFilter": false,
	"sAjaxSource": "tbl_repatencion.php", // Load Data
	"language": {
	"url": "../../assets/plugins/datatables/Spanish.json",
	"lengthMenu": '_MENU_ registros por p\xe1gina',
	"search": '<i class="glyphicon glyphicon-search"></i>',
	"paginate": {
	  "previous": '<i class="glyphicon glyphicon-arrow-left"></i>',
	  "next": '<i class="glyphicon glyphicon-arrow-right"></i>'
	}
	},
	"sServerMethod": "POST",
	"fnServerParams": function (aoData)
	{
		if(document.getElementById("chk_condicion_edad").checked==true){
			var condicion_edad="1";
		}else{
			var condicion_edad='';
		}
		if(document.getElementById("chk_condicion_urgente").checked==true){
			var condicion_urgente="1";
		}else{
			var condicion_urgente='';
		}
		if(document.getElementById("chk_id_dep_procedencia").checked==true){
			var condicion_dep_procedencia="1";
		}else{
			var condicion_dep_procedencia='';
		}
		if($("#txt_bus_id_producto").val() !== null){
			var id_producto = $("#txt_bus_id_producto").val().join();
		} else {
			var id_producto = "";
		}
		
		aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
		aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
		aoData.push({"name": "chk_gestante", "value": $("input[type=radio][name=opt_gestante]:checked").val()});
		aoData.push({"name": "condicion_eg", "value": $("#txt_condicion_eg").val()});
		aoData.push({"name": "nro_eg", "value": $("#txt_nro_eg").val()});
		aoData.push({"name": "id_producto", "value": id_producto});
		aoData.push({"name": "condicion_edad", "value": condicion_edad});
		aoData.push({"name": "edad_desde", "value": $("#txt_edad_desde").val()});
		aoData.push({"name": "edad_hasta", "value": $("#txt_edad_hasta").val()});
		aoData.push({"name": "condicion_urgente", "value": condicion_urgente});
		aoData.push({"name": "condicion_dep_procedencia", "value": condicion_dep_procedencia});
		aoData.push({"name": "id_dep_procedencia", "value": $("#txtBusIdDepRef").val()});
	},
	/*"fnServerParams": function ( aoData ) {
	aoData.push( { "name": "id_tabla", "value": $('#cboiddep').val() } );
	},*/

	"columnDefs": [
	{"orderable": false, "targets": 0, "searchable": true, "class": "small"},
	{"orderable": false, "targets": 1, "searchable": false, "class": "small"},
	{"orderable": false, "targets": 2, "searchable": false, "class": "small"},
	{"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"},
	{"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
	{"orderable": false, "targets": 5, "searchable": false, "class": "small"},
	{"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
	]
	});
	$('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');

	var multiselect_options = {
		enableFiltering: true,
		includeSelectAllOption: true,
		selectAllName: 'select-all-name',
		nSelectedText: 'Seleccionados',
		nonSelectedText: 'Seleccionar',
		allSelectedText: 'TODOS',
		filterPlaceholder: 'Buscar',
		selectAllText: 'SELECCIONAR TODOS',
		buttonClass: 'btn input-sm',
		enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
		inheritClass: true,
		maxHeight: 200,
		buttonWidth: '100%',
		widthSynchronizationMode: 'ifPopupIsSmaller'
	};
	$('#txt_bus_id_producto').multiselect(multiselect_options);
	
	//$("#txt_bus_id_producto").multiselect('selectAll', false);
    //$("#txt_bus_id_producto").multiselect('updateButtonText');
	
});
</script>
<?php require_once '../include/masterfooter.php'; ?>

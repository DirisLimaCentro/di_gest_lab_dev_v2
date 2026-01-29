<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';
require_once '../../model/UnidadMedida.php';
$um = new UnidadMedida();

require_once '../../model/Componente.php';
$c = new Componente();

$a_date = date("Y-m-d");
$fecIni = date("01/m/Y", strtotime($a_date));
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>REPORTE DE RESULTADOS</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3">
          <div class="box box-success">
            <br/>
            <div class="box-body box-profile">
				<div class="col-xs-12">
				  <h3 class="profile-username text-center">Pacientes</h3>
				  <div id="cntSIS"></div>
				  <button type="button" class="btn btn-warning btn-block" id="btnExportCnt" onclick="expor_cantidad()"><i class="glyphicon glyphicon-open"></i> Exportar cantidades </button>
				</div>
            </div>
		  </div>
        </div>
        <div class="col-sm-9">
			  <div class="box box-primary">
				<br/>
					<div class="row">
						<form name="frmBus" id="frmBus">
							  <div class="col-sm-2 col-md-2 form-group">
								<label for="txtBusAnioAsis"><small>Fecha Inicio:</small></label>
								<div class="input-group date">
								  <div class="input-group-addon">
									<i class="glyphicon glyphicon-calendar"></i>
								  </div>
								  <input type="text" class="form-control pull-right input-sm" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo $fecIni ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguientePersona('txtBusFecFin', event);"/>
								</div>
							  </div>
							  <div class="col-sm-2 col-md-2 form-group">
								<label for="txtBusAnioAsis"><small>Fecha Final:</small></label>
								<div class="input-group date">
								  <div class="input-group-addon">
									<i class="glyphicon glyphicon-calendar"></i>
								  </div>
								  <input type="text" class="form-control pull-right input-sm" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
								</div>
							  </div>
							  <div class="col-sm-3 form-group">
								<label for="txt_bus_id_examen">Examen:</label>
								<?php $rsC = $c->get_listaDetComponentePorProductos(); ?>
								<select name="txt_bus_id_examen" id="txt_bus_id_examen" class="form-control select" multiple data-mdb-clear-button="true">
								  <?php
								  foreach ($rsC as $row) {
									echo "<option value='" . $row['id_componentedet'] . "'>" . $row['componente'] . "</option>";
								  }
								  ?>
								</select>
							  </div>
							  <div class="col-sm-2 form-group">
								<br/>
								<button class="btn btn-success btn-sm" type="button" id="btnCon" onclick="buscar_datos();" tabindex="0" style="width: 100%"><i class="glyphicon glyphicon-search"></i> Buscar</button>
							  </div>
							  <div class="col-sm-2 form-group">
								<br/>
								<button id="btnRegistrarAsis" class="btn btn-warning pull-right btn-sm" type="button" onclick="exporbuscar_datos();" style="width: 100%"><i class="glyphicon glyphicon-open"></i> Exportar listado</button>
							  </div>
						</form>
					 </div>
				<br/>
					<div class="row">
						<div class="col-xs-12">
						<table id="tblAtencion" class="display" cellspacing="0" width="100%">
						  <thead class="bg-aqua">
							<tr>
							  <th>#<br/>ATENCION</th>
							  <th>DOC.<br/>IDENTIDAD</th>
							  <th>PACIENTE</th>
							  <th>PLAN<br/>TARIFARIO</th>
							  <th>FECHA<br/>ATENCION</th>
							  <th>FECHA<br/>RESULTADO</th>
							  <th>EXAMEN</th>
							  <th>RESULTADO</th>
							  <th>U.M.</th>
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

function exporbuscar_datos() {
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

    var urlwindow = "pdf_represultadosexamen.php?fecIni="+ fecIni + "&fecFin=" + fecFin + "&id_examen=" + $("#txt_bus_id_examen").val().join();
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function buscar_datossis(){
  $.ajax({
    url: "../../controller/ctrlAtencion.php",
    type: "POST",
    data: {
      accion: 'GET_CNTRESULTADOSPORFECHAANDPLANTARIFARIO', fecIni: $("#txtBusFecIni").val(), fecFin: $("#txtBusFecFin").val()
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


function back() {
  window.location = '../pages/';
}

$(document).ready(function () {
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
    /*"language": {
    "url": "../plugins/datatables/Spanish.json"
  },*/
  "bLengthChange": true, //Paginado 10,20,50 o 100
  "bProcessing": true,
  "bServerSide": true,
  "bJQueryUI": false,
  "responsive": true,
  "bInfo": true,
  "bFilter": true,
  "sAjaxSource": "tbl_represultados.php", // Load Data
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
    aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
    aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
	aoData.push({"name": "id_examen", "value": $("#txt_bus_id_examen").val().join()});

  },
  /*"fnServerParams": function ( aoData ) {
  aoData.push( { "name": "id_tabla", "value": $('#cboiddep').val() } );
},*/

"columnDefs": [
  {"orderable": true, "targets": 0, "searchable": true, "class": "small"},
  {"orderable": false, "targets": 1, "searchable": false, "class": "small"},
  {"orderable": false, "targets": 2, "searchable": false, "class": "small"},
  {"orderable": true, "targets": 3, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 6, "searchable": false, "class": "small"},
  {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 8, "searchable": false, "class": "small text-center"},
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
		inheritClass: true,
		maxHeight: 170,
		buttonWidth: '100%',
		widthSynchronizationMode: 'ifPopupIsSmaller'
	};
	$('#txt_bus_id_examen').multiselect(multiselect_options);
	
	$("#txt_bus_id_examen").multiselect('selectAll', false);
    $("#txt_bus_id_examen").multiselect('updateButtonText');

});
</script>
<?php require_once '../include/masterfooter.php'; ?>

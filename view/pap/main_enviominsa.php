<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
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
      <h3 class="panel-title"><strong>ENVÍO DE ATENCIONES DE PAP</strong></h3>
    </div>
    <div class="panel-body">
      <form class="form-horizontal" name="frmRepPrin" id="frmRepPrin" onsubmit="return false;">
        <input type="hidden" name="txtIdPap" id="txtIdPap" value=""/>
        <input type="hidden" name="txtTipAcc" id="txtTipAcc" value=""/>

        <div class="form-group">
          <div class="col-sm-4 col-md-4">
		  <label for="txt_id_estadoenvminsa"><small>Estado envío atención:</small></label>
			<select name="txt_id_estadoenvminsa" id="txt_id_estadoenvminsa"  class="form-control input-sm">
				<option value="0" selected>SIN ENVIAR, ENVIADO SIN RESPUESTA, ENVIO OBSERVADO</option>
				<option value="3">ENVÍO SATISFACTORIO</option>
            </select>
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
            <br/>
            <button class="btn btn-success btn-sm" type="button" id="btnBus" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
          </div>
        </div>
      </form>
      <!--<p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <a style="color: #449d44;"><i class="glyphicon glyphicon-pencil"></i></a>=Editar Atención | <a style="color: #F44336;"><i class="glyphicon glyphicon-trash"></i></a>=Anular Atención |  <a style="color: #449d44;"><i class="glyphicon glyphicon-th-list"></i></a>=Ver datos de Lámina EESS | <a style="color: #00c0ef;"><i class="glyphicon glyphicon-eye-open"></i></a>=Ver ficha de atención o resultado | <a style="color: #449d44;"><i class="glyphicon glyphicon-user"></i></a>=Entregar resultado a Paciente</p>-->
      <br/>
      <table id="tblSolicitud" class="display" cellspacing="0" width="100%">
        <thead class="bg-aqua">
          <tr>
		    <th>ESTABLECIMIENTO DE SALUD</th>
            <th>NRO<br/>LÁMINA</th>
			<th style="width: 60px;">FECHA<br/>ATENCIÓN</th>
			<th>SIS</th>
            <th>PACIENTE</th>
            <th style="width: 80px;">Documento<br/>de Identidad</th>
            <th>HC</th>
            <th>ESTADO<br/>ENVÍO</th>
            <th style="width: 60px;">FECHA<br/>ENVÍO</th>
            <th>DESCRIPCIÓN OBS.</th>
            <th>ID_CITA</th>
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
</div>
<?php require_once '../include/footer.php'; ?>
<script type="text/javascript" src="main_enviominsa.js"></script>
  <script Language="JavaScript">
	function back() {
	window.location = '../pages/';
	}
 
	$(document).ready(function () {
		$("#txtBusIdTipDoc").select2();

		$('#txtBusFecIni').datetimepicker({
		  locale: 'es',
		  format: 'L'
		});

		$('#txtBusFecFin').datetimepicker({
		  locale: 'es',
		  format: 'L'
		});

		$("body").tooltip({ selector: '[data-toggle=tooltip]' });

		var dTable = $('#tblSolicitud').DataTable({
		 dom: 'Bltip',
		  "buttons": [
			{
			  text: '<i class="glyphicon glyphicon-plus"></i> Enviar al HIS-MINSA',
			  className: "btn btn-primary btn-lg",
			  action: function ( e, dt, node, config ) {
				procesar_atenciones();
			  }
			},
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
		  "sAjaxSource": "tbl_enviominsa.php", // Load Data
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
			aoData.push({"name": "id_estadoenvminsa", "value": $("#txt_id_estadoenvminsa").val()});
			aoData.push({"name": "fec_ini", "value": $("#txtBusFecIni").val()});
			aoData.push({"name": "fec_fin", "value": $("#txtBusFecFin").val()});
		  },
		  "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
		  },
		  "columnDefs": [
			{"orderable": true, "targets": 0, "searchable": false, "class": "small"},
			{"orderable": false, "targets": 1, "searchable": false, "class": "small text-center font-weit"},
			{"orderable": false, "targets": 2, "searchable": false, "class": "small"},
			{"orderable": false, "targets": 3, "searchable": false, "class": "small"},
			{"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
			{"orderable": false, "targets": 5, "searchable": false, "class": "small"},
			{"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
			{"orderable": false, "targets": 7, "searchable": false, "class": "small text-center font-weit"},
			{"orderable": false, "targets": 8, "searchable": false, "class": "small text-center font-weit"},
			{"orderable": false, "targets": 9, "searchable": false, "class": "small text-center"},
			{"orderable": false, "targets": 10, "searchable": false, "class": "small text-center"},
		  ],
		  "order": [[ 0, "desc" ]]
		});

		$('#tblSolicitud').removeClass('display').addClass('table table-hover table-bordered');
	});

</script>
<?php require_once '../include/masterfooter.php'; ?>

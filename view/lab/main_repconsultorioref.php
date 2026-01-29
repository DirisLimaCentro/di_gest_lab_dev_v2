<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Ubigeo.php';
$ub = new Ubigeo();
require_once '../../model/Profesional.php';
$prof = new Profesional();
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

td.details-control {
  background: url('../../assets/images/details_open.png') no-repeat center center;
  cursor: pointer;
}
tr.shown td.details-control {
  background: url('../../assets/images/details_close.png') no-repeat center center;
}

.table.dataTable tbody tr.active:hover td, .table.dataTable tbody tr.active:hover th {
  background-color: #a7a7a7 !important;
}

.table.dataTable tbody tr.active td, .table.dataTable tbody tr.active th {
  background-color: #cecece;
  color: #333;
}

</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
		<div class="row">
			<div class="col-sm-6">
				<h3 class="panel-title"><strong>BUSCAR RESULTADOS DE LABORATORIO CLINICO SOLICITADOS POR <?php echo $_SESSION['labNomServicio'];?></strong></h3>
			</div>
			<div class="col-sm-6 text-right">
				<h3 class="panel-title"><a href="#" onclick="event.preventDefault(); open_ayuda()">Ayuda <i class="fa fa-question-circle-o" aria-hidden="true"></i></a></h3>
			</div>
		</div>
    </div>
    <div class="panel-body">
	  <form class="form-horizontal" name="frmAccion" id="frmAccion" onsubmit="return false;">
		<input type="hidden" name="txt_id_atencion" id="txt_id_atencion" value=""/>
		<input type="hidden" name="txt_accion" id="txt_accion" value=""/>
	  </form>
	  <fieldset class="scheduler-border">
        <legend class="scheduler-border" style="margin-bottom: 5px;">Buscar atención</legend>
        <form class="form-horizontal" name="frmRepPrin" id="frmRepPrin" onsubmit="return false;">
		
          <div class="form-group">
			<div class="col-md-3">
              <div class="row">
                <div class="col-md-12">
                  <label for="txtIdTipDoc">Documento de identidad</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
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
			<div class="col-sm-2">
				<label for="txtBusHCL">H. CL.:</label>
				<input type="text" class="form-control input-sm" name="txtBusHCL" id="txtBusHCL" autocomplete="OFF" maxlength="10" value="" onkeydown="campoSiguiente('btnBus', event);"/>
			</div>
            <div class="col-sm-3">
              <label for="txtBusNomRS">Nombres o Apellidos del paciente:</label>
              <input class="form-control input-sm" type="text" name="txtBusNomRS" id="txtBusNomRS" autocomplete="OFF" maxlength="150" required="" tabindex="0" onkeydown="campoSiguiente('btnBus', event);">
            </div>
			<div class="col-sm-2">
				<label for="txtBusNroAten">Nro Atención Laboratorio:</label>
				<input type="text" class="form-control input-sm" name="txtBusNroAten" id="txtBusNroAten" autocomplete="OFF" maxlength="10" value="" onkeydown="campoSiguiente('btnBus', event);"/>
				<span class="help-block">Ingresar el número seguido del guión "-" y finalmente el año: 1-2023</span>
			</div>
            <div class="col-sm-1 col-md-1">
              <br/>
              <button class="btn btn-success btn-sm btn-block" type="button" id="btnBus" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
            </div>
            <!--<div class="col-sm-4 col-md-4">
            <br/>
            <button id="btnRegistrarAsis" class="btn btn-warning btn-sm" type="button" onclick="exportar_busqueda();" tabindex="0"><i class="glyphicon glyphicon-open"></i> Exportar a Excel</button>
          </div>-->
        </div>
      </form>
    </fieldset>
      <table id="tblAtencion" class="display" cellspacing="0" width="100%">
        <thead class="bg-aqua">
          <tr>
            <th></th>
            <th>HC</th>
            <th>Nombre de Paciente</th>
            <th>Documento<br/>Identidad</th>
            <th>Tipo<br/>Atención</th>
			<th>Fecha<br/>Atención</th>
            <th>N°<br/>Atención</th>
            <th style="width: 55px;"><i class="fa fa-cogs"></i></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
	  
    </div>
  </div>
</div>

<div class="modal fade" id="mostrar_ayuda" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h2 class="modal-title">AYUDA</h2>
		</div>
		<div class="modal-body">
			<p class="text-left small" style="margin: 0 0 0px;"><b>Leyenda de botones de acción</b>:<br/> <img src="../../assets/images/details_open.png"/>=Mostrar productos solicitados |<button class="btn btn-warning btn-xs"><i class="fa fa-file-text-o"></i></button>=Imprimir Resultado</p>
			<!--<hr/>
			<div class="row">
				<div class="col-sm-6">
					<h5><i class="fa fa-bars"></i> Colores estado atención:</h5>
					<div class="table-responsive">
					  <table class="table table-bordered table-hover">
						<thead>
						  <tr><th><small>COLOR</small></th><th><small>DESCRIPCIÓN</small></th></tr>
						</thead>
						<tbody>
							<tr><td style="padding-top: 0px; padding-bottom: 2px;"><small>Sin color</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Registrado</small></td></tr>
							<tr><td class="active" style="padding-top: 0px; padding-bottom: 2px;"><small>Plomo</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Muestra recibido en parte</small></td></tr>
							<tr><td class="info" style="padding-top: 0px; padding-bottom: 2px;"><small>Celeste</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Muestra(s) recibido completo</small></td></tr>
							<tr><td class="success" style="padding-top: 0px; padding-bottom: 2px;"><small>Verde</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Resultado(s) entregado a paciente</small></td></tr>
							<tr><td class="warning" style="padding-top: 0px; padding-bottom: 2px;"><small>Amarrillo</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Muestra(s) derivada o referenciada a otro EESS</small></td></tr>
							<tr><td class="danger" style="padding-top: 0px; padding-bottom: 2px;"><small>Rojo</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Atención anulada</small></td></tr>
						</tbody>
					  </table>
					</div>
				</div>
				<div class="col-sm-6">
					<h5><i class="fa fa-bars"></i> Colores estado resultado:</h5>
					<div class="table-responsive">
					  <table class="table table-bordered table-hover">
						<thead>
						  <tr><th><small>COLOR</small></th><th><small>DESCRIPCIÓN</small></th></tr>
						</thead>
						<tbody>
							<tr><td style="padding-top: 0px; padding-bottom: 2px;"><small>Sin color</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Pendiente de resultado o resultado pendiente de validar</small></td></tr>
							<tr><td class="primary" style="padding-top: 0px; padding-bottom: 2px;"><small>Azul</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Cuenta con almenos un resultado validado</small></td></tr>
							<tr><td class="success" style="padding-top: 0px; padding-bottom: 2px;"><small>Verde</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Resultado(s) validado completo</small></td></tr>
						</tbody>
					  </table>
					</div>
				</div>
			  </div>-->
		</div>
		<div class="modal-footer">
		<button class="btn btn-default btn-block" type="button" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar Ventana</button>
		</div>
	</div>
	</div>
</div>

<div id="mostrar_anexos_d" class="modal fade" role="dialog" data-backdrop="static"></div>
<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">

function reg_resultado(idatencion) {
	window.location = './main_regresultadoprod2.php?nroSoli=' + idatencion;
}

function maxlength_doc_bus() {
    if ($("#txtBusIdTipDoc").val() == "1"){
      $("#txtBusNroDoc").attr('maxlength', '8');
    } else {
      $("#txtBusNroDoc").attr('maxlength', '15');
    }
    setTimeout(function(){$('#txtBusNroDoc').trigger('focus');}, 2);
}

function open_ayuda(){
  $('#mostrar_ayuda').modal();
}

function open_fua(){
  $('#modal_reg_fua').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });

  /*$('#modal_reg_fua').on('shown.bs.modal', function (e) {
    $("#txtBusNroAten").trigger('focus');

  })*/
}

function imprime_resultado(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorioprodn.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function imprime_resultado_area(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorio_area.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function imprime_resultado_unido(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorion.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function imprime_resultado_unido_check(idaten) {
	if ($('input.check_atencion_' + idaten).is(':checked')) {
	  var id_producto = [];
	  $.each($('input.check_atencion_' + idaten), function() {
		if( $('#txt_'+idaten+'_'+$(this).val()).is(':checked') ){
			id_producto.push($(this).val());
		}
	  });
	} else {
	  var id_producto = '';
	}
  var urlwindow = "pdf_laboratorion_check.php?p=&valid=" + idaten + "&pr=" + id_producto;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function print_resul(idAten, idDep, idProd, nomPac){
  $('#mostrar_anexos_d').modal('show');
  $.ajax({
    url: '../../controller/ctrlAtencion.php',
    type: 'POST',
    data: 'accion=GET_SHOW_PDFATENCION&idAten=' + idAten +'&idDep=' + idDep +'&idProd=' + idProd +'&nomPac=' + nomPac,
    success: function(data){
      $('#mostrar_anexos_d').html(data);
    }
  });
}

function open_pdf(idAten, opt) {
  if(opt == "1"){
    var urlwindow = "pdf_laboratorio.php?id_atencion=" + idAten +"&id_area=0";
  } else {
    var urlwindow = "pdf_laboratorioprod.php?id_atencion=" + idAten +"&id_prod=0";
  }
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}


function buscar_datos() {
  var nomRS = $("#txtBusNomRS").val();
  nomRS = nomRS.replace("%", "");
  var nroDoc = $("#txtBusNroDoc").val();
  nomRS = nroDoc.replace("%", "");
  var nroHCL = $("#txtBusHCL").val();
  nroHCL = nroHCL.replace("%", "");
  var nroAtencion = $("#txtBusNroAten").val();
  nroAtencion = nroAtencion.replace("%", "");
  
  $("#tblAtencion").dataTable().fnDraw();
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

function back() {
  window.location = '../pages/';
}

var dTable;
//var id_dep= document.getElementById('cboiddep').value;
// #areas-grid adalah id pada table
$(document).ready(function () {
  $("#txtBusIdTipDoc").select2();
	$("#txtIdDepRef").select2();
  $("#txtBusFecIni").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });
  $("#txtBusFecFin").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });

  dTable = $('#tblAtencion').DataTable({
    dom: 'Bltip',
    "buttons": [
     ],
    "lengthMenu": [[25, 50, 100 ,250], [25, 50, 100 ,250]],
    "bLengthChange": true,
    "bProcessing": true,
    "bServerSide": true,
    "bJQueryUI": false,
    "responsive": false,
    "bInfo": true,
    "bFilter": false,
    "sAjaxSource": "tbl_repconsultorioref.php", // Load Data
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
		aoData.push({"name": "idTipDoc", "value": $("#txtBusIdTipDoc").val()});
		aoData.push({"name": "nroDoc", "value": $("#txtBusNroDoc").val()});
		aoData.push({"name": "nomRS", "value": $("#txtBusNomRS").val()});
		aoData.push({"name": "nroHCL", "value": $("#txtBusHCL").val()});
		aoData.push({"name": "nroAte", "value": $("#txtBusNroAten").val()});

    },
	"createdRow": function(row, data, index) {
		if (data[8] == "VALID./PARTE" ){
			$('td:eq(8)', row).addClass('primary');
		} else if (data[8] == "VALID./COMPL" ){
			$('td:eq(8)', row).addClass('success');
		}
		
		if (data[7] == "RECIB./PARTE" ){
			$('td:eq(7)', row).addClass('active');
		} else if(data[7] == "RECIB./COMPL."){
			$('td:eq(7)', row).addClass('info');
		}
	},
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
      /* Append the grade to the default row class name */
     if ( aData[7] == "ENTREGRADO PAC." ){
        $('td', nRow).addClass('success');
      } else if ( aData[7] == "ANULADO" ){
        $('td', nRow).addClass('danger');
      }
    },
    "columnDefs": [
      {"orderable": true, "targets": 0, "searchable": false, "class": "text-center"},
      {"orderable": true, "targets": 1, "searchable": false, "class": "text-center font-weit"},
      {"orderable": false, "targets": 2, "searchable": false, "class": ""},
      {"orderable": false, "targets": 3, "searchable": false, "class": ""},
      {"orderable": false, "targets": 4, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 5, "searchable": false, "class": "text-center font-weit"},
      {"orderable": false, "targets": 6, "searchable": false, "class": "text-center font-weit"},
      {"orderable": false, "targets": 7, "searchable": false, "class": "text-center"}
    ],
    "columns": [
      {
        className: 'details-control',
        defaultContent: '',
        data: null,
        orderable: false,
        defaultContent: ''
      },
      { aTargets: 'hcpac'},
      { aTargets: 'pac' },
      { aTargets: 'idenpac'},
      { aTargets: 'servi'},
      { aTargets: 'nroate'},
      { aTargets: 'acc'}
    ],
    "order": [[1, 'desc']]
  });

  $('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');

  $('#tblAtencion tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = dTable.row(tr);
    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
    }
    else {
      row.child(det_producto(row.data())).show();
      tr.addClass('shown');
    }
  });
});

// https://pastebin.com/PePH1NGn
function det_producto(d) {
  //console.log(d[0]);

  var idate = d[0];
  var parametros = {
    "accion": "SHOW_DETPRODUCTOATENCION",
    "idAten": idate
  };
  var div = $("<div id='row_"+d[0]+"' style='width: 50%;'>").addClass( 'Cargando' ).text( 'Cargando...' );
  $.ajax({
    data: parametros,
    url: '../../controller/ctrlAtencion.php',
    type: 'post',
    dataType: 'html',
    success: function (result) {
      div.html(result).removeClass('loading');
    }
  });
  return div;
}
</script>
<?php require_once '../include/masterfooter.php'; ?>

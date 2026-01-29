<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Area.php';
$a = new Area();
require_once '../../model/Grupo.php';
$g = new Grupo();
require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Producto.php';
$p = new Producto();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>CATALOGO DE EXAMENES</strong></h3>
    </div>
    <div class="panel-body">
		<form class="form-horizontal" name="frmBuscar" id="frmBuscar" onsubmit="return false;">
			<input type="hidden" name="txtIdProd" id="txtIdProd" value="0"/>
			<div class="form-group">
			  <div class="col-sm-4">
				<label for="txtIdDep">Dependencia:</label>
				<?php $rsD = $d->get_listaDepenInstitucion(); ?>
				<select name="txtBusIdDep" id="txtBusIdDep" style="width:100%;" onchange="buscar_datos()" <?php if($_SESSION['labIdRolUser'] <> "1") echo " disabled";?>>
				  <option value="" selected="">-- Todos --</option>
				  <?php
				  foreach ($rsD as $row) {
					echo "<option value='" . $row['id_dependencia'] . "'";
					if($_SESSION['labIdRolUser'] <> "1"){
						if($_SESSION['labIdDepUser'] == $row['id_dependencia']) echo " selected";
					}
					echo ">" . $row['codref_depen'] . ": " . $row['nom_depen'] . "</option>";
				  }
				  ?>
				</select>
			  </div>
			  <div class="col-sm-4">
				<label for="txtBusNombre"><small>Nombre del examen:</small></label>
				<input class="form-control input-sm text-uppercase" type="text" name="txtBusNombre" id="txtBusNombre" autocomplete="OFF" maxlength="50" required="" tabindex="0" oninput="buscar_datos()"/>
			  </div>
				<div class="col-sm-3 col-md-3">
					<br/>
					<button id="btnExporBus" class="btn btn-warning pull-right btn-sm" type="button" onclick="exportar_datos();" tabindex="0" style="width: 100%"><i class="glyphicon glyphicon-open"></i> Exportar a Excel</button>
				</div>
			</div>
		</form>
		<br/>
		<table id="tblAtencion" class="display" cellspacing="0" width="100%">
		  <thead>
			<tr>
				<th>ESTABLECIMIENTO DE SALUD</th>
				<th>CODIGO<br/>CPMS</th>
				<th>TIPO</th>
				<th>PRODUCTO</th>
				<th>PREPARACION DEL PACIENTE</th>
				<th style="width: 60px;">PRECIO<br/>SIS</th>
				<th style="width: 60px;">PRECIO<br/>DEMANDA</th>
				<th style="width: 60px;">CNT.<br/>COMPONENTES</th>
				<th style="width: 50px;">Estado</th>
				<th style="width: 20px;"><i class="fa fa-cogs"></i></th>
			</tr>
		  </thead>
		  <tbody>
		  </tbody>
		</table>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-info pull-right" id="btnBackForm" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Ir al Menú</button>
    </div>
  </div>
</div>


<div class="modal fade" id="showCompCptModal" tabindex="-1" role="dialog" aria-labelledby="showCompCptModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showCompCptModalLabel"></h4>
      </div>
      <div class="modal-body">
        <div id="datos-tabla" style="height: 250px;">
          <table id="fixTable" class="table table-bordered table-hover">
            <thead>
				<tr>
				  <th>Componente</th>
				  <th>Unidad Medida</th>
				  <th>Metodo</th>
				  <th>Grupo</th>
				</tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Aceptar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once '../include/footer.php'; ?>
  <script Language="JavaScript">

	/***********************************************************************************************************/
	/////////////////////////////////////////// Componente ////////////////////////////////////////////
	/**********************************************************************************************************/
	function open_comp(idprod, nomprod, idDep){
		document.frmBuscar.txtIdProd.value = idprod;
		carga_grupoarea(idprod, idDep);

		$('#showCompCptModal').modal({
		  show: true,
		  backdrop: 'static',
		  focus: true,
		});

		$('#showCompCptModal').on('shown.bs.modal', function (e) {
		  var modal = $(this)
		  modal.find('.modal-title').text(nomprod)
		})
	}

	function carga_grupoarea(idprod, idDep){
		$.ajax({
		  url: "../../controller/ctrlProducton.php",
		  type: "POST",
		  data: {
			accion: 'GET_SHOW_COMPPORIDPRODUCTOANDIDDEPENDENCIA', idProd: idprod, idDep: idDep
		  },
		  success: function (registro) {
			$("#datos-tabla").html(registro);
			$("#fixTable").tableHeadFixer();
		  }
		});
	}

	function back() {
		window.location = '../pages/';
	}


	function buscar_datos() {
		$("#tblAtencion").dataTable().fnDraw();
	}

	function exportar_datos() {
		var combo = document.getElementById("txtBusIdDep");
		var nom_establecimiento = combo.options[combo.selectedIndex].text;
		window.location = './xls_repproductos.php?id_establecimiento=' + $("#txtBusIdDep").val() + '&nom_establecimiento=' + nom_establecimiento;
	}

	$(document).ready(function () {
		$("#txtBusIdDep").select2();
		$("#fixTable").tableHeadFixer();

		var dTable = $('#tblAtencion').DataTable({
		  "lengthMenu": [[15, 25, 50, 100 ,250], [15, 25, 50, 100 ,250]],
		  "bLengthChange": true, //Paginado 10,20,50 o 100
		  "bProcessing": true,
		  "bServerSide": true,
		  "bJQueryUI": false,
		  "responsive": true,
		  "bInfo": true,
		  "bFilter": true,
		  "sAjaxSource": "tbl_repproductos.php", // Load Data
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
			aoData.push({"name": "id_establecimiento", "value": $("#txtBusIdDep").val()});
			aoData.push({"name": "nom_producto", "value": $("#txtBusNombre").val()});
		  },
		  "columnDefs": [
			{"orderable": false, "targets": 0, "searchable": false, "class": "small"},
			{"orderable": false, "targets": 1, "searchable": false, "class": "small text-center"},
			{"orderable": false, "targets": 2, "searchable": true, "class": "small"},
			{"orderable": false, "targets": 3, "searchable": false, "class": "small"},
			{"orderable": false, "targets": 4, "searchable": false, "class": "small"},
			{"orderable": false, "targets": 5, "searchable": false, "class": "small text-right"},
			{"orderable": false, "targets": 6, "searchable": false, "class": "small text-right"},
			{"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"},
			{"orderable": false, "targets": 8, "searchable": false, "class": "small text-center"},
			{"orderable": false, "targets": 9, "searchable": false, "class": "small text-center"}
		  ]
		});

		$('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');
	});
</script>
<?php require_once '../include/masterfooter.php'; ?>

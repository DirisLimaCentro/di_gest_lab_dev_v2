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
      <h3 class="panel-title"><strong>MANTENIMIENTO DE PLAN TARIFARIO</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3">
          <div class="box box-success">
            <br/>
            <div class="box-body box-profile">
              <h3 class="profile-username text-center" id="titleAcc">Nuevo Plan</h3>
              <form id="frmPlan" name="frmPlan" class="form-horizontal">
                <input type="hidden" name="txt_id_plan" id="txt_id_plan" value="0"/>
				<div class="form-group">
				  <div class="col-sm-6">
					  <label for="txt_abrev_plan">Abreviatura</label>
					  <input type="text" class="form-control input-sm" name="txt_abrev_plan" id="txt_abrev_plan" autocomplete="off" maxlength="15"/>
					  <span class="help-block">Hasta 15 caracteres</span>
				  </div>
				  <div class="col-sm-6">
					  <label for="txt_sigla_plan">Sigla</label>
					  <input type="text" class="form-control input-sm" name="txt_sigla_plan" id="txt_sigla_plan" autocomplete="off" maxlength="10"/>
					  <span class="help-block">Hasta 10 caracteres</span>
				  </div>
				</div>
                <div class="form-group">
				  <div class="col-sm-12">
					  <label for="txtNomProd">Nombre completo</label>
					  <input type="text" class="form-control input-sm" name="txt_nom_plan" id="txt_nom_plan" autocomplete="off" maxlength="50"/>
					  <span class="help-block">Hasta 50 caracteres</span>
				  </div>
                </div>
				<div class="form-group">
					<div class="col-sm-12">
						<div class="checkbox">
							<label><input type="checkbox" name="chk_check_precio" id="chk_check_precio"> Se cobra?</label>
						</div>
					</div>
				</div>
				<hr/>
                <button type="button" class="btn btn-primary btn-block" id="btnValidForm" onclick="save_form()"><i class="fa fa-save"></i> Guardar </button>
                <div id="show-new" style="display:none; margin-top:5px;">
                  <button type="button" class="btn btn-success btn-block" id="btnNewForm" onclick="nuevo_registro()"><i class="glyphicon glyphicon-plus"></i> Nuevo Plan </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="box box-primary">
            <br/>
            <table id="tblAtencion" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>ABREVIATURA</th>
                  <th>NOMBRE COMPLETO</th>
                  <th>SIGLAS</th>
                  <th>SE COBRA?</th>
                  <th style="width: 60px;">Cnt.<br/>Dependencia</th>
                  <th style="width: 50px;">Estado</th>
                  <th style="width: 60px;"><i class="fa fa-cogs"></i></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-info pull-right" id="btnBackForm" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Ir al Menú</button>
    </div>
  </div>
</div>

  <div class="modal fade" id="showLisDepModal" tabindex="-1" role="dialog" aria-labelledby="showLisDepModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showLisDepModalLabel"></h4>
        </div>
        <div class="modal-body">
		<form class="form-horizontal" name="frmDepProd" id="frmDepProd">
			<input type="hidden" name="txt_id_plan_dep" id="txt_id_plan_dep" value="0"/>
			  <div class="form-group">
				<div class="col-sm-8">
					<label for="txtIdDep">Dependencia:</label>
					<?php $rsD = $d->get_listaDepenInstitucion(); ?>
					<select name="txtIdDep" id="txtIdDep" class="form-control select" multiple data-mdb-clear-button="true">
					  <?php
					  foreach ($rsD as $row) {
						echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
					  }
					  ?>
					</select>
				</div>
				<div class="col-sm-4">
					<label for="txtIdDep">&nbsp;</label>
					<button type="button" class="btn btn-primary btn-block btn-sm" id="btnValidFormDep" onclick="save_form_dep()"><i class="fa fa-save"></i> Agregar </button>
				</div>
			</div>
		</form>
		<hr/>
          <div id="datos-lis-dep" style="height: 250px;">
            <table id="fixTableDep" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><small>Dependencia</small></th>
                  <th><small>Estado</small></th>
                  <th><small>&nbsp;</small></th>
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
  <script src="../../assets/plugins/multiselect/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="../../assets/plugins/multiselect/bootstrap-multiselect.css" type="text/css"/>
  <script Language="JavaScript">

  /***********************************************************************************************************/
  /////////////////////////////////////////// Dependencia ////////////////////////////////////////////
  /**********************************************************************************************************/

  function open_dependencia(idplan, nomplan){
    document.frmPlan.txt_id_plan.value = idplan;
	$('#txtIdDep').multiselect('deselectAll', false);
	$('#txtIdDep').multiselect('updateButtonText');
	$('#txtIdDep').multiselect('enable');
    carga_dependencia(idplan);
	
    $('#showLisDepModal').modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });

    $('#showLisDepModal').on('shown.bs.modal', function (e) {
      var modal = $(this)
      modal.find('.modal-title').text(nomplan)
    })
  }

  function carga_dependencia(idplan){
    $.ajax({
      url: "../../controller/ctrlTarifa.php",
      type: "POST",
      data: {
        accion: 'GET_SHOW_DEPPORIDPLAN', id_plan: idplan
      },
      success: function (registro) {
        $("#datos-lis-dep").html(registro);
      }
    });
  }

  function save_form_dep() {
    $('#btnValidFormDep').prop("disabled", true);
    var msg = "";
    var sw = true;

    var idDep = $('#txtIdDep').val();

    if(idDep === null){ msg+= "Seleccione una Depedencia<br/>"; sw = false;}

    if (sw == false) {
      bootbox.alert(msg);
      $('#btnValidFormDep').prop("disabled", false);
      return false;
    }
	//alert(idDep);
    bootbox.confirm({
      message: "Se registrará la(s) Depedencia(s) seleccionada(s), ¿Está seguro de continuar?",
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
          form_data.append('accion', 'POST_ADD_REGDEPPORPLANATARIFARIO');
          form_data.append('txtTipIng', 'AD');
          form_data.append('id_plan_dep', $("#txt_id_plan_dep").val());
          form_data.append('id_plan', $("#txt_id_plan").val());
          form_data.append('id_dependencia', idDep.join());
                    form_data.append('rand', myRand);
          $.ajax( {
            url: '../../controller/ctrlTarifa.php',
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
                $("#showDepModal").modal('hide');
                $("#tblAtencion").dataTable().fnDraw();
                carga_dependencia($("#txt_id_plan").val());
                //bootbox.alert("Registro ingresado correctamente.");
              } else {
                bootbox.alert(msg);
				$('#btnValidFormDep').prop("disabled", false);
                return false;
              }
              $('#btnValidFormDep').prop("disabled", false);
            }
          });
        } else {
          $('#btnValidFormDep').prop("disabled", false);
        }
      }
    });
  }

  function cambio_estado_dep(id, estado) {
    bootbox.confirm({
      message: "Se quitará la dependencia seleccionada, ¿Está seguro de continuar?",
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
          form_data.append('accion', 'POST_ADD_REGDEPPORPLANATARIFARIO');
          form_data.append('txtTipIng', 'ED');
          form_data.append('txt_id_plan_dep', id);
          form_data.append('rand', myRand);
          $.ajax( {
            url: '../../controller/ctrlTarifa.php',
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
                carga_dependencia($("#txt_id_plan").val());
                //bootbox.alert("Registro ingresado correctamente.");
              } else {
                bootbox.alert(msg);
                return false;
              }
              $('#btnValidFormDep').prop("disabled", false);
            }
          });
        } else {
          $('#btnValidFormDep').prop("disabled", false);
        }
      }
    });
  }
  
  
  /**********************************************************************************************************************/
  ////////////////////////////////////////////// Mantenimiento ///////////////////////////////////////////////
  /**********************************************************************************************************************/


  function edit_registro(idTarifa) {
    $.ajax({
      url: "../../controller/ctrlTarifa.php",
      type: "POST",
      dataType: 'json',
      data: {
        accion: 'GET_SHOW_DETPLANTARIFA', id_plantarifa: idTarifa
      },
      success: function (registro) {
        var datos = eval(registro);
        $('#show-new').show();
        $('#titleAcc').text('Editar Plan');
        document.frmPlan.txt_id_plan.value = datos[0];
        document.frmPlan.txt_abrev_plan.value =  datos[1];
        document.frmPlan.txt_sigla_plan.value =  datos[3];
        document.frmPlan.txt_nom_plan.value = datos[2];
		if(datos[5] == 'SI'){
			$("#chk_check_precio").prop("checked", true);
		} else {
			$("#chk_check_precio").prop("checked", false);
		}

        document.frmPlan.txt_abrev_plan.focus();
      }
    });
  }

  function nuevo_registro(){
    $('#show-new').hide();
    $('#titleAcc').text('Nuevo Plan');
	document.frmPlan.txt_id_plan.value = 0;
	document.frmPlan.txt_abrev_plan.value = '';
	document.frmPlan.txt_sigla_plan.value = '';
	document.frmPlan.txt_nom_plan.value = '';
	$("#chk_check_precio").prop("checked", false);
    document.frmPlan.txt_abrev_plan.focus();
  }

  function save_form() {
    $('#btnValidForm').prop("disabled", true);
    var msg = "";
    var sw = true;

    var id_plan = $('#txt_id_plan').val();
    var abrev_plan = $('#txt_abrev_plan').val();
    var sigla_plan = $('#txt_sigla_plan').val();
    var nom_plan = $('#txt_nom_plan').val();

    if(abrev_plan == ""){ msg+= "Ingrese la ABREVIATURA del plan tarifario<br/>"; sw = false;}
    if(sigla_plan == ""){ msg+= "Ingrese LA SIGLA del plan tarifario<br/>"; sw = false;}
	if(nom_plan == ""){ msg+= "Ingrese el NOMBRE del plan tarifario<br/>"; sw = false;}

    if (sw == false) {
      bootbox.alert(msg);
      $('#btnValidForm').prop("disabled", false);
      return false;
    }
	
	var check_precio = 0;
	if ($("input[name='chk_check_precio']").is(':checked')) {
	  check_precio = 1;
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
          var myRand = parseInt(Math.random() * 999999999999999);
          var form_data = new FormData();
          form_data.append('accion', 'POST_ADD_REGPLANTARIFARIO');
          form_data.append('id_plan', document.frmPlan.txt_id_plan.value);
          form_data.append('abrev_plan', document.frmPlan.txt_abrev_plan.value);
          form_data.append('sigla_plan', document.frmPlan.txt_sigla_plan.value);
          form_data.append('nom_plan', document.frmPlan.txt_nom_plan.value);
          form_data.append('check_precio', check_precio);
          form_data.append('rand', myRand);
          $.ajax( {
            url: '../../controller/ctrlTarifa.php',
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
                nuevo_registro();
              } else {
				showMessage(msg, "error");

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

  function back() {
    window.location = '../pages/';
  }

  $(document).ready(function () {
    $("#txtIdUnidMed").select2();
    //$("#txtIdDep").select2();
    $("#txtIdProducto").select2();
    $("#fixTable").tableHeadFixer();
	$("#fixTable1").tableHeadFixer();
	$("#fixTableDep").tableHeadFixer();

    var dTable = $('#tblAtencion').DataTable({
      "lengthMenu": [[15, 25, 50, 100 ,250], [15, 25, 50, 100 ,250]],
      "bLengthChange": true, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": true,
      "sAjaxSource": "tbl_plantarifario.php", // Load Data
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
        aoData.push({"name": "idEstado", "value": $("#txtBusIdEstado").val()});
      },
      "columnDefs": [
        {"orderable": false, "targets": 0, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 1, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 2, "searchable": true, "class": "small"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"}
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
	$('#txtIdDep').multiselect(multiselect_options);
  });
  </script>
  <?php require_once '../include/masterfooter.php'; ?>

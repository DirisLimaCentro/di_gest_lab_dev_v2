<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php

require_once '../../model/PerfilLab.php';
$pe = new PerfilLab();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>MANTENIMIENTO DE PRODUCTO POR PERFIL</strong></h3>
    </div>
    <div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"><strong>LISTA DE PRODUCTOS</strong></h3>
					</div>
					<div class="box-body">
						<div class="row">
						  <div class="col-sm-12">
							<label for="txtBusComp"><small>Digite nombre de producto:</small></label>
							<input class="form-control input-sm text-uppercase" type="text" name="txtBusComp" id="txtBusComp" autocomplete="OFF" maxlength="50" required="" tabindex="0" oninput="buscar_componente()"/>
						  </div>
						</div>
						<br/>
						<table id="tblAtencion" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><small>NOMBRE PRODUCTO</small></th>
									<th><small>AGREGAR</small></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					 </div>
				 </div>
			</div>
			<div class="col-sm-6">
				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title"><strong>PRODUCTO POR PERFIL</strong></h3>
					</div>
					<div class="box-body">
						<div class="row">
						  <div class="form-group col-sm-6">
							<label for="cbx_id_perfil"><small>Seleccione Perfil:</small></label>
							<select class="form-control input-sm" name="cbx_id_perfil" id="cbx_id_perfil" onchange="muestra_comp_agregado()">
								<option value="">-- Seleccione --</option>
								<?php
									$rsPe = $pe->get_listaPerfilLab();
									foreach ($rsPe as $row) {
										echo "<option value='" . $row['id'] . "'>" . $row['nombre_perfil'] . "</option>";
									}
								?>
							</select>
						  </div>
						  <div class="form-group col-sm-6">
							<br/>
							<button id="btnRegistrar" class="btn btn-success btn-sm" type="button" onclick="open_modal();"><i class="glyphicon glyphicon-plus"></i> Nuevo Perfil</button>
						  </div>
						</div>
						<br/>
					  <table class="table table-bordered table-hover">
						<thead>
						  <tr>
							<th><small>PERFIL</small></th>
							<th><small>NOMBRE PRODUCTO</small></th>
							<th><small>ELIMINAR</small></th>
						  </tr>
						</thead>
						<tbody id="datos_componente_perfil">
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					  </table>
					 </div>
				 </div>
			</div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="showPerfilModal" tabindex="-1" role="dialog" aria-labelledby="showPerfilLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showGrupoAreaModalLabel"></h4>
        </div>
        <div class="modal-body">
			<form name="frmPerfil">
				<div class="row">
				  <input type="hidden" name="txt_id" id="txt_id" value=""/>
				  <div class="form-group col-sm-12 col-md-7">
					<label for="txt_nombre_perfil">Nombre Perfil</label>
					<input type="text" name="txt_nombre_perfil" id="txt_nombre_perfil" class="form-control input-sm text-uppercase" maxlength="100"/>
				  </div>
				  <div class="form-group col-sm-12 col-md-5">
					<label for="txt_abrev_perfil">Abrev. Perfil</label>
					<input type="text" name="txt_abrev_perfil" id="txt_abrev_perfil" class="form-control input-sm text-uppercase" maxlength="25"/>
				  </div>
				</div>
			</form>
        </div>
        <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="button" id="btnValidForm" class="btn btn-primary" onclick="saveData()">Guardar</button>
			</div>
        </div>
      </div>
    </div>


      <?php require_once '../include/footer.php'; ?>
      <script Language="JavaScript">

    function buscar_componente() {
		$("#tblAtencion").dataTable().fnDraw()
    }

	function open_modal(){
		document.frmPerfil.txt_id.value = '0';

		$('#showPerfilModal').modal({
		  show: true,
		  backdrop: 'static',
		  focus: true,
		});

		$('#showPerfilModal').on('shown.bs.modal', function (e) {
		  var modal = $(this)
		  modal.find('.modal-title').text('Nuevo Perfil')
		})
	}
     
	function muestra_comp_agregado(){
		var id_perfil = $("#cbx_id_perfil").val();
		$.ajax({
		  url: "../../controller/ctrlPerfilLab.php",
		  type: "POST",
		  data: {
			accion: 'GET_SHOW_COMPONENTEXPERFIL', id_perfil: id_perfil
		  },
		  success: function (registro) {
			$("#datos_componente_perfil").html(registro);
		  }
		});
	}

      function add_componente(idcompdet) {
		var msg = "";
        var sw = true;
        if($('#cbx_id_perfil').val() == ''){
          msg+= "Seleccione un perfil.<br/>";
          sw = false;
        }

        if (sw == false) {
		  showMessage(msg, "error");
          return sw;
        }

        bootbox.confirm({
          message: "Se aregará el componente al perfil. ¿Está seguro de continuar?",
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
				  url: "../../controller/ctrlPerfilLab.php",
				  type: "POST",
				  data: {
					accion: 'POST_ADD_REGCOMPPERFIL', idcompdet: idcompdet, id_perfil: $("#cbx_id_perfil").val()
				  },
				  success: function (result) {
					var tmsg = result.substring(0, 2);
					var lmsg = result.length;
					var msg = result.substring(3, lmsg);
					if(tmsg == "OK"){
						showMessage("Componente agregado correctamente", "success");
						muestra_comp_agregado();
					} else {
						showMessage(msg, "error");
					}
					
				  }
				});
			}
		  }
		});
      }
	  
      function delete_componente(idcompdetperfil) {

        bootbox.confirm({
          message: "Se eliminará el componente del perfil seleccionado. ¿Está seguro de continuar?",
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
				  url: "../../controller/ctrlPerfilLab.php",
				  type: "POST",
				  data: {
					accion: 'POST_DELETE_REGCOMPPERFIL', idcompdetperfil: idcompdetperfil
				  },
				  success: function (result) {
					var tmsg = result.substring(0, 2);
					var lmsg = result.length;
					var msg = result.substring(3, lmsg);
					if(tmsg == "OK"){
						showMessage("Componente eliminado correctamente", "success");
						muestra_comp_agregado();
					} else {
						showMessage(msg, "error");
					}
					
				  }
				});
			}
		  }
		});
      }
	  

      function saveData() {
        var msg = "";
        var sw = true;
		$('#btnValidForm').prop("disabled", true);

		var id = $('#txt_id').val();
        var nombre_perfil = $('#txt_nombre_perfil').val();
		var abrev_perfil = $('#txt_abrev_perfil').val().trim();

        if(nombre_perfil.length <= 2){
          msg+= "Ingrese nombre del perfil.<br/>";
          sw = false;
        }
        /*if(abrev_perfil == ""){
          msg+= "Ingrese abreviatura del perfil.";
          sw = false;
        }*/

        if (sw == false) {
		  showMessage(msg, "error");
          $('#btnValidForm').prop("disabled", false);
          return sw;
        }
		
        bootbox.confirm({
          message: "Se registrará el Perfil. ¿Está seguro de continuar?",
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
					url: "../../controller/ctrlPerfilLab.php",
					//dataType: "json",
					type: "post",
					data: {
						accion: 'POST_ADD_REGPERFIL',
						id: id,
						nombre_perfil: nombre_perfil, 
						abrev_perfil: abrev_perfil
					},
					processData: true,
					success: function (result) {
						var tmsg = result.substring(0, 2);
						var lmsg = result.length;
						var msg = result.substring(3, lmsg);
						if(tmsg == "OK"){
							window.location = './main_principalcompxperfil.php';
						} else {
							showMessage(msg, "error");
							$('#btnValidForm').prop("disabled", false);
						}
					},
					timeout: 12000, // sets timeout to 12 seconds
					error: function (request, status, err) {
						if (status == "timeout") {
							showMessage("Su petición demoro mas de lo permitido", "error");
						} else {
							showMessage("ocurrio un error en su petición.", "error");
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

      $(document).ready(function () {
		var dTable = $('#tblAtencion').DataTable({
		  /*"language": {
		  "url": "../plugins/datatables/Spanish.json"
		},*/
		"pageLength": 25,
		"bLengthChange": true, //Paginado 10,20,50 o 100
		"bProcessing": true,
		"bServerSide": true,
		"bJQueryUI": false,
		"responsive": true,
		"bInfo": true,
		"bFilter": false,
		"sAjaxSource": "tbl_principalproductoxperfil.php", // Load Data
		"language": {
		  //"url": "../plugins/datatables/Spanish.json",
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
		  aoData.push({"name": "nombre", "value": $("#txtBusComp").val()});

		},
		/*"fnServerParams": function ( aoData ) {
		aoData.push( { "name": "id_tabla", "value": $('#cboiddep').val() } );
		},*/

		"columnDefs": [
		{"orderable": true, "targets": 0, "searchable": false, "class": "small font-weit"},
		{"orderable": false, "targets": 1, "searchable": false, "class": "small text-center"}
		]
		});

		$('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');
	});
</script>
<?php require_once '../include/masterfooter.php'; ?>

<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';

require_once '../../model/Lab.php';
$lab = new Lab();
?>
<style>
.label-success {
    background-color: #5cb85c !important;
}
.label-warning {
    background-color: #f0ad4e !important;
}
.label-danger {
    background-color: #d9534f !important;
}
</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
		<h3 class="panel-title"><strong>REGISTRO DE RESULTADO - TPHA<strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmPrincipal" id="frmPrincipal" method="POST">
        <input type="hidden" name="id_producto_detalle" id="id_producto_detalle" value=""/>
      </form>
     
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a class="" href="#activity" data-toggle="tab" aria-expanded="true"><b>Sin resultado</b></a></li>
			  <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false"><b><span  class="text-green" >Con resultado</span></b></a></li>
            </ul>
            <div class="tab-content">
				 <div id="activity" class="tab-pane active">
					<p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <span style="color: #449d44;"><i class="glyphicon glyphicon-ok"></i></span>=Registrar resultado</p>
					<table id="tblAceptable" class="display" cellspacing="0" width="100%">
					  <thead class="bg-aqua">
						<tr>
						  <th>N° Doc.</th>
						  <th>Nombre del paciente</th>
						  <th>HC</th>
						  <th>Edad</th>
						  <th>Códico<br/>Atención</th>
						  <th><i class="fa fa-cogs"></i></th>
						</tr>
					  </thead>
					  <tbody>
					  </tbody>
					</table>
				  </div>
				  <div id="timeline" class="tab-pane">
					<p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <input type="checkbox" checked="">=Incluir en validados | <input type="checkbox">=No incluir en validados
					<table id="example" class="display" cellspacing="0" width="100%">
					  <thead class="bg-aqua">
						<tr>
						  <th></th>
						  <th>N° Doc.</th>
						  <th>Nombre del paciente</th>
						  <th>Resultado</th>
						  <th>HC</th>
						  <th>Edad</th>
						  <th>Códico<br/>Atención</th>
						  <th><i class="fa fa-cogs"></i></th>
						</tr>
					  </thead>
					  <tbody>
					  </tbody>
					</table>
					<pre id="example-console-rows" style="display: none;"></pre>
					<button type="button" class="btn btn-success btn-lg" id="btnOpenForm3" onclick="openForm('3')"><i class="glyphicon glyphicon-thumbs-up"></i> Validar resultados </button>
				  </div>
              </div>
            </div>
      </div>
    </div>
  </div>
  
  <!-- Modal donde se ingresa el motivo del rechazo-->
  <div class="modal fade" id="showIngResulModal" role="dialog" aria-labelledby="showIngResulModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showIngResulModalLabel"></h4>
        </div>
        <div class="modal-body">
          <form name="frm_crud_resultado" id="frm_crud_resultado" class="form-horizontal">
		  <input type="hidden" id="txt_id_atencion" name="txt_id_atencion" value=""/>
		  <input type="hidden" id="txt_opcion" name="txt_opcion" value=""/>
            <div class="form-group">
                <div class="col-sm-4">
                  <label for="txt_codigo_ref_lab">Código:</label>
                  <input type="text" class="form-control" name="txt_codigo_ref_lab" id="txt_codigo_ref_lab" maxlength="9" value=""/>
                </div>
				<div class="col-sm-4">
                  <label for="txt_fecha_resultado"><i class="fa fa-calendar" id="datepicker"></i> Fecha resul.:</label>
				  <input type="text" name="txt_fecha_resultado" placeholder="DD/MM/AAAA" id="txt_fecha_resultado" autofocus="" class="form-control" maxlength="10" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value=""/>
                </div>
                <div class="col-sm-4">
                  <label for="txt_det_resultado">Resultado:</label>
                  <input type="text" class="form-control" name="txt_det_resultado" id="txt_det_resultado" value=""/>
                </div>
                <div class="col-sm-12">
                  <label for="txt_obs_det_resultado">Observación:</label>
                  <textarea class="form-control" name="txt_obs_det_resultado" id="txt_obs_det_resultado" rows="3"></textarea>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-success btn-continuar" id="btnValidForm" onclick="save_form_resultado()"><i class="fa fa-save"></i> Guardar y validar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


    <?php require_once '../include/footer.php'; ?>
    <script Language="JavaScript">

	function openFormIngResul(id_atencion, dni) {
		window.location = './main_tpharesultadoform.php?nroSoli='+id_atencion;
    }
	
	function save_form_resultado() {
	  $('#btnValidForm').prop("disabled", true);
      var msg = "";
      msg = "Se guardará y <b class='text-success'>VALIDARÁ</b> los datos ingresados, ¿Está seguro de continuar?";
	  
	  if($('#txt_opcion').val() == "R"){
		  accion = 'POST_ADD_RESULPSA';
	  } else {
		accion = 'POST_ADD_VALIDRESULPSAUNICO';
	  }

      bootbox.confirm({
        message: msg,
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
            var txtIdEnv = "";
            $.ajax( {
              type: 'POST',
              url: '../../controller/ctrlLab.php',
              data: {
                accion: accion, id_atencion: $('#txt_id_atencion').val(), codigo_ref_lab: $('#txt_codigo_ref_lab').val(), fecha_resultado: $('#txt_fecha_resultado').val(), det_resultado: $('#txt_det_resultado').val(), obs_det_resultado: $('#txt_obs_det_resultado').val(),
                rand: myRand,
              },
              success: function(data) {
                var tmsg = data.substring(0, 2);
                var lmsg = data.length;
                var msg = data.substring(3, lmsg);
                //console.log(tmsg);
                if(tmsg == "OK"){
                  /*bootbox.alert({
                    message: "Se ejecutó correctamente la información solicitada",
                    callback: function () {*/
                      location.reload();
                    /*}
                  });*/
                } else {
                  bootbox.alert(msg);
				  $('#btnValidForm').prop("disabled", false);
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

	function openFormIngResulValid(id_atencion, dni, codref, resul) {
		$('#txt_opcion').val('VR');
		$('#txt_id_atencion').val(id_atencion);
		$('#showIngResulModalLabel').text(dni);
        $('#txt_codigo_ref_lab').val(codref);
		$('#txt_det_resultado').val(resul);
		$('#txt_fecha_resultado').val('');
		$('#txt_codigo_ref_lab').prop("disabled", true);
		$('#txt_det_resultado').prop("disabled", true);
		$('#txt_fecha_resultado').prop("disabled", true);
		$('#txt_obs_det_resultado').val('');
        $('#showIngResulModal').modal({
            show: true,
            backdrop: 'static',
			focus: true,
        });
    }


	function activa_validar(opt) {
		$('#BtnProcesar' + opt).prop("disabled", false);
	}
	
	function procesar_archivo(opt) {
		$('#BtnProcesar' + opt).prop("disabled", true);
		
		var file_data = $('#sortpicture'+opt).prop('files')[0];
		var accion = "PROCESAR_TRAMA_"+opt;
		
		if (!file_data) {
			$('#BtnProcesar' + opt).prop("disabled", false);
			showMessage("Por favor adjunte el archivo", "error");
			return false;
		}
		
		var form_data = new FormData();
		form_data.append('file', file_data);
		form_data.append('accion', 'CARGA_ARCHIVO_RESUL_PSA');
		$.ajax({
			url: '../../controller/ctrlLab.php', 
			dataType: 'text', 
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'post',
			async: false,
			success: function (data) {
                var tmsg = data.substring(0, 2);
                var lmsg = data.length;
                var msg = data.substring(3, lmsg);
                //console.log(tmsg);
                if(tmsg == "OK"){
					showMessage("Archivo cargado correctamente", "success");
					window.location = './main_psaregresultado.php';
                } else {
                  showMessage(msg,"error");
                  return false;
                }
			},
			timeout: 180000, // sets timeout to un minuto dos minutos
			error: function (request, status, err) {
				$("#loaderModal").hide();
				if (status == "timeout") {
					showMessage("Su petición demoro mas de lo permitido", "error");
				} else {
					// another error occured
					showMessage("ocurrio un error en su petición.", "error");
				}
			}
		});
	}
	
	/****************************************************************************************************************/

    function exportar_datos() {
      window.location = './xls_repregrecepcion.php?idEnv=' + $("#txtIdEnv").val();
    }

    function back() {
      window.location = './main_principalsolirecep.php';
    }

    function openForm(opt) {
      $('#btnOpenForm' + opt).prop("disabled", true);
      var msg = "";
      var sw = true;

      var table = $('#example').DataTable();;
      var rows_selected = table.column(0).checkboxes.selected();

      // Output form data to a console
      $('#example-console-rows').text(rows_selected.join(","));

      var idpac = $('#txtIdPac').val();

      if(rows_selected.join(",") == ""){
        msg+= "Seleccione al menos una muestra<br/>";
        sw = false;
      }

		if (sw == false) {
			bootbox.alert(msg);
			$('#btnOpenForm' + opt).prop("disabled", false);
			return sw;
		} else {
		  save_form('3');
		}
	}

    function validForm() {
      $('#btnValidForm').prop("disabled", true);
      var msg = "";
      var sw = true;

      var txtIdObsEstEnvDet = $('#txtIdObsEstEnvDet').val();
      var txtDetObsEstEnvDet = $('#txtDetObsEstEnvDet').val();
      var txtTipoOpe = $('#txtTipoOpe').val();
      if(txtTipoOpe == "2"){
        var txtIdEstEnvDet = $('#txtIdEstEnvDet').val();
        if(txtIdEstEnvDet == ""){
          msg+= "Seleccione una opción de RECHAZAR ó POR SUBSANAR<br/>";
          sw = false;
        }
      }


      if (sw == false) {
        bootbox.alert(msg);
        $('#btnValidForm').prop("disabled", false);
        return sw;
      } else {
        save_form('');
      }
      return false;
    }

    function save_form(opt) {
      var msg = "";
      msg = "Se <b class='text-success'>VALIDARÁ</b> los resultados de las muestras seleccionadas, ¿Está seguro de continuar?";

      bootbox.confirm({
        message: msg,
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
            var txtIdEnv = "";
            $.ajax( {
              type: 'POST',
              url: '../../controller/ctrlLab.php',
              data: {
                accion: 'POST_ADD_VALIDRESULPSA', txtIdEnvDet: $('#example-console-rows').text(),
                rand: myRand,
              },
              success: function(data) {
                var tmsg = data.substring(0, 2);
                var lmsg = data.length;
                var msg = data.substring(3, lmsg);
                //console.log(tmsg);
                if(tmsg == "OK"){
                  bootbox.alert({
                    message: "Se ejecutó correctamente la información solicitada",
                    callback: function () {
                      location.reload();
                    }
                  });
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
	
		$('#datepicker').on('changeDate', function() {
			$('#txt_fecha_resultado').val(
				$('#datepicker').datepicker('getFormattedDate')
			);
		});

    $(document).ready(function () {
      $("body").tooltip({ selector: '[data-toggle=tooltip]' });
  
	
	  $("#datepicker").datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true,
	  });

  
      var aTable = $('#tblAceptable').DataTable({
        "bLengthChange": true, //Paginado 10,20,50 o 100
        "bProcessing": true,
        "bServerSide": true,
        "bJQueryUI": false,
        "responsive": true,
        "bInfo": true,
        "bFilter": false,
        "sAjaxSource": "tbl_tpharegresultado.php", // Load Data
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
          aoData.push({"name": "id_estado", "value": "1"});

        },
        "columnDefs": [
          {"orderable": true, "targets": 0, "searchable": true, "class": "font-weit"},
          {"orderable": true, "targets": 1, "searchable": true, "class": "font-weit"},
          {"orderable": false, "targets": 2, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 3, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 4, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 5, "searchable": true, "class": "text-center"}
        ]
        //,"order": [[ 0, "desc" ]]
      });

      $('#tblAceptable').removeClass('display').addClass('table table-hover table-bordered');

      var table = $('#example').DataTable({
        "lengthMenu": [[20, 50, 100 ,250], [20, 50, 100 ,250, "All"]],
        "sAjaxSource": "tbl_psaregresultado.php", // Load Data
        "responsive": true,
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
          aoData.push({"name": "id_estado", "value": "2"});
        },
        initComplete: function () {
          /*table.columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
              that
              .search( this.value )
              .draw();
            } );
          } );*/
        },
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
          /*if (aData[7] >= 30){
            $('td', nRow).addClass('danger');
          }*/
        },
        'columnDefs': [
          {'targets': 0, 'checkboxes': {'selectRow': true}, "orderable": false, "class": "text-center"},
          {"orderable": false, "targets": 1, "searchable": true, "class": "font-weit"},
          {"orderable": false, "targets": 2, "searchable": true, "class": "font-weit"},
          {"orderable": false, "targets": 3, "searchable": true, "class": "font-weit text-right"},
          {"orderable": false, "targets": 4, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 5, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 6, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 7, "searchable": true, "class": "text-center"}
        ],
        'select': {
          'style': 'multi',
        },
        "order": [[ 1, "asc" ]]
      });
      $('#example').removeClass('display').addClass('table table-hover table-bordered');

    });
  </script>
  <?php require_once '../include/masterfooter.php'; ?>

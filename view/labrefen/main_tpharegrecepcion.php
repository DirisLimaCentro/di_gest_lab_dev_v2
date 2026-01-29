<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';

require_once '../../model/Lab.php';
$lab = new Lab();

$idEnvio = $_GET['envivo'];
$rsE = $lab->get_datosEnvio($idEnvio);
//print_r($rsE);
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
		<h3 class="panel-title"><strong>CLASIFICACION DE MUESTRAS DE EXAMEN SOLICITADO</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmPrincipal" id="frmPrincipal" method="POST">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value=""/>
        <input type="hidden" name="txtIdEnv" id="txtIdEnv" value="<?php echo trim($_GET['envivo']);?>"/>
        <input type="hidden" name="txtIdEnvDet" id="txtIdEnvDet" value=""/>
        <input type="hidden" name="txtTipoOpe" id="txtTipoOpe" value=""/>
      </form>
      <div class="row">
        <div class="col-sm-2">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center"><?php echo $rsE[0]['nro_envio'] . "-" . $rsE[0]['anio_envio'];?></h3>
              <p class="text-muted text-center"><?php echo $rsE[0]['dependencia_origen'];?></p>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Total muestras</b> <span id="txtCantEnv" class="pull-right badge bg-blue"><?php echo $rsE[0]['cnt_enviado'];?></span>
                </li>
                <li class="list-group-item">
                  <b>Adecuadas</b> <span id="txtCantAcep" class="pull-right badge bg-green"><?php echo $rsE[0]['cnt_soliaceptada'];?></span>
                </li>
                <li class="list-group-item">
                  <b>Rechazados</b> <span id="txtCantRec" class="pull-right badge bg-red"><?php echo $rsE[0]['cnt_solirechazada'];?></span>
                </li>
              </ul>
              <!--<button type="button" class="btn btn-success btn-block" onclick="exportar_datos()"><i class="fa fa-file-excel-o"></i> Exportar a xls</button>-->
              <button type="button" class="btn btn-default btn-block" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Regresar</button>
            </div>
          </div>
        </div>
        <div class="col-sm-10">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a class="" href="#activity" data-toggle="tab" aria-expanded="true"><b>Pendientes</b></a></li>
			  <?php if(!isset($_GET['id'])){?>
				  <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false"><b><span  class="text-red" >Rechazados (<?php echo $rsE[0]['cnt_solirechazada'];?>)</span></b></a></li>
				  <li class=""><a class="text-green" href="#settings" data-toggle="tab" aria-expanded="false"><b>Adecuadas (<?php echo $rsE[0]['cnt_soliaceptada'];?>)</b></a></li>
			  <?php }?>
            </ul>
            <div class="tab-content">
              <div id="activity" class="tab-pane active">
                <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <?php if(!isset($_GET['id'])){?><input type="checkbox" checked="">=Incluir en (Adecuada o rechazar) | <input type="checkbox">=No incluir en (Adecuada o rechazar) |<?php }?>
                <!--<p class="text-right" style="margin: 0 0 0px;"><b>Días transcurridos</b>: </span> <span class="label label-danger">Mayor de 30 días</span></p>-->
                <br/>
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead class="bg-aqua">
                    <tr>
                      <th></th>
					  <th>TIPO DOC.</th>
                      <th>N° DOC.</th>
                      <th>NOMBRE DEL PACIENTE</th>
					  <th>HC</th>
                      <th>EDAD</th>
                      <th>ATENCIÓN</th>
                      <th><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot class="bg-aqua">
                    <tr>
                      <th></th>
					  <th>TIPO DOC.</th>
                      <th>N° DOC.</th>
                      <th>NOMBRE DEL PACIENTE</th>
					  <th>HC</th>
                      <th>EDAD</th>
                      <th>ATENCIÓN</th>
                      <th><i class="fa fa-cogs"></i></th>
                    </tr>
                  </tfoot>
                </table>
                <pre id="example-console-rows" style="display: none;"></pre>
                <?php if(!isset($_GET['id'])){?>
                <div class="row">
                  <div class="col-sm-12 text-center">
                    <div class="btn-group">
                      <!--<button type="button" class="btn btn-danger btn-lg" id="btnOpenForm1" onclick="openForm('1')"><i class="glyphicon glyphicon-thumbs-down"></i> Rechazar Envío </button>-->
                      <button type="button" class="btn btn-danger btn-lg" id="btnOpenForm2" onclick="openForm('2')"><i class="glyphicon glyphicon-ban-circle"></i> Rechazar muestra </button>
                      <button type="button" class="btn btn-success btn-lg" id="btnOpenForm3" onclick="openForm('3')"><i class="glyphicon glyphicon-thumbs-up"></i> Aceptar muestra </button>
                    </div>
                  </div>
                </div>
                <?php }?>
              </div>
              <div id="timeline" class="tab-pane">
                <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <span><i class="glyphicon glyphicon-info-sign"></i></span>=Ver detalle de rechazo | <span style="color: #449d44;"><i class="glyphicon glyphicon-ok"></i></span>=Cambiar a ADECUADA</p>
                <table id="tblObservado" class="display" cellspacing="0" width="100%">
                  <thead class="bg-red">
                    <tr>
                      <th></th>
					  <th>TIPO DOC.</th>
                      <th>N° DOC.</th>
                      <th>NOMBRE DEL PACIENTE</th>
					  <th>HC</th>
                      <th>EDAD</th>
                      <th>ATENCIÓN</th>
                      <th><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <div id="settings" class="tab-pane">
                <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <a style="color: #00c0ef;"><i class="glyphicon glyphicon-eye-open"></i></a>=Ver ficha de atención</p>
                <table id="tblAceptable" class="table table-hover table-bordered" cellspacing="0" width="100%">
                  <thead class="bg-green">
                    <tr>
                      <th></th>
					  <th>TIPO DOC.</th>
                      <th>N° DOC.</th>
                      <th>NOMBRE DEL PACIENTE</th>
					  <th>HC</th>
                      <th>EDAD</th>
                      <th>ATENCIÓN</th>
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
      </div>
    </div>
  </div>
  
  <!-- Modal donde se ingresa el motivo del rechazo-->
  <div class="modal fade" id="showObsModal" role="dialog" aria-labelledby="showObsModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showObsModalLabel"></h4>
        </div>
        <div class="modal-body">
          <form name="frmObs" id="frmObs">
		  <input type="hidden" id="txtIdEstEnvDet" name="txtIdEstEnvDet" value="4"/>
		  <input type="hidden" id="txtIdObsEstEnvDet" name="txtIdObsEstEnvDet" value=""/>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  <label for="txtDetObsEstEnvDet">Detalle Motivo:</label>
                  <textarea class="form-control" name="txtDetObsEstEnvDet" id="txtDetObsEstEnvDet" rows="3"></textarea>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-warning btn-continuar" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Guardar </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal donde se muestra el detalle del rechazo-->
  <div class="modal fade" id="showDetObsModal" role="dialog" aria-labelledby="showDetObsModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showDetObsModalLabel">Detalle de la observación</h4>
        </div>
        <div class="modal-body">
          <div class="pad margin no-print">
            <div class="callout callout-info" style="margin-bottom: 0!important;">
              <h4 style="margin-bottom: 2px;"><span id="lblNomAccion">Rechazo<span></h4>
                <h4><small id="lblMotObs">Tipo de rechazo:</small></h4>
                <span id="lblDetObs">Este es el detalle de la observación.</span>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="row">
              <div class="col-md-12 text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Aceptar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="showSubModal" role="dialog" aria-labelledby="showSubModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="showSubModalLabel"></h4>
          </div>
          <div class="modal-body">
            <form name="frmSubsanar" id="frmSubsanar">
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12">
                    <label for="txtDetSubEstEnvDet">Comentario:</label>
                    <textarea class="form-control" name="txtDetSubEstEnvDet" id="txtDetSubEstEnvDet" rows="3"></textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="row">
              <div class="col-md-12 text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-success btn-continuar" id="btnValidFormSub" onclick="save_form_subsanar()"><i class="fa fa-save"></i> Cambiar a ADECUADA </button>
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


    function back() {
		window.location = './main_psarecepcion.php';
    }

	//Función que se ejecuta al dar click observar o aceptar muestra
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
        if(opt == '2'){
          $('#showPorModificar').show();
          $('#showObsModalLabel').text('Rechazar');
          $('#btnValidForm').addClass('btn-warning').removeClass('btn-danger');
          $('#btnValidForm').text('Rechazar');
          $('#btnOpenForm' + opt).prop("disabled", false);
          $("#txtIdObsEstEnvDet").val('');
          $('#txtDetObsEstEnvDet').val('');
          $('#showObsModal').modal({
            show: true,
            backdrop: 'static',
            focus: true,
          });
        } else {
          save_form('3');
        }
        $('#txtTipoOpe').val(opt);
      }
    }

	//Función donde carga el combo con los motivos de rechazo
    function get_listaobsdetenv(id_producto, opt) {//idproducto(60): PSA; opt(4):Rechazado
		$.ajax({
				url: "../../controller/ctrlLab.php",
				type: "GET",
				dataType: "json",
			data: {
				accion: 'GET_SHOW_LISTATIPORECHAZOENV', id_producto: id_producto, id_tiporechazo: opt
			},
			success: function (result) {
				var newOption = "";
				newOption = "<option value=''>--Seleccionar-</option>";
				$(result).each(function (ii, oo) {
					newOption += "<option value='" + oo.id + "'>" + oo.descrip_rechazo + "</option>";
				});
				$('#txtIdObsEstEnvDet').html(newOption);
			}
      });
    }

	//Función que se ejecuta al dar click Guardar observación o Aceptar muestra
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

      if(txtIdObsEstEnvDet == ""){
        msg+= "Seleccione tipo de observación<br/>";
        sw = false;
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
      if (opt == "3"){
        msg = "Se cambiará a estado <b class='text-success'>ADECUADA</b> la(s) muestra(s) seleccionada(s), ¿Está seguro de continuar?";
      } else {
        msg = "Se cambiará el estado a <b class='text-danger'>RECHAZADO</b> la(s) muestra(s) seleccionada(s), ¿Está seguro de continuar?";
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
            var txtIdEnv = "<?php echo $_GET['envivo']?>";
            $.ajax( {
              type: 'POST',
              url: '../../controller/ctrlLab.php',
              data: {
                accion: 'POST_ADD_REGENVIOOBSOACEPTARDET', txtTipoOpe: $('#txtTipoOpe').val(), id_envio: txtIdEnv , txtIdEnvDet: $('#example-console-rows').text(), txtIdEstEnvDet: document.frmObs.txtIdEstEnvDet.value, txtIdObsEstEnvDet: $('#txtIdObsEstEnvDet').val(), txtDetObsEstEnvDet: $('#txtDetObsEstEnvDet').val(),
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

	//Función que se ejecuta para ver el detalle del rechazo
    function open_detobs(id_envio, id_enviodet) {
      $.ajax({
        url: "../../controller/ctrlLab.php",
        type: "GET",
        dataType: 'json',
        data: {
          accion: 'GET_SHOW_DETALLERECHAZOMUESTRA', id_envio: id_envio, id_enviodet: id_enviodet
        },
        success: function (registro) {
          var datos = eval(registro);
          $('#lblNomAccion').text(datos[1]);
          $('#lblMotObs').text(datos[2]);
          $('#lblDetObs').text(datos[3]);
          $('#showDetObsModal').modal({
            show: true,
            backdrop: 'static',
            focus: true,
          });
        }
      });
    }

    function save_form_subsanar() {
      $('#btnValidFormSub').prop("disabled", true);
      var msgconfir = "";
      msgconfir = "Se cambiará a estado <b>ACEPTADO</b> las muestra seleccionada, ¿Está seguro de continuar?";
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
            var myRand = parseInt(Math.random() * 999999999999999);
            var txtIdEnv = document.frmPrincipal.txtIdEnv.value;
            var txtIdEnvDet = document.frmPrincipal.txtIdEnvDet.value;
            $.ajax( {
              type: 'POST',
              url: '../../controller/ctrlPAP.php',
              data: {
                accion: 'POST_ADD_REGENVIOOBSOACEPTARDET', txtTipoOpe: 'AO', txtIdEnv: txtIdEnv, txtIdEnvDet: txtIdEnvDet, txtIdEstEnvDet: '', txtIdObsEstEnvDet: '', txtDetObsEstEnvDet: document.frmSubsanar.txtDetSubEstEnvDet.value,
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
            $('#btnValidFormSub').prop("disabled", false);
          }
        }
      });
    }












/***********************************************************************************************************************************/
/***********************************************************************************************************************************/

    function get_listaMotivoNoConfor() {
      var idTipNoConfor = $('#txtIdTipNoConfor').val();
      if (idTipNoConfor == ""){
        $("#txtIdMotNoConfor").val('').trigger("change");
        $('#txtIdMotNoConfor').prop("disabled", true);
        return false;
      }
      $.ajax({
        url: "../../controller/ctrlPAP.php",
        type: "POST",
        dataType: "json",
        data: {
          accion: 'GET_SHOW_LISTAMOTIVONOCONFORPORIDTIPO', txtIdTipNoConfor: idTipNoConfor
        },
        success: function (result) {
          $('#txtIdMotNoConfor').prop("disabled", false);
          var newOption = "";
          newOption = "<option value=''>--Seleccionar-</option>";
          $(result).each(function (ii, oo) {
            newOption += "<option value='" + oo.id_motivonoconfor + "'>" + oo.nom_motivo + "</option>";
          });
          $('#txtIdMotNoConfor').html(newOption);
          $("#txtIdMotNoConfor").select2({max_selected_options: 4});
        }
      });
    }

    $('[name="txtIdEstEnvDet"]').change(function()
    {
      if ($(this).is(':checked')) {
        if ($(this).val() == "3") {
          get_listaobsdetenv($(this).val(), 'o');
        } else if ($(this).val() == "4") {
          get_listaobsdetenv($(this).val(), 'o');
        }
      }
    });

   

    function open_subsanar(idenvdet, nrolam) {
      document.frmPrincipal.txtIdEnvDet.value = idenvdet;
      $('#showSubModal').modal({
        show: true,
        backdrop: 'static',
        focus: true,
      });

      $('#showSubModal').on('shown.bs.modal', function (e) {
        var modal = $(this)
        modal.find('.modal-title').text('Cambiar a ADECUADA a la muestra del paciente: ' + nrolam)
        $("#txtDetSubEstEnvDet").trigger('focus');
      })
    }

    function open_rechazar(idenvdet, nrolam) {
      document.frmPrincipal.txtIdEnvDet.value = idenvdet;
      $('#showRecModal').modal({
        show: true,
        backdrop: 'static',
        focus: true,
      });

      $('#showRecModal').on('shown.bs.modal', function (e) {
        var modal = $(this)
        modal.find('.modal-title').text('Rechazar lámina ' + nrolam);
        get_listaobsdetenv('4','r');
      })
    }

    function save_form_rechazar() {
      $('#btnValidFormRec').prop("disabled", true);

      var idmotobs = document.frmRechazar.txtIdObsRecEstEnvDet.value;
      if(idmotobs == ""){
        bootbox.alert("Seleccione un motivo de rechazo...");
        $('#btnValidFormRec').prop("disabled", false);
        return false;
      }

      var msgconfir = "";
      msgconfir = "Se cambiará el estado a <b>RECHAZADO</b> el envío, ¿Está seguro de continuar?";
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
            var myRand = parseInt(Math.random() * 999999999999999);
            var txtIdEnv = document.frmPrincipal.txtIdEnv.value;
            var txtIdEnvDet = document.frmPrincipal.txtIdEnvDet.value;
            $.ajax( {
              type: 'POST',
              url: '../../controller/ctrlPAP.php',
              data: {
                accion: 'POST_ADD_REGENVIOOBSOACEPTARDET', txtTipoOpe: 'RO', txtIdEnv: txtIdEnv, txtIdEnvDet: txtIdEnvDet, txtIdEstEnvDet: '4', txtIdObsEstEnvDet: document.frmRechazar.txtIdObsRecEstEnvDet.value, txtDetObsEstEnvDet: document.frmRechazar.txtDetRecEstEnvDet.value,
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
            $('#btnValidFormRec').prop("disabled", false);
          }
        }
      });
    }

    $(document).ready(function () {		
      if(($('#txtCantMod').text() != "0") || ($('#txtCantRec').text() != "0") || ($('#txtCantAcep').text() != "0")){
        $('#btnOpenForm1').prop("disabled", true);
      }

      $("body").tooltip({ selector: '[data-toggle=tooltip]' });

      var table = $('#example').DataTable({
        "lengthMenu": [[20, 50, 100 ,250], [20, 50, 100 ,250, "All"]],
        "sAjaxSource": "tbl_regrecepcion.php", // Load Data
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
          aoData.push({"name": "id_envio", "value": "<?php echo $_GET['envivo']?>"});
          aoData.push({"name": "id_estado", "value": "1"});
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
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
          if (aData[7] >= 30){
            $('td', nRow).addClass('danger');
          }
        },
        'columnDefs': [
          {'targets': 0, 'checkboxes': {'selectRow': true}, "orderable": false, "class": "text-center"},
          {"orderable": false, "targets": 1, "searchable": true, "class": "font-weit"},
          {"orderable": false, "targets": 2, "searchable": true, "class": "font-weit"},
          {"orderable": false, "targets": 3, "searchable": true, "class": "font-weit"},
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

      var oTable = $('#tblObservado').DataTable({
        "bLengthChange": true, //Paginado 10,20,50 o 100
        "bProcessing": true,
        "bServerSide": true,
        "bJQueryUI": false,
        "responsive": true,
        "bInfo": true,
        "bFilter": false,
        "sAjaxSource": "tbl_regrecepcion.php", // Load Data
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
          aoData.push({"name": "id_envio", "value": "<?php echo $_GET['envivo']?>"});
          aoData.push({"name": "id_estado", "value": "4"});

        },
        "columnDefs": [
          {"orderable": true, "targets": 0, "searchable": true, "class": "font-weit"},
          {"orderable": false, "targets": 1, "searchable": true, "class": "font-weit"},
          {"orderable": false, "targets": 2, "searchable": true, "class": "font-weit"},
          {"orderable": false, "targets": 3, "searchable": true, "class": "font-weit"},
          {"orderable": false, "targets": 4, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 5, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 6, "searchable": true, "class": "text-center"},
		  {"orderable": false, "targets": 7, "searchable": true, "class": "text-center"}
        ]
        ,"order": [[ 0, "asc" ]]
      });

      $('#tblObservado').removeClass('display').addClass('table table-hover table-bordered');

      var aTable = $('#tblAceptable').DataTable({
        "bLengthChange": true, //Paginado 10,20,50 o 100
        "bProcessing": true,
        "bServerSide": true,
        "bJQueryUI": false,
        "responsive": true,
        "bInfo": true,
        "bFilter": false,
        "sAjaxSource": "tbl_regrecepcion.php", // Load Data
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
          aoData.push({"name": "id_envio", "value": "<?php echo $_GET['envivo']?>"});
          aoData.push({"name": "id_estado", "value": "2"});

        },
        "columnDefs": [
          {orderable: false, targets: 0, searchable: true, class: "font-weit", width: "5%"},
          {orderable: false, targets: 1, searchable: true, class: "font-weit", width: "10%"},
          {orderable: false, targets: 2, searchable: true, class: "font-weit", width: "15%"},
          {orderable: false, targets: 3, searchable: true, class: "font-weit", width: "30%"},
          {orderable: false, targets: 4, searchable: true, class: "text-center", width: "10%"},
          {orderable: false, targets: 5, searchable: true, class: "text-center", width: "10%"},
          {orderable: false, targets: 6, searchable: true, class: "text-center", width: "10%"},
		  {orderable: false, targets: 7, searchable: true, class: "text-center", width: "10%"}
        ]
        //,"order": [[ 0, "desc" ]]
      });
    });
  </script>
  <?php require_once '../include/masterfooter.php'; ?>

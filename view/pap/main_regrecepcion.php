<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';

require_once '../../model/Pap.php';
$pap = new Pap();

$idEnvio = $_GET['envivo'];
$rsE = $pap->get_datosEnvio($idEnvio);
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
.btn-spacing {
	margin-top: 10px;
}
</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <?php if(!isset($_GET['id'])){?>
		<h3 class="panel-title"><strong>Clasificación de muestras por envío</strong></h3>
      <?php } else { ?>
		<h3 class="panel-title"><strong>Recepción de Envío de muestras</strong></h3>
	  <?php }?>
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
              <h3 class="profile-username text-center"><?php echo $rsE[0]['nro_papenv'] . "-" . $rsE[0]['anio_papenv'];?></h3>
              <p class="text-muted text-center"><?php echo $rsE[0]['nom_depen'];?></p>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Total muestras</b> <span id="txtCantEnv" class="pull-right badge bg-blue"><?php echo $rsE[0]['cnt_solienvtot'];?></span>
                </li>
                <li class="list-group-item">
                  <b>Adecuadas</b> <span id="txtCantAcep" class="pull-right badge bg-green"><?php echo $rsE[0]['cnt_soliaceptada'];?></span>
                </li>
                <li class="list-group-item">
                  <b>Por subsanar</b> <span id="txtCantMod" class="pull-right badge bg-yellow"><?php echo $rsE[0]['cnt_solipormodif'];?></span>
                </li>
                <li class="list-group-item">
                  <b>Rechazados</b> <span id="txtCantRec" class="pull-right badge bg-red"><?php echo $rsE[0]['cnt_solirechazada'];?></span>
                </li>
              </ul>
              <button type="button" class="btn btn-warning btn-block" onclick="exportar_datos()"><i class="fa fa-file-excel-o"></i> &nbsp; Exportar a XLS</button>
			  <?php if(isset($_GET['id'])){?>
				<button type="button" id="btnClasificar" class="btn btn-success btn-block btn-spacing" onclick="reg_proceso('<?php echo $_GET['envivo']?>')"><i class="glyphicon glyphicon-ok"></i> &nbsp;Ir a clasificar envío</button>
				<button type="button" id="btnRBRecibidos" class="btn btn-primary btn-block btn-spacing" onclick="regresar_envio('<?php echo $_GET['envivo']?>')"><i class="fa fa-hand-o-up"></i> &nbsp;Volver envío a<br/> bandeja de recepción</button>
			  <?php }?>
              <button type="button" class="btn btn-default btn-block btn-spacing" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> &nbsp; Regresar a bandejas</button>
            </div>
          </div>
        </div>
        <div class="col-sm-10">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a class="" href="#activity" data-toggle="tab" aria-expanded="true"><b>Pendientes</b></a></li><?php if(!isset($_GET['id'])){?>
              <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false"><b><span  class="text-red" >Rechazados (<?php echo $rsE[0]['cnt_solirechazada'];?>)</span> - <span  class="text-yellow">Por subsanar (<?php echo $rsE[0]['cnt_solipormodif'];?>)</span></b></a></li>
              <li class=""><a class="text-green" href="#settings" data-toggle="tab" aria-expanded="false"><b>Adecuadas (<?php echo $rsE[0]['cnt_soliaceptada'];?>)</b></a></li>
              <li class=""><a class="" href="#noconfor" data-toggle="tab" aria-expanded="false"><b>No conformidad (<span id="lblNoConfor">0</span>)</b></a></li><?php }?>
            </ul>
            <div class="tab-content">
              <div id="activity" class="tab-pane active">
                <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <?php if(!isset($_GET['id'])){?><input type="checkbox" checked="">=Incluir en (Rechazar/Por Subsanar o Aceptar) | <input type="checkbox">=No incluir en (Rechazar/Por Subsanar o Aceptar) |<?php }?> <a style="color: #00c0ef;"><i class="glyphicon glyphicon-eye-open"></i></a>=Ver ficha de atención</p>
                <p class="text-right" style="margin: 0 0 0px;"><b>Días transcurridos</b>: </span> <span class="label label-danger">Mayor de 30 días</span></p>
                <br/>
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead class="bg-aqua">
                    <tr>
                      <th></th>
                      <th>N° Lámina<br/>Lab.</th>
                      <th>N° Lámina<br/>EESS</th>
                      <th>Abrev.<br/>Paciente</th>
                      <th>Nombre del paciente</th>
                      <th>N° Doc.</th>
                      <th>Fecha<br/>Registro</th>
                      <th>Dias<br/>Transcurridos</th>
                      <th><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot class="bg-aqua">
                    <tr>
                      <th></th>
                      <th>N° Lámina<br/>Lab.</th>
                      <th>N° Lámina<br/>EESS</th>
                      <th>Abrev.<br/>Paciente</th>
                      <th>Nombre del paciente</th>
                      <th>N° Doc.</th>
                      <th>Fecha<br/>Registro</th>
                      <th>Dias<br/>Transcurridos</th>
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
                      <button type="button" class="btn btn-warning btn-lg" id="btnOpenForm2" onclick="openForm('2')"><i class="glyphicon glyphicon-ban-circle"></i> Rechazar/ Por subsanar muestra(s) </button>
                      <button type="button" class="btn btn-success btn-lg" id="btnOpenForm3" onclick="openForm('3')"><i class="glyphicon glyphicon-thumbs-up"></i> Aceptar muestra </button>
                    </div>
                  </div>
                </div>
                <?php }?>
              </div>
              <div id="timeline" class="tab-pane">
                <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <a style="color: #00c0ef;"><i class="glyphicon glyphicon-eye-open"></i></a>=Ver ficha de atención | <span><i class="glyphicon glyphicon-info-sign"></i></span>=Ver detalle de rechazo u observación | <span style="color: #449d44;"><i class="glyphicon glyphicon-ok"></i></span>=Subsanar Observación | <span style="color: #F44336;"><i class="glyphicon glyphicon-remove"></i></span>=Rechazar muestra</p>
                <table id="tblObservado" class="display" cellspacing="0" width="100%">
                  <thead class="bg-yellow">
                    <tr>
                      <th>Nro. Lámina<br/>Laboratorio</th>
                      <th style="width: 50px;">N° Lámina<br/>EESS</th>
                      <th style="width: 30px;">Abrev.<br/>Paciente</th>
                      <th>Nombre del paciente</th>
                      <th>N° Doc.</th>
                      <th>HC</th>
                      <th>SIS</th>
                      <th>Edad</th>
                      <th style="width: 50px;">Estado</th>
                      <th style="width: 35px;"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <div id="settings" class="tab-pane">
                <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <a style="color: #00c0ef;"><i class="glyphicon glyphicon-eye-open"></i></a>=Ver ficha de atención</p>
                <table id="tblAceptable" class="display" cellspacing="0" width="100%">
                  <thead class="bg-green">
                    <tr>
                      <th style="width: 50px;">N° Lámina<br/>EESS</th>
                      <th style="width: 30px;">Abrev.<br/>Paciente</th>
                      <th>Nombre del paciente</th>
                      <th>N° Doc.</th>
                      <th>HC</th>
                      <th>SIS</th>
                      <th>Edad</th>
                      <th>1er PAP</th>
                      <th>Estado</th>
                      <th>Nro. Lámina<br/>Laboratorio</th>
                      <th><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <div id="noconfor" class="tab-pane">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="box box-primary">
                      <div class="box-body box-profile">
                        <br/>
                        <div class="form-group">
                          <label for="txtIdTipNoConfor">Tipo</label>
                          <select name="txtIdTipNoConfor" id="txtIdTipNoConfor" class="form-control input-sm" onchange="get_listaMotivoNoConfor()">
                            <option value="" selected>-- Seleccione --</option>
                            <option value="1">CON LOS DOCUMENTOS</option>
                            <option value="2">CON EL EMPAQUE</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="txtIdMotNoConfor">Motivo</label>
                          <select name="txtIdMotNoConfor" id="txtIdMotNoConfor" style="width:100%;" disabled>
                            <option value="" selected="">-- Seleccione --</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="txtDetNoConfor">Detalle</label>
                          <textarea class="form-control" rows="3" id="txtDetNoConfor" name="txtDetNoConfor"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary btn-block" id="btnValidFormNoConfor" onclick="save_confor()"><i class="fa fa-save"></i> Guardar </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-9">
                    <div class="box box-success">
                      <br/>
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th style="width: 15px"><small>#</small></th>
                              <th><small>Tipo<small></th>
                                <th><small>Motivo</small></th>
                                <th><small>Detalle</small></th>
                              </tr>
                            </thead>
                            <tbody id="det-noconfor">
                              <tr>
                                <td colspan="4"><small>No se encontraron resultados</small></td>
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
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="showObsModal" role="dialog" aria-labelledby="showObsModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showObsModalLabel"></h4>
        </div>
        <div class="modal-body">
          <form name="frmObs" id="frmObs">
            <div class="form-group">
              <div class="row">
                <div id="showPorModificar" style="display: none;">
                  <div class="col-sm-12 text-center">
                    <div class="radio">
                      <div class="radio-inline">
                        <label>
                          <input type="radio" name="txtIdEstEnvDet" id="txtIdEstEnvDet4" class="opt_estenvdet" value="4">
                          Rechazar
                        </label>
                      </div>
                      <div class="radio-inline">
                        <label>
                          <input type="radio" name="txtIdEstEnvDet" id="txtIdEstEnvDet3" class="opt_estenvdet" value="3">
                          Por Subsanar
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <label for="txtIdObsEstEnvDet">Motivo:</label>
                  <select class="form-control" name="txtIdObsEstEnvDet" id="txtIdObsEstEnvDet"></select>
                </div>
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
                  <button type="button" class="btn btn-success btn-continuar" id="btnValidFormSub" onclick="save_form_subsanar()"><i class="fa fa-save"></i> Subsanar </button>
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="showRecModal" role="dialog" aria-labelledby="showRecModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="showRecModalLabel"></h4>
          </div>
          <div class="modal-body">
            <form name="frmRechazar" id="frmRechazar">
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12">
                    <label for="txtIdObsRecEstEnvDet">Motivo:</label>
                    <select class="form-control" name="txtIdObsRecEstEnvDet" id="txtIdObsRecEstEnvDet"></select>
                  </div>
                  <div class="col-sm-12">
                    <label for="txtDetRecEstEnvDet">Detalle motivo:</label>
                    <textarea class="form-control" name="txtDetRecEstEnvDet" id="txtDetRecEstEnvDet" rows="3"></textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="row">
              <div class="col-md-12 text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-danger" id="btnValidFormRec" onclick="save_form_rechazar()"><i class="fa fa-save"></i> Rechazar </button>
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


    function exportar_datos() {
      window.location = './xls_repregrecepcion.php?idEnv=' + $("#txtIdEnv").val();
    }

    function back() {
      window.location = './main_principalsolirecep.php';
    }

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

    function open_detobs(iddetenv) {
      $.ajax({
        url: "../../controller/ctrlPAP.php",
        type: "POST",
        dataType: 'json',
        data: {
          accion: 'GET_SHOW_DETOBSPORIDDETENV', idDetEnv: iddetenv
        },
        success: function (registro) {
          var datos = eval(registro);
          $('#lblNomAccion').text(datos[3]);
          $('#lblMotObs').text(datos[5]);
          $('#lblDetObs').text(datos[6]);
          $('#showDetObsModal').modal({
            show: true,
            backdrop: 'static',
            focus: true,
          });
        }
      });
    }

    function get_listaobsdetenv(opt, opc) {
      $.ajax({
        url: "../../controller/ctrlPAP.php",
        type: "POST",
        dataType: "json",
        data: {
          accion: 'GET_SHOW_LISTAOBSPORIDESTENV', txtIdEstEnvDet: opt
        },
        success: function (result) {
          if(opc == "o"){
            $('#txtIdObsEstEnvDet').prop("disabled", false);
          }
          var newOption = "";
          newOption = "<option value=''>--Seleccionar-</option>";
          $(result).each(function (ii, oo) {
            newOption += "<option value='" + oo.id_tipoobsenvdet + "'>" + oo.nom_estado + "</option>";
          });
          if(opc == "o"){
            $('#txtIdObsEstEnvDet').html(newOption);
            $("#txtIdObsEstEnvDet").select2();
            setTimeout(function(){$("#txtIdObsEstEnvDet").select2('open');}, 2);
          } else {
            $('#txtIdObsRecEstEnvDet').html(newOption);
            $("#txtIdObsRecEstEnvDet").select2();
            setTimeout(function(){$("#txtIdObsRecEstEnvDet").select2('open');}, 2);
          }
        }
      });
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
        if(opt == '2'){
          $('#showPorModificar').show();
          $('#showObsModalLabel').text('Rechazar / Por subsanar muestra(s)');
          $('#btnValidForm').addClass('btn-warning').removeClass('btn-danger');
          $('#btnValidForm').text('Rechazar / Por subsanar muestra(s)');
          $('#btnOpenForm' + opt).prop("disabled", false);
          $("#txtIdObsEstEnvDet").val('').trigger("change");
          $('#txtIdObsEstEnvDet').prop("disabled", true);
          $('#txtDetObsEstEnvDet').val('');
          $(".opt_estenvdet").prop('checked', false);
          $('#showObsModal').modal({
            show: true,
            backdrop: 'static',
            focus: true,
          });
        } else if(opt == '1'){
          $('#showPorModificar').hide();
          $('#showObsModalLabel').text('Rechazar Envio');
          $('#btnValidForm').addClass('btn-danger').removeClass('btn-warning');
          $('#btnValidForm').text('Rechazar Envio');
          $("#txtIdObsEstEnvDet").val('').trigger("change");
          $('#txtIdObsEstEnvDet').prop("disabled", false);
          $('#txtDetObsEstEnvDet').val('');
          $(".opt_estenvdet").prop('checked', false);
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

    function open_subsanar(idenvdet, nrolam) {
      document.frmPrincipal.txtIdEnvDet.value = idenvdet;
      $('#showSubModal').modal({
        show: true,
        backdrop: 'static',
        focus: true,
      });

      $('#showSubModal').on('shown.bs.modal', function (e) {
        var modal = $(this)
        modal.find('.modal-title').text('Subsanar lámina ' + nrolam)
        $("#txtDetSubEstEnvDet").trigger('focus');
      })
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
                  /*bootbox.alert({
                    message: "Se ejecutó correctamente la información solicitada",
                    callback: function () {
                      location.reload();
                    }
                  });*/
				  location.reload();
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
                  /*bootbox.alert({
                    message: "Se ejecutó correctamente la información solicitada",
                    callback: function () {
                      location.reload();
                    }
                  });*/
				  location.reload();
                } else {
				  $('#btnValidFormRec').prop("disabled", false);
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

      if(txtDetObsEstEnvDet == ""){
        msg+= "Ingrese detalle de la observación<br/>";
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
        msg = "Se cambiará a estado <b class='text-success'>ADECUADA</b> las muestras seleccionadas, ¿Está seguro de continuar?";
      } else {
        var txtTipoOpe = $('#txtTipoOpe').val();
        if(txtTipoOpe == "1"){
          msg = "Se cambiará el estado a <b class='text-danger'>RECHAZADO</b> el envío, ¿Está seguro de continuar?";
        } else if (txtTipoOpe == "2"){
          var idEstEnvDet = document.frmObs.txtIdEstEnvDet.value;
          if(idEstEnvDet == "3"){
            msg = "Se cambiará el estado a <b class='text-warning'>POR SUBSANAR</b> la(s) muestra(s) seleccionada(s), ¿Está seguro de continuar?";
          } else {
            msg = "Se cambiará el estado a <b class='text-danger'>RECHAZADO</b> las muestra(s) seleccionada(s), ¿Está seguro de continuar?";
          }
        }
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
              url: '../../controller/ctrlPAP.php',
              data: {
                accion: 'POST_ADD_REGENVIOOBSOACEPTARDET', txtTipoOpe: $('#txtTipoOpe').val(), txtIdEnv: txtIdEnv , txtIdEnvDet: $('#example-console-rows').text(), txtIdEstEnvDet: document.frmObs.txtIdEstEnvDet.value, txtIdObsEstEnvDet: $('#txtIdObsEstEnvDet').val(), txtDetObsEstEnvDet: $('#txtDetObsEstEnvDet').val(),
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
                    callback: function () {
                      location.reload();
                    }
                  });*/
				  location.reload();
                } else {
                  bootbox.alert(msg);
				  $('#btnOpenForm' + opt).prop("disabled", false);
                  return false;
                }
              }
            });
          } else {
            $('#btnOpenForm' + opt).prop("disabled", false);
          }
        }
      });
    }


    function save_confor() {
      $('#btnValidFormNoConfor').prop("disabled", true);
      var msg = "";
      var sw = true;

      var txtIdTipNoConfor = $('#txtIdTipNoConfor').val();
      var txtIdMotNoConfor = $('#txtIdMotNoConfor').val();
      if(txtIdTipNoConfor == ""){
        msg+= "Seleccione tipo de no conformidad<br/>";
        sw = false;
      }
      if(txtIdMotNoConfor == ""){
        msg+= "Seleccione motivo de no conformidd<br/>";
        sw = false;
      }

      if (sw == false) {
        bootbox.alert(msg);
        $('#btnValidFormNoConfor').prop("disabled", false);
        return sw;
      }

      bootbox.confirm({
        message: "Se registrará la no conformidad, ¿Está seguro de continuar?",
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
              url: '../../controller/ctrlPAP.php',
              data: {
                accion: 'POST_ADD_ENVIOMOTIVONOCONFOR', txtIdEnv: txtIdEnv, txtIdMotNoConfor: $('#txtIdMotNoConfor').val() , txtDetNoConfor: $('#txtDetNoConfor').val(),
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
                      show_detnoconfor();
                    }
                  });
                } else {
                  bootbox.alert(msg);
                }
              }
            });
            $('#btnValidFormNoConfor').prop("disabled", false);
            $('#txtIdTipNoConfor').val('');
            $("#txtIdMotNoConfor").val('').trigger("change");
            $('#txtIdMotNoConfor').prop("disabled", true);
            $('#txtDetNoConfor').val('');
          } else {
            $('#btnValidFormNoConfor').prop("disabled", false);
          }
        }
      });
    }


    function show_detnoconfor(){
      var txtIdEnv = "<?php echo $_GET['envivo']?>";
      $.ajax({
        url: "../../controller/ctrlPAP.php",
        type: "POST",
        data: {
          accion: 'GET_SHOW_MOTIVONOCONFORPORIDENV', txtIdEnv: txtIdEnv
        },
        success: function (result) {
          var datos = eval(result);
          $("#lblNoConfor").text(datos[0]);
          var newOption = "";
          if(datos[0] != "0"){
            var newItem = 0;
            $(datos[1]).each(function (ii, oo) {
              newItem = newItem + 1;
              newOption += "<tr><td><small>" + newItem + "</small></td><td><small>" + oo.nom_tipo + "</small></td><td><small>" + oo.nom_motivo + "</small></td><td><small>" + oo.det_noconformidad + "</small></td></tr>";
            });
          } else {
            newOption += "<tr><td colspan=\"4\"><small>No se encontraron resultados</small></td></tr>";
          }
          $("#det-noconfor").html(newOption);
        }
      });
    }


    function open_pdfsinvalor(idSoli) {

      var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
      day = new Date();
      id = day.getTime();
      Xpos = (screen.width / 2) - 390;
      Ypos = (screen.height / 2) - 300;
      eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
    }

	function regresar_envio(id_envio){
		$('#btnRBRecibidos').prop("disabled", true);
		bootbox.confirm({
			  message: "El envío regresará a la Bandeja de Recepción, ¿Estás seguro de continuar?",
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
					url: "../../controller/ctrlPAP.php",
					type: "POST",
					data: {
					  accion: 'POST_ADD_VOLVERENVIORECEPCION', txtIdEnv: id_envio,
					},
					success: function (data) {
					  var tmsg = data.substring(0, 2);
					  var lmsg = data.length;
					  var msg = data.substring(3, lmsg);
					  //console.log(tmsg);
					  if(tmsg == "OK"){
							window.location = './main_principalsolirecep.php';
					  } else {
						bootbox.alert(msg);
						$('#btnRBRecibidos').prop("disabled", false);
						return false;
					  }
					}
				  });
				} else {
				  $('#btnRBRecibidos').prop("disabled", false);
				}
			  }
			});
	}
	
	function reg_proceso(txtIdEnv) {
		window.location = './main_regrecepcion.php?envivo=' +  txtIdEnv;
	}

    $(document).ready(function () {
      if(($('#txtCantMod').text() != "0") || ($('#txtCantRec').text() != "0") || ($('#txtCantAcep').text() != "0")){
        $('#btnOpenForm1').prop("disabled", true);
      }

      $("#txtIdMotNoConfor").select2();

      $("body").tooltip({ selector: '[data-toggle=tooltip]' });

      show_detnoconfor();

      var table = $('#example').DataTable({
        "lengthMenu": [[20, 50, 100 ,250], [20, 50, 100 ,250, "All"]],
        "sAjaxSource": "tbl_regrecepcion.php", // Load Data
        "responsive": true,
		"bFilter": false,
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
          aoData.push({"name": "idPapEnv", "value": "<?php echo $_GET['envivo']?>"});
          aoData.push({"name": "estEnv", "value": ""});
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
          {"orderable": false, "targets": 1, "searchable": true, "class": "text-center font-weit"},
          {"orderable": false, "targets": 2, "searchable": true, "class": "text-center font-weit"},
          {"orderable": false, "targets": 3, "searchable": true, "class": "text-center font-weit"},
          {"orderable": false, "targets": 4, "searchable": true, "class": ""},
          {"orderable": false, "targets": 5, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 6, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 7, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 8, "searchable": true, "class": "text-center"}
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
        "sAjaxSource": "tbl_regrecepcionobs.php", // Load Data
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
          aoData.push({"name": "estEnv", "value": "obs"});
          aoData.push({"name": "idPapEnv", "value": "<?php echo $_GET['envivo']?>"});

        },
        "columnDefs": [
          {"orderable": true, "targets": 0, "searchable": true, "class": "text-center font-weit"},
          {"orderable": false, "targets": 1, "searchable": true, "class": "text-center font-weit"},
          {"orderable": false, "targets": 2, "searchable": true, "class": ""},
          {"orderable": false, "targets": 3, "searchable": true, "class": ""},
          {"orderable": false, "targets": 4, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 5, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 6, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 7, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 8, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 9, "searchable": true, "class": "large text-center"}
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
        "sAjaxSource": "tbl_regrecepcionacep.php", // Load Data
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
          aoData.push({"name": "estEnv", "value": "acep"});
          aoData.push({"name": "idPapEnv", "value": "<?php echo $_GET['envivo']?>"});

        },
        "columnDefs": [
          {"orderable": true, "targets": 0, "searchable": true, "class": "text-center font-weit"},
          {"orderable": true, "targets": 1, "searchable": true, "class": "text-center font-weit"},
          {"orderable": false, "targets": 2, "searchable": true, "class": ""},
          {"orderable": false, "targets": 3, "searchable": true, "class": ""},
          {"orderable": false, "targets": 4, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 5, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 6, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 7, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 8, "searchable": true, "class": "text-center"},
          {"orderable": false, "targets": 9, "searchable": true, "class": "text-center font-weit"},
          {"orderable": false, "targets": 10, "searchable": true, "class": "large text-center"}
        ]
        //,"order": [[ 0, "desc" ]]
      });

      $('#tblAceptable').removeClass('display').addClass('table table-hover table-bordered');

    });
  </script>
  <?php require_once '../include/masterfooter.php'; ?>

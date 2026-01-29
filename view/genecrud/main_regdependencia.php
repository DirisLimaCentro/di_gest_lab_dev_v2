<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php
require_once '../include/sidebar.php';

require_once '../../model/Servicio.php';
$se = new Servicio();
require_once '../../model/Ubigeo.php';
$ub = new Ubigeo();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Mantenimiento de dependencia</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3">
          <div class="box box-success">
            <br/>
            <div class="box-body box-profile">
              <h3 class="profile-username text-center" id="titleAcc">Nueva Dependencia</h3>
              <form id="frmDepen" name="frmDepen">
                <input type="hidden" name="txtIdDep" id="txtIdDep" value="0"/>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-4">
                      <label for="txtCodRefDep">Código</label>
                      <input type="text" class="form-control input-sm" name="txtCodRefDep" id="txtCodRefDep" autocomplete="off" maxlength="10"/>
                    </div>
                    <div class="col-sm-8">
                      <label for="txtAbrevDep">Abreviatura</label>
                      <input type="text" class="form-control input-sm" name="txtAbrevDep" id="txtAbrevDep" autocomplete="off" maxlength="75"/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="txtNomDep">Nombre</label>
                  <input type="text" class="form-control input-sm" name="txtNomDep" id="txtNomDep" autocomplete="off" maxlength="500"/>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-4">
                      <label for="txtIdTipDep">Tipo</label>
                      <select name="txtIdTipDep" id="txtIdTipDep" class="form-control input-sm">
                        <option value="" selected>-- Seleccione --</option>
                        <option value="1">SEDE CENTRAL</option>
                        <option value="2">CENTRO DE SALUD</option>
                        <option value="3">HOSPITAL</option>
                        <option value="4">EXTERNOS</option>
                        <option value="5">OFICINA ADMINISTRATIVA</option>
                        <option value="6">ESPECIALIDADES</option>
                      </select>
                    </div>
                    <div class="col-sm-8">
                      <label for="txtIdCatDep">Categoria</label>
                      <select name="txtIdCatDep" id="txtIdCatDep" class="form-control input-sm">
                        <option value="" selected>-- Seleccione --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
						<option value="5">E</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="txtIdUbigDep">Ubigeo</label>
                  <?php $rsUb = $ub->get_listaUbigeoPeru(); ?>
                  <select class="form-control input-xs" style="width: 100%" name="txtIdUbigDep" id="txtIdUbigDep" onkeydown="campoSiguiente('txtDirPac', event);">
                    <option value="">Seleccione</option>
                    <?php
                    foreach ($rsUb as $rowUb) {
                      echo "<option value='" . $rowUb['id_ubigeo'] . "'>" . $rowUb['departamento'] . " - " . $rowUb['provincia'] . " - " . $rowUb['distrito'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="txtDirDep">Dirección</label>
                  <input type="text" class="form-control input-sm text-uppercase" name="txtDirDep" id="txtDirDep" autocomplete="off" maxlength="500"/>
                </div>

                <fieldset class="scheduler-border">
                  <legend class="scheduler-border" style="margin-bottom: 0px;">Módulo Laboratorio</legend>
                  <div class="radio">
                    <b>Correlativo por tipo (SIS-1,D-1) ? : </b>
                    <label class="radio-inline">
                      <input type="radio" class="opt_tipocorre" name="txtTipCorre" id="txtTipCorre1" value="1"> Si
                    </label>
                    <label class="radio-inline">
                      <input type="radio" class="opt_tipocorre" name="txtTipCorre" id="txtTipCorre2" value="0"> No
                    </label>
                  </div>
                  <div class="radio">
                    <b>Imprimir ticket? : </b>
                    <label class="radio-inline">
                      <input type="radio" class="opt_impriticket" name="txtImpriTicket" id="txtImpriTicket1" value="1"> Si
                    </label>
                    <label class="radio-inline">
                      <input type="radio" class="opt_impriticket" name="txtImpriTicket" id="txtImpriTicket2" value="0"> No
                    </label>
                    <br/>
                    ( Tipo de impresora :
                    <label class="radio-inline">
                      <input type="radio" class="opt_tipoimpresora" name="txtTipImpresora" id="txtTipImpresora" value="1" disabled> Ticketera
                    </label>
                    <label class="radio-inline">
                      <input type="radio" class="opt_tipoimpresora" name="txtTipImpresora" id="txtTipImpresora" value="2" disabled> Normal
                    </label>
                    )
                  </div>
                </fieldset>
				<fieldset class="scheduler-border">
                  <legend class="scheduler-border" style="margin-bottom: 0px;">Módulo PAP</legend>
                  <div class="radio">
                    <b>Envía láminas a la Sede: </b>
                    <label class="radio-inline">
                      <input type="radio" class="opt_envlamisede" name="txtEnvLamiSede" id="txtEnvLamiSede1" value="1"> Si
                    </label>
                    <label class="radio-inline">
                      <input type="radio" class="opt_envlamisede" name="txtEnvLamiSede" id="txtEnvLamiSede2" value="0"> No
                    </label>
                  </div>
                </fieldset>
                <p></p>
                <button type="button" class="btn btn-primary btn-block" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Guardar </button>
                <div id="show-new" style="display:none; margin-top:5px;">
                  <button type="button" class="btn btn-success btn-block" id="btnNewForm" onclick="nuevo_registro()"><i class="glyphicon glyphicon-plus"></i> Nueva Dependencia </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="box box-primary">
            <br/>
			<p>
			<span>Buscar dependencia en Web de SUSALUD: </span>
			<a href="http://app20.susalud.gob.pe:8080/registro-renipress-webapp/ipress.htm?action=mostrarVer#no-back-button" target="_blank" aria-hidden="true" data-toggle='tooltip' title="SUSALUD">Búsqueda por código</a> | 
			<a href="http://app20.susalud.gob.pe:8080/registro-renipress-webapp/listadoEstablecimientosRegistrados.htm?action=mostrarBuscar#no-back-button" target="_blank" aria-hidden="true" data-toggle='tooltip' title="SUSALUD">Búsqueda por Nombre o descripción</a>
			</p>
            <table id="tblDependencia" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Abreviatura</th>
                  <th>Nombre</th>
                  <th>Categoria</th>
                  <th>Tipo</th>
                  <th>Dirección</th>
                  <th>N° Serv.</th>
                  <th>Estado</th>
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
    <div class="modal-footer">
      <div class="row">
        <div class="col-md-12 text-center">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Ir al Menú</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="showSerDepModal" tabindex="-1" role="dialog" aria-labelledby="showSerDepModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showSerDepModalLabel"></h4>
      </div>
      <div class="modal-body">
        <form id="frmSerDep" name="frmSerDep">
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10">
                <label for="txtIdServicio">Servicio</label>
                <?php $rsSe = $se->get_listaServicio(); ?>
                <select name="txtIdServicio" id="txtIdServicio" class="form-control input-xs" style="width: 100%">
                  <option value="" selected="">-- Seleccione --</option>
                  <?php
                  foreach ($rsSe as $row) {
                    echo "<option value='" . $row['id_servicio'] . "'>" . $row['nom_servicio'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-2">
                &nbsp;<br/>
                <button type="button" id="btnSerDep" class="btn btn-primary btn-sm" onclick="save_formser()"><i class="glyphicon glyphicon-plus"></i></button>
              </div>
            </div>
          </div>
          <div id="datos-tabla">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><small>Servicio</small></th>
                  <th><small>Estado</small></th>
                  <th><small><i class="fa fa-cogs"></i></small></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12">
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

    $(function() {

      $('[name="txtImpriTicket"]').change(function()
      {
        if ($(this).is(':checked')) {
          if($(this).val() == "1"){
            $(".opt_tipoimpresora").prop('checked', false);
            $(".opt_tipoimpresora").prop('disabled', false);
          } else {
            $(".opt_tipoimpresora").prop('checked', false);
            $(".opt_tipoimpresora").prop('disabled', true);
          }
        }
      });
    });

    function open_servicio(iddep, nomdep){
      document.frmDepen.txtIdDep.value = iddep;
      carga_serviciodep(iddep);

      $('#showSerDepModal').modal({
        show: true,
        backdrop: 'static',
        focus: true,
      });

      $('#showSerDepModal').on('shown.bs.modal', function (e) {
        var modal = $(this)
        modal.find('.modal-title').text(nomdep)
      })
    }

    function carga_serviciodep(iddep){
      $("#txtIdServicio").val('').trigger("change");
      $.ajax({
        url: "../../controller/ctrlServicio.php",
        type: "POST",
        data: {
          accion: 'GET_SHOW_SERVICIOPORIDDEP', idDep: iddep
        },
        success: function (registro) {
          $("#datos-tabla").html(registro);
        }
      });
    }

    function save_formser() {
      bootbox.confirm({
        message: "Se Ingresará el servicio seleccionado, ¿Está seguro de continuar?",
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
            form_data.append('accion', 'POST_ADD_REGSERVICIOPORDEP');
            form_data.append('txtIdDep', document.frmDepen.txtIdDep.value);
            form_data.append('txtIdServicio', document.frmSerDep.txtIdServicio.value);
            form_data.append('rand', myRand);
            $.ajax( {
              url: '../../controller/ctrlServicio.php',
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
                  carga_serviciodep(document.frmDepen.txtIdDep.value);
                  $("#tblDependencia").dataTable().fnDraw();
                  bootbox.alert("Registro ingresado correctamente");
                } else {
                  bootbox.alert(msg);
                  return false;
                }
                //$('#btnSerDep').prop("disabled", false);
              }
            });
          } else {
            //$('#btnSerDep').prop("disabled", false);
          }
        }
      });
    }

    function cambio_serviciodep(idserdep, idest){
      var myRand = parseInt(Math.random() * 999999999999999);
      var form_data = new FormData();
      form_data.append('accion', 'POST_ADD_REGSERVICIOPORDEP');
      form_data.append('txtIdServicioDep', idserdep);
      form_data.append('txtIdEstServicioDep', idest);
      form_data.append('rand', myRand);
      $.ajax( {
        url: '../../controller/ctrlServicio.php',
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
            carga_serviciodep(document.frmDepen.txtIdDep.value);
            $("#tblDependencia").dataTable().fnDraw();
          } else {
            bootbox.alert(msg);
            return false;
          }
          //$('#btnSerDep').prop("disabled", false);
        }
      });
    }

    function edit_registro(iddep) {

      $.ajax({
        url: "../../controller/ctrlDependencia.php",
        type: "POST",
        dataType: 'json',
        data: {
          accion: 'GET_SHOW_DETDEPENDENCIA', idDep: iddep
        },
        success: function (registro) {
          var datos = eval(registro);
          $('#show-new').show();
          $('#titleAcc').text('Editar Dependencia');
          document.frmDepen.txtIdDep.value = datos[0];
          document.frmDepen.txtCodRefDep.value = datos[3];
          document.frmDepen.txtAbrevDep.value = datos[4];
          document.frmDepen.txtNomDep.value = datos[5];
          document.frmDepen.txtIdTipDep.value = datos[1];
          document.frmDepen.txtIdCatDep.value = datos[6];
          $("#txtIdUbigDep").val(datos[7]).trigger("change");
          document.frmDepen.txtDirDep.value = datos[11];
          document.frmDepen.txtTipCorre.value = datos[12];
          document.frmDepen.txtImpriTicket.value = datos[14];
          document.frmDepen.txtTipImpresora.value = datos[16];
		  document.frmDepen.txtEnvLamiSede.value = datos[18];
		  
          if(datos[16] == "1"){
            $(".opt_tipoimpresora").prop('disabled', false);
          } else {
            $(".opt_tipoimpresora").prop('checked', false);
            $(".opt_tipoimpresora").prop('disabled', true);
          }
		  
          document.frmDepen.txtCodRefDep.focus();
        }
      });
    }

    function nuevo_registro(){
      $('#show-new').hide();
      $('#titleAcc').text('Nueva Dependencia');
      document.frmDepen.txtIdDep.value = 0;
      document.frmDepen.txtCodRefDep.value = '';
      document.frmDepen.txtAbrevDep.value = '';
      document.frmDepen.txtNomDep.value = '';
      document.frmDepen.txtIdTipDep.value = '';
      document.frmDepen.txtIdCatDep.value = '';
      $("#txtIdUbigDep").val('').trigger("change");
      document.frmDepen.txtDirDep.value = '';

      $(".opt_tipocorre").prop('checked', false);
      $(".opt_impriticket").prop('checked', false);
      $(".opt_tipoimpresora").prop('disabled', true);
      $(".opt_tipoimpresora").prop('checked', false);
	  $(".opt_envlamisede").prop('checked', false);

      document.frmDepen.txtCodRefDep.focus();
    }

    function validForm() {
      //$('#btnValidForm').prop("disabled", true);
      var msg = "";
      var sw = true;

      var nomDep = $('#txtNomDep').val();
      var idTipDep = $('#txtIdTipDep').val();


      if(nomDep == ""){
        msg+= "Ingrese nombre de la Dependencia<br/>";
        sw = false;
      }

      if(idTipDep == ""){
        msg+= "Seleccione Tipo de Dependencia<br/>";
        sw = false;
      }

      if ($('input.opt_tipocorre').is(':checked')) {

      } else {
        msg+= "Seleccione correlativo po correlativo<br/>";
        sw = false;
      }


      if ($('input.opt_impriticket').is(':checked')) {
        $.each($('.opt_impriticket:checked'), function() {
          if($(this).val() == "1"){
            if ($('input.opt_tipoimpresora').is(':checked')) {
            } else {
              msg+= "Seleccione Tipo de impresora<br/>";
              sw = false;
            }
          }
        });
      } else {
        msg+= "Seleccione si desea imprimir en ticket<br/>";
        sw = false;
      }

	  if ($('input.opt_envlamisede').is(':checked')) {
        $.each($('.opt_envlamisede:checked'), function() {
          if($(this).val() == "1"){
            if ($('input.opt_envlamisede').is(':checked')) {
            } else {
              msg+= "Seleccione Si la Dependencia enviará láminas a la Sede Central<br/>";
              sw = false;
            }
          }
        });
      } else {
        msg+= "Seleccione Si la Dependencia enviará láminas a la Sede Central<br/>";
        sw = false;
      }

      if (sw == false) {
        bootbox.alert(msg);
        $('#btnValidForm').prop("disabled", false);
        return sw;
      } else {
        save_form();
      }
      return false;
    }

    function save_form() {
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
            form_data.append('accion', 'POST_ADD_REGDEPENDENCIA');
            form_data.append('txtIdDep', document.frmDepen.txtIdDep.value);
            form_data.append('txtCodRefDep', document.frmDepen.txtCodRefDep.value);
            form_data.append('txtAbrevDep', document.frmDepen.txtAbrevDep.value);
            form_data.append('txtNomDep', document.frmDepen.txtNomDep.value);
            form_data.append('txtIdTipDep', document.frmDepen.txtIdTipDep.value);
            form_data.append('txtIdCatDep', document.frmDepen.txtIdCatDep.value);
            form_data.append('txtIdUbigDep', $("#txtIdUbigDep").val());
            form_data.append('txtDirDep', document.frmDepen.txtDirDep.value);
            form_data.append('txtTipCorre', document.frmDepen.txtTipCorre.value);
            form_data.append('txtImpriTicket', document.frmDepen.txtImpriTicket.value);
            form_data.append('txtTipImpresora', document.frmDepen.txtTipImpresora.value);
			form_data.append('txtEnvLamiSede', document.frmDepen.txtEnvLamiSede.value);

            form_data.append('rand', myRand);
            $.ajax( {
              url: '../../controller/ctrlDependencia.php',
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
                  $("#tblDependencia").dataTable().fnDraw();
                  /*if($("#").val() == "0"){
                    bootbox.alert("Registro ingresado correctamente.");
                  } else {
                    bootbox.alert("Registro actualizado correctamente.");
                  }*/
                  $('#show-new').hide();

                  nuevo_registro();

                } else {
                  bootbox.alert(msg);
                  return false;
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
      $('#txtIdUbigDep').select2();
      $("#txtIdServicio").select2();
      var dTable = $('#tblDependencia').DataTable({
        "bLengthChange": true, //Paginado 10,20,50 o 100
        "bProcessing": true,
        "bServerSide": true,
        "bJQueryUI": false,
        "responsive": true,
        "bInfo": true,
        "bFilter": true,
        "sAjaxSource": "tbl_regdependencia.php", // Load Data
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
          aoData.push({"name": "idEstado", "value": ""});

        },
        "columnDefs": [
          {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center font-weit"},
          {"orderable": false, "targets": 1, "searchable": false, "class": "small"},
          {"orderable": true, "targets": 2, "searchable": true, "class": "small"},
          {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 4, "searchable": false, "class": "small"},
          {"orderable": false, "targets": 5, "searchable": false, "class": "small"},
          {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 8, "searchable": false, "class": "small text-center"}
        ]
      });

      $('#tblDependencia').removeClass('display').addClass('table table-hover table-bordered');

    });
    </script>
    <?php require_once '../include/masterfooter.php'; ?>

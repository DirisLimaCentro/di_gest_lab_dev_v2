<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php

require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/UnidadMedida.php';
$um = new UnidadMedida();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Mantenimiento de Grupos por Área de Laboratorio Clínico</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-10">
          <form class="form-horizontal" name="frmBuscar" id="frmBuscar" onsubmit="return false;">
            <input type="hidden" name="idDepQuejaPer" id="idDepQuejaPer" value="<?php if ($acceSelecDep <> "1") echo $saaIdDep; ?>"/>
            <div class="form-group">
              <div class="col-md-2">
                <label for="txtBusIdEstado">Estado</label>
                <select name="txtBusIdEstado" id="txtBusIdEstado" class="form-control input-sm">
                  <option value="1">-- Todo --</option>
                  <option value="1">ACTIVO</option>
                  <option value="2">INACTIVO</option>
                </select>
              </div>
              <div class="col-sm-1 col-md-1">
                <br/>
                <button class="btn btn-success btn-sm" type="button" id="btnCon" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
              </div>
              <div class="col-sm-4 col-md-4">
                <br/>
                <button id="btnRegistrarAsis" class="btn btn-warning pull-right btn-sm" type="button" onclick="exportar_busqueda();" tabindex="0"><i class="glyphicon glyphicon-open"></i> Exportar a Excel</button>
              </div>
            </div>
          </form>
          <br/>
          <table id="tblAtencion" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th><small>Orden Area</small></th>
                <th><small>Abrev Area</small></th>
                <th><small>Nombre Área</small></th>
                <th><small>Visible</small></th>
                <th><small>Cant. Grupos</small></th>
                <th><small>&nbsp;</small></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="col-sm-2">
          <div>
            <small>
              <p><b>Leyenda:</b></p>
              <ul>
                <li>
                  <b>Agregar o quitar grupos:</b>
                  <ul class="list-unstyled">
                    <li><button class="btn btn-success btn-xs" style="cursor: default;"><i class="glyphicon glyphicon-list-alt"></i></button></li>
                  </ul>
                </li>
              </ul>
              <p><b>Botones de acción:</b></p>
              <div class="row">
                <button class="btn btn-default btn-sm" id="btnBack" type="button" onclick="back();" tabindex="1"><i class="glyphicon glyphicon-log-out"></i> Ir al Men&uacute;</button>
              </div>
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="showGrupoAreaModal" tabindex="-1" role="dialog" aria-labelledby="showGrupoAreaModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showGrupoAreaModalLabel"></h4>
        </div>
        <div class="modal-body">
          <div id="datos-tabla">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><small>Orden</small></th>
                  <th><small>Grupo</small></th>
                  <th><small>Visible</small></th>
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

    <div class="modal fade" id="showCompDetModal" tabindex="-1" role="dialog" aria-labelledby="showCompDetModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="showCompDetModalLabel"></h4>
          </div>
          <div class="modal-body">
            <div style="margin-bottom: 5px;">
              <button class="btn btn-primary btn-sm" onclick="reg_registro()"><i class="glyphicon glyphicon-plus"></i> Agregar Componente</button>
            </div>
            <div id="datos-tabla-comp">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th><small>Orden</small></th>
                    <th><small>&nbsp;</small></th>
                    <th><small>Componente</small></th>
                    <th><small>Unidad de medida</small></th>
                    <th><small>Valor referencia</small></th>
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

      <div class="modal fade" id="showGrupoModal" role="dialog" aria-labelledby="showGrupoModalLabel" style="overflow:hidden;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="showGrupoModalLabel">Agregar Componente</h4>
            </div>
            <div class="modal-body">
              <form name="frmCompGrupoArea" id="frmCompGrupoArea">
                <input type="hidden" name="txtIdArea" id="txtIdArea" value="0"/>
                <input type="hidden" name="txtIdGrupoArea" id="txtIdGrupoArea" value="0"/>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <label for="txtIdGrupo">Componente:</label>
                      <?php $rsG = $c->get_listaComponenteActivo(); ?>
                      <select class="form-control input-xs" style="width: 100%" name="txtIdComp" id="txtIdComp" onchange="det_comp()">
                        <option value="" selected>-- Seleccione --</option>
                        <?php
                        foreach ($rsG as $rowG) {
                          echo "<option value='" . $rowG['id_componente'] . "'>" . $rowG['descrip_comp'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="txtIdUnidMed">Unidad de Medida</label>
                      <?php $rsUM = $um->get_listaUnidadMedida(); ?>
                      <select name="txtIdUnidMed" id="txtIdUnidMed" class="form-control input-sm" disabled>
                        <option value="" selected>-- Seleccione Componente--</option>
                        <option value="0"> SIN UNID. MEDIDA</option>
                        <?php
                        foreach ($rsUM as $rowUM) {
                          echo "<option value='" . $rowUM['id_unimedida'] . "'>" . $rowUM['uni_medida'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-sm-6">
                      <label for="txtIngSoluComp">Ingreso Solución</label>
                      <select name="txtIngSoluComp" id="txtIngSoluComp" class="form-control input-sm" disabled>
                        <option value="" selected>-- Seleccione Componente--</option>
                        <option value="1">LINEA</option>
                        <option value="2">MULTILINEA</option>
						<option value="3">SELECCION</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="txtValRefComp">Valor Referencial</label>
                  <textarea class="form-control" rows="3" name="txtValRefComp" id="txtValRefComp" disabled></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <div class="row">
                <div class="col-md-12 text-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-continuar" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Guardar </button>
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

      function buscar_datos() {
        var idEstado = $("#txtBusIdEstado").val();

        $("#tblAtencion").dataTable().fnDraw()
      }

      function back() {
        window.location = '../pages/';
      }

      function open_grupo(idarea, nomarea){
        document.frmCompGrupoArea.txtIdArea.value = idarea;
        carga_grupoarea(idarea);

        $('#showGrupoAreaModal').modal({
          show: true,
          backdrop: 'static',
          focus: true,
        });

        $('#showGrupoAreaModal').on('shown.bs.modal', function (e) {
          var modal = $(this)
          modal.find('.modal-title').text(nomarea)
        })
      }

      function open_compdet(idgrupoarea, nomgrupo){
        document.frmCompGrupoArea.txtIdGrupoArea.value = idgrupoarea;
        carga_compdet(idgrupoarea);

        $('#showCompDetModal').modal({
          show: true,
          backdrop: 'static',
          focus: true,
        });

        $('#showCompDetModal').on('shown.bs.modal', function (e) {
          var modal = $(this)
          modal.find('.modal-title').text(nomgrupo)
        })
      }

      function carga_grupoarea(idarea){
        $.ajax({
          url: "../../controller/ctrlComponente.php",
          type: "POST",
          data: {
            accion: 'GET_SHOW_GRUPOPORIDAREA', idArea: idarea
          },
          success: function (registro) {
            $("#datos-tabla").html(registro);
          }
        });
      }

      function carga_compdet(idgrupoarea){
        $.ajax({
          url: "../../controller/ctrlComponente.php",
          type: "POST",
          data: {
            accion: 'GET_SHOW_DETCOMPPORIDGRUPOAREA', idGrupoArea: idgrupoarea
          },
          success: function (registro) {
            $("#datos-tabla-comp").html(registro);
          }
        });
      }

      function cambiar_orden(idtip, idcompdet) {
        $.ajax({
          url: "../../controller/ctrlComponente.php",
          type: "POST",
          data: {
            accion: 'GET_REG_CAMBIOORDCOMPONENTEDET', tipAcc: idtip, idCompDet: idcompdet, idGrupoArea: $("#txtIdGrupoArea").val()
          },
          success: function (registro) {
            carga_compdet($("#txtIdGrupoArea").val());
          }
        });
      }

      function reg_registro(){
        $("#txtIdGrupo").val('').trigger("change");
        $('#showGrupoModal').modal({
          show: true,
          backdrop: 'static',
          focus: true,
        });

      }

      function det_comp() {
        var idcomp = $("#txtIdComp").val();
        if(idcomp == ""){
          document.frmCompGrupoArea.txtIdUnidMed.value = '';
          document.frmCompGrupoArea.txtValRefComp.value = '';
          document.frmCompGrupoArea.txtIngSoluComp.value = '';
          document.frmCompGrupoArea.txtIdVisiGruArea.value = '';
          return false;
        }
        $.ajax({
          url: "../../controller/ctrlComponente.php",
          type: "POST",
          dataType: 'json',
          data: {
            accion: 'GET_SHOW_DETCOMPONENTE', idComp: idcomp
          },
          success: function (registro) {
            var datos = eval(registro);
            var idUniMed = 0;
            if (datos[2] != ""){idUniMed = datos[2]};
            document.frmCompGrupoArea.txtIdUnidMed.value = idUniMed;
            document.frmCompGrupoArea.txtValRefComp.value = datos[4];
            document.frmCompGrupoArea.txtIngSoluComp.value = datos[5];
            document.frmCompGrupoArea.txtIdVisiGruArea.value = '';
          }
        });
      }

      function validForm() {
        var msg = "";
        var sw = true;

        var txtIdComp = $('#txtIdComp').val();

        if(txtIdComp == ""){
          msg+= "Seleccione un Componente<br/>";
          sw = false;
        }

        if (sw == false) {
          bootbox.alert(msg);
          $('#btnValidForm').prop("disabled", false);
          return sw;
        } else {
          save_form();
        }
      }

      function save_form() {
        bootbox.confirm({
          message: "Se registrará el componente seleccionado, ¿Está seguro de continuar?",
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
              form_data.append('accion', 'POST_ADD_REGCOMPONENTEDET');
              form_data.append('txtIdGrupoArea', document.frmCompGrupoArea.txtIdGrupoArea.value);
              form_data.append('txtIdComp', $('#txtIdComp').val());
              form_data.append('rand', myRand);
              $.ajax( {
                url: '../../controller/ctrlComponente.php',
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
                    $("#showGrupoModal").modal('hide');
                    $("#tblAtencion").dataTable().fnDraw();
                    carga_grupoarea($("#txtIdArea").val());
                    carga_compdet($("#txtIdGrupoArea").val());
                    bootbox.alert("Componente ingresado correctamente.");
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

      $(document).ready(function () {
        $("#txtIdComp").select2();

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
        "sAjaxSource": "tbl_principalcompxgrupo.php", // Load Data
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
          aoData.push({"name": "idEstado", "value": $("#txtBusIdEstado").val()});

        },
        /*"fnServerParams": function ( aoData ) {
        aoData.push( { "name": "id_tabla", "value": $('#cboiddep').val() } );
      },*/

      "columnDefs": [
        {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center font-weit"},
        {"orderable": false, "targets": 1, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 2, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center font-weit"},
        {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"}
      ]
    });

    $('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');
  });
</script>
<?php require_once '../include/masterfooter.php'; ?>

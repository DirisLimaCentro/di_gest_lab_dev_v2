<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Area.php';
$a = new Area();
require_once '../../model/Grupo.php';
$g = new Grupo();
require_once '../../model/Componente.php';
$c = new Grupo();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Mantenimiento de Componentes por CPT</strong></h3>
    </div>
    <div class="panel-body">
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
                <th><small>Cod CPT</small></th>
                <th><small>CPT</small></th>
                <th><small>Cnt. Comp.</small></th>
                <th><small>&nbsp;</small></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
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
          <div style="margin-bottom: 5px;">
            <button class="btn btn-primary btn-sm" onclick="reg_registro()"><i class="glyphicon glyphicon-plus"></i> Agregar Componente</button>
          </div>
          <div id="datos-tabla">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><small>Componente</small></th>
                  <th><small>Grupo</small></th>
                  <th><small>Area</small></th>
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

    <div class="modal fade" id="showComponenteModal" role="dialog" aria-labelledby="showComponenteModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="showComponenteModalLabel">Agregar Componente</h4>
          </div>
          <div class="modal-body">
            <form name="frmCompCpt" id="frmCompCpt">
              <input type="hidden" name="txtIdCpt" id="txtIdCpt" value="0"/>
              <input type="hidden" name="txtIdCompCpt" id="txtIdCompCpt" value="0"/>
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12">
                    <label for="txtIdArea">Área:</label>
                    <?php $rsA = $a->get_listaArea(); ?>
                    <select class="form-control input-xs" style="width: 100%" name="txtIdArea" id="txtIdArea" onchange="get_listaGrupoArea()">
                      <option value="" selected>-- Seleccione --</option>
                      <?php
                      foreach ($rsA as $rowA) {
                        echo "<option value='" . $rowA['id_area'] . "'>" . $rowA['area'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12">
                    <label for="txtIdGrupoArea">Grupo:</label>
                    <select class="form-control input-xs" style="width: 100%" name="txtIdGrupoArea" id="txtIdGrupoArea" onchange="get_listaCompGrupoArea()">
                      <option value="" selected>-- Seleccione --</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12">
                    <label for="txtIdCompDet">Componente:</label>
                    <select class="form-control input-xs" style="width: 100%" name="txtIdCompDet" id="txtIdCompDet">
                      <option value="" selected>-- Seleccione --</option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="row">
              <div class="col-md-12 text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-continuar" id="btnValidFormComp" onclick="validFormComp()"><i class="fa fa-save"></i> Guardar </button>
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

    function open_comp(idcpt, nomcpt){
      document.frmCompCpt.txtIdCpt.value = idcpt;
      carga_grupoarea(idcpt);

      $('#showCompCptModal').modal({
        show: true,
        backdrop: 'static',
        focus: true,
      });

      $('#showCompCptModal').on('shown.bs.modal', function (e) {
        var modal = $(this)
        modal.find('.modal-title').text(nomcpt)
      })
    }

    function carga_grupoarea(idcpt){
      $.ajax({
        url: "../../controller/ctrlComponente.php",
        type: "POST",
        data: {
          accion: 'GET_SHOW_COMPPORIDCPT', idCpt: idcpt
        },
        success: function (registro) {
          $("#datos-tabla").html(registro);
        }
      });
    }

    function reg_registro(){
      document.frmCompCpt.txtIdCompCpt.value = '0';
      $("#txtIdArea").val('').trigger("change");
      $("#txtIdGrupoArea").val('').trigger("change");
      $('#txtIdGrupoArea').prop("disabled", true);
      $("#txtIdCompDet").val('').trigger("change");
      $('#txtIdCompDet').prop("disabled", true);
      $('#showComponenteModal').modal({
        show: true,
        backdrop: 'static',
        focus: true,
      });
    }

    function get_listaGrupoArea() {
      var idArea = $('#txtIdArea').val();
      if (idArea == "") {
        $("#txtIdGrupoArea").val('').trigger("change");
        $('#txtIdGrupoArea').prop("disabled", true);
        $("#txtIdCompDet").val('').trigger("change");
        $('#txtIdCompDet').prop("disabled", true);
        return false;
      }
      $.ajax({
        url: "../../controller/ctrlGrupo.php",
        type: "POST",
        dataType: "json",
        data: {
          accion: 'GET_SHOW_LISTAGRUPOPORIDAREA', idArea: idArea
        },
        success: function (result) {
          $('#txtIdGrupoArea').prop("disabled", false);
          $("#txtIdCompDet").val('').trigger("change");
          $('#txtIdCompDet').prop("disabled", true);
          var newOption = "";
          newOption = "<option value=''>--Seleccionar-</option>";
          $(result).each(function (ii, oo) {
            newOption += "<option value='" + oo.id_grupoarea + "'>" + oo.grupo + "</option>";
          });
          $('#txtIdGrupoArea').html(newOption);
          $("#txtIdGrupoArea").select2({max_selected_options: 4});
        }
      });
    }

    function get_listaCompGrupoArea() {
      var txtIdGrupoArea = $('#txtIdGrupoArea').val();
      if (txtIdGrupoArea == ""){
        $("#txtIdCompDet").val('').trigger("change");
        $('#txtIdCompDet').prop("disabled", true);
        return false;
      }
      $.ajax({
        url: "../../controller/ctrlComponente.php",
        type: "POST",
        dataType: "json",
        data: {
          accion: 'GET_SHOW_LISTACOMPDETPORIDGRUPOAREA', txtIdGrupoArea: txtIdGrupoArea
        },
        success: function (result) {
          $('#txtIdCompDet').prop("disabled", false);
          var newOption = "";
          newOption = "<option value=''>--Seleccionar-</option>";
          $(result).each(function (ii, oo) {
            newOption += "<option value='" + oo.id_componentedet + "'>" + oo.componente + " - U.M.: " + oo.uni_medida + "</option>";
          });
          $('#txtIdCompDet').html(newOption);
          $("#txtIdCompDet").select2({max_selected_options: 4});
        }
      });
    }

    function validFormComp() {
      var msg = "";
      var sw = true;

      var idArea = $('#txtIdArea').val();
      var idGrupoArea = $('#txtIdGrupoArea').val();
      var idCompGrupo = $('#txtIdCompDet').val();

      if(idArea == ""){
        msg+= "Seleccione un Área<br/>";
        sw = false;
      }

      if(idGrupoArea == ""){
        msg+= "Seleccione un Grupo<br/>";
        sw = false;
      }

      if(idCompGrupo == ""){
        msg+= "Seleccione un Componente<br/>";
        sw = false;
      }

      if (sw == false) {
        bootbox.alert(msg);
        $('#btnValidFormComp').prop("disabled", false);
        return sw;
      } else {
        save_formComp();
      }
    }

    function save_formComp() {
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
            form_data.append('accion', 'POST_ADD_REGCOMPPORCPT');
            form_data.append('txtTipIng', 'C');
            form_data.append('txtIdCpt', $("#txtIdCpt").val());
            form_data.append('txtIdCompDet', $("#txtIdCompDet").val());
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
                  $("#showComponenteModal").modal('hide');
                  $("#tblAtencion").dataTable().fnDraw();
                  carga_grupoarea($("#txtIdCpt").val());
                  bootbox.alert("Registro ingresado correctamente.");
                } else {
                  bootbox.alert(msg);
                  return false;
                }
                $('#btnValidFormComp').prop("disabled", false);
              }
            });
          } else {
            $('#btnValidFormComp').prop("disabled", false);
          }
        }
      });
    }

    function cambio_estado(compdetcpt,estado) {
      bootbox.confirm({
        message: "Se cambiará el estado, ¿Está seguro de continuar?",
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
            form_data.append('accion', 'POST_ADD_REGCOMPPORCPT');
            form_data.append('txtTipIng', 'E');
            form_data.append('txtIdCpt', estado);
            form_data.append('txtIdCompDet', compdetcpt);
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
                  $("#showComponenteModal").modal('hide');
                  $("#tblAtencion").dataTable().fnDraw();
                  carga_grupoarea($("#txtIdCpt").val());
                  bootbox.alert("Registro ingresado correctamente.");
                } else {
                  bootbox.alert(msg);
                  return false;
                }
                $('#btnValidFormComp').prop("disabled", false);
              }
            });
          } else {
            $('#btnValidFormComp').prop("disabled", false);
          }
        }
      });
    }


    var dTable;
    //var id_dep= document.getElementById('cboiddep').value;
    // #areas-grid adalah id pada table
    $(document).ready(function () {
      $("#txtIdArea").select2();

      $("#txtBusFecIni").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
      });
      $("#txtBusFecFin").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
      });

      dTable = $('#tblAtencion').DataTable({
        /*"language": {
        "url": "../plugins/datatables/Spanish.json"
      },*/
      "bLengthChange": true, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
      "sAjaxSource": "tbl_principalcompxcpt.php", // Load Data
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
      {"orderable": false, "targets": 0, "searchable": false, "class": "small text-center  font-weit"},
      {"orderable": false, "targets": 1, "searchable": false, "class": "small"},
      {"orderable": false, "targets": 2, "searchable": false, "class": "small text-center font-weit"},
      {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"}
    ]
  });

  $('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');
});
</script>
<?php require_once '../include/masterfooter.php'; ?>

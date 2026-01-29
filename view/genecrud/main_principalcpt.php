<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<div class="container">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Mantenimiento de UPS</strong></h3>
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
                  <option value="">-- Todo --</option>
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
                <th><small>Código</small></th>
                <th><small>Descripción</small></th>
                <th><small>Estado</small></th>
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
                  <b>Editar:</b>
                  <ul class="list-unstyled">
                    <li><button class="btn btn-success btn-xs" style="cursor: default;"><i class="glyphicon glyphicon-pencil"></i></button></li>
                  </ul>
                </li>
              </ul>
              <p><b>Botones de acción:</b></p>
              <div class="row">
                <button class="btn btn-primary btn-sm" style="margin-bottom: 15px;" onclick="reg_registro()"><i class="glyphicon glyphicon-plus"></i> Registrar</button>
              </div>
              <div class="row">
                <button class="btn btn-default btn-sm" id="btnBack" type="button" onclick="back();" tabindex="1"><i class="glyphicon glyphicon-log-out"></i> Ir al Men&uacute;</button>
              </div>
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="showCptModal" tabindex="-1" role="dialog" aria-labelledby="showCptModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showCptModalLabel">Agregar CPT</h4>
      </div>
      <div class="modal-body">
        <form name="frmCpt" id="frmCpt">
          <input type="hidden" name="txtTipIng" id="txtTipIng" value=""/>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-4">
                <label for="txtIdCpt">Cod. CPT:</label>
                <input type="text" name="txtIdCpt" id="txtIdCpt" class="form-control input-xs" value="" autocomplete="off"/>
              </div>
              <div class="col-sm-4">
                <label for="txtIdEstCpt">Estado:</label>
                <select class="form-control input-xs" name="txtIdEstCpt" id="txtIdEstCpt" onkeydown="campoSiguiente('btnValidForm', event);" disabled>
                  <option value="1" selected>ACTIVO</option>
                  <option value="0">INACTIVO</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-12">
                <label for="txtDescCpt">Grupo:</label>
                <textarea class="form-control" name="txtDescCpt" id="txtDescCpt" rows="3"></textarea>
              </div>
            </div>
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

function reg_registro(){
  document.frmCpt.txtTipIng.value = 'C';
  document.frmCpt.txtIdCpt.value = '';
  document.frmCpt.txtDescCpt.value = '';
  document.frmCpt.txtIdEstCpt.value = '1';
  $('#txtIdEstCpt').prop("disabled", true);
  $('#txtIdCpt').prop("disabled", false);
  $('#showCptModal').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });
  $('#showCptModal').on('shown.bs.modal', function (e) {
    $("#txtIdCpt").trigger('focus');
  });
}

function edit_registro(idcpt) {
  document.frmCpt.txtTipIng.value = 'E';
  $.ajax({
    url: "../../controller/ctrlCpt.php",
    type: "POST",
    dataType: 'json',
    data: {
      accion: 'GET_SHOW_DETCPT', idCpt: idcpt
    },
    success: function (registro) {
      var datos = eval(registro);
      document.frmCpt.txtIdCpt.value = datos[0];
      document.frmCpt.txtDescCpt.value = datos[1];
      document.frmCpt.txtIdEstCpt.value = datos[2];
      $('#txtIdEstCpt').prop("disabled", false);
      $('#txtIdCpt').prop("disabled", true);

      $('#showCptModal').modal({
        show: true,
        backdrop: 'static',
        focus: true,
      });

      $('#showCptModal').on('shown.bs.modal', function (e) {
        $("#txtDescCpt").trigger('focus');
      })
    }
  });
}

function validForm() {
  var msg = "";
  var sw = true;

  var idCpt = $('#txtIdCpt').val();
  var DescCpt = $('#txtDescCpt').val();
  var estCpt = $('#txtIdEstCpt').val();

  if(idCpt == ""){
    msg+= "Ingrese Código del CPT<br/>";
    sw = false;
  }

  if(DescCpt == ""){
    msg+= "Ingrese descripción del CPT<br/>";
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
        form_data.append('accion', 'POST_ADD_REGCPT');
        form_data.append('txtTipIng', document.frmCpt.txtTipIng.value);
        form_data.append('txtIdCpt',  $('#txtIdCpt').val());
        form_data.append('txtDescCpt', document.frmCpt.txtDescCpt.value);
        form_data.append('txtIdEstCpt', $("#txtIdEstCpt").val());
        form_data.append('rand', myRand);
        $.ajax( {
          url: '../../controller/ctrlCpt.php',
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
              $("#showCptModal").modal('hide');
              bootbox.alert("Registro actualizado correctamente.");
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

var dTable;
//var id_dep= document.getElementById('cboiddep').value;
// #areas-grid adalah id pada table
$(document).ready(function () {
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
  "sAjaxSource": "tbl_principalcpt.php", // Load Data
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
  {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center"},
  {"orderable": true, "targets": 1, "searchable": false, "class": "small"},
  {"orderable": false, "targets": 2, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"}
]
});

$('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');
});

</script>
<?php require_once '../include/masterfooter.php'; ?>

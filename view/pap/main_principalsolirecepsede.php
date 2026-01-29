<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Recepción de muestras de Examen Cérvico Uterino para PAP</strong></h3>
    </div>
    <div class="panel-body">
      <input type="hidden" name="txtIdEnv" id="txtIdEnv" value=""/>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><strong>Bandeja de recepción</strong></h3>
        </div>
        <div class="panel-body">
          <form class="form-horizontal" name="frmBus" id="frmBus" onsubmit="return false;">
            <div class="form-group">
              <div class="col-sm-4 col-md-3">
                Establecimiento de procedencia
                <?php $rsD = $d->get_listaDepenInstitucion(); ?>
                <select name="txtIdDepRef" id="txtIdDepRef" style="width:100%;" class="form-control input-xs"  onkeydown="campoSiguiente('btnBus', event);">
                  <option value="0" selected="">-- Todos --</option>";
                  <?php
                  foreach ($rsD as $row) {
                    echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
                  }
                  ?>
                </select>
                <p class="help-block"><small>Seleccione establecimiento</small></p>
              </div>
              <div class="col-sm-2 col-md-1">
                <br/>
                <button class="btn btn-success btn-sm" type="button" id="btnBus" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
              </div>
              <div class="col-sm-2 col-md-1">
                <br/>
				<button class="btn btn-success btn-sm" style="margin-bottom: 15px;" onclick="open_cargo()"><i class="fa fa-file-pdf-o"></i> Imprimir Cargo</button>
              </div>
            </div>
          </form>
          <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <span class="text-primary"><i class="glyphicon glyphicon-eye-open"></i></span>=Ver planilla de envío | <span style="color: #449d44;"><i class="glyphicon glyphicon-ok"></i></span>=Recepcionar Envío</p>
          <table id="tblSolicitud" class="display" cellspacing="0" width="100%">
            <thead class="bg-primary">
              <tr>
                <th>Fec. Envío<br/>Procedencia</th>
                <th>Establecimiento<br/>Procedencia</th>
                <th>N° Envío</th>
                <th>Estado del<br/>Envío</th>
				<th>Fecha<br/>Obs./Rechazo</th>
                <th>Muestras<br/>Enviadas</th>
                <th><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title"><strong>Bandeja de recibidos</strong></h3>
        </div>
        <div class="panel-body">
          <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <span class="text-primary"><i class="glyphicon glyphicon-eye-open"></i></span>=Ver planilla de envío | <span style="color: #449d44;"><i class="glyphicon glyphicon-send"></i></span>=Enviar a Laboratorio</p>
          <table id="tblEnProceso" class="display" cellspacing="0" width="100%">
            <thead class="bg-green">
              <tr>
                <th>Fec. Envío<br/>Procedencia</th>
                <th>Establecimiento<br/>Procedencia</th>
                <th>N° Envío</th>
                <th>Fecha <br/>Recepción</th>
                <th>Muestras<br/>Enviadas</th>
                <th><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title"><strong>Bandeja de enviados</strong></h3>
        </div>
        <div class="panel-body">
          <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <span class="text-primary"><i class="glyphicon glyphicon-eye-open"></i></span>=Ver planilla de envío</p>
          <table id="tblEnEnvio" class="display" cellspacing="0" width="100%">
            <thead class="bg-aqua">
              <tr>
                <th>Fec. Envío<br/>Procedencia</th>
                <th>Establecimiento<br/>Procedencia</th>
                <th>N° Envío</th>
                <th>Fecha <br/>Recepción</th>
				<th>Fec. Envío<br/>a Lab. Ref</th>
                <th>Muestras<br/>Enviadas</th>
                <th><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-default btn-sm" id="btnBack" type="button" onclick="back();" tabindex="1"><i class="glyphicon glyphicon-log-out"></i> Ir al Menú</button>
    </div>
  </div>

  <div class="modal fade" id="showRecepEnvModal" role="dialog" aria-labelledby="showRecepEnvModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showRecepEnvModalLabel">Recepcionar Envío</h4>
        </div>
        <div class="modal-body">
          <form name="frmRecep" id="frmRecep">
            <label><b>Establecimiento</b></label><br/>
            <label id="lblNomDep"></label><br/>
            <label><b>Nro. envío</b></label><br/>
            <label id="lblNroEnv"></label>

            <div class="form-group">
              <label for="txtNroRegLabDesde"><b>Nro. Desde:</b></label>
              <input type="text" class="form-control input-lg" name="txtNroRegLabDesde" id="txtNroRegLabDesde" value="" maxlength="4"/>
              <p class="help-block">Ingrese Nro.</p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-continuar" id="btnValidFormObs" onclick="reg_recepcion_manual()"><i class="fa fa-save"></i> Recepcionar Envío </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="showObsEnvModal" role="dialog" aria-labelledby="showObsEnvModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showObsEnvModalLabel">Finalizar Envío</h4>
        </div>
        <div class="modal-body">
          <form name="frmObs" id="frmObs">
            <input type="hidden" name="optObsLabEnv" id="optObsLabEnv" value=""/>
            <div id="tipFinaLabEnv">
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-4">
                    <label for="txtNroFichaLabEnv">Nro. Ficha:</label>
                    <input type="text" class="form-control input-xs" name="txtNroFichaLabEnv" id="txtNroFichaLabEnv" value="" maxlength="4"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  <label for="txtDetObsLabEnv">Comentario:</label>
                  <textarea class="form-control" name="txtDetObsLabEnv" id="txtDetObsLabEnv" rows="3"></textarea>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-continuar" id="btnValidFormObs" onclick="save_formfinenv()"><i class="fa fa-save"></i> Finalizar Envío </button>
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
    $("#tblSolicitud").dataTable().fnDraw()
  }

  function open_detalle(idEnv) {
    var urlwindow = "pdf_regenvio.php?idEnv=" + idEnv;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function back() {
    window.location = '../pages/';
  }
  
  function open_cargo(idEnv) {
    var urlwindow = "pdf_cargoenvio.php?idDep=" + $("#txtIdDepRef").val();
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function reg_recepcion(txtIdEnv, nroEnv) {
    bootbox.confirm({
      message: "Se recepcionará el Envio: <b>" + nroEnv + "</b>, ¿Está seguro de continuar?",
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
          $.ajax( {
            type: 'POST',
            url: '../../controller/ctrlPAP.php',
            data: {
              accion: 'POST_ADD_REGENVIORECEPCIONSEDE', txtIdEnv: txtIdEnv,
              rand: myRand,
            },
            success: function(data) {
              var tmsg = data.substring(0, 2);
              var lmsg = data.length;
              var msg = data.substring(3, lmsg);
              //console.log(tmsg);
              if(tmsg == "OK"){
                bootbox.alert({
                  message: "La recepción se ejecuto correctamente",
                  callback: function () {
                    window.location = './main_principalsolirecepsede.php';
                  }
                });
              } else {
                bootbox.alert(msg);
              }
            }
          });
        } else {

        }
      }
    });
  }

   function reg_enviolab(txtIdEnv, nroEnv) {
    bootbox.confirm({
      message: "Se enviará el envío N° <b>" + nroEnv + "</b> a Laboratorio. ¿Está seguro de continuar?",
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
          $.ajax( {
            type: 'POST',
            url: '../../controller/ctrlPAP.php',
            data: {
              accion: 'POST_ADD_REGENVIOALABORATORIO', txtIdEnv: txtIdEnv,
              rand: myRand,
            },
            success: function(data) {
              var tmsg = data.substring(0, 2);
              var lmsg = data.length;
              var msg = data.substring(3, lmsg);
              //console.log(tmsg);
              if(tmsg == "OK"){
                bootbox.alert({
                  message: "El envío se ejecuto correctamente",
                  callback: function () {
                    window.location = './main_principalsolirecepsede.php';
                  }
                });
              } else {
                bootbox.alert(msg);
              }
            }
          });
        } else {

        }
      }
    });
  }

  $(document).ready(function () {
    $("#txtIdDepRef").select2();

    $("body").tooltip({ selector: '[data-toggle=tooltip]' });

    var dTable = $('#tblSolicitud').DataTable({
      "bLengthChange": false, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
      "sAjaxSource": "tbl_principalsolirecepPensede.php", // Load Data
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
        aoData.push({"name": "idDepRef", "value": $("#txtIdDepRef").val()});
		aoData.push({"name": "idEstEnv", "value": '5'});
      },
      "columnDefs": [
        {"orderable": true, "targets": 0, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 1, "searchable": false, "class": "font-weit"},
        {"orderable": false, "targets": 2, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 5, "searchable": false, "class": "text-center"},
		{"orderable": false, "targets": 6, "searchable": false, "class": "large text-center"}
      ]
    });

    $('#tblSolicitud').removeClass('display').addClass('table table-hover table-bordered');

	
    var pTable = $('#tblEnProceso').DataTable({
      "bLengthChange": false, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
      "sAjaxSource": "tbl_principalsolirecepPensede.php", // Load Data
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
        aoData.push({"name": "idDepRef", "value": $("#txtIdDepRef").val()});
		aoData.push({"name": "idEstEnv", "value": '6'});
      },
      "columnDefs": [
        {"orderable": true, "targets": 0, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 1, "searchable": false, "class": "font-weit"},
        {"orderable": false, "targets": 2, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "text-center"},
		{"orderable": false, "targets": 5, "searchable": false, "class": "text-center"}
      ]
    });

    $('#tblEnProceso').removeClass('display').addClass('table table-hover table-bordered');
	
    var pTable = $('#tblEnEnvio').DataTable({
      "bLengthChange": false, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
      "sAjaxSource": "tbl_principalsolirecepPensede.php", // Load Data
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
        aoData.push({"name": "idDepRef", "value": $("#txtIdDepRef").val()});
		aoData.push({"name": "idEstEnv", "value": '1'});
      },
      "columnDefs": [
        {"orderable": true, "targets": 0, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 1, "searchable": false, "class": "font-weit"},
        {"orderable": false, "targets": 2, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "text-center"},
		{"orderable": false, "targets": 5, "searchable": false, "class": "large text-center"},
		{"orderable": false, "targets": 6, "searchable": false, "class": "large text-center"}
      ]
    });

    $('#tblEnEnvio').removeClass('display').addClass('table table-hover table-bordered');	
  });

</script>
<?php require_once '../include/masterfooter.php'; ?>

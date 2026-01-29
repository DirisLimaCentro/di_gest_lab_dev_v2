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
      <h3 class="panel-title"><strong>Recepcionar</strong></h3>
    </div>
    <div class="panel-body">
      <input type="hidden" name="txtIdEnv" id="txtIdEnv" value=""/>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><strong>Bandeja de recepción de envío</strong></h3>
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
            </div>
          </form>
          <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <span class="text-primary"><i class="glyphicon glyphicon-eye-open"></i></span>=Ver planilla de envío | <span style="color: #449d44;"><i class="glyphicon glyphicon-ok"></i></span>=Recepcionar Envío</p>
          <table id="tblSolicitud" class="display" cellspacing="0" width="100%">
            <thead class="bg-primary">
              <tr>
                <th>Establecimiento<br/>Procedencia</th>
                <th>N° Envío</th>
                <th>Fec. Envío<br/>EESS Procedencia</th>
                <th>Muestras<br/>Enviadas</th>
                <th><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <!--<div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title"><strong>Bandeja de clasificación de muestras en proceso</strong></h3>
        </div>
        <div class="panel-body">
          <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <span class="text-primary"><i class="glyphicon glyphicon-eye-open"></i></span>=Ver planilla de envío | <span style="color: #449d44;"><i class="glyphicon glyphicon-ok"></i></span>=Aceptar, observar o rechazar muestras pendientes de recepción | <span style="color: #449d44;"><i class="glyphicon glyphicon-ok-sign"></i></span>=Finalizar envío | <span style="color: #F44336;"><i class="glyphicon glyphicon-refresh"></i></span>=Volver a enumerar envío</p>
          <table id="tblEnProceso" class="display" cellspacing="0" width="100%">
            <thead class="bg-aqua">
              <tr>
                <th>Fec. Envío</th>
                <th>Establecimiento<br/>Procedencia</th>
                <th>N° Envío</th>
                <th>Estado del<br/>Envío</th>
                <th>Muestras<br/> Enviadas</th>
                <th>Muestras<br/>Aceptables</th>
                <th>Muestras<br/>Por subsanar</th>
                <th>Muestras<br/>Rechazadas</th>
                <th>Muestras<br/>Procesadas</th>
                <th>N° de<br/>No conformidades</th>
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
          <h3 class="panel-title"><strong>Bandeja de envíos finalizados</strong></h3>
        </div>
        <div class="panel-body">
          <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-eye-open"></i></button>=Ver planilla de envío | <button class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-open"></i></button>=Imprimir ficha no conformidad | <button class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-print"></i></button>=Imprimir resultados en A4</p>
          <table id="tblFinalizado" class="display" cellspacing="0" width="100%">
            <thead class="bg-green">
              <tr>
                <th>Fecha<br/>Envío</th>
                <th>Fecha<br/>Finalizado</th>
                <th>Establecimiento<br/>Procedencia</th>
                <th>N° Envío</th>
                <th>Muestras<br/>Enviadas</th>
                <th>Muestras<br/>Aceptables</th>
                <th>Muestras<br/>Rechazadas</th>
                <th>Muestras<br/>Procesadas</th>
                <th>N° de No<br/>confor-<br/>midades</th>
                <th style="width: 55px;"><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>-->
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
              <input type="text" class="form-control input-lg" name="txtNroRegLabDesde" id="txtNroRegLabDesde" autocomplete="OFF" value="" maxlength="6"/>
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
                    <input type="text" class="form-control input-xs" name="txtNroFichaLabEnv" id="txtNroFichaLabEnv" value="" maxlength="6"/>
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

  function reg_finalizar(idenv, acc) {
    $('#txtNroFichaLabEnv').val('');
    $("#txtDetObsLabEnv").val('');
    $('#txtIdEnv').val(idenv);
    if(acc=="0"){
      $('#optObsLabEnv').val('NF');
      $('#tipFinaLabEnv').hide();
    } else {
      $('#optObsLabEnv').val('SF');
      $('#tipFinaLabEnv').show();
    }

    $('#showObsEnvModal').modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });

    if(acc=="0"){
      $('#showObsEnvModal').on('shown.bs.modal', function (e) {
        $("#txtDetObsLabEnv").trigger('focus');
      })
    } else {
      $('#showObsEnvModal').on('shown.bs.modal', function (e) {
        $("#txtNroFichaLabEnv").trigger('focus');
      })
    }
  }

  function open_detalle(idEnv) {
    var urlwindow = "pdf_regenvio.php?idEnv=" + idEnv;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function open_noconfor(idEnv) {
    var urlwindow = "pdf_papnoconfor.php?idEnv=" + idEnv;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function back() {
    window.location = '../pages/';
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
            url: '../../controller/ctrlBacteriologia.php',
            data: {
              accion: 'POST_ADD_REGENVIORECEPCIONLABREF', txtIdEnv: txtIdEnv,
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
                    //window.location = './main_regrecepcion.php?envivo=' +  txtIdEnv;
					buscar_datos();
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

  function show_recepcion_manual(txtIdEnv, nomDep, nroEnv) {
    $("#txtIdEnv").val(txtIdEnv);
    $('#showRecepEnvModal').modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });

    $('#showRecepEnvModal').on('shown.bs.modal', function (e) {
      $("#lblNomDep").text(nomDep);
      $("#lblNroEnv").text(nroEnv);
      $("#txtNroRegLabDesde").trigger('focus');
    });
  }

  function reg_recepcion_manual() {
    var txtIdEnv = $("#txtIdEnv").val();
    var nroEnv = $("#lblNroEnv").text();
    var txtNroRegLab = $("#txtNroRegLabDesde").val();
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
              accion: 'POST_ADD_REGENVIORECEPCIONMANUAL', txtIdEnv: txtIdEnv, txtNroRegLab: txtNroRegLab,
              rand: myRand,
            },
            success: function(data) {
              var tmsg = data.substring(0, 2);
              var lmsg = data.length;
              var msg = data.substring(3, lmsg);
              //console.log(tmsg);
              if(tmsg == "OK"){
                /*bootbox.alert({
                  message: "La recepción se ejecuto correctamente",
                  callback: function () {
                    window.location = './main_regrecepcion.php?envivo=' +  txtIdEnv;
                  }
                });*/
                window.location = './main_regrecepcion.php?envivo=' +  txtIdEnv + '&id='+myRand;
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

  function reg_proceso(txtIdEnv) {
    window.location = './main_regrecepcion.php?envivo=' +  txtIdEnv;
  }


    function open_pdfresultot(idSoli, tipo) {
      if(tipo=="E"){
        var urlwindow = "pdf_resulttot.php?id_envio=" + idSoli;
      } else {
        var urlwindow = "pdf_resulttot.php?id_solicitud=" + idSoli;
      }
      day = new Date();
      id = day.getTime();
      Xpos = (screen.width / 2) - 390;
      Ypos = (screen.height / 2) - 300;
      eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
    }

  function save_formfinenv() {
    //$('#btnValidFormObs').prop("disabled", true);
    var msg = "";
    var sw = true;

    var optObsLabEnv = $('#optObsLabEnv').val();
    var txtNroFichaLabEnv = $('#txtNroFichaLabEnv').val();
    var txtDetObsLabEnv = $('#txtDetObsLabEnv').val();
    if(optObsLabEnv == "SF"){
      if(txtNroFichaLabEnv == ""){
        msg+= "Ingrese número de Ficha de Reporte<br/>";
        sw = false;
      }
    }

    if (sw == false) {
      bootbox.alert(msg);
      $('#btnValidFormObs').prop("disabled", false);
      return sw;
    }

    bootbox.confirm({
      message: "Se finalizará el Envio, ¿Está seguro de continuar?",
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
          var txtIdEnv = $('#txtIdEnv').val();
          var optObsLabEnv = $('#optObsLabEnv').val();
          var txtNroFichaLabEnv = $('#txtNroFichaLabEnv').val();
          var txtDetObsLabEnv = $('#txtDetObsLabEnv').val();
          $.ajax( {
            type: 'POST',
            url: '../../controller/ctrlPAP.php',
            data: {
              accion: 'POST_ADD_REGFINALIZAENVIO', txtIdEnv: txtIdEnv, optObsLabEnv: optObsLabEnv, txtNroFichaLabEnv: txtNroFichaLabEnv, txtDetObsLabEnv: txtDetObsLabEnv,
              rand: myRand,
            },
            success: function(data) {
              var tmsg = data.substring(0, 2);
              var lmsg = data.length;
              var msg = data.substring(3, lmsg);
              //console.log(tmsg);
              if(tmsg == "OK"){
                $("#showObsEnvModal").modal('hide');
                //bootbox.alert("El envio fue finalizado correctamente");
              } else {
                bootbox.alert(msg);
              }
            }
          });
          $('#btnValidFormObs').prop("disabled", false);
          $("#tblEnProceso").dataTable().fnDraw();
          $("#tblFinalizado").dataTable().fnDraw();
        } else {
          $('#btnValidFormObs').prop("disabled", false);
        }
      }
    });
  }


  $(function() {
    jQuery('#txtNroFichaLabEnv').keypress(function (tecla) {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
      return false;
    });
  });

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
      "sAjaxSource": "tbl_principallabrefrecepPen.php", // Load Data
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
		aoData.push({"name": "id_servicio_origen", "value": "2"});
      },
      "columnDefs": [
        {"orderable": true, "targets": 0, "searchable": false, "class": "font-weit"},
        {"orderable": false, "targets": 1, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 2, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "text-center"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "large text-center"}
      ]
    });
	
    $('#tblSolicitud').removeClass('display').addClass('table table-hover table-bordered');

	/*
    var pTable = $('#tblEnProceso').DataTable({
      "bLengthChange": true, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
      "sAjaxSource": "tbl_principalsolirecepPro.php", // Load Data
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

      },
      "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
        if ( aData[6] != "<span class=\"badge bg-yellow\">0</span>" ){
          $('td', nRow).addClass('warning');
        }
        console.log(aData[10].indexOf("Finalizar envío"));

        if (aData[10].indexOf("Finalizar envío") != "-1"){
          $('td', nRow).addClass('success');
        }
      },
      "columnDefs": [
        {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 1, "searchable": false, "class": "small font-weit"},
        {"orderable": false, "targets": 2, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 8, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 9, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 10, "searchable": false, "class": "large text-center"}
      ]
    });

    $('#tblEnProceso').removeClass('display').addClass('table table-hover table-bordered');

    var fTable = $('#tblFinalizado').DataTable({
      "bLengthChange": true, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
      "sAjaxSource": "tbl_principalsolirecepFin.php", // Load Data
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
      },
      "columnDefs": [
        {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center"},
        {"orderable": true, "targets": 1, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 2, "searchable": false, "class": "small  font-weit"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 8, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 9, "searchable": false, "class": "small text-center"}
      ],
	  "order": [[ 2, "desc" ]]
    });

    $('#tblFinalizado').removeClass('display').addClass('table table-hover table-bordered');
	*/
  });

</script>
<?php require_once '../include/masterfooter.php'; ?>

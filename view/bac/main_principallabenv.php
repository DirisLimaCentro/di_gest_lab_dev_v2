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
      <h3 class="panel-title"><strong>ENVÍO DE MUESTRAS A LABORATORIO REFERENCIAL</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-10">
          <form class="form-horizontal" name="frmBus" id="frmBus" onsubmit="return false;">
            <div class="form-group">
              <div class="col-sm-3 col-md-2">
                <label for="txtBusAnioAsis"><small>Fecha Inicio:</small></label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y"); ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtBusFecFin', event);"/>
                </div>
              </div>
              <div class="col-sm-3 col-md-2">
                <label for="txtBusAnioAsis"><small>Fecha Final:</small></label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtBusNroEnv', event);"/>
                </div>
              </div>
              <div class="col-sm-2 col-md-1">
                <br/>
				<input type="hidden" name="txtBusNroEnv" id="txtBusNroEnv" autocomplete="OFF" maxlength="10" value=""/>
                <button class="btn btn-success" type="button" id="btnBus" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
              </div>
            </div>
          </form>
          <br/>
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>Bandeja de enviados</strong></h3>
            </div>
            <div class="panel-body">
              <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <!--<button class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-pencil"></i></button>=Editar Envío | --><button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-eye-open"></i></button>=Imprimir planilla de envío</p>
              <table id="tblSolicitud" class="display" cellspacing="0" width="100%">
                <thead class="bg-primary">
                  <tr>
                    <th><small>N° Envío</small></th>
                    <th><small>Fec. Envío</small></th>
                    <th><small>Nro.<br/>Enviados</small></th>
                    <th><small>Nro.<br/>Finalizados</small></th>
                    <th><small>Estado</small></th>
                    <th><small><i class="fa fa-cogs"></i></small></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
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
              <p><b>Botones de acci&oacute;n:</b></p>
              <div class="row">
                <button class="btn btn-primary btn-lg" style="margin-bottom: 15px;" onclick="reg_envio()"><i class="glyphicon glyphicon-plus"></i> Registrar Envío</button>
              </div>
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once '../include/footer.php'; ?>

  <script Language="JavaScript">



  function expo_notif() {
/*    var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();

    var msg = "";
    var sw = true;

    if (fecIni != "") {
      if (fecFin == "") {
        msg+= "Ingrese Fecha Final<br/>";
        sw = false;
      }
    }

    if (sw == false) {
      bootbox.alert(msg);
      return false;
    }
*/
    window.location = './xls_repdatosnotif.php?anio=' + $("#txtBusFecAnioNotif").val();

  }

  function open_detalle(idEnv) {
    var urlwindow = "pdf_regenvio.php?idEnv=" + idEnv;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function open_cargo(idEnv) {
    var urlwindow = "pdf_cargoenvio.php?idDep=0";
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function open_pdfsinvalor(idSoli) {
    var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
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

  function campoSiguiente(campo, evento) {
    if (evento.keyCode == 13 || evento.keyCode == 9) {
      if (campo == 'btnBus') {
        buscar_datos();
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    }
  }

  function back() {
    window.location = '../pages/';
  }

  function reg_envio() {
    window.location = './main_regenviolab.php';
  }

  function open_editar(idEnv) {
    window.location = './main_editenvio.php?envio='+idEnv;
  }

  function open_detalleestados(idEnv, opt) {
    if(opt == "P"){
      window.location = './main_listaenvio.php?envio='+idEnv;
    } else {
      window.location = './main_listaenvioFin.php?envio='+idEnv;
    }
  }

  function buscar_datos() {
    var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();
    var nomEnv = $("#txtBusNroEnv").val();

    if (nomEnv == "") {
      if (fecFin == "") {
        $('#infoModalAlert').text('Ingrese almenos un parametro de ingreso: Nombre o Raz\xf3n Social o Rango de Fechas.');
        return false;
      }
    }

    if (fecIni != "") {
      if (fecFin == "") {
        $('#infoModalAlert').text('Ingrese Fecha Final.');
        return false;
      }
    }

    if (fecIni != "") {
      if (validarFormatoFecha(fecIni) == false) {
        $('#infoModalAlert').text('Ingrese Fecha de Inicio Correctamente.');
        return false;
      }
    }
    if (fecFin != "") {
      if (validarFormatoFecha(fecFin) == false) {
        $('#infoModalAlert').text('Ingrese Fecha Final Correctamente.');
        $('#alertModal').modal("show");
        return false;
      }
    }

    f1 = fecIni.split("/");
    f2 = fecFin.split("/");

    var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
    var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

    if (f1 > f2) {
      $('#infoModalAlert').text('La Fecha de Incio debe ser menor o igual a la fecha Final.');
      $('#alertModal').modal("show");
      return false;
    }

    $("#tblSolicitud").dataTable().fnDraw();
    $("#tblEnProceso").dataTable().fnDraw();
    $("#tblFinalizado").dataTable().fnDraw();
  }

  $(document).ready(function () {

    $("#txtBusFecIni").datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
    });
    $("#txtBusFecFin").datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
    });


    var dTableS = $('#tblSolicitud').DataTable({
      "bLengthChange": false, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
      "sAjaxSource": "tbl_principallabenv.php", // Load Data
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
        aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
        aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
        aoData.push({"name": "nroEnv", "value": $("#txtBusNroEnv").val()});
        aoData.push({"name": "estEnv", "value": ""});

      },
      /*"fnServerParams": function ( aoData ) {
      aoData.push( { "name": "id_tabla", "value": $('#cboiddep').val() } );
    },*/

    "columnDefs": [
      {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center font-weit"},
      {"orderable": false, "targets": 1, "searchable": false, "class": "small text-center"},
      {"orderable": false, "targets": 2, "searchable": false, "class": "small text-center"},
      {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"},
      {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center font-weit"},
      {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
    ],
    "order": [[ 0, "desc" ]]
  });

  $('#tblSolicitud').removeClass('display').addClass('table table-hover table-bordered');

});

</script>
<?php require_once '../include/masterfooter.php'; ?>

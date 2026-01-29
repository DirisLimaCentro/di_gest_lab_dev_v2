<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Registro de Referencia a Laboratorio</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-10">
          <form class="form-horizontal" name="frmRepPrin" id="frmRepPrin" onsubmit="return false;">
            <input type="hidden" name="idDepQuejaPer" id="idDepQuejaPer" value="<?php if ($acceSelecDep <> "1") echo $saaIdDep; ?>"/>
            <div class="form-group">
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtIdTipDoc"><small>Documento de identidad</small></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-sm">
                      <div class="input-group-addon" style="padding: 0!important;">
                        <?php $rsT = $t->get_ListaTipoDocPerNatu(); ?>
                        <select name="txtvIdTipDoc" style="width:100%;" id="txtBusIdTipDoc" onchange="maxlength_doc_bus()">
                          <?php
                          foreach ($rsT as $row) {
                            echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <input type="text" name="txtBusNroDoc" placeholder="Número de documento" required="" id="txtBusNroDoc" class="form-control input-sm" maxlength="8" onkeydown="campoSiguiente('txtBusNomRS', event);"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-5 col-md-5">
                <label for="txtBusNomRS"><small>Nombres o Apellidos del paciente:</small></label>
                <input class="form-control input-sm" type="text" name="txtBusNomRS" id="txtBusNomRS" autocomplete="OFF" maxlength="150" required="" tabindex="0" onkeydown="campoSiguiente('btnBus', event);"/>
              </div>
              <div class="col-sm-1 col-md-1">
                <br/>
                <button class="btn btn-success btn-sm" type="button" id="btnBus" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
              </div>
              <div class="col-sm-4 col-md-4">
                <br/>
                <button id="btnRegistrarAsis" class="btn btn-warning pull-right btn-sm" type="button" onclick="exportar_busqueda();" tabindex="0"><i class="glyphicon glyphicon-open"></i> Exportar a Excel</button>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2 col-md-2">
                <label for="txtBusAnioAsis"><small>Fecha Inicio:</small></label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right input-sm" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y"); ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtBusFecFin', event);"/>
                </div>
              </div>
              <div class="col-sm-2 col-md-2">
                <label for="txtBusAnioAsis"><small>Fecha Final:</small></label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right input-sm" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask data-mask onkeydown="campoSiguiente('txtBusNroFUA', event);"/>
                </div>
              </div>
              <div class="col-sm-2 col-md-2">
                <label for="txtBusNroFUA"><small>Nro FUA:</small></label>
                  <input type="text" class="form-control input-sm" name="txtBusNroFUA" id="txtBusNroFUA" autocomplete="OFF" maxlength="10" value="" onkeydown="campoSiguiente('btnBus', event);"/>
              </div>
            </div>
          </form>
          <br/>
          <table id="tblAtencion" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th><small>N° FUA</small></th>
                <th><small>Paciente</small></th>
                <th><small>HC</small></th>
                <th><small>Nombre y Apellidos</small></th>
                <th><small>Profesional</small></th>
                <th><small>Fecha</small></th>
                <th><small>Hora</small></th>
                <th><small>Estado</small></th>
                <th><small>&nbsp;</small></th>
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
                  <b>Visualizar FUA:</b>
                  <ul class="list-unstyled">
                    <li><button class="btn btn-primary btn-xs" style="cursor: default;"><i class="glyphicon glyphicon-eye-open"></i></button></li>
                  </ul>
                </li>
                <li>
                  <b>Visualizar Análisis:</b>
                  <ul class="list-unstyled">
                    <li><button class="btn btn-success btn-xs" style="cursor: default;"><i class="fa fa-file-text-o"></i></button></li>
                  </ul>
                </li>
              </ul>
              <p><b>Botones de acci&oacute;n:</b></p>
              <div class="row">
                <button class="btn btn-primary btn-sm" style="margin-bottom: 15px;" onclick="reg_analisis()"><i class="glyphicon glyphicon-plus"></i> Registrar Referencia</button>
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
  <?php require_once '../include/footer.php'; ?>
  <script Language="JavaScript">
function buscar_datos() {
    var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();
    var nomRS = $("#txtBusNomRS").val();
    nomRS = nomRS.replace("%", "");

    $('#titleModalAlert').text('Mensaje de Alerta ...');
    if (nomRS == "") {
        if (fecFin == "") {
            $('#infoModalAlert').text('Ingrese almenos un parametro de ingreso: Nombre o Raz\xf3n Social o Rango de Fechas.');
            $('#alertModal').modal("show");
            return false;
        }
    }

    if (fecIni != "") {
        if (fecFin == "") {
            $('#infoModalAlert').text('Ingrese Fecha Final.');
            $('#alertModal').modal("show");
            return false;
        }
    }

    if (fecIni != "") {
        if (validarFormatoFecha(fecIni) == false) {
            $('#infoModalAlert').text('Ingrese Fecha de Inicio Correctamente.');
            $('#alertModal').modal("show");
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

    $("#tblAtencion").dataTable().fnDraw()
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

function reg_analisis() {
  window.location = './main_regsolicitud.php';
}

function open_fua(id) {
  window.location = '../fua/genera_fuaxls.php?nroAtencion='+id;
}

function open_pdf(idAten) {

  var urlwindow = "pdf_laboratorio.php?id_atencion=" + idAten +"&id_area=0";
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function back() {
  window.location = '../pages/';
}

var dTable;
//var id_dep= document.getElementById('cboiddep').value;
// #areas-grid adalah id pada table
$(document).ready(function () {
  $("#txtBusIdTipDoc").select2();

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
  "sAjaxSource": "tbl_principalsoli.php", // Load Data
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
    aoData.push({"name": "idTipDoc", "value": $("#txtBusIdTipDoc").val()});
    aoData.push({"name": "nroDoc", "value": $("#txtBusNroDoc").val()});
    aoData.push({"name": "nomRS", "value": $("#txtBusNomRS").val()});
    aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
    aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
    aoData.push({"name": "nroFUA", "value": $("#txtBusNroFUA").val()});

  },
  /*"fnServerParams": function ( aoData ) {
  aoData.push( { "name": "id_tabla", "value": $('#cboiddep').val() } );
},*/

"columnDefs": [
  {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center font-weit"},
  {"orderable": true, "targets": 1, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 2, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 3, "searchable": false, "class": "small"},
  {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 8, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 9, "searchable": false, "class": "small text-center"}
]
});

$('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');
});
</script>
<?php require_once '../include/masterfooter.php'; ?>

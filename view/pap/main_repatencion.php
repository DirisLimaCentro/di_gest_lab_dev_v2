<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';
require_once '../../model/UnidadMedida.php';
$um = new UnidadMedida();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Reporte de Atenciones</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3">
          <div class="box box-success">
            <br/>
            <div class="box-body box-profile">
              <h3 class="profile-username text-center">Atenciones</h3>
              <div id="cntAtencion"></div>
            </div>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="box box-primary">
            <br/>
            <form name="frmBus" id=frmBus>
              <div class="row">
                <div class="form-group">
                  <div class="col-sm-2 col-md-2">
                    <label for="txtBusAnioAsis"><small>Fecha Inicio:</small></label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right input-sm" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguientePersona('txtBusFecFin', event);"/>
                    </div>
                  </div>
                  <div class="col-sm-2 col-md-2">
                    <label for="txtBusAnioAsis"><small>Fecha Final:</small></label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right input-sm" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                    </div>
                  </div>
                  <div class="col-sm-1 col-md-1">
                    <br/>
                    <button class="btn btn-success btn-sm" type="button" id="btnCon" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                  </div>
                  <div class="col-sm-2 col-md-2">
                    <br/>
                    <button class="btn btn-primary btn-sm" type="button" id="btnCon" onclick="restablecer();" tabindex="0"><i class="glyphicon glyphicon-ok"></i> Restablecer</button>
                  </div>
                  <div class="col-sm-3 col-md-3">
                    <br/>
                    <button id="btnRegistrarAsis" class="btn btn-warning pull-right btn-sm" type="button" onclick="exportar_datos();" tabindex="0"><i class="glyphicon glyphicon-open"></i> Exportar a Excel</button>
                  </div>
                </div>
              </div>
            </form>
            <br/>
            <table id="tblAtencion" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Nro.<br/>Orden</th>
                  <th>Paciente</th>
                  <th>Documento<br/>Identidad</th>
                  <th>Estado<br/>Resultado</th>
                  <th>Resultado</th>
                  <th>Profesional</th>
                  <th>Fecha<br/>registro</th>
                  <th style="width:15px;"><i class="fa fa-cogs"></i></th>
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
      <button type="button" class="btn btn-info pull-right" id="btnBackForm" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Ir al Menú</button>
    </div>
  </div>
</div>
<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">

function buscar_datos() {
  var fecIni = $("#txtBusFecIni").val();
  var fecFin = $("#txtBusFecFin").val();

  var msg = "";
  var sw = true;

  if (fecIni != "") {
    if (fecFin == "") {
      msg+= "Ingrese Fecha Final<br/>";
      sw = false;
    }
  }

  if (fecIni != "") {
    if (validarFormatoFecha(fecIni) == false) {
      msg+= "Ingrese Fecha de Inicio Correctamente<br/>";
      sw = false;
    }
  }
  if (fecFin != "") {
    if (validarFormatoFecha(fecFin) == false) {
      msg+= "Ingrese Fecha Final Correctamente<br/>";
      sw = false;
    }
  }

  f1 = fecIni.split("/");
  f2 = fecFin.split("/");

  var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
  var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

  if (f1 > f2) {
    msg+= "La Fecha de Incio debe ser menor o igual a la fecha Final<br/>";
    sw = false;
  }

  if (sw == false) {
    bootbox.alert(msg);
    return false;
  }

  buscar_datosestados();
  $("#tblAtencion").dataTable().fnDraw();
}

function exportar_datos() {
  var fecIni = $("#txtBusFecIni").val();
  var fecFin = $("#txtBusFecFin").val();

  var msg = "";
  var sw = true;

  if (fecIni != "") {
    if (fecFin == "") {
      msg+= "Ingrese Fecha Final<br/>";
      sw = false;
    }
  }

  if (fecIni != "") {
    if (validarFormatoFecha(fecIni) == false) {
      msg+= "Ingrese Fecha de Inicio Correctamente<br/>";
      sw = false;
    }
  }
  if (fecFin != "") {
    if (validarFormatoFecha(fecFin) == false) {
      msg+= "Ingrese Fecha Final Correctamente<br/>";
      sw = false;
    }
  }

  f1 = fecIni.split("/");
  f2 = fecFin.split("/");

  var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
  var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

  if (f1 > f2) {
    msg+= "La Fecha de Incio debe ser menor o igual a la fecha Final<br/>";
    sw = false;
  }

  if (sw == false) {
    bootbox.alert(msg);
    return false;
  }

  window.location = './xls_replabatencion.php?fecIni=' + $("#txtBusFecIni").val() + '&fecFin=' + $("#txtBusFecFin").val();

}

function buscar_datosestados(){
  $.ajax({
    url: "../../controller/ctrlPAP.php",
    type: "POST",
    data: {
      accion: 'GET_CNTATENCIONLABESTADOSPORFECHA', fecIni: $("#txtBusFecIni").val(), fecFin: $("#txtBusFecFin").val()
    },
    success: function (registro) {
      $("#cntAtencion").html(registro);
    }
  });
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

$(document).ready(function () {
  buscar_datosestados();
  $("#txtBusFecIni").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });
  $("#txtBusFecFin").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });

  var dTable = $('#tblAtencion').DataTable({
    /*"language": {
    "url": "../plugins/datatables/Spanish.json"
  },*/
  "bLengthChange": true, //Paginado 10,20,50 o 100
  "bProcessing": true,
  "bServerSide": true,
  "bJQueryUI": false,
  "responsive": true,
  "bInfo": true,
  "bFilter": true,
  "sAjaxSource": "tbl_repatencion.php", // Load Data
  "language": {
    "url": "../../assets/plugins/datatables/Spanish.json",
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
    aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
    aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
  },
  "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
      /* Append the grade to the default row class name */
      if ( aData[2] == "POSITIVO" ){
          //$(nRow).find('td:eq(2)').css('color', 'red');
          $('td', nRow).addClass('danger');
      } else if ( aData[2] == "RECHAZADA" ){
          $('td', nRow).addClass('warning');
      } else if ( aData[2] == "NEGATIVO" ){
          $('td', nRow).addClass('success');
      } else if ( aData[2] == "INSATISFACTORIA" ){
          $('td', nRow).addClass('active');
      } else if ( (aData[2] == "PARA SUBSANAR") || (aData[2] == "SUBSANADO")){
          $('td', nRow).addClass('info');
      }
  },
  "columnDefs": [
    {"orderable": true, "targets": 0, "searchable": true, "class": "small text-center"},
    {"orderable": false, "targets": 1, "searchable": false, "class": "small"},
    {"orderable": true, "targets": 2, "searchable": false, "class": "small text-center text-bold"},
    {"orderable": true, "targets": 3, "searchable": false, "class": "small text-center"},
    {"orderable": true, "targets": 4, "searchable": false, "class": "small text-center"},
    {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
    {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
    {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"},
  ]
});

$('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');
});
</script>
<?php require_once '../include/masterfooter.php'; ?>

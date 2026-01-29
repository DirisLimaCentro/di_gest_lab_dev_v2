<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';
require_once '../../model/Profesional.php';
$prof = new Profesional();
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
              <div class="form-group">
              <button type="button" class="btn btn-success btn-block" onclick="exportar_datos()"><i class="fa fa-file-excel-o"></i> Exportar detalle</button>
            </div>
              <div id="show-btncnt" style="display:none;">
                <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" onclick="exportar_cntdiario()"><i class="fa fa-file-excel-o"></i> Exportar cantidad por día</button>
                </div>
              </div>
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
                    <label for="txtBusTipoFec"><small>Tipo Fecha:</small></label>
                    <select name="txtBusTipoFec" id="txtBusTipoFec" class="form-control" onchange="show_cntdiario()">
                      <option value="1">Fecha Recepción</option>
                      <option value="2" <?php if($labIdRolUser == "9") echo " selected"?>>Fecha Resultado</option>
                    </select>
                  </div>
                  <div class="col-sm-2 col-md-2">
                    <label for="txtBusFecIni"><small>Fecha Inicio:</small></label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguientePersona('txtBusFecFin', event);"/>
                    </div>
                  </div>
                  <div class="col-sm-2 col-md-2">
                    <label for="txtBusFecFin"><small>Fecha Final:</small></label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                    </div>
                  </div>
                  <div class="col-sm-3 col-md-3">
                    <label for="txtIdProfesional"><small>Realizado Por:</small></label>
                    <?php $rsP = $prof->get_ListaProfesionalResulPAP(); ?>
                    <select name="txtBusIdProfe" id="txtBusIdProfe" class="form-control"  <?php if($labIdRolUser == "9") echo " disabled"?>>
                      <option value="">Todos</option>
                      <?php
                      foreach ($rsP as $row) {
                        echo "<option value='" . $row['id_usuario'] . "'"; if($labIdRolUser == "9") if($row['id_usuario'] == $labIdUser) echo "selected"; echo ">" . $row['primer_ape'] . " " . $row['segundo_ape'] . " " . $row['nombre_rs'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-sm-1 col-md-1">
                    <br/>
                    <button class="btn btn-success btn-block" type="button" id="btnCon" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                  </div>
                  <!--<div class="col-sm-2 col-md-2">
                    <br/>
                    <button class="btn btn-primary btn-sm" type="button" id="btnCon" onclick="restablecer();" tabindex="0"><i class="glyphicon glyphicon-ok"></i> Restablecer</button>
                  </div>-->
                </div>
              </div>
            </form>
            <br/>
            <table id="tblAtencion" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Fec. Recep</th>
                  <th>Procedencia</th>
                  <th>Nro. Lámina<br/><Laboratorio</th>
                  <th>Resultado</th>
                  <th>Bethesda</th>
                  <th>Fec. Resul.</th>
                  <th>Validado</th>
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

<div id="mostrar_resulinicial" class="modal fade" role="dialog" data-backdrop="static"></div>
<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">

function open_resulinicial(id){
  $('#mostrar_resulinicial').modal('show');
  $.ajax({
    url: '../../controller/ctrlPAP.php',
    type: 'POST',
    data: 'accion=GET_SHOW_RESULINICIALVALID&idResul=' + id,
    success: function(data){
      $('#mostrar_resulinicial').html(data);
    }
  });
}

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

  window.location = './xls_replabatencion.php?tipoFec=' + $("#txtBusTipoFec").val() + '&fecIni=' + $("#txtBusFecIni").val() + '&fecFin=' + $("#txtBusFecFin").val() + '&idProfe=' + $("#txtBusIdProfe").val();

}

function exportar_cntdiario() {
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

  window.location = './xls_replabatencioncntdiario.php?fecIni=' + $("#txtBusFecIni").val() + '&fecFin=' + $("#txtBusFecFin").val() + '&idProfe=' + $("#txtBusIdProfe").val();

}


function buscar_datosestados(){
  $.ajax({
    url: "../../controller/ctrlPAP.php",
    type: "POST",
    data: {
      accion: 'GET_CNTATENCIONLABESTADOSPORFECHA', tipoFec: $("#txtBusTipoFec").val(), fecIni: $("#txtBusFecIni").val(), fecFin: $("#txtBusFecFin").val(), idProfe: $("#txtBusIdProfe").val()
    },
    success: function (registro) {
      $("#cntAtencion").html(registro);
    }
  });
}

function open_fua(id) {
  window.location = '../fua/genera_fuaxls.php?nroAtencion='+id;
}

function open_pdfsinvalor(idSoli) {

  var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function open_pdfresulsinvalor(idSoli) {

  var urlwindow = "pdf_resulsinvalor.php?id_solicitud=" + idSoli;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function back() {
  window.location = '../pages/';
}

function show_cntdiario() {
  if($("#txtBusTipoFec").val() == "2"){
    $("#show-btncnt").show();
  } else {
    $("#show-btncnt").hide();
  }
}

$(document).ready(function () {
  buscar_datosestados();
  <?php if($labIdRolUser == "9"){?>
  show_cntdiario();
  <?php }?>
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
  "sAjaxSource": "tbl_replabatencion.php", // Load Data
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
    aoData.push({"name": "tipoFec", "value": $("#txtBusTipoFec").val()});
    aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
    aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
    aoData.push({"name": "idProfe", "value": $("#txtBusIdProfe").val()});
  },
  "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
      /* Append the grade to the default row class name */
      if ( aData[3] == "POSITIVO" ){
          //$(nRow).find('td:eq(2)').css('color', 'red');
          $('td', nRow).addClass('danger');
      } else if ( aData[3] == "RECHAZADA" ){
          $('td', nRow).addClass('warning');
      } else if ( aData[3] == "NEGATIVO" ){
          $('td', nRow).addClass('success');
      } else if ( aData[3] == "INSATISFACTORIA" ){
          $('td', nRow).addClass('active');
      } else if ( (aData[3] == "PARA SUBSANAR") || (aData[2] == "SUBSANADO")){
          $('td', nRow).addClass('info');
      }
  },
  "columnDefs": [
    {"orderable": true, "targets": 0, "searchable": true, "class": "small text-center"},
    {"orderable": false, "targets": 1, "searchable": false, "class": "small"},
    {"orderable": false, "targets": 2, "searchable": false, "class": "small text-center text-bold"},
    {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"},
    {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
    {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
    {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center text-bold"},
    {"orderable": false, "targets": 7, "searchable": false, "class": "text-center"},
  ]
});

$('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');
});
</script>
<?php require_once '../include/masterfooter.php'; ?>

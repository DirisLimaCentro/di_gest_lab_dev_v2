<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
?>
<style>

div.dt-buttons {
  float: left;
}
div.dataTables_length {
  float: right;
  text-align: right;
}
div.dataTables_info {
  float: left;
}
div.dataTables_paginate paging_simple_numbers {
  float: right;
  text-align: right;
}

@media screen and (max-width: 450px) {
  div.dt-buttons {
    float: none;
    text-align: center;
  }
  div.dataTables_length {
    float: none;
  }
  div.dataTables_info {
    float: none;
  }
  div.dataTables_paginate paging_simple_numbers {
    float: none;
  }
}

</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Registro de Toma de imagen Rx</strong></h3>
    </div>
    <div class="panel-body">
      <fieldset class="scheduler-border">
    <legend class="scheduler-border">Buscar atención</legend>
      <form class="form-horizontal" name="frmRepPrin" id="frmRepPrin" onsubmit="return false;">
        <input type="hidden" name="idDepQuejaPer" id="idDepQuejaPer" value="<?php if ($acceSelecDep <> "1") echo $saaIdDep; ?>"/>
        <input type="hidden" name="txtIdPap" id="txtIdPap" value=""/>
        <input type="hidden" name="txtTipAcc" id="txtTipAcc" value=""/>
        <div class="form-group">
          <div class="col-sm-4 col-md-3">
            <div class="row">
              <div class="col-sm-12">
                <label for="txtIdTipDoc"><small>Documento de identidad</small></label>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
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
                  <input type="text" name="txtBusNroDoc" placeholder="Número de documento" required="" id="txtBusNroDoc" class="form-control input-sm" maxlength="8" onkeydown="campoSiguiente('btnBus', event);"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4 col-md-3">
            <label for="txtBusNomRS"><small>Nombres o Apellidos del paciente:</small></label>
            <input class="form-control input-sm text-uppercase" type="text" name="txtBusNomRS" id="txtBusNomRS" autocomplete="OFF" maxlength="50" required="" tabindex="0" onkeydown="campoSiguiente('btnBus', event);"/>
          </div>
          <div class="col-sm-3 col-md-2">
            <label for="txtBusAnioAsis"><small>Fecha Inicio:</small></label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="glyphicon glyphicon-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right input-sm" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y"); ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtBusFecFin', event);"/>
            </div>
          </div>
          <div class="col-sm-3 col-md-2">
            <label for="txtBusAnioAsis"><small>Fecha Final:</small></label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="glyphicon glyphicon-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right input-sm" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('btnBus', event);"/>
            </div>
          </div>
          <div class="col-sm-2 col-md-1">
            <br/>
            <button class="btn btn-success btn-sm" type="button" id="btnBus" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
          </div>
        </div>
      </form>
    </fieldset>
      <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <a style="color: #449d44;"><i class="glyphicon glyphicon-pencil"></i></a>=Editar atención | <a style="color: #00c0ef;"><i class="glyphicon glyphicon-eye-open"></i></a>=Ver ficha de atención | <a style="color: #1D71B8;"><i class="glyphicon glyphicon-list-alt"></i></a>=Ver lista de archivos</p>
      <br/>
      <table id="tblSolicitud" class="display" cellspacing="0" width="100%">
        <thead class="bg-aqua">
          <tr>
            <th>N°<br/>Atención</th>
            <th>Nombre del Paciente</th>
            <th style="width: 80px;">Documento<br/>de Identidad</th>
            <th>HC</th>
            <th>Profesional de Salud</th>
            <th style="width: 60px;">Fecha<br/>Registro</th>
            <th>Estado<br/>Registro</th>
            <th>Estado<br/>Lectura</th>
            <th style="width: 50px;">Nro.<br/>Archivos</th>
            <th style="width: 55px;"><i class="fa fa-cogs"></i></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <button class="btn btn-default btn-sm" id="btnBack" type="button" onclick="back();" tabindex="1"><i class="glyphicon glyphicon-log-out"></i> Ir al Men&uacute;</button>
    </div>
  </div>
  <?php require_once '../include/footer.php'; ?>
  <script Language="JavaScript">

  function open_pdfsinvalor(idSoli) {

    var urlwindow = "pdf_constanciaits.php?id_solicitud=" + idSoli;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }


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

    $("#tblSolicitud").dataTable().fnDraw()
  }

  function exporbuscar_datos() {
    var idTipDoc = $("#txtBusIdTipDoc").val();
    var nroDoc = $("#txtBusNroDoc").val();
    var nomRS = $("#txtBusNomRS").val();
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

    var urlwindow = "pdf_principalsoli.php?idTipDoc=" + idTipDoc + "&nroDoc=" + nroDoc + "&nomRS="+ nomRS + "&fecIni="+ fecIni + "&fecFin=" + fecFin;
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
  function reg_solicitud() {
    window.location = './reg_rx.php';
  }
  function edit_solicitud(id) {
    window.location = './main_editsolicitud.php?nroSoli='+id;
  }

  $(function() {
    jQuery('#txtBusNroDoc').keypress(function (tecla) {
      var idTipDocPer = $("#txtBusIdTipDoc").val();
      if (idTipDocPer == "1") {
        if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
        return false;
      } else {
        if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode != 0))//(Numeros y letras)(0=borrar)
        return false;
      }
    });
  });

  $(document).ready(function () {
    $("#txtBusIdTipDoc").select2();

    $('#txtBusFecIni').datetimepicker({
      locale: 'es',
      format: 'L'
    });

    $('#txtBusFecFin').datetimepicker({
      locale: 'es',
      format: 'L'
    });

    $("body").tooltip({ selector: '[data-toggle=tooltip]' });

    var dTable = $('#tblSolicitud').DataTable({
      dom: 'Bltip',
      "buttons": [
        {
          text: '<i class="glyphicon glyphicon-plus"></i> Registrar Atención',
          className: "btn btn-success btn-lg",
          action: function ( e, dt, node, config ) {
            reg_solicitud();
          }
        },
        {
          text: '<i class="glyphicon glyphicon-open"></i> Exportar resultado de busqueda',
          className: "btn btn-warning btn-lg",
          action: function ( e, dt, node, config ) {
            exporbuscar_datos();
          }
        }
      ],
      "bLengthChange": true, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
      "sAjaxSource": "tbl_rx.php", // Load Data
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
        aoData.push({"name": "idTipDoc", "value": $("#txtBusIdTipDoc").val()});
        aoData.push({"name": "nroDoc", "value": $("#txtBusNroDoc").val()});
        aoData.push({"name": "nomRS", "value": $("#txtBusNomRS").val()});
        aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
        aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
      },
      "columnDefs": [
        {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center font-weit"},
        {"orderable": false, "targets": 1, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 2, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 8, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 9, "searchable": false, "class": "text-center"}
      ],
      "order": [[ 0, "desc" ]]
    });

    $('#tblSolicitud').removeClass('display').addClass('table table-hover table-bordered');
  });

</script>
<?php require_once '../include/masterfooter.php'; ?>

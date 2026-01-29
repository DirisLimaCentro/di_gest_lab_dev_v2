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
      <h3 class="panel-title"><strong>Registro de Resultado de muestras citológicas de PAP</strong></h3>
    </div>
    <div class="panel-body">
      <fieldset class="scheduler-border">
        <legend class="scheduler-border">Buscar lámina</legend>
        <form class="form-horizontal" name="frmRepPrin" id="frmRepPrin" onsubmit="return false;">
          <input type="hidden" name="idDepQuejaPer" id="idDepQuejaPer" value="<?php if ($acceSelecDep <> "1") echo $saaIdDep; ?>"/>
          <div class="form-group">
            <div class="col-md-3">
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
                    <input type="text" name="txtBusNroDoc" placeholder="Número de documento" required="" id="txtBusNroDoc" class="form-control" maxlength="8" onkeydown="campoSiguiente('txtBusNomRS', event);"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-5 col-md-3">
              <label for="txtBusNomRS"><small>Nombres o Apellidos del paciente:</small></label>
              <input class="form-control" type="text" name="txtBusNomRS" id="txtBusNomRS" autocomplete="OFF" maxlength="50" required="" tabindex="0" onkeydown="campoSiguiente('txNroOrden', event);"/>
            </div>
            <div class="col-sm-2 col-md-2">
              <label for="txNroOrden"><small>N° Lámina Lab:</small></label>
              <input type="text" class="form-control pull-right" name="txNroOrden" id="txNroOrden" autocomplete="OFF" maxlength="10" value="" onkeydown="campoSiguiente('btnCon', event);"/>
            </div>
			<div class="col-sm-1">
				<div class="form-group">
					<label for="anio"><small>Año Lámina:</small></label>
					<select class="form-control" name="txtBusAnio" id="txtBusAnio">
					<?php
						$year_init = 2019;
						$year_curent = date('Y');
						for ($i = $year_init; $i <= $year_curent; $i++) {
							echo "<option value='$i'"; if($year_curent == $i){ echo " selected";}  echo ">$i</option>";
						}
					?>
					<option value="">TODOS</option>
					</select>
				</div>
			</div>
            <div class="col-sm-1 col-md-1">
              <br/>
              <button class="btn btn-success" type="button" id="btnCon" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
            </div>
          </div>
        </form>
      </fieldset>
      <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <a><i class="glyphicon glyphicon-eject"></i></a>=Registrar resultado | <a style="color: #449d44;"><i class="glyphicon glyphicon-pencil"></i></a>=Editar resultado | <a><i class="glyphicon glyphicon-check"></i></a>=Validar resultados | <a style="color: #00c0ef;"><i class="glyphicon glyphicon-eye-open"></i></a>=Ver ficha de atención</p>
      <br/>
      <table id="tblSolicitud" class="display" cellspacing="0" width="100%">
        <thead class="bg-aqua">
          <tr>
            <th>N° Lamina<br/>Laboratorio</th>
            <th>N° Lámina<br/> EESS</th>
            <th style="width: 30px;">Abrev. Paciente</th>
            <th>Nombre del Paciente</th>
            <th style="width: 80px;">Documento<br/>Identidad</th>
            <th>HC</th>
            <th>Establecimiento de Salud</th>
            <th>Estado resultado</th>
            <th>Resultado</th>
            <th style="width: 40px;"><i class="fa fa-cogs"></i></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once '../include/footer.php'; ?>

<script Language="JavaScript">

function campoSiguiente(campo, evento) {
  if (evento.keyCode == 13 || evento.keyCode == 9) {
    if (campo == 'btnCon') {
      buscar_datos();
    } else {
      document.getElementById(campo).focus();
      evento.preventDefault();
    }
  }
}

function buscar_datos() {
  var nomRS = $("#txtBusNomRS").val();
  nomRS = nomRS.replace("%", "");

  $("#tblSolicitud").dataTable().fnDraw()
}

function show_paciente(){
  $("#showPacienteModal").modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });

  $('#showPacienteModal').on('shown.bs.modal', function (e) {
    $('#txtNroDoc').trigger('focus');
  })
}

function back() {
  window.location = '../pages/';
}
function reg_solicitud() {
  window.location = './main_regsolicitud.php';
}

function reg_resultado(id) {
  window.location = './main_regresultado.php?nroSoli='+id;
}

function edit_resultado(id) {
  window.location = './main_editresultado.php?nroSoli='+id;
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

function valid_resultado(idPap, nroreglab) {
  bootbox.confirm({
    message: "Validar resultado N° Lamina Lab. <b>" + nroreglab + "</b>. ¿Está seguro de continuar?",
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
            accion: 'POST_ADD_REGVALIDARESULTADO', txtIdPap: idPap,
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              /*bootbox.alert({
                message: "La validación se realizó correctamente",
                callback: function () {
                  window.location = './main_principalresul.php';
                }
              });*/
			  window.location = './main_principalresul.php';
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
  $("#txtBusIdTipDoc").select2();
  $("body").tooltip({ selector: '[data-toggle=tooltip]' });

  var dTable = $('#tblSolicitud').DataTable({
    /*dom: 'Bltip',
    "buttons": [
      {
        text: '<i class="glyphicon glyphicon-open"></i> Exportar Consulta',
        className: "btn btn-warning btn-sm",
        action: function ( e, dt, node, config ) {
          exporbuscar_datos();
        }
      }
    ],*/
    "lengthMenu": [[25, 50, 100 ,250], [25, 50, 100 ,250, "All"]],
    "bProcessing": true,
    "bServerSide": true,
    "bJQueryUI": false,
    "responsive": true,
    "bInfo": true,
    "bFilter": false,
    "sAjaxSource": "tbl_principalresul.php", // Load Data
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
      aoData.push({"name": "nroOrden", "value": $("#txNroOrden").val()});
      aoData.push({"name": "bus_anio", "value": $("#txtBusAnio").val()});
	  

    },
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
      if ((aData[8] == "INSATISFACTORIA") ||  (aData[8] == "NEGATIVO")){
        $('td', nRow).addClass('success');
      }  else if(aData[8] == "PENDIENTE") {
      }else {//PENDIENTE
        $('td', nRow).addClass('success');
        $('td', nRow).addClass('text-danger');
      }
    },
    "columnDefs": [
      {"orderable": true, "targets": 0, "searchable": false, "class": "text-center font-weit"},
      {"orderable": false, "targets": 1, "searchable": false, "class": "text-center font-weit"},
      {"orderable": false, "targets": 2, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 3, "searchable": false, "class": ""},
      {"orderable": false, "targets": 4, "searchable": false, "class": ""},
      {"orderable": false, "targets": 5, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 6, "searchable": false, "class": ""},
      {"orderable": false, "targets": 7, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 8, "searchable": false, "class": ""},
      {"orderable": false, "targets": 9, "searchable": false, "class": "text-center"}
    ]
  });

  $('#tblSolicitud').removeClass('display').addClass('table table-hover table-bordered');

  setTimeout(function(){$('#txtBusNroDoc').trigger('focus');}, 2);
});
</script>
<?php require_once '../include/masterfooter.php'; ?>

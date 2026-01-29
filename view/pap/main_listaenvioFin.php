<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';

require_once '../../model/Pap.php';
$pap = new Pap();
require_once '../../model/Tipo.php';
$t = new Tipo();

?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Detalle de Envío de muestras de Examen Cérvico Uterino para PAP</strong></h3>
    </div>
    <div class="panel-body">
      <form class="" name="frmRepPrin" id="frmRepPrin" method="POST">
        <input type="hidden" name="txtTipoOpe" id="txtTipoOpe" value=""/>
        <input type="hidden" name="txtIdPap" id="txtIdPap" value=""/>
        <input type="hidden" name="txtTipAcc" id="txtTipAcc" value=""/>
      </form>
      <div class="row">
        <div class="col-sm-2">
          <div id="det-cntenv"></div>
        </div>
        <div class="col-sm-10">
          <div class="box box-success">
            <br/>
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a class="" href="#activity" data-toggle="tab" aria-expanded="true"><b>Detalle</b></a></li>
                <li class=""><a class="" href="#noconfor" data-toggle="tab" aria-expanded="false"><b>No conformidad</b></a></li>
              </ul>
              <div class="tab-content">
                <div id="activity" class="tab-pane active">
                  <fieldset class="scheduler-border">
                    <legend class="scheduler-border" style="margin-bottom: 5px;">Opciones de busqueda</legend>
                    <form class="form-horizontal" name="frmBus" id="frmBus" onsubmit="return false;">
                      <div class="form-group">
                        <div class="col-sm-4 col-md-3">
                          <label for="txtIdTipDoc"><small>Estado</small></label>
                          <select name="txtIdEstPAP" id="txtIdEstPAP" class="form-control input-sm">
                            <option value="">-- Todos --</option>
                            <option value="3">FINALIZADO</option>
                            <option value="4">ENTREGADO A PACIENTE</option>
                          </select>
                        </div>
                        <div class="col-sm-2 col-md-1">
                          <br/>
                          <button class="btn btn-success btn-sm btn-block" type="button" id="btnBus" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                        </div>
                      </div>
                    </form>
                  </fieldset>
                  <br/>
                  <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <button type="button" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-eye-open"></i></button>=Ver ficha de atención o resultado | <button type="button" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-info-sign"></i></button>=Ver detalle de rechazo u observación | <button type="button" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-user"></i></button>=Entregar resultado a Paciente</p>
                  <table id="tblSolicitud" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>N° Lámina<br/>EESS</th>
                        <th>Fecha</th>
                        <th>N° Doc.</th>
                        <th>HC</th>
                        <th>Paciente</th>
                        <th>Profesional</th>
                        <th>Estado</th>
                        <th>Estado<br/>Envío</th>
                        <th>Estado<br/>Resultado</th>
                        <th>N° Lamina<br/>Laboratorio</th>
                        <th style="width: 60px;">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                <div id="noconfor" class="tab-pane">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th style="width: 15px"><small>#</small></th>
                          <th><small>Tipo<small></th>
                            <th><small>Motivo</small></th>
                            <th><small>Detalle</small></th>
                          </tr>
                        </thead>
                        <tbody id="det-noconfor">
                          <tr>
                            <td colspan="4"><small>No se encontraron resultados</small></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="showDetObsModal" role="dialog" aria-labelledby="showDetObsModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="showDetObsModalLabel">Detalle de la observación</h4>
          </div>
          <div class="modal-body">
            <div class="pad margin no-print">
              <div class="callout callout-info" style="margin-bottom: 0!important;">
                <h4 style="margin-bottom: 2px;"><span id="lblNomAccion">Rechazo<span></h4>
                  <h4><small id="lblMotObs">Tipo de rechazo:</small></h4>
                  <span id="lblDetObs">Este es el detalle de la observación.</span>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div class="row">
                <div class="col-md-12 text-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Aceptar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="showTipNotifModal" role="dialog" aria-labelledby="showTipNotifModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="showTipNotifModalLabel"></h4>
            </div>
            <div class="modal-body">
              <form name="frmNotificacion" id="frmNotificacion">
                <div class="form-group">
                  <?php $rsT = $t->get_listaTipoNotificacion(); ?>
                  <label for="txtIdTipNotif">Tipo entrega a Paciente:</label>
                  <select name="txtIdTipNotif" id="txtIdTipNotif" class="form-control">
                    <option value="">-- Seleccione --</option>
                    <?php
                    foreach ($rsT as $row) {
                      echo "<option value='" . $row['id_tiponotif'] . "'>" . $row['nom_tiponotif'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <label for="txtDetNotif">Comentario:</label>
                      <textarea class="form-control" name="txtDetNotif" id="txtDetNotif" rows="3"></textarea>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <div class="row">
                <div class="col-md-12 text-center">
                  <button type="button" class="btn btn-primary btn-continuar" id="btnFrmSaveNotif" onclick="save_formaccion()"><i class="fa fa-save"></i> Continuar </button>
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="mostrar_opcprintresul" class="modal fade" role="dialog" data-backdrop="static"></div>
      <?php require_once '../include/footer.php'; ?>
      <script Language="JavaScript">
      function back() {
        window.location = './main_principalsolienv.php';
      }

      function open_detobs(iddetenv) {
        $.ajax({
          url: "../../controller/ctrlPAP.php",
          type: "POST",
          dataType: 'json',
          data: {
            accion: 'GET_SHOW_DETOBSPORIDDETENV', idDetEnv: iddetenv
          },
          success: function (registro) {
            var datos = eval(registro);
            $('#lblNomAccion').text(datos[3]);
            $('#lblMotObs').text(datos[5]);
            $('#lblDetObs').text(datos[6]);
            $('#showDetObsModal').modal({
              show: true,
              backdrop: 'static',
              focus: true,
            });
          }
        });
      }

      function show_detcntenvio(opt){
        var txtIdEnv = "<?php echo $_GET['envio']?>";
        $.ajax({
          url: "../../controller/ctrlPAP.php",
          type: "POST",
          data: {
            accion: 'SHOW_DETCANTIDADESENVIO', txtIdEnv: txtIdEnv, txtTipo: opt
          },
          success: function (result) {
            $("#det-cntenv").html(result);
          }
        });
      }

      function show_detnoconfor(){
        var txtIdEnv = "<?php echo $_GET['envio']?>";
        $.ajax({
          url: "../../controller/ctrlPAP.php",
          type: "POST",
          data: {
            accion: 'GET_SHOW_MOTIVONOCONFORPORIDENV', txtIdEnv: txtIdEnv
          },
          success: function (result) {
            var datos = eval(result);
            $("#lblNoConfor").text(datos[0]);
            var newOption = "";
            if(datos[0] != "0"){
              var newItem = 0;
              $(datos[1]).each(function (ii, oo) {
                newItem = newItem + 1;
                newOption += "<tr><td><small>" + newItem + "</small></td><td><small>" + oo.nom_tipo + "</small></td><td><small>" + oo.nom_motivo + "</small></td><td><small>" + oo.det_noconformidad + "</small></td></tr>";
              });
            } else {
              newOption += "<tr><td colspan=\"4\"><small>No se encontraron resultados</small></td></tr>";
            }
            $("#det-noconfor").html(newOption);
          }
        });
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

      function open_opcionimpresionresul(id){
        $('#mostrar_opcprintresul').modal('show');
        $.ajax({
          url: '../../controller/ctrlPAP.php',
          type: 'POST',
          data: 'accion=GET_SHOW_OPTIMPRESIONRESUL&idSoli=' + id,
          success: function(data){
            $('#mostrar_opcprintresul').html(data);
          }
        });
      }

      function acc_registro(idpap, nroreg, opt){
        document.frmRepPrin.txtIdPap.value = idpap;
        document.frmRepPrin.txtTipAcc.value = opt; //A anular; E Entregado a paciente

        if(opt == 'A'){
          $("#showComenModalLabel").text("Anular toma PAP Nro: " + nroreg);
          $("#showComenModal").modal({
            show: true,
            backdrop: 'static',
            focus: true,
          });
          $('#showComenModal').on('shown.bs.modal', function (e) {
            document.frmComentario.txtDetComen.value = '';
            $('#txtDetComen').trigger('focus');
          })
        } else {

          $("#showTipNotifModalLabel").text("Entregar resultado Nro: " + nroreg + " a paciente");
          $("#showTipNotifModal").modal({
            show: true,
            backdrop: 'static',
            focus: true,
          });
          $('#showTipNotifModal').on('shown.bs.modal', function (e) {
            document.frmNotificacion.txtIdTipNotif.value = '';
            document.frmNotificacion.txtDetNotif.value = '';
            $('#txtIdTipNotif').trigger('focus');
          })
        }
      }

      function save_formaccion(){
        $('#btnFrmSave').prop("disabled", true);
        var isValid = true;
        var msgobs = '';
        var txtIdPap = document.frmRepPrin.txtIdPap.value;
        var txtTipAcc = document.frmRepPrin.txtTipAcc.value;

        if(txtTipAcc == "A"){
          var txtIdTipNotif = '';
          var txtDetComen = document.frmComentario.txtDetComen.value;

          if(txtDetComen.length <= 2){
            msgobs+='Ingrese Motivo...';
            isValid = false;
          }
          msgconfir = 'Se anulará la muestra. ¿Está seguro de continuar?';
        } else {
          var txtIdTipNotif = document.frmNotificacion.txtIdTipNotif.value;
          var txtDetComen = document.frmNotificacion.txtDetNotif.value;

          if(txtIdTipNotif == ""){
            msgobs+='Seleccione Tipo de entrega a Paciente<br/>';
            isValid = false;
          }
          /*if(txtDetComen.length <= 2){
            msgobs+='Ingrese Comentario';
            isValid = false;
          }*/
          msgconfir = 'Se cambiará el estado a <b>ENTREGADO A PACIENTE</b>. ¿Está seguro de continuar?';
        }

        if (isValid == false){
          bootbox.alert(msgobs);
          return false;
        }

        if(txtTipAcc == "A"){
          $('#btnFrmSaveComen').prop("disabled", false);
        } else {
          $('#btnFrmSaveNotif').prop("disabled", false);
        }

        bootbox.confirm({
          message: msgconfir,
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
              $.ajax({
                url: "../../controller/ctrlPAP.php",
                type: "POST",
                data: {
                  accion: 'POST_ADD_REGANULAENTREGAPAP', txtIdPap: document.frmRepPrin.txtIdPap.value, txtTipAcc: document.frmRepPrin.txtTipAcc.value, txtIdTipNotif: txtIdTipNotif, txtDetComen: txtDetComen,
                },
                success: function (data) {
                  var tmsg = data.substring(0, 2);
                  var lmsg = data.length;
                  var msg = data.substring(3, lmsg);
                  //console.log(tmsg);
                  if(tmsg == "OK"){
                    $("#tblSolicitud").dataTable().fnDraw();

                    if(txtTipAcc == "A"){
                      $('#showComenModal').modal("hide");
                      $('#btnFrmSaveComen').prop("disabled", false);
                    } else {
                      $('#showTipNotifModal').modal("hide");
                      $('#btnFrmSaveNotif').prop("disabled", false);
                    }
                    show_detcntenvio('E');
                  } else {
                    bootbox.alert(msg);
                    return false;
                  }
                }
              });
            } else {
              $('#btnFrmSave').prop("disabled", false);
            }
          }
        });
      }

      function buscar_datos() {
        $("#tblSolicitud").dataTable().fnDraw();
      }

      $(document).ready(function () {

        show_detnoconfor();
        show_detcntenvio('E');

        var dTableS = $('#tblSolicitud').DataTable({
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
        "sAjaxSource": "tbl_editenvio.php", // Load Data
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
          aoData.push({"name": "estEnv", "value": ""});
          aoData.push({"name": "idPapEnv", "value": "<?php echo $_GET['envio']?>"});
          aoData.push({"name": "idestPap", "value": $("#txtIdEstPAP").val()});
        },
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
          /* Append the grade to the default row class name */
          if ( aData[7] == "ADECUADA" ){
            $('td', nRow).addClass('success');
          } else if ( aData[7] == "RECHAZADA" ){
            $('td', nRow).addClass('danger');
          } else if ( aData[7] == "POR SUBSANAR" ){
            $('td', nRow).addClass('warning');
          }

          if ( aData[9] == "POSITIVO" ){
            $('td', nRow).addClass('text-danger');
          }
        },
        "columnDefs": [
          {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center font-weit"},
          {"orderable": false, "targets": 1, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 2, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 4, "searchable": false, "class": "small"},
          {"orderable": false, "targets": 5, "searchable": false, "class": "small"},
          {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center font-weit"},
          {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center font-weit"},
          {"orderable": false, "targets": 8, "searchable": false, "class": "small text-center font-weit"},
          {"orderable": false, "targets": 9, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 10, "searchable": false, "class": "small text-center"}
        ],
        "order": [[ 0, "desc" ]]
      });

      $('#tblSolicitud').removeClass('display').addClass('table table-hover table-bordered');

    });
    </script>
    <?php require_once '../include/masterfooter.php'; ?>

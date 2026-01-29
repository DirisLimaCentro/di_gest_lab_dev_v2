<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';

require_once '../../model/Pap.php';
$pap = new Pap();

$idEnvio = $_GET['envio'];
$rsE = $pap->get_datosEnvio($idEnvio);
//print_r($rsE);
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Detalle de Envío de muestras de Examen Cérvico Uterino para PAP</strong></h3>
    </div>
    <div class="panel-body">
      <form class="" id="frm-example" method="POST">
        <input type="hidden" name="txtTipoOpe" id="txtTipoOpe" value=""/>
      </form>
      <div class="row">
        <div class="col-sm-2">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center"><?php echo $rsE[0]['nro_papenv'] . "-" . $rsE[0]['anio_papenv'];?></h3>
              <p class="text-muted text-center"><?php echo $rsE[0]['nom_depen'];?></p>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Total muestras</b> <span id="txtCantEnv" class="pull-right badge bg-blue"><?php echo $rsE[0]['cnt_solienvtot'];?></span>
                </li>
                <li class="list-group-item">
                  <b>Adecuadas</b> <span id="txtCantAcep" class="pull-right badge bg-green"><?php echo $rsE[0]['cnt_soliaceptada'];?></span>
                </li>
                <li class="list-group-item">
                  <b>Por subsanar</b> <span id="txtCantMod" class="pull-right badge bg-yellow"><?php echo $rsE[0]['cnt_solipormodif'];?></span>
                </li>
                <li class="list-group-item">
                  <b>Rechazados</b> <span id="txtCantRec" class="pull-right badge bg-red"><?php echo $rsE[0]['cnt_solirechazada'];?></span>
                </li>
                <li class="list-group-item">
                  <b>No conformidad</b> <span id="txtCantRec" class="pull-right badge"><?php echo $rsE[0]['cnt_solinoconfor'];?></span>
                </li>
              </ul>
              <button type="button" class="btn btn-default btn-block" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Regresar</button>
            </div>
          </div>
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
                  <table id="tblSolicitud" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>N° Lámina</th>
                        <th>Fecha</th>
                        <th>N° Doc.</th>
                        <th>HC</th>
                        <th>Paciente</th>
                        <th>Profesional</th>
                        <th>Estado</th>
                        <th>N° Lamina Lab.</th>
                        <th>Resultado</th>
                        <th style="width: 30px;">&nbsp;</th>
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

      $(document).ready(function () {

        show_detnoconfor();

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
        },
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
          /* Append the grade to the default row class name */
          if ( aData[6] == "ADECUADA" ){
            $('td', nRow).addClass('success');
          } else if ( aData[6] == "RECHAZADA" ){
            $('td', nRow).addClass('danger');
          } else if ( aData[6] == "POR SUBSANAR" ){
            $('td', nRow).addClass('warning');
          }

          if ( aData[8] == "POSITIVO" ){
            $('td', nRow).addClass('text-danger');
          }
        },
        "columnDefs": [
          {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center font-weit"},
          {"orderable": false, "targets": 1, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 2, "searchable": false, "class": "small text-center font-weit"},
          {"orderable": false, "targets": 3, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 4, "searchable": false, "class": "small"},
          {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"},
          {"orderable": false, "targets": 8, "searchable": false, "class": "small text-center font-weit"},
          {"orderable": false, "targets": 9, "searchable": false, "class": "small text-center"}
        ],
        "order": [[ 0, "desc" ]]
      });

      $('#tblSolicitud').removeClass('display').addClass('table table-hover table-bordered');

    });
    </script>
    <?php require_once '../include/masterfooter.php'; ?>

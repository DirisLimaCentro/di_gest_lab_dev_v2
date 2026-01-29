<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<style>
.label-success {
    background-color: #5cb85c !important;
}
.label-warning {
    background-color: #f0ad4e !important;
}
.label-danger {
    background-color: #d9534f !important;
}
</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>REGISTRO DE ENVÍO DE ATENCIONES DE PAP</strong></h3>
    </div>
    <div class="panel-body">
      <form class="" id="frm-example" method="POST">
        <input type="hidden" name="txtIdSolicitud" id="txtIdSolicitud" value="<?php echo $_GET['nroSoli']?>"/>
        <p class="text-right" style="margin: 0 0 0px;"><b>Acciones</b>: <input type="checkbox" checked>=Incluir en el envío | <input type="checkbox">=No incluir en el envío | <a style="color: #00c0ef;"><i class="glyphicon glyphicon-eye-open"></i></a>=Ver ficha de atención</p>
        <p class="text-right" style="margin: 0 0 0px;"><b>Color por días transcurridos desde la fecha de atención</b>: <span class="label label-success">0 a 3 días</span> <span class="label label-warning">4 a 6 días</span> <span class="label label-danger">7 días a más</span></p>
        <br/>
      <table id="example" class="display" cellspacing="0" width="100%">
        <thead class="bg-aqua">
          <tr>
            <th></th>
            <th>N°</br>Lámina</th>
            <th>Fecha</br>Atención</th>
            <th>Días</br>Transcurridos</th>
            <th>Abrev.</br>Paciente</th>
            <th>Paciente</th>
            <th>N° Doc.</th>
            <th>HC</th>
            <th>Profesional</th>
            <th><i class="fa fa-cogs"></i></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th>N° Orden</th>
            <th>Fecha</br>Atención</th>
            <th>Días</br>Transcurridos</th>
            <th>Abrev.</br>Paciente</th>
            <th>Paciente</th>
            <th>N° Doc.</th>
            <th>HC</th>
            <th>Profesional</th>
            <th><i class="fa fa-cogs"></i></th>
          </tr>
        </tfoot>
      </table>
    <pre id="example-console-rows" style="display: none;"></pre>
  </form>
</div>
<div class="modal-footer">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="btn-group">
        <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Finalizar envío </button>
        <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="fa fa-times"></i> Cancelar</button>
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

function open_pdfsinvalor(idSoli) {

  var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function validForm() {
  //$('#btnValidForm').prop("disabled", true);
  var msg = "";
  var sw = true;

  var table = $('#example').DataTable();;
  var rows_selected = table.column(0).checkboxes.selected();

  // Output form data to a console
  $('#example-console-rows').text(rows_selected.join(","));

  var idpac = $('#txtIdPac').val();

  if(rows_selected.join(",") == ""){
    msg+= "Seleccione al menos una muestra<br/>";
    sw = false;
  }

  if (sw == false) {
    bootbox.alert(msg);
    $('#btnValidForm').prop("disabled", false);
    return sw;
  } else {
    save_form();
  }
  return false;
}

function save_form() {
  bootbox.confirm({
    message: "Se registrarán los registros ingresados, ¿Está seguro de continuar?",
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
            accion: 'POST_ADD_REGENVIO',
            txtIdSoli: $('#example-console-rows').text(),
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              bootbox.alert({
                message: "Se registro el envío N° <b>" + msg + "</b>",
                callback: function () {
                  window.location = './main_principalsolienv.php';
                }
              });
            } else {
              bootbox.alert(msg);
              return false;
            }
          }
        });
      } else {
        $('#btnValidForm').prop("disabled", false);
      }
    }
  });
}

$(document).ready(function () {

  var table = $('#example').DataTable({
    "lengthMenu": [[50, 100 ,250], [50, 100 ,250, "All"]],
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": false,
    "sAjaxSource": "tbl_regenvio.php", // Load Data
	"sServerMethod": "POST",
    "language": {
      "url": "../../assets/plugins/datatables/Spanish.json",
      "lengthMenu": '_MENU_ entries per page',
      "search": '<i class="fa fa-search"></i>',
      "paginate": {
        "previous": '<i class="fa fa-angle-left"></i>',
        "next": '<i class="fa fa-angle-right"></i>'
      }
    },
    initComplete: function () {
      table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
          that
          .search( this.value )
          .draw();
        } );
      } );
    },
    //"ajax": "tbl_regenvio.php", // Load Data
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
      if (aData[3] <= 3){
        $('td', nRow).addClass('success');
      } else if (aData[3] > 3 && aData[3] <= 6){
        $('td', nRow).addClass('warning');
      } else {
        $('td', nRow).addClass('danger');
      }
    },
    'columnDefs': [
      {'targets': 0, 'checkboxes': {'selectRow': true}, "class": "text-center"},
      {"orderable": false, "targets": 1, "searchable": true, "class": "small text-center font-weit"},
      {"orderable": true, "targets": 2, "searchable": true, "class": "small text-center"},
      {"orderable": false, "targets": 3, "searchable": true, "class": "small text-center font-weit"},
      {"orderable": false, "targets": 4, "searchable": true, "class": "small text-center font-weit"},
      {"orderable": false, "targets": 5, "searchable": true, "class": "small"},
      {"orderable": false, "targets": 6, "searchable": true, "class": "small"},
      {"orderable": false, "targets": 7, "searchable": true, "class": "small text-center"},
      {"orderable": false, "targets": 8, "searchable": true, "class": "small"},
      {"orderable": false, "targets": 9, "searchable": true, "class": "small text-center"}
    ],
    'select': {
      'style': 'multi',
    },
    'order': [2, 'asc']
  });

  $('#example').removeClass('display').addClass('table table-hover table-bordered');

});
</script>
<?php require_once '../include/masterfooter.php'; ?>

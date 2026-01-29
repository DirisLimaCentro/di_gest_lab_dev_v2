<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<div class="container">
  <div class="col-sm-offset-3 col-sm-6">
    <div class="panel-prime">
      <div class="panel-heading">
        <h3 class="panel-title"><strong>Cambiar Contrase&ntilde;a</strong></h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-12 text-left">
            <div class="row">
              <form class="form-horizontal" name="frm1" id="frm1" onsubmit="return false;">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="txtContraAnte" class="col-sm-5 control-label"><small><strong>Contrase&ntilde;a Anterior:</strong></small></label>
                    <div class="col-sm-7">
                      <input class="form-control input-sm"  type="password" name="txtContraAnte" id="txtContraAnte" autocomplete="OFF"  maxlength="25" required="" onkeydown="campoSiguientePersona('txtContraNue', event);">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="txtContraNue" class="col-sm-5 control-label"><small><strong>Contrase&ntilde;a Nueva:</strong></small></label>
                    <div class="col-sm-7">
                      <input class="form-control input-sm"  type="password" name="txtContraNue" id="txtContraNue" autocomplete="OFF"  maxlength="25" required="" onkeydown="campoSiguientePersona('txtContraNueRep', event);">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="txtContraNueRep" class="col-sm-5 control-label"><small><strong>Repita Contrase&ntilde;a Nueva:</strong></small></label>
                    <div class="col-sm-7">
                      <input class="form-control input-sm"  type="password" name="txtContraNueRep" id="txtContraNueRep" autocomplete="OFF"  maxlength="25" required="" onkeydown="campoSiguientePersona('btnCambiaCon', event);">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <button id="btnBack" class="btn btn-default" type="button" onclick="back();" tabindex="1"><i class="glyphicon glyphicon-log-out"></i> Ir al Men&uacute;</button>
                      <button class="btn btn-primary pull-right" type="button" id="btnFrmSave" onclick="cambiar_contrasena();">Cambiar Contrase&ntilde;a</button>
                    </div>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </div>
        <!--Aqui-->
      </div>
    </div>
  </div>
</div>
<?php require_once '../include/footer.php'; ?>
<script type="text/javascript">
function cambiar_contrasena() {
  $('#btnFrmSave').prop("disabled", true);
  msgobs = "";
  isValid = true;

  var txtContraAnte = $("#txtContraAnte").val();
  var txtContraNue = $("#txtContraNue").val();
  var txtContraNueRep = $("#txtContraNueRep").val();

  if (txtContraAnte == "") {
    msgobs+= 'El Campo referido a la contrase\xf1a anterior es un campo obligatorio. Por favor Ingrese Contrase\xf1a anterior.<br/>';
    isValid = false;
  }
  if (txtContraNue == "") {
    msgobs+= 'El Campo referido a la contrase\xf1a nueva es un campo obligatorio. Por favor Ingrese Contrase\xf1a nueva.<br/>';
    isValid = false;
  }
  if (txtContraNueRep == "") {
    msgobs+= 'El Campo referido a la contrase\xf1a nueva es un campo obligatorio. Por favor Repita la Contrase\xf1a nueva.<br/>';
    isValid = false;
  }
  if (txtContraNue != txtContraNueRep) {
    msgobs+= 'Las contrase\xf1as nuevas no coinciden. Por favor vuelva a ingresar Contrase\xf1a nueva.<br/>';
    isValid = false;
  }

  if (txtContraAnte == txtContraNueRep) {
    msgobs+= 'La contrase\xf1a anterior y la contrase\xf1a nueva no deben ser iguales. Por favor digite otra Contrase\xf1a nueva.<br/>';
    isValid = false;
  }

  if (isValid == false){
    bootbox.alert(msgobs);
    $('#btnFrmSave').prop("disabled", false);
    return false;
  }
  bootbox.confirm({
    message: "Se cambiará la contraseña, ¿Está seguro de continuar?",
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
          url: "../../controller/ctrlUsuario.php",
          type: "POST",
          data: {
            accion: 'POST_UPD_CONTRASENA', txtContraAnte: txtContraAnte, txtContraNue: txtContraNue
          },
          success: function (data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            if (tmsg == "OK") {
              bootbox.alert(msg);
              $("#txtContraAnte").val('');
              $("#txtContraNue").val('');
              $("#txtContraNueRep").val('');
            } else {
              bootbox.alert(msg);
              $('#btnFrmSave').prop("disabled", false);
            }
          }
        });
      } else {
        $('#btnFrmSave').prop("disabled", false);
      }
    }
  });
}

function campoSiguientePersona(campo, evento) {
  if (evento.keyCode == 13 || evento.keyCode == 9) {
    if (campo == 'btnCambiaCon') {
      cambiar_contrasena();
    } else {
      document.getElementById(campo).focus();
      evento.preventDefault();
    }
  }
}
function back() {
  window.location = '../pages/';
}
</script>
</body>
</html>

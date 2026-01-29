<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Ubigeo.php';
$ub = new Ubigeo();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Registro de Atención ITS</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmSolicitud" id="frmSolicitud">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="0"/>
        <input type="hidden" name="txtIdPac" id="txtIdPac" value="0"/>
        <div class="row">
          <div class="col-sm-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Datos del paciente</strong></h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <label style="font-weight: bold !important;">Tipo de Paciente:</label>
                  <div class="input-group">
                    <label><input type="radio" name="txtTipPac" id="txtTipPac1" value="1"/> SIS </label> &nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="txtTipPac" id="txtTipPac2" value="0"/> PARTICULAR</label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-8 col-md-7">
                      <div class="row">
                        <div class="col-md-12">
                          <label for="txtIdTipDocPac">Doc. de identidad:</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4" style="padding-right: 0!important;">
                          <?php $rsT = $t->get_listaTipoDocPerNatuSinDocAndConDocAdulto(); ?>
                          <select class="form-control" name="txtIdTipDocPac" id="txtIdTipDocPac" onchange="maxlength_doc_bus()" disabled>
                            <?php
                            foreach ($rsT as $row) {
                              echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . ": " . $row['descripcion'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-sm-8" style="padding-left: 0!important;">
                          <div class="input-group input-group">
                            <input type="text" name="txtNroDocPac" id="txtNroDocPac" placeholder="Número de documento" onfocus="this.select()" autocomplete="OFF" class="form-control" maxlength="8" onkeydown="campoSiguiente('btnPacSearch', event);" disabled/>
                            <div class="input-group-btn">
                              <button class="btn btn-info" type="button" id="btnPacSearch" onclick="buscar_datos_personales()" disabled><i class="fa fa-search"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-5">
                      <label for="txtNroHCPac"> Nro. H.C.: </label>
                      <input type="text" name="txtNroHCPac" id="txtNroHCPac" class="form-control text-uppercase" maxlength="10" onkeydown="campoSiguiente('txtPriApePac', event);" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="txtPriApePac">Apellido paterno</label>
                      <input type="text" name="txtPriApePac" class="form-control text-uppercase" id="txtPriApePac" maxlength="75" onkeydown="campoSiguiente('txtSegApePac', event);" readonly/>
                    </div>
                    <div class="col-sm-6">
                      <label for="txtSegApePac">Apellido materno</label>
                      <input type="text" name="txtSegApePac" class="form-control text-uppercase" id="txtSegApePac" maxlength="75" onkeydown="campoSiguiente('txtNomPac', event);" readonly/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="txtNomPac">Nombre(s)</label>
                  <input type="text" name="txtNomPac" class="form-control text-uppercase" id="txtNomPac" maxlength="180" onkeydown="campoSiguiente('txtFecNacPac', event);" readonly/>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-3 col-md-4">
                      <label for="txtIdSexoPac">Sexo</label>
                      <select class="form-control" name="txtIdSexoPac" id="txtIdSexoPac" onkeydown="campoSiguiente('txtFecNacPac', event);" disabled>
                        <option value="">-- Seleccione  --</option>
                        <option value="1">M</option>
                        <option value="2">F</option>
                      </select>
                    </div>
                    <div class="col-sm-6 col-md-5">
                      <label for="txtFecNacPac">Fecha Nac.</label>
                      <div class="input-group input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" name="txtFecNacPac" id="txtFecNacPac" placeholder="DD/MM/AAAA" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtIdPaisNacPac', event);" disabled/>
                      </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                      <label for="txtEdadPac">Edad</label>
                      <input type="text" class="form-control" name="txtEdadPac" id="txtEdadPac" disabled/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="txtIdPaisNacPac">País de nacimiento</label>
                  <select class="form-control" style="width: 100%" name="txtIdPaisNacPac" id="txtIdPaisNacPac" onkeydown="campoSiguiente('txtIdEtniaPac', event);" disabled>
                    <option value="">-- Seleccione --</option>
                    <?php
                    $rsPP = $ub->get_listaPais();
                    foreach ($rsPP as $rowPP) {
                      echo "<option value='" . $rowPP['id_pais'] . "'>" . $rowPP['nom_pais'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="txtIdEtniaPac">ETNIA</label>
                  <select class="form-control" style="width: 100%" name="txtIdEtniaPac" id="txtIdEtniaPac" onkeydown="campoSiguiente('txtUBIGEOPac', event);" disabled>
                    <option value="">-- Seleccione --</option>
                    <?php
                    $rsTE = $t->get_listaEtnia();
                    foreach ($rsTE as $rowTE) {
                      echo "<option value='" . $rowTE['id_etnia'] . "'>" . $rowTE['nom_etnia'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Notificación del paciente</strong></h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <label for="txtIdDepPac">UBIGEO (Departamento)</label>
                  <?php $rsUb = $ub->get_listaUbigeoDepartamentosPeru(); ?>
                  <select class="form-control" style="width: 100%" name="txtIdDepPac" id="txtIdDepPac" onchange="get_listaProvinciaAndDistrito('', '')" disabled>
                    <option value="">-- Seleccione --</option>
                    <?php
                    foreach ($rsUb as $rowUb) {
                      echo "<option value='" . $rowUb['id_ubigeo'] . "'";
                      if($rowUb['id_ubigeo'] == "14") echo " selected";
                      echo ">" . $rowUb['departamento'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="txtUBIGEOPac">UBIGEO (Provincia - Distrito)</label>
                  <?php $rsUb = $ub->get_listaUbigeoLimaPeru(); ?>
                  <select class="form-control" style="width: 100%" name="txtUBIGEOPac" id="txtUBIGEOPac" disabled>
                    <option value="">-- Seleccione --</option>
                    <?php
                    foreach ($rsUb as $rowUb) {
                      echo "<option value='" . $rowUb['id_ubigeo'] . "'>" . $rowUb['provincia'] . " - " . $rowUb['distrito'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="txtDirPac">Dirección:</label>
                  <input type="text" name="txtDirPac" id="txtDirPac" onfocus="this.select()" class="form-control text-uppercase" maxlength="185" value="" onkeydown="campoSiguiente('txtDirRefPac', event);" readonly/>
                </div>
                <div class="form-group">
                  <label for="txtDirRefPac">Referencia:</label>
                  <input type="text" name="txtDirRefPac" id="txtDirRefPac" onfocus="this.select()" class="form-control text-uppercase" maxlength="185" value="" onkeydown="campoSiguiente('txtNroTelFijoPac', event);" readonly/>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="txtNroTelFijoPac">Telf. Fijo</label>
                      <div class="input-group input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></div>
                        <input type="text" name="txtNroTelFijoPac" placeholder="999999999" id="txtNroTelFijoPac" onfocus="this.select()" class="form-control" maxlength="9" value="" onkeydown="campoSiguiente('txtNroTelMovilPac', event);" disabled/>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="txtNroTelMovilPac">Telf. Móvil</label>
                      <div class="input-group input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
                        <input type="text" name="txtNroTelMovilPac" placeholder="999999999" id="txtNroTelMovilPac" onfocus="this.select()" class="form-control" maxlength="9" value="" onkeydown="campoSiguiente('txtEmailPac', event);" disabled/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="txtEmailPac">Email</label>
                  <div class="input-group input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
                    <input type="text" name="txtEmailPac" placeholder="@example.com" id="txtEmailPac" onfocus="this.select()" class="form-control" maxlength="50" value="" disabled/>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div id="saveSolicitud">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Guardar Atención </button>
                <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="fa fa-times"></i> Cancelar</button>
              </div>
            </div>
            <div id="saveExportar" style="display: none;">
              <div class="btn-group">
                <button type="button" class="btn btn-lg btn-success" id="btn-imrimirall" onclick="open_pdfsinvalor();"><i class="fa fa-file-pdf-o"></i> Imprimir Informe</button>
                <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="fa fa-times"></i> Salir</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
<?php require_once '../include/footer.php'; ?>
<script type="text/javascript" src="../pap/main_principalsoli.js"></script>
<script Language="JavaScript">
$(function() {

  jQuery('#txtNroDocPac').keypress(function (tecla) {
    var idTipDocPer = $("#txtIdTipDocPac").val();
    if (idTipDocPer == "1") {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
      return false;
    } else {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode != 0))//(Numeros y letras)(0=borrar)
      return false;
    }
  });

  jQuery('#txtPriApePac').keypress(function (tecla) {
    if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
    return false;
  });
  jQuery('#txtSegApePac').keypress(function (tecla) {
    if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
    return false;
  });
  jQuery('#txtNomPac').keypress(function (tecla) {
    if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
    return false;
  });

  jQuery('#txtNroTelMovilPac').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
    return false;
  });

  jQuery('#txtNroTelfMovilPac').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
    return false;
  });

  jQuery('#txtPesoPac').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0) && (tecla.charCode != 46))//(Solo Numeros)(0=borrar) (punto)
    return false;
  });

  jQuery('#txtTallaPac').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0) && (tecla.charCode != 46))//(Solo Numeros)(0=borrar) (punto)
    return false;
  });

  jQuery('#txtPAPac').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0) && (tecla.charCode != 47))//(Solo Numeros)(0=borrar) (slash)
    return false;
  });

  jQuery('#txtNroRefDepPac').keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
    return false;
  });

  $('[name="txtTipPac"]').change(function()
  {
    enabled_datos_documento();
    maxlength_doc_bus();
    $('#txtNroHCPac').prop("disabled", false);
    enabled_datos_direccion();
  });
});

$('#txtIdEtniaPac').on("change", function (e) {
  if($(this).val() != ""){
    if($('#txtUBIGEOPac').val() != ""){
      $('#txtDirPac').trigger('focus');
    } else {
      $('#txtUBIGEOPac').select2('open');
    }
  }
});

$('#txtUBIGEOPac').on("change", function (e) {
  if($(this).val() != ""){
    setTimeout(function(){$('#txtDirPac').trigger('focus');}, 2);
  }
});

function open_pdfsinvalor() {
  var idSoli = $('#txtIdAtencion').val();
  var urlwindow = "pdf_constanciaits.php?id_solicitud=" + idSoli;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function back() {
  window.location = './main_principalsoli.php';
}

function buscar_datos_personales(){
  $('#txtIdPac').val('0');
  var msg = "";
  var sw = true;
  var txtIdTipDoc = $('#txtIdTipDocPac').val();
  var txtNroDoc = $('#txtNroDocPac').val();
  var txtNroDocLn = txtNroDoc.length;

  if (txtIdTipDoc == "1") {
    if (txtNroDocLn != 8) {
      msg += "Ingrese el Nro. de documento correctamente (8 digitos)<br/>";
      sw = false;
    }

    if(validateNumber(txtNroDoc) == "0"){
      msg += "Ingrese el Nro. de documento correctamente (Digitar valores numéricos)<br/>";
      sw = false;
    }
  } else if(txtIdTipDoc == "2" || txtIdTipDoc == "4"){
    if (txtNroDocLn <= 5) {
      msg += "Ingrese el Nro. de documento correctamente<br/>";
      sw = false;
    }
  } else {
    if (txtNroDocLn <= 9) {
      msg += "Ingrese el Nro. de documento correctamente<br/>";
      sw = false;
    }
  }

  if (sw == false) {
    bootbox.alert(msg);
    $('#btn-pac-search').prop("disabled", false);
    return false;
  }

  $('#btn-pac-search').prop("disabled", true);
  $.ajax({
    url: "../../controller/ctrlPersona.php",
    type: "POST",
    dataType: 'json',
    data: {
      accion: 'GET_SHOW_PERSONULTIMAATENCIONPORIDDEP', txtIdTipDoc: txtIdTipDoc, txtNroDoc: txtNroDoc
    },
    beforeSend: function (objeto) {
      bootbox.dialog({
        message: '<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i> Por favor espere...</p>',
        closeButton: false
      });
    },
    success: function (registro) {
      bootbox.hideAll();
      var datos = eval(registro);
      $("#txtIdPac").val(datos[0]);
      if(datos[0] == "E"){
        $("#txtIdPac").val('0');
        bootbox.alert({
          message: "No se encontró el DNI en consulta RENIEC, verifíque por favor.",
          callback: function () {
            setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
          }
        });
      } else if(datos[0] == "C"){
        $('#txtIdSexoPac').prop("disabled", false);
        $('#txtNomPac').prop("readonly", false);
        $('#txtPriApePac').prop("readonly", false);
        $('#txtSegApePac').prop("readonly", false);
        $('#txtFecNacPac').prop("disabled", false);
        $('#txtIdPaisNacPac').prop("disabled", false);
        $('#txtIdEtniaPac').prop("disabled", false);
        $("#txtIdPaisNacPac").val('').trigger("change");
        $("#txtIdEtniaPac").val('').trigger("change");
        $("#txtIdPac").val('0');
        bootbox.alert({
          message: "El servicio de consulta RENIEC no está disponible, por favor ingrese los datos manualmente...",
          callback: function () {
            setTimeout(function(){$('#txtNroHCPac').trigger('focus');}, 2);
          }
        });
      } else if((datos[4] == null) || (datos[4] == "")){
        $('#txtIdSexoPac').prop("disabled", false);
        $('#txtNomPac').prop("readonly", false);
        $('#txtPriApePac').prop("readonly", false);
        $('#txtSegApePac').prop("readonly", false);
        $('#txtFecNacPac').prop("disabled", false);
        $('#txtIdPaisNacPac').prop("disabled", false);
        $('#txtIdEtniaPac').prop("disabled", false);
        //$("#txtIdPaisNacPac").val('').trigger("change");
        //$("#txtIdEtniaPac").val('').trigger("change");
        $("#txtNroHCPac").trigger('focus');
      } else {
        $("#txtNomPac").val(datos[4]);
        $("#txtPriApePac").val(datos[5]);
        $("#txtSegApePac").val(datos[6]);
        $("#txtIdSexoPac").val(datos[7]);
        $("#txtFecNacPac").val(datos[9]);
        $("#txtEdadPac").val(datos[20]);
        $("#txtNroTelFijoPac").val(datos[11]);
        $("#txtNroTelMovilPac").val(datos[12]);
        $("#txtEmailPac").val(datos[13]);
        $("#txtUBIGEOPac").val(datos[14]).trigger("change");
        $("#txtNroHCPac").val(datos[10]);
        $("#txtIdPaisNacPac").val(datos[21]).trigger("change");
        $("#txtDirPac").val(datos[18]);
        $("#txtDirRefPac").val(datos[19]);
        $('#txtNomPac').prop("readonly", true);
        $('#txtPriApePac').prop("readonly", true);
        $('#txtSegApePac').prop("readonly", true);
        $('#txtIdSexoPac').prop("disabled", true);
        $('#txtFecNacPac').prop("disabled", true);
        if(datos[9] == ""){
          $('#txtFecNacPac').prop("disabled", false);
        }
        if(datos[10] == ""){
          if(datos[22] != ""){
            $("#txtIdEtniaPac").val(datos[22]).trigger("change");
          } else {
            $('#txtIdEtniaPac').prop("disabled", false);
          }
          $('#txtNroHCPac').prop("readonly", false);
          $("#txtNroHCPac").trigger('focus');
        } else {
          if(datos[22] != ""){
            $("#txtIdEtniaPac").val(datos[22]).trigger("change");
          } else {
            $('#txtIdEtniaPac').prop("disabled", false);
            if(datos[14] != ""){
              $("#txtDirPac").trigger('focus');
            } else {
              $('#txtUBIGEOPac').select2('open');
            }
          }
        }
      }

      $('#txtIdTipDocSoliT').prop("disabled", false);
      $('#txtNroDocSoliT').prop("disabled", false);
      $('#btnSoliTSearch').prop("disabled", false);
    }
  });
}

function get_listaProvinciaAndDistrito(opt, id) {
  if(opt == ""){
    var txtIdDepPac = $('#txtIdDepPac').val();
  }else {
    var txtIdDepPac = opt;
  }

  if (txtIdDepPac == ""){
    $('#txtUBIGEOPac').html("<option value=''>--Seleccionar-</option>");
    return false;
  }
  $.ajax({
    url: "../../controller/ctrlUbigeo.php",
    type: "POST",
    dataType: "json",
    data: {
      accion: 'GET_SHOW_LISTAPROVINCIAANDDISTRITO', idDepPac: txtIdDepPac
    },
    success: function (result) {
      var newOption = "";
      newOption = "<option value=''>--Seleccionar-</option>";
      $(result).each(function (ii, oo) {
        newOption += "<option value='" + oo.id_ubigeo + "'"
        if(oo.id_ubigeo == id){
          newOption += " selected";
        }
        newOption += ">" + oo.provincia + " - " + oo.distrito + "</option>";
      });
      $('#txtUBIGEOPac').html(newOption);
      $("#txtUBIGEOPac").val('').trigger("change");
    }
  });
}

function validForm() {
  //$('#btnValidForm').prop("disabled", true);
  var msg = "";
  var sw = true;

  var idpac = $('#txtIdPac').val();
  var tippac = document.frmSolicitud.txtTipPac.value;
  var docpac = $('#txtNroDocPac').val();

  if(tippac == ""){
    msg+= "Seleccione tipo del Paciente (SIS/PARTICULAR)<br/>";
    sw = false;
  }

  if(tippac == ""){
    msg+= "Ingrese Nro. de documento del Paciente<br/>";
    sw = false;
  }

  if(idpac == "0"){
    var sexopac = $('#txtIdSexoPac').val();
    var fecnacpac = $('#txtFecNacPac').val();
    var nompac = $('#txtNomPac').val();
    var priapepac = $('#txtPriApePac').val();
    var seapepac = $('#txtSegApePac').val();

    if(sexopac == ""){
      msg+= "Seleccione el sexo del Paciente<br/>";
      sw = false;
    }

    if(fecnacpac == ""){
      msg+= "Ingrese fecha de nacimiento del Paciente<br/>";
      sw = false;
    }

    if(nompac == ""){
      msg+= "Ingrese nombre del Paciente<br/>";
      sw = false;
    }

    if(priapepac == ""){
      if(seapepac == ""){
        msg+= "Ingrese el apellido paterno o materno del Paciente<br/>";
        sw = false;
      }
    }
  } else {
    var fecnacpac = $('#txtFecNacPac').val();
    if(fecnacpac == ""){
      msg+= "Ingrese fecha de nacimiento del Paciente<br/>";
      sw = false;
    }
  }

  var nrohcpac = $('#txtNroHCPac').val();
  var paispac = $('#txtIdPaisNacPac').val();
  var etniapac = $('#txtIdEtniaPac').val();
  var ubigeopac = $('#txtUBIGEOPac').val();
  var dirpac = $('#txtDirPac').val();
  var refdirpac = $('#txtDirRefPac').val();
  var telfipac = $('#txtNroTelFijoPac').val();
  var telmopac = $('#txtNroTelMovilPac').val();
  var emailpac = $('#txtEmailPac').val();

  if(paispac == ""){
    msg+= "Seleccione país de nacimiento del Paciente<br/>";
    sw = false;
  }

  if(etniapac == ""){
    msg+= "Seleccione Etnia del Paciente<br/>";
    sw = false;
  }

  if(nrohcpac == ""){
    msg+= "Ingrese historia clínica del Paciente<br/>";
    sw = false;
  }

  if(telfipac != ""){
    var ltelfipac = telfipac.length;
    if(ltelfipac < 7){
      msg+= "Ingrese correctamente el número de teléfono fijo de la Paciente<br/>";
      sw = false;
    }
  }

  if(telmopac != ""){
    var ltelmopac = telmopac.length;
    if(ltelmopac < 9){
      msg+= "Ingrese correctamente el número de teléfono móvil de la Paciente<br/>";
      sw = false;
    }
  }

  if(ubigeopac == ""){
    msg+= "Seleccione el Distrio de la dirección de la Paciente<br/>";
    sw = false;
  }

  if(emailpac != ""){
    if(validateEmail(emailpac) === false){
      msg+= "Ingrese correctamente el email del Paciente<br/>";
      sw = false;
    };
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
          url: '../../controller/ctrlCerits.php',
          data: {
            accion: 'POST_ADD_REGSOLICITUD',
            txtTipPac: document.frmSolicitud.txtTipPac.value,
            txtIdPac: document.frmSolicitud.txtIdPac.value, txtIdTipDocPac: document.frmSolicitud.txtIdTipDocPac.value, txtNroDocPac: document.frmSolicitud.txtNroDocPac.value, txtNroHCPac: document.frmSolicitud.txtNroHCPac.value, txtNomPac: document.frmSolicitud.txtNomPac.value, txtPriApePac: document.frmSolicitud.txtPriApePac.value, txtSegApePac: document.frmSolicitud.txtSegApePac.value, txtIdSexoPac: document.frmSolicitud.txtIdSexoPac.value, txtFecNacPac: document.frmSolicitud.txtFecNacPac.value, txtIdPaisNacPac: document.frmSolicitud.txtIdPaisNacPac.value, txtIdEtniaPac: document.frmSolicitud.txtIdEtniaPac.value, txtUBIGEOPac: document.frmSolicitud.txtUBIGEOPac.value, txtDirPac: document.frmSolicitud.txtDirPac.value, txtDirRefPac: document.frmSolicitud.txtDirRefPac.value, txtNroTelFijoPac: document.frmSolicitud.txtNroTelFijoPac.value, txtNroTelMovilPac: document.frmSolicitud.txtNroTelMovilPac.value, txtEmailPac: document.frmSolicitud.txtEmailPac.value,
            txtIdAtencion: document.frmSolicitud.txtIdAtencion.value,
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $('#txtIdAtencion').val(msg);
              $("#saveSolicitud").hide();
              $("#saveExportar").show();
            } else {
              bootbox.alert(msg);
              $('#btnValidForm').prop("disabled", false);
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

$(document).ready(function() {

  $('#txtFecNacPac').inputmask();
  $('#txtFecNacPac').datetimepicker({
    locale: 'es',
    format: 'L'
  });

  $('#txtIdPaisNacPac').select2();
  $('#txtIdEtniaPac').select2();
  $('#txtIdDepPac').select2();
  $('#txtUBIGEOPac').select2();

  $("#txtFecNacPac").focusout(function () {
    fecha_fin = '<?php echo date("d/m/Y")?>';//$("#txtFecNacPac").val();
    fecha_ini = $(this).val();
    if(fecha_ini != ""){
      $.post("../../controller/ctrlTipo.php", { fecha_ini: fecha_ini, fecha_fin: fecha_fin, accion: "GET_FUNC_CALCULAEDAD" }, function(data){
        var datos = eval(data);
        $("#txtEdadPac").val(datos[0]);
      });
    } else {
      //setTimeout(function(){$('#txtFecNacPac').trigger('focus');}, 2);
    }
  });

});

</script>
<?php require_once '../include/masterfooter.php'; ?>

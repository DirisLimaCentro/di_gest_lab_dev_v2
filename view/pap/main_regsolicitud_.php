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
      <h3 class="panel-title"><strong>Registro de Atención para PAP</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmSolicitud" id="frmSolicitud">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="0"/>
        <input type="hidden" name="txtIdPac" id="txtIdPac" value="0"/>
        <input type="hidden" name="txtIdSoli" id="txtIdSoli" value="0"/>
        <div class="row">
          <div class="col-sm-4">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Datos del paciente</strong></h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <label style="font-weight: bold !important;">Tipo de Paciente:</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <label><input type="radio" name="txtTipPac" id="txtTipPac1" value="1"/> SIS </label> &nbsp;&nbsp;&nbsp;
                      <label><input type="radio" name="txtTipPac" id="txtTipPac2" value="0"/> PARTICULAR</label>
                    </span>
                    <select class="form-control" name="txtIdTipPacParti" id="txtIdTipPacParti" onkeydown="campoSiguiente('txtNroDocPac', event);" disabled>
                      <option value=""> -- Seleccione --</option>
                      <option value="1">PAGANTE</option>
                      <option value="2">PROGRAMA</option>
                    </select>
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
                <div id="datos-sis" style="display: none;">
                  <label style="font-weight: bold !important;">Datos FUA (Opcional)</label>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-7">
                        <label for="txtNroFUA">N° FUA:</label>
                        <input type="text" name="txtNroFUA" id="txtNroFUA" onfocus="this.select()" class="form-control" maxlength="20" onkeydown="campoSiguiente('txtUBIGEOPac', event);"/>
                      </div>
                      <div class="col-sm-5">
                        <label for="txtCodPrestacional">Cod. Prestacional</label>
                        <input type="text" name="txtCodPrestacional" id="txtCodPrestacional" class="form-control" maxlength="3" value="024" readonly/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
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
                <fieldset class="scheduler-border">
                  <legend class="scheduler-border" style="margin-bottom: 0px;">Datos del apoderado (<span class="text-primary" id="show-datos-soli" style="cursor: pointer;" onclick="show_datos_soli()">Mostrar</span>)</legend>
                  <div id="datos-soli" style="display: none;">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-12">
                          <label for="txtIdTipDocSoliT">Documento de identidad:</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <?php $rsT = $t->get_listaTipoDocPerNatuSinDocAndConDocAdulto(); ?>
                          <select class="form-control" name="txtIdTipDocSoliT" id="txtIdTipDocSoliT" onchange="maxlength_doc_bus_soli_t()" disabled>
                            <?php
                            foreach ($rsT as $row) {
                              echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . ": " . $row['descripcion'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group input-group">
                            <input type="text" name="txtNroDocSoliT" id="txtNroDocSoliT" placeholder="Número de documento" onfocus="this.select()" autocomplete="OFF" class="form-control" maxlength="8" onkeydown="campoSiguiente('btnSoliTSearch', event);" disabled/>
                            <div class="input-group-btn">
                              <button class="btn btn-info" type="button" id="btnSoliTSearch" onclick="buscar_datos_personales_soli('1')" disabled><i class="fa fa-search"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="txtNomCompleSoli">Nombre completo</label>
                      <div class="input-group input-group">
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-success" id="btnDeletAPo" onclick="delete_apo('')"><i class="fa fa-remove"></i> Quitar</button>
                        </div>
                        <input type="text" class="form-control text-uppercase" name="txtNomCompleSoli" id="txtNomCompleSoli" maxlength="175" value="" readonly/>
                      </div>
                      <span id="lbl-parentesco" class="help-block"></span>
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Datos de la atención</strong></h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <label for="txtIdCondiDepen">Condición del Paciente en el EESS</label>
                  <select class="form-control" name="txtIdCondiDepen" id="txtIdCondiDepen" onkeydown="campoSiguiente('txtIdCondiServ', event);" disabled>
                    <option value="">-- Seleccione --</option>
                    <option value="1">NUEVO</option>
                    <option value="2">CONTINUADOR</option>
                    <option value="3">REINGRESO</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="txtIdCondiServ">Condición del Paciente en el Servicio</label>
                  <select class="form-control" name="txtIdCondiServ" id="txtIdCondiServ" onkeydown="campoSiguiente('txtIRS', event);" disabled>
                    <option value="">-- Seleccione --</option>
                    <option value="1">NUEVO</option>
                    <option value="2">CONTINUADOR</option>
                    <option value="3">REINGRESO</option>
                  </select>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-4">
                      <label for="txtIRS" class="control-label">Edad IRS:</label>
                      <input type="text" class="form-control" name="txtIRS" id="txtIRS" onfocus="this.select()" maxlength="2" value="" onkeydown="campoSiguiente('txtFUR', event);" disabled/>
                    </div>
                    <div class="col-sm-8">
                      <label for="txtFechaFUR" class="control-label">FUR:</label>
                      <div class="input-group input-group">
                        <div class="input-group-addon">
                          <label class="checkbox-inline" style="margin-left:0px !important; padding-left:0px !important;">
                            <input type="radio" class="check_fur" name="txtFUR" id="txtFUR1" value="1" disabled> Si
                          </label>
                          <label class="checkbox-inline" style="margin-left:0px !important">
                            <input type="radio" class="check_fur" name="txtFUR" id="txtFUR2" value="0" disabled> No
                          </label>
                        </div>
                        <input type="text" name="txtFechaFUR" id="txtFechaFUR" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtIdGestante', event);" disabled/>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-8">
                      <label for="txtFechaFUR" class="control-label">Gestante/FPP:</label>
                      <div class="input-group input-group">
                        <div class="input-group-addon">
                          <label class="checkbox-inline" style="margin-left:0px !important; padding-left:0px !important;">
                            <input type="radio" class="check_gestante" name="txtIdGestante" id="txtIdGestante1" value="1" disabled> Si
                          </label>
                          <label class="checkbox-inline" style="margin-left:0px !important">
                            <input type="radio" class="check_gestante" name="txtIdGestante" id="txtIdGestante2" value="0" disabled> No
                          </label>
                        </div>
                        <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-2">
                      <label for="txtGest" class="control-label">GEST:</label>
                      <input type="text" class="form-control" name="txtGest" id="txtGest" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA1', event);" disabled/>
                    </div>
                    <div class="col-sm-10">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="row">
                            <label for="txtPARA1" class="col-sm-3 control-label">PARA:</label>
                          </div>
                        </div>
                        <div class="col-sm-12">
                          <div class="row">
                            <div class="col-sm-3">
                              <input type="text" class="form-control" name="txtPARA1" id="txtPARA1" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA2', event);" disabled/>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" class="form-control" name="txtPARA2" id="txtPARA2" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA3', event);" disabled/>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" class="form-control" name="txtPARA3" id="txtPARA3" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA4', event);" disabled/>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" class="form-control" name="txtPARA4" id="txtPARA4" onfocus="this.select()" maxlength="2" value="0" disabled/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <label for="txtPesoPac">PESO (Kg):</label>
                      <div class="input-group input-group">
                        <div class="input-group-addon"><i class="fa fa-balance-scale"></i></div>
                        <input type="text" name="txtPesoPac" id="txtPesoPac" onfocus="this.select()" class="form-control" maxlength="7" value="" onkeydown="campoSiguiente('txtTallaPac', event);" disabled/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label for="txtTallaPac">Talla (cm):</label>
                      <div class="input-group input-group">
                        <div class="input-group-addon"><i class="fa fa-child"></i></div>
                        <input type="text" name="txtTallaPac" id="txtTallaPac" onfocus="this.select()" class="form-control" maxlength="7" value="" onkeydown="campoSiguiente('txtPAPac', event);" disabled/>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <label for="txtPAPac">P.A. (mmHg):</label>
                      <div class="input-group input-group">
                        <div class="input-group-addon"><i class="fa fa-heart"></i></div>
                        <input type="text" name="txtPAPac" id="txtPAPac" onfocus="this.select()" class="form-control" maxlength="7" value="" onkeydown="campoSiguiente('txtPAPANte', event);" disabled/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Tamizaje de cuello úterino anterior</strong></h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="txtPAPANte">Tamizaje anterior</label>
                  <select class="form-control" name="txtPAPANte" id="txtPAPANte" disabled>
                    <option value=""> -- Seleccione  -- </option>
                    <option value="1">PAP</option>
                    <option value="2">BIOPSIA</option>
                    <option value="3">IVAA</option>
                    <option value="4">VPH</option>
                    <option value="0">NINGUNO</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="txtResultadoAnte">Resultado</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtResultadoAnte" id="txtResultadoAnte1" value="1" class="opt_resulante" disabled/>
                      Positivo
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="txtResultadoAnte" id="txtResultadoAnte2" value="2" class="opt_resulante" disabled/>
                      Negativo
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Año último tamizaje con resultado</label>
                  <input type="text" name="txAnioResulAnte" id="txAnioResulAnte" onfocus="this.select()" class="form-control" maxlength="4" value=""  onkeydown="campoSiguiente('txtDetResultadoAnte', event);" disabled/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><strong>Anormalidad de células epiteliales escamosas</strong></h3>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <div class="radio" style="margin-top: 0px !important;">
                        <label>
                          <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa1" class="opt_anorescamosa" value="1" disabled/>
                          ASCUS
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa2" class="opt_anorescamosa" value="2" disabled/>
                          L.I.E. de bajo grado
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa3" class="opt_anorescamosa" value="3" disabled/>
                          ASCH
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa4" class="opt_anorescamosa" value="4" disabled/>
                          L.I.E. de alto grado
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa5" class="opt_anorescamosa" value="5" disabled/>
                          CARCINOMA IN SITU
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa6" class="opt_anorescamosa" value="6" disabled/>
                          CARCINOMA INVASOR
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><strong>Anormalidad de células epiteliales Glandulares</strong></h3>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <div class="radio">
                        <label>
                          <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular1" class="opt_anorglandular" value="1" disabled/>
                          Celulas glandulares atipicas
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular2" class="opt_anorglandular" value="2" disabled/>
                          Celulas glandulares atipicas sugestivas de neoplasia
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular3" class="opt_anorglandular" value="3" disabled/>
                          Adenocarcinoma in situ
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular4" class="opt_anorglandular" value="4" disabled/>
                          Adenocarcinoma
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Anticonceptivos</strong></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-12">
                    <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo5" value="5" disabled/> NINGUNO</label>
                    <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo2" value="1" disabled/> DIU</label>
                    <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo1" value="2" disabled/> ORAL</label>
                    <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo3" value="3" disabled/> INYEC</label>
                    <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo4" value="4" disabled/> IMPLANTE</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="checkbox">
                      <div class="input-group input-group">
                        <span class="input-group-addon">
                          <label class="radio-inline">
                            <input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo6" value="6" disabled/> OTROS
                          </label>
                        </span>
                        <input class="form-control" type="text" name="txtDetAnticonceptivo" id="txtDetAnticonceptivo" maxlength="185" value="" onkeydown="campoSiguiente('txtIdGestante', event);" disabled/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Síntomas actuales</strong></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-12">
                    <label class="checkbox-inline"><input type="checkbox" class="check_sintoma" name="txtSintoma" id="txtSintoma1" value="1" disabled/> NINGUNO</label>
                    <label class="checkbox-inline"><input type="checkbox" class="check_sintoma" name="txtSintoma" id="txtSintoma2" value="2" disabled/> DOLOR</label>
                    <label class="checkbox-inline"><input type="checkbox" class="check_sintoma" name="txtSintoma" id="txtSintoma3" value="3" disabled/> LEUCORREA</label>
                    <label class="checkbox-inline"><input type="checkbox" class="check_sintoma" name="txtSintoma" id="txtSintoma4" value="4" disabled/> PRURITO</label>
                    <label class="checkbox-inline"><input type="checkbox" class="check_sintoma" name="txtSintoma" id="txtSintoma5" value="5" disabled/> COITORRAGIA</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="checkbox">
                      <div class="input-group input-group">
                        <span class="input-group-addon">
                          <label class="checkbox-inline">
                            <input type="checkbox" class="check_sintoma" name="txtSintoma" id="txtSintoma6" value="6" disabled/> OTROS
                          </label>
                        </span>
                        <input class="form-control" type="text" name="txtDetSintoma" id="txtDetSintoma" maxlength="185" value="" onkeydown="campoSiguiente('txtIdGestante', event);" disabled/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Examen cervico uterino (Espéculo)</strong></h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-3">
                <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="check_exacervico" name="txtExaCervico" id="txtExaCervico1" value="1" disabled/>
                      CONGESTIÓN (Amarrillo)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="check_exacervico" name="txtExaCervico" id="txtExaCervico2" value="2" disabled/>
                      ECTROPIÓN (Azul)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="check_exacervico" name="txtExaCervico" id="txtExaCervico3" value="3" disabled/>
                      ULCERACIÓN (Rojo)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="check_exacervico" name="txtExaCervico" id="txtExaCervico4" value="4" disabled/>
                      PÓLIPOS (Anaranjado)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="check_exacervico" name="txtExaCervico" id="txtExaCervico5" value="5" disabled/>
                      TUMORACIÓN (Verde)
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-sm-9">
                <div id="paint-app"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Observaciones de la atención</strong></h3>
          </div>
          <div class="panel-body" style="padding-top: 5px !important; padding-bottom: 5px !important;">
            <div class="form-group">
              <textarea name="txtObsSoli" id="txtObsSoli" class="form-control" rows="3" disabled></textarea>
            </div>
          </div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Procedimientos realizados</strong></h3>
          </div>
          <div class="panel-body">
            <div class="row" id="diag-1">
              <div class="col-md-2">
                <label for="txtIdDepOri">Código:</label>
              </div>
              <div class="col-md-6">
                <label for="txtIdDepOri">Nombre:</label>
              </div>
            </div>
            <div class="row" id="diag-1">
              <div class="col-md-2">
                <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="88141" disabled/>
              </div>
              <div class="col-md-4">
                <div class="input-group input-group">
                  <div class="input-group-btn">
                    <button type="button" class="btn" disabled>DIFINITIVO</button>
                  </div>
                  <input type="text" name="txtNomDiagnostico" placeholder="Ingrese descripción" id="txtNomDiagnostico" class="form-control" maxlength="500" value="TOMA DE PAPANICOLAOU" disabled/>
                </div>

              </div>
            </div>
            <br/>
            <div class="row">
              <div class="col-sm-6">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><strong>Diagnóstico clínico</strong></h3>
                  </div>
                  <div class="panel-body">
                    <div class="row" style="padding-top: 5px;" id="diag-11">
                      <div class="col-sm-3 col-md-2">
                        <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="Z01.4" disabled/>
                        <input type="hidden" name="lblZ014" id="lblZ014" value="1"/>
                      </div>
                      <div class="col-sm-9 col-md-10">
                        <div class="input-group input-group">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-success" id="btnDeletZ014" onclick="delete_diag('Z01.4')"><i class="fa fa-remove"></i> Quitar</button>
                          </div>
                          <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="EXAMEN GINECOLÓGICO (GENERAL) (DE RUTINA)" disabled/>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="padding-top: 5px;" id="diag-9">
                      <div class="col-sm-3 col-md-2">
                        <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="N84.1" disabled/>
                        <input type="hidden" name="lblN841" id="lblN841" value="1"/>
                      </div>
                      <div class="col-sm-9 col-md-10">
                        <div class="input-group input-group">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-success" id="btnDeletN841" onclick="delete_diag('N84.1')"><i class="fa fa-remove"></i> Quitar</button>
                          </div>
                          <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="POLIPO DEL CUELLO UTERINO" disabled/>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="padding-top: 5px;" id="diag-10">
                      <div class="col-sm-3 col-md-2">
                        <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="N86" disabled/>
                        <input type="hidden" name="lblN86" id="lblN86" value="1"/>
                      </div>
                      <div class="col-sm-9 col-md-10">
                        <div class="input-group input-group">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-success" id="btnDeletN86" onclick="delete_diag('N86')"><i class="fa fa-remove"></i> Quitar</button>
                          </div>
                          <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="EROSIÓN Y ECTROPIÓN" disabled/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><strong>Insumos</strong></h3>
                  </div>
                  <div class="panel-body">
                    <div class="row" style="padding-top: 5px;" id="diag-4">
                      <div class="col-sm-3 col-md-2">
                        <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="23904" disabled/>
                        <input type="hidden" name="lbl23904" id="lbl23904" value="1"/>
                      </div>
                      <div class="col-sm-9 col-md-10">
                        <div class="input-group input-group">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-success" id="btnDelet23904" onclick="delete_diag('23904')"><i class="fa fa-remove"></i> Quitar</button>
                          </div>
                          <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="CITOCEPILLO PARA PAPANICOLAU" disabled/>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="padding-top: 5px;" id="diag-5">
                      <div class="col-sm-3 col-md-2">
                        <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="29448" disabled/>
                        <input type="hidden" name="lbl29448" id="lbl29448" value="1"/>
                      </div>
                      <div class="col-sm-9 col-md-10">
                        <div class="input-group input-group">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-success" id="btnDelet29448" onclick="delete_diag('29448')"><i class="fa fa-remove"></i> Quitar</button>
                          </div>
                          <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="GUANTES DESCARTABLES TALLA M" disabled/>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="padding-top: 5px;" id="diag-6">
                      <div class="col-sm-3 col-md-2">
                        <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="25122" disabled/>
                        <input type="hidden" name="lbl25122" id="lbl25122" value="1"/>
                      </div>
                      <div class="col-sm-9 col-md-10">
                        <div class="input-group input-group">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-success" id="btnDelet25122" onclick="delete_diag('25122')"><i class="fa fa-remove"></i> Quitar</button>
                          </div>
                          <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="ESPECULO VAGINAL DESCARTABLE MEDIANO" disabled/>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="padding-top: 5px;" id="diag-7">
                      <div class="col-sm-3 col-md-2">
                        <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="25391" disabled/>
                        <input type="hidden" name="lbl25391" id="lbl25391" value="1"/>
                      </div>
                      <div class="col-sm-9 col-md-10">
                        <div class="input-group input-group">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-success" id="btnDelet25391" onclick="delete_diag('25391')"><i class="fa fa-remove"></i> Quitar</button>
                          </div>
                          <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="ESPATULA DE AYRE DE MADERA" disabled/>
                        </div>
                      </div>
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
                  <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Guardar Solicitud </button>
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

<div class="modal fade" id="showSoliModal" role="dialog" aria-labelledby="showSoliModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showSoliModalLabel">Registro de apoderado</h4>
      </div>
      <div class="modal-body">
        <form name="frmSolicitante" id="frmSolicitante">
          <div class="form-group">
            <div class="row">
              <div class="col-sm-7">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtIdTipDocSoli">Documento de identidad</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-4" style="padding-right: 0!important;">
                    <?php $rsT = $t->get_listaTipoDocPerNatuConDocAdulto(); ?>
                    <select class="form-control input-sm" name="txtIdTipDocSoli" id="txtIdTipDocSoli" onchange="maxlength_doc_bus_soli()" disabled>
                      <?php
                      foreach ($rsT as $row) {
                        echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . ": " . $row['descripcion'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-xs-8" style="padding-left: 0!important;">
                    <div class="input-group input-group-sm">
                      <input type="text" name="txtNroDocSoli" id="txtNroDocSoli" class="form-control input-sm" maxlength="8" onkeydown="campoSiguiente('btnSoliSearch', event);" disabled/>
                      <div class="input-group-btn">
                        <button class="btn btn-success" type="button" id="btnSoliSearch" onclick="buscar_datos_personales_soli('2')" disabled><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <label for="txtPriApeSoli">Apellido paterno</label>
                <input type="text" name="txtPriApeSoli" id="txtPriApeSoli" class="form-control input-sm" maxlength="75" onkeydown="campoSiguiente('txtSegApeSoli', event);" readonly/>
              </div>
              <div class="col-sm-6">
                <label for="txtSegApeSoli">Apellido materno</label>
                <input type="text" name="txtSegApeSoli" id="txtSegApeSoli" class="form-control input-sm" maxlength="75" onkeydown="campoSiguiente('txtNomSoli', event);" readonly/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtNomSoli">Nombre(s)</label>
            <input type="text" name="txtNomSoli" class="form-control input-sm" id="txtNomSoli" maxlength="180" onkeydown="campoSiguiente('txtIdSexoSoli', event);" readonly/>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6 col-md-3">
                <label for="txtIdSexoSoli">Sexo</label>
                <select class="form-control input-sm" name="txtIdSexoSoli" id="txtIdSexoSoli" onkeydown="campoSiguiente('txtFecNacSoli', event);" disabled>
                  <option value="">Seleccione</option>
                  <option value="1">M</option>
                  <option value="2">F</option>
                </select>
              </div>
              <div class="col-sm-6 col-md-4">
                <label for="txtFecNacSoli">Fecha Nac.</label>
                <div class="input-group input-group-sm">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" name="txtFecNacSoli" id="txtFecNacSoli" placeholder="DD/MM/AAAA" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtIdParenSoli', event);" disabled/>
                </div>
              </div>
              <div class="col-sm-6 col-md-5">
                <label for="txtIdParenSoli">Parentesco</label>
                <?php $rsTP = $t->get_listaParentesco(); ?>
                <select class="form-control input-sm" name="txtIdParenSoli" id="txtIdParenSoli" style="width: 100%" onkeydown="campoSiguiente('txtIdPaisNacSoli', event);" disabled>
                  <option value="">Seleccione</option>
                  <?php
                  foreach ($rsTP as $row) {
                    echo "<option value='" . $row['id_parentesco'] . "'>" . $row['nom_parentesco'] . "</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <label for="txtIdPaisNacSoli">País de nacimiento</label>
                <select class="form-control" style="width: 100%" name="txtIdPaisNacSoli" id="txtIdPaisNacSoli" onkeydown="campoSiguiente('txtIdEtniaSoli', event);" disabled>
                  <option value="">-- Seleccione --</option>
                  <?php
                  $rsPP = $ub->get_listaPais();
                  foreach ($rsPP as $rowPP) {
                    echo "<option value='" . $rowPP['id_pais'] . "'>" . $rowPP['nom_pais'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-6">
                <label for="txtIdEtniaSoli">ETNIA</label>
                <select class="form-control" style="width: 100%" name="txtIdEtniaSoli" id="txtIdEtniaSoli" onkeydown="campoSiguiente('txtNroTelFijoSoli', event);" disabled>
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
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <label for="txtNroTelFijoSoli">Telf. Fijo</label>
                <div class="input-group input-group-sm">
                  <div class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></div>
                  <input type="text" name="txtNroTelFijoSoli" placeholder="999999999" id="txtNroTelFijoSoli" class="form-control input-sm" maxlength="9" value="" onkeydown="campoSiguiente('txtNroTelMovilSoli', event);"/>
                </div>
              </div>
              <div class="col-sm-6">
                <label for="txtNroTelMovilSoli">Telf. Móvil</label>
                <div class="input-group input-group-sm">
                  <div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
                  <input type="text" name="txtNroTelMovilSoli" placeholder="999999999" id="txtNroTelMovilSoli" class="form-control input-sm" maxlength="9" value="" onkeydown="campoSiguiente('txtEmailSoli', event);"/>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtEmailSoli">Email</label>
            <div class="input-group input-group-sm">
              <div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
              <input type="text" name="txtEmailSoli" placeholder="@example.com" id="txtEmailSoli" class="form-control input-sm" maxlength="50" value="" onkeydown="campoSiguiente('btnValidFormSoli', event);"/>
            </div>
            <span class="help-block">Para el Email, considere mayúsculas y minúsculas</span>
          </div>

        </form>
      </div>
      <div class="modal-footer" style="padding-bottom: 7px !important; padding-top: 7px !important;">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button type="button" class="btn btn-primary btn-continuar" id="btnValidFormSoli" onclick="validFormSoli('1')"><i class="fa fa-save"></i> Aceptar </button>
              <button type="button" class="btn btn-default" onclick="validFormSoli('2')"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="mostrar_datospac" class="modal fade" role="dialog" data-backdrop="static"></div>
<?php require_once '../include/footer.php'; ?>
<script type="text/javascript" src="main_principalsoli.js"></script>
<script type="text/javascript" src="../../assets/js/canvasregpap.js"></script>
<script Language="JavaScript">
var dd = ['88141','Z01.4','N84.1','N86','23904','29448','25122','25391'];

//alert(dd);

function delete_diag(nro){
  //alert(nro);
  var jo = '1';
  for (x=0;x<dd.length;x++){
      if(dd[x] == nro){
          dd.splice(x,1);
          jo = '2';
          break;
        }
  }
  if(jo == '1') dd.push(nro);

  nro = nro.replace(".", "");
  var iddiag = $("#lbl"+nro).val();
  if(iddiag == '2'){
    $("#btnDelet" + nro).html('<i class="fa fa-remove"></i> Quitar').removeClass("btn-default").addClass("btn-success");
    $("#lbl" + nro).val('1');
  } else {
    $("#btnDelet" + nro).html('<i class="glyphicon glyphicon-ok"></i> Agregar').removeClass("btn-success").addClass("btn-default");
    $("#lbl" + nro).val('2');
  }
  //alert(dd);
}
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
    enabled_datos_atencion();
    enabled_datos_tamizaje();
    enabled_datos_anticonceptivo();
    enabled_datos_sintoma();
    enabled_datos_examen();

    if($(this).val() == "1"){
      $("#datos-sis").show();
      $("#txtNroFUA").val('');
      $("#txtCodPrestacional").val('024');
      $("#txtIdTipPacParti").val('');
      $('#txtIdTipPacParti').prop("disabled", true);
      setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
    } else {
      $("#datos-sis").hide();
      $("#txtNroFUA").val('');
      $("#txtCodPrestacional").val('');
      $("#txtIdTipPacParti").val('');
      $('#txtIdTipPacParti').prop("disabled", false);
      setTimeout(function(){$('#txtIdTipPacParti').trigger('focus');}, 2);
    }
  });

  $('[name="txtAnticonceptivo"]').change(function()
  {
    if ($(this).is(':checked')) {
      if ($('#txtAnticonceptivo6').is(':checked')) {
        $("#txtDetAnticonceptivo").prop('disabled', false);
        setTimeout(function(){$('#txtDetAnticonceptivo').trigger('focus');}, 2);
      } else {
        $("#txtDetAnticonceptivo").val('');
        $("#txtDetAnticonceptivo").prop('disabled', true);
      }
    } else {
      if ($('#txtAnticonceptivo6').is(':checked')) {
        $("#txtDetAnticonceptivo").prop('disabled', false);
        setTimeout(function(){$('#txtDetAnticonceptivo').trigger('focus');}, 2);
      } else {
        $("#txtDetAnticonceptivo").val('');
        $("#txtDetAnticonceptivo").prop('disabled', true);
      }
    };
  });

  $('[name="txtPAPANte"]').change(function()
  {
    if(($(this).val() == "") || ($(this).val() == "0")){
      $(".opt_resulante").prop('checked', false);
      $(".opt_resulante").prop('disabled', true);
      $(".opt_anorescamosa").prop('checked', false);
      $(".opt_anorescamosa").prop('disabled', true);
      $(".opt_anorglandular").prop('checked', false);
      $(".opt_anorglandular").prop('disabled', true);
      $("#txAnioResulAnte").val('');
      $("#txAnioResulAnte").prop('disabled', true);
    } else {
      if(($(this).val() == "1") || ($(this).val() == "2")){
        $(".opt_anorescamosa").prop('checked', false);
        $(".opt_anorescamosa").prop('disabled', false);
        $(".opt_anorglandular").prop('checked', false);
        $(".opt_anorglandular").prop('disabled', false);
      } else {
        $(".opt_anorescamosa").prop('checked', false);
        $(".opt_anorescamosa").prop('disabled', true);
        $(".opt_anorglandular").prop('checked', false);
        $(".opt_anorglandular").prop('disabled', true);
      }
      $(".opt_resulante").prop('checked', false);
      $(".opt_resulante").prop('disabled', false);
      $("#txAnioResulAnte").val('');
      $("#txAnioResulAnte").prop('disabled', false);
    }
  });

  $('[name="txtResultadoAnte"]').change(function()
  {
    if ($(this).is(':checked')) {
      if($(this).val() == "1"){
        $(".opt_detresulante").prop('checked', false);
        $(".opt_detresulante").prop('disabled', false);
        setTimeout(function(){$('#txAnioResulAnte').trigger('focus');}, 2);
      }
      if($(this).val() == "2"){
        $(".opt_detresulante").prop('checked', false);
        $(".opt_detresulante").prop('disabled', true);
        setTimeout(function(){$('#txAnioResulAnte').trigger('focus');}, 2);
      }
    }
  });

  $('[name="txtAnorEscamosa"]').change(function()
  {
    if ($(this).is(':checked')) {
      $(".opt_anorglandular").prop('disabled', true);
    };
  });

  $('[name="txtAnorGlandular"]').change(function()
  {
    if ($(this).is(':checked')) {
      $(".opt_anorescamosa").prop('disabled', true);
    };
  });


  $('[name="txtSintoma"]').change(function()
  {
    if ($(this).is(':checked')) {
      if ($('#txtSintoma6').is(':checked')) {
        $("#txtDetSintoma").prop('disabled', false);
        setTimeout(function(){$('#txtDetSintoma').trigger('focus');}, 2);
      } else {
        $("#txtDetSintoma").val('');
        $("#txtDetSintoma").prop('disabled', true);
      }
    } else {
      if ($('#txtSintoma').is(':checked')) {
        $("#txtDetSintoma").prop('disabled', false);
        setTimeout(function(){$('#txtDetSintoma').trigger('focus');}, 2);
      } else {
        $("#txtDetSintoma").val('');
        $("#txtDetSintoma").prop('disabled', true);
      }
    };
  });

  $('[name="txtFUR"]').change(function()
  {
    if ($(this).is(':checked')) {
      $("#txtFechaFUR").prop('disabled', false);
      var mask = "dd/mm/yyyy";
      if($(this).val() == "1"){
        $("#txtFechaFUR").inputmask();
        $('#txtFechaFUR').datetimepicker({
          locale: 'es',
          format: 'L'
        });
      } else {
        $("#txtFechaFUR").inputmask('remove');
        $("#txtFechaFUR").datetimepicker('destroy');
        $("#txtFechaFUR").val('');
      }
      setTimeout(function(){$('#txtFechaFUR').trigger('focus');}, 2);
    };
  });

  $('[name="txtIdGestante"]').change(function()
  {
    if ($(this).is(':checked')) {
      var mask = "dd/mm/yyyy";
      if($(this).val() == "1"){
        $("#txtFechaParto").prop('disabled', false);
        $("#txtFechaParto").inputmask();
        $('#txtFechaParto').datetimepicker({
          locale: 'es',
          format: 'L'
        });
        setTimeout(function(){$('#txtFechaParto').trigger('focus');}, 2);
      } else {
        $("#txtFechaParto").prop('disabled', true);
        $("#txtFechaParto").inputmask('remove');
        $("#txtFechaParto").datetimepicker('destroy');
        $("#txtFechaParto").val('');
        setTimeout(function(){$('#txtGest').trigger('focus');}, 2);
      }
    };
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
    if (txtNroDocLn <= 8) {
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
        if(datos[7] == "1"){
          $("#txtIdPac").val('0');
          bootbox.alert({
            message: "El paciente debe ser de sexo <b>FEMENINO</b>",
            callback: function () {
              setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
            }
          });
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
      }

      $('#txtIdTipDocSoliT').prop("disabled", false);
      $('#txtNroDocSoliT').prop("disabled", false);
      $('#btnSoliTSearch').prop("disabled", false);
    }
  });
}

function buscar_datos_personales_soli(opt){
  $('#txtIdSoli').val('0');
  var msg = "";
  var sw = true;
  if(opt == "1"){
    var txtIdTipDoc = $('#txtIdTipDocSoliT').val();
    var txtNroDoc = $('#txtNroDocSoliT').val();
  } else {
    var txtIdTipDoc = $('#txtIdTipDocSoli').val();
    var txtNroDoc = $('#txtNroDocSoli').val();
  }
  var txtNroDocLn = txtNroDoc.length;

  $("#txtNomSoli").val('');
  $("#txtPriApeSoli").val('');
  $("#txtSegApeSoli").val('');
  $("#txtIdSexoSoli").val('');
  $("#txtFecNacSoli").val('');
  $("#txtNroTelFijoSoli").val('');
  $("#txtNroTelMovilSoli").val('');
  $("#txtEmailSoli").val('');

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

  //$('#btnSoliSearch').prop("disabled", true);
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
      $("#txtIdSoli").val(datos[0]);
      if((datos[4] == null) || (datos[4] == "")){
        $('#txtIdSexoSoli').prop("disabled", false);
        $('#txtNomSoli').prop("readonly", false);
        $('#txtPriApeSoli').prop("readonly", false);
        $('#txtSegApeSoli').prop("readonly", false);
        $('#txtFecNacSoli').prop("disabled", false);
        $('#txtIdParenSoli').prop("disabled", false);
        $('#txtIdPaisNacSoli').prop("disabled", false);
        $('#txtIdEtniaSoli').prop("disabled", false);
        $("#txtIdSexoSoli").trigger('focus');
      } else {
        $("#txtIdTipDocSoli").val(datos[1]);
        $("#txtNroDocSoli").val(datos[3]);
        $("#txtNomSoli").val(datos[4]);
        $("#txtPriApeSoli").val(datos[5]);
        $("#txtSegApeSoli").val(datos[6]);
        $("#txtIdSexoSoli").val(datos[7]);
        $("#txtFecNacSoli").val(datos[9]);
        $("#txtIdPaisNacSoli").val(datos[21]).trigger("change");
        $("#txtNroTelFijoSoli").val(datos[11]);
        $("#txtNroTelMovilSoli").val(datos[12]);
        $("#txtEmailSoli").val(datos[13]);
        $('#txtNomSoli').prop("readonly", true);
        $('#txtPriApeSoli').prop("readonly", true);
        $('#txtSegApeSoli').prop("readonly", true);
        $('#txtIdSexoSoli').prop("disabled", true);
        $('#txtFecNacSoli').prop("disabled", true);
        $('#txtIdParenSoli').prop("disabled", false);
        if(datos[9] == ""){
          $('#txtFecNacSoli').prop("disabled", false);
        }
        if(datos[22] != ""){
          $("#txtIdEtniaSoli").val(datos[22]).trigger("change");
          $('#txtIdEtniaSoli').prop("disabled", true);
        } else {
          $('#txtIdEtniaSoli').prop("disabled", false);
        }
      }

      if(opt == "1"){
        $('#showSoliModal').modal({
          show: true,
          backdrop: 'static',
          focus: true,
        });

        $('#showSoliModal').on('shown.bs.modal', function (e) {
          /*$('#txtIdEtniaSoli').select2({
          dropdownParent: $('#showSoliModal')
        });*/
        $('#txtIdEtniaSoli').select2();
        $('#txtIdParenSoli').select2('open');
      })
    } else {
      $("#txtNroTelFijoSoli").trigger('focus');
    }

  }
});
}


function validFormSoli(opt){
  if(opt == "2"){
    $("#txtIdSoli").val('0');
    $("#txtIdTipDocSoliT").val('1');
    $("#txtNroDocSoliT").val('');
    $("#txtNomCompleSoli").val('');
    $("#lbl-parentesco").text('');
    $("#txtNroDocSoliT").prop("disabled", false);
    $("#btnSoliTSearch").prop("disabled", false);

    $("#txtNomSoli").val('');
    $("#txtPriApeSoli").val('');
    $("#txtSegApeSoli").val('');
    $("#txtIdSexoSoli").val('');
    $("#txtFecNacSoli").val('');
    $("#txtNroTelFijoSoli").val('');
    $("#txtNroTelMovilSoli").val('');
    $("#txtEmailSoli").val('');

    $("#txtIdParenSoli").val('').trigger("change");
    $("#txtIdPaisNacSoli").val('').trigger("change");
    $("#txtIdEtniaSoli").val('').trigger("change");



    $("#txtNroDocSoliT").trigger('focus');
  } else {
    $('#btnValidFormSoli').prop("disabled", true);

    var msg = "";
    var sw = true;
    var idpac = $('#txtIdSoli').val();
    var idparensoli = $("#txtIdParenSoli").val();
    var idetniasoli = $("#txtIdEtniaSoli").val();

    var telfipac = $('#txtNroTelFijoSoli').val();
    var telmopac = $('#txtNroTelMovilSoli').val();
    var emailpac = $('#txtEmailSoli').val();

    if(idpac == "0"){
      var sexopac = $('#txtIdSexoSoli').val();
      var fecnacpac = $('#txtFecNacSoli').val();
      var nompac = $('#txtNomSoli').val();
      var priapepac = $('#txtPriApeSoli').val();
      var seapepac = $('#txtSegApeSoli').val();

      if(sexopac == ""){
        msg+= "Seleccione el sexo del Apoderado<br/>";
        sw = false;
      }

      if(fecnacpac == ""){
        msg+= "Ingrese fecha de nacimiento del Apoderado<br/>";
        sw = false;
      }

      if(nompac == ""){
        msg+= "Ingrese nombre del Apoderado<br/>";
        sw = false;
      }

      if(priapepac == ""){
        if(seapepac == ""){
          msg+= "Ingrese el apellido paterno o materno del Apoderado<br/>";
          sw = false;
        }
      }
    } else {
      var fecnacpac = $('#txtFecNacPac').val();
      if(fecnacpac == ""){
        msg+= "Ingrese fecha de nacimiento del Apoderado<br/>";
        sw = false;
      }
    }

    if(idparensoli == ""){
      msg+= "Seleccione Parentesco del Apoderado<br/>";
      sw = false;
    }

    if(idetniasoli == ""){
      msg+= "Seleccione Etnia del Apoderado<br/>";
      sw = false;
    }

    if(telfipac != ""){
      var ltelfipac = telfipac.length;
      if(ltelfipac < 7){
        msg+= "Ingrese correctamente el número de teléfono fijo del Paciente<br/>";
        sw = false;
      }
    }

    if(telmopac != ""){
      var ltelmopac = telmopac.length;
      if(ltelmopac < 9){
        msg+= "Ingrese correctamente el número de teléfono móvil del Paciente<br/>";
        sw = false;
      }
    }

    if(emailpac != ""){
      if(validateEmail(emailpac) === false){
        msg+= "Ingrese correctamente el email del Paciente<br/>";
        sw = false;
      };
    }

    if (sw == false) {
      bootbox.alert(msg);
      $('#btnValidFormSoli').prop("disabled", false);
      return false;
    }

    $("#txtNomCompleSoli").val($("#txtPriApeSoli").val() + " " + $("#txtSegApeSoli").val() + " " + $("#txtNomSoli").val());
    $("#lbl-parentesco").text('Parentesco: ' + $("#txtIdParenSoli option:selected").text());
  }
  $("#showSoliModal").modal('hide');
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

function open_pdfsinvalor() {
  var idSoli = $('#txtIdAtencion').val();
  var urlwindow = "pdf_solisinvalor.php?id_solicitud=" + idSoli;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function saveViaAJAX(idaten)
{
  var testCanvas = document.getElementById("testCanvas");
  var canvasData = testCanvas.toDataURL("image/png");
  var postData = idaten + "=" + canvasData;
  //var postData = "canvasData="+canvasData;
  //var postData = 'txtIdAtencion,'+ $('#txtIdAtencion').val() + '&canvasData='+canvasData;
  //var debugConsole= document.getElementById("debugConsole");
  //debugConsole.value=canvasData;

  //alert("canvasData ="+canvasData );
  var ajax = new XMLHttpRequest();
  ajax.open("POST",'examen/testSave.php',true);
  ajax.setRequestHeader('Content-Type', 'canvas/upload');
  //ajax.setRequestHeader('Content-TypeLength', postData.length);

  ajax.onreadystatechange=function()
  {
    if (ajax.readyState == 4)
    {
      $("#saveSolicitud").hide();
      $("#saveExportar").show();
      //bootbox.alert("El registro se guardo correctamente.");
      open_datoslamina();
    }
  }

  ajax.send(postData);
}

function open_datoslamina(){
  var id = $("#txtIdAtencion").val();
  $('#mostrar_datospac').modal('show');
  $.ajax({
    url: '../../controller/ctrlPAP.php',
    type: 'POST',
    data: 'accion=GET_SHOW_DATOSATENCION&idSoli=' + id,
    success: function(data){
      $('#mostrar_datospac').html(data);
    }
  });
}

function validForm() {
  //$('#btnValidForm').prop("disabled", true);
  var msg = "";
  var sw = true;

  var idpac = $('#txtIdPac').val();
  var tippac = document.frmSolicitud.txtTipPac.value;
  var tipoparti = $('#txtIdTipPacParti').val();
  var docpac = $('#txtNroDocPac').val();

  if(tippac == ""){
    msg+= "Seleccione tipo del Paciente (SIS/PARTICULAR)<br/>";
    sw = false;
  }

  if(tippac == "0"){
    if(tipoparti == ""){
      msg+= "Seleccione tipo (PAGANTE/PROGAMA) paciente particular<br/>";
      sw = false;
    }
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

  var condieess = $('#txtIdCondiDepen').val();
  var condiserv = $('#txtIdCondiServ').val();
  var fur = document.frmSolicitud.txtFUR.value;
  var fecfur = document.frmSolicitud.txtFechaFUR.value;
  var gestante = document.frmSolicitud.txtIdGestante.value;
  var fecparto = $('#txtFechaParto').val();
  var papante = $('#txtPAPANte').val();

  if(condieess == ""){
    msg+= "Seleccione condición del paciente en el EESS<br/>";
    sw = false;
  }

  if(condiserv == ""){
    msg+= "Seleccione condición del paciente en el servicio<br/>";
    sw = false;
  }

  if(fur == ""){
    msg+= "Seleccione si la paciente tiene o no FUR<br/>";
    sw = false;
  }

  if(fur == "1"){
    if(fecfur == ""){
      msg+= "Ingrese fecha de FUR<br/>";
      sw = false;
    }
  }

  if(gestante == ""){
    msg+= "Seleccione si la paciente es gestante<br/>";
    sw = false;
  }

  if(gestante == "1"){
    if(fecparto == ""){
      msg+= "Ingrese fecha posible de parto<br/>";
      sw = false;
    }
  }

  if ($('#txtAnticonceptivo6').is(':checked')) {
    if(fecfur == ""){
      msg+= "Ingrese detalle de otro Método Anticonceptivo<br/>";
      sw = false;
    }
  }

  if(papante != "") {
    if(papante == "1" || papante == "2"){

      if ($('input.opt_resulante').is(':checked')) { //Positivo o Negativo
        $.each($('.opt_resulante:checked'), function() {
          if($(this).val() == "1"){ //Cuando selecciona positivo
            if ($('input.opt_anorescamosa').is(':checked')) {
            } else {
              if ($('input.opt_anorglandular').is(':checked')) {
              } else {
                msg+= "Seleccione el detalle del resultado final del examen Anterior<br/>";
                sw = false;
              }
            }

          };
        });
      } else {
        msg+= "Seleccione si el resultado del examen de PAP o Biopsia fue positivo o negativo<br/>";
        sw = false;
      }
      var nroregresul = $('#txAnioResulAnte').val();
      if(nroregresul == ""){
        msg+= "Ingrese año de tamizaje anterior<br/>";
        sw = false;
      }
    } else if (papante == "0") {

    } else {
      var nroregresul = $('#txAnioResulAnte').val();
      if(nroregresul == ""){
        msg+= "Ingrese año de tamizaje anterior<br/>";
        sw = false;
      }
    }
  } else {
    msg+= "Seleccione el tipo de tamizaje anterior del paciente<br/>";
    sw = false;
  }

  /*
  if ($('input.check_exacervico').is(':checked')) {
} else {
msg+= "Seleccione almenos una opción para el diagnóstico del Examen cervico uterino (Espéculo)<br/>";
sw = false;
}
*/
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
        if ($('input.check_anticonceptivo').is(':checked')) {
          var anticonceptivo = [];
          $.each($('.check_anticonceptivo:checked'), function() {
            anticonceptivo.push($(this).val());
          });
        } else {
          var anticonceptivo = '';
        }

        if ($('input.check_sintoma').is(':checked')) {
          var sintoma = [];
          $.each($('.check_sintoma:checked'), function() {
            sintoma.push($(this).val());
          });
        } else {
          var sintoma = '';
        }
        if ($('input.check_exacervico').is(':checked')) {
          var exacervico = [];
          $.each($('.check_exacervico:checked'), function() {
            exacervico.push($(this).val());
          });
        } else {
          var exacervico = '';
        }

        /*var coddiag = [];
        $("input[name='txtIdDiagnostico']").each(function() {
          coddiag.push($(this).val());
        });*/

        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlPAP.php',
          data: {
            accion: 'POST_ADD_REGSOLICITUD',
            txtTipPac: document.frmSolicitud.txtTipPac.value, txtIdTipPacParti: $("#txtIdTipPacParti").val(), txtNroFUA: document.frmSolicitud.txtNroFUA.value, txtCodPrestacional: document.frmSolicitud.txtCodPrestacional.value,
            txtIdPac: document.frmSolicitud.txtIdPac.value, txtIdTipDocPac: document.frmSolicitud.txtIdTipDocPac.value, txtNroDocPac: document.frmSolicitud.txtNroDocPac.value, txtNroHCPac: document.frmSolicitud.txtNroHCPac.value, txtNomPac: document.frmSolicitud.txtNomPac.value, txtPriApePac: document.frmSolicitud.txtPriApePac.value, txtSegApePac: document.frmSolicitud.txtSegApePac.value, txtIdSexoPac: document.frmSolicitud.txtIdSexoPac.value, txtFecNacPac: document.frmSolicitud.txtFecNacPac.value, txtIdPaisNacPac: document.frmSolicitud.txtIdPaisNacPac.value, txtIdEtniaPac: document.frmSolicitud.txtIdEtniaPac.value, txtUBIGEOPac: document.frmSolicitud.txtUBIGEOPac.value, txtDirPac: document.frmSolicitud.txtDirPac.value, txtDirRefPac: document.frmSolicitud.txtDirRefPac.value, txtNroTelFijoPac: document.frmSolicitud.txtNroTelFijoPac.value, txtNroTelMovilPac: document.frmSolicitud.txtNroTelMovilPac.value, txtEmailPac: document.frmSolicitud.txtEmailPac.value,
            txtIdSoli: document.frmSolicitud.txtIdSoli.value, txtIdTipDocSoli: document.frmSolicitante.txtIdTipDocSoli.value, txtNroDocSoli: document.frmSolicitante.txtNroDocSoli.value, txtNomSoli: document.frmSolicitante.txtNomSoli.value, txtPriApeSoli: document.frmSolicitante.txtPriApeSoli.value, txtSegApeSoli: document.frmSolicitante.txtSegApeSoli.value, txtIdSexoSoli: document.frmSolicitante.txtIdSexoSoli.value, txtFecNacSoli: document.frmSolicitante.txtFecNacSoli.value, txtIdParenSoli: document.frmSolicitante.txtIdParenSoli.value, txtIdPaisNacSoli: document.frmSolicitante.txtIdPaisNacSoli.value, txtIdEtniaSoli: document.frmSolicitante.txtIdEtniaSoli.value, txtNroTelFijoSoli: document.frmSolicitante.txtNroTelFijoSoli.value, txtNroTelMovilSoli: document.frmSolicitante.txtNroTelMovilSoli.value, txtEmailSoli: document.frmSolicitante.txtEmailSoli.value,
            txtIdAtencion: document.frmSolicitud.txtIdAtencion.value, txtIdCondiDepen: document.frmSolicitud.txtIdCondiDepen.value, txtIdCondiServ: document.frmSolicitud.txtIdCondiServ.value, txtFUR: document.frmSolicitud.txtFUR.value, txtFechaFUR: document.frmSolicitud.txtFechaFUR.value, txtIdGestante: document.frmSolicitud.txtIdGestante.value, txtFechaParto: document.frmSolicitud.txtFechaParto.value, txtGest: document.frmSolicitud.txtGest.value, txtPARA1: document.frmSolicitud.txtPARA1.value, txtPARA2: document.frmSolicitud.txtPARA2.value, txtPARA3: document.frmSolicitud.txtPARA3.value, txtPARA4: document.frmSolicitud.txtPARA4.value, txtPesoPac: document.frmSolicitud.txtPesoPac.value, txtTallaPac: document.frmSolicitud.txtTallaPac.value, txtPAPac: document.frmSolicitud.txtPAPac.value,
            txtPAPANte: document.frmSolicitud.txtPAPANte.value, txtResultadoAnte: document.frmSolicitud.txtResultadoAnte.value, txAnioResulAnte: document.frmSolicitud.txAnioResulAnte.value, txtAnorEscamosa: document.frmSolicitud.txtAnorEscamosa.value, txtAnorGlandular: document.frmSolicitud.txtAnorGlandular.value,
            txtAnticonceptivo: anticonceptivo, txtDetAnticonceptivo: document.frmSolicitud.txtDetAnticonceptivo.value, txtSintoma: sintoma, txtDetSintoma: document.frmSolicitud.txtDetSintoma.value,
            txtIRS: document.frmSolicitud.txtIRS.value, txtObsSoli: document.frmSolicitud.txtObsSoli.value,
            txtExaCervico: exacervico,
            txtIdDiagnostico: dd,
            rand: myRand,
          },
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $('#txtIdAtencion').val(msg);
              saveViaAJAX(msg);
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

  $('#txtIdParenSoli').select2();

  $('#txtNroFUA').inputmask("036-99-99999999");

  //setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);

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

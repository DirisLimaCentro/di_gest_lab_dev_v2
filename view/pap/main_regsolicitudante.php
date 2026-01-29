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
        <div class="row">
          <div class="col-sm-4">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Datos del paciente</strong></h3>
              </div>
              <div class="panel-body">
                <label style="font-weight: bold !important;">
                  Tipo de Paciente:&nbsp;&nbsp;
                  <label class="radio-inline">
                    <input type="radio" name="txtTipPac" id="txtTipPac1" value="1"/> SIS <!-- onclick="desabilita_datosgene()"-->
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="txtTipPac" id="txtTipPac2" value="2"/> PARTICULAR
                  </label>
                </label>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-8 col-md-7">
                      <div class="row">
                        <div class="col-md-12">
                          <label for="txtIdTipDocPac">Documento de identidad<span class="span-asterisk">(*)</span>:</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4" style="padding-right: 0!important;">
                          <?php $rsT = $t->get_ListaTipoDocPerNatu(); ?>
                          <select class="form-control input-sm" name="txtIdTipDocPac" id="txtIdTipDocPac" onchange="maxlength_doc_bus()">
                            <?php
                            foreach ($rsT as $row) {
                              echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-sm-8" style="padding-left: 0!important;">
                          <div class="input-group input-group-sm">
                            <input type="text" name="txtNroDocPac" id="txtNroDocPac" placeholder="Número de documento" onfocus="this.select()" required="" autocomplete="OFF" class="form-control input-sm" maxlength="8" onkeydown="campoSiguiente('btnPacSearch', event);"/>
                            <div class="input-group-btn">
                              <button class="btn btn-info" type="button" id="btnPacSearch" onclick="buscar_datos_personales()"><i class="fa fa-search"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-5">
                      <label for="txtNroHCPac"> Nro. H.C.: </label>
                      <input type="text" name="txtNroHCPac" id="txtNroHCPac" class="form-control input-sm text-uppercase" maxlength="10" onkeydown="campoSiguiente('txtIdSexoPac', event);">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-4">
                      <label for="txtIdSexoPac">Sexo</label>
                      <select class="form-control input-sm" name="txtIdSexoPac" id="txtIdSexoPac" onkeydown="campoSiguiente('txtFecNacPac', event);" disabled>
                        <option value="">Seleccione</option>
                        <option value="1">M</option>
                        <option value="2">F</option>
                      </select>
                    </div>
                    <div class="col-sm-4">
                      <label for="txtFecNacPac">Fecha Nac.</label>
                      <div class="input-group input-group-sm">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" name="txtFecNacPac" id="txtFecNacPac" placeholder="DD/MM/AAAA" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtPriApePac', event);" disabled/>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <label for="txtEdadPac">Edad</label>
                      <input type="text" class="form-control input-sm" name="txtEdadPac" id="txtEdadPac" readonly/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="txtPriApePac">Apellido paterno</label>
                      <input type="text" name="txtPriApePac" class="form-control input-sm" id="txtPriApePac" maxlength="75" onkeydown="campoSiguiente('txtSegApePac', event);" readonly/>
                    </div>
                    <div class="col-sm-6">
                      <label for="txtSegApePac">Apellido materno</label>
                      <input type="text" name="txtSegApePac" class="form-control input-sm" id="txtSegApePac" maxlength="75" onkeydown="campoSiguiente('txtNroTelFijoPac', event);" readonly/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="txtNomPac">Nombre(s)</label>
                  <input type="text" name="txtNomPac" class="form-control input-sm" id="txtNomPac" maxlength="180" onkeydown="campoSiguiente('txtNroTelFijoPac', event);" readonly/>
                </div>
              </div>
              <br/>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Notificación del paciente</strong></h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="txtNroTelFijoPac">Telf. Fijo</label>
                      <div class="input-group input-group-sm">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></div>
                        <input type="text" name="txtNroTelFijoPac" placeholder="999999999" id="txtNroTelFijoPac" onfocus="this.select()" class="form-control" maxlength="9" value="" onkeydown="campoSiguiente('txtNroTelMovilPac', event);"/>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="txtNroTelMovilPac">Telf. Móvil</label>
                      <div class="input-group input-group-sm">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
                        <input type="text" name="txtNroTelMovilPac" placeholder="999999999" id="txtNroTelMovilPac" onfocus="this.select()" class="form-control" maxlength="9" value="" onkeydown="campoSiguiente('txtEmailPac', event);"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="txtEmailPac">Email</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
                    <input type="text" name="txtEmailPac" placeholder="@example.com" id="txtEmailPac" onfocus="this.select()" class="form-control" maxlength="50" value="" onkeydown="campoSiguiente('txtUBIGEOPac', event);"/>
                  </div>
                </div>
                <div class="form-group">
                  <label for="txtUBIGEOPac">UBIGEO (Departamento - Provincia - Distrito)</label>
                  <?php $rsUb = $ub->get_listaUbigeoPeru(); ?>
                  <select class="form-control input-sm" style="width: 100%" name="txtUBIGEOPac" id="txtUBIGEOPac" onkeydown="campoSiguiente('txtDirPac', event);">
                    <option value="">Seleccione</option>
                    <?php
                    foreach ($rsUb as $rowUb) {
                      echo "<option value='" . $rowUb['id_ubigeo'] . "'>" . $rowUb['departamento'] . " - " . $rowUb['provincia'] . " - " . $rowUb['distrito'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="txtDirPac">Dirección:</label>
                  <input type="text" name="txtDirPac" id="txtDirPac" placeholder="" required="" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="185" value="" onkeydown="campoSiguiente('txtDirRefPac', event);"/>
                </div>
                <div class="form-group">
                  <label for="txtDirRefPac">Referencia:</label>
                  <input type="text" name="txtDirRefPac" id="txtDirRefPac" placeholder="" required="" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="185" value=""/>
                </div>
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
                  <div class="row">
                    <div class="col-sm-8">
                      <label for="txtFechaFUR" class="control-label">FUR:</label>
                      <div class="input-group input-group-sm">
                        <div class="input-group-addon">
                          <label class="checkbox-inline" style="margin-left:0px !important; padding-left:0px !important;"><input type="radio" name="txtFUR" id="txtFUR1" class="check_fur" value="1"> Si</label>
                          <label class="checkbox-inline" style="margin-left:0px !important"><input type="radio" name="txtFUR" id="txtFUR2" class="check_fur" value="0"> No</label>
                        </div>
                        <input type="text" name="txtFechaFUR" id="txtFechaFUR" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <label for="txtIdGestante" class="control-label">Gestante:</label><br/>
                      <label class="radio-inline">
                        <input type="radio" name="txtIdGestante" id="txtIdGestante1" class="opt_gestante" value="1"/> Si
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="txtIdGestante" id="txtIdGestante2" class="opt_gestante" value="2"/> No
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-2">
                      <label for="txtGest" class="control-label">GEST:</label>
                      <input type="text" class="form-control input-sm" name="txtGest" id="txtGest" placeholder="" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA1', event);"/>
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
                              <input type="text" class="form-control input-sm" name="txtPARA1" id="txtPARA1" placeholder="" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA2', event);"/>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" class="form-control input-sm" name="txtPARA2" id="txtPARA2" placeholder="" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA3', event);"/>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" class="form-control input-sm" name="txtPARA3" id="txtPARA3" placeholder="" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA4', event);"/>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" class="form-control input-sm" name="txtPARA4" id="txtPARA4" placeholder="" onfocus="this.select()" maxlength="2" value="0"/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <label style="font-weight: bold !important;">Datos FUA (Opcional)</label>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="txNroFUA">N° FUA:</label>
                      <input type="text" name="txNroFUA" placeholder="" required="" id="txNroFUA" onfocus="this.select()" class="form-control input-sm" maxlength="6" onkeydown="campoSiguiente('txtPesoPac', event);"/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <label for="txtPesoPac">PESO (Kg):</label>
                      <div class="input-group input-group-sm">
                        <div class="input-group-addon"><i class="fa fa-balance-scale"></i></div>
                        <input type="text" name="txtPesoPac" required="" id="txtPesoPac" onfocus="this.select()" class="form-control" maxlength="7" value="" onkeydown="campoSiguiente('txtTallaPac', event);"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label for="txtTallaPac">Talla (cm):</label>
                      <div class="input-group input-group-sm">
                        <div class="input-group-addon"><i class="fa fa-child"></i></div>
                        <input type="text" name="txtTallaPac" required="" id="txtTallaPac" onfocus="this.select()" class="form-control" maxlength="7" value="" onkeydown="campoSiguiente('txtPAPac', event);"/>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <label for="txtPAPac">P.A. (mmHg):</label>
                      <div class="input-group input-group-sm">
                        <div class="input-group-addon"><i class="fa fa-heart"></i></div>
                        <input type="text" name="txtPAPac" required="" id="txtPAPac" onfocus="this.select()" class="form-control" maxlength="7" value=""/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br/>
              <br/>
            </div>
          </div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>PAP o Biopsia anterior</strong></h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-3">
                <div class="checkbox">
                  <strong>PAP o Biopsia anterior</strong><br/>
                  <div class="form-group">
                    <div class="radio">
                      <label>
                        <input type="radio" name="txtPAPANte" id="txtPAPANte1" value="1" class="opt_papante"/>
                        Si
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="txtPAPANte" id="txtPAPANte2" value="2" class="opt_papante"/>
                        No
                      </label>
                    </div>
                  </div>
                  <strong>Resultado</strong><br/>
                  <div class="form-group">
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
                    <label>N° Registro</label>
                    <input type="text" name="txNroRegResul" id="txNroRegResul" placeholder="" required="" onfocus="this.select()" class="form-control input-sm" maxlength="6" value=""  onkeydown="campoSiguiente('txtDetResultadoAnte', event);" disabled/>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><strong>Anormalidad de células epiteliales escamosas</strong></h3>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <div class="radio">
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
                          CARCINOMA
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
                      <label class="checkbox-inline"><input type="checkbox" name="txtAnticonceptivo" id="txtAnticonceptivo5" class="check_anticonceptivo" value="5"/> NINGUNO</label>
                      <label class="checkbox-inline"><input type="checkbox" name="txtAnticonceptivo" id="txtAnticonceptivo2" class="check_anticonceptivo" value="1"/> DIU</label>
                      <label class="checkbox-inline"><input type="checkbox" name="txtAnticonceptivo" id="txtAnticonceptivo1" class="check_anticonceptivo" value="2"/> ORAL</label>
                      <label class="checkbox-inline"><input type="checkbox" name="txtAnticonceptivo" id="txtAnticonceptivo3" class="check_anticonceptivo" value="3"/> INYEC</label>
                      <label class="checkbox-inline"><input type="checkbox" name="txtAnticonceptivo" id="txtAnticonceptivo4" class="check_anticonceptivo" value="4"/> IMPLANTE</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="checkbox">
                      <div class="input-group input-group-sm">
                        <span class="input-group-addon">
                          <label class="checkbox-inline">
                              <input type="checkbox" name="txtAnticonceptivo" id="txtAnticonceptivo6" class="check_anticonceptivo" value="6"/> OTROS
                            </label>
                        </span>
                        <input class="form-control input-sm" type="text" name="txtDetAnticonceptivo" id="txtDetAnticonceptivo" placeholder="" required="" maxlength="185" value="" onkeydown="campoSiguiente('txtIdGestante', event);" disabled/>
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
                <h3 class="panel-title"><strong>Síntomas</strong></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-12">
                    <label class="checkbox-inline"><input type="checkbox" name="txtSintoma" id="txtSintoma1" class="check_sintoma" value="1"/> NINGUNO</label>
                    <label class="checkbox-inline"><input type="checkbox" name="txtSintoma" id="txtSintoma2" class="check_sintoma" value="2"/> DOLOR</label>
                    <label class="checkbox-inline"><input type="checkbox" name="txtSintoma" id="txtSintoma3" class="check_sintoma" value="3"/> LEUCORREA</label>
                    <label class="checkbox-inline"><input type="checkbox" name="txtSintoma" id="txtSintoma4" class="check_sintoma" value="4"/> PRURITO</label>
                    <label class="checkbox-inline"><input type="checkbox" name="txtSintoma" id="txtSintoma5" class="check_sintoma" value="5"/> COITORRAGIA</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="checkbox">
                    <div class="input-group input-group-sm">
                      <span class="input-group-addon">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="txtSintoma" id="txtSintoma6" class="check_sintoma" value="6"/> OTROS
                        </label>
                      </span>
                      <input class="form-control" type="text" name="txtDetSintoma" id="txtDetSintoma" placeholder="" required="" maxlength="185" value="" onkeydown="campoSiguiente('txtIdGestante', event);" disabled/>
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
                        <input type="checkbox" name="txtExaCervico" id="txtExaCervico1" value="1" class="check_exacervico"/>
                        CONGESTIÓN (Amarrillo)
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="txtExaCervico" id="txtExaCervico2" value="2" class="check_exacervico"/>
                        EROSIÓN (Azul)
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="txtExaCervico" id="txtExaCervico3" value="3" class="check_exacervico"/>
                        ULCERACIÓN (Rojo)
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="txtExaCervico" id="txtExaCervico4" value="4" class="check_exacervico"/>
                        PÓLIPOS (Anaranjado)
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="txtExaCervico" id="txtExaCervico5" value="5" class="check_exacervico"/>
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
              <h3 class="panel-title"><strong>Diagnóstico clínico, insumos y/o actividad de Salud</strong></h3>
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
                  <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control input-sm" maxlength="18" value="88141" disabled/>
                </div>
                <div class="col-md-4">
                  <input type="text" name="txtNomDiagnostico" placeholder="Ingrese descripción" id="txtNomDiagnostico" class="form-control input-sm" maxlength="500" value="TOMA DE PAPANICOLAOU" disabled/>
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
                      <div class="row" style="padding-top: 5px;" id="diag-8">
                        <div class="col-sm-3 col-md-2">
                          <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control input-sm" maxlength="18" value="N72" disabled/>
                        </div>
                        <div class="col-sm-9 col-md-10">
                          <div class="input-group input-group-sm">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-success btn-sm" id="btnDelet" onclick="delete_diag('8')"><i class="fa fa-remove"></i> Quitar</button>
                            </div>
                            <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control input-sm" maxlength="500" value="CERVICITIS" disabled/>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="padding-top: 5px;" id="diag-9">
                        <div class="col-sm-3 col-md-2">
                          <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control input-sm" maxlength="18" value="N84.1" disabled/>
                        </div>
                        <div class="col-sm-9 col-md-10">
                          <div class="input-group input-group-sm">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-success btn-sm" id="btnDelet" onclick="delete_diag('9')"><i class="fa fa-remove"></i> Quitar</button>
                            </div>
                            <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control input-sm" maxlength="500" value="POLIPO DEL CUELLO UTERINO" disabled/>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="padding-top: 5px;" id="diag-10">
                        <div class="col-sm-3 col-md-2">
                          <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control input-sm" maxlength="18" value="N86" disabled/>
                        </div>
                        <div class="col-sm-9 col-md-10">
                          <div class="input-group input-group-sm">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-success btn-sm" id="btnDelet" onclick="delete_diag('10')"><i class="fa fa-remove"></i> Quitar</button>
                            </div>
                            <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control input-sm" maxlength="500" value="EROSIÓN Y ECTROPIÓN" disabled/>
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
                      <!--<div class="row" style="padding-top: 5px;" id="diag-2">
                      <div class="col-md-2">
                      <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control input-sm" maxlength="18" value="9938601" disabled/>
                    </div>
                    <div class="col-md-4">
                    <div class="input-group input-group-sm">
                    <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control input-sm" maxlength="500" value="EXAMEN DE MAMAS" disabled/>
                    <div class="input-group-btn">
                    <button type="button" class="btn btn-success btn-sm" id="btnDelet" onclick="delete_diag('2')"><i class="fa fa-remove"></i> Quitar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" style="padding-top: 5px;" id="diag-3">
            <div class="col-md-2">
            <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control input-sm" maxlength="18" value="99401" disabled/>
          </div>
          <div class="col-md-4">
          <div class="input-group input-group-sm">
          <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control input-sm" maxlength="500" value="EVALUACION ANTROPOMETRICA" disabled/>
          <div class="input-group-btn">
          <button type="button" class="btn btn-success btn-sm" id="btnDelet" onclick="delete_diag('3')"><i class="fa fa-remove"></i> Quitar</button>
        </div>
      </div>
    </div>
  </div>-->
  <div class="row" style="padding-top: 5px;" id="diag-4">
    <div class="col-sm-3 col-md-2">
      <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control input-sm" maxlength="18" value="23904" disabled/>
    </div>
    <div class="col-sm-9 col-md-10">
      <div class="input-group input-group-sm">
        <div class="input-group-btn">
          <button type="button" class="btn btn-success btn-sm" id="btnDelet" onclick="delete_diag('4')"><i class="fa fa-remove"></i> Quitar</button>
        </div>
        <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control input-sm" maxlength="500" value="CITOCEPILLO PARA PAPANICOLAU" disabled/>
      </div>
    </div>
  </div>
  <div class="row" style="padding-top: 5px;" id="diag-5">
    <div class="col-sm-3 col-md-2">
      <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control input-sm" maxlength="18" value="29448" disabled/>
    </div>
    <div class="col-sm-9 col-md-10">
      <div class="input-group input-group-sm">
        <div class="input-group-btn">
          <button type="button" class="btn btn-success btn-sm" id="btnDelet" onclick="delete_diag('5')"><i class="fa fa-remove"></i> Quitar</button>
        </div>
        <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control input-sm" maxlength="500" value="GUANTES DESCARTABLES TALLA M" disabled/>
      </div>
    </div>
  </div>
  <div class="row" style="padding-top: 5px;" id="diag-6">
    <div class="col-sm-3 col-md-2">
      <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control input-sm" maxlength="18" value="25122" disabled/>
    </div>
    <div class="col-sm-9 col-md-10">
      <div class="input-group input-group-sm">
        <div class="input-group-btn">
          <button type="button" class="btn btn-success btn-sm" id="btnDelet" onclick="delete_diag('6')"><i class="fa fa-remove"></i> Quitar</button>
        </div>
        <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control input-sm" maxlength="500" value="ESPECULO VAGINAL DESCARTABLE MEDIANO" disabled/>
      </div>
    </div>
  </div>
  <div class="row" style="padding-top: 5px;" id="diag-7">
    <div class="col-sm-3 col-md-2">
      <input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control input-sm" maxlength="18" value="25391" disabled/>
    </div>
    <div class="col-sm-9 col-md-10">
      <div class="input-group input-group-sm">
        <div class="input-group-btn">
          <button type="button" class="btn btn-success btn-sm" id="btnDelet" onclick="delete_diag('7')"><i class="fa fa-remove"></i> Quitar</button>
        </div>
        <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control input-sm" maxlength="500" value="ESPATULA DE AYRE DE MADERA" disabled/>
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
</div>
<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">

function delete_diag(nro){
  $("#diag-" + nro).remove();
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
    if ($(this).is(':checked')) {
      if($(this).val() == "1"){
        $(".opt_resulante").prop('checked', false);
        $(".opt_resulante").prop('disabled', false);
        $(".opt_anorescamosa").prop('checked', false);
        $(".opt_anorescamosa").prop('disabled', false);
        $(".opt_anorglandular").prop('checked', false);
        $(".opt_anorglandular").prop('disabled', false);
        $("#txNroRegResul").val('');
        $("#txNroRegResul").prop('disabled', false);
      }
      if($(this).val() == "2"){
        $(".opt_resulante").prop('checked', false);
        $(".opt_resulante").prop('disabled', true);
        $(".opt_anorescamosa").prop('checked', false);
        $(".opt_anorescamosa").prop('disabled', true);
        $(".opt_anorglandular").prop('checked', false);
        $(".opt_anorglandular").prop('disabled', true);
        $("#txNroRegResul").val('');
        $("#txNroRegResul").prop('disabled', true);
      }
    };
  });

  $('[name="txtResultadoAnte"]').change(function()
  {
    if ($(this).is(':checked')) {
      if($(this).val() == "1"){
        $(".opt_detresulante").prop('checked', false);
        $(".opt_detresulante").prop('disabled', false);
        setTimeout(function(){$('#txNroRegResul').trigger('focus');}, 2);
      }
      if($(this).val() == "2"){
        $(".opt_detresulante").prop('checked', false);
        $(".opt_detresulante").prop('disabled', true);
        setTimeout(function(){$('#txNroRegResul').trigger('focus');}, 2);
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

  //$('#txtFecNacPac').inputmask();

  $('[name="txtFUR"]').change(function()
  {
    if ($(this).is(':checked')) {
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
});

function maxlength_doc_bus() {
  if ($("#txtIdTipDocPac").val() == "1") {
    $("#txtNroDocPac").attr('maxlength', '8');
  } else {
    $("#txtNroDocPac").attr('maxlength', '12');
  }
  $("#txtNroDocPac").val('');
  $("#txtNroDocPac").focus();
  $('#txtNroDocPac').trigger('focus');
  setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
}

function buscar_datos_personales(){
  $('#txtIdPer').val('0');
  var msg = "";
  var sw = true;
  var txtIdTipDoc = $('#txtIdTipDocPac').val();
  var txtNroDoc = $('#txtNroDocPac').val();
  var txtNroDocLn = txtNroDoc.length;

  if (txtIdTipDoc == "1") {
    if (txtNroDocLn != 8) {
      msg += "Ingrese el Nro. de documento correctamente<br/>";
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
    return sw;
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
      $("#txtIdPer").val(datos[0]);
      if((datos[4] == null) || (datos[4] == "")){
        $('#txtIdSexoPac').prop("disabled", false);
        $('#txtNomPac').prop("readonly", false);
        $('#txtPriApePac').prop("readonly", false);
        $('#txtSegApePac').prop("readonly", false);
        $('#txtFecNacPac').prop("disabled", false);
        $("#txtNroHCPac").trigger('focus');
      } else {
        if(datos[7] == "1"){
          $("#txtIdPer").val('0');
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
          $("#txtNroHCPac").val(datos[10]);
          $('#txtNomPac').prop("readonly", true);
          $('#txtPriApePac').prop("readonly", true);
          $('#txtSegApePac').prop("readonly", true);
          $('#txtIdSexoPac').prop("disabled", true);
          $('#txtFecNacPac').prop("disabled", true);
          if(datos[9] == ""){
            $('#txtFecNacPac').prop("disabled", false);
          }
          if(datos[10] == ""){
            $("#txtNroHCPac").trigger('focus');
            $('#txtNroHCPac').prop("readonly", false);
          } else{
            $("#txtNroTelFijoPac").trigger('focus');
          }
        }
      }
    }
  });
}

function campoSiguiente(campo, evento) {
  if (evento.keyCode == 13 || evento.keyCode == 9) {
    if (campo == 'btnPacSearch') {
      buscar_datos_personales();
    } else if  (campo == 'txtIdSexoPac') {
      if ($('#txtIdSexoPac').val() != ""){
        setTimeout(function(){$('#txtNroTelFijoPac').trigger('focus');}, 2);
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    } else if (campo == 'txtNomPac') {
      if ($('#txtNomPac').val() != ""){
        setTimeout(function(){$('#txtNroTelfFijo').trigger('focus');}, 2);
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    } else if (campo == 'txtUBIGEOPac'){
      $('#txtUBIGEOPac').select2('open');
    } else {
      document.getElementById(campo).focus();
      evento.preventDefault();
    }
  }
}

function back() {
  window.location = './main_principalsoli.php';
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
      bootbox.alert("El registro se guardo correctamente.");
    }
  }

  ajax.send(postData);
}

function validForm() {
  //$('#btnValidForm').prop("disabled", true);
  var msg = "";
  var sw = true;

  var idpac = $('#txtIdPac').val();

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
  var telfipac = $('#txtNroTelFijoPac').val();
  var telmopac = $('#txtNroTelMovilPac').val();
  var emailpac = $('#txtEmailPac').val();
  var ubigeopac = $('#txtUBIGEOPac').val();
  var dirpac = $('#txtDirPac').val();
  var refdirpac = $('#txtDirRefPac').val();

  if(nrohcpac == ""){
    msg+= "Ingrese historia clínica del Paciente<br/>";
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

  //var exisis = $('#txtIdExiSIS').val();
  var fur = $('#txtFUR').val();
  var fecfur = $('#txtFechaFUR').val();

  /*if(exisis == ""){
    msg+= "Seleccione si el paciente, tiene SIS<br/>";
    sw = false;
  }*/

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

  if ($('input.opt_gestante').is(':checked')) {
  } else {
    msg+= "Seleccione si la paciente es gestante<br/>";
    sw = false;
  }

  if ($('#txtAnticonceptivo6').is(':checked')) {
    if(fecfur == ""){
      msg+= "Ingrese detalle de otro Método Anticonceptivo<br/>";
      sw = false;
    }
  }

  if ($('input.opt_papante').is(':checked')) {
    $.each($('.opt_papante:checked'), function() {
      if($(this).val() == "1"){

        if ($('input.opt_resulante').is(':checked')) {
          $.each($('.opt_resulante:checked'), function() {
            if($(this).val() == "1"){

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
          msg+= "Seleccione si el resultado del examen de PAP o Biopsia fue positivo o negativo paciente<br/>";
          sw = false;
        }

        var nroregresul = $('#txNroRegResul').val();
        if(fecfur == ""){
          msg+= "Ingrese Nro. de registro del anterior resultado<br/>";
          sw = false;
        }

      };
    });
  } else {
    msg+= "Seleccione si la paciente se realizó anteriormente un examen de PAP o Biopsia<br/>";
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

        var coddiag = [];
        $("input[name='txtIdDiagnostico']").each(function() {
          coddiag.push($(this).val());
        });

        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlPAP.php',
          data: {
            accion: 'POST_ADD_REGSOLICITUD',
            txtIdPac: document.frmSolicitud.txtIdPac.value, txtIdTipDocPac: document.frmSolicitud.txtIdTipDocPac.value, txtNroDocPac: document.frmSolicitud.txtNroDocPac.value, txtNroHCPac: document.frmSolicitud.txtNroHCPac.value, txtIdSexoPac: document.frmSolicitud.txtIdSexoPac.value, txtFecNacPac: document.frmSolicitud.txtFecNacPac.value, txtNomPac: document.frmSolicitud.txtNomPac.value, txtPriApePac: document.frmSolicitud.txtPriApePac.value, txtSegApePac: document.frmSolicitud.txtSegApePac.value, txtNroTelFijoPac: document.frmSolicitud.txtNroTelFijoPac.value, txtNroTelMovilPac: document.frmSolicitud.txtNroTelMovilPac.value, txtEmailPac: document.frmSolicitud.txtEmailPac.value, txtUBIGEOPac: document.frmSolicitud.txtUBIGEOPac.value, txtDirPac: document.frmSolicitud.txtDirPac.value, txtDirRefPac: document.frmSolicitud.txtDirRefPac.value,
            txtIdExiSIS: document.frmSolicitud.txtTipPac.value, txtFUR: document.frmSolicitud.txtFUR.value, txtFechaFUR: document.frmSolicitud.txtFechaFUR.value, txtGest: document.frmSolicitud.txtGest.value, txtPARA1: document.frmSolicitud.txtPARA1.value, txtPARA2: document.frmSolicitud.txtPARA2.value, txtPARA3: document.frmSolicitud.txtPARA3.value, txtPARA4: document.frmSolicitud.txtPARA4.value, txtIdGestante: document.frmSolicitud.txtIdGestante.value, txtAnticonceptivo: anticonceptivo, txtDetAnticonceptivo: document.frmSolicitud.txtDetAnticonceptivo.value, txtPAPANte: document.frmSolicitud.txtPAPANte.value, txtResultadoAnte: document.frmSolicitud.txtResultadoAnte.value, txNroRegResul: document.frmSolicitud.txNroRegResul.value, txtAnorEscamosa: document.frmSolicitud.txtAnorEscamosa.value, txtAnorGlandular: document.frmSolicitud.txtAnorGlandular.value, txtSintoma: sintoma, txtDetSintoma: document.frmSolicitud.txtDetSintoma.value, txtExaCervico: exacervico,
            txtPesoPac: document.frmSolicitud.txtPesoPac.value, txtTallaPac: document.frmSolicitud.txtTallaPac.value, txtPAPac: document.frmSolicitud.txtPAPac.value, txNroFUA: document.frmSolicitud.txNroFUA.value,
            txtIdDiagnostico: coddiag,
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

  $('#txtFecNacPac').datetimepicker({
    locale: 'es',
    format: 'L'
  });

  $('#txtFecNacPac').inputmask();

  $('#txtUBIGEOPac').select2();
  setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
});

</script>
<?php require_once '../include/masterfooter.php'; ?>

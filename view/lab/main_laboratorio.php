<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Area.php';
$a = new Area();
require_once '../../model/Grupo.php';
$g = new Grupo();
require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/Cpt.php';
$cpt = new Cpt();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Registro de análisis clínico</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmPaciente" id="frmPaciente">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="0"/>
        <input type="hidden" name="txtIngResul" id="txtIngResul" value="NO"/>
        <input type="hidden" name="txtShowOptPrint" id="txtShowOptPrint" value=""/>
        <input type="hidden" name="txtIdPer" id="txtIdPer" value="0"/>
        <input type="hidden" name="txtIdSoli" id="txtIdSoli" value="0"/>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Datos Personales</strong></h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtIdTipDoc">Documento de identidad<span class="span-asterisk">(*)</span>:</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-sm">
                      <div class="input-group-addon" style="padding: 0!important;">
                        <?php $rsT = $t->get_ListaTipoDocPerNatu(); ?>
                        <select name="txtIdTipDoc" style="width:100%;" id="txtIdTipDoc" onchange="maxlength_doc_bus()">
                          <?php
                          foreach ($rsT as $row) {
                            echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <input type="text" name="txtNroDoc" placeholder="Número de documento" required="" id="txtNroDoc" class="form-control input-xs" maxlength="8" onkeydown="campoSiguiente('btn-pac-search', event);"/>
                      <div class="input-group-btn">
                        <button class="btn btn-info" type="button" id="btn-pac-search" onclick="buscar_datos_personales()"><i class="fa fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtNroHC"> Nro. H.C.: </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <input type="text" name="txtNroHC" class="form-control input-xs" id="txtNroHC" maxlength="10" onkeydown="campoSiguiente('txtIdSexoPac', event);">
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtIdSexoPac"> Sexo: </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <select class="form-control input-xs" name="txtIdSexoPac" id="txtIdSexoPac" onkeydown="campoSiguiente('txtFecNacPac', event);">
                      <option value="">Seleccione</option>
                      <option value="1">M</option>
                      <option value="2">F</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtFecNacPac"> Fecha Nac.: </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-xs">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                      <input type="text" name="txtFecNacPac" id="txtFecNacPac" placeholder="DD/MM/AAAA" required="" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtNomPac', event);"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <label for="txtEdadPac"> Edad: </label>
                <input type="text" class="form-control input-xs" name="txtEdadPac" id="txtEdadPac" readonly/>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtNomPac"> Nombre(s): </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <input type="text" name="txtNomPac" class="form-control input-xs" id="txtNomPac" maxlength="180" onkeydown="campoSiguiente('txtPriApePac', event);"/>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12"><label for="txtPriApePac">Apellido paterno: </label></div>
                </div>
                <div class="row">
                  <div class="col-md-12"><input type="text" name="txtPriApePac" class="form-control input-xs" id="txtPriApePac" maxlength="75" onkeydown="campoSiguiente('txtSegApePac', event);"/>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtSegApePac">Apellido materno: </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <input type="text" name="txtSegApePac" class="form-control input-xs" id="txtSegApePac" maxlength="75" onkeydown="campoSiguiente('txtNroTelFijoPac', event);"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtNroTelFijoPac">Telf. Fijo: </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-xs">
                      <div class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></div>
                      <input type="text" name="txtNroTelFijoPac" placeholder="999999999" required="" id="txtNroTelFijoPac" onfocus="this.select()" class="form-control" maxlength="9" value="" onkeydown="campoSiguiente('txtNroTelMovilPac', event);"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtNroTelMovilPac">Telf. Móvil:</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-xs">
                      <div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
                      <input type="text" name="txtNroTelMovilPac" placeholder="999999999" required="" id="txtNroTelMovilPac" onfocus="this.select()" class="form-control" maxlength="9" value="" onkeydown="campoSiguiente('txtEmailPac', event);"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtEmailPac">Email:</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-xs">
                      <div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
                      <input type="text" name="txtEmailPac" placeholder="@example.com" required="" id="txtEmailPac" onfocus="this.select()" class="form-control" maxlength="50" value="" onkeydown="campoSiguiente('txtNroFUA', event);"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- Fin Datos Personales -->

        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Datos de la atención</strong></h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12"><label for="txtNroRefAtencion">Nro. FUA: </label></div>
                </div>
                <div class="row">
                  <div class="col-md-12"><input type="text" name="txtNroFUA" id="txtNroFUA" class="form-control input-sm" maxlength="20" onkeydown="campoSiguiente('txtIdTipAtencion', event);"/>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtIdTipAtencion">Atención</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <select class="form-control input-sm" name="txtIdTipAtencion" id="txtIdTipAtencion" onchange="change_tipoatencion()">
                      <option value="">Seleccione</option>
                      <option value="1">AMBULATORIA</option>
                      <option value="2">REFERENCIA</option>
                      <option value="3">EMERGENCIA</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtIdDepRef">Referencia realizada por:</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <?php $rsD = $d->get_listaDepenInstitucion(); ?>
                    <select name="txtIdDepRef" id="txtIdDepRef" style="width:100%;" class="form-control input-xs"  onkeydown="campoSiguiente('txtNroRefDep', event);" disabled>
                      <option value="0" selected="">-- Seleccione --</option>";
                      <?php
                      foreach ($rsD as $row) {
                        echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12"><label for="txtNroRefDep">Nro. Ref.: </label></div>
                </div>
                <div class="row">
                  <div class="col-md-12"><input type="text" name="txtNroRefDep" id="txtNroRefDep" class="form-control input-sm" maxlength="20" onkeydown="campoSiguiente('txtCodSIS', event);" readonly/>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtCodSIS"> Tipo de Seguro</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <select class="form-control input-xs" name="txtCodSIS" id="txtCodSIS" onkeydown="campoSiguiente('txtNroSIS', event);" onchange="change_codis()">
                      <option value="">Seleccione</option>
                      <option value="2">2: Documento Nacional de Identidad-DNI</option>
                      <option value="3">3: Carnet de extrangería-CE</option>
                      <option value="E">E: Afiliación temporal</option>
                      <option value="9">9: SIS independiente</option>
                      <option value="8">8: Microempresas</option>
                      <option value="R">R: NRUS</option>
                      <option value="N">N: No es paciente SIS</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-12"><label for="txtNroSIS">Número SIS: </label></div>
                </div>
                <div class="row">
                  <div class="col-md-12"><input type="text" name="txtNroSIS" id="txtNroSIS" class="form-control input-xs" maxlength="25" onkeydown="campoSiguiente('txtIdGestante', event);" readonly/>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtIdGestante"> Gestante?</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <select class="form-control input-xs" name="txtIdGestante" id="txtIdGestante" onkeydown="campoSiguiente('txtFechaParto', event);" onchange="change_gestante()" disabled>
                      <option value="">Seleccione</option>
                      <option value="1">SI</option>
                      <option value="2">NO</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtFechaParto"> Fecha probable de parto: </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-xs">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                      <input type="text" name="txtFechaParto" id="txtFechaParto" placeholder="DD/MM/AAAA" required="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtEdadGest', event);" disabled/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12"><label for="txtEdadGest">Edad Gest.: </label></div>
                </div>
                <div class="row">
                  <div class="col-md-12"><input type="text" name="txtEdadGest" id="txtEdadGest" class="form-control input-xs" maxlength="25" onkeydown="campoSiguiente('txtFechaAten', event);" readonly/>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12"><label for="txtNroRefAtencion">Nro. Atención: </label></div>
                </div>
                <div class="row">
                  <div class="col-md-12"><input type="text" name="txtNroRefAtencion" id="txtNroRefAtencion" class="form-control input-sm" maxlength="20" onkeydown="campoSiguiente('txtIdTipAtencion', event);"/>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtFechaAten">Fecha Atención: </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-xs">
                      <div class="input-group-addon" for="txtFechaAten"><i class="fa fa-calendar" for="txtFechaAten"></i></div>
                      <input type="text" name="txtFechaAten" placeholder="DD/MM/AAAA" required="" id="txtFechaAten" autofocus="" class="form-control" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtHoraAten', event);"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtHoraAten">Hora Atención:</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-xs">
                      <div class="input-group-addon" for="txtHoraAten"><i class="fa fa-clock-o" for="txtHoraAten"></i></div>
                      <input type="text" name="txtHoraAten" placeholder="HH:MM" required="" id="txtHoraAten" onfocus="this.select()" class="form-control" maxlength="5" value="<?php echo date("h:i") ?>" data-inputmask="'mask': '99:99'" onkeydown="campoSiguiente('txtIdCpt', event);"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-1">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtPesoPac">PESO (Kg):</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-xs">
                      <div class="input-group-addon" for="txtHoraAten"><i class="fa fa-balance-scale" for="txtHoraAten"></i></div>
                      <input type="text" name="txtPesoPac" required="" id="txtPesoPac" onfocus="this.select()" class="form-control" maxlength="3" value="" data-inputmask="'mask': '999'" onkeydown="campoSiguiente('txtTallaPac', event);"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-1">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtTallaPac">Talla (cm):</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-xs">
                      <div class="input-group-addon" for="txtHoraAten"><i class="fa fa-child" for="txtHoraAten"></i></div>
                      <input type="text" name="txtTallaPac" required="" id="txtTallaPac" onfocus="this.select()" class="form-control" maxlength="3" value="" data-inputmask="'mask': '999'" onkeydown="campoSiguiente('txtPAPac', event);"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-12">
                    <label for="txtPAPac">P.A. (mmHg):</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group input-group-xs">
                      <div class="input-group-addon" for="txtHoraAten"><i class="fa fa-heart" for="txtHoraAten"></i></div>
                      <input type="text" name="txtPAPac" required="" id="txtPAPac" onfocus="this.select()" class="form-control" maxlength="3" value="" onkeydown="campoSiguiente('txtIdCpt', event);"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- Fin Datos de Parentesco -->

        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Datos del apoderado</strong></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtIdTipDocSoli">Documento de identidad</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-4" style="padding-right: 0!important;">
                      <?php $rsT = $t->get_ListaTipoDocPerNatu(); ?>
                      <select class="form-control input-xs" name="txtIdTipDocSoli" id="txtIdTipDocSoli" onchange="maxlength_doc_bus_soli()">
                        <?php
                        foreach ($rsT as $row) {
                          echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-xs-8" style="padding-left: 0!important;">
                      <div class="input-group input-group-xs">
                        <input type="text" name="txtNroDocSoli" id="txtNroDocSoli" placeholder="Número de documento" required="" class="form-control input-xs" maxlength="8" onkeydown="campoSiguiente('btnSoliSearch', event);"/>
                        <div class="input-group-btn">
                          <button class="btn btn-info" type="button" id="btnSoliSearch" onclick="buscar_datos_personalessoli()"><i class="fa fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtIdSexoSoli"> Sexo: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <select class="form-control input-xs" name="txtIdSexoSoli" id="txtIdSexoSoli" onkeydown="campoSiguiente('txtFecNacSoli', event);">
                        <option value="">Seleccione</option>
                        <option value="1">M</option>
                        <option value="2">F</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtFecNacPac"> Fecha Nac.: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <input type="text" name="txtFecNacSoli" id="txtFecNacSoli" class="form-control input-xs" value="" onkeydown="campoSiguiente('txtNomSoli', event);"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtNomSoli"> Nombre(s): </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <input type="text" name="txtNomSoli" class="form-control input-xs" id="txtNomSoli" maxlength="180" onkeydown="campoSiguiente('txtPriApeSoli', event);"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12"><label for="txtPriApeSoli">Apellido paterno: </label></div>
                  </div>
                  <div class="row">
                    <div class="col-md-12"><input type="text" name="txtPriApeSoli" id="txtPriApeSoli" class="form-control input-xs" maxlength="75" onkeydown="campoSiguiente('txtSegApeSoli', event);"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtSegApeSoli">Apellido materno: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <input type="text" name="txtSegApeSoli" id="txtSegApeSoli" class="form-control input-xs" maxlength="75" onkeydown="campoSiguiente('txtNroTelFijoSoli', event);"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtNroTelFijoSoli">Telf. Fijo: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group input-group-xs">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></div>
                        <input type="text" name="txtNroTelFijoSoli" placeholder="999999999" required="" id="txtNroTelFijoSoli" class="form-control input-xs" maxlength="9" value="" onkeydown="campoSiguiente('txtNroTelMovilSoli', event);"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtNroTelMovilSoli">Telf. Móvil:</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group input-group-xs">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
                        <input type="text" name="txtNroTelMovilSoli" placeholder="999999999" required="" id="txtNroTelMovilSoli" class="form-control input-xs" maxlength="9" value="" onkeydown="campoSiguiente('txtEmailSoli', event);"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtEmailSoli">Email:</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group input-group-xs">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
                        <input type="text" name="txtEmailSoli" placeholder="@example.com" required="" id="txtEmailSoli" class="form-control input-xs" maxlength="50" value="" onkeydown="campoSiguiente('txtIdCpt', event);"/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- Fin de solicitante -->
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Datos del CPT</strong></h3>
          </div>
          <div class="panel-body">
            <?php $rsCpt = $cpt->get_listaCptLaboratorio(); ?>
            <select class="form-control js-example-basic-multiple" name="txtIdCpt[]" id="txtIdCpt" required="" style="width: 100%" multiple="multiple">
              <option value="">--Seleccione--</option>
              <?php
              foreach ($rsCpt as $rowCpt) {
                echo "<option value='" . $rowCpt['id_cpt'] . "'>" . $rowCpt['id_cpt'].": ".$rowCpt['denominacion_cpt'] . "</option>";
              }
              ?>
            </select>
          </div>
        </div>

      </form>
      <br/>
      <div class="row">
        <?php
        $frm = "";
        $rsA = $a->get_listaArea();
        foreach ($rsA as $rowA) {
          ?>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span id="bgArea<?php echo $rowA['id_area']?>" class="info-box-icon bg-aqua sel-cursor" onclick="show_area('<?php echo $rowA['id_area']?>')">
                <i class="fa fa-thermometer-half"></i>
              </span>
              <div class="info-box-content">
                <span class="info-box-text"><?php echo $rowA['area']?></span>
                <span class="info-box-number" id="lblArea<?php echo $rowA['id_area']?>">POR GENERAR</span>
                <a href="#" class="text-success" style="display: none;" id="print<?php echo $rowA['id_area']?>" onclick="open_pdf('<?php echo $rowA['id_area']?>')"><b><i class="fa fa-file-pdf-o"></i> Exportar</b></a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <?php
          $frm.= "#frmArea". $rowA['id_area'] . ",";
        }
        $frm = trim($frm, ',');
        ?>
      </div>
    </div>
    <div class="panel-footer">
      <div class="row">
        <div class="col-md-12 text-center">
          <div id="saveAtencion">
            <div class="btn-group">
              <button class="btn btn-primary btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="validForm()"><i class="fa fa-save"></i>  Guardar  </button>
              <a href="./main_principallab.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
            </div>
          </div>
          <div id="impriAtencion" style="display: none;">
            <div class="btn-group">
              <button class="btn btn-lg btn-success" id="btn-imrimirall" onclick="open_pdf('0')"><i class="fa fa-file-pdf-o"></i> Imprimir formatos generados</button>
              <a href="./main_principallab.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Salir</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
//$rsA = $a->get_listaArea();
foreach ($rsA as $rowA) {
  ?>
  <div class="modal fade" id="showArea<?php echo $rowA['id_area']?>" tabindex="-1" role="dialog" aria-labelledby="showArea<?php echo $rowA['id_area']?>Label">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showArea<?php echo $rowA['id_area']?>Label"><?php echo $rowA['area']?></h4>
        </div>
        <div class="modal-body-scroll" style="font-size:12px;">
          <form class="form-horizontal" name="frmArea<?php echo $rowA['id_area']?>" id="frmArea<?php echo $rowA['id_area']?>">
            <?php
            $rsG = $g->get_listaGrupoPorIdArea($rowA['id_area']);
            $cantG = Count($rsG);
            foreach ($rsG as $rowG) {
              if($rowG['visible'] == "1"){
                ?>
                <div class="panel panel-info">
                  <div class="panel-heading" style="padding: 2px 15px;">
                    <h4 class="modal-title"><strong><?php echo $rowG['grupo']?></strong></h4>
                  </div>
                  <div class="panel-body" style="padding: 2px 15px;">
                    <?php
                  }
                  $rsC = $c->get_listaComponentePorIdGrupoArea($rowG['id_grupoarea']);
                  foreach ($rsC as $rowC) {
                    if ($rowC['tipo_ingresosol'] == "1"){
                      ?>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label-xs"><?php echo $rowC['componente']?></label>
                        <div class="col-sm-4">
                          <div class="input-group input-group-xs">
                            <input type="text" class="form-control input-xs" id="txt_<?php echo $rowC['id_componentedet']?>" name="txt_<?php echo $rowC['id_componentedet']?>" placeholder=""/>
                            <div class="input-group-addon"><?php echo $rowC['uni_medida']?></div>
                          </div>
                        </div>
                        <div class="col-sm-4"><p class="help-block"><?php echo nl2br($rowC['valor_ref'])?></p></div>
                      </div>
                      <?php
                    } else {
                      if ($cantG <> "1"){
                        ?>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label-xs"><?php echo $rowC['componente']?></label>
                          <div class="col-sm-4">
                            <textarea class="form-control" id="txt_<?php echo $rowC['id_componentedet']?>" name="txt_<?php echo $rowC['id_componentedet']?>" rows="3"></textarea>
                          </div>
                          <div class="col-sm-4"><p class="help-block"><?php echo nl2br($rowC['valor_ref'])?></p></div>
                        </div>
                        <?php
                      } else {
                        ?>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label-xs"><?php echo $rowC['componente']?></label>
                          <div class="col-sm-8">
                            <textarea class="form-control" id="txt_<?php echo $rowC['id_componentedet']?>" name="txt_<?php echo $rowC['id_componentedet']?>" rows="15"></textarea>
                          </div>
                        </div>
                        <?php
                      }
                    }
                  }
                  if($rowG['visible'] == "1"){
                    ?>
                  </div>
                </div>
                <?php
              }
            }
            ?>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button class="btn btn-primary" id="btnAreaCon<?php echo $rowA['id_area']?>" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="save_area('<?php echo $rowA['id_area']?>')"><i class="fa fa-save"></i> Continuar </button>
                <button class="btn btn-default" id="btnAreaCan<?php echo $rowA['id_area']?>" onclick="cancel_area('<?php echo $rowA['id_area']?>')"><i class="fa fa-times"></i> Cancelar</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
  ?>


  <?php require_once '../include/footer.php'; ?>
  <script Language="JavaScript">


  $(function() {

    jQuery('#txtNroDoc').keypress(function (tecla) {
      var idTipDocPer = $("#txtIdTipDoc").val();
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

    jQuery('#txtNroTelFijoPac').keypress(function (tecla) {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
      return false;
    });

    jQuery('#txtNroTelfMovilPac').keypress(function (tecla) {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
      return false;
    });

    jQuery('#txtNroRefDep').keypress(function (tecla) {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
      return false;
    });

    jQuery('#txtEdadGest').keypress(function (tecla) {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
      return false;
    });

    jQuery('#txtHoraAten').keypress(function (tecla) {
      if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0) && (tecla.charCode != 58))//(Solo Numeros)(0=borrar)
      return false;
    });

  });

  function maxlength_doc_bus() {
    if ($("#txtIdTipDoc").val() == "1") {
      $("#txtNroDoc").attr('maxlength', '8');
    } else {
      $("#txtNroDoc").attr('maxlength', '12');
    }
    $("#txtNroDoc").val('');
    $("#txtNroDoc").focus();
    $('#txtNroDoc').trigger('focus');
    setTimeout(function(){$('#txtNroDoc').trigger('focus');}, 2);
  }

  function change_tipoatencion() {
    if($("#txtIdTipAtencion").val() == "2"){
      $("#txtNroRefDep").val('');
      $("#txtIdDepRef").val('0').trigger("change");
      $('#txtIdDepRef').prop("disabled", false);
      $('#txtNroRefDep').prop("readonly", false);
    } else {
      $("#txtNroRefDep").val('');
      $("#txtIdDepRef").val('0').trigger("change");
      $('#txtIdDepRef').prop("disabled", true);
      $('#txtNroRefDep').prop("readonly", true);
    }
  }

  function campoSiguiente(campo, evento) {
    if (evento.keyCode == 13 || evento.keyCode == 9) {
      if (campo == 'txtIdSexoPac') {
        if ($('#txtIdSexoPac').val() == ""){
          setTimeout(function(){$('#txtIdSexoPac').trigger('focus');}, 2);
        } else {
          if ($('#txtFecNacPac').val() == ""){
            setTimeout(function(){$('#txtFecNacPac').trigger('focus');}, 2);
          } else {
            if ($('#txtNomPac').val() != ""){
              setTimeout(function(){$('#txtNroTelFijoPac').trigger('focus');}, 2);
            } else {
              document.getElementById(campo).focus();
              evento.preventDefault();
            }
          }
        }
      } else if (campo == 'txtNomPac') {
        if ($('#txtNomPac').val() != ""){
          setTimeout(function(){$('#txtNroTelFijoPac').trigger('focus');}, 2);
        } else {
          document.getElementById(campo).focus();
          evento.preventDefault();
        }
      } else if (campo == 'txtNroSIS') {
        $('#txtNroSIS').val('');
        $('#txtIdGestante').val('');
        $('#txtFechaParto').val('');
        $('#txtEdadGest').val('');
        if ($('#txtCodSIS').val() == ""){
          $('#txtNroSIS').prop("readonly", true);
          $('#txtIdGestante').prop("disabled", true);
          setTimeout(function(){$('#txtCodSIS').trigger('focus');}, 2);
        } else if ($('#txtCodSIS').val() == "2"){
          if(($('#txtCodSIS').val() == "2") && ($('#txtIdTipDoc').val() == "1")){
            $('#txtNroSIS').prop("readonly", true);
            $('#txtNroSIS').val($('#txtNroDoc').val());
            if($('#txtIdSexoPac').val() == "2"){
              $('#txtIdGestante').prop("disabled", false);
              setTimeout(function(){$('#txtIdGestante').trigger('focus');}, 2);
            } else {
              $('#txtIdGestante').val('2');
              setTimeout(function(){$('#txtFechaAten').trigger('focus');}, 2);
            }
          } else {
            $('#txtNroSIS').prop("readonly", true);
            $('#txtIdGestante').prop("disabled", true);
            setTimeout(function(){$('#txtCodSIS').trigger('focus');}, 2);
          }
        } else if ($('#txtCodSIS').val() == "3"){
          if(($('#txtCodSIS').val() == "3") && ($('#txtIdTipDoc').val() == "2")){
            $('#txtNroSIS').prop("readonly", true);
            $('#txtNroSIS').val($('#txtNroDoc').val());
            if($('#txtIdSexoPac').val() == "2"){
              $('#txtIdGestante').prop("disabled", false);
              setTimeout(function(){$('#txtIdGestante').trigger('focus');}, 2);
            } else {
              $('#txtIdGestante').val('2');
              setTimeout(function(){$('#txtFechaAten').trigger('focus');}, 2);
            }
          } else {
            $('#txtNroSIS').prop("readonly", true);
            $('#txtIdGestante').prop("disabled", true);
            setTimeout(function(){$('#txtCodSIS').trigger('focus');}, 2);
          }
        } else if ($('#txtCodSIS').val() == "N"){
          $('#txtNroSIS').prop("readonly", true);
          $('#txtIdGestante').prop("disabled", true);
          setTimeout(function(){$('#txtFechaAten').trigger('focus');}, 2);
        } else {
          $('#txtNroSIS').prop("readonly", false);
          if($('#txtIdSexoPac').val() == "2"){
            $('#txtIdGestante').prop("disabled", false);
            setTimeout(function(){$('#txtIdGestante').trigger('focus');}, 2);
          } else {
            $('#txtIdGestante').val('2');
            setTimeout(function(){$('#txtFechaAten').trigger('focus');}, 2);
          }
          //document.getElementById(campo).focus();
          //evento.preventDefault();
        }
      } else if (campo == 'txtFechaParto') {

        if ($('#txtIdGestante').val() == "2"){
          $('#txtEdadGest').prop("readonly", true);
          $('#txtFechaParto').prop("disabled", true);
          setTimeout(function(){$('#txtFechaAten').trigger('focus');}, 2);
        }else {
          $('#txtEdadGest').prop("readonly", false);
          $('#txtFechaParto').prop("disabled", false);
          document.getElementById(campo).focus();
          evento.preventDefault();
        }
      } else if (campo == 'btn-pac-search') {
        buscar_datos_personales();
      } else if (campo == 'btnSoliSearch') {
        buscar_datos_personalessoli();
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    }
  }

  function change_codis(){
    $('#txtNroSIS').val('');
    $('#txtIdGestante').val('');
    $('#txtFechaParto').val('');
    $('#txtEdadGest').val('');
    if ($('#txtCodSIS').val() == ""){
      $('#txtNroSIS').prop("readonly", true);
      $('#txtIdGestante').prop("disabled", true);
      setTimeout(function(){$('#txtCodSIS').trigger('focus');}, 2);
    } else if ($('#txtCodSIS').val() == "2"){
      if(($('#txtCodSIS').val() == "2") && ($('#txtIdTipDoc').val() == "1")){
        $('#txtNroSIS').prop("readonly", true);
        $('#txtNroSIS').val($('#txtNroDoc').val());
        if($('#txtIdSexoPac').val() == "2"){
          $('#txtIdGestante').prop("disabled", false);
          setTimeout(function(){$('#txtIdGestante').trigger('focus');}, 2);
        } else {
          $('#txtIdGestante').val('2');
          setTimeout(function(){$('#txtFechaAten').trigger('focus');}, 2);
        }
      } else {
        $('#txtNroSIS').prop("readonly", true);
        $('#txtIdGestante').prop("disabled", true);
        setTimeout(function(){$('#txtCodSIS').trigger('focus');}, 2);
      }
    } else if ($('#txtCodSIS').val() == "3"){
      if(($('#txtCodSIS').val() == "3") && ($('#txtIdTipDoc').val() == "2")){
        $('#txtNroSIS').prop("readonly", true);
        $('#txtNroSIS').val($('#txtNroDoc').val());
        if($('#txtIdSexoPac').val() == "2"){
          $('#txtIdGestante').prop("disabled", false);
          setTimeout(function(){$('#txtIdGestante').trigger('focus');}, 2);
        } else {
          $('#txtIdGestante').val('2');
          setTimeout(function(){$('#txtFechaAten').trigger('focus');}, 2);
        }
      } else {
        $('#txtNroSIS').prop("readonly", true);
        $('#txtIdGestante').prop("disabled", true);
        setTimeout(function(){$('#txtCodSIS').trigger('focus');}, 2);
      }
    } else if ($('#txtCodSIS').val() == "N"){
      $('#txtNroSIS').prop("readonly", true);
      $('#txtIdGestante').prop("disabled", true);
      setTimeout(function(){$('#txtFechaAten').trigger('focus');}, 2);
    } else {
      $('#txtNroSIS').prop("readonly", false);
      if($('#txtIdSexoPac').val() == "2"){
        $('#txtIdGestante').prop("disabled", false);
      } else {
        $('#txtIdGestante').val('2');
      }
      setTimeout(function(){$('#txtNroSIS').trigger('focus');}, 2);
    }
  }

  function change_gestante(){
    if (($('#txtIdGestante').val() == "2") || ($('#txtIdGestante').val() == "")){
      $('#txtEdadGest').prop("readonly", true);
      $('#txtFechaParto').prop("disabled", true);
      setTimeout(function(){$('#txtFechaAten').trigger('focus');}, 2);
    } else {
      $('#txtEdadGest').prop("readonly", false);
      $('#txtFechaParto').prop("disabled", false);
      setTimeout(function(){$('#txtFechaParto').trigger('focus');}, 2);
    }
  }

  function buscar_datos_personales(){
    $('#txtIdPer').val('0');
    var msg = "";
    var sw = true;
    var txtIdTipDoc = $('#txtIdTipDoc').val();
    var txtNroDoc = $('#txtNroDoc').val();
    var txtNroDocLn = txtNroDoc.length;

    $("#txtNomPac").val('');
    $("#txtPriApePac").val('');
    $("#txtSegApePac").val('');
    $("#txtIdSexoPac").val('');
    $("#txtFecNacPac").val('');
    $("#txtEdadPac").val('');
    $("#txtNroTelFijoPac").val('');
    $("#txtNroTelMovilPac").val('');
    $("#txtEmailPac").val('');
    $("#txtNroHC").val('');
    $('#txtIdGestante').val('');
    $('#txtIdGestante').prop("disabled", true);
    $('#txtCodSIS').val('');
    $('#txtNroSIS').val('');

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
          $("#txtNroHC").trigger('focus');
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
          $("#txtNroHC").val(datos[10]);
          $('#txtNomPac').prop("readonly", true);
          $('#txtPriApePac').prop("readonly", true);
          $('#txtSegApePac').prop("readonly", true);
          $('#txtIdSexoPac').prop("disabled", true);
          $('#txtFecNacPac').prop("disabled", true);
          if(datos[9] == ""){
            $('#txtFecNacPac').prop("disabled", false);
          }
          if(datos[10] == ""){
            $("#txtNroHC").trigger('focus');
            $('#txtNroHC').prop("readonly", false);
          } else{
            $("#txtNroTelFijoPac").trigger('focus');
          }
        }
      }
    });
  }

  function buscar_datos_personalessoli(){
    $('#txtIdSoli').val('0');
    var msg = "";
    var sw = true;
    var txtIdTipDoc = $('#txtIdTipDocSoli').val();
    var txtNroDoc = $('#txtNroDocSoli').val();
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

    $('#btnSoliSearch').prop("disabled", true);
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
          $("#txtIdSexoSoli").trigger('focus');
        } else {
          $("#txtNomSoli").val(datos[4]);
          $("#txtPriApeSoli").val(datos[5]);
          $("#txtSegApeSoli").val(datos[6]);
          $("#txtIdSexoSoli").val(datos[7]);
          $("#txtFecNacSoli").val(datos[9]);
          $("#txtNroTelFijoSoli").val(datos[11]);
          $("#txtNroTelMovilSoli").val(datos[12]);
          $("#txtEmailSoli").val(datos[13]);
          $('#txtNomSoli').prop("readonly", true);
          $('#txtPriApeSoli').prop("readonly", true);
          $('#txtSegApeSoli').prop("readonly", true);
          $('#txtIdSexoSoli').prop("disabled", true);
          $('#txtFecNacSoli').prop("disabled", true);
          $('#btnSoliSearch').prop("disabled", false);
          if(datos[9] == ""){
            $('#txtFecNacSoli').prop("disabled", false);
          }
          $("#txtNroTelFijoSoli").trigger('focus');
        }
      }
    });

  }

  function show_area(area) {
    var ingResul = $("#txtIngResul" ).val();
    if(ingResul == "SI") return false;

    $('#showArea' + area).modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });

    $('#showArea' + area).on('shown.bs.modal', function (e) {
      var nameInput = '';
      var AnameInput = $('#frmArea' + area).serializeArray();
      nameInput = AnameInput[0]['name'];
      $("#" + nameInput).trigger('focus');

    })
  }

  function save_area(area) {
    var AnameInput = $('#frmArea' + area).serializeArray();
    var ing = "";
    len = AnameInput.length;
    for (i=0; i<len; i++) {
      nameInput = AnameInput[i]['name'];
      if($("#" + nameInput).val() != ""){
        ing = "1";
        break;
      }
    }

    if(ing == ""){
      bootbox.alert("Ingrese almenos un resultado<br/>");
      return false;
    }

    $("#lblArea" + area).text('GENERADO');
    $("#bgArea" + area).removeClass("bg-aqua").addClass("bg-yellow");
    $('#showArea'+ area).modal('hide');
    var txtShowOptPrint = $('#txtShowOptPrint').val();
    if(txtShowOptPrint==""){
      $('#txtShowOptPrint').val("#print" + area);
    } else {
      $('#txtShowOptPrint').val(txtShowOptPrint + ", #print" + area);
    }

  }

  function cancel_area(area) {
    bootbox.confirm({
      message: "Se borrará los registros ingresados, ¿Está seguro de continuar?",
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
          var AnameInput = $('#frmArea' + area).serializeArray();
          var ing = "";
          len = AnameInput.length;
          for (i=0; i<len; i++) {
            nameInput = AnameInput[i]['name'];
            $("#" + nameInput).val('');
          }

          $("#lblArea" + area).text('POR GENERAR');
          $("#bgArea" + area).removeClass("bg-yellow").addClass("bg-aqua");
          $('#showArea'+ area).modal('hide');
        }
      }
    });
  }

  function open_pdf(area) {

    var urlwindow = "pdf_laboratorio.php?id_atencion=" + $("#txtIdAtencion").val() +"&id_area=" + area;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
  }

  function validForm() {
    $('#btn-submit').prop("disabled", true);
    var msg = "";
    var sw = true;

    var txtIdTipDoc = $('#txtIdTipDoc').val();
    var txtNroDoc = $('#txtNroDoc').val();
    var txtNroDocLn = txtNroDoc.length;
    var txtNroHC = $('#txtNroHC').val();
    var txtNomPac = $('#txtNomPac').val();
    var txtPriApePac = $('#txtPriApePac').val();
    var txtSegApePac = $('#txtSegApePac').val();
    var txtNroTelMovilPac = $('#txtNroTelMovilPac').val();
    var txtNroTelFijoPac = $('#txtNroTelFijoPac').val();
    var txtCodSIS = $('#txtCodSIS').val();
    var txtIdGestante = $('#txtIdGestante').val();
    var txtEdadGest = $('#txtEdadGest').val();
    var txtNroRefAtencion = $('#txtNroRefAtencion').val();
    var txtFechaAten = $('#txtFechaAten').val();
    var txtHoraAten = $('#txtHoraAten').val();
    var txtIdDepOri = $('#txtIdDepOri').val();


    if (txtIdTipDoc == "1") {
      if (txtNroDocLn != 8) {
        msg += "Ingrese el Nro. de documento correctamente<br/>";
      }
    } else if(txtIdTipDoc == "2" || txtIdTipDoc == "4"){
      if (txtNroDocLn <= 5) {
        msg += "Ingrese el Nro. de documento correctamente<br/>";
      }
    } else {
      if (txtNroDocLn <= 9) {
        msg += "Ingrese el Nro. de documento correctamente<br/>";
      }
    }
    if (txtNroHC == "") {
      msg += "Ingrese el Nro. de Historia Clínica<br/>";
    }
    if (txtNomPac == "") {
      msg += "Ingrese el nombre del Paciente<br/>";
    }
    if (txtPriApePac == "") {
      msg += "Ingrese el primer apellido del Paciente<br/>";
    }
    if (txtSegApePac == "") {
      msg += "Ingrese el segundo apellido del Paciente<br/>";
    }
    if (txtNroTelFijoPac == "") {
      if (txtNroTelMovilPac == "") {
        msg += "Ingrese el Nro. de Telefono fijo del paciente<br/>";
      }
    }
    if(txtCodSIS == ""){
      msg += "Seleccione tipo de seguro<br/>";
      sw = false;
    }
    if (txtIdGestante == "1") {
      if (txtEdadGest == "") {
        msg += "La edad gestacional es obligatorio en pacientes gestantes.<br/>";
      }
    }
    if (txtEdadGest != "") {
      if (txtEdadGest > 42) {
        msg += "La edad gestacional debe ir desde el 1 al 42<br/>";
      }
    }
    if (txtNroRefAtencion == "") {
      msg += "Ingrese el número de la atención<br/>";
    }
    if (txtFechaAten == "") {
      msg += "Ingrese la fecha de atención<br/>";
    }
    if (txtHoraAten == "") {
      msg += "Ingrese la hora de atención<br/>";
    }

    var txtIdCpt = $('#txtIdCpt').val();
    if((txtIdCpt == null) || (txtIdCpt == "")){
      msg += "Seleccione al menos un PROCEDIMIENTO LABORATORIO a solicitar<br/>";
      sw = false;
    }else {
      var txtIdCpt = String($('#txtIdCpt').val());
      var len = txtIdCpt.substr(0,1);
      if(len == ","){
        msg += "No seleccione la opnción \"--Seleccione--\"<br/>";
        sw = false;
      }
    }

    var generado = $('#txtShowOptPrint').val();
    if(generado == ""){
      msg += "Generar la información de almenos una Área<br/>";
      sw = false;
    }

    if (sw == false) {
      bootbox.alert(msg);
      $('#btn-submit').prop("disabled", false);
      return sw;
    } else {
      save_atencion();
    }
    return false;
  }


  function save_atencion() {
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

          var selectednumbers = [];
          $('.js-example-basic-multiple :selected').each(function(i, selected) {
            selectednumbers[i] = $(selected).val();
          });

          $.ajax( {
            type: 'POST',
            url: '../../controller/ctrlAtencion.php',
            data: $("<?php echo $frm ?>").serialize()
            + "&txtIdPer=" + $('#txtIdPer').val() + "&txtIdTipDoc=" + $('#txtIdTipDoc').val() + "&txtNroDoc=" + $('#txtNroDoc').val() + "&txtNroHC=" + $('#txtNroHC').val() + "&txtIdSexoPac=" + $('#txtIdSexoPac').val() + "&txtFecNacPac=" + $('#txtFecNacPac').val() + "&txtNomPac=" + $('#txtNomPac').val() + "&txtPriApePac=" + $('#txtPriApePac').val() + "&txtSegApePac=" + $('#txtSegApePac').val() + "&txtNroTelFijoPac=" + $('#txtNroTelFijoPac').val() + "&txtNroTelMovilPac=" + $('#txtNroTelMovilPac').val() + "&txtEmailPac=" + $('#txtEmailPac').val()
            + "&txtIdSoli=" + $('#txtIdSoli').val() + "&txtIdTipDocSoli=" + $('#txtIdTipDocSoli').val() + "&txtNroDocSoli=" + $('#txtNroDocSoli').val() + "&txtIdSexoSoli=" + $('#txtIdSexoSoli').val() + "&txtFecNacSoli=" + $('#txtFecNacSoli').val() + "&txtNomSoli=" + $('#txtNomSoli').val() + "&txtPriApeSoli=" + $('#txtPriApeSoli').val() + "&txtSegApeSoli=" + $('#txtSegApeSoli').val() + "&txtNroTelFijoSoli=" + $('#txtNroTelFijoSoli').val() + "&txtNroTelMovilSoli=" + $('#txtNroTelMovilSoli').val() + "&txtEmailSoli=" + $('#txtEmailSoli').val()
            + "&txtNroRefAtencion=" + $('#txtNroRefAtencion').val() + "&txtIdTipAtencion=" + $('#txtIdTipAtencion').val() + "&txtIdDepRef=" + $('#txtIdDepRef').val() + "&txtNroRefDep=" + $('#txtNroRefDep').val() + "&txtCodSIS=" + $('#txtCodSIS').val() + "&txtNroSIS=" + $('#txtNroSIS').val() + "&txtIdGestante=" + $('#txtIdGestante').val() + "&txtFechaParto=" + $('#txtFechaParto').val() + "&txtEdadGest=" + $('#txtEdadGest').val() +"&txtFechaAten=" + $('#txtFechaAten').val() + "&txtHoraAten=" + $('#txtHoraAten').val() + "&txtIdCpt=" + selectednumbers + "&txtNroFUA=" + $('#txtNroFUA').val() + "&txtPesoPac=" + $('#txtPesoPac').val() + "&txtTallaPac=" + $('#txtTallaPac').val() + "&txtPAPac=" + $('#txtPAPac').val()
            + "&accion=POST_ADD_ATENCION",
            success: function(data) {
              var tmsg = data.substring(0, 2);
              var lmsg = data.length;
              var msg = data.substring(3, lmsg);
              //console.log(tmsg);
              if(tmsg == "OK"){
                $($('#txtShowOptPrint').val()).show();
                $("#saveAtencion").hide();
                $("#impriAtencion").show();
                $('#txtIdAtencion').val(msg);
                $('.sel-cursor').attr('style','cursor: text;');
                $('#txtIngResul').val('SI');
                bootbox.alert("El registro se guardo correctamente.");
                return false;
              } else {
                $('#btn-submit').prop("disabled", false);
                bootbox.alert(msg);
                return false;
              }
            }
          });
        } else {
          $('#btn-submit').prop("disabled", false);
        }
      }
    });
  }

  $(document).ready(function() {

    $("#txtFechaAten").datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
    });
    $('#txtFechaAten').inputmask();

    $("#txtFecNac").datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
    });
    $('#txtFecNac').inputmask();
    $('#txtFecNac').inputmask("99:99");

    $("#txtIdTipDoc").select2();
    $("#txtIdDepRef").select2();
    setTimeout(function(){$('#txtNroDoc').trigger('focus');}, 2);

    $(".js-example-basic-multiple").select2({
      width: 'resolve', // need to override the changed default
      max_selected_options: 4
    });
    /*
    var selectedValues = new Array();
    <?php
    /*$n = 0;
    foreach ($consultoriomedico as $rowConsul):
    ?>
    selectedValues[<?php echo $n?>] = "<?php echo $rowConsul->id_consultorio?>";
    <?php
    $n++;
  endforeach;*/
  ?>
  $('.js-example-basic-multiple').val(selectedValues).trigger('change')*/
});

</script>
<?php require_once '../include/masterfooter.php'; ?>

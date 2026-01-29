<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php
require_once '../include/sidebar.php';


require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Ubigeo.php';
$ub = new Ubigeo();
require_once '../../model/Ubigeo.php';
$ub = new Ubigeo();

?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title" style="text-align: center;"><strong>REGISTRAR ATENCIÓN</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-6 col-md-4">
          <div class="box box-success">
            <br/>
            <div class="box-body box-profile">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">DATOS DEL PACIENTE</h3>
                </div>
                <div class="panel-body">
                  <form name="frmSolicitud" id="frmSolicitud">
                    <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="0"/>
                    <input type="hidden" name="txtIdPac" id="txtIdPac" value="0"/>
                    <input type="hidden" name="txtIdSoli" id="txtIdSoli" value="0"/>
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
                          <option value="2">EXONERADO</option>
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
                          <input type="text" name="txtPriApePac" class="form-control input-sm text-uppercase" id="txtPriApePac" maxlength="75" onkeydown="campoSiguiente('txtSegApePac', event);" readonly/>
                        </div>
                        <div class="col-sm-6">
                          <label for="txtSegApePac">Apellido materno</label>
                          <input type="text" name="txtSegApePac" class="form-control input-sm text-uppercase" id="txtSegApePac" maxlength="75" onkeydown="campoSiguiente('txtNomPac', event);" readonly/>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="txtNomPac">Nombre(s)</label>
                      <input type="text" name="txtNomPac" class="form-control input-sm text-uppercase" id="txtNomPac" maxlength="180" onkeydown="campoSiguiente('txtFecNacPac', event);" readonly/>
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
                      <div class="row">
                        <div class="col-sm-6">
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
                        <div class="col-sm-6">
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
                      <input type="text" name="txtDirPac" id="txtDirPac" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="185" value="" onkeydown="campoSiguiente('txtDirRefPac', event);" readonly/>
                    </div>
                    <div class="form-group">
                      <label for="txtDirRefPac">Referencia:</label>
                      <input type="text" name="txtDirRefPac" id="txtDirRefPac" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="185" value="" onkeydown="campoSiguiente('txtNroTelFijoPac', event);" readonly/>
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
                              <select class="form-control input-sm" name="txtIdTipDocSoliT" id="txtIdTipDocSoliT" onchange="maxlength_doc_bus_soli_t()" disabled>
                                <?php
                                foreach ($rsT as $row) {
                                  echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . ": " . $row['descripcion'] . "</option>";
                                }
                                ?>
                              </select>
                            </div>
                            <div class="col-sm-8">
                              <div class="input-group input-group-sm">
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
                          <div class="input-group input-group-sm">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-success" id="btnDeletAPo" onclick="delete_apo('')"><i class="fa fa-remove"></i> Quitar</button>
                            </div>
                            <input type="text" class="form-control text-uppercase" name="txtNomCompleSoli" id="txtNomCompleSoli" maxlength="175" value="" readonly/>
                          </div>
                          <span id="lbl-parentesco" class="help-block"></span>
                        </div>
                      </div>
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-8">
          <div class="box box-primary">
            <div class="col-sm-12 col-md-8">
              <br/>
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">ADJUNTAR ARCHIVOS</h3>
                </div>
                <div class="panel-body">
                  <form action="" method="post" class="dropzone" id="id_dropzone">
                    <!--<form id="id_dropzone" class="dropzone" action="/ajax_file_upload_handler/" enctype="multipart/form-data" method="post">-->
                  </form>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <br/>
              <!--<div class="panel panel-primary">
              <div class="panel-heading">
              <h3 class="panel-title">ARCHIVOS ADJUNTOS</h3>
            </div>
            <div class="panel-body">
            <div id="tree_3" class="tree-demo"></div>
          </div>
        </div>-->
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">DATOS DE LA ATENCIÓN</h3>
          </div>
          <div class="panel-body">
            <form name="frmAtencion" id="frmAtencion">
              <div class="form-group">
                <label style="font-weight: bold !important;">Estrategia TBC:</label>
                <div class="input-group">
                  <label><input type="radio" name="txtTBC" id="txtTBC1" class="opt_tbc" value="1" disabled/> SI </label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="txtTBC" id="txtTBC0" class="opt_tbc" value="0" disabled/> NO</label>
                </div>
              </div>
              <div class="form-group">
                <label for="txtIdDepRef">Referencia realizada por:</label>
                <?php $rsD = $d->get_listaDepenInstitucion(); ?>
                <select name="txtIdDepRef" id="txtIdDepRef" style="width:100%;" class="form-control"  onkeydown="campoSiguiente('txtNroRefDep', event);" disabled>
                  <option value="0" selected="">NINGUNO</option>";
                  <?php
                  foreach ($rsD as $row) {
                    echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="txtIdTipExa" class="control-label">Tipo de Examen:</label>
                <?php $rsRx = $t->get_listaRx(); ?>
                <select name="txtIdTipExa" id="txtIdTipExa" class="form-control" style="width:100%;" onkeydown="campoSiguiente('txtObsSoli', event);" disabled>
                  <option value="">SELECCIONE</option>
                  <?php
                  foreach ($rsRx as $row) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nom_tiporx'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="txtObsSoli">Observaciones: </label>
                <textarea class="form-control" rows="8" name="txtObsSoli" id="txtObsSoli" disabled></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success btn-block" type="button" id="btnValidForm" onclick="save_form()">&nbsp; &nbsp; <i class="glyphicon glyphicon-share-alt"></i> REGISTRAR &nbsp; &nbsp; &nbsp; &nbsp;</button>
            <button type="button" class="btn btn-default btn-block" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Regresar</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
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
<?php require_once '../include/footer.php'; ?>
<script type="text/javascript" src="main_principalsoli.js"></script>
<script Language="JavaScript">
var nomcarpeta = "<?php echo date("dmYhis")?>";


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



  $('[name="txtTipPac"]').change(function()
  {

    enabled_datos_documento();
    maxlength_doc_bus();
    $('#txtNroHCPac').prop("disabled", false);
    enabled_datos_direccion();
    enabled_datos_atencion();

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

    $('div.dz-default.dz-message > span').show(); // Show message span
    $('div.dz-default.dz-message').css({'opacity':1, 'background-image': 'none', 'text-align': 'center'});
    $('div.dz-message').css({'font-weight': 400, 'color': '#646C7F'});
    $(".dz-hidden-input").prop("disabled",false);

  });


});

function back() {
  window.location = './main_rx.php';
}

function archivos_cargados(){
  $.ajax({
    url: "../../controller/ctrlRx.php",
    type: "POST",
    data: {
      accion: 'GET_SHOW_ARCHIVOS', folder: nomcarpeta, idEst: '1'
    },
    success: function (registro) {
      $("#tree_3").html(registro);
    }
  });
}

function eli_archivos(rmvFile){
  $.ajax({
    url: "../../controller/ctrlRx.php",
    type: "POST",
    data: {
      accion: 'POST_UPLOAD_ARCHIVOS', caso: 'elimina', file: rmvFile, folder: nomcarpeta
    },
    success: function (registro) {
      archivos_cargados();
    }
  });
}

function campoSiguiente(campo, evento) {
  if (evento.keyCode == 13 || evento.keyCode == 9) {
    if (campo == 'btnPacSearch') {
      buscar_datos_personales();
    } else if (campo == 'txtPriApePac') {
      if ($('#txtPriApePac').val() != ""){
        if($('#txtIdEtniaPac').val() != ""){
          $('#txtUBIGEOPac').select2('open');
        } else {
          $('#txtIdEtniaPac').select2('open');
        }
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    } else if (campo == 'txtIdPaisNacPac'){
      if($('#txtIdPaisNacPac').val() != ""){
        $('#txtUBIGEOPac').select2('open');
      } else {
        $('#txtIdPaisNacPac').select2('open');
      }
    } else if (campo == 'txtIdEtniaPac'){
      $('#txtIdEtniaPac').select2('open');
    } else if (campo == 'txtUBIGEOPac'){
      $('#txtUBIGEOPac').select2('open');
    } else if (campo == 'btnSoliTSearch') {
      buscar_datos_personales_soli('1');
    } else if (campo == 'btnSoliSearch') {
      buscar_datos_personales_soli('2');
    } else if (campo == 'btnValidFormSoli') {
      validFormSoli('1');
    } else {
      document.getElementById(campo).focus();
      evento.preventDefault();
    }
  }
}




function save_form() {

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
      msg+= "Seleccione tipo (PAGANTE/EXONERADO) paciente particular<br/>";
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

  var idtbc = document.frmAtencion.txtTBC.value;
  var iddepref = $('#txtIdDepRef').val();
  var idtipexa = $('#txtIdTipExa').val();
  var obssoli = $('#txtObsSoli').val();

  if(idtbc == ""){
    msg+= "Seleccione estrategia TBC (SI/NO)<br/>";
    sw = false;
  }

  if(idtipexa == ""){
    msg+= "Seleccione Tipo de examen<br/>";
    sw = false;
  }


  if (sw == false) {
    bootbox.alert(msg);
    $('#btnValidForm').prop("disabled", false);
    return false;
  }

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
        url: '../../controller/ctrlRx.php',
        data: {
          accion: 'POST_ADD_ATENCION',
          txtTipPac: document.frmSolicitud.txtTipPac.value, txtIdTipPacParti: $("#txtIdTipPacParti").val(),
          txtIdPac: document.frmSolicitud.txtIdPac.value, txtIdTipDocPac: document.frmSolicitud.txtIdTipDocPac.value, txtNroDocPac: document.frmSolicitud.txtNroDocPac.value, txtNroHCPac: document.frmSolicitud.txtNroHCPac.value, txtNomPac: document.frmSolicitud.txtNomPac.value, txtPriApePac: document.frmSolicitud.txtPriApePac.value, txtSegApePac: document.frmSolicitud.txtSegApePac.value, txtIdSexoPac: document.frmSolicitud.txtIdSexoPac.value, txtFecNacPac: document.frmSolicitud.txtFecNacPac.value, txtIdPaisNacPac: document.frmSolicitud.txtIdPaisNacPac.value, txtIdEtniaPac: document.frmSolicitud.txtIdEtniaPac.value, txtUBIGEOPac: document.frmSolicitud.txtUBIGEOPac.value, txtDirPac: document.frmSolicitud.txtDirPac.value, txtDirRefPac: document.frmSolicitud.txtDirRefPac.value, txtNroTelFijoPac: document.frmSolicitud.txtNroTelFijoPac.value, txtNroTelMovilPac: document.frmSolicitud.txtNroTelMovilPac.value, txtEmailPac: document.frmSolicitud.txtEmailPac.value,
          txtIdSoli: document.frmSolicitud.txtIdSoli.value, txtIdTipDocSoli: document.frmSolicitante.txtIdTipDocSoli.value, txtNroDocSoli: document.frmSolicitante.txtNroDocSoli.value, txtNomSoli: document.frmSolicitante.txtNomSoli.value, txtPriApeSoli: document.frmSolicitante.txtPriApeSoli.value, txtSegApeSoli: document.frmSolicitante.txtSegApeSoli.value, txtIdSexoSoli: document.frmSolicitante.txtIdSexoSoli.value, txtFecNacSoli: document.frmSolicitante.txtFecNacSoli.value, txtIdParenSoli: document.frmSolicitante.txtIdParenSoli.value, txtIdPaisNacSoli: document.frmSolicitante.txtIdPaisNacSoli.value, txtIdEtniaSoli: document.frmSolicitante.txtIdEtniaSoli.value, txtNroTelFijoSoli: document.frmSolicitante.txtNroTelFijoSoli.value, txtNroTelMovilSoli: document.frmSolicitante.txtNroTelMovilSoli.value, txtEmailSoli: document.frmSolicitante.txtEmailSoli.value,
          txtIdAtencion: document.frmSolicitud.txtIdAtencion.value, txtTBC: document.frmAtencion.txtTBC.value, txtIdDepRef: document.frmAtencion.txtIdDepRef.value, txtIdTipExa: document.frmAtencion.txtIdTipExa.value, txtObsSoli: document.frmAtencion.txtObsSoli.value, nomcarpeta: nomcarpeta,
          rand: myRand,
        },
        success: function(data) {
          var tmsg = data.substring(0, 2);
          var lmsg = data.length;
          var msg = data.substring(3, lmsg);
          //console.log(tmsg);
          if(tmsg == "OK"){
            location.href ="./main_rx.php";
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


jQuery(document).ready(function () {
  $('.archivo').click(function () {
    window.open("", "_blank").location = $(this).attr('href');
  });
});

Dropzone.autoDiscover = false;
var fileList = new Array;
var i =0;

$(document).ready(function () {

  $('#txtIdPaisNacPac').select2();
  $('#txtIdEtniaPac').select2();
  $('#txtUBIGEOPac').select2();
  $('#txtIdDepRef').select2();
  $('#txtIdTipExa').select2();
  $('#txtIdParenSoli').select2();

  $("#id_dropzone").addClass("dropzone").dropzone({
    maxFiles: 10,
    maxFilesize: 2, //in MB
    addRemoveLinks: true,
    dictDefaultMessage : 'Adjuntar archivos',
    acceptedFiles: ".png, .jpg, .bmp, .jpeg, .pdf, .rar, .xls, .xlsx, .pdf, .doc, .docx",
    init: function() {
      this.on("success", function(file, serverFileName) {
        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i};
        //console.log(fileList);
        i++;
      });
      this.on("removedfile", function(file) {
        var rmvFile = file.name;
        if (rmvFile){
          $.ajax({
            url: "../../controller/ctrlRx.php",
            type: "POST",
            data: { 'accion': 'POST_UPLOAD_ARCHIVOS', 'caso': 'elimina', 'file': rmvFile, 'folder': nomcarpeta},
            success: function (file, response) {
              //console.log(response);
              //archivos_cargados();
            }
          });
        }
      });
      this.on("complete", function (file) {
        //$('#txtcantUploads').val(fileList.length);
        //alert(fileList.length);
        //archivos_penrevision();
      });
    },
    url: "../../controller/ctrlRx.php",
    params: {'accion': 'POST_UPLOAD_ARCHIVOS', 'caso': 'carga', 'folder': nomcarpeta},
    success: function (file, response) {
      //console.log(response);
      //archivos_cargados();
    }
  });

  $(".dz-hidden-input").prop("disabled",true);
});

</script>
<?php require_once '../include/masterfooter.php'; ?>

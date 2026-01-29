<div class="modal fade" id="showUsuarioModal" role="dialog" aria-labelledby="showUsuarioModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showUsuarioModalLabel">REGISTRO PROFESIONAL</h4>
      </div>
      <div class="modal-body">
        <form name="frmUsuario" id="frmUsuario">
          <input type="hidden" name="txtIdPer" id="txtIdPer" value="0"/>
          <input type="hidden" name="txtIdProfesional" id="txtIdProfesional" value="0"/>
		  <input type="hidden" name="txtValidReniec" id="txtValidReniec" value="0"/>
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>Datos personales</strong></h3>
            </div>
            <div class="panel-body" style="padding-top: 2px !important;">
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
                        <input type="text" name="txtNroDoc" placeholder="Número de documento" required="" id="txtNroDoc" class="form-control input-xs text-uppercase" maxlength="8" onkeydown="campoSiguiente('btn-pac-search', event);"/>
                        <div class="input-group-btn">
                          <button class="btn btn-info" type="button" id="btn-pac-search" onclick="validate_exis_profesional()"><i class="fa fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtIdSexoPac">Sexo<span class="span-asterisk">(*)</span>: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <select class="form-control input-xs" name="txtIdSexoPac" id="txtIdSexoPac" onkeydown="campoSiguiente('txtFecNacPac', event);" disabled>
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
                      <label for="txtFecNacPac"> Fecha Nac.<span class="span-asterisk">(*)</span>: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group input-group-xs">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" name="txtFecNacPac" id="txtFecNacPac" placeholder="DD/MM/AAAA" required="" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtNomPac', event);" disabled/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtNomPac"> Nombre(s)<span class="span-asterisk">(*)</span>: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <input type="text" name="txtNomPac" class="form-control input-xs text-uppercase" id="txtNomPac" maxlength="180" onkeydown="campoSiguiente('txtPriApePac', event);" readonly/>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12"><label for="txtPriApePac">Apellido paterno<span class="span-asterisk">(*)</span>: </label></div>
                  </div>
                  <div class="row">
                    <div class="col-md-12"><input type="text" name="txtPriApePac" class="form-control input-xs text-uppercase" id="txtPriApePac" maxlength="75" onkeydown="campoSiguiente('txtSegApePac', event);" readonly/>
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
                      <input type="text" name="txtSegApePac" class="form-control input-xs text-uppercase" id="txtSegApePac" maxlength="75" onkeydown="campoSiguiente('txtNroTelFijoPac', event);" readonly/>
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
                        <input type="text" name="txtEmailPac" placeholder="@example.com" required="" id="txtEmailPac" onfocus="this.select()" class="form-control" maxlength="50" value="" onkeydown="campoSiguiente('txtIdProfesion', event);"/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- Fin Datos Personales -->
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">
                <strong>Datos del profesional</strong></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="txtIdProfesion">Profesión<span class="span-asterisk">(*)</span>:</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <?php $rsRU = $u->get_listaProfesion(); ?>
                        <select name="txtIdProfesion" id="txtIdProfesion" class="form-control input-xs"  style="width:100%;" onkeydown="campoSiguiente('txtNroCole', event);">
                          <option value="" selected="">-- Seleccione --</option>
                          <?php
                          foreach ($rsRU as $row) {
                            echo "<option value='" . $row['id_profesion'] . "'>" . $row['nom_profesion'] . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="txtNroCole">N° Colegiatura<span class="span-asterisk">(*)</span>: </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="input-group input-group-xs">
                          <div class="input-group-addon"><i class="fa fa-user-md"></i></div>
                          <input type="text" name="txtNroCole" id="txtNroCole" onfocus="this.select()" class="form-control" maxlength="9" value="" onkeydown="campoSiguiente('txtNroRne', event);"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="txtNroRne">N° RNE:</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="input-group input-group-xs">
                          <div class="input-group-addon"><i class="fa fa-medkit"></i></div>
                          <input type="text" name="txtNroRne" id="txtNroRne" onfocus="this.select()" class="form-control" maxlength="9" value="" onkeydown="campoSiguiente('txt_id_condicion_laboral', event);"/>
                        </div>
                      </div>
                    </div>
                  </div>
				  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="txt_id_condicion_laboral">Condi. Laboral:</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <?php $rsCL = $u->get_listaCondicion_laboral(); ?>
                        <select name="txt_id_condicion_laboral" id="txt_id_condicion_laboral" class="form-control input-xs">
                          <option value="" selected="">-- Seleccione --</option>
                          <?php
                          foreach ($rsCL as $row) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="col-md-12">
                    <label for="imgFirma">Firma:</label>
                    <input type="file" id="imgFirma" name="imgFirma"/>
                  </div>
                </div>
              </div>
          </form>
        </div>
        <div class="modal-footer" style="padding-bottom: 7px !important; padding-top: 7px !important;">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-continuar" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Guardar </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

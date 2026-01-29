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

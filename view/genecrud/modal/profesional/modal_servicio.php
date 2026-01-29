<div class="modal fade" id="modalServicio" role="dialog" aria-labelledby="showUsuarioModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showUsuarioModalLabel">Dependencia / Servicio</h4>
      </div>
      <div class="modal-body">
        <form name="frmServicio" id="frmServicio">
		<input type="hidden" name="txtIdProfesionalServicio" id="txtIdProfesionalServicio" value="0"/>
          <input type="hidden" name="ser_txtIdProfesional" id="ser_txtIdProfesional" value=""/>
          <input type="hidden" name="ser_txtIdUsuario" id="ser_txtIdUsuario" value=""/>
          <div class="row">
            <div class="col-md-12">
              <label for="ser_txtIdDep">Dependencia:</label>
              <?php $rsD = $d->get_listaDepenInstitucion(); ?>
              <select name="ser_txtIdDep" id="ser_txtIdDep" style="width:100%;" onchange="get_listaServicio('ser_txtIdDep','ser_txtIdServicioDep')">
                <option value="" selected="">-- Seleccione --</option>
                <?php
                foreach ($rsD as $row) {
                  echo "<option value='" . $row['id_dependencia'] . "'>" . $row['codref_depen'] . ": " . $row['nom_depen'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <label for="ser_txtIdServicioDep">Servicio</label>
              <select name="ser_txtIdServicioDep" id="ser_txtIdServicioDep" style="width:100%;" onkeydown="campoSiguiente('ser_txtIdCargo', event);">
                <option value="" selected="">-- Seleccione --</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="ser_txtIdCargo">Cargo:</label>
              <?php $rsRU = $u->get_listaCargo(); ?>
              <select name="ser_txtIdCargo" id="ser_txtIdCargo" class="form-control">
                <option value="" selected="">-- Ninguno --</option>
                <?php
                foreach ($rsRU as $row) {
                  echo "<option value='" . $row['id_cargo'] . "'>" . $row['nom_cargo'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <br/>
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>Datos de usuario</strong></h3>
            </div>
            <div class="panel-body">
				<div id="alert-no-user" style="display: none;">
					<div class="alert alert-danger alert-dismissible">
						<h4><i class="icon fa fa-ban"></i> Alerta</h4>
						El profesional no tiene usuario registrado.
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						  <label for="txtNomUsuario">Usuario: </label>
						  <div class="input-group input-group">
							<div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
							<input type="text" name="txtNomUsuario" id="txtNomUsuario" onfocus="this.select()" class="form-control text-uppercase" maxlength="25" value="" disabled/>
					  </div>
					</div>
					<div class="col-md-6">
						  <label for="txtIdRol">Rol:</label>
						  <?php $rsRU = $u->get_listaRol(); ?>
						  <select name="txtIdRol" id="txtIdRol" class="form-control" onkeydown="campoSiguiente('txtIdProfesion', event);">
							<option value="" selected="">-- Seleccione --</option>
							<?php
							foreach ($rsRU as $row) {
							  echo "<option value='" . $row['id_rol'] . "'>" . $row['nom_rol'] . "</option>";
							}
							?>
						  </select>
					</div>
			  </div>
        </div>
      </div>
    </div>
      </form>
    <div class="modal-footer">
      <div class="row">
        <div class="col-md-12 text-center">
          <div class="btn-group">
            <button type="button" class="btn btn-primary btn-continuar" id="btnSaveServicio" onclick="saveServicio('ins')"><i class="fa fa-save"></i>Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

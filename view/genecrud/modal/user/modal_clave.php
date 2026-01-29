<div class="modal fade" id="showClaveUsuario" role="dialog" aria-labelledby="showUsuarioModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showUsuarioModalLabel">CAMBIAR CONTRASEÑA</h4>
      </div>
      <div class="modal-body">
		<input type="hidden" name="cla_iduser" id="cla_iduser" value=""/>
		<div class="form-group">
			<label for="cla_clave">Nueva contraseña:</label>
			<div class="input-group input-group-sm">
				<div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
				<input type="password" name="cla_clave" id="cla_clave" onfocus="this.select()" class="form-control" maxlength="20" value=""/>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button type="button" class="btn btn-primary btn-continuar" id="btnValidFormClave" onclick="validFormClave()"><i class="fa fa-save"></i> Guardar </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

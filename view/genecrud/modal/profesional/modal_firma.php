<div class="modal fade" id="showFirmaModal" role="dialog" aria-labelledby="showFirmaModalLabel" style="display: none;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			  <h4 class="modal-title" id="showFirmaModalLabel">Editar Firma</h4>
			</div>
			<div class="modal-body">
			  <form name="frmImg" id="frmImg">
				<div class="row">
				<div class="col-md-8">
				  <label for="imgFirma1">Firma:</label>
				  <input type="file" id="imgFirma1" name="imgFirma1">
				</div>
			  </div>
			  </form>
		  </div>
			<div class="modal-footer" style="padding-bottom: 7px !important; padding-top: 7px !important;">
				<div class="row">
				  <div class="col-md-12 text-center">
					<div class="btn-group">
					  <button type="button" class="btn btn-primary" id="btnValidFormFirma" onclick="save_formfirma()"><i class="fa fa-save"></i> Guardar </button>
					  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
					</div>
				  </div>
				</div>
			</div>
		</div>
  </div>
</div>
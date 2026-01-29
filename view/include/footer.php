<div class="modal fade" id="showChangeClaveUser" role="dialog" aria-labelledby="showChangeClaveUserLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showChangeClaveUserLabel">CAMBIAR CONTRASEÑA</h4>
      </div>
      <div class="modal-body">
		<div class="form-group">
			<label for="cha_nclave">Nueva contraseña:</label>
			<div class="input-group input-group-sm">
				<div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
				<input type="password" name="cha_nclave" id="cha_nclave" onfocus="this.select()" class="form-control" maxlength="20" value=""/>
			</div>
		</div>
		<div class="form-group">
			<label for="cha_repitnclave">Repita<br/>nueva contraseña:</label>
			<div class="input-group input-group-sm">
				<div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
				<input type="password" name="cha_repitnclave" id="cha_repitnclave" onfocus="this.select()" class="form-control" maxlength="20" value=""/>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button type="button" class="btn btn-primary btn-continuar" id="btnChangeClaveUser" onclick="validChangeClaveUser()"><i class="fa fa-save"></i> Guardar </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Establecimiento:</strong> <?php echo $_SESSION['labNomDepUser'];?><br/>
        <strong>Servicio:</strong> <?php echo $_SESSION['labNomServicio'];?>
      </div>
      <div class="col-sm-12 text-center">
        <strong>Copyright &copy; 2019 <a href="#">DIRIS - LIMA CENTRO</a></strong> todos los derechos reservados.<br/>
        <strong>Oficina de Tecnologías de la Información<br/></strong>
      </div>
    </div>
  </div>
</footer>
<!-- Select2 -->
<script type="text/javascript" src="../../assets/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script type="text/javascript" src="../../assets/plugins/input-mask/jquery.inputmask.js"></script>
<script type="text/javascript" src="../../assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script type="text/javascript" src="../../assets/plugins/input-mask/jquery.inputmask.numeric.extensions.js"></script>
<script type="text/javascript" src="../../assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<!-- jQuery 2.1.4 -->
<!--<script type="text/javascript" src="../../assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>-->
<!-- bootstrap datepicker -->
<script src="../../assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- DataTables -->
<script type="text/javascript" src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="../../assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="../../assets/plugins/datatables/dataTables.checkboxes.min.js"></script>
<!--bootbox-->
<script type="text/javascript" src="../../assets/plugins/bootbox/bootbox.min.js"></script>
<!--bootbox-->
<script type="text/javascript" src="../../assets/plugins/toastr/toastr.min.js"></script>
<!-- dropzone -->
<!--<script type="text/javascript" src="../../assets/plugins/dropzone/dropzone.js"></script>-->
<!-- validar fecha, solo número, mascara fecha-->
<script type="text/javascript" src="../../assets/js/validForm.js"></script>
<!-- Canvas-->
<!--<script type="text/javascript" src="../../assets/js/canvas.js"></script>-->
<!-- Bootstrap 3.3.7 -->
<script type="text/javascript" src="../../assets/css/bootstrap/3.3.7/js/bootstrap.min.js"></script>

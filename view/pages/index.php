<?php
require_once '../../model/Pap.php';
$pap = new Pap();
require_once '../../model/Dependencia.php';
$d = new Dependencia();

?>
<?php require_once '../include/masterheader.php'; ?>
<style>
.bodyLogin {
  background-color: #367fa9;
}
</style>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<div class="row">
  <div class="col-sm-12">
    <div class="col-md-offset-3 col-md-6">
      <div class="panel-prime">
        <div class="panel-heading">
          <h3 class="panel-title"><strong>Inicio</strong></h3>
        </div>
        <div class="panel-body">
          <dl class="dl-horizontal">
            <dt>Usuario</dt>
            <dd><?php echo "(".$_SESSION['labNomUser']. ") " . $_SESSION['labNomPer']." " . $_SESSION['labApePatPer']." " . $_SESSION['labApeMatPer']?></dd>
            <dt>Establecimiento</dt>
            <dd><?php echo $_SESSION['labNomDepUser']?></dd>
            <dt>Servicio</dt>
            <dd><?php echo $_SESSION['labNomServicio']?></dd>
            <dt>Rol</dt>
            <dd><?php echo $_SESSION['labAbrevRolUser'];?></dd>
            <dd><?php echo $_SESSION['labNomRolUser']?></dd>
            <!--<dt>Contraseña</dt>
            <dd><a class="btn btn-sm btn-primary" href="#">Cambiar contraseña</a></dd>-->
            <?php
            if($_SESSION['labIdRolUser'] == "1" OR $_SESSION['labIdRolUser'] == "2"){
              ?>
              <br/>
              <dt>Cambiar EESS<?php echo $_SESSION['labIdTipoCorrelativo']?></dt>
              <dd><a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#mySeleDepModal">Cambiar Establecimiento de salud</a></dd>
              <?php
            }
            ?>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once '../include/footer.php'; ?>
<div class="modal fade" id="mySeleDepModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Seleccione depdencia</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label for="txtIdDep">Dependencia:</label>
            <?php $rsD = $d->get_listaDepenInstitucion(); ?>
            <select name="txtIdDep" id="txtIdDep" style="width:100%;">
              <option value="" selected="">-- Seleccione --</option>
              <?php
              foreach ($rsD as $row) {
                echo "<option value='" . $row['id_dependencia'] . "'>" . $row['codref_depen'] . ": " . $row['nom_depen'] . "</option>";
              }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnChangeDep" onclick="get_changeLoginDependencia()">Cambiar</button>
      </div>
    </div>
  </div>
</div>
<script Language="JavaScript">

function get_changeLoginDependencia() {
  var txtIdDep = $('#txtIdDep').val();
  if (txtIdDep == ""){
    return false;
  }
  $('#btnChangeDep').prop("disabled", true);
  $.ajax({
    url: "../../controller/ctrlLogin.php",
    type: "POST",
    data: {
      accion: 'POST_CHANGEDEP', idDep: txtIdDep
    },
    success: function (result) {
      $("#mySeleDepModal").modal('hide');
      location.reload();
    }
  });
}

$(document).ready(function() {
  $("#txtIdDep").select2({
    dropdownParent: $('#mySeleDepModal'),
    closeOnSelect: true
  });
  <?php
  if($labIdRolUser == "1" OR $labIdRolUser == "7"){
	$rs=$pap->get_datosPAPAlertaInicial($labIdDepUser);
    $cntFi = (int)$rs[0];
	$cntPo = (int)$rs[1];
    if($cntFi > 0){
		if($cntPo > 0){
      ?>
      bootbox.alert({
        message: "Existe al menos un envío <b>finalizado por Laboratorio Referencial.</b><br/><b class='text-danger'>Cuenta con (<?php echo $cntPo;?>) resultado(s) positivo(s), entregar a la brevedad posible a la paciente.</b>",
        callback: function () {
          window.location = '../pap/main_principalsolienv.php';
        }
      });
      <?php
    } else {
		?>
      bootbox.alert({
        message: "Existe al menos un envío <b>finalizado por Laboratorio Referencial.</b>",
        callback: function () {
          window.location = '../pap/main_principalsolienv.php';
        }
      });
		<?php
	}
  } else {
	  if($cntPo > 0){
		  ?>
		  bootbox.alert("<b class='text-danger'>Cuenta con (<?php echo $cntPo;?>) resultado(s) positivo(s), entregar a la brevedad posible a la paciente.</b>");
		  <?php
	  }
  }
  }
  ?>
});
</script>
<?php require_once '../include/masterfooter.php'; ?>

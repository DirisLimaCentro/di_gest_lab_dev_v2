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
<link href="../../assets/lib/videojs/css/video-js.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../assets/lib/videojs/js/video.js"></script>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<div class="row">
  <div class="col-sm-12">
    <div class="col-md-offset-3 col-md-6">
      <div class="panel-prime">
        <div class="panel-heading">
          <h3 class="panel-title"><strong>MANUAL DE USUARIO</strong></h3>
        </div>
        <div class="panel-body">

		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Toma de PAP</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Envió de PAP</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Entrega a Paciente</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <b>Manual de usuario en PPT:</b>
                <p>El manual de usuario indicará lo siguiente:</p>
                <ol>
                <li>Registrar toma de PAP</li>
                <li>Editar toma de PAP</li>
                <li>Anular toma de PAP</li>
              </ol>
			  <button type="button" class="btn btn-info" onclick=""><i class="fa fa-file-pdf-o"></i> Ver el manual</button><br/>
			    <b>Manual de usuario en VIDEO:</b>
                <p>Este video, se tomará el caso de registro de toma de PAP de una paciente extranjera, quien no está registrada en el sistema, por lo cual el sistema no la encontrará, teniendo que registrar sus datos personales manualmente.</p>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#pap_viedo1"><i class="fa fa-file-video-o"></i> Ver el video</button>
				
				
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <b>Manual de usuario en PPT:</b>
                <p>El manual de usuario indicará los pasos para realizar el envió de tomas de PAP.</p>
			    <b>Manual de usuario en VIDEO:</b>
                <p>Este video, indicará los pasos para realizar el envió de tomas de PAP.</p>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#pap_viedo2"><i class="fa fa-file-video-o"></i> Ver el video</button>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <b>Manual de usuario en PPT:</b>
                <p>El manual de usuario indicará los pasos para realizar la entrega de resultados a una paciente.</p>
			    <b>Manual de usuario en VIDEO:</b>
                <p>El manual de usuario indicará los pasos para realizar la entrega de resultados a una paciente.</p>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
		
        </div>
      </div>
    </div>
  </div>
</div>
<div id="pap_viedo1" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h2 class="modal-title">VIDEO</h2>
		</div>
		<div class="modal-body">
			<video class="fm-video video-js vjs-16-9 vjs-big-play-centered" data-setup="{}" controls id="pap_1">
				<source src="../manual/video/pap_1.mp4" type="video/mp4">
			</video>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default btn-block" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar ventana</button>
	  </div>
	</div>
</div>
</div>
<div id="pap_viedo2" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h2 class="modal-title">VIDEO</h2>
		</div>
		<div class="modal-body">
			<video class="fm-video video-js vjs-16-9 vjs-big-play-centered" data-setup="{}" controls id="pap_2">
				<source src="../manual/video/pap_2.mp4" type="video/mp4">
			</video>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default btn-block" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar ventana</button>
	  </div>
	</div>
</div>
</div>
<?php require_once '../include/footer.php'; ?>
<script type="text/javascript">
	function open_video(nom){
	  $('#mostrar_video').modal('show');
	  var reproductor = '';
	  $.ajax({
		url: '../../controller/ctrlManual.php',
		type: 'POST',
		data: 'accion=GET_SHOW_VIDEOMANUAL&nom_manual=' + nom,
		success: function(data){
		  $('#mostrar_video').html(data);
		},
		complete: function() {
		  	reproductor = videojs(nom, {
				fluid: true
			});
		},
		dataType: 'html'
	  });
	}

	var reproductor = videojs('pap_1, pap_2', {
		fluid: true
	});
</script>
<?php require_once '../include/masterfooter.php'; ?>

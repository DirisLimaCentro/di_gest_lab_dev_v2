<?php
session_start();
if (!isset($_SESSION["labAccess"])) {
  header("location:../index.php");
  exit();
}
if ($_SESSION["labAccess"] <> "Yes") {
  header("location:../index.php");
  exit();
}
$labIdUser = $_SESSION['labIdUser'];
$labIdDepUser = $_SESSION['labIdDepUser'];
$labIdServicioDepUser = $_SESSION['labIdServicioDep'];

switch ($_POST['accion']) {
	Case "GET_SHOW_VIDEOMANUAL":
	$nom_manual = $_POST['nom_manual'];
	?>
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h2 class="modal-title">VIDEO</h2>
		</div>
		<div class="modal-body">
			<video class="fm-video video-js vjs-16-9 vjs-big-play-centered" data-setup="{}" controls id="<?php echo $nom_manual;?>">
				<source src="../manual/video/<?php echo $nom_manual;?>.mp4" type="video/mp4">
			</video>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default btn-block" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar ventana</button>
	  </div>
	</div>
	<?php
	break;
}
?>

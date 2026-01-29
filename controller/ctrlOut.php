<?php
session_start();
session_unset();
// Finalmente, destruye la sesi&oacute;n
session_destroy();
header("location:../index.php");
?>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu-principal" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="../../assets/images/logo-formal.png" width="100" class="img-responsive" alt="Cinque Terre"/></a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-menu-principal">
      <ul class="nav navbar-nav navbar-right">
        <?php
        if (isset($labAccesoMenuUsu['1'])) {
          ?>
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Procesos<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <!--<li><a href="rep_mayoresfecha.php">Cumplen 18 A&ntilde;os</a></li>-->
              <?php
              foreach ($labAccesoMenuUsu['1'] as $key => $value) {
                $menuAcce = explode("|", $value);
                ?>
                <li><a href="<?php echo $menuAcce[1] ?>"><?php echo $menuAcce[0]; ?></a></li>
                <?php
              }
              ?>
            </ul>
          </li>
          <?php
        }
          if (isset($labAccesoMenuUsu['2'])) {
            ?>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!--<li><a href="rep_mayoresfecha.php">Cumplen 18 A&ntilde;os</a></li>-->
                <?php
                foreach ($labAccesoMenuUsu['2'] as $key => $value) {
                  $menuAcce = explode("|", $value);
                  ?>
                  <li><a href="<?php echo $menuAcce[1] ?>"><?php echo $menuAcce[0]; ?></a></li>
                  <?php
                }
                ?>
              </ul>
            </li>
            <?php
          }
          if (isset($labAccesoMenuUsu['3'])) {
            ?>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Estadística<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!--<li><a href="rep_mayoresfecha.php">Cumplen 18 A&ntilde;os</a></li>-->
                <?php
                foreach ($labAccesoMenuUsu['3'] as $key => $value) {
                  $menuAcce = explode("|", $value);
                  ?>
                  <li><a href="<?php echo $menuAcce[1] ?>"><?php echo $menuAcce[0]; ?></a></li>
                  <?php
                }
                ?>
              </ul>
            </li>
            <?php
          }
          if (isset($labAccesoMenuUsu['4'])) {
            ?>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Mantenimiento<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!--<li><a href="rep_mayoresfecha.php">Cumplen 18 A&ntilde;os</a></li>-->
                <?php
                foreach ($labAccesoMenuUsu['4'] as $key => $value) {
                  $menuAcce = explode("|", $value);
                  ?>
                  <li><a href="<?php echo $menuAcce[1] ?>"><?php echo $menuAcce[0]; ?></a></li>
                  <?php
                }
                ?>
              </ul>
            </li>
            <?php
          }
          ?>
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Mi Cuenta<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#"><?php echo $_SESSION['labNomUser'];?></a></li>
			  <?php if($_SESSION['labIdRolUser'] == "1"){?>
				<li><a target="_blank" href="../../assets/images/iconlab.ico">Icono</a></li>
			  <?php }?>
              <li class="divider"></li>
              <li><a href="#" onclick="event.preventDefault();change_clave();">Cambiar Contrase&ntilde;a</a></li>
              <!--<li class="divider"></li>
              <li><a href="../pages/main_manual.php">Manual de Usuario</a></li>-->
              <li class="divider"></li>
              <li><a href="../../controller/ctrlOut.php">Cerrar Sesi&oacute;n</a></li>
            </ul>
          </li>
          <!--<li><a href="../controller/ctrlOut.php"><i class="glyphicon glyphicon-log-out"></i> Cerrar Sesi&oacute;n</a></li>-->
        </ul>
      </div>
    </div>
  </nav>

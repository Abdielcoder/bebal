<?php

		if (isset($title))
		{
	?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <div class="navbar-brand">
<?php
	echo '<span style="font-style:oblique;font-size: 14px;" class="text-secondary">bebal</span>';
	echo '<br><span style="font-size: 12px;" class="text-white">'.$PROFILE.'-'.$ID_MUNICIPIO.'</span>';
//echo '<a class="navbar-brand" href="#">Stock X</a>';
?>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php if (isset($active_principal)){echo 'active';}?>" href="principal.php"><i class='bi bi-list'></i> Lista</a>
        </li>

<?php
if ( $PROFILE=='admin' ) {
?>
<li class="nav-item"><a class="nav-link <?php if (isset($active_usuarios)){echo 'active';}?>" href="usuarios.php"><i class='bi bi-person'></i> Usuarios</a></li>
<li class="nav-item"><a class="nav-link <?php if (isset($active_colonias)){echo 'active';}?>" href="colonias.php"><i class='bi bi-list-check'></i> Colonias</a></li>
<li class="nav-item"><a class="nav-link <?php if (isset($active_delegaciones)){echo 'active';}?>" href="delegacion.php"><i class='bi bi-list-check'></i> Delegaciones</a></li>
<li class="nav-item"><a class="nav-link <?php if (isset($active_giro)){echo 'active';}?>" href="giro.php"><i class='bi bi-list-check'></i> Giro</a></li>
<li class="nav-item"><a class="nav-link <?php if (isset($active_tramite)){echo 'active';}?>" href="tramite.php"><i class='bi bi-list-check'></i> Tramite</a></li>
<li class="nav-item"><a class="nav-link <?php if (isset($active_modalidad)){echo 'active';}?>" href="modalidad.php"><i class='bi bi-list-check'></i> Modalidad</a></li>
<li class="nav-item"><a class="nav-link <?php if (isset($active_serviciosAdicionales)){echo 'active';}?>" href="serviciosAdicionales.php"><i class='bi bi-list-check'></i> Servicios Adicionales</a></li>
<?php } else { ?>
<li class="nav-item"><a class="nav-link <?php if (isset($active_usuarios)){echo 'active';}?>" href="#"><i class='bi bi-person'></i> Usuarios</a></li>
<li class="nav-item"><a class="nav-link <?php if (isset($active_colonias)){echo 'active';}?>" href="#"><i class='bi bi-list-check'></i> Colonias</a></li>
<li class="nav-item"><a class="nav-link <?php if (isset($active_delegaciones)){echo 'active';}?>" href="#"><i class='bi bi-list-check'></i> Delegaciones</a></li>
<?php
}

$mes_actual=date("n");
$semana_actual = date('W');
$anio=date("Y");

?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-file-earmark-text"></i> Reportes
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="reporte1.php"><i class="bi bi-play-fill text-secondary"></i> Reporte 1</a></li>
            <li><a class="dropdown-item" href="reporte_Por_Mes.php?m=<?php echo $mes_actual;?>&y=<?php echo $anio;?>"><i class="bi bi-play-fill text-secondary"></i> Por Mes (<?php echo $mes_actual;?>)</a></li>
            <li><a class="dropdown-item" href="reporte_Por_Semana.php?w=<?php echo $semana_actual;?>&y=<?php echo $anio;?>"><i class="bi bi-play-fill text-secondary"></i> Por Semana <?php echo $semana_actual;?></a></li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="http://AppstravagenceSystems.com/contacto/" target='_blank'><i class='bi bi-envelope text-secondary'></i> Soporte</a></li>
		<li class="nav-item"><a class="nav-link" href="login.php?logout"><i class='bi bi-power text-secondary'></i> Salir</a></li>
      </ul>
    </div>
  </div>
</nav>
	<?php
		}
	?>

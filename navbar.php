<?php

		if (isset($title))
		{
            // Establecer el elemento Lista como activo por defecto si no hay otra selección
            // Asegurar que solo un elemento esté activo a la vez
            $active_principal = false;
            $active_usuarios = false;
            $active_colonias = false;
            $active_delegaciones = false; 
            $active_giro = false;
            $active_tramite = false;
            $active_modalidad = false;
            $active_serviciosAdicionales = false;
            $active_Generales = false;
            
            // Verificar la URL actual para determinar cuál debe estar activo
            $current_page = basename($_SERVER['PHP_SELF']);
            
            if ($current_page == 'principal.php') {
                $active_principal = true;
            } elseif ($current_page == 'usuarios.php') {
                $active_usuarios = true;
            } elseif ($current_page == 'colonia.php') {
                $active_colonias = true;
            } elseif ($current_page == 'delegacion.php') {
                $active_delegaciones = true;
            } elseif ($current_page == 'giro.php') {
                $active_giro = true;
            } elseif ($current_page == 'tramite.php') {
                $active_tramite = true;
            } elseif ($current_page == 'modalidad.php') {
                $active_modalidad = true;
            } elseif ($current_page == 'serviciosAdicionales.php') {
		$active_serviciosAdicionales = true;
            } elseif ($current_page == 'Generales.php') {
		$active_Generales = true;
            } else {
                // Por defecto, activar Lista si no estamos en ninguna de las páginas específicas
                $active_principal = true;
            }
	?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<?php
// <div class="container-fluid">
// <div class="navbar-brand">
	echo '<span style="font-style:oblique;font-size:10px;" class="text-secondary">bebal</span>';
	echo '<br><span style="font-size:8px;" class="text-white"><br>'.$PROFILE.'-'.$ID_MUNICIPIO.'</span>';
//echo '<a class="navbar-brand" href="#">Stock X</a>';
?>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item <?php if ($active_principal){echo 'active-item';}?>">
          <a class="nav-link <?php if ($active_principal){echo 'active';}?>" href="principal.php"><i class='bi bi-house-fill'></i> Lista</a>
        </li>

<?php
if ( $PROFILE=='admin' ) {
?>
<li class="nav-item <?php if ($active_usuarios){echo 'active-item';}?>"><a class="nav-link <?php if ($active_usuarios){echo 'active';}?>" href="usuarios.php"><i class='bi bi-people-fill'></i><font size="1"> Usuarios</font></a></li>
<li class="nav-item <?php if ($active_colonias){echo 'active-item';}?>"><a class="nav-link <?php if ($active_colonias){echo 'active';}?>" href="colonia.php"><i class='bi bi-pin-map-fill'></i><font size="1"> Colonias</font></a></li>
<li class="nav-item <?php if ($active_delegaciones){echo 'active-item';}?>"><a class="nav-link <?php if ($active_delegaciones){echo 'active';}?>" href="delegacion.php"><i class='bi bi-building-fill'></i><font size="1"> Delegaciones</font></a></li>
<li class="nav-item <?php if ($active_giro){echo 'active-item';}?>"><a class="nav-link <?php if ($active_giro){echo 'active';}?>" href="giro.php"><i class='bi bi-arrow-repeat'></i><font size="1"> Giro</font></a></li>

<li class="nav-item <?php if ($active_tramite){echo 'active-item';}?>"><a class="nav-link <?php if ($active_tramite){echo 'active';}?>" href="tramite.php"><i class='bi bi-file-earmark-text-fill'></i><font size="1"> Tramite</font></a></li>

<li class="nav-item <?php if ($active_modalidad){echo 'active-item';}?>"><a class="nav-link <?php if ($active_modalidad){echo 'active';}?>" href="modalidad.php"><i class='bi bi-sliders'></i><font size="1"> Modalidad</font></a></li>
<li class="nav-item <?php if ($active_serviciosAdicionales){echo 'active-item';}?>"><a class="nav-link <?php if ($active_serviciosAdicionales){echo 'active';}?>" href="serviciosAdicionales.php"><i class='bi bi-plus-circle-fill'></i><font size="1"> Serv Adicionales</font></a></li>
<li class="nav-item <?php if ($active_Generales){echo 'active-item';}?>"><a class="nav-link <?php if ($active_Generales){echo 'active';}?>" href="Generales.php"><i class='bi bi-asterisk'></i><font size="1"> Generales</font></a></li>
<?php
}

$mes_actual=date("n");
$semana_actual = date('W');
$anio=date("Y");

?>




        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-graph-up-arrow"></i><font size="1"> Reportes </font></a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="reporte1.php"><i class="bi bi-play-fill text-secondary"></i> Reporte 1</a></li>
            <li><a class="dropdown-item" href="reporte_Por_Mes.php?m=<?php echo $mes_actual;?>&y=<?php echo $anio;?>"><i class="bi bi-play-fill text-secondary"></i> Por Mes (<?php echo $mes_actual;?>)</a></li>
            <li><a class="dropdown-item" href="reporte_Por_Semana.php?w=<?php echo $semana_actual;?>&y=<?php echo $anio;?>"><i class="bi bi-play-fill text-secondary"></i> Por Semana <?php echo $semana_actual;?></a></li>
          </ul>
        </li>
      </ul>

<?php
if ( $active_principal) {
//echo '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#nuevoRegistroPrincipal" style="background-color:#AC905B;"><i class="bi bi-plus-circle me-1"></i> Nuevo Registro</button>';
}
?>

      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="http://https://www.mexcaptijuana.com" target='_blank'><i class='bi bi-envelope text-secondary'></i> Soporte</a></li>
		<li class="nav-item"><a class="nav-link" href="login.php?logout"><i class='bi bi-power text-secondary'></i> Salir</a></li>
      </ul>
<?php
//    </div>
//  </div>
echo '</nav>';
		}
	?>

<head>
<style>
.dropbtn {
  background-color: #661C32;
  color: white;
  padding: 14px;
  font-size: 12px;
  border: none;
  cursor: pointer;
}

.Mydropdown {
  position: relative;
  display: inline-block;
}

.Mydropdown-content {
  display: none;
  position: absolute;
  right: 0;
  background-color: #f9f9f9;
  min-width: 200px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.Mydropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.Mydropdown-content a:hover {background-color: #f1f1f1;}

.Mydropdown:hover .Mydropdown-content {
  display: block;
}

.Mydropdown:hover .dropbtn {
  background-color: #AC905B;
}
</style>
</head>


<?php

		if (isset($title))
		{
            // Establecer el elemento Lista como activo por defecto si no hay otra selección
            // Asegurar que solo un elemento esté activo a la vez
            $active_principal = false;
            $active_principal_temp = false;
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
            } elseif ($current_page == 'principal_temp.php') {
                $active_principal_temp = true;
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
	echo '<p style="font-style:oblique;font-size:8px;">bebal</p>';
	echo '<p style="font-size:8px;">'.$PROFILE.'-'.$ID_MUNICIPIO.'</p>';
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



        <li class="nav-item <?php if ($active_principal_temp){echo 'active-item';}?>">
          <a class="nav-link <?php if ($active_principal_temp){echo 'active';}?>" href="principal_temp.php"><font size="2"><i class='bi bi-dice-6'></i> <b>Temporal</b></font></a>
        </li>


<div class="Mydropdown" style="float:letf;">
  <button class="dropbtn"><font size="2"><i class='bi bi-card-checklist'></i> <b>Reportes</b></font></button>
  <div class="Mydropdown-content">
  <a href="reporte_registrosNuevos.php"><font size="1">Registros Nuevos Completos</font></a>
  <a href="#"><font size="1">Registros Nuevos en Proceso</font></a>
  <a href="#"><font size="1">Tramites</font></a>
  <a href="#"><font size="1">Revalidaciones</font></a>
  <a href="#"><font size="1">Permisos Vencidos</font></a>
  <a href="#"><font size="1">Impresiones</font></a>
  <a href="#"><font size="1">Cierres Temporales</font></a>
  </div>
</div>
&nbsp;



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








</ul>

<?php
if ( $active_principal) {
//echo '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#nuevoRegistroPrincipal" style="background-color:#AC905B;"><i class="bi bi-plus-circle me-1"></i> Nuevo Registro</button>';
}
?>

      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="https://www.https://www.tijuana.gob.mx/" target='_blank'><i class='bi bi-envelope text-secondary'></i> Soporte</a></li>
		<li class="nav-item"><a class="nav-link" href="login.php?logout"><i class='bi bi-power text-secondary'></i> Salir</a></li>
      </ul>
<?php
//    </div>
//  </div>
echo '</nav>';
		}
	?>

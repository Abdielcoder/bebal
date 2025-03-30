<?php

		if (isset($title))
		{
	?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
<?php
	echo '<font style="font-style:oblique;font-size: 10px;" color="white">bebal</font>';
	echo '<br><font size=1>'.$PROFILE.'-'.$ID_MUNICIPIO.'</font>';
//echo '<a class="navbar-brand" href="#">Stock X</a>';
?>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php if (isset($active_principal)){echo $active_principal;}?>"><a href="principal.php"><i class='glyphicon glyphicon-list'></i> Lista</a></li>

<?php
if ( $PROFILE=='admin' ) {
?>
<li class="<?php if (isset($active_usuarios)){echo $active_usuarios;}?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-user'></i> Usuarios</a></li>
<li class="<?php if (isset($active_colonias)){echo $active_colonias;}?>"><a href="colonias.php"><i  class='glyphicon glyphicon-list-alt'></i> Colonias</a></li>
<li class="<?php if (isset($active_delegaciones)){echo $active_delegaciones;}?>"><a href="delegacion.php"><i  class='glyphicon glyphicon-list-alt'></i> Delegaciones</a></li>
<li class="<?php if (isset($active_giro)){echo $active_giro;}?>"><a href="giro.php"><i  class='glyphicon glyphicon-list-alt'></i> Giro</a></li>
<li class="<?php if (isset($active_tramite)){echo $active_tramite;}?>"><a href="tramite.php"><i  class='glyphicon glyphicon-list-alt'></i> Tramite</a></li>
<li class="<?php if (isset($active_modalidad)){echo $active_modalidad;}?>"><a href="modalidad.php"><i  class='glyphicon glyphicon-list-alt'></i> Modalidad</a></li>
<li class="<?php if (isset($active_serviciosAdicionales)){echo $active_serviciosAdicionales;}?>"><a href="serviciosAdicionales.php"><i  class='glyphicon glyphicon-list-alt'></i> Servicios Adicionales</a></li>
<?php } else { ?>
<li class="<?php if (isset($active_usuarios)){echo $active_usuarios;}?>"><a href="#"><i  class='glyphicon glyphicon-user'></i> Usuarios</a></li>
<li class="<?php if (isset($active_colonias)){echo $active_colonias;}?>"><a href="#"><i  class='glyphicon glyphicon-list-alt'></i> Colonias</a></li>
<li class="<?php if (isset($active_delegaciones)){echo $active_delegaciones;}?>"><a href="#"><i  class='glyphicon glyphicon-list-alt'></i> Delegaciones</a></li>
<?php
}


//if (isset($active_reportes))
//echo '<li class="'.$active_reportes.'"><a href="reportes.php"><i  class="glyphicon glyphicon-cutlery"></i> Reportes</a></li>';
//else 
//echo '<li class=""><a href="reportes.php"><i  class="glyphicon glyphicon-cutlery"></i> Reportes</a></li>';

$mes_actual=date("n");
$semana_actual = date('W');
$anio=date("Y");

## https://www.w3schools.com/bootstrap/bootstrap_buttons.asp
### Colores  btn btn-primary  AZUL

echo '<li><p>';
echo '<div class="dropdown">';
echo '<button class="btn btn-basic dropdown-toggle" type="button" data-toggle="dropdown"><i  class="glyphicon glyphicon-cutlery"></i>&nbsp; &nbsp;Reportes&nbsp; &nbsp;<span class="caret"></span></button>';
echo '<ul class="dropdown-menu">';
echo '<li><a href="reporte1.php"><i class="glyphicon glyphicon-play"></i>&nbsp; &nbsp;Reporte 1</a></li>';
echo '<li><a href="reporte_Por_Mes.php?m='.$mes_actual.'&y='.$anio.'"><i class="glyphicon glyphicon-play"></i>&nbsp; &nbsp;Por Mes ('.$mes_actual.')</a></li>';
echo '<li><a href="reporte_Por_Semana.php?w='.$semana_actual.'&y='.$anio.'"><i class="glyphicon glyphicon-play"></i>&nbsp; &nbsp;Por Semana '.$semana_actual.'</a></li>';
echo '</ul>';
echo '</div>';
echo '</li>';

?>
       </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="http://AppstravagenceSystems.com/contacto/" target='_blank'><i class='glyphicon glyphicon-envelope'></i> Soporte</a></li>
		<li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>

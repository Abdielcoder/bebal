<?php
include('ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado


error_reporting(0);
session_start();

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	// Eliminar la inclusión del modal de recibo que ya no usamos
	include("modal/revisar_pago.php");
	include("modal/eliminar_registro.php");
	include("modal/efectuar_inspeccion.php");

	$active_principal="active";
	$active_clientes="";
	$active_usuarios="";	
	$active_reportes="";


	$title="bebal";
	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>


    <?php include("head.php");?>
    <style>
        /* Estilos para hacer la interfaz muy compacta y visible en una sola pantalla */
        body {
            font-size: 0.9rem;
        }
        
        .container {
            max-width: 1400px;
            padding: 0 10px;
        }
        
        .encabezado-programa {
            background-color: var(--color-tertiary-light);
            border-radius: 4px;
            padding: 5px 10px;
            margin-bottom: 10px;
            text-align: center;
            border-left: 3px solid var(--color-primary);
            border-right: 3px solid var(--color-primary);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .encabezado-programa h6 {
            font-size: 0.8rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .seccion-datos {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            margin-bottom: 8px;
            overflow: hidden;
            height: 100%;
        }
        
        .seccion-datos .encabezado {
            background-color: #AC905B;
            color: white;
            padding: 4px 8px;
            text-align: center;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        
        .seccion-datos .encabezado h4 {
            margin: 0;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .seccion-datos .contenido {
            padding: 6px 10px;
        }
        
        .fila-datos {
            margin-bottom: 4px;
        }
        
        .etiqueta {
            background-color: #f4f0ec;
            font-weight: 600;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 0.8rem;
            margin-bottom: 2px;
        }
        
        .valor {
            padding: 3px 6px;
            font-size: 0.8rem;
            background-color: #f9f9f9;
            border-radius: 3px;
        }
        
        .valor-destacado {
            font-weight: 600;
        }
        
        .sidebar {
            position: sticky;
            top: 10px;
        }
        
        .area-botones {
            margin-top: 0;
            margin-bottom: 8px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .area-botones .btn {
            padding: 5px 8px;
            font-size: 0.8rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-primary);
            border-color: var(--color-primary-dark);
            color: white;
        }
        
        .area-botones .btn:hover {
            background-color: var(--color-primary-dark);
            border-color: var(--color-primary-dark);
        }
        
        .area-botones .btn i {
            margin-right: 5px;
            font-size: 0.9rem;
        }
        
        .estatus-seccion {
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 8px;
        }
        
        .foto-establecimiento {
            width: 100%;
            height: auto;
            max-height: 120px;
            object-fit: cover;
            border-radius: 3px;
            margin-bottom: 8px;
            border: 1px solid #ddd;
        }
        
        .info-bloque {
            margin-bottom: 8px;
        }
        
        .estatus-badge {
            background-color: #997a8d;
            color: white;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 2px;
        }
        
        .mt-compact {
            margin-top: 5px;
        }
        
        .mb-compact {
            margin-bottom: 5px;
        }
        
        .compact-row [class*="col-"] {
            padding-right: 4px;
            padding-left: 4px;
        }
        
        .alert-compact {
            padding: 3px 6px;
            margin-bottom: 5px;
            font-size: 0.75rem;
        }
        
        hr {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        
        @media (max-width: 768px) {
            .etiqueta, .valor {
                padding: 3px 5px;
                font-size: 0.75rem;
            }
            
            .sidebar {
                position: static;
                margin-top: 10px;
            }
        }
    </style>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
<div class="container">
<?php

#################################
if (isset($_GET['id'])) {
$IDPRINCIPAL=$_GET['id'];
$page=$_GET['page'];
} else {
$IDPRINCIPAL=$_POST['IDPRINCIPAL'];
$page=$_POST['page'];
}
#################################
#################################


$sqlPrincipal="SELECT * FROM principal WHERE id=".$IDPRINCIPAL;
$row = mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));


					$principal_id=$row['id'];
					$folio=$row['folio'];

$nombre_comercial_establecimiento=$row['nombre_comercial_establecimiento'];
$calle_establecimiento=$row['calle_establecimiento'];
$entre_calles_establecimiento=$row['entre_calles_establecimiento'];
$numero_establecimiento=$row['numero_establecimiento'];
$numerointerno_local_establecimiento=$row['numerointerno_local_establecimiento'];
$cp_establecimiento=$row['cp_establecimiento'];
$nombre_persona_fisicamoral_solicitante=$row['nombre_persona_fisicamoral_solicitante'];
$nombre_representante_legal_solicitante=$row['nombre_representante_legal_solicitante'];
$domicilio_solicitante=$row['domicilio_solicitante'];
$email_solicitante=$row['email_solicitante'];
$telefono_solicitante=$row['telefono_solicitante'];

$id_giro=$row['giro'];
$id_modalidad_graduacion_alcoholica=$row['modalidad_graduacion_alcoholica'];


	$numero_permiso=$row['numero_permiso'];
	$estatus=$row['estatus'];
	$operacion=$row['operacion'];

	$observaciones=$row['observaciones'];
	$fecha_alta=$row['fecha_alta'];
	$id_municipio=$row['id_municipio'];
	$delegacion_id=$row['id_delegacion'];
	$colonia_id=$row['id_colonia'];
	$foto=$row['foto'];

##
$sql_giro="SELECT descripcion_giro FROM giro WHERE id=".$id_giro;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
##
$sql_modalidad_graduacion_alcoholica="SELECT descripcion_modalidad_graduacion_alcoholica FROM modalidad_graduacion_alcoholica WHERE id=".$id_modalidad_graduacion_alcoholica;
$result_modalidad_graduacion_alcoholica = mysqli_query($con,$sql_modalidad_graduacion_alcoholica);
$row_modalidad_graduacion_alcoholica = mysqli_fetch_assoc($result_modalidad_graduacion_alcoholica);
$MODALIDAD_GA=$row_modalidad_graduacion_alcoholica['descripcion_modalidad_graduacion_alcoholica'];
##
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipio;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIO=$row_municipio['municipio'];
##
$sql_delegacion="SELECT delegacion FROM delegacion WHERE id=".$delegacion_id;
$result_delegacion = mysqli_query($con,$sql_delegacion);
$row_delegacion = mysqli_fetch_assoc($result_delegacion);
$DELEGACION=$row_delegacion['delegacion'];
##
$sql_colonia="SELECT colonia FROM colonias WHERE id=".$colonia_id;
$result_colonia = mysqli_query($con,$sql_colonia);
$row_colonia = mysqli_fetch_assoc($result_colonia);
$COLONIA=$row_colonia['colonia'];
##
?>

    <div class="mt-3">
        <!-- Encabezado del programa -->
        <div class="encabezado-programa">
            <h6>PROGRAMA DE IDENTIFICACIÓN Y REGULARIZACIÓN DE ESTABLECIMIENTOS QUE EXPIDEN Y VENDEN BEBIDAS CON CONTENIDO ALCOHÓLICO</h6>
        </div>
        
        <div class="row compact-row g-2">
            <!-- Columna principal con datos -->
            <div class="col-lg-8">
                <div class="row compact-row g-2">
                    <!-- Datos del establecimiento -->
                    <div class="col-lg-12">
                        <div class="seccion-datos">
                            <div class="encabezado">
                                <h4>Datos del Establecimiento</h4>
                            </div>
                            <div class="contenido">
                                <div class="row compact-row">
                                    <div class="col-md-3 col-6">
                                        <div class="etiqueta">Folio</div>
                                        <div class="valor"><?php echo $folio; ?></div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="etiqueta">Giro</div>
                                        <div class="valor"><?php echo $GIRO; ?></div>
                                    </div>
                                    <div class="col-md-5 col-12 mt-md-0 mt-1">
                                        <div class="etiqueta">Modalidad Graduación Alcohólica</div>
                                        <div class="valor"><?php echo $MODALIDAD_GA; ?></div>
                                    </div>
                                </div>
                                
                                <div class="row compact-row">
                                    <div class="col-12">
                                        <div class="etiqueta">Nombre Comercial</div>
                                        <div class="valor valor-destacado"><?php echo $nombre_comercial_establecimiento; ?></div>
                                    </div>
                                </div>
                                
                                <div class="row compact-row">
                                    <div class="col-md-9 col-12">
                                        <div class="etiqueta">Domicilio</div>
                                        <div class="valor">
                                            <?php echo $calle_establecimiento; ?> #<?php echo $numero_establecimiento; ?> 
                                            <?php if (!empty($numerointerno_local_establecimiento)) echo $numerointerno_local_establecimiento; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 mt-md-0 mt-1">
                                        <div class="etiqueta">CP</div>
                                        <div class="valor"><?php echo $cp_establecimiento; ?></div>
                                    </div>
                                </div>
                                
                                <div class="row compact-row">
                                    <div class="col-md-4 col-12">
                                        <div class="etiqueta">Colonia</div>
                                        <div class="valor"><?php echo $COLONIA; ?></div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-md-0 mt-1">
                                        <div class="etiqueta">Delegación</div>
                                        <div class="valor"><?php echo $DELEGACION; ?></div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-md-0 mt-1">
                                        <div class="etiqueta">Ciudad</div>
                                        <div class="valor"><?php echo $MUNICIPIO; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Datos del solicitante -->
                    <div class="col-md-6">
                        <div class="seccion-datos">
                            <div class="encabezado">
                                <h4>Datos del Solicitante</h4>
                            </div>
                            <div class="contenido">
                                <div class="row compact-row">
                                    <div class="col-12">
                                        <div class="etiqueta">Persona Física/Moral</div>
                                        <div class="valor"><?php echo $nombre_persona_fisicamoral_solicitante; ?></div>
                                    </div>
                                </div>
                                
                                <div class="row compact-row">
                                    <div class="col-12">
                                        <div class="etiqueta">Representante Legal</div>
                                        <div class="valor"><?php echo $nombre_representante_legal_solicitante; ?></div>
                                    </div>
                                </div>
                                
                                <div class="row compact-row">
                                    <div class="col-12">
                                        <div class="etiqueta">Domicilio</div>
                                        <div class="valor"><?php echo $domicilio_solicitante; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contacto -->
                    <div class="col-md-6">
                        <div class="seccion-datos">
                            <div class="encabezado">
                                <h4>Información de Contacto</h4>
                            </div>
                            <div class="contenido">
                                <div class="row compact-row">
                                    <div class="col-12">
                                        <div class="etiqueta">Email</div>
                                        <div class="valor"><?php echo $email_solicitante; ?></div>
                                    </div>
                                </div>
                                
                                <div class="row compact-row">
                                    <div class="col-12">
                                        <div class="etiqueta">Teléfono</div>
                                        <div class="valor"><?php echo $telefono_solicitante; ?></div>
                                    </div>
                                </div>
                                
                                <?php if (!empty($observaciones)): ?>
                                <div class="row compact-row">
                                    <div class="col-12">
                                        <div class="etiqueta">Observaciones</div>
                                        <div class="valor small"><?php echo $observaciones; ?></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Columna lateral con acciones y estado -->
            <div class="col-lg-4">
                <div class="row compact-row g-2">
                    <!-- Sección de estatus -->
                    <div class="col-md-12">
                        <div class="seccion-datos">
                            <div class="encabezado">
                                <h4>Estado del Registro</h4>
                            </div>
                            <div class="contenido">
                                <div class="row compact-row">
                                    <div class="col-4">
                                        <div class="estatus-badge">Estatus</div>
                                    </div>
                                    <div class="col-8">
                                        <div class="valor"><?php echo $estatus; ?></div>
                                    </div>
                                </div>
                                <div class="row compact-row">
                                    <div class="col-4">
                                        <div class="estatus-badge">Operación</div>
                                    </div>
                                    <div class="col-8">
                                        <div class="valor"><?php echo $operacion; ?></div>
                                    </div>
                                </div>
                                <div class="row compact-row">
                                    <div class="col-4">
                                        <div class="estatus-badge">Fecha Alta</div>
                                    </div>
                                    <div class="col-8">
                                        <div class="valor"><?php echo $fecha_alta; ?></div>
                                    </div>
                                </div>
                                <?php if (!empty($numero_permiso)): ?>
                                <div class="row compact-row">
                                    <div class="col-4">
                                        <div class="estatus-badge">Permiso</div>
                                    </div>
                                    <div class="col-8">
                                        <div class="valor"><?php echo $numero_permiso; ?></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="col-12">
                        <div class="area-botones">
                            <div class="row compact-row g-1">
                                <div class="col-6">
                                    <a href="principal.php?pagina=<?php echo $page; ?>" class="btn w-100">
                                        <i class="bi bi-arrow-left"></i> Regresar
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="generar_pdf_html.php?id=<?php echo $IDPRINCIPAL; ?>" target="_blank" class="btn w-100">
                                        <i class="bi bi-file-earmark-pdf"></i> Generar Recibo
                                    </a>
                                </div>
                                
                                <?php if ($estatus=='Generar Recibo Inspeccion') { ?>
                                <div class="col-6">
                                    <a href="#revisarPago" data-toggle="modal" data-nombre_comercial_establecimiento="<?php echo $nombre_comercial_establecimiento; ?>" data-folio="<?php echo $folio; ?>" data-idprincipal="<?php echo $IDPRINCIPAL; ?>" data-pagina="<?php echo $page; ?>" class="btn w-100" title="Revisar Pago">
                                        <i class="bi bi-check-circle"></i> Revisar Pago
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#EliminarRegistro" data-toggle="modal" data-nombre_comercial_establecimiento="<?php echo $nombre_comercial_establecimiento; ?>" data-folio="<?php echo $folio; ?>" data-idprincipal="<?php echo $IDPRINCIPAL; ?>" data-pagina="<?php echo $page; ?>" class="btn w-100" title="Eliminar Registro">
                                        <i class="bi bi-trash"></i> Eliminar Registro
                                    </a>
                                </div>
                                <?php } else if ($estatus=='Efectuar Inspeccion') { ?>
                                <div class="col-12">
                                    <a href="#EfectuarInspeccion" data-toggle="modal" data-nombre_comercial_establecimiento="<?php echo $nombre_comercial_establecimiento; ?>" data-folio="<?php echo $folio; ?>" data-idprincipal="<?php echo $IDPRINCIPAL; ?>" data-pagina="<?php echo $page; ?>" class="btn w-100" title="Registrar Inspección">
                                        <i class="bi bi-clipboard-check"></i> Registrar Inspección
                                    </a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
		 
<hr>
<?php include("footer.php"); ?>

<script>
$( "#registro_guardar_pago" ).submit(function( event ) {
  $('#Button_registro_guardar_pago').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/registro_guardar_pago.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxPago").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxPago").html(datos);
			$('#Button_registro_guardar_pago').attr("disabled", true);
			window.setTimeout(function() {
				$(".alert").fadeTo(150, 0).slideUp(150, function(){
				$(this).remove();});
				location.replace('principal.php');
			}, 4000);

		  }
	});
  event.preventDefault();
});

$( "#registro_guardar_inspeccion" ).submit(function( event ) {
  $('#Button_registro_guardar_inspeccion').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/registro_guardar_inspeccion.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxInspeccion").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxInspeccion").html(datos);
			$('#Button_registro_guardar_inspeccion').attr("disabled", true);
			window.setTimeout(function() {
				$(".alert").fadeTo(150, 0).slideUp(150, function(){
				$(this).remove();});
				location.replace('principal.php');
			}, 4000);

		  }
	});
  event.preventDefault();
});

// Inicializar eventos para los botones de modal
$(document).ready(function() {
    $('[data-toggle="modal"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        
        // Extraer los datos de los atributos data
        var nombreComercial = $(this).data('nombre_comercial_establecimiento');
        var folio = $(this).data('folio');
        var idPrincipal = $(this).data('idprincipal');
        var pagina = $(this).data('pagina');
        
        // Abrir el modal utilizando Bootstrap 5
        var myModal = new bootstrap.Modal(document.querySelector(target));
        
        // Transferir los datos al modal antes de mostrarlo
        $(target + ' #mod_nombre_comercial_establecimiento').val(nombreComercial);
        $(target + ' #mod_folio').val(folio);
        $(target + ' #mod_idprincipal, ' + target + ' #IDPRINCIPAL').val(idPrincipal);
        $(target + ' #mod_pagina, ' + target + ' #pagina').val(pagina);
        
        // Mostrar el modal
        myModal.show();
    });
});
</script>
</body>
</html>



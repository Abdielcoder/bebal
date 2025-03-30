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
        .encabezado-programa {
            background-color: var(--color-tertiary-light);
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 25px;
            text-align: center;
            border-left: 5px solid var(--color-primary);
            border-right: 5px solid var(--color-primary);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }
        
        .seccion-datos {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            overflow: hidden;
        }
        
        .seccion-datos .encabezado {
            background-color: #AC905B;
            color: white;
            padding: 10px 15px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        
        .seccion-datos .encabezado h4 {
            margin: 0;
            font-weight: 600;
        }
        
        .seccion-datos .contenido {
            padding: 20px;
        }
        
        .fila-datos {
            margin-bottom: 12px;
        }
        
        .etiqueta {
            background-color: #f4f0ec;
            font-weight: 600;
            padding: 10px 15px;
            border-radius: 4px;
        }
        
        .valor {
            padding: 10px 15px;
        }
        
        .valor-destacado {
            font-weight: 600;
        }
        
        .area-botones {
            margin: 25px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .nota-legal {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            font-size: 0.85rem;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
        
        .estatus-seccion {
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 25px;
        }
        
        @media (max-width: 768px) {
            .etiqueta, .valor {
                padding: 8px 10px;
            }
            
            .area-botones {
                flex-direction: column;
            }
            
            .area-botones .btn {
                width: 100%;
                margin-bottom: 8px;
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

    <div class="mt-4">
        <!-- Encabezado del programa -->
        <div class="encabezado-programa">
            <h6 class="mb-0">PROGRAMA DE IDENTIFICACIÓN, EMPADRONAMIENTO, REGULARIZACIÓN Y REVALIDACIÓN DE ESTABLECIMIENTOS QUE EXPIDEN Y VENDEN AL PÚBLICO, EN ENVASE CERRADO Y ABIERTO, BEBIDAS CON CONTENIDO ALCOHÓLICO</h6>
        </div>
        
        <!-- Sección de datos del establecimiento -->
        <div class="seccion-datos">
            <div class="encabezado">
                <h4>Datos del Establecimiento</h4>
            </div>
            <div class="contenido">
                <div class="row fila-datos">
                    <div class="col-md-2 col-6">
                        <div class="etiqueta">Folio</div>
                        <div class="valor"><?php echo $folio; ?></div>
                    </div>
                    <div class="col-md-5 col-6">
                        <div class="etiqueta">Giro</div>
                        <div class="valor"><?php echo $GIRO; ?></div>
                    </div>
                    <div class="col-md-5 col-12 mt-md-0 mt-3">
                        <div class="etiqueta">Modalidad Graduación Alcohólica</div>
                        <div class="valor"><?php echo $MODALIDAD_GA; ?></div>
                    </div>
                </div>
                
                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Nombre Comercial</div>
                        <div class="valor valor-destacado"><?php echo $nombre_comercial_establecimiento; ?></div>
                    </div>
                </div>
                
                <div class="row fila-datos">
                    <div class="col-md-9 col-12">
                        <div class="etiqueta">Domicilio</div>
                        <div class="valor">
                            <?php echo $calle_establecimiento; ?> #<?php echo $numero_establecimiento; ?> 
                            <?php if (!empty($numerointerno_local_establecimiento)) echo $numerointerno_local_establecimiento; ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 mt-md-0 mt-3">
                        <div class="etiqueta">CP</div>
                        <div class="valor"><?php echo $cp_establecimiento; ?></div>
                    </div>
                </div>
                
                <div class="row fila-datos">
                    <div class="col-md-4 col-12">
                        <div class="etiqueta">Colonia</div>
                        <div class="valor"><?php echo $COLONIA; ?></div>
                    </div>
                    <div class="col-md-4 col-12 mt-md-0 mt-3">
                        <div class="etiqueta">Delegación</div>
                        <div class="valor"><?php echo $DELEGACION; ?></div>
                    </div>
                    <div class="col-md-4 col-12 mt-md-0 mt-3">
                        <div class="etiqueta">Ciudad</div>
                        <div class="valor"><?php echo $MUNICIPIO; ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sección de datos del solicitante -->
        <div class="seccion-datos">
            <div class="encabezado">
                <h4>Datos del Solicitante</h4>
            </div>
            <div class="contenido">
                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Persona Física/Moral</div>
                        <div class="valor"><?php echo $nombre_persona_fisicamoral_solicitante; ?></div>
                    </div>
                </div>
                
                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Representante Legal</div>
                        <div class="valor"><?php echo $nombre_representante_legal_solicitante; ?></div>
                    </div>
                </div>
                
                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Domicilio</div>
                        <div class="valor"><?php echo $domicilio_solicitante; ?></div>
                    </div>
                </div>
                
                <div class="row fila-datos">
                    <div class="col-md-6 col-12">
                        <div class="etiqueta">Email</div>
                        <div class="valor"><?php echo $email_solicitante; ?></div>
                    </div>
                    <div class="col-md-6 col-12 mt-md-0 mt-3">
                        <div class="etiqueta">Teléfono</div>
                        <div class="valor"><?php echo $telefono_solicitante; ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sección de estatus -->
        <div class="estatus-seccion">
            <div class="row p-3">
                <div class="col-md-4 col-12 mb-md-0 mb-3">
                    <div class="etiqueta" style="background-color: #997a8d; color: white;">Estatus</div>
                    <div class="valor"><?php echo $estatus; ?></div>
                </div>
                <div class="col-md-4 col-12 mb-md-0 mb-3">
                    <div class="etiqueta" style="background-color: #997a8d; color: white;">Operación</div>
                    <div class="valor"><?php echo $operacion; ?></div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="etiqueta" style="background-color: #997a8d; color: white;">Fecha Alta</div>
                    <div class="valor"><?php echo $fecha_alta; ?></div>
                </div>
            </div>
        </div>
        
        <!-- Nota legal -->
        <div class="nota-legal">
            <p class="mb-0">
                Mediante Acuerdo del Cabildo de fecha once de diciembre del dos mil veinticuatro en el punto de acuerdo número VI.3, se autoriza a la Secretaría de Gobierno Municipal para que instrumente el programa de identificación, empadronamiento y regularización de la situación jurídica y administrativa de las personas físicas o morales que se dediquen a la expedición y venta, en envase cerrado y abierto, de bebidas con contenido alcohólico, a fin de que se actualice su situación jurídica. Para cumplir con los objetivos del programa, por medio de la presente, se autoriza la recepción de documentos del solicitante para revisión de su expediente y posterior determinación. Este documento no implica que se vaya a expedir un permiso nuevo y/o autorizar la regularización de uno previo, situación que se le informa al solicitante y acepta de conformidad, firmando al calce.
            </p>
        </div>
        
        <!-- Botones de acción -->
        <div class="area-botones">
            <a href="principal.php?pagina=<?php echo $page; ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>
            
            <a href="generar_pdf_html.php?id=<?php echo $IDPRINCIPAL; ?>" target="_blank" class="btn btn-success">
                <i class="bi bi-file-earmark-pdf"></i> Generar Recibo
            </a>
            
            <?php if ($estatus=='Generar Recibo Inspeccion') { ?>
                <a href="#revisarPago" data-toggle="modal" data-nombre_comercial_establecimiento="<?php echo $nombre_comercial_establecimiento; ?>" data-folio="<?php echo $folio; ?>" data-idprincipal="<?php echo $IDPRINCIPAL; ?>" data-pagina="<?php echo $page; ?>" class="btn btn-info" title="Revisar Pago">
                    <i class="bi bi-check-circle"></i> Revisar Pago
                </a>
                
                <a href="#EliminarRegistro" data-toggle="modal" data-nombre_comercial_establecimiento="<?php echo $nombre_comercial_establecimiento; ?>" data-folio="<?php echo $folio; ?>" data-idprincipal="<?php echo $IDPRINCIPAL; ?>" data-pagina="<?php echo $page; ?>" class="btn btn-danger" title="Eliminar Registro">
                    <i class="bi bi-trash"></i> Eliminar Registro
                </a>
            <?php } else if ($estatus=='Efectuar Inspeccion') { ?>
                <a href="#EfectuarInspeccion" data-toggle="modal" data-nombre_comercial_establecimiento="<?php echo $nombre_comercial_establecimiento; ?>" data-folio="<?php echo $folio; ?>" data-idprincipal="<?php echo $IDPRINCIPAL; ?>" data-pagina="<?php echo $page; ?>" class="btn btn-info" title="Registrar Inspección">
                    <i class="bi bi-check-circle"></i> Registrar Inspección
                </a>
            <?php } ?>
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



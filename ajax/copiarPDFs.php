<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['IDPRINCIPAL'])) {
           $errors[] = "Campo vacío";
		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");

$IDPRINCIPAL=intval($_POST['IDPRINCIPAL']);
$id_proceso_tramites_anterior=intval($_POST['id_proceso_tramites_anterior']);
$id_proceso_tramites_actual=intval($_POST['id_proceso_tramites_actual']);

$dirPDFs="/var/www/html/bebal_docs/";

$arreglo0 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM proceso_tramites WHERE id=$id_proceso_tramites_anterior"));
$pdf1_ant=$arreglo0['docs_pdf1'];
$pdf2_ant=$arreglo0['docs_pdf2'];
$pdf3_ant=$arreglo0['docs_pdf3'];
$pdf4_ant=$arreglo0['docs_pdf4'];

##docs_pdf1=108-171-c1.pdf
##estatus_docs_pdf1=OK

$pdf_c1=$IDPRINCIPAL.'-'.$id_proceso_tramites_actual.'-c1.pdf';
$pdf_c2=$IDPRINCIPAL.'-'.$id_proceso_tramites_actual.'-c2.pdf';
$pdf_c3=$IDPRINCIPAL.'-'.$id_proceso_tramites_actual.'-c3.pdf';
$pdf_c4=$IDPRINCIPAL.'-'.$id_proceso_tramites_actual.'-c4.pdf';

$Kuery_Update="UPDATE proceso_tramites SET 
docs_pdf1='$pdf_c1',
estatus_docs_pdf1='OK',
docs_pdf2='$pdf_c2',
estatus_docs_pdf2='OK',
docs_pdf3='$pdf_c3',
estatus_docs_pdf3='OK',
docs_pdf4='$pdf_c4',
estatus_docs_pdf4='OK'
WHERE id=$id_proceso_tramites_actual";

$result10 = mysqli_query($con,$Kuery_Update);

##
copy($dirPDFs.$pdf1_ant, $dirPDFs.$pdf_c1);
copy($dirPDFs.$pdf2_ant, $dirPDFs.$pdf_c2);
copy($dirPDFs.$pdf3_ant, $dirPDFs.$pdf_c3);
copy($dirPDFs.$pdf4_ant, $dirPDFs.$pdf_c4);
###
mysqli_close($con);



			if ($result10) {
				$messages[] = "Se Copiaron  los PDFs Correctamente";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
	##} else {
	##		$errors []= "Error desconocido.";
	}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>

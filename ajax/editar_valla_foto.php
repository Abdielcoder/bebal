<?php

function superscaleimage($source,$dest,$maxancho,$maxalto,$quality) {

		/* Check for the image's exisitance */
        if (!file_exists($source)) {
            // echo 'File does not exist!';
            return FALSE;
        } else {
            $size = getimagesize($source); // Get the image dimensions and mime type
          	$ratio = ($size[0] / $size[1]);
			
		if (($size[0]<$maxancho) && ($size[1]<$maxalto)) {
			//echo "Imagen muy chica NO SCALING";
			$maxancho=$size[0];
			$maxalto=$size[0];
			}
		
	if ((($maxancho*$size[1])/$size[0])<$maxalto) //DEBE ESCALAR POR EL ALTO.
	//if (((500*900)/1000)>345) //DEBE ESCALAR POR EL ALTO.
		{
		//echo "<br>DEBE ESCALAR POR EL ALTO.";
		$newancho=($maxalto*$size[0])/$size[1];
		$newalto=$maxalto;
		$origenx=($newancho-$maxancho)/2;;
		$origeny=0;
		
		} else {

		//echo "<br>DEBE ESCALAR POR EL ANCHO.";
		$newancho=$maxancho;
		$newalto=($maxancho*$size[1])/$size[0];
		$origenx=0;
		$origeny=($newalto-$maxalto)/2;
		
		// $origenx=($size[0]-$size[1])/2;
		// $origeny=0;
		// DEBE ESCALAR POR EL ANCHO;
		}
		}
			
       $resize = imagecreatetruecolor($newancho, $newalto); // Create a blank image

		$immarcadeagua="imagenes/marcadeagua.png";
       $im = imagecreatefromjpeg($source);
       imagecopyresampled($resize, $im, 0, 0, 0, 0, $newancho, $newalto, $size[0], $size[1]); // Resample the original JPEG
				
	$resize2 = imagecreatetruecolor($maxancho, $maxalto);
				// $origeny=(280-100)/2;
	imagecopyresampled($resize2, $resize, 0, 0, $origenx, $origeny, $maxancho, $maxalto, $maxancho, $maxalto); // Resample the original JPEG
				
				// imagecopyresampled($resize2, $resize, 0, 0, $origenx, $origeny, $newancho, $newalto, $size[0], $size[1]); // Resample the original JPEG
				// Le inserta la marca de agua
				/*
				if (imagesx($resize)<246) $watermark=imagecreatefrompng("img/marcadeagua140.png");
					else $watermark=imagecreatefrompng("img/marcadeagua.png");

				imagelogo($resize, $watermark, imagesx($resize), imagesy($resize), imagesx($watermark), imagesy($watermark), 'bottom');
				*/
				
		
				
		ob_start();
// CHANG
##imagejpeg($resize2,$dest, $quality); // Output the new JPEG
                imagejpeg($resize2,$dest, $quality); // Output the new JPEG
               $image_buffer = ob_get_contents();
               ob_end_clean();
                //Create temporary file and write to it

// CHANG                $fp = fopen($dest,'w');
// CHANG                fwrite($fp, $image_buffer);
// CHANG                rewind($fp);

                imagedestroy($resize);
	       imagedestroy($resize2);

}

echo '<script>alert("Aqui estoy ");</script>';


	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/

	if (isset($_POST['id'])) {
	$ID=$_POST['id'];
        $filename=$ID.'.jpg';

	if ($_FILES["imagenFile"]['type']!='image/jpeg') {
	  $messages[]="La foto debe estar en formato jpg";
	}
	else if (($size=getimagesize($_FILES["imagenFile"]['tmp_name']))==NULL) {
	  $errors[]="Error el archivo es NULL";
	}
	##else if (($size[0]<640) OR ($size[1]<480)) {
	   ##$messages[]="Imagen con poca resolución. Imagen actual: ".$size[0]."x".$size[1]."px. Mínimo 640x480px";
	else if (($size[0]<200) OR ($size[1]<300)) {
	   $messages[]="Imagen con poca resolución. Imagen actual: ".$size[0]."x".$size[1]."px. Mínimo 200x300px";
	} else  {
	require_once ("../config/db.php");
	$destino= '../../'.FOTOSORIGINALES;
	##$destino= '../../stockx_images/originales/';
	$destinoMedia= '../../'.FOTOSMEDIAS;
	$destinoThumb= '../../'.FOTOSTHUMB;
	##$destinoMedia= '../../stockx_images/medias/';
	if (!move_uploaded_file($_FILES["imagenFile"]['tmp_name'],$destino.$filename)) 
         $errors[]=$destino.$filename."Error al subir la Imagen";
	else {	

		 superscaleimage($destino.$filename,$destinoMedia.$filename,ANCHOMEDIO,ALTOMEDIO,95);
		 superscaleimage($destino.$filename,$destinoThumb.$filename,ANCHOTHUMB,ALTOTHUMB,95);

	
	//$IMAGEN=$_FILES['imagenFile']['name'];

		/* Connect To Database*/
		require_once ("../config/conexion.php");
		$sql="UPDATE vallas SET foto='".$filename."' WHERE id=".$ID;
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "la Imagen del Producto ha sido actualizado satisfactoriamente.";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}

	}
	}


		} else {
		$errors []= "Error desconocido.";
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
						
			echo '</div>';
			
			}
			if (isset($messages)){
				
			?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>¡Bien hecho!</strong>
				<?php
				foreach ($messages as $message) {
					echo '<h2>'.$message.'</h2>';
				}
			
				echo '</div>';
echo '<script>';
//echo 'setTimeout(function () {';
echo 'location.assign("../vallas.php");';
//echo '}, 3000);';
echo '</script>';
	
			}

?>

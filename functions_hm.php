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
##imagejpeg($resize2,, $quality); // Output the new JPEG
                imagejpeg($resize2,$dest, $quality); // Output the new JPEG
               $image_buffer = ob_get_contents();
               ob_end_clean();
                //Create temporary file and write to it

// CHANG                $fp = fopen($dest,'w');
// CHANG                fwrite($fp, $image_buffer);
// CHANG                rewind($fp);

// CHANG                imagedestroy($resize);
// CHANG                imagedestroy($resize2);
        
    }

function scaleimagesquare($source,$dest,$maxancho,$maxalto,$quality)
    {
		/* Check for the image's exisitance */
		if (!file_exists($source))
        {
            echo 'File does not exist!';
            return FALSE;
        }
        else
        {
            $size = getimagesize($source); // Get the image dimensions and mime type
          	$ratio = ($size[0] / $size[1]);
			
		if (($size[0]<$maxancho) && ($size[1]<$maxalto))
			{
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
		$origenx=($size[0]-$size[1])/2;
		$origeny=0;
		}
		else
		{
		//echo "<br>DEBE ESCALAR POR EL ANCHO.";
		$newancho=$maxancho;
		$newalto=($maxancho*$size[1])/$size[0];
		$origenx=0;
		$origeny=($size[1]-$size[0])/2;
		// DEBE ESCALAR POR EL ANCHO;
		}
		}
			
			
			
            $resize = imagecreatetruecolor($maxalto,$maxancho); // Create a blank image

			
            /* Check quality option. If quality is greater than 100, return error */

             //   header('Content-Type: '.$size['mime']); // Set the mime type for the image
                $im = imagecreatefromjpeg($source);
                
                imagecopyresampled($resize, $im, 0, 0, $origenx, $origeny, $newancho, $newalto, $size[0], $size[1]); // Resample the original JPEG
        //        imagejpeg($resize, '', $quality); // Output the new JPEG

                ob_start();
                imagejpeg($resize,'', $quality); // Output the new JPEG
                $image_buffer = ob_get_contents();
                ob_end_clean();
                //Create temporary file and write to it

                $fp = fopen($dest,'w');
                fwrite($fp, $image_buffer);
                rewind($fp);

                imagedestroy($im);
        
    }

function eliminar_archivo_foto($idp,$idf) {
	if (file_exists(FOTOSORIGINALES.'/'.$idp.'-'.$idf.'.jpg')) unlink(FOTOSORIGINALES.'/'.$idp.'-'.$idf.'.jpg');
	if (file_exists(FOTOSMEDIAS    .'/'.$idp.'-'.$idf.'.jpg')) unlink(FOTOSMEDIAS    .'/'.$idp.'-'.$idf.'.jpg');
	if (file_exists(FOTOSTHUMB     .'/'.$idp.'-'.$idf.'.jpg')) unlink(FOTOSTHUMB     .'/'.$idp.'-'.$idf.'.jpg');
}

#########################

?>

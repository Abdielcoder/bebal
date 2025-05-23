<!DOCTYPE html>
<html>  
<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
function getPredial(forma) {
var val=forma.referencia.value;
$.ajax({
type: "POST",
url: "ws-Predial.php",
data:'referencia='+val,
//async : false,
  success: function(data){
  //alert('success'+data);
  var xmlDoc = data;
  var propietarioX = xmlDoc.documentElement.getElementsByTagName("propietario")[0];
  var propietario = propietarioX.childNodes[0];
  var direccionX = xmlDoc.documentElement.getElementsByTagName("direccion")[0];
  var direccion = direccionX.childNodes[0];
  var CuentaX = xmlDoc.documentElement.getElementsByTagName("Cuenta")[0];
  var Cuenta = CuentaX.childNodes[0];
  var MensajeX = xmlDoc.documentElement.getElementsByTagName("Mensaje")[0];
  var Mensaje = MensajeX.childNodes[0];
  var AdeudoX = xmlDoc.documentElement.getElementsByTagName("Adeudo")[0];
  var Adeudo = AdeudoX.childNodes[0];

  //alert('Propietario: '+propietario.nodeValue+', Direccion: '+direccion.nodeValue);
  //alert('Clave Catastral: '+Cuenta.nodeValue+', Adeudo: '+Mensaje.nodeValue+' $'+Adeudo.nodeValue);

  document.getElementById("propietario").innerHTML = propietario.nodeValue; 
  document.getElementById("direccion").innerHTML = direccion.nodeValue; 
  document.getElementById("Cuenta").innerHTML = Cuenta.nodeValue; 
  document.getElementById("Mensaje").innerHTML = Mensaje.nodeValue; 
  document.getElementById("Adeudo").innerHTML = Adeudo.nodeValue; 
  },
  timeout: 10000,
  error: function(){
    alert('failure');
  }
});
}
</script>

<form name='predialForma'>
Clave Catastral (referencia): <input type="text" name="referencia"><br>

<?php
//echo '<button onclick="getPredial(predialForma)">Submit</button>';
echo '<a href="javascript:getPredial(document.predialForma)" style="background-color:#ff0000;color:white">Consultar Predial</a>';
?>
<br>
<p id="propietario"></p>
<p id="direccion"></p>
<p id="Cuenta"></p>
<p id="Mensaje"></p>
<p id="Adeudo"></p>


</form>


</body>
</html>

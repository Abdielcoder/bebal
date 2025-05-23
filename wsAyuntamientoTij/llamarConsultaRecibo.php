<!DOCTYPE html>
<html>  
<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
function getRecibo(forma) {
var val=forma.referencia.value;
$.ajax({
type: "POST",
url: "ws-ConsultaRecibo.php",
data:'referencia='+val,
//async : false,
  success: function(data){
  //alert('success'+data);
  var xmlDoc = data;
  var mensajeX = xmlDoc.documentElement.getElementsByTagName("mensaje")[0];
  var mensaje = mensajeX.childNodes[0];
  var importeX = xmlDoc.documentElement.getElementsByTagName("importe")[0];
  var importe = importeX.childNodes[0];
  var idstatusX = xmlDoc.documentElement.getElementsByTagName("idstatus")[0];
  var idstatus = idstatusX.childNodes[0];

  //alert('mensaje: '+mensaje.nodeValue+', importe: '+importe.nodeValue);

  document.getElementById("mensaje").innerHTML = mensaje.nodeValue; 
  document.getElementById("importe").innerHTML = importe.nodeValue; 
  document.getElementById("idstatus").innerHTML = idstatus.nodeValue; 
  },
  timeout: 10000,
  error: function(){
    alert('failure');
  }
});
}
</script>

<form name='reciboForma'>
Consultar Recibo (referencia): <input type="text" name="referencia"><br>

<?php
echo '<a href="javascript:getRecibo(document.reciboForma)" style="background-color:#ff0000;color:white">Consultar Recibo</a>';
?>
<br>
<p id="mensaje"></p>
<p id="importe"></p>
<p id="idstatus"></p>


</form>


</body>
</html>

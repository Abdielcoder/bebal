<html>
<meta charset="utf-8" />
<head>
<script src="../MiLibreria/leaflet/js/leaflet.js"></script>
<link rel="stylesheet" href="../MiLibreria/leaflet/css/leaflet.css" />

<?php
$dbLon=$_GET["dbLon"];
$dbLat=$_GET["dbLat"];
$nombre_comercial_establecimiento=$_GET["nombre_comercial_establecimiento"];

?>
 <style>
  #map {
  widh: 50px;
  height: 270px; }
 </style>
 
 </head>
  <body>
   <div id="map"></div>
<script>

var map = L.map('map').
<?php
echo 'setView(['.$dbLat.','.$dbLon.'],';
?>
14);
 
L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
    maxZoom: 18
}).addTo(map);

L.control.scale().addTo(map);
<?php
echo 'L.marker(['.$dbLat.', '.$dbLon.'], {draggable: false, title:"'.$Placas.'"}).addTo(map);';
?>

 </script>
 </body>
<?php
echo '<font size=1 color=skyblue>'.$nombre_comercial_establecimiento.', Lat='.$dbLat.', Lon='.$dbLon;
?>
 </html>


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
  width: 450px;
  height: 300px; }
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
echo 'L.marker(['.$dbLat.', '.$dbLon.'], {draggable: false, title:"'.$nombre_comercial_establecimiento.'"}).addTo(map);';
?>

 </script>
 </body>
<?php
echo '<br>';
//echo '<font size=4 color=black>'.$nombre_comercial_establecimiento.', Lat='.$dbLat.', Lon='.$dbLon;
echo '<font size=4 color=black>'.$nombre_comercial_establecimiento;
?>
 </html>


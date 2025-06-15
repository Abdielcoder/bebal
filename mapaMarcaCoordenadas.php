<!DOCTYPE html>
<html>
  <head>
  <script src="../MiLibreria/leaflet/js/leaflet.js"></script>
  <link rel="stylesheet" href="../MiLibreria/leaflet/css/leaflet.css" />
</head>
<style>
html, body, #map {
  margin: 0px;
  width: 100%;
  height: 100%;
  padding: 0px;
}
~                  
</style>
<body>
  <form>
  <label for="latitude">Latitud:</label>
  <input id="latitud" type="text" />
  <label for="longitud">Longitude:</label>
  <input id="longitud" type="text" />
  </form>
  <div id="map"></div>
  </body>

<script>




var Lat="32.514756";
var Lon="-117.038333";

var map = L.map('map').
setView([Lat,Lon], 
14);
 
L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
    maxZoom: 18
}).addTo(map);


var marker = L.marker([Lat,Lon],{
draggable: true
}).addTo(map);

marker.on('dragend', function (e) {
  document.getElementById('latitud').value = marker.getLatLng().lat;
  document.getElementById('longitud').value = marker.getLatLng().lng;
});
</script>
</html>

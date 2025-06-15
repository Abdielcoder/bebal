var Lat="32.5317397";
var Lon="-117.019529";


const modal = document.getElementById('EfectuarInspeccion');
const modalBs = new bootstrap.Modal(EfectuarInspeccion);

const map = L.map("map")
map.setView([Lat,Lon], 14);


L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
    maxZoom: 18
}).addTo(map);

modalBs.show();

var marker = L.marker([Lat,Lon],{
draggable: true
}).addTo(map);


map.whenReady(() => {
    setTimeout(() => {
        map.invalidateSize();
    }, 550);
});

marker.on('dragend', function (e) {
  document.getElementById('latitud').value = marker.getLatLng().lat;
  document.getElementById('longitud').value = marker.getLatLng().lng;
});


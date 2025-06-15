const modal = document.getElementById('EfectuarInspeccion');
const modalBs = new bootstrap.Modal(EfectuarInspeccion);
const map = L.map("map")

map.setView([41.902782, 12.496366], 12);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 18,
	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
modalBs.show();

map.whenReady(() => {
    setTimeout(() => {
        map.invalidateSize();
    }, 250);
});

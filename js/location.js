import { LatLng, LatLngBounds, Map, Marker, Polyline, TileLayer } from "./lib/leaflet/leaflet-src.esm.js";

const container = document.querySelector('#map');
const map = new Map(container);
map.setMaxZoom(15);
map.setView([0,0], 1);
// map.addLayer(new TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
// 	// maxZoom: 15,
// 	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
// }));

const locations = JSON.parse(container.getAttribute('data-locations'));
const locLine = new Polyline(
	locations.map(it=>[it.lat, it.lon])
);
locLine.addTo(map);

const bounds = locLine.getBounds();

const markers = JSON.parse(container.getAttribute('data-markers'));
markers.forEach(it=>{
	const marker = new Marker([it.lat, it.lon]);
	marker.bindTooltip(it.label);
	marker.addTo(map);
	bounds.extend(marker.getLatLng());
});


map.fitBounds(bounds);


const time = document.querySelector('#time');
const timeValue = document.querySelector('#timeValue');
let timeMarker;
const timeChanged = ()=>{
	if (!locations.length) return;
	const loc = locations[time.value];
	timeValue.textContent = new Date(loc.timestamp*1000).toLocaleString();
	if (timeMarker) {
		timeMarker.remove();
	}
	timeMarker = new Marker([loc.lat, loc.lon]);
	timeMarker.bindTooltip(timeValue.textContent);
	timeMarker.addTo(map);
};
time.min = 0;
time.max = locations.length - 1;
time.value = locations.length - 1;
timeChanged();
time.addEventListener('input', timeChanged);

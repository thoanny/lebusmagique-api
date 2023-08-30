import './admin.scss';
import 'leaflet/dist/leaflet'
import 'leaflet/dist/leaflet.css'


if(document.getElementById('genshin-map')) {
    const target = document.getElementById('genshin-map');
    const {tiles ,zoom, minZoom, maxZoom, bounds, inputX, inputY, icon, markerX, markerY} = target.dataset;
    const mapIcon = L.icon({
        iconUrl: icon,
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [12, 0]
    });

    let mapBounds = [];
    let currentMarker = null;

    if(bounds) {
        const b = bounds.split('|');
        b.forEach((c) => {
            console.log('c', c)
            c.split(',').forEach((d) => {
                mapBounds.push(d);
            });
        })
    }

    const genshinMap = new L.Map('genshin-map', {
        center: [0,0],
        zoom: zoom,
        zoomControl: false
    });

    function unproject(coord) {
        return genshinMap.unproject(coord, genshinMap.getMaxZoom());
    }

    function onMapClick(e) {
        const iptX = (inputX) ? document.getElementById(inputX) : null;
        const iptY = (inputY) ? document.getElementById(inputY) : null;
        const position = genshinMap.project([e.latlng.lat, e.latlng.lng], genshinMap.getMaxZoom());
        const x = Math.floor(position.x);
        const y = Math.floor(position.y);
        if(iptX && iptY) {
            iptX.value = x;
            iptY.value = y;
        }

        if(!currentMarker) {
            currentMarker = L.marker(unproject([x, y]), {icon: mapIcon}).addTo(genshinMap);
        } else {
            currentMarker.setLatLng(unproject([x, y]));
        }
    }

    L.tileLayer(tiles + '/{z}/{x}/{y}.jpg', {
        attribution: '<a href="https://gaming.lebusmagique.fr">Le Bus Magique Gaming</a>',
        maxZoom: maxZoom,
        minZoom: minZoom,
        continuousWorld: true,
        maxBoundsViscosity: 0.8,
        noWrap: true
    }).addTo(genshinMap);

    console.log(mapBounds)

    if(mapBounds.length === 4) {
        genshinMap.setMaxBounds(new L.LatLngBounds(unproject([mapBounds[0], mapBounds[1]]), unproject([mapBounds[2], mapBounds[3]])));
    }

    if(markerX && markerY) {
        currentMarker = L.marker(unproject([markerX, markerY]), {icon: mapIcon}).addTo(genshinMap);
        genshinMap.setView(unproject([markerX, markerY]), maxZoom);
    }

    genshinMap.on('click', onMapClick);
}

document.getElementById('menu-toggle').addEventListener('click', (e) => {
    document.getElementById('menu').classList.toggle('hidden');
});

import $ from 'jquery';
import 'webpack-jquery-ui';

$(document).ready(function() {
    $('#sortable').sortable({
        placeholder: "ui-state-highlight"
    });
    $("#sortable").disableSelection();
});




const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('#' + e.currentTarget.dataset.collectionHolderId);
    const collectionLimit = e.currentTarget.dataset.collectionLimit;
    const item = document.createElement('div');
    const numberOfChildren = collectionHolder.children.length;

    if(typeof collectionLimit !== 'undefined') {
        if(numberOfChildren >= collectionLimit) {
            return;
        }
    }

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            numberOfChildren
        );

    item.querySelector('.remove-item').addEventListener('click', (e) => {
        e.target.parentNode.parentNode.parentNode.parentNode.remove()
        // el.parentNode.parentNode.parentNode.remove()
    })

    collectionHolder.appendChild(item);
};

['#character_add_wish', '#recipe_add_ingredient'].forEach(el => {
    if(document.querySelector(el)) {
        document.querySelector(el).addEventListener("click", addFormToCollection);
    }
});

if(document.querySelectorAll('.remove-item')) {
    document.querySelectorAll('.remove-item').forEach(el => {
        el.addEventListener('click', () => {
            el.parentNode.parentNode.parentNode.remove()
        })
    })
}
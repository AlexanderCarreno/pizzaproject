var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};
  
function success(pos) {
    var crd = pos.coords; // crd.lolongitude = 1.00, crd.latitude = 1.00
    mapboxgl.accessToken = 'pk.eyJ1Ijoic3Vtc3VtZXIiLCJhIjoiY2t0dzRzZHV1MHFidzJ3cW01c3ZhNWY3aSJ9.ltCHiShuwSZrohgLhM4ZOA';
    lngLat  = [crd.longitude,crd.latitude];

    var mapa = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: lngLat,
        zoom: 13,
        interactive: true
    });
    
    new mapboxgl.Marker({
        draggable: true
    })
        .setLngLat(this.lngLat)
        .addTo(mapa);
    
};
  
function error(err) {
    console.warn('ERROR(' + err.code + '): ' + err.message);
};


// Script start here
if (!navigator.geolocation) {
    alert('The Browser dose not support Geolocation');
}else{
    navigator.geolocation.getCurrentPosition(success, error, options);
}

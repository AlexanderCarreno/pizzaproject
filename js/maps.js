var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};
  
function success(pos) {
    var crd = pos.coords;
    
    //console.log('Your current position is:');
    //console.log('Latitude : ' + crd.latitude);
    //console.log('Longitude: ' + crd.longitude);
    //console.log('More or less ' + crd.accuracy + ' meters.');

    mapboxgl.accessToken = 'pk.eyJ1Ijoic3Vtc3VtZXIiLCJhIjoiY2t0dzRzZHV1MHFidzJ3cW01c3ZhNWY3aSJ9.ltCHiShuwSZrohgLhM4ZOA';
    //lngLat  = [-100.192842,25.722559];
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

if (!navigator.geolocation) {
    alert('The Browser dose not support Geolocation');
}else{
    navigator.geolocation.getCurrentPosition(success, error, options);
}

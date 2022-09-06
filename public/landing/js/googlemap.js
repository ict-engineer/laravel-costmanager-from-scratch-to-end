

function initMap() {
    var map;
    var marker;
  result = {lat:19.4326, lng: -99.1332};
  // The map, centered at Uluru
  map = new google.maps.Map(
    document.getElementById('map'), {zoom: 10, center: result});
  // The marker, positioned at Uluru
  marker = new google.maps.Marker({position: result, map: map});
}

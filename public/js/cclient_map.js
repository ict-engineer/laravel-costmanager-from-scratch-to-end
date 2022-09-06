// Initialize and add the map
var map;
var marker;

function initMap() {
  // The location of Uluru
    lat = 0;
    lng = 0;
  
  result = {lat:lat, lng: lng};
  // The map, centered at Uluru
  map = new google.maps.Map(
    document.getElementById('map'), {zoom: 15, center: result});
  // The marker, positioned at Uluru
  marker = new google.maps.Marker({position: result, map: map});
}


function getLatLong(add)
{
    var geocoder = new google.maps.Geocoder();
    // var countryData = $("#country_selector").countrySelect("getSelectedCountryData");
    // var cou = countryData['iso2'];
    add = add;
    geocoder.geocode( { address: add }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();
            result = {lat:lat, lng:lng};
            map.setCenter(result);
            map.setZoom(15);
            marker.setPosition(result);
            marker.setVisible(true);    
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();
        } else {
            result = "Unable to find address: " + status;
        }
    });
}


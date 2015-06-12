var select = document.getElementById("tours-select");
var keys = Object.keys(tours);

for (var i = 0; i < keys.length; i++) {
  var option =  document.createElement("option");
 
  option.text = tours[ keys[i] ]['name'];
  option.value = keys[i];
  select.add(option);
}

var map;
var infowindow = null;
var directionsDisplay = null;

function initialize() {
  var mapOptions = {
    zoom: 9
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);

      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
  
  setMarkers(map, sites);
  infowindow = new google.maps.InfoWindow({ content: "loading..." });
}

function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(27.943667,-82.446614,17),
  };

  map.setCenter(options.position);
}

function buildInfoWindow( id, image, name, description, url) {
  var pic = ( image == "" ) ? '' : 
    '<div style="float: left;"><img src="' + image + '" style="max-width: 100px; max-height: 100px; padding-right: 10px;" /></div>';

  var website = ( url == "" ) ? "" : "<br /> <br /> <a href='" + url + "' target='_blank'>Website</a>";
  var audioIcon = "http://lastpickproductions.com/wp-content/uploads/2013/05/speaker-icon.png";
  var audioSrc = "media/audio/applause.mp3";
  var audioTour = '<audio id="audio'+ id +'">\n  <source src="' + audioSrc + '" type="audio/mpeg">\n</audio>';
  var audioLink = '&nbsp; &nbsp; &nbsp; <a href="#" onclick="document.getElementById(\'audio' + id + '\').play(); return false;">Audio Tour <img src="'+ audioIcon +'" style="height: 15px; width: 15px;" /></a>';
  
  return pic + '<div><h4>' + name + "</h4>" + description + website + audioLink + "</div>\n" + audioTour;
}

function setMarkers(map, locations) {
  for (var i = 0; i < locations.length; i++) {
    var location = locations[i];
    var myLatLng = new google.maps.LatLng( location["lat"], location["lng"] );
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: location["name"],
		html: buildInfoWindow( location["id"], location["img"], location["name"], location["description"], location["url"] )
    });

    var contentString = "Some content";

    google.maps.event.addListener(marker, "click", function () {
      infowindow.setContent(this.html);
      infowindow.open(map, this);
    });
  }
}

function getTour( tourID ) {
 
  if ( tourID == "" ) { 

  //no tour selected
  if ( directionsDisplay  != null ) {
    directionsDisplay.setMap(null);
    directionsDisplay = null;
  }
  map.setZoom( 9 );
  map.setCenter( {lat: 27.9962691, lng: -82.4541977} );
 
 } else {
  
    //tour selected
    var tour = tours[ tourID ]['sites'];
	
    if ( directionsDisplay  != null ) {
     directionsDisplay.setMap(null);
      directionsDisplay = null;
    }

    directionsDisplay = new google.maps.DirectionsRenderer( { map: map } );
	
    // build an array of waypoints
    var wps = [];
    for (var i = 0; i < tour.length; i++ ) {
      wps[i] = {"location" : new google.maps.LatLng( sites[ tour[i] ]["lat"], sites[ tour[i] ]["lng"] ) };
    }

    if (typeof origin == 'undefined') {
      origin = new google.maps.LatLng ( 27.943667, -82.446614,17 );
	}

    var request = {
      "origin" : origin,
      "destination" : new google.maps.LatLng ( sites[5]["lat"], sites[5]["lng"]),
      "waypoints" : wps,
	  "optimizeWaypoints" : true,
      "travelMode" : google.maps.DirectionsTravelMode.DRIVING
    };
  
    directionsService = new google.maps.DirectionsService();

    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      } 
      else
        alert ('failed to get directions');
    });
  }
};

google.maps.event.addDomListener(window, 'load', initialize);
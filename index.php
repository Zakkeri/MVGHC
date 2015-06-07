<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
    </style>
    <title>Visitors Guide</title>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
    <script>
var infowindow = null;
var directionsDisplay = null;	
function initialize() {
  var mapOptions = {
    zoom: 11,
    center: new google.maps.LatLng(27.9962691, -82.4541977)
  }
  map = new google.maps.Map(document.getElementById('map-canvas'),
                                mapOptions);

  setMarkers(map, sites);
  
  infowindow = new google.maps.InfoWindow({
                content: "loading..."
               });
}

//JSON data
sites = [
  {"id": 0,
   "name": "Belmont Heights Little League", 
   "lat": 27.9813723, 
   "lng": -82.4360732,
   "img": "",
   "description": "Where Dwight Gooden, Floyd Youmans, Vance Lovelace, Gary Sheffield and Derek Bell learned to play the game.",
   "url": ""
   },
  {"id": 1, 
   "name": "Fort Foster Historic Site at Hillsborough River State Park", 
   "lat": 28.1479166, 
   "lng": -82.2348914,
   "img": "https://www.floridastateparks.org/sites/default/files/styles/slider_large/public/Division%20of%20Recreation%20and%20Parks/gallery/Hillsborough-River/DSC_0032.JPG?itok=HGneX-dQ",
   "description": "Within Hillsborough River State Park is a replica of Fort Foster, a Second Seminole War military fort built in 1836 and occupied until 1838. The fort guarded a military bridge over the Hillsborough River. An interpretive center contains exhibits on the fort, Seminoles, and Second Seminole War.",
   "url": "https://www.floridastateparks.org/park/Hillsborough-River"
   },
   {"id": 2, 
    "name": "Helping Hand Day Nursery", 
    "lat": 28.0060047, 
    "lng": -82.4100972,
    "img": "http://helpinghanddaycare.org/img/header.gif",
    "description": "Some of Tampa’s best known political figures were students here. The nursery began in 1924 and thrived in the city’s historically black business district, along Central Avenue.",
    "url": "http://helpinghanddaycare.org/"
  },
  {"id": 3, 
   "name": "The Jackson House", 
   "lat": 27.952036, 
   "lng": -82.452004,
   "img": "",
   "description": "The house was built around 1900 as a family’s home, but it was eventually transformed into a 24 room hotel for black visitors who, no matter how celebrated there were, could not get a room elsewhere in town.",
   "url": ""
  },
  {"id": 4, 
   "name": "La Union Martí-Maceo", 
   "lat": 27.960472, 
   "lng": -82.44588,
   "img": "",
   "description": "The club, which was founded in 1900, provided medical and other support services to the Afro-Cuban cigar workers who were barred by the practice of segregation of participating in the other Spanish and Italian clubs that cared for Ybor City’s cigar workers. The club was named for Cuban patriot Jose Martí, who was white, and General Antonio Maceo, who was black. Both were killed in the mid-1890s.",
   "url": ""
  },
  {"id": 5, 
   "name": "North Franklin Street Historic District", 
   "lat": 27.960472, 
   "lng": -82.44588,
   "img": "",
   "description": "A sparsely settled area of private wood frame dwellings and businesses, this neighborhood formed around 1900 and reached its peak during the 1930s. A segregated area until the 1960s, the F.W. Woolworth Department store was located at the corner of Franklin and Polk Streets and was the site of sit-ins in late February 1960 by the NAACP and students from Tampa’s Middleton and Blake High Schools and from Booker T. Washington Junior High School. Today the building is vacant but has been designated a local historic structure and is scheduled for redevelopment.",
   "url": ""
  },
  {"id": 6, 
   "name": "Oaklawn Cemetery", 
   "lat": 27.9545892, 
   "lng": -82.4572721,
   "img": "",
   "description": "Opened in 1859, this was Tampa’s first public cemetery. Perhaps its most remarkable grave is that of the white man, John Ashley, the city’s first clerk, and his black slave Nancy, who lived as common-law husband and wife, and are buried together here.",
   "url": ""
  },
  {"id": 7, 
   "name": "St. Paul AME Church", 
   "lat": 27.954068, 
   "lng": -82.458117,
   "img": "",
   "description": "The church dates back to 1870. It was the setting for many gatherings of civil rights campaigners, and the church has preserved its rich history with photographs of many people who visited and served there.",
   "url": ""
  },
  {"id": 8, 
   "name": "St. Peter Claver School", 
   "lat": 27.9568101, 
   "lng": -82.4533148,
   "img": "",
   "description": "The school, opened in 1894 in downtown, was burned down by white supremacists a year after it opened. It was rebuilt in its present location and remains the oldest black school in the county.",
   "url": ""
  },
  {"id": 9, 
   "name": "Upper Tampa Bay Park Archaeological District", 
   "lat": 28.0147713, 
   "lng": -82.633423,
   "img": "http://vivaflorida.org/var/site/storage/images/explore/gardens-and-parks/upper-tampa-bay-park-archaeological-district/11088-2-eng-US/Upper-Tampa-Bay-Park-Archaeological-District_poi.jpg",
   "description": "This 2,144-acre park and preserve features an archaeological district within the park, with 18 sites that date from 500 to 4,000 years ago and are associated with the Manasota Culture. The interpretive building houses exhibits on the archaeological district.",
   "url": "http://www.hillsboroughcounty.org/Facilities/Facility/Details/7945"
  },
  {"id": 10,
   "name": "Bealsville Glover School", 
   "lat": 28.0186323, 
   "lng": -82.1128641,
   "img": "http://www.bealsville.com/WebpagestyleC/Publish/images/GloverSchool3.jpg",
   "description": "This part of Hillsborough County, seven miles south of Plant City, was settled in 1865 by freed slaves. The first of five churches, Antioch Baptist, was opened in 1868. A wooden one-room school house was built in 1933. Two other buildings were added in the 1940s, but the school was eventually closed. It operates today as a community center.",
   "url": "http://www.bealsville.com/"
  },
  {"id": 11,
   "name": "Mt. Olive African Methodist Episcopal Church", 
   "lat": 27.96934, 
   "lng": -82.7985454,
   "img": "",
   "description": "Built in 1913 in the Gothic Revival style, the church is on the site of the original Mt. Olive AME, built in 1896.",
   "url": "mtolivechurch1.org/"
  },
  {"id": 12,
   "name": "Tampa Bay History Center and Museum Store", 
   "lat": 27.9422224, 
   "lng": -82.4499111,
   "img": "http://thingstodo.s3.amazonaws.com/resources/photos/TampaBayHistory1.jpg",
   "description": "The new 60,000-square-foot Center features the first native inhabitants, Spanish conquistadors, pioneers, sports legends, a 1920s-era cigar store, interactive maps, and exhibits that feature a rich ethnic heritage and adventurous spirit that hasinspired generations.",
   "url": "www.tampabayhistorycenter.org/"
  },
  {"id": 13,
   "name": "Safety Harbor Temple Mound", 
   "lat": 28.0124434, 
   "lng": -82.6828505,
   "img": "",
   "description": "This National Historic Landmark site, with a large temple mound, was a ceremonial center of the Tocobaga Indians for nearly 500 years, beginning about 1,000 years ago.",
   "url": "www.pinellascounty.org/park/11_Philippe.htm"
  }
];

function buildInfoWindow(image, name, description, url) {
  var pic = ( image == "" ) ? '' : 
    '<div style="float: left;"><img src="' + image + '" style="max-width: 100px; max-height: 100px; padding-right: 10px;" /></div>';

  var website = ( url == "" ) ? "" : "<br /> <br /> <a href='" + url + "' target='_blank'>Website</a>";
	
  return pic + '<div><h4>' + name + "</h4>" + description + website + "</div>";
}

function setMarkers(map, locations) {

  for (var i = 0; i < locations.length; i++) {
    var location = locations[i];
    var myLatLng = new google.maps.LatLng( location["lat"], location["lng"] );
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: location["name"],
		html: buildInfoWindow( location["img"], location["name"], location["description"], location["url"] )
    });

    var contentString = "Some content";

    google.maps.event.addListener(marker, "click", function () {
      infowindow.setContent(this.html);
      infowindow.open(map, this);
    });
	
}
  
  google.maps.event.addListener(marker, 'click', function() {
    this.infowindow.open(map, this);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

function listClick() {
	console.log("Clicked!");
}
    </script>
	<style>
      #target {
        width: 345px;
      }
	  #tours {
		  position: fixed;
		  top: 20px;
		  left:30px;
		  border: 1px solid #999;
        background: #fff;
	  }
	  ul {
		  
		  list-style-type: none;
        padding: 0;
        margin: 0;
		height: 90px;

	  }
	  li {
        background-color: #f1f1f1;
        padding: 10px;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
		cursor: pointer;
	}
	  li:nth-child(odd) {
        background-color: #fcfcfc;
		cursor: pointer;
	  }
	h2 {
        font-size: 22px;
        margin: 0 0 5px 0;
      }

    </style>
 </head>
  <body>
    
	<div id="map-canvas"></div>
	<div id="tours">
	<center><h2>Tours</h2></center>
	<ul id="places"></ul>
	</div>
	<script>
var placesList = document.getElementById('places');
var li = document.createElement("li");
	li.appendChild(document.createTextNode("Tampa Round Tour"));
	li.addEventListener('click', function(){
	var latlng = new google.maps.LatLng(sites[5]["lat"], sites[5]["lng"]);
    var myOptions = {
      zoom: 9,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    };
   	var rendererOptions = { map: map };
	if(directionsDisplay  != null){
		directionsDisplay.setMap(null);
		directionsDisplay = null;
	}
	directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
		var point1 = new google.maps.LatLng(sites[3]["lat"], sites[3]["lng"]);
var point2 = new google.maps.LatLng(sites[7]["lat"], sites[7]["lng"]);
var point3 = new google.maps.LatLng(sites[6]["lat"], sites[6]["lng"]);
var point4 = new google.maps.LatLng(sites[8]["lat"], sites[8]["lng"]);

// build an array of the points
var wps = [{ location: point1 }, { location: point2 }, {location: point3}, {location: point4}];

// set the origin and destination
var org = new google.maps.LatLng ( sites[5]["lat"], sites[5]["lng"]);
var dest = new google.maps.LatLng ( sites[5]["lat"], sites[5]["lng"]);

var request = {
        origin: org,
        destination: dest,
        waypoints: wps,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
directionsService = new google.maps.DirectionsService();
	directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
				}
				else
					alert ('failed to get directions');
			});
		});
	placesList.appendChild(li);
	
var li1 = document.createElement("li");
	li1.appendChild(document.createTextNode("Around The Bay!"));
	li1.addEventListener('click', function(){
		var latlng = new google.maps.LatLng(sites[12]["lat"], sites[12]["lng"]);
    var myOptions = {
      zoom: 9,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    };
   	var rendererOptions = { map: map };
	if(directionsDisplay  != null){
		directionsDisplay.setMap(null);
		directionsDisplay = null;
	}
	directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
		var point1 = new google.maps.LatLng(sites[3]["lat"], sites[3]["lng"]);
var point2 = new google.maps.LatLng(sites[7]["lat"], sites[7]["lng"]);
var point3 = new google.maps.LatLng(sites[9]["lat"], sites[9]["lng"]);


// build an array of the points
var wps = [{ location: point1 }, { location: point2 }, {location: point3}];

// set the origin and destination
var org = new google.maps.LatLng ( sites[12]["lat"], sites[12]["lng"]);
var dest = new google.maps.LatLng ( sites[13]["lat"], sites[13]["lng"]);

var request = {
        origin: org,
        destination: dest,
        waypoints: wps,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
directionsService = new google.maps.DirectionsService();
	directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
				}
				else
					alert ('failed to get directions');
			});
		});
	placesList.appendChild(li1);	
</script>
  </body>
</html>


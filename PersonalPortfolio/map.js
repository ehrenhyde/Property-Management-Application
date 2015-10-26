var map;
var infowindows =[]; // declares an info windows array
var markers= [];

function initialize (){
	var mapOptions = { 
	zoom: 14, // declares the altitude the map will be at
	} ;
	map = new google.maps.Map(document.getElementById('MapArea'), mapOptions); //declares a new map
		
}

function GeneralMap (Address, jArray) {// this defines a map with many points
	initialize();
	var image = 'images/marker.png';
	
	for (i=0;i<jArray.length-1;i++) { // this for loop fill in the info windows with a string that is made up of the following variables concatanated with html
		var contentString = '<p><b>Address: </b>'+jArray[i];

		infowindows[i] = new google.maps.InfoWindow({// this is the info windows declaration
			content: contentString
		});

		var geocoder = new google.maps.Geocoder();
			geocoder.geocode({'address': jArray[i]}, function(results, status) {
				if (status === google.maps.GeocoderStatus.OK) {
					markers[i] = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location,
					title: jArray[i],
					icon: image
					});
				} else {
					alert('Geocode was not successful for the following reason: ' + status);
				}
			});
		
	}
	var infowindow = new google.maps.InfoWindow({// this is the info windows declaration
			content: 'Test'
		});
	
		
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({'address': Address}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var myMarker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
		
      });
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
	});
}
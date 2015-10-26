<script>function IndividualMap (i) {//this function defines a map thart has only a singular point on it
	document.getElementById('MapArea').style.display ="block";//this makes the map visible
	var data = [//this is the list of possible maps
		["7th Brigade Park, Chermside","Delaware St","Chermside",-27.37893,153.04461],
		["Annerley Library Wifi","450 Ipswich Road","Annerley, 4103",-27.50942285,153.0333218],
		["Ashgrove Library Wifi","87 Amarina Avenue","Ashgrove, 4060",-27.44394629,152.9870981],
		["Booker Place Park","Birkin Rd & Sugarwood St","Bellbowrie",-27.56353,152.89372],
		["Banyo Library Wifi","284 St. Vincents Road","Banyo, 4014",-27.37396641,153.0783234],
		["Bracken Ridge Library Wifi","Corner Bracken and Barrett Street","Bracken Ridge, 4017",-27.31797261,153.0378735],
		["Brisbane Botanic Gardens","Mt Coot-tha Rd","Toowong",-27.47724,152.97599],
		["Brisbane Square Library Wifi","Brisbane Square, 266 George Street","Brisbane, 4000",-27.47091173,153.0224598],
		["Bulimba Library Wifi","Corner Riding Road & Oxford Street","Bulimba, 4171",-27.45203086,153.0628242],
		["Calamvale District Park","Formby & Ormskirk Sts","Calamvale",-27.62152,153.03665],
		["Carina Library Wifi","Corner Mayfield Road & Nyrang Street","Carina, 4152",-27.49169314,153.0912127],
		["Carindale Library Wifi","The Home and Leisure Centre, Corner Carindale Street  & Banchory Court, Westfield Carindale Shopping Centre","Carindale, 4152",-27.50475928,153.1003965],
		["Carindale Recreation Reserve","Cadogan and Bedivere Sts","Carindale",-27.497,153.11105],
		["Chermside Library Wifi","375 Hamilton Road","Chermside, 4032",-27.3856032,153.0349028],
		["City Botanic Gardens Wifi","Alice Street","Brisbane City",-27.47561,153.03005]
		]
	var LatLng = new google.maps.LatLng(data[i][3],data[i][4])// this declares the position in the world the map will show
	var mapOptions = { 
	zoom: 14, // this controls the altitude the map will be at
	center: LatLng // this centers the map on the predetermined position
	} ;
	var map = new google.maps.Map(document.getElementById('MapArea'), mapOptions); // this declares the map
	var marker = new google.maps.Marker({ // this declares the map marker
		position: LatLng, // this places the map marker on the target location
		map: map, // this tells the marker which map to be on
	});
	
}
function GeneralMap (i) {// this defines a map with many points
	
	var mapOptions = { 
	zoom: 14, // declares the altitude the map will be at
	center: LatLng // centers the map on the average position
	} ;
	var map = new google.maps.Map(document.getElementById('MapArea'), mapOptions); //declares a new map
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({'address': i}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
      });
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
	});
	var data = [// this is the list of points that will be on the map
		["7th Brigade Park, Chermside","Delaware St","Chermside",-27.37893,153.04461],
		["Annerley Library Wifi","450 Ipswich Road","Annerley, 4103",-27.50942285,153.0333218],
		["Ashgrove Library Wifi","87 Amarina Avenue","Ashgrove, 4060",-27.44394629,152.9870981],
		["Booker Place Park","Birkin Rd & Sugarwood St","Bellbowrie",-27.56353,152.89372],
		["Banyo Library Wifi","284 St. Vincents Road","Banyo, 4014",-27.37396641,153.0783234],
		["Bracken Ridge Library Wifi","Corner Bracken and Barrett Street","Bracken Ridge, 4017",-27.31797261,153.0378735],
		["Brisbane Botanic Gardens","Mt Coot-tha Rd","Toowong",-27.47724,152.97599],
		["Brisbane Square Library Wifi","Brisbane Square, 266 George Street","Brisbane, 4000",-27.47091173,153.0224598],
		["Bulimba Library Wifi","Corner Riding Road & Oxford Street","Bulimba, 4171",-27.45203086,153.0628242],
		["Calamvale District Park","Formby & Ormskirk Sts","Calamvale",-27.62152,153.03665],
		["Carina Library Wifi","Corner Mayfield Road & Nyrang Street","Carina, 4152",-27.49169314,153.0912127],
		["Carindale Library Wifi","The Home and Leisure Centre, Corner Carindale Street  & Banchory Court, Westfield Carindale Shopping Centre","Carindale, 4152",-27.50475928,153.1003965],
		["Carindale Recreation Reserve","Cadogan and Bedivere Sts","Carindale",-27.497,153.11105],
		["Chermside Library Wifi","375 Hamilton Road","Chermside, 4032",-27.3856032,153.0349028],
		["City Botanic Gardens Wifi","Alice Street","Brisbane City",-27.47561,153.03005]
		]
	var Lat = 0 // this initializes the positioning variables
	var Long = 0
	for (i=0;i<data.length;i++) {// this for loop and following lines averages the center of the map to the center of the points on it
		var Lat = Lat + data[i][3];
		var Long = Long + data[i][4];
	}
	var Lat= Lat/(data.length); 
	var Long = Long/(data.length); //end of averaging code
	
	var LatLng = new google.maps.LatLng(Lat, Long) // declares the position of the map to be equal to the average position
	
	var markers = [] // declares a markers array
	var infowindows = [] // declares an info windows array
	for (i=0;i<data.length;i++) { // this for loop fill in the info windows with a string that is made up of the following variables concatanated with html
		var contentString = '<p><b>Hotspot name: </b>'+data[i][0]+
		'<br><b>Address: </b>'+data[i][1]+
		'<br><b>Suburb: </b>'+data[i][2]+
		'<br><b>Latitude & Longitude: </b>'+data[i][3]+','+data[i][4]+'</p>'+
		'<p><b>More info: </b><a href="Result.html">'+
		data[i][0]+'</a></p>';

		infowindows[i] = new google.maps.InfoWindow({// this is the info windows declaration
			content: contentString
		});

		var LatLng = new google.maps.LatLng(data[i][3],data[i][4])// this redefines the position to the individual location of the data point
		markers [i] = new google.maps.Marker({ // this declares a new marker
			position: LatLng, // this declaers the position of the marker
			map: map, // this tells it which map to be on
			title: data[i][0] // this gives the marker a title
		});
		
	}
	/* the following 15 call of this function are unavoidable or at least for my efforts in trying to
	make this into a for loop. these call create the event of clicking on a marker and assigning its
	information window, i tried to for loop this but it didn't work after hours of trying so i figure
	this will have to suffice*/
	google.maps.event.addListener(markers[0], 'click', function() {
			infowindows[0].open(map,markers[0]);
			
		});
	google.maps.event.addListener(markers[1], 'click', function() {
			infowindows[1].open(map,markers[1]);
			
		});
	google.maps.event.addListener(markers[2], 'click', function() {
			infowindows[2].open(map,markers[2]);
			
		});
	google.maps.event.addListener(markers[3], 'click', function() {
			infowindows[3].open(map,markers[3]);
			
		});
	google.maps.event.addListener(markers[4], 'click', function() {
			infowindows[4].open(map,markers[4]);
			
		});
	google.maps.event.addListener(markers[5], 'click', function() {
			infowindows[5].open(map,markers[5]);
			
		});
	google.maps.event.addListener(markers[6], 'click', function() {
			infowindows[6].open(map,markers[6]);
			
		});
	google.maps.event.addListener(markers[7], 'click', function() {
			infowindows[7].open(map,markers[7]);
			
		});
	google.maps.event.addListener(markers[8], 'click', function() {
			infowindows[8].open(map,markers[8]);
			
		});
	google.maps.event.addListener(markers[9], 'click', function() {
			infowindows[9].open(map,markers[9]);
			
		});
	google.maps.event.addListener(markers[10], 'click', function() {
			infowindows[10].open(map,markers[10]);
			
		});
	google.maps.event.addListener(markers[11], 'click', function() {
			infowindows[11].open(map,markers[11]);
			
		});
	google.maps.event.addListener(markers[12], 'click', function() {
			infowindows[12].open(map,markers[12]);
			
		});
	google.maps.event.addListener(markers[13], 'click', function() {
			infowindows[13].open(map,markers[13]);
			
		});
	google.maps.event.addListener(markers[14], 'click', function() {
			infowindows[14].open(map,markers[14]);
			
		});
}</script>

function StationMap(elementId) {
	
	// self reference to be used in function closure scopes
	var self = this;
	
	var stationMarkers = [];
	
	var mapOptions = {
		zoom: 9,
		center: new google.maps.LatLng(64.984005, 25.06372),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var map = new google.maps.Map(document.getElementById(elementId), mapOptions);
	
	self.addStation = function(station) {
	
		var coords = station.location_coordinates.split(",");
		
		var position = new google.maps.LatLng($.trim(coords[0]), $.trim(coords[1]));
		var marker = new RichMarker({
			title: station.location_name,
			position: position,
			draggable: false,
			flat: true,
			map: map,
			anchor: RichMarkerPosition.MIDDLE,
			content: station.getMarkerContent()
		});
		
		/*
		google.maps.event.addListener(marker, 'click', function() {
		
		});
		*/
		
		stationMarkers.push(marker);
	};
	
	self.clearStations = function() {
	  for (var i = 0; i < stationMarkers.length; i++) {
		  stationMarkers[i].setMap(null);
	  }		
	}
};

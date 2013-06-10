
function MainPageViewModel() {
	
	// path where the measurements json is loaded
	var measurementsDataPath = "data/measurements.php";
	
	// interval (milliseconds) for measurement data updates
	var updateInterval = 60 * 1000;
	
	// self reference to be used in function closure scopes
	var self = this;
	
	self.weatherStations = ko.observableArray([]);
		
	/**
	 * Begin sequential data updates
	 */
	self.beginUpdates = function () {
		
		// sequentially load measurement json data
		setInterval(function(){		
			self.loadFromServer();
		}, updateInterval);		
	}
	
	/**
	 * Load weather station data JSON from server
	 */
	self.loadFromServer = function () {
		
		$.getJSON(measurementsDataPath, function(json){
			
			var stationArray = $.map(json, function(stationData) {
				return new WeatherStation().importJSON(stationData);
			});
			
			self.weatherStations(stationArray);
			
			// update map
			map.clearStations();
			for(var i = 0; i < self.weatherStations().length; i++){
				map.addStation(self.weatherStations()[i]);
			}
			
		});
	};	
}

function WeatherStation() {
	
	// self reference to be used in function closure scopes
	var self = this;
	
	self.station_id = null;
	self.description = null;
	self.location_name = null;
	self.location_coordinates = null;
	
	self.currentMeasurement = ko.observable(new Measurement());
	self.measurements = ko.observableArray([]);
	
	self.importJSON = function(json) {
		
		self.station_id = json.station_id;
		self.description = json.description;
		self.location_name = json.location_name;
		self.location_coordinates = json.location_coordinates;
		
		if(json.measurements[0]) {
			self.currentMeasurement().importJSON(json.measurements[0]);
		}
		
		self.measurements($.map(json.measurements, function(measurement){
			return new Measurement().importJSON(measurement);
		}));
	
		return self;
	};
	
	self.getMarkerContent = function() {
		var content = "";
		content += "<div class='wind-marker wind-";
		content += Math.round(self.currentMeasurement()['speed'])
		content += "-"		
		content += self.currentMeasurement().getDirectionStrings()[0];		
		content += "'></div>";
		return content;
	};
	
	
}

function Measurement() {

	// self reference to be used in function closure scopes
	var self = this;
	
	self.speed = "";
	self.gust = "";
	self.direction = "";
	self.measurement_time = "";
	
	self.importJSON = function(json) {
		
		self.speed = json.speed;
		self.gust = json.gust;
		self.direction = json.direction;
		self.measurement_time = json.measurement_time;
	
		return self;
	};	
	
	self.getDirectionStrings = function () {
		
		var currentDirection = self.direction;
		
		var arr = [];
		if( currentDirection > 337.5 && currentDirection <= 22.5 ) {
			arr[0] = "N";
			arr[1] = "Pohjoistuulta";
		}
		else if ( currentDirection > 22.5 && currentDirection <= 67.5 ) {
			arr[0] = "NE";
			arr[1] = "Koillistuulta";
		}
		else if ( currentDirection > 67.5 && currentDirection <= 112.5 ) {
			arr[0] = "E";
			arr[1] = "Itätuulta";
		}
		else if ( currentDirection > 112.5 && currentDirection <= 157.5 ) {
			arr[0] = "SE";
			arr[1] = "Kaakkoistuulta";
		}
		else if ( currentDirection > 157.5 && currentDirection <= 202.5 ) {
			arr[0] = "S";
			arr[1] = "Etelätuulta";
		}
		else if ( currentDirection > 202.5 && currentDirection <= 247.5 ) {
			arr[0] = "SW";
			arr[1] = "Lounastuulta";
		}
		else if ( currentDirection > 247.5 && currentDirection <= 292.5 ) {
			arr[0] = "W";
			arr[1] = "Länsituulta";
		}
		else if ( currentDirection > 292.5 && currentDirection <= 337.5 ) {
			arr[0] = "NW";
			arr[1] = "Luoteistuulta";
		}		
		
		return arr;
	};	
}
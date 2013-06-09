
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
			
		});
	};	
}

function WeatherStation() {
	
	// self reference to be used in function closure scopes
	var self = this;
	
	self.station_id = null;
	self.name = null;
	self.description = null;
	self.location_name = null;
	self.location_coordinates = null;
	
	self.currentMeasurement = ko.observable(new Measurement());
	self.measurements = ko.observableArray([]);
	
	self.importJSON = function(json) {
		
		self.station_id = json.station_id;
		self.name = json.name;
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
	
	
}

function Measurement() {

	// self reference to be used in function closure scopes
	var self = this;
	
	self.speed = null;
	self.gust = null;
	self.direction = null;
	self.measurement_time = null;
	
	self.importJSON = function(json) {
		
		self.speed = json.speed;
		self.gust = json.gust;
		self.direction = json.direction;
		self.measurement_time = json.measurement_time;
	
		return self;
	};	
}
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>TNS windmeter</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css" />
        <link rel="stylesheet" type="text/css" href="css/windmarker-styles.css.php" />        
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>        
        <script type="text/javascript" src="js/ext/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="js/ext/knockout-2.2.1.js"></script>
		<script type="text/javascript" src="js/ext/richmarker-min.js"></script>				
		<script type="text/javascript" src="js/scripts.js"></script>
		<script type="text/javascript" src="js/viewmodel.js"></script>		
    </head>
    <body>
    
    <script type="text/javascript">	

		var map;
		var viewModel;
		$(document).ready(function() {

			viewModel = new MainPageViewModel();			
			ko.applyBindings(viewModel);			
			viewModel.loadFromServer();
			viewModel.beginUpdates();

			map = new StationMap("map");

		});
		
	</script>
    
    <div id="main" class="centered">
	    <div id="map" class="panel"></div>
	    <div id="weather_stations" class="panel" data-bind="foreach: weatherStations">
	    	<div class="station">
				<div class="station-info">
					<span class="location-name" data-bind="text: location_name"></span>
				    <span class="measurement-time" data-bind="text: currentMeasurement().measurement_time"></span><br>					 			
					<!--<span class="description" data-bind="text: description"></span><br>--> 
					
					<br>
					<div class="current-measurement">
				    	<span data-bind="text: currentMeasurement().getDirectionStrings()[1]"></span>					
				    	<span class="wind-measurement"data-bind="text: currentMeasurement().speed"></span>
				    	<span>/</span>
				    	<span class="wind-measurement" data-bind="text: currentMeasurement().gust"></span>
				    	<span>m/s</span>				
					</div> 
					<br>
				</div>
				<div class="station-graph">
				</div>
			</div>
			<hr/>										
	    </div> 
    </div>   
    </body>
</html>
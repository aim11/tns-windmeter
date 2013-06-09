<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>TNS windmeter</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css" />
        <script type="text/javascript" src="js/ext/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="js/ext/knockout-2.2.1.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
		<script type="text/javascript" src="js/viewmodel.js"></script>		
    </head>
    <body>
    
    <script type="text/javascript">	
	
		$(document).ready(function() {

			var viewModel = new MainPageViewModel();			
			ko.applyBindings(viewModel);			
			viewModel.loadFromServer();
			viewModel.beginUpdates();

		});
		
	</script>
    
    <div id="map"></div>
    <div id="weather_stations">
    	<ul data-bind="foreach: weatherStations">
    		<li>
    			<span data-bind="text: name"></span><br>
				<span data-bind="text: description"></span><br> 
				<span data-bind="text: location_name"></span><br> 
				<span data-bind="text: location_coordinates"></span><br>
				<div class="current-measurement">
			    	<span data-bind="text: currentMeasurement().speed"></span><br>
			    	<span data-bind="text: currentMeasurement().gust"></span><br>
			    	<span data-bind="text: currentMeasurement().direction"></span><br>
			    	<span data-bind="text: currentMeasurement().measurement_time"></span><br>				
				</div> 
				<ul data-bind="foreach: measurements">
					<li>
				    	<span data-bind="text: speed"></span><br>
				    	<span data-bind="text: gust"></span><br>
				    	<span data-bind="text: direction"></span><br>
				    	<span data-bind="text: measurement_time"></span>    					    					    					
					</li>
				</ul>											
    		</li>
    	</ul>
    </div>    
    </body>
</html>
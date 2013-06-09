<?php

include_once('../inc/config.php');
include_once('../inc/db.php');
include_once('../inc/util.php');
include_once('../inc/auth.php');

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
  case 'GET':
    get($request);  
    break;	
  case 'POST':
    post($request);  
    break;
  default:
    error($request);  
    break;
}

function get($request) {

	$con = db_connect();

	$stations_data = db_getAllStationInfo($con);

	db_disconnect($con);
	
	echo json_encode($stations_data);
}

function post($request) {
	
	/* check authentication */
	if(!checkBasicAuth()){
		sendBasicAuthRequired();	
	}
	
	$station_info = array();
	$station_info['name'] = $_POST['name'];
	$station_info['description'] = $_POST['description'];
	$station_info['location_name'] = $_POST['location_name'];
	$station_info['location_coordinates'] = $_POST['location_coordinates'];
	
	/* value checks */
	if (!$station_info['name']) {
		header(' ', true, 400);
		exit("Parameter 'name' required");		
	}
	if (!$station_info['description']) {
		header(' ', true, 400);
		exit("Parameter 'description' required");
	}	
	if (!$station_info['location_name']) {
		header(' ', true, 400);
		exit("Parameter 'location_name' required");
	}	
	if (!$station_info['location_coordinates']) {
		header(' ', true, 400);
		exit("Parameter 'location_coordinates' required");
	} else if(!checkCoordinates($station_info['location_coordinates'])) {
		header(' ', true, 400);
		exit("Parameter 'location_coordinates' is not valid coordinates. Valid syntax is '[latitude], [longitude]' e.g. '65.042454, 25.411150'");		
	}	
	
	$con = db_connect();
	
	$station_id = db_addStationInfo($con, $station_info);
	
	if ($station_id != 0) {
		header(' ', true, 200);	
		$station_info['station_id'] = $station_id;
		echo json_encode($station_info);
	} else {
		header(' ', true, 500);	
	}
	
	db_disconnect($con);
}

?>

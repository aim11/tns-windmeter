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

	$station_id_param = $_GET['station_id'];
	$from_param = $_GET['from'];
	$to_param = $_GET['to'];
	
	if($from_param)
	if(!checkDateTime($from_param)){
		header(' ', true, 400);
		exit('From parameter is not a valid datetime');		
	}
	
	if($to_param)
	if(!checkDateTime($to_param)){
		header(' ', true, 400);
		exit('To parameters is not a valid datetime');	
	}	
	
	$con = db_connect();

	$result_data = null;
	
	if($station_id_param) {
		$station_data = db_getStationInfo($con, $station_id_param);
		if(empty($station_data)) {
			header(' ', true, 400);
			exit('Invalid station id');
		}
		$measurements = db_getStationMeasurements($con, $station_id_param, $from_param, $to_param);		
		$station_data['measurements'] = $measurements;
		$result_data = $station_data;		
	} else {
		$stations_data = db_getAllStationInfo($con);
		foreach($stations_data as &$station_data) {
			$measurements = db_getStationMeasurements($con, $station_data['station_id'], $from_param, $to_param);
			$station_data['measurements'] = $measurements;		
		}
		$result_data = $stations_data;
	}

	db_disconnect($con);
	
	echo json_encode($result_data);
}

function post($request) {
	
	/* check authentication */
	if(!checkBasicAuth()){
		sendBasicAuthRequired();
	}
	
	$station_id_param = $_POST['station_id'];
	
	$measurement_arr = array();
	$measurement_arr['speed'] = $_POST['speed'];
	$measurement_arr['gust'] = $_POST['gust'];
	$measurement_arr['direction'] = $_POST['direction'];
	$measurement_arr['measurement_time'] = $_POST['measurement_time'];
	
	/* value checks */
	if (!$measurement_arr['speed']) {
		header(' ', true, 400);
		exit("Parameter 'speed' required");		
	}
	if (!$measurement_arr['gust']) {
		header(' ', true, 400);
		exit("Parameter 'gust' required");
	}	
	if (!$measurement_arr['direction']) {
		header(' ', true, 400);
		exit("Parameter 'direction' required");
	}	
	if (!$measurement_arr['measurement_time']) {
		header(' ', true, 400);
		exit("Parameter 'measurement_time' required");
	} else if(!checkDateTime($measurement_arr['measurement_time'])) {
		header(' ', true, 400);
		exit("Parameter 'measurement_time' is not valid datetime. Valid syntax is 'yyyy-mm-dd hh:mm:ss");		
	}	
	
	$con = db_connect();
	
	$success = db_addStationMeasurement($con, $station_id_param, $measurement_arr);
	
	if ($success) {
		header(' ', true, 200);		
	} else {
		header(' ', true, 500);	
	}
	
	db_disconnect($con);
}

?>

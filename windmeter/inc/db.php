<?php

include_once('config.php');

function db_connect() {
	
	global $config;
	
	$con = mysqli_connect(
			$config['db']['host'],
			$config['db']['user'],
			$config['db']['password'],
			$config['db']['name']);
	
	/* check connection error*/
	if (mysqli_connect_errno()) {
		die( 'Could not connect: ' . mysqli_connect_error() );
	}	
	
	return $con;
}

function db_disconnect($con) {
	$con->close();
}

function db_addStationInfo($con, $station_info_arr) {

	$name = mysqli_real_escape_string($con, $station_info_arr['name']);
	$description = mysqli_real_escape_string($con, $station_info_arr['description']);
	$location_name = mysqli_real_escape_string($con, $station_info_arr['location_name']);
	$location_coordinates = mysqli_real_escape_string($con, $station_info_arr['location_coordinates']);
	
	$query = 'INSERT INTO weather_station(name, description, loc_name, loc_coordinates) VALUES(?,?,?,?)';
	
	
	if ($stmt = mysqli_prepare($con, $query)) {
	
		/* pass parameters to query */
		mysqli_stmt_bind_param($stmt, "ssss", $name, $description, $location_name, $location_coordinates);
	
		/* run the query on the database */
		mysqli_stmt_execute($stmt);
	
		$station_id = mysqli_insert_id($con);
	
		if ($station_id == 0) {
			printf("Database error: %s.\n", $stmt->error);
		}
	
		/* close statement */
		mysqli_stmt_close($stmt);
	}
	
	return $station_id;
	
}

function db_updateStationInfo($con, $station_id_param, $station_info_arr) {
	
}

function db_deleteStationInfo($con, $station_id_param) {
	
}

function db_getAllStationInfo($con) {

	$stations = array();

	$query = 'SELECT id, name, description, loc_name, loc_coordinates FROM weather_station';

	if ($stmt = mysqli_prepare($con, $query)) {

		/* run the query on the database */
		mysqli_stmt_execute($stmt);

		/* assign variable for each column to store results in */
		mysqli_stmt_bind_result($stmt, $id, $name, $description, $location_name, $location_coordinates);

		/* fetch values */
		while (mysqli_stmt_fetch($stmt)) {

			$station_info = array();
			$station_info['station_id'] = $id;
			$station_info['name'] = $name;
			$station_info['description'] = $description;
			$station_info['location_name'] = $location_name;
			$station_info['location_coordinates'] = $location_coordinates;
			$stations[] = $station_info;
		}

		/* close statement */
		mysqli_stmt_close($stmt);
	}

	return $stations;
}

function db_getStationInfo($con, $station_id_param) {
	
	$station_id = mysqli_real_escape_string($con, $station_id_param);
	
	$station_info = array();
	
	$query = 'SELECT name, description, loc_name, loc_coordinates FROM weather_station WHERE id=?';

	if ($stmt = mysqli_prepare($con, $query)) {
	
		/* pass parameters to query */
		mysqli_stmt_bind_param($stmt, "i", $station_id);
	
		/* run the query on the database */
		mysqli_stmt_execute($stmt);
	
		/* assign variable for each column to store results in */
		mysqli_stmt_bind_result($stmt, $name, $description, $location_name, $location_coordinates);
	
		/* fetch values */
		if (mysqli_stmt_fetch($stmt)) {
			
			$station_info['name'] = $name;
			$station_info['description'] = $description;
			$station_info['location_name'] = $location_name;
			$station_info['location_coordinates'] = $location_coordinates;

		}
	
		/* close statement */
		mysqli_stmt_close($stmt);
	}
	
	return $station_info;	
}

function db_addStationMeasurement($con, $station_id_param, $measurement_arr) {

	$station_id = mysqli_real_escape_string($con, $station_id_param);
	$speed = mysqli_real_escape_string($con, $measurement_arr['speed']);
	$gust = mysqli_real_escape_string($con, $measurement_arr['gust']);
	$direction = mysqli_real_escape_string($con, $measurement_arr['direction']);
	$measurement_time = mysqli_real_escape_string($con, $measurement_arr['measurement_time']);

	$query = 'INSERT INTO measurement_wind(station_id, speed, gust, direction, measurement_time) VALUES(?,?,?,?,?)';

	$success = false;

	if ($stmt = mysqli_prepare($con, $query)) {

		/* pass parameters to query */
		mysqli_stmt_bind_param($stmt, "iddis", $station_id, $speed, $gust, $direction, $measurement_time);

		/* run the query on the database */
		mysqli_stmt_execute($stmt);

		$success = mysqli_stmt_affected_rows($stmt) == 1;

		if (!$success) {
			printf("Database error: %s.\n", $stmt->error);
		}

		/* close statement */
		mysqli_stmt_close($stmt);
	}

	return $success;
}

function db_getStationMeasurements($con, $station_id_param, $from_param, $to_param) {

	$station_id = mysqli_real_escape_string($con, $station_id_param);
	$query = 'SELECT speed, gust, direction, measurement_time FROM measurement_wind WHERE station_id=?';

	if($from_param != $to_param) {
		if($from_param) {
			$from = mysqli_real_escape_string($con, $from_param);
			$query = $query . ' AND measurement_time >= ?';
		}
		if($to_param) {
			$to = mysqli_real_escape_string($con, $to_param);
			$query = $query . ' AND measurement_time <= ?';
		}
	}

	$query = $query . ' ORDER BY measurement_time DESC';

	if($from_param != null && $to_param!= null && $from_pram == $to_param) {
		$query = $query . ' LIMIT 1';
	}

	$measurements = array();

	if ($stmt = mysqli_prepare($con, $query)) {

		/* pass parameters to query */
		if ($from && $to) {
			mysqli_stmt_bind_param($stmt, "iss", $station_id, $from, $to);
		} else if (!$from && $to) {
			mysqli_stmt_bind_param($stmt, "is", $station_id, $to);
		} else if ($from && !$to) {
			mysqli_stmt_bind_param($stmt, "is", $station_id, $from);
		} else if (!$from && !$to) {
			mysqli_stmt_bind_param($stmt, "i", $station_id);
		}




		/* run the query on the database */
		mysqli_stmt_execute($stmt);

		/* assign variable for each column to store results in */
		mysqli_stmt_bind_result($stmt, $speed, $gust, $direction, $measurement_time);

		/* fetch values */
		while (mysqli_stmt_fetch($stmt)) {

			$row = array();
			$row['measurement_time'] = $measurement_time;
			$row['speed'] = $speed;
			$row['gust'] = $gust;
			$row['direction'] = $direction;

			$measurements[] = $row;
		}

		/* close statement */
		mysqli_stmt_close($stmt);
	}

	return $measurements;
}

?>
<?php

include_once('config.php');

function checkBasicAuth() {
	
	global $config;
	
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		return false;
	} else {
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];
		
		return ($username == $config['user']['name'] && $password == $config['user']['password']);
	}
}

function sendBasicAuthRequired() {
	header('WWW-Authenticate: Basic realm="TNS windmeter"');
	header('HTTP/1.0 401 Unauthorized');
	echo 'Authentication required.';
	exit;	
}
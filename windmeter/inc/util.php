<?php

function checkDateTime($data) {
	return (date('Y-m-d H:i:s', strtotime($data)) == $data);
}

function checkCoordinates($coords) {
	
	return (preg_match('/^([+\-]?[0-9]{1,3}\.[0-9]{3,}),\s*([+\-]?[0-9]{1,3}\.[0-9]{3,})\z/', $coords) == 1);
}

?>
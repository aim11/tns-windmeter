<?php

function checkDateTime($data) {
	return (date('Y-m-d H:i:s', strtotime($data)) == $data);
}

?>
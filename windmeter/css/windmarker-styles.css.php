<?php

header("Content-type: text/css", true);

// N
for($i = 0; $i < 40; $i++) {
	echo ".wind-".$i."-N {background-position: ".($i*-30)."px 0px;}";
}
// NW
for($i = 0; $i < 40; $i++) {
	echo ".wind-".$i."-NW {background-position: ".($i*-30)."px -30px;}";
}
// W
for($i = 0; $i < 40; $i++) {
	echo ".wind-".$i."-W {background-position: ".($i*-30)."px -60px;}";
}
// SW
for($i = 0; $i < 40; $i++) {
	echo ".wind-".$i."-SW {background-position: ".($i*-30)."px -90px;}";
}
// S
for($i = 0; $i < 40; $i++) {
	echo ".wind-".$i."-S {background-position: ".($i*-30)."px -120px;}";
}
// SE
for($i = 0; $i < 40; $i++) {
	echo ".wind-".$i."-SE {background-position: ".($i*-30)."px -150px;}";
}
// E
for($i = 0; $i < 40; $i++) {
	echo ".wind-".$i."-E {background-position: ".($i*-30)."px -180px;}";
}
// NE
for($i = 0; $i < 40; $i++) {
	echo ".wind-".$i."-NE {background-position: ".($i*-30)."px -210px;}";
}
?>
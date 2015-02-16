<?php

function correctDecimal($var){
	return 0+(str_replace(".", "", $var));
}

function getColor($diff){
	$red=0;$green=0;$blue=0;
	if($diff>510) {
		$red=255;
	}else if($diff>255){
		$red=255;
		$green=510-$diff;
	}else if($diff>0){
		$green=255;
		$red=$diff;
	}else{
		$green=255;
		$blue= max(array(255,$diff*-1));
	}
	$rgbstring="rgb($red,$green,$blue)";
	return $rgbstring;
}

?>
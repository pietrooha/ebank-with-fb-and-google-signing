<?php

function genNewKey() {
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$key = array();
	$alphaLength = strlen($alphabet) - 1;
	for ($i = 0; $i < 8; $i++) {
	  $n = rand(0, $alphaLength);
	  $key[] = $alphabet[$n];
	}
	return implode($key);
}

?>
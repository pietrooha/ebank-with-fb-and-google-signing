<?php

function encryptKey($key)
{
	$key = mysql_real_escape_string(trim(strip_tags($key)));
	$key = md5($key);
	$salt = substr(hash('sha512',rand(1,99999) . microtime()),0,64);
	$key = sha1($key . $salt);
	$key = hash('sha512',$key . $salt);

	return $key;
}

?>
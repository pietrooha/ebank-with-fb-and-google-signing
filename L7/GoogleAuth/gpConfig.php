<?php
//session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '678702197210-7ubci2h7pdb20pdcllptnpuq1ml853o5.apps.googleusercontent.com';
$clientSecret = 'c8-AfPf_GZhMeg7wduyToVLU';
$redirectURL = 'http://e-systempieniezny.pl/crypto/L4/Lista4/Lista7/L7/index.php';

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Logowanie do e-systempieniezny.pl');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>
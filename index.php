<?php

require_once("fb-sdk/src/facebook.php");

$config = array(
    'appId' => '649697948411720',
    'secret' => '64cbda50eb4afdda6ab07acea8189164',
    'fileUpload' => false, // optional
    'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
);

$facebook = new Facebook($config);

print_r($facebook);

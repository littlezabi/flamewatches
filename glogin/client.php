<?php


require 'google-api/vendor/autoload.php';
// Creating new google client instance
$client = new Google_Client();

// Enter your Client ID

// $client->setClientId('949848343660-qvtsdrldffe0tjfc553lq3sjm81ec14f.apps.googleusercontent.com');
$client->setClientId('417159939838-5hqjgcpfll294rm7193i9n012rv759jo.apps.googleusercontent.com');
// Enter your Client Secrect
//$client->setClientSecret('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');
$client->setClientSecret('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');
// Enter the Redirect URL
// $client->setRedirectUri('https://firewatch.gbfirmware.com/glogin/login.php');
$client->setRedirectUri('https://flamewatches.com/glogin/login.php');

// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");

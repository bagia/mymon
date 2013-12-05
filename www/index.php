<?php

$f3 = require_once ("lib/base.php");

if ((float)PCRE_VERSION < 7.9)
	trigger_error ("PCRE version is out of date");

// Load the configuration from a place that is not exposed:
$f3->config ("../config.ini");

$f3->set('DB', new \DB\SQL (
    "mysql:host={$f3->get('MYSQL_SERVER')};port={$f3->get('MYSQL_PORT')};dbname={$f3->get('MYSQL_DB')}",
    $f3->get('MYSQL_USER'),
    $f3->get('MYSQL_PWD')
));

// Define the routes:
$f3->route ("GET /", "\\Prospe\\Controller\\MasterController->masterAction");
// We need to inject the Facebook app id from the config.ini file in the facebook.js script
$f3->route ("GET /ui/js/@script_name.js", "\\Prospe\\Controller\\JavascriptController->getScript");
$f3->route ("GET /watchdogs/list/@user_third_party_id", "\\Prospe\\Controller\\WatchdogController->watchdogsList");
$f3->route ("GET /watchdogs/count/@user_third_party_id", "\\Prospe\\Controller\\WatchdogController->watchdogsCount");

$f3->run ();


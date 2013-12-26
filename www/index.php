<?php
set_time_limit(0);

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
// In case we need to inject some data from the configuration in the Javascript files:
$f3->route ("GET /ui/js/@script_name.js", "\\Prospe\\Controller\\JavascriptController->getScript");
// Watchdog management
$f3->route ("GET /watchdogs/list", "\\Prospe\\Controller\\WatchdogController->watchdogsList");
$f3->route ("GET /watchdogs/count", "\\Prospe\\Controller\\WatchdogController->watchdogsCount");
$f3->route ("POST /watchdogs", "\\Prospe\\Controller\\WatchdogController->watchdogsNew");
$f3->route ("DELETE /watchdogs/@watchdog_id", "\\Prospe\\Controller\\WatchdogController->watchdogsDelete");
// Detect trafic from Facebook
$f3->route ("GET /img/@image", "\\Prospe\\Controller\\ImageController->hit");

$f3->run ();


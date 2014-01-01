<?php
require_once("bootstrap.php");

// TODO: remove the test route when it is not useful anymore
$f3->route ("GET /test", "\\Prospe\\Controller\\TestController->testAction");

// Master route
$f3->route ("GET /", "\\Prospe\\Controller\\MasterController->masterAction");

// In case we need to inject some data from the configuration in the Javascript files:
$f3->route ("GET /ui/js/@script_name.js", "\\Prospe\\Controller\\JavascriptController->getScript");

// Watchdog management
$f3->route ("GET /watchdogs/list", "\\Prospe\\Controller\\WatchdogController->watchdogsList");
$f3->route ("GET /watchdogs/count", "\\Prospe\\Controller\\WatchdogController->watchdogsCount");
$f3->route ("POST /watchdogs", "\\Prospe\\Controller\\WatchdogController->watchdogsNew");
$f3->route ("POST /watchdogs/power", "\\Prospe\\Controller\\WatchdogController->watchdogsPower");
$f3->route ("DELETE /watchdogs/power", "\\Prospe\\Controller\\WatchdogController->watchdogsPowerDelete");
$f3->route ("DELETE /watchdogs/@watchdog_id", "\\Prospe\\Controller\\WatchdogController->watchdogsDelete");

// Tasks management
$f3->route ("GET /tasks/@task_id", "\\Prospe\\Controller\\TaskController->progressAction");


// Detect trafic from Facebook
$f3->route ("GET /img/@image", "\\Prospe\\Controller\\ImageController->hit");

$f3->run ();


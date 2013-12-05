<?php

$f3 = require_once ("lib/base.php");

if ((float)PCRE_VERSION < 7.9)
	trigger_error ("PCRE version is out of date");

// Load the configuration from a place that is not exposed:
$f3->config ("../config.ini");

// Define the routes:
$f3->route ("GET /", "\\Prospe\\Controller\\MasterController->masterAction");

$f3->run ();


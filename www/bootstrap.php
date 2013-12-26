<?php
$f3 = require_once ("lib/base.php");

if ((float)PCRE_VERSION < 7.9)
    trigger_error ("PCRE version is out of date");

// Load the configuration from a place that is not exposed:
$f3->config (realpath(__DIR__ . "/../config.ini"));

$f3->set('DB', new \DB\SQL("mysql:host={$f3->get('MYSQL_SERVER')};port={$f3->get('MYSQL_PORT')};dbname={$f3->get('MYSQL_DB')}",
               $f3->get('MYSQL_USER'),
               $f3->get('MYSQL_PWD')
));

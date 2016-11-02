#!/usr/bin/env php
<?php

require_once __DIR__ . "/../vendor/autoload.php";

$app             = new Silex\Application();
$application_env = getenv("APPLICATION_ENV") ? : null;

$app->register(new CinemaHD\Config($application_env));

if ('cli' === php_sapi_name()) {
    $app['console']->run();
}

<?php

date_default_timezone_set('Indian/Antananarivo');
error_reporting(E_ALL);

if (function_exists('mb_internal_encoding') === true) {
  mb_internal_encoding('UTF-8');
}

if (empty($app) === true) {
  $app = Flight::app();
}

$app->path(__DIR__ . $ds . '..' . $ds . '..');

$app->set('flight.base_url', '/');
$app->set('flight.case_sensitive', false);
$app->set('flight.log_errors', true);
$app->set('flight.handle_errors', false);
$app->set('flight.views.path', __DIR__ . $ds . '..' . $ds . 'views');
$app->set('flight.views.extension', '.php');

return [
  'database' => [
    'host' => 'localhost',
    'dbname' => '4064_4078',
    'user' => 'root',
    'password' => '',
    'port' => 3306
  ],
];

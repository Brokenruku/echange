<?php

use flight\Engine;
use flight\debug\tracy\TracyExtensionLoader;
use Tracy\Debugger;

Debugger::enable();
Debugger::$logDirectory = __DIR__ . $ds . '..' . $ds . 'log';
Debugger::$strictMode = true;

if (Debugger::$showBar === true && php_sapi_name() !== 'cli') {
  (new TracyExtensionLoader($app));
}

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$app->register('db', mysqli::class, [
  $config['database']['host'],
  $config['database']['user'],
  $config['database']['password'],
  $config['database']['dbname'],
  $config['database']['port'],
]);

try {
  $app->db()->set_charset('utf8mb4');
} catch (\Throwable $e) {
}

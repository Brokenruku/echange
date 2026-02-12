<?php

use app\middlewares\SecurityHeadersMiddleware;
use app\controllers\ObjectController;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$router->group('', function (Router $router) use ($app) {

  $router->get('/', function () {
    Flight::redirect('/login');
  });

  $router->get('/objects', [ObjectController::class, 'index']);
  $router->get('/objects/@id', [ObjectController::class, 'show']);

  $router->post('/echanges/proposer', [ObjectController::class, 'proposer']);
  $router->get('/echanges', [ObjectController::class, 'echanges']);
  $router->post('/echanges/@id/refuser', [ObjectController::class, 'refuser']);
  $router->post('/echanges/@id/accepter', [ObjectController::class, 'accepter']);

  $router->get('/login', function () {
    Flight::render('login');
  });

  $router->post('/login', [ObjectController::class, 'login']);
}, [SecurityHeadersMiddleware::class]);

<?php
session_start();
date_default_timezone_set('America/Sao_paulo');
require '../vendor/autoload.php';
require '../src/routes.php';

$router->run( $router->routes );
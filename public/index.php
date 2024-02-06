<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;

$router = new Router();


// $router->get('/', [PaginasController::class, 'index']);



$router->comprobarRutas();

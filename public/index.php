<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\CtrlFeeds;
use Controllers\CtrlNews;
use Controllers\CtrlPages;
use MVC\Router;

$router = new Router();


$router->get("/",[CtrlPages::class,"index"]);

$router->get("/feeds",[CtrlPages::class,"feeds"]);
$router->post("/feeds/update",[CtrlFeeds::class,"registrarFeedsNuevas"]);

$router->get("/news/buscar",[CtrlNews::class,"buscarNoticias"]);
$router->post("/news/update",[CtrlFeeds::class,"actualizarFeeds"]);

$router->comprobarRutas();

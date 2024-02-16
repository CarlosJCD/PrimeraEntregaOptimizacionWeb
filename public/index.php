<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\CtrlFeeds;
use Controllers\CtrlNews;
use Controllers\CtrlPages;
use MVC\Router;

$router = new Router();


// $router->get('/', [PaginasController::class, 'index']);

$router->get("/",[CtrlPages::class,"index"]);
$router->get("/feeds",[CtrlPages::class,"feeds"]);

$router->put("/news/update",[CtrlNews::class,"updateNews"]);


$router->post("/feeds/new",[CtrlFeeds::class,""]);
$router->put("/feeds/update/",[CtrlFeeds::class,"updateFeed"]);
$router->delete("/feeds/delete/",[CtrlFeeds::class,"updateFeed"]);

$router->comprobarRutas();

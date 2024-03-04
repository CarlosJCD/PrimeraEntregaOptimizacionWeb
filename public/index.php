<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\CtrlFeeds;
use Controllers\CtrlNews;
use Controllers\CtrlPages;
use MVC\Router;

$router = new Router();


$router->get("/",[CtrlPages::class,"index"]);

$router->get("/feeds",[CtrlPages::class,"feeds"]);

$router->post("/feeds/update",[CtrlFeeds::class,"actualizarFeeds"]);

$router->put("/news/update",[CtrlNews::class,"updateNews"]);

$router->comprobarRutas();

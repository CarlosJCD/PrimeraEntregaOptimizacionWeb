<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\CtrlFeeds;
use Controllers\CtrlNews;
use Controllers\CtrlPages;
use MVC\Router;

$router = new Router();


$router->get("/",[CtrlPages::class,"index"]);
$router->get("/feeds",[CtrlPages::class,"feeds"]);
$router->post("/feeds",[CtrlPages::class,"feeds"]);
$router->get("/news",[CtrlPages::class,"news"]);

$router->put("/news/update",[CtrlNews::class,"updateNews"]);


$router->post("/feeds/new",[CtrlFeeds::class,"registerFeed"]);
$router->put("/feeds/update/",[CtrlFeeds::class,"updateFeed"]);
$router->post("/feeds/delete/",[CtrlFeeds::class,"deleteFeed"]);

$router->comprobarRutas();

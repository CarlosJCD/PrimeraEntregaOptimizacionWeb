<?php 


namespace Controllers;

use MVC\Router;

use Model\FeedModel;
use Model\NewsModel;
use Model\CategoriesModel;
use Controllers\CtrlFeeds;

class CtrlPages{

    public static function index(Router $router){
    }

    public static function feeds(Router $router){
        
        $feeds = FeedModel::get("ASC", "10");
        $urls = [];

        foreach ($feeds as $feed) {
            $urls[] = $feed->feedRssUrl;
        }
        
        $router->render('/feeds', [
            'title' => 'Agregar Feeds',
            'urls' => $urls
        ]);
        return;
    }

    public static function news(Router $router){
        
        $news  = NewsModel::get("ASC", "10");
        $categories = CategoriesModel::get("ASC", "10");
        $router->render('/news', [
            'title' => 'Mostrar Noticias',
            'news' => $news,
            'categories' => $categories
        ]);
    }

}
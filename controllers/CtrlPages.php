<?php


namespace Controllers;

use Classes\DB;
use MVC\Router;

use Model\FeedModel;
use Model\CategoriesModel;

class CtrlPages{

    public static function index(Router $router){
        
        $feedId = $_GET["feedId"] ?? null;
        $ordenarPor = $_GET["ordenarPor"] ?? "newsDate";
        $orden = $_GET["orden"] ??"ASC";
        $categoriaId = $_GET["categoriaId"] ?? null;

        
        $db = new DB();
        
        $db = $db->select(["newsTitle", "newsDescription","newsDate", "newsUrl", "newsImageUrl", "feedName","feedImageUrl"])->from("news")->join("feeds","feeds.id","=","news.feedId");

        if(isset($feedId) && !empty($feedId)){
            $db = $db->where(["feedId" =>$feedId]);
        }
        
        $db = $db->orderBy($ordenarPor)->order($orden);


        $news = $db->build();

        $feeds = $db->rawSQL("SELECT feeds.id, feeds.feedName, COUNT(news.id) AS total FROM feeds JOIN news ON feeds.id = news.feedId GROUP BY feeds.id, feeds.feedName");


        $categories = CategoriesModel::whereAll("feedId", $feedId ?? "");
        $router->render('/index', [
            'title' => 'LectorRSS - Noticias',
            'news' => $news,
            "feeds" => $feeds,
            'categorias' => $categories ?? [],
            "ordenarPor" => $ordenarPor,
            "orden" => $orden,
            "feedId" => $feedId,
            "categoriaId" => $categoriaId
        ]);
    }

    public static function feeds(Router $router){
        
        $feeds = FeedModel::get();
        $urls = [];

        foreach ($feeds as $feed) {
            $urls[] = $feed->feedRssUrl;
        }
        
        $router->render('/feeds', [
            'title' => 'LectorRSS - Feeds',
            'urls' => $urls
        ]);
    }

}

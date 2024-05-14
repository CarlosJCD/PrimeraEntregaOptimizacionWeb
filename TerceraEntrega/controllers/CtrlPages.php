<?php


namespace Controllers;

use Classes\Paginacion;
use Classes\DB;
use MVC\Router;
use Model\FeedModel;
use Model\CategoriesModel;

class CtrlPages{

    public static function index(Router $router){
        
        $feedId = $_GET["feedId"] ?? 0;
        $ordenarPor = $_GET["ordenarPor"] ?? "newsDate";
        $orden = $_GET["orden"] ??"ASC";
        $categoriaId = $_GET["categoriaId"] ?? null;

        
        $db = new DB();
        
        if(!empty($feedId)){
            $totalDeNoticias = $db->rawSQL("SELECT COUNT(news.id) AS total FROM news JOIN feeds ON news.feedId = feeds.id WHERE feeds.id = $feedId");

        }else{
            $totalDeNoticias = $db->rawSQL("SELECT COUNT(news.id) AS total FROM news");
        }
       

        $db = $db->reset();

        if(!empty($feedId)){
            $db = $db->where(["news.feedId" =>$feedId]);
            $selectedFeed =  FeedModel::findById($feedId);

            $feedCategories = CategoriesModel::where("feedId", $feedId);
        }

        if(!empty($categoriaId)){
            $db = $db->where(["categories.id"=>$categoriaId]);
        }

        $registrosPorPagina = 20;
        $paginaActual = $_GET["page"] ?? 1;
        $totalRegistrosDeNoticias = intval($totalDeNoticias[0]["total"]);
        $paginacion = new Paginacion($paginaActual, $registrosPorPagina, $totalRegistrosDeNoticias, $feedId);

        $db = $db->select(["news.id","newsTitle", "newsDescription","newsDate", "newsUrl", "newsImageUrl", "feedName","feedImageUrl", "feedUrl", "GROUP_CONCAT(categories.categoryName SEPARATOR ', ') AS categories"])->from("news")->join("INNER","feeds","feeds.id","=","news.feedId")->groupBy("news.id")->join("LEFT","categories_news", "categories_news.newsId","=","news.id")->join("LEFT","categories","categories_news.categoryId","=","categories.id");
        
        $db = $db->orderBy($ordenarPor)->order($orden)->limit($registrosPorPagina)->offset($paginacion->offset());

        $news = $db->build();

        $feeds = $db->rawSQL("SELECT feeds.id, feeds.feedName, feeds.feedImageUrl, COUNT(news.id) AS total FROM feeds JOIN news ON feeds.id = news.feedId GROUP BY feeds.id, feeds.feedName");

        $categories = CategoriesModel::whereAll("feedId", $feedId ?? "");

       
    
        $router->render('/index', [
            'title' => 'LectorRSS - Noticias',
            'news' => $news,
            "feeds" => $feeds,
            'categorias' => $categories ?? [],
            "ordenarPor" => $ordenarPor,
            "orden" => $orden,
            "feedId" => $feedId,
            "selectedFeed" => $selectedFeed ?? null,
            "categoriaId" => $categoriaId,
            "paginacion" => $paginacion->paginacion()
        ]);
    }

    public static function feeds(Router $router){
        
        $feeds = FeedModel::get();
        $urls = [];

        foreach ($feeds as $feed) {
            $urls[] = $feed->feedRssUrl;
        }
        $db = new DB();
        $feeds = $db->rawSQL("SELECT feeds.id, feeds.feedName, feeds.feedImageUrl, COUNT(news.id) AS total FROM feeds JOIN news ON feeds.id = news.feedId GROUP BY feeds.id, feeds.feedName");

        $router->render('/feeds', [
            'title' => 'LectorRSS - Feeds',
            'urls' => $urls,
            "feeds" => $feeds
        ]);
    }

}

<?php


namespace Controllers;

use Classes\Paginacion;
use Classes\DB;
use MVC\Router;
use Model\FeedModel;
use Model\CategoriesModel;

class CtrlPages{ 
    const REGISTROS_POR_PAGINA = 20;
    public static function index(Router $router){
        
        $feedId = $_GET["feedId"] ?? 0;
        $ordenarPor = $_GET["ordenarPor"] ?? "newsDate";
        $orden = $_GET["orden"] ??"ASC";
        $categoriaId = $_GET["categoriaId"] ?? null;

        $db = new DB();
        
        $totalDeNoticias = self::obtenerTotalDeNoticiasDeLaDB($feedId, $db);

        if(!empty($feedId)){
            $db = $db->where(["news.feedId" =>$feedId]);
            $selectedFeed =  FeedModel::findById($feedId);
        }

        if(!empty($categoriaId)){
            $db = $db->where(["categories.id"=>$categoriaId]);
        }

        $paginaActual = $_GET["page"] ?? 1;
        $totalRegistrosDeNoticias = intval($totalDeNoticias[0]["total"]);
        $paginacion = new Paginacion($paginaActual, self::REGISTROS_POR_PAGINA, $totalRegistrosDeNoticias, $feedId);

        if(self::paginaActualMayorATotalDePaginas($paginaActual, $paginacion->total_paginas())){
            self::redireccionarAPrimeraPagina();
        } else {

            $news = self::obtenerNoticiasDeLaDB($ordenarPor, $orden, $paginacion->offset(), $db);

            $feeds = self::obtenerFeedsDeLaDB($db);

            $categories = self::obtenerCategoriasDeLaDB($feedId);
        
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
    }

    private static function obtenerTotalDeNoticiasDeLaDB(int $feedId, DB $db){
        if(!empty($feedId)){
           $totalNoticias = $db->rawSQL("SELECT COUNT(news.id) AS total FROM news JOIN feeds ON news.feedId = feeds.id WHERE feeds.id = $feedId");
        } else {
            $totalNoticias = $db->rawSQL("SELECT COUNT(news.id) AS total FROM news");
        }
        $db = $db->reset();
        return $totalNoticias;
    }

    private static function paginaActualMayorATotalDePaginas($paginaActual, $totalPaginas){
        return $paginaActual > $totalPaginas;
    }

    private static function redireccionarAPrimeraPagina(){
        $urlActual = $_SERVER['REQUEST_URI'];

        $componentesDeLaURL = parse_url($urlActual);
        parse_str($componentesDeLaURL['query'], $queryParams);

        unset($queryParams['page']);

        $queryStringNuevo = http_build_query($queryParams);

        $nuevaUrl = $componentesDeLaURL['path'] . '?' . $queryStringNuevo;

        header("Location: $nuevaUrl");
    }

    private static function obtenerNoticiasDeLaDB(string $ordenarPor, string $orden, int $offset, DB $db){
        $db = $db->select(["news.id","newsTitle", "newsDescription","newsDate", "newsUrl", "newsImageUrl", "feedName","feedImageUrl", "feedUrl", "GROUP_CONCAT(categories.categoryName SEPARATOR ', ') AS categories"])->from("news")->join("INNER","feeds","feeds.id","=","news.feedId")->groupBy("news.id")->join("LEFT","categories_news", "categories_news.newsId","=","news.id")->join("LEFT","categories","categories_news.categoryId","=","categories.id");
        
        $db = $db->orderBy($ordenarPor)->order($orden)->limit(self::REGISTROS_POR_PAGINA)->offset($offset);

        return $db->build();
    }

    private static function obtenerFeedsDeLaDB(DB $db){
        return $db->rawSQL("SELECT feeds.id, feeds.feedName, feeds.feedImageUrl, COUNT(news.id) AS total FROM feeds JOIN news ON feeds.id = news.feedId GROUP BY feeds.id, feeds.feedName");
    }

    private static function obtenerCategoriasDeLaDB(int $feedId){
        return CategoriesModel::whereAll("feedId", $feedId ?? "");
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

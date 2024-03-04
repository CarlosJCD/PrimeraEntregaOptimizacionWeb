<?php

namespace Controllers;

use Model\FeedModel;
use Model\NewsModel;
use Model\CategoriesModel;
use SimplePie\SimplePie;
use Controllers\CtrlNews;
use Model\CategoriesNewsModel;

class CtrlFeeds
{

    public static function registrarFeedsNuevas()
    {

        $peticion = json_decode(file_get_contents('php://input'));
        $feedsURLS = $peticion->feedsUrls;


        $respuestaValidacion = static::validarFeedsURLs($feedsURLS);

        if (!$respuestaValidacion["ok"]) {
            header("Content-Type: application/json");
            echo json_encode($respuestaValidacion);
            return;
        }

        static::vaciarDB();

        $simplePieFeeds = $respuestaValidacion["simplePieFeeds"];

        static::registrarFeeds($simplePieFeeds);

        header("Content-Type: application/json");
        echo json_encode(["ok" => true]);
    }

    public static function actualizarFeeds(){
        $feedsModelo = FeedModel::get();

        NewsModel::deleteAll();
        CategoriesModel::deleteAll();
        CategoriesNewsModel::deleteAll();

        foreach ($feedsModelo as $feedModelo) {
            $simplePieFeed = static::instanciarSimplePieFeed($feedModelo->feedUrl);
            $simplePieFeed->init();
            $simplePieFeed->handle_content_type("application/xml");
            
            CtrlNews::registrarNoticias($simplePieFeed, $feedModelo);
        }

        header("Content-Type: application/json");
        echo json_encode(["ok" => true]);
    }

    private static function validarFeedsURLs(array $feedsURLs)
    {

        $simplePieFeeds = [];
        foreach ($feedsURLs as $feedURL) {
            $simplePieFeed = static::instanciarSimplePieFeed($feedURL);

            if (!$simplePieFeed->init()) {

                return ["ok" => false, "feedErronea" => $feedsURLs];
            }

            $simplePieFeed->handle_content_type("application/xml");
            $simplePieFeeds[] = $simplePieFeed;
        }
        return ["ok" => true, "simplePieFeeds" => $simplePieFeeds];
    }

    private static function instanciarSimplePieFeed(String $feedURI)
    {
        $feed = new SimplePie();
        $feed->set_feed_url($feedURI);
        $feed->enable_cache(false);

        return $feed;
    }

    private static function vaciarDB()
    {
        FeedModel::deleteAll();
        NewsModel::deleteAll();
        CategoriesModel::deleteAll();
        CategoriesNewsModel::deleteAll();
    }

    private static function registrarFeeds(array $simplePieFeeds)
    {
        foreach ($simplePieFeeds as $simplePieFeed) {
            $feedRegistrada = FeedModel::where('feedUrl', $simplePieFeed->get_permalink());

            if (!isset($feedRegistrada)) {
                $feedModel = static::registrarFeed($simplePieFeed);
                CtrlNews::registrarNoticias($simplePieFeed, $feedModel);
            }
        }
    }

    private static function registrarFeed(SimplePie $simplePieFeed)
    {

        $feedModel = static::construirModeloFeed($simplePieFeed);

        $respuestaBD = $feedModel->create();
        $feedModel->id = $respuestaBD["id"];

        return $feedModel;
    }

    private static function construirModeloFeed(SimplePie $simplePieFeed)
    {

        $feedModel = new FeedModel();

        $feedModel->feedName = $simplePieFeed->get_title();
        $feedModel->feedUrl = $simplePieFeed->get_permalink();

        $feedImageUrl = $simplePieFeed->get_image_link();
        $feedModel->feedRssUrl = $simplePieFeed->subscribe_url();

        if ($simplePieFeed->get_image_link() == $feedModel->feedUrl && !isset($feedimageUrl)) {
            $feedImageUrl = $simplePieFeed->get_image_url();

            if (!isset($feedImageUrl) || $feedImageUrl == $feedModel->feedUrl) {
                $feedModel->feedImageUrl = 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Feed-icon.svg/800px-Feed-icon.svg.png';
            }
        }

        $feedModel->feedImageUrl = $feedImageUrl;

        return $feedModel;
    }
}

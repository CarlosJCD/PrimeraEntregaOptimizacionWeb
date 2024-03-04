<?php 

namespace Controllers;

use MVC\Router;
use Model\NewsModel;
use Model\FeedModel;
use SimplePie\SimplePie;
use Controllers\CtrlCategories;
use SimplePie\Item;

class CtrlNews{


    public static function registrarNoticias(SimplePie $simplePieFeed, FeedModel $feedModel ){
        
        $simplePieItems = $simplePieFeed->get_items();

        foreach ($simplePieItems as $simplePieItem){
            $noticiaRegistrada = NewsModel::where('newsUrl', $simplePieItem->get_permalink());
            
            if (!isset($noticiaRegistrada)) {
                $newsModel = static::registrarNoticia($feedModel, $simplePieItem);
                
                $newsCategories = $simplePieItem->get_categories();

                if(isset($newsCategories)) CtrlCategories::registrarCategorias($newsCategories, $newsModel);
                
            }
        }
    }

    private static function registrarNoticia(FeedModel $feedModel, Item $simplePieItem){
        $newsModel = static::construirModeloNoticias($feedModel, $simplePieItem);
        $respuestaBD = $newsModel->create();
        $newsModel->id = $respuestaBD["id"];

        return $newsModel;
    }

    private static function construirModeloNoticias(FeedModel $feedModel, Item $simplePieItem){
        $newsModel = new NewsModel();
        
        $newsModel->newsTitle = html_entity_decode($simplePieItem->get_title());
        $newsModel->newsDescription = html_entity_decode($simplePieItem->get_description());
        $newsModel->newsDate = $simplePieItem->get_date('Y-m-d');
        $newsModel->newsUrl = $simplePieItem->get_permalink();
        
        $newsImageURL = $simplePieItem->get_enclosure()->get_link();

        isset($newsImageURL) ? $newsModel->newsImageUrl = $newsImageURL :  $newsModel->newsImageUrl = $feedModel->feedImageUrl;

        $newsModel->feedId = $feedModel->id;

        return $newsModel;
    }

}

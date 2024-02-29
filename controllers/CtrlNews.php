<?php 

namespace Controllers;

use MVC\Router;
use Model\NewsModel;
use Model\FeedModel;
use Model\CategoriesModel;
use SimplePie\SimplePie;
use Controllers\CtrlCategories;
use Controllers\CtrlNewsCategory;

class CtrlNews{

    public static function getNews(){

    }

    public static function updateNews(Router $router){

    }

    public static function registerNews(SimplePie $feed, FeedModel $feeddb ){
        $newsdb = new NewsModel;
        $feedId = $feeddb->id;
        $newsdb->resetAutoIncrement(); 
        foreach ($feed -> get_items() as $item){
            $alerts = [];
            $newsdb->newsTitle = html_entity_decode($item->get_title());
            
            $newsdb->newsDescription = html_entity_decode($item->get_description());
            
            $newsdb->newsDate = $item->get_date('Y-m-d');
            
            $newsdb->newsUrl = $item->get_permalink();
            
            if ($item->get_enclosure()->get_link() == null) {
                $newsdb->newsImageUrl = 'no hay imagen disponible';
            }else {
                $newsdb->newsImageUrl = $item->get_enclosure()->get_link();
            }   
            $newsdb->feedId = $feedId;
            $newsdb->sincroniceEntity();
            $alerts = $newsdb->validar();
            if (empty($alerts)) {
                $newsdb->save();
                $newdb = NewsModel::where('newsUrl',  $item->get_permalink());
                if ($item->get_categories() != null) {
                    
                CtrlCategories::registerCategories($item->get_categories());
                //$newCategory = CategoriesModel::where('categoryName', $item->get_categories());
                //CtrlNewsCategory::registerNewsCategory($newdb, $newCategory);

                }
        }
        }

        

    }
    
}
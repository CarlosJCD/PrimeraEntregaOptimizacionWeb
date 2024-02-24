<?php 

namespace Controllers;

use MVC\Router;
use Model\NewsModel;

class CtrlNews{

    public static function getNews(){

    }

    public static function updateNews(Router $router){

    }

    public static function registerNews($feed, $feeddb ){
        $newsdb = new NewsModel;
        $feedId = $feeddb->id;
        foreach ($feed -> get_items() as $item){
            $newsdb->newsTitle = $item->get_title();
            $newsdb->newsDescription = $item->get_description();
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
                
        }
        }

        header('Location: /feeds');
        
        

    }
    
}
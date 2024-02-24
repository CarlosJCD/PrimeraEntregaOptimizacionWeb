<?php 

namespace Controllers;

use Model\FeedModel;
use Model\NewsModel;
use Controllers\CtrlNews;
use MVC\Router;

class CtrlFeeds{

  
    public static function registerFeed($router ){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $urls = $_POST['url'];
            $feeds = recuperarFeeds($urls);  
            $feeddb = new FeedModel;
            $feeddb->deleteAll();

            
            foreach($feeds as $feed){
                
                $alerts = [];

                $feeddb->feedName = $feed->get_title();
                $feeddb->feedUrl = $feed->get_permalink();
                if ($feed->get_image_url() == null) {
                    $feeddb->feedImageUrl = 'no hay imagen disponible';
                }else {
                    $feeddb->feedImageUrl = $feed->get_image_url();
                }
                $feeddb->feedRss = $feed->subscribe_url();
                $feeddb->sincroniceEntity();
                $alerts = $feeddb->validar();

                if (empty($alerts)) {
                    $feeddb->save();
                    $feedb = FeedModel::where('feedUrl',  $feed->get_permalink());
                    CtrlNews::registerNews($feed, $feedb);
                }
        }
        }else {
                $feeds = null;
                header('Location: /feeds');
            }

          
          
    }

    public static function updateFeed(Router $router){

    }

    public static function deleteFeed(){
        FeedModel::deleteAll();
        header('Location: /feeds'); 
        
    }

    public static function registerFeedCategory($feed, $feeddb){
        //recuperar las categorias
        $categories = $feed->get_categories();
        echo $categories;

    }

    public static function registerNewsCategory(){
        //recuperar la categoria
        $category = $news;

    }


   
}

?>
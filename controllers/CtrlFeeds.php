<?php 

namespace Controllers;

use Model\FeedModel;
use Model\NewsModel;
use Controllers\CtrlNews;
use MVC\Router;

class CtrlFeeds{

  
    public static function registerFeed(){
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
                    $feeddb->feedImageUrl = 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Feed-icon.svg/800px-Feed-icon.svg.png';
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

    private function recuperarFeeds(Array $urls)
{
    $feeds = [];
    foreach($urls as $url) {
        if ($url == '') {
            continue;
        }
        $feed = new SimplePie();
        $feed->set_feed_url($url);
        $feed->enable_cache(false);
        $feed->init();
        $feed->handle_content_type();
        $feeds[] = $feed;
    
    }
   return $feeds;
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
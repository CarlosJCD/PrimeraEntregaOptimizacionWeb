<?php 

namespace Controllers;

use Model\FeedModel;
use Model\NewsModel;
use Model\CategoriesModel;
use SimplePie\SimplePie;
use Controllers\CtrlNews;
use MVC\Router;

class CtrlFeeds{

  
    public static function registerFeed(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $urls = $_POST['url'];
            if (empty($urls)) {
                return header('Location: /news');
            }
            $feeds = self::recuperarFeeds($urls);  
            $feeddb = new FeedModel;
            
            CategoriesModel::deleteAll();
            
            $feeddb->deleteAll();
            $categorydb = new CategoriesModel;
            
            $categorydb->categoryName = 'Sin categoria';
            $categorydb->sincroniceEntity();
            $categorydb->create(); 

            foreach($feeds as $feed){
                
                $alerts = [];

                $exists = FeedModel::where('feedUrl', $feed->get_permalink());  
                if ($exists) {
                    FeedModel::addAlert('repeticion', 'El feed ya existe');
                    $alerts = FeedModel::getAlerts();
                }

                $feeddb->feedName = $feed->get_title();
                $feeddb->feedUrl = $feed->get_permalink();

             
                $feedimageUrl = $feed->get_image_link();
                if ($feed->get_image_link() == $feeddb->feedUrl && !isset($feedimageUrl)){
                    $feedImageUrl = $feed->get_image_url();
                    if (!isset($feedImageUrl) || $feedImageUrl == $feeddb->feedUrl) {
                        $feeddb->feedImageUrl = 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Feed-icon.svg/800px-Feed-icon.svg.png';
                    }
                }

                $feeddb->feedImageUrl = $feedimageUrl;
                

                $feeddb->feedRssUrl = $feed->subscribe_url();
                $feeddb->sincroniceEntity();
                $alerts = $feeddb->validar();

                if (empty($alerts)) {
                    $result = $feeddb->create();  
                    $feedb->id = $result["id"];  
                    CtrlNews::registerNews($feed, $feedb);  
                }
                else{
                    return header('Location: /feeds');
                }

            }
        }else {
                $feeds = null;
                header('Location: /feeds');
            }


          
          
    }

    private static function recuperarFeeds(Array $urls)
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


    public static function deleteFeed(){
        FeedModel::deleteAll();
        CategoriesModel::deleteAll();
        header('Location: /feeds'); 
        
    }

    public static function registerFeedCategory($feed, $feeddb){
        //recuperar las categorias
        $categories = $feed->get_categories();
        echo $categories;

    }


   
}

?>
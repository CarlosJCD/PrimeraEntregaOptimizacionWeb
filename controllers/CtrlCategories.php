<?php 

namespace Controllers;

use MVC\Router;
use Model\NewsModel;
use SimplePie\SimplePie;
use SimplePie\Item;
use Model\FeedModel;
use Model\CategoriesNewsModel;
use Model\CategoriesModel;



class CtrlCategories {

    public static function registerCategories(Array $categories){
            $categorydb = new CategoriesModel;
            
            foreach ($categories as $category) {
                
                $alerts = [];
                $categoryName = $category->get_label();

                $exists = CategoriesModel::where('categoryName', $categoryName);  
                if ($exists) {
                    FeedModel::addAlert('repeticion', 'El feed ya existe');
                    $alerts = FeedModel::getAlerts();
                }

                $categorydb->categoryName = $categoryName;
                $categorydb->sincroniceEntity();
                $alerts = $categorydb->validar();
        

                if (empty($alerts)) {
                    $categorydb->save();
                }
            }

            header('Location: /feeds');
    }



}

    



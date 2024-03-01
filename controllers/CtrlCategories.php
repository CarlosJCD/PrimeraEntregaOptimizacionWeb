<?php 

namespace Controllers;

use MVC\Router;
use Model\NewsModel;
use SimplePie\SimplePie;
use SimplePie\Item;
use Model\FeedModel;
use Model\CategoriesNewsModel;
use Model\CategoriesModel;
use Controllers\CtrlNewsCategory;



class CtrlCategories {

    public static function registerCategories(Array $categories, NewsModel $newdb){
            $categorydb = new CategoriesModel;
            
            foreach ($categories as $category) {
                $exists = null;
                $alerts = [];
                $categoryName = $category->get_label();

                if (str_contains($categoryName, "'")) {
                    $categoryName = str_replace("'", "", $categoryName);
                }

                $exists = CategoriesModel::where('categoryName', " ".$categoryName. " ");  
                if (!$exists) {
                    $categorydb->categoryName = $categoryName;
                    $categorydb->sincroniceEntity();
                    $alerts = $categorydb->validar();
                    $categorydb->create(); 
                }

                $newCategory = CategoriesModel::where('categoryName', " $categoryName ");
                CtrlNewsCategory::registerNewsCategory($newdb, $newCategory);
            }

    }

    public static function registerEmptyCategories(NewsModel $newdb){
        
        $newCategory = CategoriesModel::where('categoryName', ' Sin categoria ');
        CtrlNewsCategory::registerNewsCategory($newdb, $newCategory);
    }

}

    



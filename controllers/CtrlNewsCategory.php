<?php

namespace Controllers;

use MVC\Router;
use Model\CategoriesNewsModel;
use Model\CategoriesModel;
use Model\NewsModel;


class CtrlNewsCategory{


    public static function registerNewsCategory(NewsModel $newsdb, CategoriesModel $categorydb){
        $alerts = [];
        $newsId = $newsdb->id;
        $categoryId = $categorydb->id;
        $newsCategorydb = new CategoriesNewsModel;
        $newsCategorydb->categoryId = $categoryId;
        $newsCategorydb->newsId = $newsId;
        $newsCategorydb->sincroniceEntity();
        $alerts = $newsCategorydb->validar();
        if (empty($alerts)) {
            $newsCategorydb->create();
        }
        header('Location: /feeds');
    }

    
}
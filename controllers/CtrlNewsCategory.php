<?php

namespace Controllers;

use MVC\Router;
use Model\NewsCategoryModel;
use Model\CategoriesModel;
use Model\NewsModel;


class CtrlNewsCategory{


    public static function registerNewsCategory(NewsModel $newsdb, CategoriesModel $categorydb){
        $alerts = [];
        $newsId = $newsdb->id;
        $categoryId = $categorydb->id;
        $newsCategorydb = new NewsCategoryModel;
        $newsCategorydb->categoryId = $categoryId;
        $newsCategorydb->newsId = $newsId;
        $newsCategorydb->sincroniceEntity();
        $alerts = $newsCategorydb->validar();
        if (empty($alerts)) {
            $newsCategorydb->save();
        }
    }

    public static function deleteNewsCategory(NewsModel $newsdb){
        $newsId = $newsdb->id;
        NewsCategoryModel::deleteNewsCategory($newsId);
    }

    public static function deleteCategoryNews(CategoriesModel $categorydb){
        $categoryId = $categorydb->id;
        NewsCategoryModel::deleteCategoryNews($categoryId);
    }

    public static function deleteAll(){
        NewsCategoryModel::deleteAll();
    }
}
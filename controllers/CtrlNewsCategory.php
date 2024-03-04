<?php

namespace Controllers;

use Model\CategoriesNewsModel;

class CtrlNewsCategory
{

    public static function registrarNewsCategory(int $newsId, int $categoryId)
    {

        $categoriesNewsModel = static::construirModeloCategoriesNews($newsId, $categoryId);

        $categoriesNewsModel->create();
    }

    private static function construirModeloCategoriesNews(int $newsId, int $categoryId)
    {
        return new CategoriesNewsModel([
            "newsId" => $newsId,
            "categoryId" => $categoryId
        ]);
    }
}

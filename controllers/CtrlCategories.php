<?php

namespace Controllers;

use Model\NewsModel;
use Model\CategoriesModel;
use Controllers\CtrlNewsCategory;

class CtrlCategories
{

    public static function registrarCategorias(array $simplePieCategories, NewsModel $newsModel)
    {

        foreach ($simplePieCategories as $simplePieCategory) {
            $nombreCategoria = $simplePieCategory->get_label();

            if (str_contains($nombreCategoria, "'")) {
                $nombreCategoria = str_replace("'", "", $nombreCategoria);
            }


            $categoriaRegistrada = CategoriesModel::where('categoryName', " " . $nombreCategoria . " ");

            $categoryModel =  $categoriaRegistrada ?? static::registrarCategoria($nombreCategoria, $newsModel->feedId);

            CtrlNewsCategory::registrarNewsCategory($newsModel->id, $categoryModel->id);
        }
    }

    private static function registrarCategoria(string $nombreCategoria, int $feedId)
    {
        $categoryModel = static::construirModeloCategoria($nombreCategoria, $feedId);
        
        $respuestaDB = $categoryModel->create();
        
        $categoryModel->id = $respuestaDB["id"];
        
        return $categoryModel;
    }

    private static function construirModeloCategoria(string $nombreCategoria, int $feedId)
    {
        $categoryModel = new CategoriesModel();

        $categoryModel->categoryName = $nombreCategoria;

        $categoryModel->feedId = $feedId;

        return $categoryModel;
    }
}

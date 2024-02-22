<?php

namespace Model;

class CategoriesNewsModel extends ActiveRecord{

    protected static $tableName = 'categories-news';

    protected static $primaryKey = ['newsId', 'noCategory', 'categoryId'];

    protected static $dbColumns = ['newsId', 'noCategory', 'categoryId'];

    public int $newsId;
    public int $noCategory;
    public int $categoryId;
    
    

    public function __construct($args = [])
    {
        $this->newsId = $args['newsId'] ?? null;
        $this->noCategory = $args['noCategory'] ?? null;
        $this->categoryId = $args['categoryId'] ?? null;
        
    }

    public function validar() {
        if (!$this->newsd || !filter_var($this->newsId, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'El newsId no puede estar vacio';
        }
        if (!$this->noCategory || !filter_var($this->noCategory, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'El numero de categoría no puede estar vacio';
        }
        if (!$this->categoryId || !filter_var($this->categoryId, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'El categoryId no puede estar vacio';
        }
        return self::$alertas;
    }
}
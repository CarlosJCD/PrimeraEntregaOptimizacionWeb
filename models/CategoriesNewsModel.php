<?php

namespace Model;

class CategoriesNewsModel extends ActiveRecord{

    protected static $tableName = 'categories-news';

    protected static $primaryKey = ['newsId', 'categoryId'];

    protected static $dbColumns = ['newsId', 'categoryId'];

    public ?int $newsId = null;
    public ?int $categoryId = null;
    
    

    public function __construct($args = [])
    {
        $this->newsId = $args['newsId'] ?? null;
        $this->categoryId = $args['categoryId'] ?? null;
        
    }

    public function validar() {
        if (!$this->newsId || !filter_var($this->newsId, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = 'El newsId no puede estar vacio';
        }
        if (!$this->categoryId || !filter_var($this->categoryId, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = 'El categoryId no puede estar vacio';
        }
        return self::$alerts;
    }
}
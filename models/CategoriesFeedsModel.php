<?php

namespace Model;

class CategoriesFeedsModel extends ActiveRecord{

    protected static $tableName = 'categories-feeds';

    protected static $primaryKey = ['feedId', 'noCategory', 'categoryId'];

    protected static $dbColumns = ['feedId', 'noCategory', 'categoryId'];

    public int $feedId;
    public int $noCategory;
    public int $categoryId;
    
    

    public function __construct($args = [])
    {
        $this->feedId = $args['feedId'] ?? null;
        $this->noCategory = $args['noCategory'] ?? null;
        $this->categoryId = $args['categoryId'] ?? null;
        
    }

    public function validar() {
        if (!$this->feedId || !filter_var($this->feedId, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'El feedId no puede estar vacio';
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
<?php

namespace Model;

class CategoriesFeedsModel extends ActiveRecord{

    protected static $tableName = 'categories-feeds';

    protected static $primaryKey = ['feedId', 'categoryId'];

    protected static $dbColumns = ['feedId', 'categoryId'];

    public int $feedId;

    public int $categoryId;
    
    

    public function __construct($args = [])
    {
        $this->feedId = $args['feedId'] ?? null;
        $this->categoryId = $args['categoryId'] ?? null;
        
    }

    public function validar() {
        if (!$this->feedId || !filter_var($this->feedId, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'El feedId no puede estar vacio';
        }
        if (!$this->categoryId || !filter_var($this->categoryId, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'El categoryId no puede estar vacio';
        }
        return self::$alertas;
    }
}
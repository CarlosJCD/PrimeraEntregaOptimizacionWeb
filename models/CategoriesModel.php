<?php

namespace Model;

class CategoriesModel extends ActiveRecord{

    protected static $tableName = 'categories';

    protected static $primaryKey = 'categoryId';

    protected static $dbColumns = ['categoryId', "categoryName"];

    public int $categoryId;
    public string $categoryName;
    

    public function __construct($args = [])
    {
        $this->categoryId = $args['categoryId'] ?? null;
        $this->categoryName = $args['categoryName'] ?? '';
        
    }

    public function validar() {
        if ($this->categoryName == '') {
            self::$alertas['error'][] = 'El nombre de la categoria no puede estar vacio';
        }
        return self::$alertas;
    }
}
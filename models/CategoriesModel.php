<?php

namespace Model;

class CategoriesModel extends ActiveRecord{

    protected static $tableName = 'categories';

    protected static $primaryKey = 'id';

    protected static $dbColumns = ['id', "categoryName"];

    public ?int $id = null;
    public string $categoryName;
    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->categoryName = $args['categoryName'] ?? '';
        
    }

    public function validar() {
        if ($this->categoryName == '') {
            self::$alerts['error'][] = 'El nombre de la categoria no puede estar vacio';
        }
        return self::$alerts;
    }
}
<?php 

namespace Model;

class NewsMode extends ActiveRecord{

    protected static $tableName = 'news';

    protected static $primaryKey = 'newsId';

    protected static $dbColumns = ['newsId', "newsTitle", "newsDescription"];

    public $newsId;
    public $newsTitle;
}

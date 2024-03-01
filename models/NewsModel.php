<?php

namespace Model;

class NewsModel extends ActiveRecord{

    protected static $tableName = 'news';

    protected static $primaryKey = 'id';

    protected static $dbColumns = ['id', "newsTitle", "newsDescription","newsDate", "newsUrl", "newsImageUrl" ,"feedId"];

    public ?int $id = null;
    public string $newsTitle;
    public string $newsDescription;
    public $newsDate;
    public string $newsUrl;
    public string $newsImageUrl;
    public ?int $feedId = null;

    public function __construct($args = [])
    {
        $this->id= $args['id'] ?? null;
        $this->newsTitle = $args['newsTitle'] ?? '';
        $this->newsDescription = $args['newsDescription'] ?? '';
        $this->newsDate = $args['newsDate'] ?? '';
        $this->newsUrl = $args['newsUrl'] ?? '';
        $this->newsImageUrl = $args['newsImageUrl'] ?? '';
        $this->feedId = $args['feedId'] ?? 0;
              
    }

    public function validar() {
       if ($this->newsTitle == '') {
           self::$alerts['error'][] = 'El titulo no puede estar vacio';
       }
       if ($this->newsDescription == '') {
              self::$alerts['error'][] = 'La descripcion no puede estar vacio';
       }
       if ($this->newsDate == '') {
        self::$alerts['error'][] = 'La fecha no puede estar vacio';
       }  
       if ($this->newsUrl == '') {
        self::$alerts['error'][] = 'El link de la noticia es obligatorio';
       }
       if ($this->newsImageUrl == '') {
        self::$alerts['error'][] = 'El link de la imagen es obligatorio';
       }
       if (!$this->feedId || !filter_var($this->feedId, FILTER_VALIDATE_INT)) {
        self::$alerts['error'][] = 'El feed de la noticia es obligatorio';
       }

        return self::$alerts;
    }
}

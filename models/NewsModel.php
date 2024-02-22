<?php

namespace Model;

class NewsModel extends ActiveRecord{

    protected static $tableName = 'news';

    protected static $primaryKey = 'newsId';

    protected static $dbColumns = ['newsId', "newsTitle", "newsDescription","newsDate", "newsUrl", "newsImageUrl", "feedId"];

    public int $newsId;
    public string $newsTitle;
    public string $newsDescription;
    public $newsDate;
    public string $newsLink;
    public string $newsImageLink;
    public int $sourceFeedId;

    public function __construct($args = [])
    {
        $this->newsId = $args['newsId'] ?? null;
        $this->newsTitle = $args['newsTitle'] ?? '';
        $this->newsDescription = $args['newsDescription'] ?? '';
        $this->newsDate = $args['newsDate'] ?? '';
        $this->newsLink = $args['newsUrl'] ?? '';
        $this->newsImageLink = $args['newsImageUrl'] ?? '';
        $this->sourceFeedId = $args['feedId'] ?? 0;
        
    }

    public function validar() {
       if ($this->newsTitle == '') {
           self::$alertas['error'][] = 'El titulo no puede estar vacio';
       }
       if ($this->newsDescription == '') {
              self::$alertas['error'][] = 'La descripcion no puede estar vacio';
       }
       if ($this->newsDate == '') {
        self::$alertas['error'][] = 'La fecha no puede estar vacio';
       }  
       if ($this->newsLink == '') {
        self::$alertas['error'][] = 'El link de la noticia es obligatorio';
       }
       if ($this->newsImageLink == '') {
        self::$alertas['error'][] = 'El link de la imagen es obligatorio';
       }
       if (!$this->sourceFeedId || !filter_var($this->sourceFeedId, FILTER_VALIDATE_INT)) {
        self::$alertas['error'][] = 'El feed de la noticia es obligatorio';
       }
        return self::$alertas;
    }
}

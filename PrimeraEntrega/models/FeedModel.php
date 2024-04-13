<?php 

namespace Model;

class FeedModel extends ActiveRecord{

    protected static $tableName = 'feeds';

    protected static $primaryKey = 'id';

    protected static $dbColumns = ['id', "feedName", "feedUrl", "feedImageUrl", "feedRssUrl"];

    public ?int $id = null;
    public string $feedName;
    public string $feedUrl;
    public string $feedImageUrl;
    public string $feedRssUrl;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->feedName = $args['feedName'] ?? '';
        $this->feedUrl = $args['feedUrl'] ?? '';
        $this->feedImageUrl = $args['feedImageUrl'] ?? '';
        $this->feedRssUrl = $args['feedRssUrl'] ?? '';
        
    }

    public function validar() {
        if ($this->feedName == '') {
            self::$alerts['error'][] = 'El nombre del feed no puede estar vacio';
        }
        if ($this->feedUrl == '') {
               self::$alerts['error'][] = 'La url del feed no puede estar vacio';
        }
        if ($this->feedRssUrl == '') {
            self::$alerts['error'][] = 'La url del rss del feed no puede estar vacio';
        }
        return self::$alerts;
    }
}

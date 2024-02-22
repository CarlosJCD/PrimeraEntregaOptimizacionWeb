<?php 

namespace Model;

class FeedModel extends ActiveRecord{

    protected static $tableName = 'feeds';

    protected static $primaryKey = 'feedId';

    protected static $dbColumns = ['feedId', "feedName", "feedUrl", "feedImageUrl"];

    public int $feedId;

    public string $feedName;

    public string $feedUrl;

    public string $feedImageUrl;


    public function __construct($args = [])
    {
        $this->feedId = $args['feedId'] ?? null;
        $this->feedName = $args['feedName'] ?? '';
        $this->feedUrl = $args['feedUrl'] ?? '';
        $this->feedImageUrl = $args['feedImageUrl'] ?? '';
        
    }

    public function validar() {
        if ($this->feedName == '') {
            self::$alertas['error'][] = 'El nombre del feed no puede estar vacio';
        }
        if ($this->feedUrl == '') {
               self::$alertas['error'][] = 'La url del feed no puede estar vacio';
        }
        if ($this->feedImageUrl == '') {
            self::$alertas['error'][] = 'La url de la imagen del feed no puede estar vacio';
        }
        return self::$alertas;
    }
}

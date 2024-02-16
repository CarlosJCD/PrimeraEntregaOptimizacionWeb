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

}

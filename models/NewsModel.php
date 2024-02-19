<?php

namespace Model;

class NewsModel extends ActiveRecord{

    protected static $tableName = 'news';

    protected static $primaryKey = 'newsId';

    protected static $dbColumns = ['newsId', "newsTitle", "newsDescription", "newsUrl", "newsImageUrl", "newsFeedId"];

    public int $newsId;

    public string $newsTitle;

    public string $newsDescription;

    public string $newsLink;

    public string $newsImageLink;

    public int $sourceFeedId;
}

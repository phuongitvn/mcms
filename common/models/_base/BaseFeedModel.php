<?php
class BaseFeedModel extends EMongoDocument
{
    public $_id;
    public $title;
    public $introtext;
    public $fulltext;
    public $genre;
    public $tags;
    public $views;
    public $thumb;
    public $comments;/*comment count*/
    public $url_source;/*from*/
    public $source;/*from*/
    public $created_datetime;
    public $updated_datetime;
    public $active_datetime;
    public $created_by;
    public $status;/* 1:puplished, 2:deleted, 0:wait approve*/
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function primaryKey()
    {
        return '_id';
    }
    public function getCollectionName()
    {
        return 'feed';
    }
}
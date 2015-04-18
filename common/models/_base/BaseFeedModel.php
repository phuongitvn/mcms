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
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title ,introtext ,fulltext ,genre ,tags ,views ,thumb ,comments ,url_source ,source ,created_datetime ,updated_datetime ,active_datetime ,created_by ,status', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            //array('_id, name, code, description, cat_id, status, created_datetime, updated_datetime, created_by', 'safe', 'on'=>'search'),
        );
    }
}
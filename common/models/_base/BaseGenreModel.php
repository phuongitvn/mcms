<?php
class BaseGenreModel extends EMongoDocument
{
    public $_id;
    public $name;
    public $code;
    public $url_key;
    public $description;
    public $parent;
    public $created_datetime;
    public $updated_datetime;
    public $position;
    public $created_by;
    public $status;/* 0:draft, 1:puplished, 2:deleted*/
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
        return 'genre';
    }
    public function rules()
    {
        return array(
            array('name, code, url_key, description ,parent ,created_datetime ,updated_datetime ,position ,created_by ,status','safe')
        );
    }
}
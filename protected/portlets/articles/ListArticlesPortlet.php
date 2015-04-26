<?php
class ListArticlesPortlet extends CPortlet
{
    public $type='';
    public function run(){
        $data = WebArticlesModel::model()->getMostPopular();
        $this->render('list',compact('data'));
    }
}
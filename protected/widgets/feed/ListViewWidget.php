<?php
class ListViewWidget extends CWidget
{
    public $data = null;
    public $layout='';
    public $title='';
    public $info_extra = true;
    public function run(){
        $view = $this->layout;
        $this->render('listview'.$view, array(
            'data'=>$this->data,
            'title'=>$this->title
        ));
    }
}
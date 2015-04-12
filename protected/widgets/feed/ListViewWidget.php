<?php
class ListViewWidget extends CWidget
{
    public $data = null;
    public function run(){
        $this->render('listview', array(
            'data'=>$this->data
        ));
    }
}
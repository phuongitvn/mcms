<?php
class ActiveDataCommand extends CConsoleCommand
{
    public function actionIndex($genre='')
    {
        $crit = array(
            'conditions'=>array(
                'status'=>array('equals' => 3),
            ),
            'limit'=>10,
            'sort'=>array('_id'=>EMongoCriteria::SORT_ASC),
        );
        if($genre!=''){
            $crit['conditions']['genre'] = array('equals' => $genre);
        }
        $data = TubeVideo::model()->findAll($crit);
        if($data){
            foreach($data as $video){
                $model = TubeVideo::model()->findByPk($video->_id);
                $model->updated_datetime = date('Y-m-d H:i:s');
                $model->status=1;
                $res = $model->save();
                echo $res?"Update status success!":"Update fail";
                echo "\n";
                echo $video->_id;
            }
        }else{
            echo 'Not found content to active'."\n";
        }
    }
}
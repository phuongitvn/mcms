<?php
/**
 * Created by PhpStorm.
 * User: phuongnv
 * Date: 3/12/2015
 * Time: 2:09 AM
 */
//php E:\source\gcms\fan2clip\trunk\console.php VimeoCrawl
class VimeoCrawlCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        try{
            $url = 'https://vimeo.com/channels/staffpicks/videos/sort:date/format:thumbnail';
            $html = file_get_html($url);
            $i=0;
            $f=0;
            foreach ($html->find('#browse_content ol.browse_videos li') as $e) {
                if(is_object($e)) {
                    $link = $e->find("a", 0)->href;
                    $thumb = $e->find("a img", 0)->src;
                    //$title = $e->find("a div.data p.title", 0)->innertext;
                    $title = htmlspecialchars($e->find("a div.data p.title", 0)->plaintext);
                    $vimeoId = $e->id;
                    $vimeoId = str_replace('clip_', '', $vimeoId);
                    if (!empty($vimeoId) && !$this->isExistsCode($vimeoId)) {
                        $tubeLink = new TubeVideoLink();
                        $tubeLink->title = trim($title);
                        $tubeLink->link = trim($link);
                        $tubeLink->code = $vimeoId;
                        $tubeLink->thumb = $thumb;
                        $tubeLink->type = 'vimeo';
                        $tubeLink->status = 0;
                        $tubeLink->created_datetime = date('Y-m-d H:i:s');
                        $res = $tubeLink->save();
                        if($res){
                            $i++;
                        }else{
                            $f++;
                        }
                        $errors = $tubeLink->getErrors();
                    }
                }
            }
            echo $i.' videos added success, '.$f.' videos fail';
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
    //get video detail
    public function actionView()
    {
        try{
            $array = array(
                'conditions'=>array(
                    // field name => operator definition
                    'status'=>array('equals' => 0), // Or 'FieldName1'=>array('>=', 10)
                ),
                'limit'=>10,
                'offset'=>0,
                'sort'=>array('_id'=>EMongoCriteria::SORT_ASC),
            );
            $tubeLink = TubeVideoLink::model()->findAll($array);
            $i=0;
            $f=0;
            foreach ($tubeLink as $vimeo) {
                if ($vimeo->code != '' && !empty($vimeo->link)) {
                    echo $url = 'https://vimeo.com'.$vimeo->link;
                    echo "\n";
                    $html = file_get_html($url);
                    if(is_object($html)) {
                        $description = $html->find('#info p.first', 0)->plaintext;

                        $tubeVideo = new TubeVideo();
                        $tubeVideo->name = $vimeo->title;
                        $tubeVideo->code = $vimeo->code;
                        $tubeVideo->type = $vimeo->type;
                        $tubeVideo->thumb = $vimeo->thumb;
                        $tubeVideo->description = trim($description);
                        $tubeVideo->status = 3;
                        $tubeVideo->cat_id = 1;
                        $tubeVideo->views = 0;
                        $tubeVideo->link_id = $vimeo->_id;
                        $tubeVideo->created_datetime = date('Y-m-d H:i:s');
                        $tubeVideo->updated_datetime = date('Y-m-d H:i:s');
                        $author = rand(1,10);
                        $tubeVideo->created_by = $author;
                        $res = $tubeVideo->save();
                        if($res){
                            $i++;
                        }else{
                            $f++;
                        }
                    }
                }
                //update tube link
                $tubeLinkUpdate = TubeVideoLink::model()->findByPk($vimeo->_id);
                $tubeLinkUpdate->status = 1;
                $tubeLinkUpdate->updated_datetime = date('Y-m-d H:i:s');
                $res2 = $tubeLinkUpdate->save();
                var_dump($res2);
            }
            echo $i.' videos added success, '.$f.' videos fail';
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
    private function isExistsCode($code)
    {
        $c = array(
            'conditions'=>array(
                'code'=>array('equals' => $code)
            ),
            'limit'=>1,
        );
        $video = TubeVideoLink::model()->find($c);
        return $video?true:false;
    }
}
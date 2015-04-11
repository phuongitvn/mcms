<?php
/**
 * Created by PhpStorm.
 * User: phuongnv
 * Date: 3/12/2015
 * Time: 11:33 PM
 */
//php E:\source\gcms\fan2clip\trunk\console.php YoutubeCrawl
class YoutubeCrawlCommand extends CConsoleCommand
{
    public static $_limit_related = 5;
    public function actionIndex($code='', $type='funny')
    {
        try{
            switch($type)
            {
                case 'funny':
                    $genre = 'funny';
                    $tags = 'funny,troll,fail';
                    break;
                case 'kids':
                    $genre = 'kids';
                    $tags = 'music,barbie';
                    break;
                case 'music':
                    $genre = 'music';
                    $tags = 'music,barbie';
                    break;
                default:
                    $genre = 'news';
                    $tags = 'hot news';
                    break;
            }
            if(empty($code)){
                $array = array(
                    'conditions'=>array(
                        // field name => operator definition
                        'status'=>array('equals' => 2), // Or 'FieldName1'=>array('>=', 10)
                        'related'=>array('equals' => 1), // Or 'FieldName1'=>array('>=', 10)
                    ),
                    'limit'=>10,
                    'offset'=>0,
                    'sort'=>array('_id'=>EMongoCriteria::SORT_ASC),
                );
                $tubeLink = TubeVideoLink::model()->findAll($array);
                if($tubeLink){
                    foreach($tubeLink as $tlink){
                        $codes[]=$tlink->code;
                    }
                }
            }else{
                $codes[]=$code;
            }
            //echo '<pre>';print_r($codes);exit;
            foreach($codes as $code) {
                $url = 'https://www.youtube.com/watch?v=' . $code;
                $html = file_get_html($url);
                if (is_object($html)) {
                    $title = $html->find("#watch-header h1 span", 0)->plaintext;
                    $description = $html->find("#eow-description", 0)->innertext;
                    if (!$this->isExistsCode($code)) {
                        $tubeLink = new ConsoleTubeLinkModel();
                        $tubeLink->title = trim($title);
                        $tubeLink->code = $code;
                        $tubeLink->status = 0;
                        $tubeLink->genre = $genre;
                        $tubeLink->tags = $tags;
                        $tubeLink->type = 'youtube';
                        $tubeLink->link = 'https://www.youtube.com/watch?v=' . $code;
                        $tubeLink->related = 1;
                        $res = $tubeLink->add();
                    }else{
                        $c = array(
                            'conditions'=>array(
                                'code'=>array('equals' => $code)
                            ),
                        );
                        $tubeLink = ConsoleTubeLinkModel::model()->find($c);
                        $tubeLink->status=0;
                        $des = $tubeLink->save();
                        echo $des?"$code|update status 0 success":"$code|update status fail";
                        echo "\n";
                    }
                    //related video
                    $i = 0;
                    for ($i = 0; $i < self::$_limit_related; $i++) {
                        echo $i . "\n";
                        if ($i == self::$_limit_related) break;
                        if (is_object($html)) {
                            $title = $html->find("#watch-related li div a span.title", $i)->innertext;
                            $link = $html->find("#watch-related li div a", $i)->href;
                            preg_match("/v=(\w+)/", $link, $match);
                            if (!empty($match)) {
                                $sl = explode('=', $match[0]);
                                $code = $sl[1];
                            }
                            if (!empty($code) && !$this->isExistsCode($code)) {
                                $tubeLink = new ConsoleTubeLinkModel();
                                $tubeLink->title = trim($title);
                                $tubeLink->code = $code;
                                $tubeLink->status = 2;
                                $tubeLink->type = 'youtube';
                                $tubeLink->genre = $genre;
                                $tubeLink->tags = $tags;
                                $tubeLink->link = 'https://www.youtube.com' . $link;
                                $tubeLink->related = 1;
                                $res = $tubeLink->add();
                                if ($res) {
                                    echo 'success' . "\n";
                                } else {
                                    $errors = $res->getErrors();
                                    var_dump($errors);
                                }
                            }
                        }
                        $i++;
                    }
                }else{
                    echo 'Not object|'.$code."\n";
                    $c = array(
                        'conditions'=>array(
                            'code'=>array('equals' => $code)
                        ),
                    );
                    $deleted = ConsoleTubeLinkModel::model()->deleteAll($c);
                    echo $deleted?"$code|deleted success":"$code|deleted fail";
                    echo "\n";
                }
            }
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
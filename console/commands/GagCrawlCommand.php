<?php
/**
 * Created by PhpStorm.
 * User: phuongnv
 * Date: 3/22/2015
 * Time: 4:38 PM
 */
#php E:\source\gcms\fan2clip\trunk\console.php GagCrawl FindLink
ini_set('max_execution_time', 8640000);
ini_set('memory_limit', -1);
class GagCrawlCommand extends CConsoleCommand
{
    public function actionFindLink()
    {
        try{
            $links = array(
                0=>array(
                    'link'=>'http://9gag.tv/channel/prank',
                    'genre'=>'funny',
                    'tags'=>'funny,fail,prank'
                ),
                1=>array(
                    'link'=>'http://9gag.tv/channel/comedy',
                    'genre'=>'funny',
                    'tags'=>'comedy,cute,funny'
                ),
                2=>array(
                    'link'=>'http://9gag.tv/channel/game',
                    'genre'=>'game',
                    'tags'=>'game,funny'
                ),
                3=>array(
                    'link'=>'http://9gag.tv/channel/music',
                    'genre'=>'music',
                    'tags'=>'music,funny'
                ),
                4=>array(
                    'link'=>'http://9gag.tv/channel/movie-and-tv',
                    'genre'=>'tv',
                    'tags'=>'movie,tv,film,trailer'
                ),
				5=>array(
                    'link'=>'http://9gag.tv/channel/cute',
                    'genre'=>'funny',
                    'tags'=>'comedy,cute,funny'
                ),
				6=>array(
                    'link'=>'http://9gag.tv',
                    'genre'=>'hot',
                    'tags'=>'funny,trailer,tv,comedy,cute,music'
                ),
            );
            foreach($links as $link)
            {
                echo '-----------------------'."\n";
                echo 'Link:'.$link['link']."\n";
                $html = file_get_html($link['link']);
                $main = $html->find(".main",0);
                foreach($main->find(".badge-grid-item") as $e){
                    $etitle = $e->find(".item div.info a.title h4",0);
                    if($etitle){
                        //$title = $etitle->innertext;
                        $title = $etitle->plaintext;
                        $url = $e->find(".item div.info a",0)->href;
                    }else{
                        continue;
                    }

                    $html2 = file_get_html($url);
                    $attr = 'data-external-id';
                    $tubeCode = $html2->find("#jsid-post-container",0)->$attr;
					if($html2){
						$checkCode = $this->isExistsCode($tubeCode);
						echo 'Tube Code: '.$tubeCode."\n";
						if(!empty($tubeCode) && !$checkCode) {
							$model = new TubeVideoLink();
							$model->title = trim($title);
							$model->link = trim($url);
							$model->type = 'youtube';
							$model->code = $tubeCode;
							$model->genre = $link['genre'];
							$model->tags = $link['tags'];
							$model->created_datetime = date('Y-m-d H:i:s');
							$model->updated_datetime = date('Y-m-d H:i:s');
							$model->status = 0;
							$res = $model->save();
							echo $res ? "true" : "false";
							echo "\n";
						}else{
							echo 'Not found tube Code or exists code!'."\n";
						}
					}else{
						continue;
					}
                }
            }
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
        exit;
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
<?php
//php E:\source\mcms\trunk\console.php HW Find
class HWCommand extends CConsoleCommand
{
    const _DOMAIN = 'http://www.healthywomen.org';
    public $html='';
    public $content='';
    public function actionTest()
    {
        $link = self::_DOMAIN.'/content/article/top-10-ways-burn-200-calories-under-hour?context=ages-and-stages/14&amp;context_title=';
        $html = file_get_html($link);

        $removePattern = explode('|', 'h3|.node-info-bar');
        foreach ($removePattern as $rpt){
            if($rpt!=''){
                foreach ($html->find("$rpt") as $e)
                {
                    $e->outertext='';
                }
            }
        }
        //echo $html;
        echo $cc = $html->find(".content-left",0)->innertext;
        $content = str_get_html($cc);
        echo "\n";
        echo $content->find("p",0)->plaintext;
    }
    public function actionFind()
    {
        $cat = include_once SITE_PATH.DS.'console'.DS.'config'.DS.'healthywomen.php';
        try{
            foreach($cat as $key => $value) {
                $url = $value['url'];
                echo '##Start Crawl ' . $url . '##' . "\n";
                $content = file_get_html($url);
                $allArticlesCat = array();
                foreach($content->find(".view-content .highlights") as $e){
                    $link = $e->find("a.imagecache",0)->href;
                    $title = $e->find("h3",0)->plaintext;
                    $img = $e->find("a.imagecache img",0)->src;
                    $introtext = $e->find("p",0)->innertext;
                    if(!empty($title)){
                        $allArticlesCat[]=array(
                            'title'=>$title,
                            'link'=>self::_DOMAIN.$link,
                            'img'=>$img,
                            'introtext'=>$introtext,
                            'genre'=>$value['genre'],
                            'source'=>$value['source'],
                            'tags'=>$value['tags'],
                        );
                    }
                }
                //echo '<pre>';print_r($allArticlesCat);
                $articlesRelated = array();
                if(!empty($allArticlesCat)){
                    $data = CrawlDataFactory::makeDataCrawl('HW');
                    $tag=true;
                    $i=0;
                    while($tag){
                        if(isset($allArticlesCat[$i])) {
                            $article = $allArticlesCat[$i];
                            $checkExists = $this->isExists($article['link']);
                            if (!$checkExists) {
                                //foreach($allArticlesCat as $article){
                                $html = array();
                                echo '##Content of ' . $article['link'] . '##' . "\n";
                                $data->setUrl($article['link']);
                                if (empty($articlesRelated)) {
                                    $articlesRelated = $data->getArticlesRelated();
                                    if (!empty($articlesRelated)) {
                                        foreach ($articlesRelated as $key => $d) {
                                            $articlesRelated[$key]['genre'] = $value['genre'];
                                            $articlesRelated[$key]['source'] = $value['source'];
                                            $articlesRelated[$key]['tags'] = $value['tags'];
                                        }
                                        $allArticlesCat = CMap::mergeArray($allArticlesCat, $articlesRelated);
                                        //echo '<pre>';print_r($allArticlesCat);exit;
                                    }
                                }
                                //echo '<pre>';print_r($articlesRelated);exit;
                                $content = $data->getContentBody();
                                $imgThumb = $article['img'];
                                $html['link'] = trim($article['link']);
                                $html['title'] = addslashes($article['title']);
                                $html['introtext'] = trim($article['introtext']);
                                $html['thumb'] = $imgThumb;
                                $html['second_thumb'] = $data->getOtherThumb($content);
                                $html['fulltext'] = $content;
                                $html['source'] = $article['source'];
                                $html['genre'] = $article['genre'];
                                $html['tags'] = $article['tags'];
                                $html['status'] = 0;
                                $res = $this->addToFeed($html);
                                if ($res) {
                                    echo 'id:' . $res . "\n";
                                    //process thumb
                                    if(strpos($html['thumb'],'health2tips')!==false){
                                        $pthumb = $html['thumb'];
                                    }else{
                                        $pthumb = $this->processThumb($res, $html['thumb']);
                                    }
                                    if($pthumb){
                                        $feed = FeedModel::model()->findByPk(new MongoId($res));
                                        $feed->thumb = $pthumb;
                                        $feed->status = 1;
                                        $updateThumb = $feed->save();
                                        echo 'update thumb:'.json_encode($updateThumb)."\n";
                                    }else{
                                        echo 'update thumb: false'."\n";
                                    }

                                }
                                //}
                                $i++;
                            } else {
                                $tag = false;
                            }

                        }else{
                            echo 'This article is exists!'."\n";
                            $tag = false;
                        }
                    }

                }
            }
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
    private function addToFeed($data)
    {
        if(!empty($data['title'])) {
            $feedModel = new FeedModel();
            $feedModel->title = $data['title'];
            $feedModel->introtext = $data['introtext'];
            /*$s = preg_replace("/<p ?.*>SOURCE(.*?)<\/p>/","",$data['fulltext']);
            $s = preg_replace("/<p ?.*>Published(.*?)<\/p>/","",$s);
            $s = preg_replace("/<p ?.*>Copyright(.*?)<\/p>/","",$s);*/
            $feedModel->fulltext = $data['fulltext'];
            $feedModel->thumb = $data['thumb'];
            $feedModel->second_thumb = $data['second_thumb'];
            $feedModel->url_source = $data['link'];
            $feedModel->source = $data['source'];
            $feedModel->genre = $data['genre'];
            $feedModel->comments = 0;
            $feedModel->created_datetime = date('Y-m-d H:i:s');
            $feedModel->updated_datetime = date('Y-m-d H:i:s');
            $author = mt_rand(1,20);
            $feedModel->created_by = $author;
            $feedModel->status = $data['status'];
            $res = $feedModel->save();
            return $feedModel->_id;
        }else{
            echo 'empty article'."\n";
        }
        return false;
    }
    private function isExists($link)
    {
        $c = array(
            'conditions'=>array(
                'url_source'=>array('equals' => $link)
            ),
            'limit'=>1,
        );
        $feed = FeedModel::model()->find($c);
        return $feed?true:false;
    }
    private function processThumb($_id,$imgsrc)
    {
        $storage = Yii::app()->params['feed_path'];
        $temp = Yii::app()->params['temp'];
        $fileInfo = explode('.',$imgsrc);
        $fileType = $fileInfo[count($fileInfo)-1];
        $fileName = 'tmp_'.$_id.".".$fileType;
        $tmpFile = $temp.DS.$fileName;

        $res_get_file = FileRemote::getFromUrl($imgsrc,$tmpFile);
        if ($res_get_file && file_exists($tmpFile)) {
            $fileDest = StorageHelper::generalStoragePath($_id,$fileType,$storage);
            $fileSystem = new Filesystem();
            //$copy = $fileSystem->copy($tmpFile,$fileDest);
            $width = Yii::app()->params['profile_image']['thumb']['width'];
            $height = Yii::app()->params['profile_image']['thumb']['height'];
            $resizeObj = new ResizeImage($tmpFile);
            $resizeObj ->resizeImage($width, $height, 0);
            $resizeObj ->saveImage($fileDest, 100);
            //$resize = $imageCrop->resizeCrop($fileDest,$width,$height);
            $fileSystem->remove($tmpFile);
            if($resizeObj){
                $thumbPath = str_replace($storage,'',$fileDest);
                return $thumbPath;
            }
            return false;
        }
    }
}
<?php
//php E:\source\mcms\trunk\console.php NewsCrawl Find
//include_once SITE_PATH.'/console/components/crawl/CrawlDataFactory.php';
class NewsCrawlCommand extends CConsoleCommand
{
    public function actionFind()
    {
        $wfind = array(
            'cnet'=>array(
                'link'=>'http://www.cnet.com/au/topics/internet/how-to',
                'genre'=>'internet',
                'source'=>'Cnet'
            ),
            'cnet2'=>array(
                'link'=>'http://www.cnet.com/au/topics/phones/how-to/',
                'genre'=>'mobile',
                'source'=>'Cnet'
            ),
            'cnet3'=>array(
                'link'=>'http://www.cnet.com/au/topics/security/how-to/',
                'genre'=>'internet',
                'source'=>'Cnet'
            )
        );
        try{
            foreach($wfind as $key => $value) {
                echo '--Start Crawl '.$key.'--'."\n";
                $content = file_get_html($value['link']);
                $main = $content->find("#topicListing", 0);
                $data = CrawlDataFactory::makeDataCrawl('cnet');
                foreach ($main->find(".asset") as $e) {
                    $html = array();
                    if (is_object($e)) {
                        $link = ($e->find(".assetBody a", 0)) ? $e->find(".assetBody a", 0)->href : "";
                        if (!empty($link)) {
                            $link = 'http://www.cnet.com' . $link;
                            $introtext = ($e->find(".assetBody a .dek", 0)) ? $e->find(".assetBody a .dek", 0)->innertext : "";
                            $imgThumb = ($e->find(".assetThumb a figure img", 0)) ? $e->find(".assetThumb a figure img", 0)->src : "";
                            echo $link . "\n";
                            $html['link'] = $link;
                            $set = $data->setUrl($link);
                            $html['title'] = addslashes($data->getTitle());
                            $html['introtext'] = trim($introtext);
                            //$html['thumb'] = $data->getFirstImage();
                            $html['thumb'] = $imgThumb;
                            $html['fulltext'] = $data->getContentBody();
                            $html['source'] = $value['source'];
                            $html['genre'] = $value['genre'];
                            $html['status']=0;
                        }
                        $res = $this->addToFeed($html);
                        if($res){
                            echo 'id:'.$res."\n";
                            //process thumb
                            $pthumb = $this->processThumb($res,$html['thumb']);
                        }
                        echo "\n";
                    }
                    sleep(2);
                    //exit;
                }
            }
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
        exit;
    }
    private function addToFeed($data)
    {
        if(!empty($data['title']) && !$this->isExists($data['link'])) {
            $feedModel = new FeedModel();
            $feedModel->title = $data['title'];
            $feedModel->introtext = $data['introtext'];
            $feedModel->fulltext = $data['fulltext'];
            $feedModel->thumb = $data['thumb'];
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
            if($resizeObj){
                echo 'copy file success!'."\n";
                $feed = FeedModel::model()->findByPk(new MongoId($_id));
                $thumbPath = str_replace($storage,'',$fileDest);
                $feed->thumb = $thumbPath;
                $feed->status = 1;
                return $feed->save();
            }
        }
    }
}
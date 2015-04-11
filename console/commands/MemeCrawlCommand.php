<?php
ini_set('max_execution_time', 8640000);
ini_set('memory_limit', -1);
class MemeCrawlCommand extends CConsoleCommand
{
    //#php E:\source\gcms\fan2clip\trunk\console.php MemeCrawl
    public function actionIndex()
    {
        $my_file = Yii::app()->params['storage'].DS.'meme_page.txt';
        $handle = fopen($my_file, 'r');
        $page = fread($handle,filesize($my_file));
        $page = intval($page);
        for($i=$page; $i<($page+2); $i++){
            echo $url = 'http://www.lolhappens.com/page/'.$i;
            echo "\n";
            $html = file_get_html($url);
            $content = $html->find(".content-wrap",0);
            foreach($content->find(".social-bar") as $e){
                $e->outertext="";
            };
            //echo $content;exit;
            $storage = Yii::app()->params['storage'];
            $temp = Yii::app()->params['temp'];
            $j=0;
            foreach($content->find(".hentry") as $e){
                $title = $e->find(".post-title h2 a",0)->plaintext;
                $link = $e->find(".post-title h2 a",0)->href;
                $imageUrl = $img = $e->find(".post-content p img",0)->src;
                $fileInfo = explode('.',$img);
                $fileType = $fileInfo[count($fileInfo)-1];
                $fileName = 's_'.$j.'_'.$i.time().".".$fileType;
                $fileDesc = $storage.DS.$fileName;
                $tmpFile = $temp.DS.$fileName;

                if(!$this->isExists($link)) {
                    $res_get_file = FileRemote::getFromUrl($img,$tmpFile);
                    if ($res_get_file && file_exists($tmpFile)) {
                        $meme = new MemeLink();
                        $meme->title = trim($title);
                        $meme->code = trim($link);
                        $meme->link = trim($link);
                        $meme->content = $imageUrl;
                        $meme->type='image';
                        $meme->source = 'lolhappens.com';
                        $meme->status=0;
                        $meme->created_datetime = date('Y-m-d H:i:s');
                        if($meme->save()){
                            //copy file
                            $storage = Yii::app()->params['meme_path'];
                            $mId = $meme->_id;
                            $fileDest = StorageHelper::generalStoragePath($meme->_id,$fileType,$storage);
                            $fileSystem = new Filesystem();
                            $copy = $fileSystem->copy($tmpFile,$fileDest);
                            if($copy){
                                echo 'Copy file success'."\n";
                                $img = str_replace($storage,'',$fileDest);
                                $img = str_replace(DS,'_',$img);
                                $meme->img = $img;
                                $meme->save();
                            }else{
                                if($meme->delete()){
                                    echo 'deleted:'.$mId."\n";
                                }
                            }
                            echo 'save success!'."\n";
                            echo $meme->_id."\n";
                        }else{
                            $error = $meme->getErrors();
                            var_dump($error);
                        }
                    }
                }else{
                    continue;
                }
                echo 'File source:'.$img."<br />";
                echo 'File dest:'.$fileDesc."<br />";
                $j++;
            }
        }

        //write page end
        $data = $i;
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        fwrite($handle, $data);
        fclose($handle);
    }
    public function actionView()
    {
        try{
            $criteria = array(
                'conditions'=>array(
                    // field name => operator definition
                    'status'=>array('equals' => 0), // Or 'FieldName1'=>array('>=', 10)
                ),
                'limit'=>10,
                'offset'=>0,
                'sort'=>array('_id'=>EMongoCriteria::SORT_ASC),
            );
            $memeLink = MemeLink::model()->findAll($criteria);
            if($memeLink){
                foreach($memeLink as $link){
                    $meme = new Meme();
                    $meme->title = $link->title;
                    $meme->content = $link->img;
                    $meme->link_id = $link->_id;
                    $meme->type = $link->type;
                    $meme->source = $link->source;
                    $author = rand(1,20);
                    $meme->created_by = $author;
                    $meme->created_datetime = date('Y-m-d H:i:s');
                    $meme->status=3;
                    $meme->views = 0;
                    $link->status = 1;
                    if($link->save()){
                        $res = $meme->save();
                        echo $res?"success":"fail";
                        echo "\n";
                    }
                }
            }
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
    private function isExists($code)
    {
        $c = array(
            'conditions'=>array(
                'code'=>array('equals' => $code)
            ),
            'limit'=>1,
        );
        $meme = MemeLink::model()->find($c);
        return $meme?true:false;
    }
}
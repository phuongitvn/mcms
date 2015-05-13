<?php
Yii::import('console.components.crawl._base.DataCrawl');
class HW extends DataCrawl
{
    const _DOMAIN = 'http://www.healthywomen.org';
    public function __construct($config)
    {
        $config = array(
            'title_pattern'=>'.content-left h3',
            'content_pattern'=>'.content-left',
            'remove_pattern'=>'.print-link|h3|.item-list|div.node-info-bar',
            'imgavatar_pattern'=>'.imageContainer img'
        );
        //parent::__construct($config);
        $this->config = $config;
    }
    public function getArticlesRelated()
    {
        $blockRelated = $this->html->find("#block-views-related_blocks-block_2",0);
        $data = array();
        if(is_object($blockRelated)){
            foreach($blockRelated->find('.view-content .views-row a') as $e){
                $title = $e->plaintext;
                $link = $e->href;
                //echo $link."\n";
                $html = file_get_html(self::_DOMAIN.$link);
                $contentParttern = $this->config['content_pattern'];
                if(is_object($html)) {
                    $removePattern = explode('|', $this->config['remove_pattern']);
                    foreach ($removePattern as $rpt){
                        if($rpt!=''){
                            foreach ($html->find("$contentParttern $rpt") as $e)
                            {
                                $e->innertext='';
                            }
                        }
                    }

                    $content = $html->find("$contentParttern", 0)->innertext;
                    $content = str_get_html($content);
                    if (is_object($content)) {

                        $img = $content->find("img", 0)->src;
                        if(strpos($img,self::_DOMAIN)===false){
                            $img = self::_DOMAIN.$img;
                        }
                        $tag = true;
                        $i=0;
                        while($tag){
                            $introtext = $content->find("p", $i)->plaintext;
                            if(empty($introtext)){
                                $i++;
                            }else{
                                $tag=false;
                            }
                        }
                        $data[] = array(
                            'title' => $title,
                            'link' => self::_DOMAIN.$link,
                            'img' => $img,
                            'introtext' => $introtext
                        );
                    }
                }
            }
        }
        return $data;
    }
    protected function beforeGetContentBody()
    {
        $sn = time();
        $i=0;
        $tmpFile = $temp = Yii::app()->params['temp'];
        $storage = Yii::app()->params['feed_path'];
        $cdn = Yii::app()->params['cdn_url'];
        $contentParttern = $this->config['content_pattern'];

        foreach($this->html->find("$contentParttern img") as $e) {
            $imgSrc = $e->src;
            if($imgSrc=='http://www.healthywomen.org/sites/default/files/HEALTHDAY_99white.gif'){
                $e->src = SITE_URL.'/images/health2tips_125_83.png';
                $e->height="";
            }elseif (!empty($imgSrc)) {
                if(strpos($imgSrc,self::_DOMAIN)===false){
                    $imgSrc = self::_DOMAIN.$imgSrc;
                }
                $fileInfo = explode('.', $imgSrc);
                $fileType = $fileInfo[count($fileInfo) - 1];
                $fileName = 'tmp_' . $sn . $i . "." . $fileType;
                $sfile = $tmpFile . DS . $fileName;
                $res_get_file = FileRemote::getFromUrl($imgSrc, $sfile);

                if ($res_get_file && file_exists($sfile)) {
                    $fileDest = StorageHelper::generalStoragePath($sn . $i, $fileType, $storage);
                    $fileSystem = new Filesystem();
                    $copy = $fileSystem->copy($sfile, $fileDest);
                    if ($copy) {
                        echo $fileDest . "\n";
                        $fileDestUrl = str_replace($storage,$cdn,$fileDest);
                        $fileDestUrl = str_replace(DS,"/",$fileDestUrl);

                        echo $fileDestUrl . "\n";
                        $e->src = $fileDestUrl;
                        echo 'replace file content success' . "\n";
                    } else {
                        echo 'replace file content error' . "\n";
                    }
                }
                $i++;
            }
        }
    }
    protected function afterGetContentBody()
    {
        $sn = time();
        $tmpFile = $temp = Yii::app()->params['temp'];
        $storage = Yii::app()->params['feed_path'];
        $cdn = Yii::app()->params['cdn_url'];
        $contentParttern = $this->config['content_pattern'];
        $contentPage='';
        $k=0;
        foreach($this->html->find("$contentParttern .item-list ul li") as $e){
            $k++;
        }
        if($k>0){
            $numPage = $k-1;
            for($j=2;$j<$numPage; $j++){
                $link = $this->url.'&page='.$j;
                echo $link."\n";
                $htmlBodyPage = file_get_html($link);
                if(is_object($htmlBodyPage)){
                    if(isset($this->config['remove_pattern']) || !empty($this->config['remove_pattern'])){
                        $removePattern = explode('|', $this->config['remove_pattern']);
                        foreach ($removePattern as $rpt){
                            if($rpt!=''){
                                foreach ($htmlBodyPage->find("$rpt") as $e)
                                {
                                    $e->outertext='';
                                }
                            }
                        }
                    }
                    foreach ($htmlBodyPage->find("a") as $e)
                    {
                        $innerText = $e->plaintext;
                        //$e->outertext = $innerText;
                        $e->href = '#';
                    }
                    //get image for content
                    $i=0;
                    foreach($this->html->find("$contentParttern img") as $e) {
                        $imgSrc = $e->src;
                        if (!empty($imgSrc)) {
                            $fileInfo = explode('.', $imgSrc);
                            $fileType = $fileInfo[count($fileInfo) - 1];
                            $fileName = 'tmp_' . $sn . $i . "." . $fileType;
                            $sfile = $tmpFile . DS . $fileName;
                            $res_get_file = FileRemote::getFromUrl($imgSrc, $sfile);

                            if ($res_get_file && file_exists($sfile)) {
                                $fileDest = StorageHelper::generalStoragePath($sn . $i, $fileType, $storage);
                                $fileSystem = new Filesystem();
                                $copy = $fileSystem->copy($sfile, $fileDest);
                                if ($copy) {
                                    echo $fileDest . "\n";
                                    $fileDestUrl = str_replace($storage,$cdn,$fileDest);
                                    $fileDestUrl = str_replace(DS,"/",$fileDestUrl);

                                    echo $fileDestUrl . "\n";
                                    $e->src = $fileDestUrl;
                                    echo 'replace file content success' . "\n";
                                } else {
                                    echo 'replace file content error' . "\n";
                                }
                            }
                            $i++;
                        }
                    }
                    $contentPage .= $htmlBodyPage->find($this->config['content_pattern'],0)->innertext;


                }
            }
        }
        $this->content .= $contentPage;
    }
}
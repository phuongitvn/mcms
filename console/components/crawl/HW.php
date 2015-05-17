<?php
Yii::import('console.components.crawl._base.DataCrawl');
class HW extends DataCrawl
{
    const _DOMAIN = 'http://www.healthywomen.org';
    const _MY_DOMAIN = 'http://localhost:6969';
    const _ALT = 'Health2Tips';
    public $second_thumb = '';
    public function __construct($config)
    {
        $config = array(
            'title_pattern'=>'.content-left h3',
            'content_pattern'=>'.content-left',
            'remove_pattern'=>'.print-link|h3|.item-list|div.node-info-bar',
            'imgavatar_pattern'=>'.imageContainer img',
            'replace_pattern'=>array(
                'HealthDay News'=>'Health2Tips'
            )
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
                    $replacePattern = $this->config['replace_pattern'];
                    foreach($replacePattern as $key => $value){
                        $content = str_replace($key,$value,$content);
                    }
                    $content = str_get_html($content);
                    if (is_object($content)) {

                        $img = $content->find("img", 0)->src;
                        if(strpos($img,self::_DOMAIN)===false){
                            $img = self::_DOMAIN.$img;
                        }
                        if(strpos($img,'HEALTHDAY_99white.gif')!==false){
                            $img = '/images/health2tips_125_83.png';
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
                            'introtext' =>$this->validString($introtext)
                        );
                    }
                }
            }
        }
        return $data;
    }
    public function getOtherThumb($minzise=300){
        $contentParttern = $this->config['content_pattern'];
        foreach($this->html->find("$contentParttern img") as $e) {
            $imgSrc = $e->src;
            /*if(strpos($imgSrc,self::_MY_DOMAIN)===false){
                $imgSrc = self::_MY_DOMAIN.$imgSrc;
            }*/
            list($width, $height) = getimagesize($imgSrc);
            /*echo $imgSrc."\n";
            echo 'width:'.$width."\n";
            echo 'height:'.$height."\n";
            exit;*/
            if($width>=$minzise){
                return $imgSrc;
            }
        }
        return '';
    }
    protected function validString($str)
    {
        if(strlen($str)>200){
            return FormatHelper::smartCut($str,170,0,'');
        }
        return $str;
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
                $e->alt = self::_ALT;
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
                    list($width, $height) = getimagesize($sfile);
                    if($width>500){
                        //resize image
                        $width=500;
                        $height = 0;
                        $resizeObj = new ResizeImage($sfile);
                        $resizeObj->resizeImage($width, $height);
                        $resizeObj->saveImage($fileDest, 100);
                    }else{
                        //copy file from tmp
                        $fileSystem = new Filesystem();
                        $copy = $fileSystem->copy($sfile, $fileDest);
                    }
                    unlink($sfile);
                    if (file_exists($fileDest)) {
                        echo $fileDest . "\n";
                        $fileDestUrl = str_replace($storage,$cdn,$fileDest);
                        $fileDestUrl = str_replace(DS,"/",$fileDestUrl);
                        echo $fileDestUrl . "\n";
                        //$e->src = $fileDestUrl;
                        $e->outertext = '<img src="'.$fileDestUrl.'" title="'.$e->title.'" alt="'.$e->alt.'" />';
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
                        $e->outertext = $innerText;
                        //$e->href = '#';
                    }
                    //get image for content
                    $i=0;
                    foreach($htmlBodyPage->find("$contentParttern img") as $e) {
                        $imgSrc = $e->src;
                        if (!empty($imgSrc)) {
                            $fileInfo = explode('.', $imgSrc);
                            $fileType = $fileInfo[count($fileInfo) - 1];
                            $fileName = 'tmp_' . $sn . $i . "." . $fileType;
                            $sfile = $tmpFile . DS . $fileName;
                            $res_get_file = FileRemote::getFromUrl($imgSrc, $sfile);

                            if ($res_get_file && file_exists($sfile)) {
                                $fileDest = StorageHelper::generalStoragePath($sn . $i, $fileType, $storage);
                                list($width, $height) = getimagesize($sfile);
                                if($width>500){
                                    $width=500;
                                    $height = 0;
                                    $resizeObj = new ResizeImage($sfile);
                                    $resizeObj->resizeImage($width, $height);
                                    $resizeObj->saveImage($fileDest, 100);
                                }else{
                                    $fileSystem = new Filesystem();
                                    $copy = $fileSystem->copy($sfile, $fileDest);
                                }
                                //resize image
                                unlink($sfile);
                                if (file_exists($fileDest)) {
                                    echo $fileDest . "\n";
                                    $fileDestUrl = str_replace($storage,$cdn,$fileDest);
                                    $fileDestUrl = str_replace(DS,"/",$fileDestUrl);

                                    echo $fileDestUrl . "\n";
                                    //$e->src = $fileDestUrl;
                                    $e->outertext = '<img src="'.$fileDestUrl.'" title="'.$e->title.'" alt="'.$e->alt.'" />';
                                    echo 'replace file content success in page'.$j. "\n";
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
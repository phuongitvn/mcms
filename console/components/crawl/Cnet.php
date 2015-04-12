<?php
Yii::import('console.components.crawl._base.DataCrawl');
class Cnet extends DataCrawl
{
    public function __construct($config)
    {
        $config = array(
            'title_pattern'=>'.articleHead h1',
            'content_pattern'=>'.article-main-body',
            'remove_pattern'=>'figcaption|noscript',
            'imgavatar_pattern'=>'.imageContainer img'
        );
        //parent::__construct($config);
        $this->config = $config;
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
    }
}
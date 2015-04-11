<?php
Yii::import('console.components.crawl._base.DataCrawl');
class Cnet extends DataCrawl
{
    public function __construct($config)
    {
        $config = array(
            'title_pattern'=>'.articleHead h1',
            'content_pattern'=>'.article-main-body',
            'remove_pattern'=>'figcaption',
            'imgavatar_pattern'=>'.imageContainer img'
        );
        parent::__construct($config);
    }
    /*public function __construct($config)
    {
        die('dcm');
        $config = array(
            'title_pattern'=>'.articleHead h1',
            'content_pattern'=>'article-main-body',
            'remove_pattern'=>'figcaption',
            'imgavatar_pattern'=>'.imageContainer img'
        );
        parent::__construct($config);
    }*/
}
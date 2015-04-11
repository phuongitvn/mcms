<?php
Yii::import('application.components.crawl.DataCrawl');
class theverge extends DataCrawl
{
    public function __construct($config)
    {
        $config = array(
            'title_pattern'=>'h1 .instapaper_title',
            'content_pattern'=>'.m-article__entry-section',
            'remove_pattern'=>'.m-article__share-buttons|.video-wrap|.m-article__sources',
            'imgavatar_pattern'=>'.news-image'
        );
        parent::__construct($config);

    }
}
<?php
class BuzzFeed extends DataCrawl
{
    public function __construct($config)
    {
        $config = array(
            'title_pattern'=>'.articleHead h1',
            'content_pattern'=>'article-main-body',
            'remove_pattern'=>'figcaption',
            'imgavatar_pattern'=>'.imageContainer'
        );
        parent::__construct($config);
    }
}
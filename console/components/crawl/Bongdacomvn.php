<?php
Yii::import('application.components.crawl.DataCrawl');
class Bongdacomvn extends DataCrawl
{
	public function __construct($config)
	{
		$config = array(
				'title_pattern'=>'#main-content .post-inner h1',
				'content_pattern'=>'#main-content .post-inner .entry',
				'remove_pattern'=>'.widget-top|.widget-container|.post-source|.text-html-box|.letsop-ads-mobile|#disqus_thread|script',
				'imgavatar_pattern'=>'.art_content img'
		);
		parent::__construct($config);
		
	}
	protected function beforeGetContent()
	{
		parent::beforeGetContent();
		//$modify = $this->html->find("#main-content .post-inner .entry img",0);
		foreach ($this->html->find("#main-content .post-inner .entry img") as $e){
			$src = 'data-src';
			$e->src = $e->$src;
		}
		foreach($this->html->find("#main-content .post-inner .entry .wp-caption") as $e){
			$e->style='';
		}
		/* if($modify){
			$src = $this->getFirstImage();
			if(strpos($src, 'http')===false){
				$modify->src = 'http://www.bongda.com.vn/'.$src;
			}
		} */
	}
	protected function afterGetContent()
	{
		$this->content = str_replace('(BongDa.com.vn)', '(BongDa8.mobi)', $this->content);
	}
	public function getAuthor()
	{
		return 'BongDa.com.vn';
	}
}
<?php
Yii::import('application.components.crawl.DataCrawl');
class BongdasoData extends DataCrawl
{
	public function __construct($config)
	{
		$config = array(
				'title_pattern'=>'.art_title h3',
				'content_pattern'=>'.art_content',
				'remove_pattern'=>'.art_center_banner',
				'imgavatar_pattern'=>'.art_content img'
		);
		parent::__construct($config);
		
	}
	public function test()
	{
		echo '<pre>';print_r($this->config);
	}
	protected function beforeGetContent()
	{
		parent::beforeGetContent();
		$modify = $this->html->find(".art_content img",0);
		if($modify){
			$src = $this->getFirstImage();
			if(strpos($src, 'http')===false){
				$modify->src = 'http://bongdaso.com'.$src;
			}
		}
	}
	/* public function setUrl($url)
	{
		$this->url = $url;
		$this->html = file_get_html($this->url);
		$this->removeElements();
	}
	public function getTitle()
	{
		$title = $this->html->find(".art_title h3",0)->plaintext;
		return $title;
	}
	public function getContentBody()
	{
		$this->html->find(".art_content img",0)->src = 'http://bongdaso.com'.$this->getImageThumb();
		$contentBody = $this->html->find(".art_content",0)->outertext;
		return $contentBody;
	}
	public function getImageThumb()
	{
		$imageUrl = $this->html->find(".art_content img",0)->getAttribute('src');
		return $imageUrl;
	}
	private function removeElements()
	{
		$this->html->find(".art_center_banner",0)->outertext = '';//remove banner in article
	} */
}
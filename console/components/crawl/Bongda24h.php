<?php
class Bongda24h extends DataCrawl
{
	public function __construct($config)
	{
		$config = array(
				'title_pattern'=>'.baiviet-title',
				'content_pattern'=>'.text-conent',
				'remove_pattern'=>'.fb_iframe_widget|script|iframe',
				'imgavatar_pattern'=>'.news-image'
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
		//$this->html->find(".art_content img",0)->src = 'http://bongdaso.com'.$this->getImageThumb();
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
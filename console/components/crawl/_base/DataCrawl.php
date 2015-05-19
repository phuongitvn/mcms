<?php
Yii::import('console.components.crawl._base.AbstractDataCrawl');
class DataCrawl extends AbstractDataCrawl
{
	protected $url = '';
	protected $html = '';
	protected  $config = array();
	public $content = '';
	public function __construct($config)
	{
		$this->config = $config;
	}
	public function setUrl($url)
	{
		$this->url = $url;
		$this->html = file_get_html($this->url);
		if(!$this->html){
			return false;
		}
		//$this->removeElements();
		return true;
	}
	public function getTitle()
	{
		if(!isset($this->config['title_pattern']) || empty($this->config['title_pattern'])){
			throw new Exception('Title pattern is empty', 606);
		}
		$titleParttern = $this->config['title_pattern'];
		$title = ($this->html->find("$titleParttern",0))?$this->html->find("$titleParttern",0)->plaintext:"";
		return $title;
	}
    public function getHtml(){
        return $this->html;
    }
	public function getContentBody()
	{
		if(!isset($this->config['content_pattern']) || empty($this->config['content_pattern'])){
			throw new Exception('Content pattern is empty', 606);
		}
		$contentParttern = $this->config['content_pattern'];
        $this->removeElements();
		$this->beforeGetContentBody();
		$this->content = ($this->html->find("$contentParttern",0))?$this->html->find("$contentParttern",0)->innertext:"";
		$this->afterGetContentBody();
		return $this->content;
	}
	public function getFirstImage()
	{
		$imageUrl = '';
		if(isset($this->config['imgavatar_pattern']) || !empty($this->config['imgavatar_pattern'])){
			$avatarUrlPattern = $this->config['imgavatar_pattern'];
			$imageUrl = ($this->html->find("$avatarUrlPattern",0))?$this->html->find("$avatarUrlPattern",0)->getAttribute('src'):"";
		}
		return $imageUrl;
	}
	protected function removeElements()
	{
		if(isset($this->config['remove_pattern']) || !empty($this->config['remove_pattern'])){
			$removePattern = explode('|', $this->config['remove_pattern']);
			foreach ($removePattern as $rpt){
				if($rpt!=''){
					foreach ($this->html->find("$rpt") as $e)
					{
						$e->outertext='';
					}
				}
			}
		}
        foreach ($this->html->find("a img") as $e)
        {
            $innerText = $e->plaintext;
            $e->outertext = $innerText;
            //$e->href = '#';
        }
		foreach ($this->html->find("a") as $e)
		{
			$innerText = $e->innertext;
			$e->outertext = $innerText;
			//$e->href = '#';
		}
	}
	protected function beforeGetContentBody()
	{
		//
	}
	protected function afterGetContentBody()
	{
		//
	}
}
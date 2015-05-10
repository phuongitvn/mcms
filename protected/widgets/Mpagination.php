<?php
class Mpagination extends CLinkPager
{
	public function init()
	{
		if($this->nextPageLabel===null)
			$this->nextPageLabel=Yii::t('yii','&gt; Next');
		if($this->prevPageLabel===null)
			$this->prevPageLabel=Yii::t('yii','&lt; Prev');
		if($this->firstPageLabel===null)
			$this->firstPageLabel=Yii::t('yii','&lt;&lt; Frist');
		if($this->lastPageLabel===null)
			$this->lastPageLabel=Yii::t('yii','&gt;&gt; Last');
		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='yiiPager';
		//$this->cssFile = Yii::app()->theme->baseUrl.'/css/paper.css';
	}
/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		$buttons[]=$this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);
		if($endPage<($pageCount-2)){
				$buttons[] = '<li>...</li>';
				$k = $pageCount;
				$buttons[] = $this->createPageButton($k,$k-1,self::CSS_INTERNAL_PAGE,false,$k==$currentPage);
		}elseif($endPage==($pageCount-2)){
				$k = $pageCount;
				$buttons[] = $this->createPageButton($k,$k-1,self::CSS_INTERNAL_PAGE,false,$k==$currentPage);
		}
		
		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);

		// last page
		$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);
		
		//$buttons[] = '<li class="counts"><span>'.$this->getResults().'</span></li>';
		return $buttons;
	}
	protected function getResults()
	{
		$counts=$this->getItemCount();
		return Yii::t("frontend","&nbsp;{results} kết quả",array("{results}"=>$counts));
	}
}
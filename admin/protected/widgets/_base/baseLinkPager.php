<?php
Yii::import('system.web.widgets.pagers.CLinkPager');
class baseLinkPager extends CLinkPager
{
	public function init()
	{
		$this->header = '';
		$this->htmlOptions['class']='pagination pagination-sm';
		parent::init();
	}

}

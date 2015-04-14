<?php
Yii::import('zii.widgets.CDetailView');
class baseDetailView extends CDetailView
{
	public function init()
	{
		$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.widgets._base.assets.detailview'),false, -1, YII_DEBUG);
		$this->cssFile=$this->baseScriptUrl.'/detailview.css';
		parent::init();
	}
}
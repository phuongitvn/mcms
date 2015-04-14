<?php
class MenuLeftWidget extends CWidget
{
	public $_active = '';
	public $_item_active = null;
	public $_urlPath = NULL;
	public function init()
	{
		$dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		$this->_urlPath = Yii::app()->getAssetManager()->publish($dir);
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile("{$this->_urlPath}/menuleft.css");
		$cs->registerScriptFile("{$this->_urlPath}/menu_jquery.js");
		parent::init();
	}
	public function run()
	{
		$this->render('default');
	}
}
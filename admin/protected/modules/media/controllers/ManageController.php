<?php
class ManageController extends AdminController
{
	public $_exturl = '';
	public function init()
	{
		parent::init();
		$dir = Yii::app()->basePath.DIRECTORY_SEPARATOR."extensions".DIRECTORY_SEPARATOR."elrte";                       
        $this->_exturl = Yii::app()->getAssetManager()->publish($dir,false, -1, YII_DEBUG);
		$ClientScript = Yii::app()->getClientScript();
		$ClientScript->registerCssFile("{$this->_exturl}/css/smoothness/jquery-ui-1.8.13.custom.css");
		$ClientScript->registerCssFile("{$this->_exturl}/css/elfinder.css");
		$ClientScript->registerScriptFile("{$this->_exturl}/js/jquery-ui-183.min.js");
		$ClientScript->registerScriptFile("{$this->_exturl}/js/elfinder.full.js");
		$this->pageTitle = Yii::t("main","Media Manager");
	}
	public function actionIndex()
	{
		$this->render('index', array('ExtUrl'=>$this->_exturl));
	}
}
<?php
Yii::import('zii.widgets.CPortlet');
class iButtonBar extends CPortlet
{
	public $htmlOptions=array('class'=>'ibuttonbar');
	
	private $_openTag='';
	
	public function init($classCss='')
	{
		if(!empty($classCss)){
			$this->htmlOptions['class'].= ' '.$classCss;
		}
		ob_start();
		ob_implicit_flush(false);
		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$this->htmlOptions['id']=$this->getId();
		$this->renderDecoration();
		echo "<div class=\"buttonbar-content\">\n";

		$this->_openTag=ob_get_contents();
		ob_clean();
	}

	/**
	 * Renders the content of the portlet.
	 */
	public function run()
	{
		$this->renderContent();
		$content=ob_get_clean();
		if($this->hideOnEmpty && trim($content)==='')
			return;
		echo $this->_openTag;
		echo $content;
		echo "</div>\n";
		echo CHtml::closeTag($this->tagName);
	}
}
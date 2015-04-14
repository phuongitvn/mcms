<?php
Yii::import('zii.widgets.CPortlet');
class iPortlet extends CPortlet
{
	public $htmlOptions=array('class'=>'iportlet');
	public $decorationCssClass='iportlet-title';
	
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
		echo "<div class=\"portlet-content\">\n";

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
	/**
	 * Renders the decoration for the portlet.
	 * The default implementation will render the title if it is set.
	 */
	protected function renderDecoration()
	{
		if($this->title!==null)
		{
			echo "<div class=\"{$this->decorationCssClass}\">\n";
						echo "<h3>{$this->title}</h3>\n";
			echo "</div>\n";
		}
	}
}
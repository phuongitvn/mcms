<?php
/**
 * TbButtonColumn class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.8
 */

Yii::import('zii.widgets.grid.CButtonColumn');
/**
 * Bootstrap button column widget.
 * Used to set buttons to use Glyphicons instead of the defaults images.
 */
class iButtonColumn extends CButtonColumn
{
	/**
	 * @var string the view button icon (defaults to 'eye-open').
	 */
	//public $viewButtonIcon = 'eye-open blue';
	public $viewButtonIcon = 'glyphicon glyphicon-search';
	/**
	 * @var string the update button icon (defaults to 'pencil').
	 */
	//public $updateButtonIcon = 'pencil blue';
	public $updateButtonIcon = 'glyphicon glyphicon-pencil';
	/**
	 * @var string the delete button icon (defaults to 'trash').
	 */
	//public $deleteButtonIcon = 'trash blue';
	public $deleteButtonIcon = 'glyphicon glyphicon-remove';

	public $htmlOptions=array('style'=>'width: 50px');
	/**
	 * Initializes the default buttons (view, update and delete).
	 */
	/* protected function initDefaultButtons()
	{
		parent::initDefaultButtons();
	} */
	protected function initDefaultButtons()
	{
		if($this->viewButtonLabel===null)
			$this->viewButtonLabel=Yii::t('zii','View');
		if($this->updateButtonLabel===null)
			$this->updateButtonLabel=Yii::t('zii','Update');
		if($this->deleteButtonLabel===null)
			$this->deleteButtonLabel=Yii::t('zii','Delete');
		if($this->viewButtonImageUrl===null)
			$this->viewButtonImageUrl=$this->grid->baseScriptUrl.'/view.png';
		if($this->updateButtonImageUrl===null)
			$this->updateButtonImageUrl=$this->grid->baseScriptUrl.'/update.png';
		if($this->deleteButtonImageUrl===null)
			$this->deleteButtonImageUrl=$this->grid->baseScriptUrl.'/delete.png';
		if($this->deleteConfirmation===null)
			$this->deleteConfirmation=Yii::t('zii','Are you sure you want to delete this item?');
	
		foreach(array('view','update','delete') as $id)
		{
			$button=array(
					'label'=>$this->{$id.'ButtonLabel'},
					'url'=>$this->{$id.'ButtonUrl'},
					//'imageUrl'=>$this->{$id.'ButtonImageUrl'},
					'icon'=>$this->{$id.'ButtonIcon'},
					'options'=>$this->{$id.'ButtonOptions'},
			);
			if(isset($this->buttons[$id]))
				$this->buttons[$id]=array_merge($button,$this->buttons[$id]);
			else
				$this->buttons[$id]=$button;
		}
	
		if(!isset($this->buttons['delete']['click']))
		{
			if(is_string($this->deleteConfirmation))
				$confirmation="if(!confirm(".CJavaScript::encode($this->deleteConfirmation).")) return false;";
			else
				$confirmation='';
	
			if(Yii::app()->request->enableCsrfValidation)
			{
				$csrfTokenName = Yii::app()->request->csrfTokenName;
				$csrfToken = Yii::app()->request->csrfToken;
				$csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
			}
			else
				$csrf = '';
	
			if($this->afterDelete===null)
				$this->afterDelete='function(){}';
	
			$this->buttons['delete']['click']=<<<EOD
function() {
	$confirmation
	var th = this,
		afterDelete = $this->afterDelete;
	jQuery('#{$this->grid->id}').yiiGridView('update', {
		type: 'POST',
		url: jQuery(this).attr('href'),$csrf
		success: function(data) {
			jQuery('#{$this->grid->id}').yiiGridView('update');
			afterDelete(th, true, data);
		},
		error: function(XHR) {
			return afterDelete(th, false, XHR);
		}
	});
	return false;
}
EOD;
		}
	}
	/**
	 * Renders a link button.
	 * @param string $id the ID of the button
	 * @param array $button the button configuration which may contain 'label', 'url', 'imageUrl' and 'options' elements.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data object associated with the row
	 */
	protected function renderButton($id, $button, $row, $data)
	{
		if (isset($button['visible']) && !$this->evaluateExpression($button['visible'], array('row'=>$row, 'data'=>$data)))
			return;

		$label = isset($button['label']) ? $button['label'] : $id;
		$url = isset($button['url']) ? $this->evaluateExpression($button['url'], array('data'=>$data, 'row'=>$row)) : '#';
		$options = isset($button['options']) ? $button['options'] : array();

		if (!isset($options['title']))
			$options['title'] = $label;

		if (isset($button['icon']))
		{
			if (strpos($button['icon'], 'icon') === false)
				$button['icon'] = 'icon-'.implode(' icon-', explode(' ', $button['icon']));
			echo '<li>';
			echo CHtml::link('<i class="'.$button['icon'].'"></i>&nbsp;'.$label, $url, $options);
			echo '</li>';
		}
		else if (isset($button['imageUrl']) && is_string($button['imageUrl'])){
			echo '<li>';
			echo CHtml::link(CHtml::image($button['imageUrl'], $label)."&nbsp;<span>$label</span>", $url, $options);
			echo '</li>';
		}
		else{
			echo '<li>';
			echo CHtml::link($label, $url, $options);
			echo '</li>';
		}
		
	}
	protected function renderDataCellContent($row,$data)
	{
		$tr=array();
		ob_start();
		echo '<div class="btn-group tbaction">';
		echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="glyphicon glyphicon-cog icon-blue"></i>
			<span class="caret"></span>
			</a>';
		echo '<ul class="dropdown-menu pull-right">';
		foreach($this->buttons as $id=>$button)
		{
			$this->renderButton($id,$button,$row,$data);
			$tr['{'.$id.'}']=ob_get_contents();
			ob_clean();
		}
		echo '</ul></div>';
		ob_end_clean();
		echo strtr($this->template,$tr);
	}
}

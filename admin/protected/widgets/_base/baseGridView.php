<?php

Yii::import('zii.widgets.grid.CGridView');

class baseGridView extends CGridView
{
	/**
	 * @var string|array the table type.
	 * Valid values are 'striped', 'bordered' and/or ' condensed'.
	 */
	public $type;
	/**
	 * @var string the CSS class name for the pager container. Defaults to 'pagination'.
	 */
	public $pagerCssClass = 'pagination';
	/**
	 * @var string the URL of the CSS file used by this grid view.
	 * Defaults to false, meaning that no CSS will be included.
	 */
	public $cssFile = false;

	public $classStyle = 'responsive-table-toggle';
	
	public $pager=array('class'=>'application.widgets._base.baseLinkPager');
	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();
		$assetsGrid=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.widgets._base.assets.gridview'),false, -1, YII_DEBUG);
		Yii::app()->getClientScript()->registerCssFile($assetsGrid.'/gridview.css');
	}

	/**
	 * Creates column objects and initializes them.
	 */
	protected function initColumns()
	{
		foreach ($this->columns as $i => $column)
		{
			if (is_array($column) && !isset($column['class']))
				$this->columns[$i]['class'] = 'baseDataColumn';
		}

		parent::initColumns();
	}
	/**
	 * Renders the data items for the grid view.
	 */
	public function renderItems()
	{
		if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
		{
			echo "<table cellpadding=\"0\" cellspacing=\"0\" class=\"{$this->itemsCssClass} {$this->classStyle}\">\n";
			$this->renderTableHeader();
			ob_start();
			$this->renderTableBody();
			$body=ob_get_clean();
			$this->renderTableFooter();
			echo $body; // TFOOT must appear before TBODY according to the standard.
			echo "</table>";
		}
			else
				$this->renderEmptyText();
	}
	/**
	 * Creates a column based on a shortcut column specification string.
	 * @param mixed $text the column specification string
	 * @return \TbDataColumn|\CDataColumn the column instance
	 * @throws CException if the column format is incorrect
	 */
	protected function createDataColumn($text)
	{
		if (!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/', $text, $matches))
			throw new CException(Yii::t('zii', 'The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));

		$column = new baseDataColumn($this);
		$column->name = $matches[1];

		if (isset($matches[3]) && $matches[3] !== '')
			$column->type = $matches[3];

		if (isset($matches[5]))
			$column->header = $matches[5];

		return $column;
	}
}

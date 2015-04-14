<?php
/**
 * Tbnavbar class file.
 * @author Phuong Nguyen <phuong.nguyen.itvn@gmail.com>
 * @copyright Copyright &copy; 2012
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version 1.0
 */

Yii::import('bootstrap.widgets.TbCollapse');

/**
 * Bootstrap navigation bar widget.
 */
class iNavbar extends CWidget
{
	// inavbar types.
	const TYPE_INVERSE = 'inverse';

	// inavbar fix locations.
	const WIDTH = '226';
	const FIXED_BOTTOM = 'bottom';

	/**
	 * @var string the inavbar type. Valid values are 'inverse'.
	 * @since 1.0.0
	 */
	public $type;
	/**
	* @var boolean whether the nav span over the full width. Defaults to false.
	* @since 0.9.8
	*/
	public $fluid = false;
	/**
	 * @var boolean whether to enable collapsing on narrow screens. Default to false.
	 */
	public $collapse = false;
	/**
	 * @var array navigation items.
	 * @since 0.9.8
	 */
	public $items = array();
	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		$classes = array('inavbar');

		if (isset($this->type) && in_array($this->type, array(self::TYPE_INVERSE)))
			$classes[] = 'inavbar-'.$this->type;

		if (!empty($classes))
		{
			$classes = implode(' ', $classes);
			if (isset($this->htmlOptions['class']))
				$this->htmlOptions['class'] .= ' '.$classes;
			else
				$this->htmlOptions['class'] = $classes;
		}
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::openTag('div', $this->htmlOptions);
		echo '<div class="inavbar-inner">';


		foreach ($this->items as $item)
		{
			if (is_string($item))
				echo '<ul class="flat-list nav"><li>'.$item.'</li></ul>';
			else
			{
				if (isset($item['class']))
				{
					$className = $item['class'];
					unset($item['class']);

					$this->controller->widget($className, $item);
				}
			}
		}
		echo '</div></div>';
	}

	/**
	 * Returns the inavbar container CSS class.
	 * @return string the class
	 */
	protected function getContainerCssClass()
	{
		return $this->fluid ? 'container-fluid' : 'container';
	}
}

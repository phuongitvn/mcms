<?php
/**
 * Tbnavbox class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.7
 */

Yii::import('bootstrap.widgets.TbCollapse');

/**
 * Bootstrap navigation bar widget.
 */
class iNavbox extends CWidget
{
	// navbox types.
	const TYPE_INVERSE = 'inverse';

	// navbox fix locations.
	const WIDTH = '226';
	const FIXED_BOTTOM = 'bottom';

	/**
	 * @var string the navbox type. Valid values are 'inverse'.
	 * @since 1.0.0
	 */
	public $type;
	/**
	 * @var string the text for the brand.
	 */
	public $brand;
	/**
	 * @var string the URL for the brand link.
	 */
	public $brandUrl;
	/**
	 * @var array the HTML attributes for the brand link.
	 */
	public $brandOptions = array('class'=>'section-head');
	/**
	 * @var mixed fix location of the navbox if applicable.
	 * Valid values are 'top' and 'bottom'. Defaults to 'top'.
	 * Setting the value to false will make the navbox static.
	 * @since 0.9.8
	 */
	public $width = self::WIDTH;
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
		if ($this->brand !== false)
		{
			if (!isset($this->brand))
				$this->brand = CHtml::encode(Yii::app()->name);

			if (!isset($this->brandUrl))
				$this->brandUrl = Yii::app()->homeUrl;

			$this->brandOptions['href'] = CHtml::normalizeUrl($this->brandUrl);

			if (isset($this->brandOptions['class']))
				$this->brandOptions['class'] .= ' brand';
			else
				$this->brandOptions['class'] = 'brand';
		}

		$classes = array('navbox');

		if (isset($this->type) && in_array($this->type, array(self::TYPE_INVERSE)))
			$classes[] = 'navbox-'.$this->type;

		if ($this->width !== false)
			$this->htmlOptions['style'] = "width:{$this->width}px";

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
		echo '<div class="navbox-inner">';

		if ($this->brand !== false){
			echo '<ul class="menu-box"><li class="section">';
			echo CHtml::openTag('a', $this->brandOptions).$this->brand.'</a>';
		}

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
		if ($this->brand !== false){
			echo '</li></ul>';
		}
		echo '</div></div>';
	}

	/**
	 * Returns the navbox container CSS class.
	 * @return string the class
	 */
	protected function getContainerCssClass()
	{
		return $this->fluid ? 'container-fluid' : 'container';
	}
}

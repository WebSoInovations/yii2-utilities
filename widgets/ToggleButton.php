<?php
namespace webso\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class ToggleButton extends Widget
{
	public $url;

	public $attribute;

	public $value;

	public $grid;

	private $button;

	public function init()
	{
		parent::init();
		$this->button = Html::a(Html::tag('span', '', [
			'class' => $this->value == 1 ? 'fa fa-check-circle text-success' : 'fa fa-times-circle text-danger'
		]), (empty($this->url) ? '#' : $this->url), [
			'onclick' => "return $(this).button.toggle('{$this->url}', '{$this->grid}');"
		]);
	}

	public function run()
	{
		return Html::decode($this->button);
	}
}
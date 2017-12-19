<?php
namespace webso\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class UpdateButton extends Widget
{
	public $url;

	private $button;

	public function init()
	{
		parent::init();
		$this->button = Html::a(Html::tag('span', '', [
			'class' => 'fa fa-pencil'
		]), (empty($this->url) ? '#' : $this->url), [
			'title' => 'Actualizar'
		]);
	}

	public function run()
	{
		return Html::decode($this->button);
	}
}
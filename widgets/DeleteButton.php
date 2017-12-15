<?php
namespace webso\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class DeleteButton extends Widget
{
	public $url;

	public $grid;

	private $button;

	public function init()
	{
		parent::init();
		$this->button = Html::a(Html::tag('span', '', [
			'class' => 'ws-delete fa fa-trash text-danger'
		]), '#');
	}

	public function run()
	{
		$this->getView()->registerJs("
			$('.ws-delete').click(function(){
				$('.ws-confirm').addClass('is-visible');
				$('.ws-confirm-buttons li a[role=\"ok\"]').attr('href', '$this->url');
			});
		");
		return Html::decode($this->button);
	}
}
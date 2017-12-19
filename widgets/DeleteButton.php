<?php
namespace webso\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class DeleteButton extends Widget
{
	public $url;

	public $grid;

	public $confirm_id;

	private $button;

	public function init()
	{
		parent::init();
		$this->confirm_id = isset($this->confirm_id) ? $this->confirm_id : 'ws-confirm-delete';
		$this->button = Html::a(Html::tag('span', '', [
			'class' => 'fa fa-trash text-danger'
		]), '#', [
			'class' => 'ws-delete',
			'title' => 'Eliminar',
			'onclick' => "
				var confirm = $('#$this->confirm_id')
				confirm.addClass('is-visible');
				confirm.find('.ws-confirm-buttons li a[role=\'ok\']')
				.attr('href', '$this->url')
				.attr('data-grid', '#$this->grid');
			"
		]);
	}

	public function run()
	{
		return Html::decode($this->button);
	}
}
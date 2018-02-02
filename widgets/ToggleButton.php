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
			'onclick' => "
				$.ajax({
					url:$(this).attr('href'),
					method:'PUT',
					success:function(data){
						var response = JSON.parse(data);
						$.notify({
							title:response.message.title + '<hr class=\'kv-alert-separator\'>',
							icon:response.message.icon,
							message:response.message.body
						}, {
							type:response.message.type
						});
						var grid = '#$this->grid';
						if ($(grid).length > 0) {
							$.pjax.reload({
								container:grid
							});
						}
					}
				});
				return false;
			"
		]);
	}

	public function run()
	{
		return Html::decode($this->button);
	}
}
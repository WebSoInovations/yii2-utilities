<?php
namespace webso\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class ViewButton extends Widget
{
	public $url;

	private $button;

	public function init()
	{
		parent::init();
		$this->button = Html::a(Html::tag('span', '', [
			'class' => 'fas fa-external-link-alt'
		]), (empty($this->url) ? '' : $this->url), [
			'class' => 'ws-view',
			'title' => 'Detalles',
			'data' => [
				'view' => uniqid()
			],
			'onclick' => "
				var obj = $(this); 
				var view = $('#'+obj.data('view')); 
				if (view.length > 0) {
					if (view.is(':visible')) {
						view.hide();
					} else {
						view.show();
					}
				} else {
					var url = obj.attr('href');
					$.ajax({
						url:url,
						method:'GET',
						success:function(data){
							var view = $('<td id='+obj.data('view')+' colspan=\'10\'>'+data+'</td>');
							view.hide();
							obj.parent().parent().after(view);
							view.show();
						},
						error:function(){
							$.notify({
		                        title:'Operación no Válida!<hr class=\'kv-alert-separator\'>',
		                        icon:'fa fa-exclamation-circle',
		                        message:'Ocurrió un error al realizar la petición, favor de intentar mas tarde.'
		                    }, {
		                        type:'error'
		                    });
						}
					});
				}
				return false;
			"
		]);
	}

	public function run()
	{
		return Html::decode($this->button);
	}
}
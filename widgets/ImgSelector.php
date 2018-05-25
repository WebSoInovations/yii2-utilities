<?php
namespace webso\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class ImgSelector extends Widget
{
	public $model;

	public $attribute;

	public $directory;

	public $actionUp;

	protected $files;

	public function init()
	{
		$path = \Yii::getAlias('@webroot')."/$this->directory";
		if (is_dir($path)) {
			$this->files = array_map(function($item) {
				return \Yii::$app->getUrlManager()->hostInfo.'/'.$this->directory.'/'.basename($item);
			} ,\yii\helpers\FileHelper::findFiles($path, [
				'only' => ['*.svg', '*.jpg', '*.png']
			]));
		}
		parent::init();
	}

	public function run()
	{
		$url_img = \Yii::$app->getUrlManager()->hostInfo.'/'.$this->directory.'/';
		$this->getView()->registerJs("
			$('.ws-selector-add').each(function(){
				var parent = $(this).parent();
				new AjaxUpload($(this), {
			        action:'$this->actionUp',
			        name:'file',
			        data:{
			            _csrf:'".\Yii::$app->request->csrfToken."'
			        },
			        onSubmit:function(file, ext){
			            if (!(ext && /^(svg|jpg|png)$/.test(ext))) {
			                $.notify({
			                    title:'Importante!<hr class=\'kv-alert-separator\'>',
			                    icon:'fa fa-exclamation-circle',
			                    message:'El archivo debe ser un <strong>zip</strong>.'
			                }, {
			                    type:'warning'
			                });
			                return false;
			            }
			            $('#ws-spinner').fadeIn(200);
			        },
			        onComplete: function(file, data){
			            var response = JSON.parse(data);
			            $('#ws-spinner').fadeOut(200);
			            if (!response.success) {
			            	$.notify({
			                    title:response.message.title+'<hr class=\'kv-alert-separator\'>',
			                    icon:response.message.icon,
			                    message:response.message.body
			                }, {
			                    type:response.message.type
			                });
			            } else {
			            	var div = $('<div></div>');
			            	div.addClass('ws-selector-item');
			            	div.attr('data-url', '$url_img'+response.filename);
			            	div.append('<img src=\"$url_img'+response.filename+'\"/>');
			            	div.click(function(){
								$('.ws-selector-item').removeClass('ws-selector-selected');
								$(this).addClass('ws-selector-selected');
								$('.ws-selector-img input').val($(this).data('url'));
		            		});
			            	div.appendTo(parent);
			            }
			        }
			    });
			});
		");
		$this->getView()->registerCss("
			.ws-selector-img {
				display:flex;
				flex-wrap:wrap;
				background-color:#fff;
				width:100%;
				height:300px;
				border:1px solid #ccc;
				border-radius:5px;
				overflow-y: auto;
			}
			.ws-selector-item {
				width:250px;
				height:150px;
				border:1px solid #ccc;
				margin:5px;
				cursor:pointer;
			}
			.ws-selector-item img{
				width:100%;
				height:100%;
			}
			.ws-selector-add {
				display:flex;
				background-color:#e6e6e6;
				color:#999999;
				font-size:30px;
				justify-content:center;
				align-items:center;
			}
			.ws-selector-selected {
				border:2px solid #00a65a;
			}
		");
		$selector = Html::beginTag('div', [
			'class' => 'ws-selector-img'
		]);
		$selector .= Html::activeInput('hidden', $this->model, $this->attribute);
		$selector .= Html::tag('div', '<span class="fas fa-plus"></span>', [
			'class' => 'ws-selector-item ws-selector-add'
		]);
		foreach ($this->files as $file) {
			$selector .= Html::tag('div', '<img src="'.$file.'"/>', [
				'class' => 'ws-selector-item',
				'data' => [
					'url' => $file
				],
				'onclick' => "
					$('.ws-selector-item').removeClass('ws-selector-selected');
					$(this).addClass('ws-selector-selected');
					$('.ws-selector-img input').val($(this).data('url'));
				"
			]);
		}
		$selector .= Html::endTag('div');
		return $selector;
	}
}
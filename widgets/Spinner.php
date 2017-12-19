<?php
namespace webso\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class Spinner extends Widget
{
	public $id;

	private $spinner;

	public function init()
	{
		$this->id = isset($this->id) ? $this->id : 'ws-spinner';
		$this->spinner = Html::beginTag('div', [
			'id' => $this->id
		]);
		$this->spinner .= Html::beginTag('div', [
			'class' => 'ws-spinner-wrapper'
		]);
		$this->spinner .= Html::beginTag('div', [
			'class' => 'ws-spinner-content'
		]);
		$this->spinner .= Html::tag('p', '<h2>Procesando</h2>');
		$this->spinner .= Html::tag('p', '<span class="fa fa-spinner fa-pulse fa-5x fa-fw"></span>');
		$this->spinner .= Html::tag('p', 'Favor de esperar');
		$this->spinner .= Html::endTag('div');
		$this->spinner .= Html::endTag('div');
		$this->spinner .= Html::endTag('div');
		$this->spinner .= Html::style('
			#ws-spinner {
	    		display:none;
	    		color:#7f7f7f;
			}
			#ws-spinner .ws-spinner-wrapper {
			    background-color: transparent;
			    position: fixed;
			    display: flex;
			    justify-content: center;
			    align-items: center;
			    width: 100%;
			    height: 100%;
			    z-index: 1030;
			}
			#ws-spinner .ws-spinner-content {
			    background-color: #fff;
			    width: 250px;
			    height: 220px;
			    padding: 20px 0;
			    text-align: center;
			    border: 1px solid #e6e6e6;
			    border-radius: 5px;
		}');
	}

	public function run()
	{
		$this->getView()->registerJs("
			$(document).ready(function(){
				$('#$this->id').fadeOut(200);
			});
			$(document).on({
				ajaxStart:function(){
					$('#$this->id').fadeIn(200);
				},
				ajaxStop:function(){
					$('#$this->id').fadeOut(200);
				}
			});
		");
		return Html::decode($this->spinner);
	}
}
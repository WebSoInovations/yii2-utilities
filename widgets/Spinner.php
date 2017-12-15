<?php
namespace webso\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class Spinner extends Widget
{
	private $spinner;

	public function init()
	{
		$this->spinner = Html::beginTag('div', [
			'id' => 'ws-spinner'
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
			}
			#ws-spinner .ws-spinner-wrapper {
			    background-color: rgba(0, 0, 0, 0.5);
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
		return Html::decode($this->spinner);
	}
}
<?php
namespace webso\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class Confirm extends Widget
{
	private $confirm;

	public $message;

	public $buttonOk;

	public function init()
	{
		$this->confirm = Html::beginTag('div', [
			'class' => 'ws-confirm',
			'role' => 'alert'
		]);
		$this->confirm .= Html::beginTag('div', [
			'class' => 'ws-confirm-content'
		]);
		$this->confirm .= Html::tag('p', (isset($this->message) ? $this->message : '¿Está seguro de querer eliminar el registro?'));
		$this->confirm .= Html::ul([
			Html::a('Aceptar', '#', [
				'role' => 'ok',
				'data' => [
					'method' => isset($buttonOk['method']) ? $buttonOk['method'] : 'DELETE'
				]
			]), 
			Html::a('Cancelar', '#', [
				'role' => 'cancel'
			])
		], [
			'class' => 'ws-confirm-buttons'
		]);
		$this->confirm .= Html::a(Html::tag('span', '', [
			'class' => 'fa fa-remove'
		]), '#', [
			'class' => 'ws-confirm-close',
		]);
		$this->confirm .= Html::endTag('div');
		$this->confirm .= Html::endTag('div');
	}

	public function run()
	{
		$this->getView()->registerCss('
			.ws-confirm {
			 	position: fixed;
			 	display: flex;
    			justify-content: center;
    			align-items: center;
				left: 0;
				top: 0;
				height: 100%;
				width: 100%;
				background-color: rgba(94, 110, 141, 0.9);
				opacity: 0;
				visibility: hidden;
				-webkit-transition: opacity 0.3s 0s, visibility 0s 0.3s;
				-moz-transition: opacity 0.3s 0s, visibility 0s 0.3s;
				transition: opacity 0.3s 0s, visibility 0s 0.3s;
				z-index:1030;
			}
			.ws-confirm.is-visible {
	  		 	opacity: 1;
  				visibility: visible;
  				-webkit-transition: opacity 0.3s 0s, visibility 0s 0s;
  				-moz-transition: opacity 0.3s 0s, visibility 0s 0s;
  				transition: opacity 0.3s 0s, visibility 0s 0s;
			}
			.ws-confirm-content {
		  		position: relative;
				width: 90%;
				max-width: 500px;
				margin: 4em auto;
				background: #FFF;
				border-radius: .25em .25em .4em .4em;
				text-align: center;
				box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
				-webkit-transform: translateY(-40px);
				-moz-transform: translateY(-40px);
				-ms-transform: translateY(-40px);
				-o-transform: translateY(-40px);
				transform: translateY(-40px);
				-webkit-backface-visibility: hidden;
				-webkit-transition-property: -webkit-transform;
				-moz-transition-property: -moz-transform;
				transition-property: transform;
				-webkit-transition-duration: 0.3s;
				-moz-transition-duration: 0.3s;
				transition-duration: 0.3s;
			}
			.ws-confirm-content p {
  				padding: 2em 1em;
  				color:#7f7f7f;
  				font-size:1.5em;
			}
			.ws-confirm-buttons {
				display:flex;
				padding:0;
				margin:0;
			}
			.ws-confirm-buttons li {
				display: inline-block;
				width:50%;
			}
			.ws-confirm-buttons li a {
				display: block;
				padding: 1.5em 0;
				text-transform: uppercase;
			}
			.ws-confirm-buttons li a:hover {
				filter: brightness(0.96);
				transition: 0.3s filter;
			}
			.ws-confirm-buttons li:first-child a{
				background-color: #dff0d8;
				color:#3c763d;
			}
			.ws-confirm-buttons li:last-child a{
				background-color: #f2dede;
				color:#a94442;
			}
			.ws-confirm-close {
				position:absolute;
				top:0.5em;
				right:1em;
				color:#7f7f7f;
			}
			.is-visible .ws-confirm-content {
	  			-webkit-transform: translateY(0);
				-moz-transform: translateY(0);
				-ms-transform: translateY(0);
				-o-transform: translateY(0);
				transform: translateY(0);
			}
		');
		$this->getView()->registerJs('
			$(".ws-confirm-close").click(function(){
				$(".ws-confirm").removeClass("is-visible");
			});
			$(".ws-confirm-buttons li a[role=\'cancel\']").click(function(){
				$(".ws-confirm").removeClass("is-visible");
			});
		');
		return Html::decode($this->confirm);
	}
}
<?php
namespace webso;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use kartik\widgets\Growl;

class GrowlFlash extends Component
{
	const SUCCESS_MESSAGE = 'El proceso se realizó correctamente.';
	const ERROR_MESSAGE = 'Ocurrió un error en el proceso.';
	const INFO_MESSAGE = 'Favor de esperar a que el proceso finalice.';
	const WARNING_MESSAGE = 'El proceso pudo no ser realizado correctamente.';
	const DEFAULT_MESSAGE = 'No olvides cerrar tu sesión del sistema al terminar.';

	private $success = [
		'type' => Growl::TYPE_SUCCESS,
		'title' => 'Operación Exitosa!',
		'icon' => 'fa fa-check-circle-o',
		'showSeparator' => true,
	];

	private $error = [
		'type' => Growl::TYPE_DANGER,
		'title' => 'Operación no Válida!',
		'icon' => 'fa fa-times-circle-o',
		'showSeparator' => true,
	];

	private $info = [
		'type' => Growl::TYPE_INFO,
		'title' => 'Importante!',
		'icon' => 'fa fa-info',	
		'showSeparator' => true,
	];

	private $warning = [
		'type' => Growl::TYPE_WARNING,
		'title' => 'Advertencia!',
		'icon' => 'fa fa-exclamation-circle',
		'showSeparator' => true
	];

	private $default = [
		'type' => Growl::TYPE_MINIMALIST,
		'title' => 'Información!',
		'showSeparator' => true
	];

	private function message($type)
	{
		$options = [
			'success' => self::SUCCESS_MESSAGE,
			'error' => self::ERROR_MESSAGE,
			'info' => self::INFO_MESSAGE,
			'warning' => self::WARNING_MESSAGE,
			'default' => self::DEFAULT_MESSAGE
		];
		return (array_key_exists($type, $options) ? $options[$type] : self::DEFAULT_MESSAGE);
	}

	public function set($type = 'default', $message = null)
	{
		$options = [
			'success' => self::SUCCESS_MESSAGE,
			'error' => self::ERROR_MESSAGE,
			'info' => self::INFO_MESSAGE,
			'warning' => self::WARNING_MESSAGE,
			'default' => self::DEFAULT_MESSAGE
		];
		Yii::$app->session->setFlash($type, (!is_null($message) ? $message : $this->message($type)));
	}

	public function json($type, $message = null)
	{
		if(property_exists(__CLASS__, $type)) {
			$data = $this->$type;
		} else {
			$data = $this->default;
		}
		$data['body'] = !is_null($message) ? $message : $this->message($type);
		return $data;
	}


	public function success($message = null)
	{
		$this->success['body'] = !is_null($message) ? $message : self::SUCCESS_MESSAGE;
		return Growl::widget($this->success);
	}

	public function error($message = null)
	{
		$this->error['body'] = !is_null($message) ? $message : self::ERROR_MESSAGE;
		return Growl::widget($this->error);
	}

	public function info($message = null)
	{
		$this->info['body'] = !is_null($message) ? $message : self::INFO_MESSAGE;
		return Growl::widget($this->info);
	}

	public function warning($message = null)
	{
		$this->warning['body'] = !is_null($message) ? $message : self::WARNING_MESSAGE;
		return Growl::widget($this->warning);	
	}

	public function default($message = null) 
	{
		$this->default['body'] = !is_null($message) ? $message : self::DEFAULT_MESSAGE;
		return Growl::widget($this->default);
	}

	public function show() 
	{
		foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
			$method = method_exists($this, $key) ? "self::$key" : 'self::default';
			echo call_user_func($method, $message);
		}
	}	
}

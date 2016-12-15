<?php

/**
 *
 * @author   Falko Matthies <falko.m@web.de>
 * @since    2016-12-15
 */
class WuWeatherStandardRenderer extends WuWeatherRenderer
{
	/**
	 * @var string
	 */
	public $feature = '';

	/**
	 * @var string
	 */
	public $templateFile = '';

	/**
	 * @var bool
	 */
	public $use_fahrenheit = false;

	/**
	 * @var WuWeatherStandardResponseModel
	 */
	public $response = null;

	protected function _check()
	{
		$this->_checkResponse();

		$this->_checkVersion();
		
		if(!empty($this->feature))
		{
			$this->_checkFeature();
		}

		$this->_checkTemplate();
	}

	protected function _checkResponse()
	{
		if( is_null($this->response) )
		{
			throw new InvalidArgumentException("response not set");
		}
		elseif( !is_object($this->response) )
		{
			throw new InvalidArgumentException("response must be an object");
		}
		elseif( !($this->response instanceof WuWeatherStandardResponseModel) )
		{
			throw new InvalidArgumentException("response must be an instance of class WuWeatherStandardResponseModel");
		}
	}

	protected function _checkFeature()
	{
		if( true !== $this->response->response->features->{$this->feature} )
		{
			throw new RuntimeException(sprintf("feature (%s) unknown", $this->feature));
		}
	}

	protected function _checkVersion()
	{
		if( $this->response->response->version !== self::WU_WEATHER_VERSION )
		{
			throw new RuntimeException(sprintf("invalid wu weather version (%s) in response", $this->_unifiedResponse->response->version));
		}
	}
	
	protected function _checkTemplate()
	{
		if( empty($this->templateFile) )
		{
			throw new RuntimeException("templateFile must not be empty");
		}
	}

	/**
	 * Executes the widget.
	 * This method is called by {@link CBaseController::endWidget}.
	 */
	public function run()
	{
		$this->_check();

		$this->render($this->templateFile, array(
			'response'       => $this->response,
			'use_fahrenheit' => $this->use_fahrenheit,
		));
	}

}

?>
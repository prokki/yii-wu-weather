<?php

/**
 * Class WuWeatherRequest
 * 
 * ( $this->_format === "xml" ) ? simplexml_load_string($_response) : json_decode($_response);
 */
abstract class WuWeatherRequest
{

	/**
	 * Most API features can be accessed using the following format.
	 *
	 * @var WuWeather
	 */
	protected $_component = null;

	/**
	 * Most API features can be accessed using the following format.
	 *
	 * @var string
	 */
	protected $_url = "";

	/**
	 * json|xml
	 * @var string
	 */
	protected $_format = "json";

	/**
	 *
	 * @var WuWeatherCache
	 */
	protected $_cache = null;

	/**
	 * @var string
	 */
	private $_response = null;


	/**
	 * @var bool
	 */
	private $_responseFromCache = false;

	/**
	 * WuWeatherStandardRequest constructor.
	 *
	 * @param string $api_key
	 */
	public function __construct($component, $url)
	{
		$this->_component = $component;
		$this->_url       = $url;
	}

	protected function _getRequestUrlWithParameter()
	{
		$call_url = str_replace("{API_KEY}", $this->_component->apiKey, $this->_url);

		$call_url = str_replace("{FORMAT}", $this->_format, $call_url);

		return $call_url;
	}


	public function setFormatJSON()
	{
		$this->_format = "json";
	}

	public function setFormatXML()
	{
		$this->_format = "xml";
	}

	/**
	 * @return string
	 */
	public function getFormat()
	{
		return $this->_format;
	}

	/**
	 * @return string
	 */
	public function getResponse($use_cache = true)
	{
		if( !$this->wasSent() )
		{
			$this->request($use_cache);
		}
		
		return $this->_response;
	}

	protected function addEvent($event, $callable)
	{
		array_push($this->_events[ $event ], $callable);
	}


	protected function _validParameters()
	{
		if( empty($this->_component->apiKey) )
		{
			throw new RuntimeException('apiKey must not be empty');
		}
	}

	protected function _getRequestUrl($parameters = true)
	{
		return $parameters ? $this->_getRequestUrlWithParameter() : $this->_url;
	}

	/**
	 * @param bool $use_cache
	 *
	 * @return $this
	 */
	public function request($use_cache = true)
	{
		if( !$this->wasSent() || !$use_cache )
		{
			if( $use_cache && $this->cacheIsEnabled() )
			{
				$this->_response = $this->_cache->load($this);
			}

			$this->_responseFromCache = !empty($this->_response);

			if( !$this->_responseFromCache )
			{
				$this->_response = $this->_performRequest();

				$this->_cache->save($this, $this->_response);
			}
		}
		
		return $this;
	}

	public function wasSent()
	{
		return !is_null($this->_response);
	}

	abstract public function enableCache();

	public function cacheIsEnabled()
	{
		return !is_null($this->_cache);
	}

	public function getCache()
	{
		if( is_null($this->_cache) )
		{
			throw new RuntimeException('cache was not enabled - use enableCache() before');
		}

		return $this->_cache;
	}

	/**
	 * @param bool $cache
	 *
	 * @return string
	 */
	protected function _performRequest()
	{
		return file_get_contents($this->_getRequestUrl());
	}

}

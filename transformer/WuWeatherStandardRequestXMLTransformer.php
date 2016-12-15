<?php

class WuWeatherStandardRequestXMLTransformer
{
	/**
	 * @var $this
	 */
	protected static $_Instance = null;

	/**
	 * @return $this
	 */
	protected static function _GetInstance()
	{
		if( is_null(self::$_Instance) )
		{
			self::$_Instance = new self();
		}

		return self::$_Instance;
	}

	/**
	 * Disable copying
	 */
	protected function __clone() { }

	/**
	 * @return $this
	 */
	public static function Create()
	{
		return self::_GetInstance();
	}

	/**
	 * @param string $response
	 *
	 * @return WuWeatherStandardResponseModel
	 */
	public function transform($response)
	{
		throw new RuntimeException("rendering of SimpleXMLElement response not implemented yet");
		
		//return new WuWeatherStandardResponseModel(simplexml_load_string($response));
	}

}
